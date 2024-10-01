<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparer la requête SQL pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $type = $row['type']; // Assurez-vous que 'type' est le nom correct du champ dans votre base de données
    $statut = $row['statut'];

} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas trouvé dans la base de données
    header("Location: login.php");
    exit();
}
?>

<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données MySQL
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $database = "4w0vau_dreamize";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $database);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Préparer les données avant insertion
    $full_name = $_POST['full_name'] ?? '';
    $preno = $_POST['preno'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $country = $_POST['country'] ?? '';
    $city = $_POST['city'] ?? '';
    $marital_status = $_POST['marital_status'] ?? '';
    $immigration_type = '1';
    $employeur = '1';
    $education = '1';
    $experience = $_POST['experience'] ?? '';
    $photo = uploadFile('photo', 'uploads/');

    // Étape 1: Insertion des données de la session 1 dans la base de données
    $sql1 = "INSERT INTO formulaire_immigration_session11 (full_name, preno, dob, email, phone, country, city, marital_status, immigration_type, employeur, education, experience, photo, user_id, datet)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("sssssssssssssi", $full_name, $preno, $dob, $email, $phone, $country, $city, $marital_status, $immigration_type, $employeur, $education, $experience, $photo, $userId);
    if ($stmt1->execute()) {
        echo "Données de la session 1 insérées avec succès.<br>";
    } else {
        echo "Erreur lors de l'insertion des données de la session 1 : " . $stmt1->error . "<br>";
    }
    $stmt1->close();

    // Étape 2: Insertion des données de la session 2 dans la base de données
    $service_agreement = isset($_POST['service_agreement']) ? 1 : 0;
    $payment = $_POST['payment'] ?? '';
    $documents = uploadMultipleFiles('documents', 'uploads/');

    $sql2 = "INSERT INTO formulaire_immigration_session22 (service_agreement, payment, documents, user_id, datet)
            VALUES (?, ?, ?, ?, now())";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("issi", $service_agreement, $payment, $documents, $userId);
    if ($stmt2->execute()) {
        echo "Données de la session 2 insérées avec succès.<br>";
    } else {
        echo "Erreur lors de l'insertion des données de la session 2 : " . $stmt2->error . "<br>";
    }
    $stmt2->close();

    // Étape 3: Insertion des données de la session 3 dans la base de données
    $client_approval = isset($_POST['client_approval']) ? 1 : 0;
    $final_payment = $_POST['final_payment'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    $sql3 = "INSERT INTO formulaire_immigration_session33 (client_approval, final_payment, payment_method, user_id, datet)
            VALUES (?, ?, ?, ?, now())";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("issi", $client_approval, $final_payment, $payment_method, $userId);
    if ($stmt3->execute()) {
        echo "";
    } else {
        echo "Erreur lors de l'insertion des données de la session 3 : " . $stmt3->error . "<br>";
    }
    $stmt3->close();

    // Fermeture de la connexion
    $conn->close();
}

// Fonction pour traiter l'upload d'un fichier unique
function uploadFile($fileInputName, $targetDir) {
    $targetFilePath = $targetDir . basename($_FILES[$fileInputName]["name"]);
    if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
        return basename($_FILES[$fileInputName]["name"]);
    } else {
        return "";
    }
}

// Fonction pour traiter l'upload de plusieurs fichiers
function uploadMultipleFiles($fileInputName, $targetDir) {
    $uploadedFiles = array();
    $total = count($_FILES[$fileInputName]['name']);
    for ($i = 0; $i < $total; $i++) {
        $targetFilePath = $targetDir . basename($_FILES[$fileInputName]['name'][$i]);
        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'][$i], $targetFilePath)) {
            $uploadedFiles[] = basename($_FILES[$fileInputName]['name'][$i]);
        }
    }
    return implode(', ', $uploadedFiles);
}
?>

<?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérez l'ID de l'utilisateur
$userId = $_SESSION['id'];





ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération du dernier ID inséré dans la table competence1
$sql = "SELECT MAX(id) AS last_id FROM competence1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];
} else {
    $last_id = 0;
}

