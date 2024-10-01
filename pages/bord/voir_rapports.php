<?php
$id = $_GET['id'];

// Connexion à la base de données
$conn = new mysqli('4w0vau.myd.infomaniak.com', '4w0vau_dreamize', 'Pidou2016', '4w0vau_dreamize');

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête pour obtenir les détails des rapports du projet
$sql = "SELECT * FROM reportso WHERE etape_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails des Rapports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Détails des Rapports du Projet ID: <?php echo htmlspecialchars($id); ?></h2>
    <table>
        <thead>
            <tr>
                <th>date dureport</th>
                <th>progression</th>
                <th>commentaire</th>
                <th>Date d'insertion</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['report_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['progress']) . "</td>";
                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <button onclick="window.close()">Fermer</button>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
