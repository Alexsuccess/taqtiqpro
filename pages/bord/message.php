<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupérez les informations de l'utilisateur
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $usernamext = $user['id'];
    $usernamex = $user['nom'];
    $prenom = $user['prenom'];
} else {
    $usernamex = "Utilisateur inconnu";
}

// Récupérez la liste des personnes qui ont contacté l'utilisateur en session
$sqlContacts = "(SELECT DISTINCT sender_id FROM messages WHERE receiver_id = ?) UNION (SELECT DISTINCT receiver_id FROM messages WHERE sender_id = ?)";
$stmtContacts = $conn->prepare($sqlContacts);
$stmtContacts->execute([$userId, $userId]);
$contacts = $stmtContacts->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "sendMessage") {
        $message = $_POST["message"];
        $contactId = $_POST["contactId"];

        $fileName = "";
        $fileDestination = ""; // Initialisez le chemin du fichier à une chaîne vide

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileDestination = "uploads/" . $fileName; // Changez "uploads/" selon votre structure de dossiers

            // Déplacez le fichier vers le dossier d'uploads
            move_uploaded_file($fileTmpName, $fileDestination);
        }

        // Enregistrez le message et le chemin du fichier dans la base de données
        $sqlSendMessage = "INSERT INTO messages (sender_id, receiver_id, message, file_path, is_read) VALUES (?, ?, ?, ?, 0)";
        $stmtSendMessage = $conn->prepare($sqlSendMessage);
        if ($stmtSendMessage->execute([$userId, $contactId, $message, $fileDestination])) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } elseif ($action == "getMessages") {
        $contactId = $_POST["contactId"];

        $sqlGetMessages = "SELECT m.*, u.nom AS username FROM messages m 
                           LEFT JOIN userss u ON m.sender_id = u.id 
                           WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
                           ORDER BY m.timestamp ASC LIMIT 10";

        $stmtGetMessages = $conn->prepare($sqlGetMessages);
        $stmtGetMessages->execute([$userId, $contactId, $contactId, $userId]);
        $messages = $stmtGetMessages->fetchAll(PDO::FETCH_ASSOC);

        // Mettez à jour le champ is_read une seule fois après avoir récupéré tous les messages
        $sqlUpdateReadStatus = "UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND is_read = 0";
        $stmtUpdateReadStatus = $conn->prepare($sqlUpdateReadStatus);
        $stmtUpdateReadStatus->execute([$userId]);

        // Ajoutez la sortie JSON
        header('Content-Type: application/json');
        echo json_encode($messages);
        exit();  // Ajout de exit pour arrêter l'exécution du script après l'envoi des messages
    }
}

echo "Aucun commanditaire ne vous a déjà contacté jusqu'ici !!!! : ";
print_r($contacts);

// Sélectionner tous les utilisateurs avec certains types de comptes et grouper par nom
$sqlContactNames = "SELECT id, nom, prenom, profile_pic, compte 
                    FROM userss 
                    WHERE compte IN ('Client', 'Modérateur', 'Televendeur', 'Candidat', 'Prestataire') 
                    GROUP BY nom";
$stmtContactNames = $conn->prepare($sqlContactNames);
$stmtContactNames->execute();
$resultContactNames = $stmtContactNames->fetchAll(PDO::FETCH_ASSOC);

// Créez un tableau associatif des noms de contact
$contactNames = array();
foreach ($resultContactNames as $contactNameRow) {
    $contactNames[$contactNameRow['id']] = array(
        'prenom' => $contactNameRow['prenom'],
        'nom' => $contactNameRow['nom']
    );
}

$conn = null;
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Chat</title>

    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        #users-list {
            width: 20%;
            padding: 20px;
            background-color: #333;
            color: white;
            overflow-y: auto;
        }

        #contacts {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #contacts li {
            margin-bottom: 10px;
            cursor: pointer;
        }

        #contacts li:hover {
            text-decoration: underline;
        }

        #chat-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;

        }

