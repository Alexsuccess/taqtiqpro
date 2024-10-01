<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données des projets
$projects = [];
$ratings = [];

$sql = "SELECT p.nom AS project_name, AVG(s.rating) AS average_rating FROM projets4 p LEFT JOIN suivit_projets s ON p.id = s.project_id GROUP BY p.id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $projects[] = $row['project_name'];
    $ratings[] = $row['average_rating'];
}

$conn->close();

echo json_encode([
    'projects' => $projects,
    'ratings' => $ratings
]);
?>
