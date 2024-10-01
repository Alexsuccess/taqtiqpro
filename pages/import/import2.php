<!DOCTYPE html>
<html>
<head>
    <title>Importation de données Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            border-radius: 5px;
        }
        input[type="file"] {
            display: none;
        }
        label {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Importation de données Excel vers la base de données</h2>

<form action="" method="post" enctype="multipart/form-data">
    <label for="file">Sélectionnez un fichier CSV</label>
    <input type="file" id="file" name="file" accept=".csv, .xlsx, .xls">
    <!-- ... -->
            <table>
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Numéro</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>Exemple</td>
                    <td>Exemple</td>
                    <td>Exemple</td>
                    <td>Exemple</td>
                    <td>Exemple</td>
                </tr>
            </table>
            <input type="submit" name="import" value="Importer">
        </form>
    </div>
</body>
</html>
<?php
if (isset($_POST['import'])) {
    $file = $_FILES['file']['tmp_name'];

    // Connexion à la base de données (à personnaliser)
    $conn = new mysqli("localhost", "root", "", "renaprov");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $handle = fopen($file, "r");
    if ($handle) {
        while (($data = fgetcsv($handle, 0, ";")) !== false) {
            $Matricule = trim($data[0]);
            $Nom = trim($data[1]);
            $Numero = trim($data[2]);
            $Montant = trim($data[3]);
            $Date = trim($data[4]);

            // Utilisez des requêtes SQL pour insérer les données dans la table (à personnaliser)
            $query = "INSERT INTO client2 (date_debut, date_fin, date_finn, aa, bb) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sssss", $Matricule, $Nom, $Numero, $Montant, $Date);
                if ($stmt->execute()) {
                    // Données insérées avec succès
                } else {
                    // Erreur d'insertion
                }
                $stmt->close();
            } else {
                // Erreur de préparation de la requête
            }
        }
        fclose($handle);
    }

    $conn->close();
    header('Location: #'); // Rediriger vers la page d'importation
}
?>