#chat-box {
    overflow-y: auto;
    flex-grow: 1;
    
    padding: 20px;
    background-image: url(images/Contacter.png);
    background-size: cover; /* Assurez-vous que l'image couvre entièrement la taille de l'élément */
    background-repeat: no-repeat; /* Évite la répétition de l'image */
    background-color: #f8f8f8;
}


        #message-container {
            display: flex;
            padding: 10px;
            align-items: flex-end;
        }

        #message {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        button:active {
            background-color: #3e8e41;
        }

        .sent-message {
            background-color: rgb(162,252,143);
            color: black;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            width: 50%;
               margin-left: 40%;
        }





        .received-message {
            background-color: rgb(159,252,253);
            color: #333;
            padding: 10px;
            width: 50%;
            border-radius: 10px;
            margin-bottom: 10px;
            margin-left: 10%;
        }

        #user-label {
            color: #4CAF50;
            font-size: 18px;
            margin-bottom: 10px;
        }

        #selected-contact {
            color: #4CAF50;
            font-size: 18px;
            margin-bottom: 10px;
        }


        .read-status {
    display: inline-block;
    margin-left: 10px;
    font-size: 14px;
}

.read-status.read {
    color: blue; /* Couleur des flèches bleues */
}

.read-status.unread {
    color: red; /* Couleur de la flèche rouge */
}

    </style>

















<style type="text/css">
        /* Votre CSS existant reste inchangé */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 99%;
            position: fixed;
        }
/* Ajoutez ce CSS à votre feuille de style existante */

/* Dropdown container */
.dropdown {
    display: inline-block;
}

/* Bouton du dropdown */
.dropbtn {
    background-color: #333;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

/* Contenu du dropdown (caché par défaut) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

/* Liens du dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change la couleur des liens au survol */
.dropdown-content a:hover {
    background-color: #ddd;
}

/* Affiche le dropdown au survol du bouton */
.dropdown:hover .dropdown-content {
    display: block;
}

        .logo-container img {
            max-width: 50px;
            margin-right: 10px;
        }

        .logo-container h1 {
            margin: 0;
            font-size: 1.5em;
        }

        .user-info {
            color: #ddd;
        }

        main {
            display: flex;
        }

        .categories {
            width: 20%;
            padding: 20px;
            background-color: #eee;
        }

        .category-item {
            margin-bottom: 10px;
            cursor: pointer;
        }

        .job-list,
        #job-detail {
            padding: 20px;
        }

        .job-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
        }

        .job-item img {
            max-width: 80px;
            margin-right: 15px;
        }

        .job-info {
            flex: 1;
        }

        .detail-btn {
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        #job-detail {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-left: 20px;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }
        /* Votre CSS existant reste inchangé */

        .job-list,
        .job-detail {
            transition: margin-left 0.5s;
            /* Animation de transition pour la division */
        }

        .job-list {
            float: left;
            width: 50%;
             float: left;

    overflow-y: auto;
        }

        .job-detail {
            float: left;
            width: 50%;
            display: none;
        }

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

    .detail-image {
        max-width: 20%; /* La largeur maximale de l'image est de 100% de la largeur du conteneur parent */
        height: auto; /* Laissez la hauteur s'ajuster automatiquement pour maintenir les proportions originales de l'image */
        display: block; /* Assurez-vous que l'image n'a pas de marge inférieure */
        margin: auto; /* Centrez l'image dans le conteneur parent */
        max-height: 50px; /* Définissez une hauteur maximale pour éviter que l'image ne devienne trop grande */
    }


.footer-content {
    max-width: 800px;
    margin: 0 auto;
}
/* Votre CSS existant reste inchangé */

.job-list, .job-detail {
    transition: margin-left 0.5s; /* Animation de transition pour la division */
}

.job-list {
    float: left;
    width: 50%;
    overflow-y: auto; /* Ajout de cette ligne pour activer la barre de défilement vertical */
}


.job-detail {
    float: left;
    width: 50%;
    display: none;
}


    </style>





<style>
  /* Style pour la modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
  }

  .modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  /* Style pour le formulaire dans la modal */
  form {
    display: grid;
    grid-gap: 10px;
  }

  label {
    font-weight: bold;
  }

  input,
  button {
    width: 20%;
    padding: 10px;
  }

  button {
    background-color: #4caf50;
    color: white;
    cursor: pointer;
  }
</style>

 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            display: flex;
            align-items: center;
        }

        #logo img {
            width: 40px; /* Ajustez la taille de votre logo */
            height: auto;
            margin-right: 10px;
        }

        #logo h3 {
            margin: 0;
        }

        #main-menu {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #main-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        #main-menu li {
            margin: 0 15px;
        }

        #main-menu a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        #right-menu {
            display: flex;
            align-items: center;
        }

        #right-menu a {
            margin-right: 15px;
            text-decoration: none;
            color: #fff;
        }

        .button-primary {
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;

        }


        .file-label {
    position: relative;
    cursor: pointer;
}

