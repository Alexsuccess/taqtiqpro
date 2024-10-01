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

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clientName']) && isset($_POST['clientPhone']) && isset($_POST['callNotes'])) {
        $clientName = $_POST['clientName'];
        $clientPhone = $_POST['clientPhone'];
        $callNotes = $_POST['callNotes'];

        $stmt = $conn->prepare("INSERT INTO calls (clientName, clientPhone, callNotes, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $clientName, $clientPhone, $callNotes, $userId);

        if ($stmt->execute()) {
            $response['message'] = "Appel enregistré avec succès";
        } else {
            $response['message'] = "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['appointmentClient']) && isset($_POST['appointmentDate']) && isset($_POST['appointmentTime'])) {
        $client = $_POST['appointmentClient'];
        $date = $_POST['appointmentDate'];
        $time = $_POST['appointmentTime'];

        $stmt = $conn->prepare("INSERT INTO appointments (client, appointmentDate, appointmentTime, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $client, $date, $time, $userId);

        if ($stmt->execute()) {
            $response['message'] = "Rendez-vous planifié avec succès";
        } else {
            $response['message'] = "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['caseNumber']) && isset($_POST['caseDetails'])) {
        $caseNumber = $_POST['caseNumber'];
        $caseDetails = $_POST['caseDetails'];

        $stmt = $conn->prepare("INSERT INTO cases (caseNumber, caseDetails, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $caseNumber, $caseDetails, $userId);

        if ($stmt->execute()) {
            $response['message'] = "Dossier enregistré avec succès";
        } else {
            $response['message'] = "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['prospectName']) && isset($_POST['prospectContact']) && isset($_POST['prospectionNotes'])) {
        $prospectName = $_POST['prospectName'];
        $prospectContact = $_POST['prospectContact'];
        $prospectionNotes = $_POST['prospectionNotes'];

        $stmt = $conn->prepare("INSERT INTO prospections (prospectName, prospectContact, prospectionNotes, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $prospectName, $prospectContact, $prospectionNotes, $userId);

        if ($stmt->execute()) {
            $response['message'] = "Prospection enregistrée avec succès";
        } else {
            $response['message'] = "Erreur: " . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();

    // Retourner la réponse en JSON
    header('Content-Type: application/json');
    
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module des Téléphonistes</title>
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

        form label {
            display: block;
            margin-top: 1em;
        }

        form input, form textarea {
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
        <h1>Module des Téléphonistes</h1>
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
            <form id="callForm" action="" method="POST">
                <label for="clientName">Nom du Client:</label>
                <input type="text" id="clientName" name="clientName" required>
                
                <label for="clientPhone">Numéro de Téléphone:</label>
                <input type="tel" id="clientPhone" name="clientPhone" required>
                
                <label for="callNotes">Notes de l'appel:</label>
                <textarea id="callNotes" name="callNotes" required></textarea>
                
                <button type="submit">Enregistrer l'Appel</button>
            </form>
        </section>

        <section id="appointments">
            <h2>Planification de Rendez-vous</h2>
            <form id="appointmentForm" action="" method="POST">
                <label for="appointmentClient">Client:</label>
                <input type="text" id="appointmentClient" name="appointmentClient" required>
                
                <label for="appointmentDate">Date:</label>
                <input type="date" id="appointmentDate" name="appointmentDate" required>
                
                <label for="appointmentTime">Heure:</label>
                <input type="time" id="appointmentTime" name="appointmentTime" required>
                
                <button type="submit">Planifier Rendez-vous</button>
            </form>
        </section>

        <section id="cases">
            <h2>Traitement des Dossiers</h2>
            <form id="caseForm" action="" method="POST">
                <label for="caseNumber">Numéro de Dossier:</label>
                <input type="text" id="caseNumber" name="caseNumber" required>
                
                <label for="caseDetails">Détails du Dossier:</label>
                <textarea id="caseDetails" name="caseDetails" required></textarea>
                
                <button type="submit">Enregistrer le Dossier</button>
            </form>
        </section>

        <section id="prospection">
            <h2>Prospection</h2>
            <form id="prospectionForm" action="" method="POST">
                <label for="prospectName">Nom du Prospect:</label>
                <input type="text" id="prospectName" name="prospectName" required>
                
                <label for="prospectContact">Contact:</label>
                <input type="tel" id="prospectContact" name="prospectContact" required>
                
                <label for="prospectionNotes">Notes de Prospection:</label>
                <textarea id="prospectionNotes" name="prospectionNotes" required></textarea>
                
                <button type="submit">Enregistrer la Prospection</button>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const callForm = document.getElementById('callForm');
            const appointmentForm = document.getElementById('appointmentForm');
            const caseForm = document.getElementById('caseForm');
            const prospectionForm = document.getElementById('prospectionForm');

            function handleFormSubmit(event, formId) {
                event.preventDefault();

                const formData = new FormData(document.getElementById(formId));
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                    } else {
                        alert('Enregistrement ok');
                    }
                    document.getElementById(formId).reset();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Enregistrement ok');
                });
            }

            callForm.addEventListener('submit', function (event) {
                handleFormSubmit(event, 'callForm');
            });

            appointmentForm.addEventListener('submit', function (event) {
                handleFormSubmit(event, 'appointmentForm');
            });

            caseForm.addEventListener('submit', function (event) {
                handleFormSubmit(event, 'caseForm');
            });

            prospectionForm.addEventListener('submit', function (event) {
                handleFormSubmit(event, 'prospectionForm');
            });
        });
    </script>
</body>
</html>
