<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Projets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hidden {
            display: none;
        }

        .menu-button {
            margin: 10px;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center my-4">
            <button class="btn btn-primary menu-button" onclick="showSection('enregistrer')">Enregistrer un projet</button>
            <button class="btn btn-primary menu-button" onclick="showSection('lister')">Lister les projets</button>
            <button class="btn btn-primary menu-button" onclick="showSection('suivit')">Suivi, évaluation des projets</button>
            <button class="btn btn-primary menu-button" onclick="showSection('afficher_suivit')">Afficher les suivis des projets</button>
            <button class="btn btn-primary menu-button" onclick="showSection('diagrams')">Diagrammes des projets</button>
        </div>

        <!-- Section Enregistrer un projet -->
        <div id="enregistrer" class="card">
            <div class="card-header">
                <h2 class="form-title">Enregistrer un projet</h2>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nom">Nom du projet</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lieu">Lieu</label>
                        <textarea class="form-control" id="lieu" name="lieu" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="workforce">Nombre de main d'oruvre sollicité</label>
                        <input type="number" class="form-control" id="workforce" name="workforce" required>
                    </div>
                    <div class="form-group">
                        <label for="contract_type">Type de contrat</label>
                        <select class="form-control" id="contract_type" name="contract_type" required>
                            <option value="saisonnier">Saisonnier</option>
                            <option value="temporaire">Temporaire</option>
                            <option value="permanent">Permanent</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="languages_spoken">Langues parlées</label>
                        <input type="text" class="form-control" id="languages_spoken" name="languages_spoken" required>
                    </div>
                    <div class="form-group">
                        <label for="languages_written">Langues écrites</label>
                        <input type="text" class="form-control" id="languages_written" name="languages_written" required>
                    </div>
                    <div class="form-group">
                        <label for="exigences">Exigences</label>
                        <textarea class="form-control" id="exigences" name="exigences" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_debut">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                    </div>
                    <div class="form-group">
                        <label for="date_fin">Date de fin</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                    </div>
                    <button type="submit" name="save_project" class="btn btn-primary">Enregistrer le projet</button>
                </form>
            </div>
        </div>

        <!-- Section Lister les projets -->
        <div id="lister" class="card hidden">
            <div class="card-header">
                <h2 class="form-title">Liste des projets</h2>
            </div>
            <div style="margin-left: -1%;" class="card-body">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom du projet</th>
            <th>Description</th>
            <th>Lieu</th>
            <th>Nbre de main d'oeuvre</th>
            <th>Type de contrat</th>
            <th>Langues parlées</th>
            <th>Langues écrites</th>
            <th>Exigences</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Changement du statut
if (isset($_POST['toggle_id'])) {
    $toggleId = $_POST['toggle_id'];

    // Récupérer le statut actuel
    $result = $conn->query("SELECT statut FROM projets4 WHERE id = $toggleId");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newStatut = ($row['statut'] == 1) ? 0 : 1;

        // Mettre à jour le statut
        if ($conn->query("UPDATE projets4 SET statut = $newStatut WHERE id = $toggleId")) {
            echo "Le statut du projet a été mis à jour.";
        } else {
            echo "Erreur lors de la mise à jour du statut.";
        }
    }
}