.file-icon {
    font-size: 24px; /* Ajustez la taille selon vos préférences */
    display: inline-block;
}

.file-label:hover .file-icon::before {
    content: "Joindre votre fichier";
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    visibility: visible;
    opacity: 1;
    transition: visibility 0s, opacity 0.2s linear;
}

.file-label:hover .file-icon {
    opacity: 0.7;
}

    </style>











<style>
  .media-file {
    width: 90%;
    height: 90%;
    margin-top: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }


</style>





<style>
#contacts {
    list-style-type: none;
    padding: 0;
}

#contacts li {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.profile-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.unread-notification {
    color: red;
    margin-left: auto;
}
</style>






</head>
<body>

        <header id="header">
        <div id="logo">
            <img src="images/logo.png" alt="Logo">
            <h3>Pluto</h3>
        </div>

        <div id="main-menu">
            <ul>
                <li><a href="../../telephoniste.php">Accueil</a></li>
                         
              
               <!-- ... (votre code HTML existant) -->

<li style="margin-top: -0.5%;">
    <?php
        // Inclure le script PHP pour compter les messages non lus
        // Assurez-vous que la session est démarrée
        session_start();

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
            header("Location: login.php");
            exit();
        }

        // Récupérez l'ID de l'utilisateur en session
        $userId = $_SESSION['id'];

        // Connexion à la base de données (à adapter selon vos paramètres)
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";



        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifiez la connexion à la base de données
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Requête SQL pour compter les messages non lus pour l'utilisateur en session
        $sqlCountUnreadMessages = "SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_id = ? AND is_read = 0";
        $stmtCountUnreadMessages = $conn->prepare($sqlCountUnreadMessages);
        $stmtCountUnreadMessages->bind_param("i", $userId);
        $stmtCountUnreadMessages->execute();
        $resultCountUnreadMessages = $stmtCountUnreadMessages->get_result();

        if ($resultCountUnreadMessages->num_rows > 0) {
            $row = $resultCountUnreadMessages->fetch_assoc();
            $unreadCount = $row['unread_count'];
            echo '<a href="message.php" id="unread-messages">Messages <strong style="color: red;">(' . $unreadCount . ')</strong></a>';
        } else {
            echo "Erreur lors de la récupération du nombre de messages non lus.";
        }

        // Fermez la connexion à la base de données
        $conn->close();
    ?>
</li>

