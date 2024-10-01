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
$sql = "SELECT * FROM calls i LEFT JOIN userss AS d on d.id=i.user_id where i.user_id = $userId";
if ($searchQuery) {
    $sql .= " WHERE clientName LIKE ? OR clientPhone LIKE ? OR callNotes LIKE ?";
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
    <title>Appels Clients</title>
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
        <h1>Appels Clients</h1>
    </header>
    <main>
        <form>
            <input type="text" name="search" placeholder="Rechercher..." oninput="fetchCalls(this.value)">
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Client</th>
                    <th>Numéro de Téléphone</th>
                    <th>Notes de l'appel</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $call): ?>
                <tr>
                    <td><?php echo htmlspecialchars($call['id']); ?></td>
                    <td><?php echo htmlspecialchars($call['clientName']); ?></td>
                    <td><?php echo htmlspecialchars($call['clientPhone']); ?></td>
                    <td><?php echo htmlspecialchars($call['callNotes']); ?></td>
                    <td><?php echo htmlspecialchars($call['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.querySelector('table tbody');

            function fetchCalls(searchTerm = '') {
                fetch(`?search=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';

                        data.forEach(call => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${call.id}</td>
                                <td>${call.clientName}</td>
                                <td>${call.clientPhone}</td>
                                <td>${call.callNotes}</td>
                                <td>${call.created_at}</td>
                            `;

                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Initial load
            fetchCalls();
        });
    </script>
</body>
</html>