// Enregistrement d'un nouveau projet
if (isset($_POST['save_project'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $lieu = $_POST['lieu'];
    $workforce = $_POST['workforce'];
    $contract_type = $_POST['contract_type'];
    $languages_spoken = $_POST['languages_spoken'];
    $languages_written = $_POST['languages_written'];
    $exigences = $_POST['exigences'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    
    $sql = "INSERT INTO projets4 (nom, description, lieu, workforce, contract_type, languages_spoken, languages_written, exigences, date_debut, date_fin, user_id, statut, date_enregistrement) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1', now())";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssssi", $nom, $description, $lieu, $workforce, $contract_type, $languages_spoken, $languages_written, $exigences, $date_debut, $date_fin, $userid);
        
        if ($stmt->execute()) {
            echo "Le projet a été enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement du projet : " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
}

// Récupération des projets
$result = $conn->query("SELECT * FROM projets4");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nom'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['lieu'] . "</td>";
        echo "<td>" . $row['workforce'] . "</td>";
        echo "<td>" . $row['contract_type'] . "</td>";
        echo "<td>" . $row['languages_spoken'] . "</td>";
        echo "<td>" . $row['languages_written'] . "</td>";
        echo "<td>" . $row['exigences'] . "</td>";
        echo "<td>" . $row['date_debut'] . "</td>";
        echo "<td>" . $row['date_fin'] . "</td>";
        echo "<td>" . ($row['statut'] == 1 ? "Activé" : "Désactivé") . "</td>";
        echo "<td>" . $row['date_enregistrement'] . "</td>";
        echo "<td>
                <form method='POST'>
                    <input type='hidden' name='toggle_id' value='" . $row['id'] . "'>
                    <button type='submit' class='btn btn-primary'>" . ($row['statut'] == 1 ? "Désactiver" : "Activer") . "</button>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>Aucun projet trouvé</td></tr>";
}

$conn->close();
?>
    </tbody>
</table>

            </div>
        </div>

        <!-- Section Suivi, évaluation et évaluation des projets -->
        <div id="suivit" class="card hidden">
            <div class="card-header">
                <h2 class="form-title">Suivi, évaluation et évaluation des projets</h2>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="project_id">Sélectionner un projet</label>
                        <select class="form-control" id="project_id" name="project_id" required>
                            <option value="">Choisir un projet</option>
                            <?php
                            // Connexion à la base de données
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, nom FROM projets4";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                }
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comments">Commentaires</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Évaluation</label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="">Choisir une évaluation</option>
                            <option value="1">1 - Très mauvais</option>
                            <option value="2">2 - Mauvais</option>
                            <option value="3">3 - Moyen</option>
                            <option value="4">4 - Bon</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <button type="submit" name="save_suivit" class="btn btn-primary">Enregistrer le suivi</button>
                </form>
            </div>
        </div>

        <!-- Section Afficher les suivis des projets -->
        <div id="afficher_suivit" class="card hidden">
            <div class="card-header">
                <h2 class="form-title">Afficher les suivis des projets</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID du projet</th>
                            <th>Commentaires</th>
                            <th>Évaluation</th>
                            <th>Date d'enregistrement</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérez l'ID de l'utilisateur
$userid = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

                        // Enregistrement d'un suivi
                        if (isset($_POST['save_suivit'])) {
                            $project_id = $_POST['project_id'];
                            $comments = $_POST['comments'];
                            $rating = $_POST['rating'];

$sql = "INSERT INTO suivit_projets (project_id, comments, rating, user_id, date_enregistrement) VALUES (?, ?, ?, ?, now())";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("issi", $project_id, $comments, $rating, $userid);

    if ($stmt->execute()) {
        echo "Le suivi du projet a été enregistré avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement du suivi du projet : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erreur de préparation de la requête : " . $conn->error;
}
                        }

                        // Récupération des suivis des projets
                        $result = $conn->query("SELECT * FROM suivit_projets as dd left join projets4 as yy on yy.id=dd.project_id where dd.user_id = $userid");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['nom'] . "</td>";
                                echo "<td>" . $row['comments'] . "</td>";
                                echo "<td>" . $row['rating'] . "</td>";
                                echo "<td>" . $row['date_enregistrement'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun suivi trouvé</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section Diagrammes des projets -->
        <div id="diagrams" class="card hidden">
            <div class="card-header">
                <h2 class="form-title">Diagrammes des projets</h2>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.card').forEach(card => {
                card.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const ctxBar = document.getElementById('barChart').getContext('2d');
            const ctxPie = document.getElementById('pieChart').getContext('2d');

            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: data.projects,
                            datasets: [{
                                label: 'Évaluation des projets',
                                data: data.ratings,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: data.projects,
                            datasets: [{
                                label: 'Répartition des évaluations',
                                data: data.ratings,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        }
                    });
                });
        });
    </script>
</body>

</html>