<!-- ... (le reste de votre code HTML) -->

                  <li><a style="margin-top: -0.5%;" href="#">Utilisateur : <strong style="color: orange;"><?php echo $usernamex; ?></strong></a></li>
            </ul>
        </div>

        <div id="right-menu">
            <a href="../../login.php" class="button-primary">Déconnexion</a>
        </div>



    </header>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="margin-top: 2.5%; margin-left: -1%; position: fixed; height: 100%; width: 15%;" id="users-list">
    <div id="user-label">Utilisateur en session</div>
    <?php
    if (isset($usernamex)) {
        echo $usernamex;
    } else {
        echo "Utilisateur inconnu";
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

    // Connexion à la base de données (à adapter selon vos paramètres)
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $dbname = "4w0vau_dreamize";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérez les informations de l'utilisateur
    $sql = "SELECT * FROM userss WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usernamext = $row['id'];
        $usernamex = $row['nom'];
        $prenom = $row['prenom'];
    } else {
        $usernamex = "Utilisateur inconnu";
    }

    // Récupérez la liste des personnes qui ont contacté l'utilisateur en session
    $sqlContacts = "(SELECT DISTINCT sender_id FROM messages WHERE receiver_id = ?) UNION (SELECT DISTINCT receiver_id FROM messages WHERE sender_id = ?)";
    $stmtContacts = $conn->prepare($sqlContacts);
    $stmtContacts->bind_param("ii", $userId, $userId);
    $stmtContacts->execute();
    $resultContacts = $stmtContacts->get_result();

    $contacts = array();
    while ($contactRow = $resultContacts->fetch_assoc()) {
        $contacts[] = $contactRow['sender_id'];
    }

    // Récupérez tous les contacts des types spécifiés
    $sqlSpecifiedContacts = "SELECT id FROM userss WHERE compte IN ('Client', 'Modérateur', 'Televendeur', 'Candidat', 'Prestataire', 'Employé', 'Collaborateur', 'Agent', 'Agence')";
    $resultSpecifiedContacts = $conn->query($sqlSpecifiedContacts);

    while ($specifiedContactRow = $resultSpecifiedContacts->fetch_assoc()) {
        $contacts[] = $specifiedContactRow['id'];
    }

    // Supprimez les doublons
    $contacts = array_unique($contacts);

    // Requête pour récupérer les informations des contacts
    $sqlContactNames = "SELECT id, nom, prenom, profile_pic, compte 
                        FROM userss 
                        WHERE compte IN ('Client', 'Modérateur', 'Televendeur', 'Candidat', 'Prestataire', 'Employé', 'Collaborateur', 'Agent', 'Agence')";
    $stmtContactNames = $conn->prepare($sqlContactNames);
    $stmtContactNames->execute();
    $resultContactNames = $stmtContactNames->get_result();

    // Créez un tableau associatif des noms de contact et des images de profil
    $contactNames = array();
    while ($contactNameRow = $resultContactNames->fetch_assoc()) {
        $contactNames[$contactNameRow['id']] = array(
            'prenom' => $contactNameRow['prenom'],
            'nom' => $contactNameRow['nom'],
            'compte' => $contactNameRow['compte'],
            'profile_pic' => $contactNameRow['profile_pic'] ?? '../../papa.jpg' // Utilisez 'default.png' si profile_pic est vide
        );
    }

    ?>

    <ul id="contacts">
        <li id="selected-contact" data-contact-id="-1">Sélectionnez un contact</li>
        <br>
        <input style="width: 100%;" type="text" id="search-contact" placeholder="Rechercher un contact">
        <br><br>
        <?php foreach ($contacts as $contactId): 
            // Vérifiez si le contact existe dans $contactNames
            if (!isset($contactNames[$contactId])) {
                continue;
            }
            $contactData = $contactNames[$contactId];
            $contactName = $contactData['prenom'] . ' ' . $contactData['nom'];
            $profile_pic = $contactData['profile_pic'];
            $compte = $contactData['compte'];

            // Requête pour compter les messages non lus pour ce contact
            $sqlUnreadMessages = "SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_id = ? AND sender_id = ? AND is_read = 0";
            $stmtUnreadMessages = $conn->prepare($sqlUnreadMessages);
            $stmtUnreadMessages->bind_param("ii", $userId, $contactId);
            $stmtUnreadMessages->execute();
            $resultUnreadMessages = $stmtUnreadMessages->get_result();
            $unreadCount = 0;

            if ($resultUnreadMessages->num_rows > 0) {
                $row = $resultUnreadMessages->fetch_assoc();
                $unreadCount = $row['unread_count'];
            }
        ?>
        <li data-contact-id="<?php echo $contactId; ?>">
            <img src="../../uploads/<?php echo $profile_pic; ?>" alt="Profile Image" class="profile-image">
            <span><?php echo $compte; ?>: <?php echo $contactName; ?></span>
            <?php if ($unreadCount != 0): ?>
                <span class="unread-notification">(<?php echo $unreadCount; ?>)</span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>

    <?php
    // Fermez la connexion à la base de données après avoir terminé toutes les opérations
    $conn->close();
    ?>
