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
    $nom_lien = $_POST['nom_lien'];
    $lien = $_POST['lien'];

    $stmt = $conn->prepare("INSERT INTO links (compte, nom_lien, lien) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $compte, $nom_lien, $lien);

    if ($stmt->execute()) {
        $success_message = "Lien enregistré avec succès.";
    } else {
        $error_message = "Erreur lors de l'enregistrement: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partager un lien</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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
        .error-message, .success-message {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Enregistrer les liens</h2>
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label class="form-label">Type de compte</label>
            <select name="compte" class="form-control" required>
                <option value="Client">Client</option>
                <option value="Employé">Employé</option>
                <option value="Candidat">Candidat</option>
                <option value="Prestataire">Entreprise</option>
                <option value="Televendeur">Télévendeur</option>
                <option value="Agence de Marketing">Agence de Marketing</option>
                <option value="Employeur">Employeur</option> <!-- Ajouté le compte employeur -->
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Nom du lien</label>
            <input type="text" name="nom_lien" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Lien</label>
            <input type="url" name="lien" class="form-control" required>
        </div>
        <button type="submit" class="main_bt">Enregistrer</button>
    </form>
</div>
</body>
</html>
