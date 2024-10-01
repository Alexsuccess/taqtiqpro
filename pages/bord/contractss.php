<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Crée une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Sélectionne les données
$sql = "SELECT * FROM contrats";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contrats</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Contrat de recrutement de travailleurs internationaux</h1>
        <div style="margin-left: -20%;" class="table-container">
            <?php
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Nom de l\'Entreprise</th>';
               
            
               

                echo '<th>Nom et prénom</th>';
                echo '<th>Titre</th>';
                echo '<th>Adresse</th>';
                echo '<th>Numéro de téléphone</th>';
                echo '<th>Numéro de cellulaire</th>';
                echo '<th>Adresse courriel</th>';
                echo '<th>Date de Signature</th>';


                echo '<th>Date de Début</th>';
                echo '<th>Date de Création</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["entreprise_nom"] . '</td>';



echo '<td>' . $row["noms1"] . '</td>';
echo '<td>' . $row["noms2"] . '</td>';
echo '<td>' . $row["noms3"] . '</td>';
echo '<td>' . $row["noms4"] . '</td>';
echo '<td>' . $row["noms5"] . '</td>';
echo '<td>' . $row["noms6"] . '</td>';



                    echo '<td>' . $row["date_signature"] . '</td>';
                    echo '<td>' . $row["date_debut"] . '</td>';
                    echo '<td>' . $row["created_at"] . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Aucun contrat trouvé.</p>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
