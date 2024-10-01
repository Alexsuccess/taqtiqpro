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
$sql = "SELECT *, CASE 
                    WHEN appointmentDate = CURDATE() THEN 'today'
                    WHEN appointmentDate < CURDATE() THEN 'past'
                    ELSE 'upcoming'
                END AS appointmentStatus 
        FROM appointments 
        WHERE user_id = ?";

if ($searchQuery) {
    $sql .= " AND (client LIKE ? OR appointmentDate LIKE ? OR appointmentTime LIKE ?)";
}

$stmt = $conn->prepare($sql);
if ($searchQuery) {
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("isss", $userId, $searchTerm, $searchTerm, $searchTerm);
} else {
    $stmt->bind_param("i", $userId);
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
    <title>Rendez-vous</title>
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
        <h1>Rendez-vous</h1>
    </header>
    <main>
        <form id="searchForm">
            <input type="text" id="search" name="search" placeholder="Rechercher..." autocomplete="off">
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date du Rendez-vous</th>
                    <th>Heure du Rendez-vous</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody id="appointmentsTableBody">
                <!-- Les données seront insérées ici par JavaScript -->
                <?php foreach ($data as $row): ?>
                    <tr <?php if ($row['appointmentStatus'] === 'today') echo 'style="background-color: #ffcc00;"'; if ($row['appointmentStatus'] === 'past') echo 'style="background-color: #ff9999;"'; ?>>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['client']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                    <?php if ($row['appointmentStatus'] === 'today'): ?>
                        <script>
                            alert(`Rappel: Vous avez un rendez-vous aujourd'hui avec <?php echo htmlspecialchars(addslashes($row['client'])); ?>`);
                        </script>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const appointmentsTableBody = document.getElementById('appointmentsTableBody');

            searchInput.addEventListener('input', function () {
                const query = searchInput.value;

                fetch(`appointments.php?search=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    appointmentsTableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(appointment => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${appointment.id}</td>
                                <td>${appointment.client}</td>
                                <td>${appointment.appointmentDate}</td>
                                <td>${appointment.appointmentTime}</td>
                                <td>${appointment.created_at}</td>
                            `;

                            if (appointment.appointmentStatus === 'today') {
                                row.style.backgroundColor = '#ffcc00';  // Yellow for today's appointments
                            } else if (appointment.appointmentStatus === 'past') {
                                row.style.backgroundColor = '#ff9999';  // Red for past appointments
                            }

                            appointmentsTableBody.appendChild(row);
                        });
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="5" style="text-align:center;">Aucun résultat trouvé</td>`;
                        appointmentsTableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });

            // Déclencher une recherche initiale pour afficher tous les rendez-vous au chargement
            searchInput.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>