// Génération automatique du code utilisateur en incrémentant le dernier ID
$codeutilisateur = $last_id + 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si le tableau $_POST['Nom'] est défini et s'il contient des éléments
    if (isset($_POST['Nom']) && is_array($_POST['Nom']) && count($_POST['Nom']) > 0) {
        // Préparation de la requête SQL d'insertion pour la table competence1
        $stmt1 = $conn->prepare("INSERT INTO competence11 (codeutilisateur, Nom, prenom, pays, ville) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt1) {
            die("Erreur de préparation de la requête pour la table competence1: " . $conn->error);
        }

        // Préparation de la requête SQL d'insertion pour la table competence2
        $stmt2 = $conn->prepare("INSERT INTO competence22 (codeutilisateur, nomm, prenomm, payss, villee, skillTitle, description, tools, `references`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt2) {
            die("Erreur de préparation de la requête pour la table competence2: " . $conn->error);
        }

        // Récupération des données du formulaire
        $noms = $_POST['Nom'];
        $prenoms = $_POST['prenom'];
        $pays = $_POST['pays'];
        $villes = $_POST['ville'];
            $nomm = $_POST['nomm'];
        $prenomm = $_POST['prenomm'];
        $payss = $_POST['payss'];
        $villee = $_POST['villee'];
        $skillTitles = $_POST['skillTitle'];
        $descriptions = $_POST['description'];
        $tools = $_POST['tools'];
        $references = $_POST['references'];

        // Insertion des données dans les tables competence1 et competence2
        foreach ($skillTitles as $key => $skillTitle) {
            // Insertion dans la table competence1
            $stmt1->bind_param("sssss", $codeutilisateur, $noms[$key], $prenoms[$key], $pays[$key], $villes[$key]);
            $result1 = $stmt1->execute();

            if (!$result1) {
                die("Erreur lors de l'insertion dans la table competence1: " . $stmt1->error);
            }

            // Insertion dans la table competence2
            $stmt2->bind_param("sssssssss", $codeutilisateur, $skillTitle,$nomm[$key], $prenomm[$key], $payss[$key], $villee[$key], $descriptions[$key], $tools[$key], $references[$key]);
            $result2 = $stmt2->execute();

            if (!$result2) {
                die("Erreur lors de l'insertion dans la table competence2: " . $stmt2->error);
            }
        }

        echo "Compétences enregistrées avec succès!";
    } else {
        echo "Aucune compétence n'a été ajoutée.";
    }

    // Fermeture des requêtes
    $stmt1->close();
    $stmt2->close();
}

// Fermeture de la connexion
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Formulaire d'Ajout d'une entrperise</title>


    <style type="text/css">


body {
    font-family: 'Helvetica', sans-serif;
}

.container {
    max-width: 600px;
}

form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}



.container {
    width: 50%;
    margin: 50px auto;
}

form {
    display: grid;
    gap: 10px;
}

label {
    font-weight: bold;
}

textarea {
    resize: vertical;
}




    </style>





<style type="text/css">
        /* Styles pour le conteneur principal */
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Styles pour le titre */
h2 {
    text-align: center;
    margin-bottom: 30px;
}

/* Styles pour les étiquettes */
label {
    font-weight: bold;
}

/* Styles pour les boutons */
.btn-primary,
.btn-success,
.btn-danger {
    margin-top: 20px;
    margin-right: 10px;
}

/* Styles pour les formulaires de compétences */
.skill {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    background-color: #fff;
}

/* Styles pour les boutons de suppression */
.removeSkill {
    margin-top: 20px;
}

/* Styles pour les notifications */
#response {
    margin-top: 20px;
    text-align: center;
}