</div>



    <div style="margin-left: -12%;" id="chat-container">
        <div style="margin-top: 3%;  " id="chat-box"></div>
<div id="message-container">
    <textarea  style="margin-left: 5%;" id="message" placeholder="Votre message"></textarea>
<label for="fileInput" class="file-label">
    <input type="file" id="fileInput" accept=".php, .doc, .docx, .pdf, .jpg, .jpeg, .png, .xls, .xlsx, .mp4, .avi, .mov, .mkv" style="display: none" multiple>
    <img style="font-size: 24px; display: inline-block; width: 80px; height: 80px; " title="Joindre un fichier : image, audio, vidéo, pdf, word, excel, SQL, ...." src="../../uploads/images/fich.jpg">
</label>


    <button onclick="sendMessage()">Envoyer</button>
</div>
<br><br><br><br><br>
    </div>

<!-- ... -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function sendMessage() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];

    var message = $("#message").val();
    var selectedContactId = $("#selected-contact").attr("data-contact-id");

    if (selectedContactId !== "-1") {
        var formData = new FormData();
        formData.append('action', 'sendMessage');
        
        // Ajoutez le fichier uniquement s'il est réellement sélectionné
        if (file) {
            formData.append('file', file);
        }

        formData.append('message', message);
        formData.append('contactId', selectedContactId);

        $.ajax({
            url: " ", // Assurez-vous de spécifier le bon fichier PHP pour gérer l'envoi de fichiers
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("File and message sent successfully. Server response:", response);
                $("#message").val('');
                fileInput.value = ''; // Efface le contenu de l'input file après l'envoi du fichier
                getMessages(selectedContactId);
            },
            error: function (error) {
                console.error("Error sending file and message:", error);
                toastr.error("Erreur lors de l'envoi du fichier et du message. Veuillez réessayer. " + error.responseText);
            }
        });
    } else {
        alert("Veuillez sélectionner un contact avant d'envoyer un fichier.");
    }
}



