<?php
// Activation des erreurs PHP pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Paramètres de connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête SQL pour récupérer les données
$sql = "SELECT * FROM qualification_calls";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Appels de Qualification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .signature {
            width: 200px;
            height: 100px;
            border: 1px solid #ddd;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Appels de Qualification</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom du Prospect</th>
                    <th>Votre Nom</th>
                    <th>Offre 1</th>
                    <th>Offre 2</th>
                    <th>Offre 3</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Affichage des données de chaque ligne
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['prospect_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['your_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['offer1']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['offer2']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['offer3']) . "</td>";
                        echo "<td><img src='data:image/png;base64," . $row['signature_data'] . "' class='signature' alt='Signature'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun enregistrement trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?>
