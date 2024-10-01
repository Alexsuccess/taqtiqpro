<!DOCTYPE html>
<html lang="fr">
<head>
<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
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

// Vérification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $localisation = $_POST['localisation'];
    $salaire = $_POST['salaire'];
    $nombre_poste = $_POST['nombre_poste'];
    $type_contrat = $_POST['type_contrat'];
    $description = $_POST['description'];

    // Requête SQL pour insérer les données dans la table
    $sql = "INSERT INTO offres_emploi (titre, pays, ville, localisation, salaire, nombre_poste, type_contrat, description, user_id, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '0')";
    $stmt = $conn->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("ssssssssi", $titre, $pays, $ville, $localisation, $salaire, $nombre_poste, $type_contrat, $description, $userId);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "L'offre d'emploi a été enregistrée avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de l'offre : " . $stmt->error;
    }

    // Fermeture de la déclaration
    $stmt->close();
}

// Fermeture de la connexion
$conn->close();
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement d'Offre d'Emploi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container">
                <h2>Enregistrement d'Offre d'Emploi</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre du Poste</label>
                        <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de l'offre" required>
                    </div>
                    <div class="mb-3">
                        <label for="pays" class="form-label">Pays</label>
                        <input type="text" class="form-control" id="pays" name="pays" placeholder="Pays" required>
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" required>
                    </div>
                    <div class="mb-3">
                        <label for="localisation" class="form-label">Localisation Précise</label>
                        <input type="text" class="form-control" id="localisation" name="localisation" placeholder="Lieu de travail" required>
                    </div>
                    <div class="mb-3">
                        <label for="salaire" class="form-label">Salaire</label>
                        <input type="number" class="form-control" id="salaire" name="salaire" placeholder="Salaire proposé (en €)" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_poste" class="form-label">Nombre de Postes</label>
                        <input type="number" class="form-control" id="nombre_poste" name="nombre_poste" placeholder="Nombre de postes disponibles" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_contrat" class="form-label">Type de Contrat</label>
                        <select class="form-select" id="type_contrat" name="type_contrat" required>
                            <option value="" disabled selected>Choisir le type de contrat</option>
                            <option value="Temps plein">Temps plein</option>
                            <option value="Temps patiel">Temps patiel</option>
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Stage">Stage</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description du poste" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer l'Offre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
