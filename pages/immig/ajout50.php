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
$sql = "SELECT * FROM cases i LEFT JOIN userss AS d on d.id=i.user_id where i.user_id = $userId";
if ($searchQuery) {
    $sql .= " WHERE caseNumber LIKE ? OR caseDetails LIKE ?";
}

$stmt = $conn->prepare($sql);
if ($searchQuery) {
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

// Vérifiez si la requête est une requête AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossiers</title>
    <style>
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
</head>
<body>
    <header>
        <h1>Dossiers</h1>
    </header>
    <main>
        <form id="searchForm">
            <input type="text" id="search" name="search" placeholder="Rechercher..." autocomplete="off">
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numéro de Dossier</th>
                    <th>Détails du Dossier</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody id="casesTableBody">
                <!-- Les données seront insérées ici par JavaScript -->
                        <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['caseNumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['caseDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const casesTableBody = document.getElementById('casesTableBody');

            searchInput.addEventListener('input', function () {
                const query = searchInput.value;

                fetch(`cases.php?search=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    casesTableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(caseItem => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${caseItem.id}</td>
                                <td>${caseItem.caseNumber}</td>
                                <td>${caseItem.caseDetails}</td>
                                <td>${caseItem.created_at}</td>
                            `;

                            casesTableBody.appendChild(row);
                        });
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="4" style="text-align:center;">Aucun résultat trouvé</td>`;
                        casesTableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });

            // Déclencher une recherche initiale pour afficher tous les dossiers au chargement
            searchInput.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>
