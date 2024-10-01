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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compte = $_POST['compte'];
    $nom = $_POST['nom'];
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
    $pays = $_POST['pays'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // On ne vérifie plus le mot de passe
    $nom_entreprise = isset($_POST['nom_entreprise']) ? $_POST['nom_entreprise'] : null;
    $raison_sociale = isset($_POST['raison_sociale']) ? $_POST['raison_sociale'] : null;
    $poste = isset($_POST['poste']) ? $_POST['poste'] : null;
    $responsable = isset($_POST['responsable']) ? $_POST['responsable'] : null;
    $cv = isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : null;
    $lettre_motivation = isset($_FILES['lettre_motivation']['name']) ? $_FILES['lettre_motivation']['name'] : null;
    $service_propose = isset($_POST['service_propose']) ? $_POST['service_propose'] : null;
    $zone_couverture = isset($_POST['zone_couverture']) ? $_POST['zone_couverture'] : null;
    $strategie_marketing = isset($_POST['strategie_marketing']) ? $_POST['strategie_marketing'] : null;

    // Gérer le téléchargement des fichiers
    if ($cv) {
        $target_dir = "uploads/dossierss/";
        $target_file_cv = $target_dir . basename($_FILES["cv"]["name"]);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file_cv);
    }

    if ($lettre_motivation) {
        $target_file_lettre = $target_dir . basename($_FILES["lettre_motivation"]["name"]);
        move_uploaded_file($_FILES["lettre_motivation"]["tmp_name"], $target_file_lettre);
    }

    // Vérifier si le numéro de téléphone existe déjà
    $stmt = $conn->prepare("SELECT * FROM userss WHERE telephone = ?");
    $stmt->bind_param("s", $telephone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le numéro de téléphone existe déjà
        $error_message = "Ce Compte existe déjà.";
    } else {
        // Préparer la requête SQL pour insérer les données
         $sql = "INSERT INTO userss (compte, nom, prenom, pays, email, telephone, password, nom_entreprise, raison_sociale, poste, responsable, cv, lettre_motivation, service_propose, zone_couverture, strategie_marketing, type, statut)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'sssssssssssssssss', 
            $compte, $nom, $prenom, $pays, $email, $telephone, $password, 
            $nom_entreprise, $raison_sociale, $poste, $responsable, $cv, 
            $lettre_motivation, $service_propose, $zone_couverture, $strategie_marketing, $compte
        );

        if ($stmt->execute()) {
            // Rediriger vers la page d'accueil
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

<?php if (!empty($error_message)): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
<?php endif; ?>

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

        function previewProfilePic(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile_pic');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
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
            var commonFields = document.getElementById("commonFields");
            var employeFields = document.getElementById("employeFields");
            var candidatFields = document.getElementById("candidatFields");
            var prestaireFields = document.getElementById("prestaireFields");
            var agenceFields = document.getElementById("agenceFields");
            var agentFields = document.getElementById("agentFields");
            var televendeurFields = document.getElementById("televendeurFields");
            var colaborateurFields = document.getElementById("colaborateurFields");
            var marketingFields = document.getElementById("marketingFields");

            // Hide all fields initially
            clientFields.classList.add("hidden");
            entrepriseFields.classList.add("hidden");
            commonFields.classList.remove("hidden");
            employeFields.classList.add("hidden");
            candidatFields.classList.add("hidden");
            prestaireFields.classList.add("hidden");
            televendeurFields.classList.add("hidden");
            agenceFields.classList.add("hidden");
            agentFields.classList.add("hidden");
            colaborateurFields.classList.add("hidden");
            marketingFields.classList.add("hidden");

            if (accountType === "Client") {
                clientFields.classList.remove("hidden");
            } else if (accountType === "Agence") {
                entrepriseFields.classList.remove("hidden");
                commonFields.classList.add("hidden"); // Hide common fields
            } else if (accountType === "Employé") {
                employeFields.classList.remove("hidden");
            } else if (accountType === "Candidat") {
                candidatFields.classList.remove("hidden");
            } else if (accountType === "Prestaire") {
                entrepriseFields.classList.remove("hidden");
                prestaireFields.classList.remove("hidden");
            } else if (accountType === "Televendeur") {
                televendeurFields.classList.remove("hidden");
            } else if (accountType === "Colaborateur") {
                colaborateurFields.classList.remove("hidden");
            } else if (accountType === "Agence") {
                agenceFields.classList.remove("hidden");
            } else if (accountType === "Agent") {
                agentFields.classList.remove("hidden");
            } else if (accountType === "Agence de Marketing") {
                marketingFields.classList.remove("hidden");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            showFields();
        });
    </script>
</head>
<body>
<div class="container">
  
            <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="profile-pic">
            <label for="profile_pic_input">
                <input type="file" id="profile_pic_input" name="profile_pic" accept="image/*" onchange="previewProfilePic(event)" required>
                <img id="profile_pic" src="images/logo/logo_icon.png" alt="Photo de profil" required>
            </label>
        </div>
        <div class="acceuil_form">
          <h2 style="margin-left: 20%;">Formulaire d'inscription</h2>
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label class="form-label">Type de compte</label>
            <select name="compte" class="form-control" onchange="showFields()">
                <option value="Client">Client</option>
                <option value="Employé">Employé</option>
                <option value="Candidat">Candidat</option>
                <option value="Prestataire">Entreprise / Employeur</option>
                <option value="Televendeur">Télévendeur</option>
                <option value="Colaborateur">Collaborateur</option>
                <option value="Agence">Agence</option>
                <option value="Agent">Agent</option>
                <option value="Agence de Marketing">Agence de Marketing</option>
            </select>
        </div>

        <!-- Client specific fields -->
        <div id="clientFields" class="hidden">
            <!-- Add client specific fields here if any -->
        </div>

        <!-- Common fields for Employee, Prestaire -->
        <div id="commonFields">
            <div class="form-group">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">NIU</label>
                <input type="text" name="prenom" class="form-control">
            </div>
        </div>

        <!-- Agence specific fields -->
        <div id="entrepriseFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Nom de l'entreprise</label>
                <input type="text" name="nom_entreprise" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Raison sociale</label>
                <input type="text" name="raison_sociale" class="form-control">
            </div>
        </div>


                <div id="agentFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Nom de l'engence</label>
                <input type="text" name="nom" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Raison sociale</label>
                <input type="text" name="prenom" class="form-control">
            </div>
        </div>

        <!-- Employé specific fields -->
        <div id="employeFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Poste</label>
                <input type="text" name="poste" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Responsable</label>
                <input type="text" name="responsable" class="form-control">
            </div>
        </div>

        <!-- Candidat specific fields -->
        <div id="candidatFields" class="hidden">
            <div class="form-group">
                <label class="form-label">CV</label>
                <input type="file" name="cv" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Lettre de motivation</label>
                <input type="file" name="lettre_motivation" class="form-control">
            </div>
        </div>

        <!-- Prestaire specific fields -->
        <div id="prestaireFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Service proposé</label>
                <input type="text" name="service_propose" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Zone de couverture</label>
                <input type="text" name="zone_couverture" class="form-control">
            </div>
        </div>


          <div id="colaborateurFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Service proposé</label>
                <input type="text" name="service_propose" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Zone de couverture</label>
                <input type="text" name="zone_couverture" class="form-control">
            </div>
        </div>


                  <div id="agenceFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Service proposé</label>
                <input type="text" name="service_propose" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Zone de couverture</label>
                <input type="text" name="zone_couverture" class="form-control">
            </div>
        </div>

        <!-- Televendeur specific fields -->
        <div id="televendeurFields" class="hidden">
            <!-- Add televendeur specific fields here if any -->
        </div>

        <!-- Agence de Marketing specific fields -->
        <div id="marketingFields" class="hidden">
            <div class="form-group">
                <label class="form-label">Stratégie Marketing</label>
                <textarea name="strategie_marketing" class="form-control"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Pays</label>
            <input type="text" name="pays" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Téléphone</label>
            <input type="tel" name="telephone" class="form-control" required>
        </div>
        <div class="form-group password-field">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <span class="toggle-password" onclick="togglePassword('password')">
                <i class="fa fa-eye"></i>
            </span>
        </div>
        <div class="form-group password-field">
            <label class="form-label">Confirmez le mot de passe</label>
            <input type="password" id="confirm_password" class="form-control" required>
            <span class="toggle-password" onclick="togglePassword('confirm_password')">
                <i class="fa fa-eye"></i>
            </span>
        </div>
        <button type="submit" class="main_bt">S'inscrire</button>
        <a href="acceuil.php">Connexion</a>
    </form>
</div>
</body>
</html>