/* Ajoutez ici d'autres styles personnalisés selon vos besoins */


    </style>
        <style>
    
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        input[type="submit"], .next-btn, .prev-btn {
            padding: 10px;
            background-color: rgb(0,0,98);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .next-btn:hover, .prev-btn:hover, input[type="submit"]:hover {
            background-color: rgb(0,0,98);
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
    </style>
        <style>
        /* Styles pour le message d'avertissement */
        .warning-message {
            background-color: #ffe4e1; /* Couleur de fond */
            color: #8b0000; /* Couleur du texte */
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ff69b4; /* Bordure rose */
        }

        .warning-message h3 {
            color: #ff1493; /* Couleur du titre */
            margin-top: 0;
        }

        .warning-message p {
            margin-bottom: 10px;
        }

        .warning-message ul {
            margin-bottom: 10px;
            padding-left: 20px;
        }

        .warning-message li {
            margin-bottom: 5px;
        }
    </style>
    <style>
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        input[type="submit"], .next-btn, .prev-btn {
            padding: 10px;
            background-color: rgb(0,0,98);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .next-btn:hover, .prev-btn:hover, input[type="submit"]:hover {
            background-color: rgb(0,0,98);
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Formulaire d'Ajout d'une Entreprise</h2>
        <div class="section active" id="section0">
        <div class="warning-message">
            <h3>Important: Avant de remplir ce formulaire, veuillez lire attentivement les informations suivantes :</h3>
            <p>Cher(e) utilisateur/trice,</p>
            <p>Nous vous remercions de votre intérêt pour notre service d'immigration. Avant de commencer à remplir ce formulaire, veuillez prendre en compte les éléments suivants :</p>
            <ul>
                <li>Veuillez vous assurer d'avoir tous les documents nécessaires prêts à être téléchargés, y compris votre CV, votre carte d'identité nationale ou passeport, vos diplômes, attestations, relevés de notes, etc.</li>
                <li>Assurez-vous de bien comprendre toutes les modalités, conditions et étapes relatives au processus d'immigration que vous souhaitez entreprendre.</li>
                <li>Les frais de traitement de votre demande sont non remboursables, quel que soit le résultat de votre demande d'immigration.</li>
                <li>En soumettant ce formulaire, vous confirmez que toutes les informations fournies sont exactes, complètes et véridiques.</li>
                <li>Les informations que vous fournissez seront traitées de manière confidentielle et utilisées uniquement dans le cadre de votre demande d'immigration.</li>
                <li>Notre équipe est là pour vous aider à chaque étape du processus. N'hésitez pas à nous contacter si vous avez des questions ou besoin d'assistance.</li>
                <li>Veuillez noter que le traitement de votre demande peut prendre du temps. Nous vous tiendrons informé(e) de l'avancement de votre dossier dès que possible.</li>
                <li>En cas de besoin d'assistance technique lors du remplissage du formulaire, veuillez nous contacter à l'adresse email support@votreentreprise.com.</li>
            </ul>
            <p>Merci de votre compréhension et de votre coopération. Nous vous souhaitons bonne chance dans votre processus d'immigration.</p>
        </div>
         <!-- Affichage du message -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <div class="message">
                <?php
                if (!empty($message)) {
                    echo $message;
                }
                ?>
            </div>
        <?php endif; ?>

            <div class="button-group">
                <button type="button" class="next-btn" onclick="showSection(1)">Suivant</button>
            </div>
        </div>

        <form id="immigrationForm" action="" method="post" enctype="multipart/form-data">
            <div class="section" id="section1">
                <!-- Section 1 - Vos champs de formulaire -->
                                <h3>Identification d'Entreprise,</h3>
                <div class="form-group">
                    <label for="full_name">Raison sociale <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="full_name" name="full_name" placeholder="vision info sarl" >
                </div>
                  <div class="form-group">
                    <label for="preno">Responsable <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="preno" name="preno" placeholder="Paul François" >
                </div>
                <div class="form-group">
                    <label for="dob">Date de création <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="date" id="dob" name="dob" >
                </div>
                <div class="form-group">
                    <label for="email">Email <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="email" id="email" name="email" placeholder="paulfrançois@gmail.com" >
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="tel" id="phone" name="phone" placeholder="+237 697867352" >
                </div>
                <div class="form-group">
                    <label for="country">Pays <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="country" name="country" placeholder="Cameroun" >
                </div>
                <div class="form-group">
                    <label for="city">Ville :</label>
                    <input type="text" id="city" placeholder="Yaoundé" name="city" >
                </div>
                <div class="form-group">
                    <label for="marital_status">Type d'entreprise :</label>
                   <select id="marital_status" name="marital_status" >
                        <option value="Etablissement">Etablissement</option>
                        <option value="S.A">S.A</option>
                        <option value="Multi_national">Multi-national</option>
                        <option value="ONG">ONG</option>
                    </select>
                 </div>

                <div class="form-group">
                    <label for="experience">Message :</label>
                    <textarea id="experience" name="experience" ></textarea>
                </div>
                <div class="form-group">
                    <label for="photo">Téléchargez votre logo <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="file" id="photo" name="photo" accept="image/*" >
                </div>
                <!-- ... -->
                <div class="button-group">
                    <button type="button" class="prev-btn" onclick="showSection(0)">Précédent</button>
                    <button type="button" class="next-btn" onclick="showSection(2)">Suivant</button>
                </div>
            </div>

            <div class="section" id="section2">
                <!-- Section 2 - Vos champs de formulaire -->
                                <h3>Domaine d'activité</h3>
                <!-- Champs de formulaire pour la session 2 -->
<div class="form-group">
        <label for="payment">Domaine d'activité <em style="color: red; font-size: 9px;"></em>:</label>
        <input type="text" id="payment" name="payment" placeholder="Informatique" >
    </div>
    <div class="form-group">
        <label for="documents">Télécharger les documents nécessaires <em style="color: red; font-size: 9px;"></em>: <br>
            <p style="color: blue; font-size: 11px; ">Vous pouvez télécharger vos documents nécessaires (CV du personel, CNI/Passeport, Diplômes, Régistre du commerce,...</p>
            <em style="color: red; font-size: 10px; ">Attention, vous devez les selectionner de votre repertoire une seule fois, peut importe le nombre de documents</em>
        </label>
        <input type="file" id="documents" name="documents[]" multiple >
    </div>
    <div class="form-group" id="selected-documents">
        <label>Documents sélectionnés :</label>
        <table>
            <thead>
                <tr>
                    <th>Date d'obtention</th>
                    <th>Intitulé</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les documents sélectionnés seront affichés ici -->
            </tbody>
        </table>
    </div>
                <!-- ... -->
                <div class="button-group">
                    <button type="button" class="prev-btn" onclick="showSection(1)">Précédent</button>
                    <button type="button" class="next-btn" onclick="showSection(3)">Suivant</button>
                </div>
            </div>

            <div class="section" id="section3">
                <!-- Section 3 - Vos champs de formulaire -->
                <div class="containererrfgh">
    <h2>Déposer les compétences de votre personnel</h2>
    <!-- Formulaire pour déposer les compétences -->
    <form id="skillsForm" method="post">
        <div id="skillsContainer">
            <div class="form-group">
                <label for="Nom">Régistre de commerce  :</label>
                <input type="text" class="form-control" name="Nom[]" required>
            </div>
            <div class="form-group">
                <label for="prenom">NUI :</label>
                <input type="text" class="form-control" name="prenom[]" required>
            </div>
            <div class="form-group">
                <label for="pays">Capital Social :</label>
                <input type="text" class="form-control" name="pays[]" placeholder="Séparez les outils par des virgules">
            </div>
            <div class="form-group">
                <label for="ville">Nombre d'employés à voyager :</label>
                <input type="number" class="form-control" name="ville[]" placeholder="Séparez les outils par des virgules">
            </div>
            <!-- Formulaire de compétence par défaut -->
            <div class="skill">
                <div class="form-group">
                    <label for="nomm">Nom Personnel :</label>
                    <input type="text" class="form-control" name="nomm[]" required>
                </div>
                <div class="form-group">
                    <label for="prenomm">Prénom Personnel :</label>
                    <input type="text" class="form-control" name="prenomm[]" required>
                </div>
                <div class="form-group">
                    <label for="payss">pays :</label>
                    <input type="text" class="form-control" name="payss[]" required>
                </div>
                <div class="form-group">
                    <label for="ville">Ville :</label>
                    <input type="text" class="form-control" name="villee[]" required>
                </div>
                <div class="form-group">
                    <label for="skillTitle">Intitulé de la compétence :</label>
                    <input type="text" class="form-control" name="skillTitle[]" required>
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tools">Outils / Technologies :</label>
                    <input type="text" class="form-control" name="tools[]" placeholder="Séparez les outils par des virgules">
                </div>
                <div class="form-group">
                    <label for="references">Références :</label>
                    <textarea class="form-control" name="references[]" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-danger removeSkill">Supprimer</button>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="addSkill">Ajouter une compétence</button>
        
    </form>
    <!-- Div pour afficher les notifications -->
    <div id="response"></div>
</div>
                <!-- ... -->
                <div class="button-group">
                    <button type="button" class="prev-btn" onclick="showSection(2)">Précédent</button>
                    <input type="submit" value="Terminer">
                </div>
            </div>
        </form>
    </div>

    <script>
        // Fonction pour afficher les sections du formulaire
        function showSection(sectionNumber) {
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById('section' + sectionNumber).classList.add('active');
        }
    </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    // Fonction pour ajouter un formulaire de compétence
    $("#addSkill").click(function() {
        var newSkill = $(".skill:first").clone(); // Clone le premier formulaire de compétence
        newSkill.find("input, textarea").val(""); // Efface les valeurs des champs
        newSkill.find(".removeSkill").show(); // Affiche le bouton de suppression
        $("#skillsContainer").append(newSkill); // Ajoute le nouveau formulaire à la fin du conteneur
    });

    // Fonction pour supprimer un formulaire de compétence
    $(document).on("click", ".removeSkill", function() {
        $(this).closest(".skill").remove(); // Supprime le formulaire de compétence parent
    });
</script>

    <script>
    // Function to update selected documents table
    function updateSelectedDocuments() {
        var documentsTable = document.querySelector('#selected-documents tbody');
        documentsTable.innerHTML = ''; // Clear existing table rows

        var files = document.getElementById('documents').files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var row = '<tr>' +
                '<td><input type="date" name="document_dates[]" ></td>' +
                '<td><input type="text" name="document_places[]" ></td>' +
                '<td><button type="button" onclick="removeDocument(this)">Supprimer</button></td>' +
                '</tr>';
            documentsTable.innerHTML += row;
        }
    }

    // Function to remove a document from the table
    function removeDocument(button) {
        var row = button.parentElement.parentElement;
        row.remove();
    }

    // Add event listener to update table when files are selected
    document.getElementById('documents').addEventListener('change', updateSelectedDocuments);
</script>


    <script>
    // Fonction pour afficher les informations de paiement en fonction du mode sélectionné
    function showPaymentInfo() {
        var paymentMethod = document.getElementById('payment_method').value;
        // Masquer tous les formulaires d'abord
        document.getElementById('creditCardInfo').style.display = 'none';
        document.getElementById('paypalInfo').style.display = 'none';
        document.getElementById('bankTransferInfo').style.display = 'none';
        // Afficher le formulaire approprié en fonction du mode de paiement sélectionné
        if (paymentMethod === 'carte_credit') {
            document.getElementById('creditCardInfo').style.display = 'block';
        } else if (paymentMethod === 'paypal') {
            document.getElementById('paypalInfo').style.display = 'block';
        } else if (paymentMethod === 'virement_bancaire') {
            document.getElementById('bankTransferInfo').style.display = 'block';
        }
    }
</script>

</body>
</html>
