<?php
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

// Fonction pour exécuter une requête SQL et récupérer les résultats
function executeSQLQuery($sql, $conn) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur dans la requête SQL: " . $conn->error);
    }
    return $result;
}

// Par défaut, récupérer toutes les données sans filtre de recherche
$sqlCalls = "SELECT * FROM calls WHERE user_id = $userId";
$sqlAppointments = "SELECT * FROM appointments WHERE user_id = $userId";
$sqlCases = "SELECT * FROM cases WHERE user_id = $userId";
$sqlProspections = "SELECT * FROM prospections WHERE user_id = $userId";

$resultCalls = executeSQLQuery($sqlCalls, $conn);
$resultAppointments = executeSQLQuery($sqlAppointments, $conn);
$resultCases = executeSQLQuery($sqlCases, $conn);
$resultProspections = executeSQLQuery($sqlProspections, $conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module des Téléphonistes - Tableau de Bord</title>
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

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        main {
            padding: 2em;
        }

        section {
            margin-bottom: 2em;
            background: white;
            padding: 1em;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        form label {
            display: block;
            margin-top: 1em;
        }

        form input[type="text"], form input[type="search"] {
            width: 100%;
            padding: 0.5em;
            margin-top: 0.5em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            margin-top: 1em;
            padding: 0.7em 1.5em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Module des Téléphonistes - Tableau de Bord</h1>
        <nav>
            <ul>
                <li><a href="#calls">Appels Clients</a></li>
                <li><a href="#appointments">Planification de Rendez-vous</a></li>
                <li><a href="#cases">Traitement des Dossiers</a></li>
                <li><a href="#prospection">Prospection</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="calls">
            <h2>Appels Clients</h2>
            <table>
                <tr>
                    <th>Nom du Client</th>
                    <th>Numéro de Téléphone</th>
                    <th>Notes de l'Appel</th>
                </tr>
                <?php
                if ($resultCalls && $resultCalls->num_rows > 0) {
                    while ($row = $resultCalls->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['clientName'] . "</td>";
                        echo "<td>" . $row['clientPhone'] . "</td>";
                        echo "<td>" . $row['callNotes'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
            </table>
        </section>

        <section id="appointments">
            <h2>Planification de Rendez-vous</h2>
            <table>
                <tr>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Heure</th>
                </tr>
                <?php
                if ($resultAppointments && $resultAppointments->num_rows > 0) {
                    while ($row = $resultAppointments->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['client'] . "</td>";
                        echo "<td>" . $row['appointmentDate'] . "</td>";
                        echo "<td>" . $row['appointmentTime'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
            </table>
        </section>

        <section id="cases">
            <h2>Traitement des Dossiers</h2>
            <table>
                <tr>
                    <th>Numéro de Dossier</th>
                    <th>Détails du Dossier</th>
                </tr>
                <?php
                if ($resultCases && $resultCases->num_rows > 0) {
                    while ($row = $resultCases->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['caseNumber'] . "</td>";
                        echo "<td>" . $row['caseDetails'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
            </table>
        </section>

        <section id="prospection">
            <h2>Prospection</h2>
            <table>
                <tr>
                    <th>Nom du Prospect</th>
                    <th>Contact</th>
                    <th>Notes de Prospection</th>
                </tr>
                <?php
                if ($resultProspections && $resultProspections->num_rows > 0) {
                    while ($row = $resultProspections->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['prospectName'] . "</td>";
                        echo "<td>" . $row['prospectContact'] . "</td>";
                        echo "<td>" . $row['prospectionNotes'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
            </table>
        </section>
    </main>
</body>
</html>
