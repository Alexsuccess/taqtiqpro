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
    $photot = uploadFile('photot', 'uploads/');

    // Étape 1: Insertion des données de la session 1 dans la base de données
    $sql1 = "INSERT INTO formulaire_immigration_session1 (full_name, preno, dob, email, phone, country, city, marital_status, immigration_type, employeur, education, experience, photo, photot, user_id, datet)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ssssssssssssssi", $full_name, $preno, $dob, $email, $phone, $country, $city, $marital_status, $immigration_type, $employeur, $education, $experience, $photo, $photot, $userId);
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

    $sql2 = "INSERT INTO formulaire_immigration_session2 (service_agreement, payment, documents, user_id, datet)
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

    $sql3 = "INSERT INTO formulaire_immigration_session3 (client_approval, final_payment, payment_method, user_id, datet)
            VALUES (?, ?, ?, ?, now())";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("issi", $client_approval, $final_payment, $payment_method, $userId);
    if ($stmt3->execute()) {
        echo "";
    } else {
        echo "Erreur lors de l'insertion des données de la session 3 : " . $stmt3->error . "<br>";
    }

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
        $stmt1 = $conn->prepare("INSERT INTO competence1 (codeutilisateur, Nom, prenom, pays, ville, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt1) {
            die("Erreur de préparation de la requête pour la table competence1: " . $conn->error);
        }

        // Préparation de la requête SQL d'insertion pour la table competence2
        $stmt2 = $conn->prepare("INSERT INTO competence2 (codeutilisateur, skillTitle, description, tools, `references`, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt2) {
            die("Erreur de préparation de la requête pour la table competence2: " . $conn->error);
        }

        // Récupération des données du formulaire
        $noms = $_POST['Nom'];
        $prenoms = $_POST['prenom'];
        $pays = $_POST['pays'];
        $villes = $_POST['ville'];
        $skillTitles = $_POST['skillTitle'];
        $descriptions = $_POST['description'];
        $tools = $_POST['tools'];
        $references = $_POST['references'];

        // Insertion des données dans les tables competence1 et competence2
        foreach ($skillTitles as $key => $skillTitle) {
            // Insertion dans la table competence1
            $stmt1->bind_param("sssssi", $codeutilisateur, $noms[$key], $prenoms[$key], $pays[$key], $villes[$key], $userId );
            $result1 = $stmt1->execute();

            if (!$result1) {
                die("Erreur lors de l'insertion dans la table competence1: " . $stmt1->error);
            }

            // Insertion dans la table competence2
            $stmt2->bind_param("sssssi", $codeutilisateur, $skillTitle, $descriptions[$key], $tools[$key], $references[$key], $userId );
            $result2 = $stmt2->execute();

            if (!$result2) {
                die("Erreur lors de l'insertion dans la table competence2: " . $stmt2->error);
            }
        }

        echo "Compétences enregistrées avec succès!";
echo "Félicitations ! Si votre candidature est validée, vous recevrez un email de confirmation contenant toutes les informations nécessaires pour commencer à travailler sur notre plateforme.

