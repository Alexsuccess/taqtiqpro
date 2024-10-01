<?php
// Configuration de la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $typeImmigration = $_POST["typeImmigration"];
    $etape = $_POST["etape"];
    $nomFichier = $_POST["nomFichier"];

    // Chemin où le fichier sera enregistré
    $uploadDirectory = "uploads/immig/";
    $fichierChemin = $uploadDirectory . basename($_FILES["fichier"]["name"]);
    $fichierNom = $_FILES["fichier"]["name"];

    // Déplacer le fichier téléchargé vers le dossier d'uploads
    if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $fichierChemin)) {
        // Requête préparée pour l'insertion des données
        $sql = "INSERT INTO fichiers_immigration (type_immigration, etape, nom_fichier, chemin_fichier)
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $typeImmigration, $etape, $nomFichier, $fichierNom); // Stocker le nom du fichier dans la base de données
        
        if ($stmt->execute()) {
            echo "Fichier enregistré avec succès.";
        } else {
            echo "Erreur lors de l'insertion des données : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur lors de l'upload du fichier.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement des Fichiers d'Immigration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        .card {
            border: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            font-size: 24px;
            padding: 20px;
            border-bottom: none;
        }
        .card-body {
            padding: 20px;
        }
        .form-group label {
            color: #555;
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            Enregistrement des Fichiers d'Immigration
        </div>
        <div class="card-body">
            <form id="immigrationForm" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="typeImmigration">Type d'immigration</label>
                    <input type="text" class="form-control" id="typeImmigration" name="typeImmigration" required>
                </div>
                <div class="form-group">
                    <label for="etape">N° de l'étape</label>
                    <input type="number" class="form-control" id="etape" name="etape" required>
                </div>
                <div class="form-group">
                    <label for="nomFichier">Nom du fichier</label>
                    <input type="text" class="form-control" id="nomFichier" name="nomFichier" required>
                </div>
                <div class="form-group">
                    <label for="fichier">Fichier</label>
                    <input type="file" class="form-control-file" id="fichier" name="fichier" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
