<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créez une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

try {
    // Requête pour sélectionner tous les utilisateurs
    $query = "SELECT id, nom, prenom FROM userss";
    $result = $conn->query($query);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérer les résultats dans un tableau associatif
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        $users = [];
    }

    // Libérer le résultat
    $result->free();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

$error_message = ""; // Initialisez la variable pour stocker les messages d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compte = $_POST['compte'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Vérification de l'existence du numéro de téléphone
    $stmt = $conn->prepare("SELECT * FROM userss WHERE telephone = ?");
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("s", $telephone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Ce numéro de téléphone est déjà utilisé.";
    } else {
        // Construire la requête SQL en fonction du type de compte
        $sql = "INSERT INTO userss (compte, nom, prenom, pays, email, telephone, password, type, statut";
        $values = "VALUES (?, ?, ?, ?, ?, ?, ?, '1'";

        if ($compte === "Agence" || $compte === "Prestaire" || $compte === "Televendeur" || $compte === "Colaborateur" || $compte === "Agent" || $compte === "Agence de Marketing") {
            $sql .= ", service_propose, zone_couverture, strategie_marketing";
            $values .= ", ?, ?, ?";
        } elseif ($compte === "Employé") {
            $sql .= ", poste, responsable";
            $values .= ", ?, ?";
        } elseif ($compte === "Candidat") {
            $sql .= ", cv, lettre_motivation, accompagne, accompagnant_id";
            $values .= ", ?, ?, ?, ?";
        }

        $sql .= ") ";
        $values .= ")";

        $stmt = $conn->prepare($sql . $values);
        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        // Binding des paramètres en fonction du type de compte
        switch ($compte) {
            case "Client":
                $stmt->bind_param('sssssss', $compte, $nom, $prenom, $pays, $email, $telephone, $password);
                break;
            case "Agence":
            case "Prestaire":
            case "Televendeur":
            case "Colaborateur":
            case "Agent":
            case "Agence de Marketing":
                $service_propose = $_POST['service_propose'] ?? null;
                $zone_couverture = $_POST['zone_couverture'] ?? null;
                $strategie_marketing = $_POST['strategie_marketing'] ?? null;
                $stmt->bind_param('ssssssssss', $compte, $nom, $prenom, $pays, $email, $telephone, $password, $service_propose, $zone_couverture, $strategie_marketing);
                break;
            case "Employé":
                $poste = $_POST['poste'] ?? null;
                $responsable = $_POST['responsable'] ?? null;
                $stmt->bind_param('sssssssss', $compte, $nom, $prenom, $pays, $email, $telephone, $password, $poste, $responsable);
                break;
            case "Candidat":
                $cv = $_FILES['cv']['name'] ?? null;
                $lettre_motivation = $_FILES['lettre_motivation']['name'] ?? null;
                $accompagne = $_POST['accompagne'] ?? null;
                $accompagnant_id = $_POST['accompagnateur'] ?? null;
                $stmt->bind_param('sssssssssss', $compte, $nom, $prenom, $pays, $email, $telephone, $password, $cv, $lettre_motivation, $accompagne, $accompagnant_id);

                // Gérer le téléchargement des fichiers
                if ($cv) {
                    move_uploaded_file($_FILES['cv']['tmp_name'], "uploads/" . $cv);
                }
                if ($lettre_motivation) {
                    move_uploaded_file($_FILES['lettre_motivation']['tmp_name'], "uploads/" . $lettre_motivation);
                }
                break;
            default:
                $stmt->bind_param('sssssss', $compte, $nom, $prenom, $pays, $email, $telephone, $password);
                break;
        }

        if ($stmt->execute()) {
            header("Location: acceuil.php");
            exit();
        } else {
            $error_message = "Erreur lors de l'enregistrement: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .hidden {
            display: none;
        }
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            background-image: url(font4.jpg);
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .profile-pic {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .profile-pic img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #007bff;
            background-color: #f0f0f0; /* Ensuring the circle shape */
        }
        .profile-pic label {
            width: 120px;
            height: 120px;
            display: inline-block;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 3px solid #007bff;
            background-color: #f0f0f0; /* Ensuring the circle shape */
            cursor: pointer;
        }
        .profile-pic input {
            display: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }
        .form-control {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }
        .password-field {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .main_bt {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
        }
        .main_bt:hover {
            background: #0056b3;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = field.nextElementSibling.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas");
                return false;
            }

            return true;
        }

        function showFields() {
            var accountType = document.getElementsByName("compte")[0].value;
            var clientFields = document.getElementById("clientFields");
            var entrepriseFields = document.getElementById("entrepriseFields");
            var employeFields = document.getElementById("employeFields");
            var candidatFields = document.getElementById("candidatFields");
            var prestaireFields = document.getElementById("prestaireFields");
            var televendeurFields = document.getElementById("televendeurFields");
            var agenceFields = document.getElementById("agenceFields");
            var agentFields = document.getElementById("agentFields");
            var colaborateurFields = document.getElementById("colaborateurFields");
            var marketingFields = document.getElementById("marketingFields");

            clientFields.classList.add("hidden");
            entrepriseFields.classList.add("hidden");
            employeFields.classList.add("hidden");
            candidatFields.classList.add("hidden");
            prestaireFields.classList.add("hidden");
            televendeurFields.classList.add("hidden");
            agenceFields.classList.add("hidden");
            agentFields.classList.add("hidden");
            colaborateurFields.classList.add("hidden");
            marketingFields.classList.add("hidden");

            switch (accountType) {
                case "Client":
                    clientFields.classList.remove("hidden");
                    break;
                case "Agence":
                    entrepriseFields.classList.remove("hidden");
                    agenceFields.classList.remove("hidden");
                    break;
                case "Employé":
                    employeFields.classList.remove("hidden");
                    break;
                case "Candidat":
                    candidatFields.classList.remove("hidden");
                    break;
                case "Prestaire":
                    entrepriseFields.classList.remove("hidden");
                    prestaireFields.classList.remove("hidden");
                    break;
                case "Televendeur":
                    entrepriseFields.classList.remove("hidden");
                    televendeurFields.classList.remove("hidden");
                    break;
                case "Colaborateur":
                    entrepriseFields.classList.remove("hidden");
                    colaborateurFields.classList.remove("hidden");
                    break;
                case "Agent":
                    entrepriseFields.classList.remove("hidden");
                    agentFields.classList.remove("hidden");
                    break;
                case "Agence de Marketing":
                    entrepriseFields.classList.remove("hidden");
                    marketingFields.classList.remove("hidden");
                    break;
                default:
                    break;
            }
        }
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body onload="showFields()">
    <div class="container">
        <h2>Formulaire d'inscription</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="compte">Type de compte:</label>
                <select name="compte" class="form-control" onchange="showFields()">
                    <option value="">Sélectionnez un type de compte</option>
                    <option value="Client">Client</option>
                    <option value="Agence">Agence</option>
                    <option value="Employé">Employé</option>
                    <option value="Candidat">Candidat</option>
                    <option value="Prestaire">Prestaire</option>
                    <option value="Televendeur">Televendeur</option>
                    <option value="Colaborateur">Colaborateur</option>
                    <option value="Agent">Agent</option>
                    <option value="Agence de Marketing">Agence de Marketing</option>
                </select>
            </div>

            <div id="commonFields">
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="pays">Pays:</label>
                    <input type="text" class="form-control" id="pays" name="pays" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone:</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="input-group-text" onclick="togglePassword('password')"><i class="fa fa-eye"></i></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer mot de passe:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <span class="input-group-text" onclick="togglePassword('confirm_password')"><i class="fa fa-eye"></i></span>
                </div>
            </div>

            <div id="clientFields" class="hidden">
                <!-- Ajouter les champs spécifiques au client ici -->
            </div>

            <div id="entrepriseFields" class="hidden">
                <div class="form-group">
                    <label for="service_propose">Service proposé:</label>
                    <input type="text" class="form-control" id="service_propose" name="service_propose">
                </div>
                <div class="form-group">
                    <label for="zone_couverture">Zone de couverture:</label>
                    <input type="text" class="form-control" id="zone_couverture" name="zone_couverture">
                </div>
                <div class="form-group">
                    <label for="strategie_marketing">Stratégie marketing:</label>
                    <input type="text" class="form-control" id="strategie_marketing" name="strategie_marketing">
                </div>
            </div>

            <div id="employeFields" class="hidden">
                <div class="form-group">
                    <label for="poste">Poste:</label>
                    <input type="text" class="form-control" id="poste" name="poste">
                </div>
                <div class="form-group">
                    <label for="responsable">Responsable:</label>
                    <input type="text" class="form-control" id="responsable" name="responsable">
                </div>
            </div>

            <div id="candidatFields" class="hidden">
                <div class="form-group">
                    <label for="cv">CV:</label>
                    <input type="file" class="form-control" id="cv" name="cv">
                </div>
                <div class="form-group">
                    <label for="lettre_motivation">Lettre de motivation:</label>
                    <input type="file" class="form-control" id="lettre_motivation" name="lettre_motivation">
                </div>
                <div class="form-group">
                    <label for="accompagne">Accompagné:</label>
                    <select class="form-control" id="accompagne" name="accompagne">
                        <option value="non">Non</option>
                        <option value="oui">Oui</option>
                    </select>
                </div>
                <div id="accompagnantFields" class="hidden">
                    <label for="accompagnateur">Sélectionnez l'accompagnateur :</label>
                    <select class="form-control" id="accompagnateur" name="accompagnateur">
                        <option value="">Sélectionnez un accompagnateur</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= $user['nom'] . ' ' . $user['prenom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="prestaireFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux prestaired ici -->
            </div>

            <div id="televendeurFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux televendeur ici -->
            </div>

            <div id="agenceFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux agence ici -->
            </div>

            <div id="agentFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux agent ici -->
            </div>

            <div id="colaborateurFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux colaborateur ici -->
            </div>

            <div id="marketingFields" class="hidden">
                <!-- Ajouter les champs spécifiques aux marketing ici -->
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

    <script>
        // Afficher ou masquer les champs en fonction du type de compte sélectionné
        document.getElementsByName("compte")[0].addEventListener("change", function() {
            showFields();
        });

        // Afficher ou masquer les champs de l'accompagnateur en fonction du choix "accompagné"
        document.getElementById("accompagne").addEventListener("change", function() {
            var accompagnantFields = document.getElementById("accompagnantFields");
            if (this.value === "oui") {
                accompagnantFields.classList.remove("hidden");
            } else {
                accompagnantFields.classList.add("hidden");
            }
        });
    </script>
</body>
</html>