$(document).ready(function() {
    // Stocker l'ID du contact actuel
    var currentContactId;

    $("#contacts li").click(function() {
        var contactId = $(this).attr("data-contact-id");
        $("#selected-contact").attr("data-contact-id", contactId);
        $("#selected-contact").text("Conversation avec " + contactId);
        getMessages(contactId);

        // Stocker l'ID du contact actuel
        currentContactId = contactId;

        // Appeler la fonction startAutoRefresh pour démarrer l'actualisation automatique
        startAutoRefresh();
    });

    function getMessages(contactId) {
        console.log("getMessages function is called");

        $.ajax({
            url: "",  // Assurez-vous de spécifier l'URL correcte
            type: "POST",
            data: { action: "getMessages", contactId: contactId },
            success: function (response) {
                console.log('Messages reçus :', response);
                updateChatBox(response);
                updateUnreadCounts(response); // Appel de la fonction pour mettre à jour les nombres de messages non lus
            },
            error: function (error) {
                console.error('Erreur lors de la récupération des messages :', error);
                alert("Erreur lors de la récupération des messages. Veuillez réessayer. " + error.responseText);
            }
        });
    }

    // Fonction pour mettre à jour les nombres de messages non lus
    function updateUnreadCounts(messages) {
        // Réinitialiser tous les compteurs à zéro
        $(".unread-notification").text("");

        // Compter les messages non lus pour chaque contact
        messages.forEach(function(message) {
            var contactId = message.sender_id;
            var unreadCount = message.unread_count;

            // Mettre à jour le compteur pour ce contact
            $(".unread-notification[data-contact-id='" + contactId + "']").text(unreadCount);
        });
    }

function updateChatBox(messages) {
    var chatBox = $("#chat-box");
    var videoStates = {};

    // Sauvegarder l'état des vidéos existantes
    $("video").each(function() {
        var video = $(this)[0];
        videoStates[video.src] = {
            currentTime: video.currentTime,
            paused: video.paused
        };
    });

    chatBox.empty();

    messages.forEach(function (message) {
        var messageClass = message.sender_id == <?php echo $userId; ?> ? 'sent-message' : 'received-message';
        var formattedMessage = message.message.replace(/\n/g, '<br>'); // Remplace les sauts de ligne par des balises <br>

        var mediaElement = '';
        // Vérifier s'il y a un fichier joint
        if (message.file_path) {
            var fileExtension = message.file_path.split('.').pop().toLowerCase();

            // Afficher une balise img pour une image
            if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
                mediaElement = '<img src="' + message.file_path + '" class="media-file">';
            }
            // Afficher une balise video pour une vidéo
            else if (fileExtension === 'mp4' || fileExtension === 'avi' || fileExtension === 'mov' || fileExtension === 'mkv') {
                mediaElement = '<video controls class="media-file"><source src="' + message.file_path + '" type="video/' + fileExtension + '"></video>';
            }
        }

        // Ajouter les flèches de statut de lecture
        var readStatusIcon = '';
        if (message.is_read == 1) {
            readStatusIcon = '<span class="read-status read"><i class="fas fa-check-double"></i></span>'; // Flèches bleues
        } else {
            readStatusIcon = '<span class="read-status unread"><i class="fas fa-check"></i></span>'; // Flèche rouge
        }

        // Ajouter le média à la boîte de chat
        var messageContainer = '<div class="message-container ' + messageClass + '"><strong>' + message.username + ':</strong> ' + formattedMessage + ' (' + message.timestamp + ')' + mediaElement + readStatusIcon + '</div>';
        chatBox.append(messageContainer);
    });

    // Restaurer l'état des vidéos
    $("video").each(function() {
        var video = $(this)[0];
        if (videoStates[video.src]) {
            video.currentTime = videoStates[video.src].currentTime;
            if (!videoStates[video.src].paused) {
                video.play();
            }
        }
    });

    chatBox.scrollTop(chatBox[0].scrollHeight);
}

function startAutoRefresh() {
    // Actualiser les messages toutes les 5 secondes (vous pouvez ajuster cela selon vos besoins)
    setInterval(function () {
        // Actualiser la liste des messages avec le dernier timestamp
        getMessages(currentContactId);
    }, 15000); // 5000 millisecondes équivalent à 5 secondes

    // Récupérer les messages initiaux
    getMessages(currentContactId);
}
});



   
</script>

<script>
$(document).ready(function() {
    $("#search-contact").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();

        $("#contacts li").each(function() {
            var contactName = $(this).text().toLowerCase();

            if (contactName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
    <script>
        // Fonction pour actualiser le contenu du header après 10 secondes
        setInterval(function() {
            // Utilisation de jQuery pour charger le contenu du header à partir du fichier header.php
            $('#header').load('header.php #header');
        }, 20000); // 10000 millisecondes équivalent à 10 secondes
    </script>
</body>
</html>
