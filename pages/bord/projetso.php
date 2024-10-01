<?php
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

// Fonction pour vérifier si un client existe
function clientExists($conn, $client_id) {
    $sql = "SELECT id FROM clientso WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $client_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

// Ajouter un projet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create_project') {
    $client_id = $_POST['client_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Vérifier si le client existe
    if (clientExists($conn, $client_id)) {
        $sql = "INSERT INTO projectso (client_id, name, description, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $client_id, $name, $description, $start_date, $end_date);

        if ($stmt->execute()) {
            echo "Projet créé avec succès.";
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur: Le client sélectionné n'existe pas.";
    }
}

// Ajouter une étape
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_step') {
    $projet_id = $_POST['projet_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "INSERT INTO stepso (projet_id, name, description, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $projet_id, $name, $description, $start_date, $end_date);

    if ($stmt->execute()) {
        echo "Étape ajoutée avec succès.";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
}

// Ajouter un rapport
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_report') {
    $etape_id = $_POST['etape_id'];
    $report_date = $_POST['report_date'];
    $progress = $_POST['progress'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO reportso (etape_id, report_date, progress, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $etape_id, $report_date, $progress, $comment);

    if ($stmt->execute()) {
        echo "Rapport ajouté avec succès.";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
}

// Récupérer les alertes pour les rapports manquants
$today = new DateTime();
$today->format('Y-m-d');

$sql = "SELECT s.name AS step_name, r.report_date
        FROM stepso s
        LEFT JOIN reportso r ON s.id = r.etape_id AND r.report_date = ?
        WHERE r.id IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today->format('Y-m-d'));
$stmt->execute();
$result = $stmt->get_result();

$alerts = [];
while ($row = $result->fetch_assoc()) {
    $alerts[] = $row;
}

$stmt->close();
?>


<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$database = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les projets
$projects = $conn->query("SELECT id, name FROM projectso");

// Récupérer les étapes et rapports en fonction du projet sélectionné
$selected_project_id = isset($_POST['projet_id']) ? $_POST['projet_id'] : null;
$steps = [];
$reports = [];

if ($selected_project_id) {
    // Récupérer les étapes du projet sélectionné
    $steps_result = $conn->query("SELECT id, name, start_date, end_date FROM stepso WHERE projet_id = $selected_project_id");
    if ($steps_result) {
        $steps = $steps_result->fetch_all(MYSQLI_ASSOC);
    }

    // Récupérer les rapports des étapes du projet sélectionné
    $reports_result = $conn->query("
        SELECT r.id, r.report_date, r.progress, r.comment, s.name AS step_name 
        FROM reportso r 
        JOIN stepso s ON r.etape_id = s.id 
        WHERE s.projet_id = $selected_project_id
    ");
    if ($reports_result) {
        $reports = $reports_result->fetch_all(MYSQLI_ASSOC);
    }
}

// Gérer les alertes pour rapports manquants
// Gérer les alertes pour rapports manquants
$alerts = [];
$selected_project_id = intval($selected_project_id); // Assurez-vous que l'ID du projet est un entier pour éviter les injections SQL

// Préparer la requête SQL
$sql = "
    SELECT s.name AS step_name, s.end_date AS report_date 
    FROM stepso s 
    LEFT JOIN reportso r ON s.id = r.etape_id 
    WHERE s.projet_id = $selected_project_id 
    AND r.id IS NULL
";

// Exécuter la requête
$alerts_result = $conn->query($sql);

if ($alerts_result) {
    $alerts = $alerts_result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Erreur de requête : " . $conn->error;
}


// Gantt chart data
$ganttData = [];
$gantt_result = $conn->query("
    SELECT p.id, p.name AS project_name, p.start_date AS project_start, p.end_date AS project_end,
           s.name AS step_name, s.start_date AS step_start, s.end_date AS step_end 
    FROM projectso p 
    LEFT JOIN stepso s ON p.id = s.projet_id
");
if ($gantt_result) {
    $ganttData = $gantt_result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Projets</title>
    <style type="text/css">
        /* Style de base pour le corps de la page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Style pour le menu de navigation */
.navbar {
    background-color: #333;
    overflow: hidden;
}

.navbar a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
}

.navbar a:hover {
    background-color: #ddd;
    color: black;
}

.navbar .active {
    background-color: #4CAF50;
    color: white;
}

/* Style pour le contenu principal */
.container {
    margin: 20px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Style pour les titres de sections */
.container h2 {
    color: #333;
    font-size: 24px;
    margin-top: 0;
}

/* Style pour les boutons */
button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: #45a049;
}

/* Style pour les formulaires */
form {
    margin: 20px 0;
}

form input[type="text"],
form input[type="date"],
form textarea {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form label {
    font-weight: bold;
}

/* Style pour les tableaux */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

/* Style pour les alertes */
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    margin-bottom: 15px;
    border-radius: 4px;
}

.alert.success {
    background-color: #4CAF50;
}

.alert.info {
    background-color: #2196F3;
}

.alert.warning {
    background-color: #ff9800;
}

/* Style pour le diagramme de Gantt */
.gantt-container {
    overflow-x: auto;
    white-space: nowrap;
}

/* Style pour le calendrier des projets */
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #ddd;
}

.calendar div {
    background-color: white;
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

/* Style pour les sections des projets enregistrés */
.project-list {
    margin-top: 20px;
}

.project-item {
    background-color: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
}


        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            background-color: #444;
            overflow: hidden;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            float: left;
        }
        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav ul li a:hover {
            background-color: #575757;
        }
        .container {
            padding: 20px;
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            margin-bottom: 15px;
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
        th {
            background-color: #f2f2f2;
        }
        canvas {
            max-width: 100%;
        }
    </style>






    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="#" onclick="showSection('create_project')">Créer un Projet</a></li>
                <li><a href="#" onclick="showSection('add_step')">Ajouter une Étape</a></li>
                <li><a href="#" onclick="showSection('add_report')">Ajouter un Rapport</a></li>
                <li><a href="#" onclick="showSection('alerts')">Alertes</a></li>
                <li><a href="#" onclick="showSection('gantt_chart')">Diagramme de Gantt</a></li>
                <li><a href="#" onclick="showSection('calendar')">Calendrier</a></li>
                <li><a href="#" onclick="showSection('view_projects')">Afficher les Projets</a></li>
            </ul>
        </nav>

        <!-- Section Afficher les Projets -->
        <div id="view_projects" class="section">
            <h2>Afficher les Projets</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
             <?php
            if ($projects) {
                while ($row = $projects->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>
                            <button class='btn btn-secondary' type='button' onclick=\"voirPlus('" . htmlspecialchars($row['id']) . "')\">Étapes</button>
                            <button class='btn btn-secondary' type='button' onclick=\"voirPlus2('" . htmlspecialchars($row['id']) . "')\">Rapports</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Aucun projet disponible</td></tr>";
            }
            ?>
                </tbody>
            </table>
        </div>

        <!-- Section Détails du Projet -->
        <div id="project_details" class="section">
            <h2>Détails du Projet</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="view_project_details">
                <label for="projet_id">Sélectionner un Projet:</label>
                <select name="projet_id" id="projet_id" onchange="this.form.submit()">
                    <option value="">Sélectionner un Projet</option>
                    <?php
                    // Réinitialiser la valeur du projet sélectionné
                    if ($projects) {
                        while ($row = $projects->fetch_assoc()) {
                            $selected = $selected_project_id == $row['id'] ? 'selected' : '';
                            echo "<option value=\"" . $row['id'] . "\" $selected>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </form>

            <!-- Affichage des étapes du projet -->
            <?php if ($selected_project_id): ?>
                <h3>Étapes du Projet</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Date de Début</th>
                            <th>Date de Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($steps) {
                            foreach ($steps as $step) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($step['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($step['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($step['start_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($step['end_date']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Aucune étape disponible pour ce projet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Affichage des rapports des étapes du projet -->
                <h3>Rapports des Étapes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Étape</th>
                            <th>Date du Rapport</th>
                            <th>Progrès</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($reports) {
                            foreach ($reports as $report) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($report['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($report['step_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($report['report_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($report['progress']) . "</td>";
                                echo "<td>" . htmlspecialchars($report['comment']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun rapport disponible pour ce projet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Section Ajouter un Projet -->
        <div id="create_project" class="section">
            <h2>Créer un Projet</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="create_project">
                <label for="client_id">Client:</label>
                <select name="client_id" id="client_id" required>
                    <?php
                    // Affichage des clients depuis la base de données
                    $sql = "SELECT id, name FROM clientso";
                    $result = $conn->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Aucun client disponible</option>";
                    }
                    ?>
                </select><br><br>


                <label for="name">Nom du Projet:</label>
                <input type="text" name="name" id="name" required>

                <label for="start_date">Date de Début:</label>
                <input type="date" name="start_date" id="start_date" required>

                <label for="end_date">Date de Fin:</label>
                <input type="date" name="end_date" id="end_date" required>

                <label for="description">Déscription</label>
                <textarea type="text" name="description" id="description" required>
                ></textarea>
                <input type="submit" value="Créer le Projet">
            </form>
        </div>

        <!-- Section Ajouter une Étape -->
        <div id="add_step" class="section">
            <h2>Ajouter une Étape</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="add_step">
                <label for="projet_id">Projet:</label>
                <select name="projet_id" id="projet_id" required>
                    <?php
                    // Affichage des projets depuis la base de données
                    $sql = "SELECT id, name FROM projectso"; // Assurez-vous que le nom de la table est correct
                    $result = $conn->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Aucun projet disponible</option>";
                    }
                    ?>
                </select><br><br>

                <label for="name">Nom de l'Étape:</label>
                <input type="text" id="name" name="name" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                <label for="start_date">Date de Début:</label>
                <input type="date" id="start_date" name="start_date" required>
                <label for="end_date">Date de Fin:</label>
                <input type="date" id="end_date" name="end_date" required>
                <button type="submit">Ajouter</button>
            </form>
        </div>

        <!-- Section Ajouter un Rapport -->
        <div id="add_report" class="section">
            <h2>Ajouter un Rapport</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="add_report">
                <label for="etape_id">Étape:</label>
                <select name="etape_id" id="etape_id" required>
                    <?php
                    if ($steps) {
                        foreach ($steps as $step) {
                            echo "<option value=\"" . $step['id'] . "\">" . $step['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Aucune étape disponible</option>";
                    }
                    ?>
                </select><br>
<br>


                <label for="report_date">Date du Rapport:</label>
                <input type="date" name="report_date" id="report_date" required>

                <label for="progress">Progrès:</label>
                <input type="number" name="progress" id="progress" required>

                <label for="comment">Commentaire:</label>
                <textarea name="comment" id="comment" required></textarea>

                <input type="submit" value="Ajouter le Rapport">
            </form>
        </div>

        <!-- Section Alertes -->
        <div id="alerts" class="section">
            <h2>Alertes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Étape</th>
                        <th>Date Limite du Rapport</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($alerts) {
                        foreach ($alerts as $alert) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($alert['step_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($alert['report_date']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Aucune alerte disponible</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Section Diagramme de Gantt -->
        <div id="gantt_chart" class="section">
            <h2>Diagramme de Gantt</h2>
            <canvas id="ganttChart"></canvas>
            <script>
                const ganttData = <?php echo json_encode($ganttData); ?>;
                const ctx = document.getElementById('ganttChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ganttData.map(item => item.project_name + ' - ' + item.step_name),
                        datasets: [{
                            label: 'Durée des Étapes',
                            data: ganttData.map(item => (new Date(item.step_end) - new Date(item.step_start)) / (1000 * 60 * 60 * 24)),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        if (label) {
                                            return label + ': ' + context.raw + ' jours';
                                        }
                                        return context.raw + ' jours';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>

        <!-- Section Calendrier -->
        <div id="calendar" class="section">
            <h2>Calendrier</h2>
            <div id="calendar-container"></div>
            <script>
                // Code JavaScript pour afficher le calendrier
                // Vous pouvez utiliser une bibliothèque comme FullCalendar pour cela
            </script>
        </div>
    </div>
    <script>
    function voirPlus(id) {
        // Ouvrir une nouvelle fenêtre avec les détails des étapes du projet
        var url = 'voir_etapes.php?id=' + encodeURIComponent(id);
        var windowName = 'DetailsEtapes';
        var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

        window.open(url, windowName, windowFeatures);
    }

    function voirPlus2(id) {
        // Ouvrir une nouvelle fenêtre avec les détails des rapports du projet
        var url = 'voir_rapports.php?id=' + encodeURIComponent(id);
        var windowName = 'DetailsRapports';
        var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

        window.open(url, windowName, windowFeatures);
    }
</script>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }

        function showProjectDetails(projectId) {
            document.getElementById('projet_id').value = projectId;
            document.querySelector('form[action=""]').submit();
        }
    </script>
</body>
</html>
