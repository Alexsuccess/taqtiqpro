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



$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Requête SQL pour récupérer les données avec recherche
$sql = "SELECT * FROM prospections AS i LEFT JOIN userss AS d on d.id=i.user_id where i.user_id = $userId";
if ($searchQuery) {
    $sql .= " WHERE prospectName LIKE ? OR prospectContact LIKE ? OR prospectionNotes LIKE ?";
}

$stmt = $conn->prepare($sql);
if ($searchQuery) {
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

// Retourner les résultats en JSON si c'est une requête AJAX
if (isset($_GET['search'])) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Prospections</title>
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1em;
            text-align: center;
        }

        main {
            padding: 2em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2em;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.5em;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        form input[type="text"] {
            width: calc(100% - 1em);
            padding: 0.5em;
            margin: 1em 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('input[name="search"]');
            const tableBody = document.querySelector('table tbody');

            function fetchProspections(searchTerm = '') {
                fetch(`?search=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';

                        data.forEach(prospect => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${prospect.id}</td>
                                <td>${prospect.prospectName}</td>
                                <td>${prospect.prospectContact}</td>
                                <td>${prospect.prospectionNotes}</td>
                                <td>${prospect.created_at}</td>
                            `;

                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            searchInput.addEventListener('input', function () {
                fetchProspections(searchInput.value);
            });

            // Initial load
            fetchProspections();
        });
    </script>
</head>
<body>
    <header>
        <h1>Liste des Prospections</h1>
    </header>
    <main>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Rechercher...">
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Prospect</th>
                    <th>Contact</th>
                    <th>Notes de Prospection</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les résultats seront insérés ici par JavaScript -->
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['prospectName']); ?></td>
                        <td><?php echo htmlspecialchars($row['prospectContact']); ?></td>
                        <td><?php echo htmlspecialchars($row['prospectionNotes']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