Nous vous souhaitons la meilleure des chances dans votre démarche et nous réjouissons de vous compter bientôt parmi nous.";

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
    <title>Formulaire d'Immigration</title>


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

     <style>
        .section {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .section h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .section p, .section ul, .section ol {
            font-size: 18px;
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .section ul, .section ol {
            padding-left: 20px;
        }
        .section .button-group {
            margin-top: 20px;
        }
        .button-group button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }
        .button-group button.prev-btn {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Formulaire de présélection</h2>
        <div class="section active" id="section0">
<div class="warning-message">
    <h3>IMPORTANT : AVANT DE REMPLIR CE FORMULAIRE, VEUILLEZ LIRE ATTENTIVEMENT LES INFORMATIONS SUIVANTES :</h3>
    <p style="color: blue;">Cher(e) candidat(e),</p>
    <p style="color: blue;">Nous vous remercions de votre intérêt pour travailler au sein de notre entreprise. Avant de commencer à remplir ce formulaire, veuillez prendre en compte les éléments suivants :</p>
    <ul>
        <li>Veuillez vous assurer d'avoir tous les documents nécessaires prêts à être téléchargés, y compris votre CV, votre carte d'identité nationale ou passeport, vos diplômes, portfolio, attestations, relevés de notes, etc.</li>
        <li>Assurez-vous de bien comprendre toutes les conditions et étapes relatives au processus d’embauche que vous souhaitez entreprendre.</li>
        <li>En soumettant ce formulaire, vous confirmez que toutes les informations fournies sont exactes, complètes et véridiques.</li>
        <li>Les informations que vous fournissez seront traitées de manière confidentielle et utilisées uniquement dans le cadre de votre candidature.</li>
        <li>Vous devez d’abord compléter le formulaire. Pour les téléphonistes, soumettre votre audio avec le script adopté à cet effet que vous trouverez dans la prochaine étape. Téléchargez vos documents et portfolio pour tous les postes de créations. Aucun dossier ne sera soumis s’il n’est pas complet. Aucun retour ne sera effectué en cas de doute sur la véracité des informations fournies.</li>
        <li>En aucun cas nous n’accepterons l’usurpation d’une candidature au sein de l’organisation.</li>
        <li>Notre équipe est là pour vous aider à chaque étape du processus. N'hésitez pas à nous contacter si vous avez des questions ou besoin d'assistance.</li>
        <li>Veuillez noter que le traitement de votre demande peut prendre du temps. Nous vous tiendrons informé(e) de l'avancement de votre dossier dès que possible.</li>
        <li>En cas de besoin d'assistance technique lors du remplissage du formulaire, veuillez nous contacter à l'adresse email <a href="mailto:support@rushmedias.com">support@rushmedias.com</a>.</li>
    </ul>
    <p style="color: blue;">Merci de votre compréhension et de votre coopération. Nous vous souhaitons la meilleure des chances dans votre processus de d’embauche en tant que téléphoniste.</p>
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


    <div class="section" id="section1">
          <h3>Script d'appel de qualification</h3>
    <p>Bonjour!!!<br>
    Puis-je parler au propriétaire s'il vous plaît?<br>
    Je suis ... d’Immonivo, la plateforme immobilière québécoise. J’aurai besoin de vous prendre 2 petites minutes de votre temps afin de promouvoir vos bénéfices en vous faisant intégrer notre réseau multiservices.</p>

    <p>Je vous appelle aujourd’hui car les meilleures entreprises québécoises ont manifesté l’envie d’augmenter leur revenu, d’autant plus que le secteur de l’immobilier génère à lui seul sous différentes catégories des revenus de plusieurs milliards de dollars par année au Québec. Nos courtiers offrent des cadeaux, des clients qui consomment suite à l’achat ou la vente de leur propriété, la rénovation des maisons...<br>
    Dites-moi Monsieur/Madame, avez-vous entrepris des démarches dans ce sens ces 2 dernières années ? (Attendre la réponse du client)</p>

    <p>Très bien. Il faut savoir que nous disposons de 15 000 ambassadeurs très actifs sur le marché qui pourront promouvoir votre entreprise. Actuellement, c’est la plateforme ressource pour ne pas dire la plus grande vitrine immobilière du Québec avec plus de 2 millions de clients uniques annuellement.<br>
    Vous pouvez offrir des offres locales, des rabais sur nos pages promotionnelles, des offres éclairs...</p>

    <p>Alors nous avons comme produits et services :</p>
    <ul>
        <li>Pochettes</li>
        <li>Bottin-annuaire</li>
        <li>Web</li>
        <li>Réseaux sociaux</li>
        <li>Promotions</li>
        <li>Marketing web</li>
        <li>Géolocalisation et bien d'autres...</li>
    </ul>

    <p>Alors dites-moi, lequel de ces produits ou services vous intéresse-t-il?</p>

    <p>Très bien. Pour vous montrer concrètement cela, je vous invite à vous rapprocher d'un ordinateur s'il vous plaît.</p>

    <p>- D'accord. Vous ouvrez une page Google et à la barre d'adresse tout en haut, renseignez : "immonivo.com" et vous validez.<br>
    Vous verrez une page avec les différents services de Immonivo. C'est bon?</p>

    <p>- Super. Allez au niveau de "Nos services et produits" et cliquez sur l'option "Services professionnels et personnalisables", vous verrez 5 services.</p>

    <p>- Très bien Monsieur/Madame. Puisque vous êtes intéressé(e) par le service "Pochette", vous allez cliquer sur la mention "commander" en dessous du service "Pochette".<br>
    Qu'est-ce que vous voyez?<br>
    Avez-vous une image de pochette à votre gauche et des champs à remplir à votre droite?</p>

    <p>- D'accord. Vous allez donc choisir le format qui vous intéresse ainsi que le montant et vous cliquez dessus. Une fois que ce sera fait, allez plus bas et cliquez sur "Ajouter au panier".<br>
    Vous allez apercevoir un point rouge avec le chiffre "1" à l'intérieur. Cliquez dessus.</p>

    <p>- À ce niveau, vous verrez une page qui vous montre le montant total à payer et le moyen de paiement.<br>
    Vous allez choisir le moyen qui vous arrange (soit le paiement par "link", "Valider la commande" c'est-à-dire un paiement par carte bleue; ou enfin par "Paypal").<br>
    Une fois le choix fait, remplissez discrètement vos formulaires de paiement. Quand vous allez valider le paiement, vous recevrez directement un mail attestant votre paiement.</p>

    <p>- Félicitations Monsieur/Madame pour votre enregistrement, je transfère directement votre dossier au service technique pour votre prise en charge. Vous serez contacté(e) sous 48h par le service technique de Immonivo. Mais si vous avez une disponibilité particulière, n'hésitez pas à me le dire maintenant pour que je le mentionne à votre dossier.</p>

    <p>- Parfait, on va faire un récapitulatif de vos informations. S'il vous plaît, votre nom et prénom, votre adresse mail, votre numéro de téléphone. Super.<br>
    Donc si j'ai bien noté, vous êtes Monsieur/Madame..., et vous avez souscrit au service (bottin/Pochette, etc.). C'est bien cela?</p>

    <p>- Super. Avez-vous une question ou une préoccupation? Si oui, répondre à sa préoccupation.<br>
    Très bien, s'il n'y a plus de souci, je transfère rapidement votre dossier au service technique et vous patientez leur appel comme on s'est dit, d'accord Monsieur/Madame...?</p>

    <p>- Parfait, je vous remercie pour votre confiance et à très bientôt.</p>


        <div class="button-group">
            <button type="button" class="prev-btn" onclick="showSection(0)">Précédent</button>
            <button type="button" class="next-btn" onclick="showSection(2)">Suivant</button>
        </div>
    </div>


        <form id="immigrationForm" action="" method="post" enctype="multipart/form-data">
            <div class="section" id="section2">
                <!-- Section 1 - Vos champs de formulaire -->
                                <h3>Identification personnelle, profil académique et professionnel</h3>
                <div class="form-group">
                    <label for="full_name">Nom complet <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Paul François" required="required">
                </div>
                  <div class="form-group">
                    <label for="preno">Prénom <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="preno" name="preno" placeholder="Paul François" required="required">
                </div>
                <div class="form-group">
                    <label for="dob">Date de naissance <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="date" id="dob" name="dob" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Email <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="email" id="email" name="email" placeholder="paulfrançois@gmail.com" required="required">
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="tel" id="phone" name="phone" placeholder="+237 697867352" required="required">
                </div>
                <div class="form-group">
                    <label for="country">Pays <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="text" id="country" name="country" placeholder="Cameroun" required="required">
                </div>
                <div class="form-group">
                    <label for="city">Ville :</label>
                    <input type="text" id="city" placeholder="Yaoundé" name="city" required="required">
                </div>
                <div class="form-group">
                    <label for="marital_status">Situation matrimoniale :</label>
                   <select id="marital_status" name="marital_status" required="required">
                        <option value="single">Célibataire</option>
                        <option value="married">Marié</option>
                        <option value="divorced">Divorcé</option>
                        <option value="widowed">Veuf</option>
                    </select>
                 </div>

                <div class="form-group">
                    <label for="experience">Message :</label>
                    <textarea id="experience" name="experience" ></textarea>
                </div>
                <div class="form-group">
                    <label for="photo">Téléchargez votre photo <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required="required">
                </div>
                <div class="form-group">
                    <label for="photot">Téléchargez vocal <em style="color: red; font-size: 9px;"></em>:</label>
                    <input type="file" id="photot" name="photot" accept="audio/*" required="required">
                </div>
                <!-- ... -->
                <div class="button-group">
                    <button type="button" class="prev-btn" onclick="showSection(1)">Précédent</button>
                    <button type="button" class="next-btn" onclick="showSection(3)">Suivant</button>
                </div>
            </div>

            <div class="section" id="section3">
                <!-- Section 2 - Vos champs de formulaire -->
                                <h3>Savoir-faire</h3>
                <!-- Champs de formulaire pour la session 2 -->
<div class="form-group">
        <label for="payment">Profession <em style="color: red; font-size: 9px;"></em>:</label>
        <input type="text" id="payment" name="payment" placeholder="Téléphoniste" >
    </div>
    <div class="form-group">
        <label for="documents">Télécharger les documents nécessaires <em style="color: red; font-size: 9px;"></em>: <br>
            <p style="color: blue; font-size: 11px; ">Vous pouvez télécharger vos documents nécessaires (CV, CNI/Passeport, Diplômes,...</p>
            <em style="color: red; font-size: 10px; ">Attention, vous devez les selectionner de votre repertoire une seule fois, peut importe le nombre de documents</em>
        </label>
        <input type="file" id="documents" name="documents[]" multiple required="required">
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
                    <button type="button" class="prev-btn" onclick="showSection(2)">Précédent</button>
                    <button type="button" class="next-btn" onclick="showSection(4)">Suivant</button>
                </div>
            </div>

            <div class="section" id="section4">
                <!-- Section 3 - Vos champs de formulaire -->
                <div class="containererrfgh">
    <h2>Déposer vos compétences</h2>
    <!-- Formulaire pour déposer les compétences -->
    <form id="skillsForm" method="post">
        <div id="skillsContainer">
            <div class="form-group">
                <label for="Nom">Nom :</label>
                <input type="text" class="form-control" name="Nom[]" required="required">
            </div>
            <div class="form-group">
                <label for="prenom">Prenom :</label>
                <input type="text" class="form-control" name="prenom[]" required="required">
            </div>
            <div class="form-group">
                <label for="pays">Pays :</label>
                <input type="text" class="form-control" name="pays[]" placeholder="Séparez les outils par des virgules" required="required">
            </div>
            <div class="form-group">
                <label for="ville">Ville :</label>
                <input type="text" class="form-control" name="ville[]" placeholder="Séparez les outils par des virgules" required="required">
            </div>
            <!-- Formulaire de compétence par défaut -->
            <div class="skill">
                <div class="form-group">
                    <label for="skillTitle">Intitulé de la compétence :</label>
                    <input type="text" class="form-control" name="skillTitle[]" required="required">
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description[]" rows="3" required="required"></textarea>
                </div>
                <div class="form-group">
                    <label for="tools">Outils / Technologies :</label>
                    <input type="text" class="form-control" name="tools[]" placeholder="Séparez les outils par des virgules" required="required">
                </div>
                <div class="form-group">
                    <label for="references">Références :</label>
                    <textarea class="form-control" name="references[]" rows="3" required="required"></textarea>
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
                    <button type="button" class="prev-btn" onclick="showSection(3)">Précédent</button>
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
