<!DOCTYPE html>
<html>
<head>
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

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = '';

// Vérifie si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si les clés du tableau $_POST sont définies
    if (isset($_POST['jobTitle'], $_POST['jobTitlee'], $_POST['jobTitleex'], $_POST['jobTitleexo'], $_POST['jobDescription'], $_POST['jobRequirements'])) {
        // Récupération des données du formulaire
        $Entreprise = $_POST['Entreprise'];
        $jobTitle = $_POST['jobTitle'];
        $jobTitlee = $_POST['jobTitlee'];
        $jobTitleex = $_POST['jobTitleex'];
        $jobTitleexo = $_POST['jobTitleexo'];
        $jobDescription = $_POST['jobDescription'];
        $jobRequirements = $_POST['jobRequirements'];

        // Vérifie si les données ne sont pas vides
        if (!empty($Entreprise) && !empty($jobTitle) && !empty($jobTitlee) && !empty($jobTitleex) && !empty($jobTitleexo) && !empty($jobDescription) && !empty($jobRequirements)) {
            // Préparation de la requête SQL d'insertion avec des paramètres
            $sql = "INSERT INTO offre (Entreprise, job_title, job_titlee, job_description, job_requirements, user_id, etapes, type_poste) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Liaison des valeurs aux paramètres de la requête
            $stmt->bind_param("ssssssss", $Entreprise, $jobTitle, $jobTitlee, $jobDescription, $jobRequirements, $userId, $jobTitleex, $jobTitleexo);

            // Exécution de la requête
            if ($stmt->execute()) {
                $successMessage = "L'offre a été enregistrée avec succès.";
            } else {
                echo "Erreur lors de l'enregistrement de l'offre : " . $stmt->error;
            }

            // Fermeture de la déclaration
            $stmt->close();
        } else {
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    } else {
        echo "Formulaire incomplet.";
    }
}

// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une offre d'emploi</title>
    <style type="text/css">
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        section {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border-color: #4CAF50;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .step-fields {
            margin-bottom: 20px;
        }

        .step-fields label {
            font-weight: normal;
        }

        @media (max-width: 768px) {
            section {
                padding: 15px;
            }

            h2 {
                font-size: 22px;
            }

            input[type="text"],
            textarea,
            select {
                font-size: 13px;
            }

            button[type="submit"] {
                padding: 12px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php
    if (!empty($successMessage)) {
        echo "<p>$successMessage</p>";
    }
    ?>
<section>
    <h2>Enregistrer une offre d'emploi</h2>
    <form id="offerForm" method="post" action="">
        <label for="Entreprise">Nom de l'entreprise :</label>
        <input type="text" id="Entreprise" name="Entreprise" required="required">

        <label for="jobTitle">Titre de l'offre :</label>
        <input type="text" id="jobTitle" name="jobTitle" required="required">

        <label for="jobTitlee">Lieu de service :</label>
        <input type="text" id="jobTitlee" name="jobTitlee" required="required">

        <label for="jobTitleex">Type d'offre :</label>
        <select id="jobTitleex" name="jobTitleex" required="required">
            <option value="Saisonnier">Saisonnier</option>
            <option value="Permanent">Permanent</option>
        </select>

        <label for="jobTitleexo">Type de poste :</label>
        <select id="jobTitleexo" name="jobTitleexo" required="required">
            <option value="Temps plein">Temps plein</option>
            <option value="Partiel">Partiel</option>
        </select>

        <label for="jobDescription">Description de l'offre :</label>
        <textarea id="jobDescription" name="jobDescription"></textarea>

        <label for="jobRequirements">Exigences de l'offre :</label>
        <textarea id="jobRequirements" name="jobRequirements"></textarea>

        <button type="submit">Enregistrer</button>
    </form>
</section>
</body>
</html>
