<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Vérifier que l'utilisateur est bien connecté
if ($userId === null) {
    die("Erreur : L'utilisateur n'est pas connecté.");
}

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

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT u.id, u.nom, u.prenom, u.email, u.Profession, c1.Nom AS competence_nom, c1.prenom AS competence_prenom, 
               c1.pays AS competence_pays, c2.skillTitle, c2.description, c2.references, u.Localisation, u.Education, 
               u.Competences, u.profile_pic, u.compte
        FROM userss u
        LEFT JOIN competence12 c1 ON u.id = c1.user_id
        LEFT JOIN competence21 c2 ON u.id = c2.user_id
        WHERE u.compte = 'Client'";

if (!empty($search)) {
    $sql .= " AND c2.skillTitle LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result = $conn->query($sql);

// Traitement du formulaire
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_embauche = isset($_POST['date_embauche']) ? $conn->real_escape_string($_POST['date_embauche']) : '';
    $pays = isset($_POST['pays']) ? $conn->real_escape_string($_POST['pays']) : '';
    $ville = isset($_POST['ville']) ? $conn->real_escape_string($_POST['ville']) : '';
    $exigences = isset($_POST['exigences']) ? $conn->real_escape_string($_POST['exigences']) : '';
    $selected_candidates = isset($_POST['selected_candidates']) ? $_POST['selected_candidates'] : '';
    $project_id = isset($_POST['project_id']) ? $conn->real_escape_string($_POST['project_id']) : '';

    $candidate_ids = explode(',', $selected_candidates);
    $stmt = $conn->prepare("INSERT INTO commandes412 (date_embauche, pays, ville, exigences, candidate_id, user_id, project_id, datee) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $check_stmt = $conn->prepare("SELECT id FROM userss WHERE id = ?");

    $success = true;
    foreach ($candidate_ids as $candidate_id) {
        $check_stmt->bind_param("i", $candidate_id);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $stmt->bind_param("ssssiii", $date_embauche, $pays, $ville, $exigences, $candidate_id, $userId, $project_id);
            if (!$stmt->execute()) {
                $success = false;
                $response['status'] = 'error';
                $response['message'] = "Erreur lors de l'insertion pour le candidat ID " . htmlspecialchars($candidate_id) . ": " . $stmt->error;
                break;
            }
        } else {
            $success = false;
            $response['status'] = 'error';
            $response['message'] = "Le candidat avec l'ID " . htmlspecialchars($candidate_id) . " n'existe pas.";
            break;
        }
    }

    if ($success) {
        $response['status'] = 'success';
        $response['message'] = "Votre enregistrement a été validé. Vous serez contacté par email à wisework@gmail.com.";
    }

    $check_stmt->close();
    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Contenu Dynamique</title>
    <!-- Liens vers Bootstrap et FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Contenu Principal -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <input type="text" id="searchInput" placeholder="Rechercher une profession" onkeyup="filterResults()">
            </div>
        </div>
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            ' . htmlspecialchars($row['Profession'] ?? '') . '
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>' . htmlspecialchars($row['prenom'] ?? '') . ' ' . htmlspecialchars($row['nom'] ?? '') . '</b></h2>
                    <p class="text-muted text-sm"><b>About: </b>' . htmlspecialchars($row['skillTitle'] ?? '') . '</p>
                    <p class="text-muted text-sm"><b>References: </b>' . htmlspecialchars($row['references'] ?? '') . '</p>
                    <p class="text-muted text-sm"><b>Localisation: </b>' . htmlspecialchars($row['Localisation'] ?? '') . '</p>
                    <p class="text-muted text-sm"><b>Education: </b>' . htmlspecialchars($row['Education'] ?? '') . '</p>
                    <p class="text-muted text-sm"><b>Profession: </b>' . htmlspecialchars($row['Profession'] ?? '') . '</p>
                    <p class="text-muted text-sm"><b>Description: </b>' . htmlspecialchars($row['description'] ?? '') . '</p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: wisework@gmail.com</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:  (+237) 697978793</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="https://admin.izishope.com/uploads/' . htmlspecialchars($row['profile_pic'] ?? '') . '" alt="user-avatar" class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
            </div>
        </div>
         <input type="checkbox" name="candidates[]" value="' . htmlspecialchars($row["id"] ?? '') . '"> Sélectionner
    </div>
</div>';
                        }
                    } else {
                        echo '<p>Aucun utilisateur trouvé</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Commande Button -->
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commandeModal">Confier un projet</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="commandeModal" tabindex="-1" role="dialog" aria-labelledby="commandeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commandeModalLabel">Confier un projet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="commandeForm">
                        <div class="form-group">
                            <label for="date_embauche">Date d'embauche</label>
                            <input type="date" class="form-control" id="date_embauche" name="date_embauche" required>
                        </div>
                        <div class="form-group">
                            <label for="pays">Pays</label>
                            <input type="text" class="form-control" id="pays" name="pays" required>
                        </div>
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" required>
                        </div>
                        <div class="form-group">
                            <label for="exigences">Exigences</label>
                            <textarea class="form-control" id="exigences" name="exigences" rows="3" required></textarea>
                        </div>
                        <input type="hidden" id="selected_candidates" name="selected_candidates">
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

                        
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liens vers les scripts JavaScript nécessaires -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#commandeForm').submit(function (e) {
                e.preventDefault();
                var selectedCandidates = [];
                $('input[name="candidates[]"]:checked').each(function () {
                    selectedCandidates.push($(this).val());
                });
                $('#selected_candidates').val(selectedCandidates.join(','));

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        var jsonData = JSON.parse(response);

                        if (jsonData.status === "success") {
                            alert(jsonData.message);
                        } else {
                            alert(jsonData.message);
                        }
                    },
                    error: function () {
                        alert("Erreur lors de l'envoi de la commande. Veuillez réessayer.");
                    }
                });
            });
        });

        function filterResults() {
            var input, filter, cards, cardContainer, title, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cardContainer = document.getElementById("cards-container");
            cards = cardContainer.getElementsByClassName("card");

            for (i = 0; i < cards.length; i++) {
                title = cards[i].querySelector(".card-body .lead b");
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    cards[i].parentElement.style.display = "";
                } else {
                    cards[i].parentElement.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
