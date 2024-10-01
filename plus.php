<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'identifiant du personnel depuis l'URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Requête pour obtenir les détails du personnel
$sql = "SELECT * FROM userss WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Aucun enregistrement trouvé.";
    exit();
}

$conn->close();

// Fonction pour éviter les erreurs liées aux valeurs nulles
function safe_htmlspecialchars($value) {
    return htmlspecialchars($value !== null ? $value : '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du Personnel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 10px;
        }
        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-info {
            width: 100%;
        }
        .profile-info h5 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info .row > div {
            margin-bottom: 10px;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="profile-card">
                <img src="uploads/<?php echo !empty($row['profile_pic']) ? safe_htmlspecialchars($row['profile_pic']) : 'https://via.placeholder.com/150'; ?>" alt="Profile Image">
                <h5><?php echo safe_htmlspecialchars($row['nom']) . ' ' . safe_htmlspecialchars($row['prenom']); ?></h5>
                <div class="profile-info">
                    <div class="row">
                        <div class="col-6 font-weight-bold">Identifiant du personnel</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['id']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Rôle</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['prof']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Poste</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['poste']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Département</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['dep']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Compétences</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['Competences']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Code</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['codee']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Profession</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['Profession']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Localisation</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['Localisation']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Date de création</div>
                        <div class="col-6"><?php echo safe_htmlspecialchars($row['date_creation']); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pay-tab" data-toggle="tab" href="#pay" role="tab" aria-controls="pay" aria-selected="false">Paie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="leaves-tab" data-toggle="tab" href="#leaves" role="tab" aria-controls="leaves" aria-selected="false">Feuilles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">Présence du personnel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Chronologie</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">Téléphone</th>
                                    <td><?php echo safe_htmlspecialchars($row['telephone']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail</th>
                                    <td><?php echo safe_htmlspecialchars($row['email']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Pays</th>
                                    <td><?php echo safe_htmlspecialchars($row['pays']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Ville</th>
                                    <td><?php echo safe_htmlspecialchars($row['Ville']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nom de l'entreprise</th>
                                    <td><?php echo safe_htmlspecialchars($row['nom_entreprise']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Raison sociale</th>
                                    <td><?php echo safe_htmlspecialchars($row['raison_sociale']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Service proposé</th>
                                    <td><?php echo safe_htmlspecialchars($row['service_propose']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Zone de couverture</th>
                                    <td><?php echo safe_htmlspecialchars($row['zone_couverture']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Stratégie marketing</th>
                                    <td><?php echo safe_htmlspecialchars($row['strategie_marketing']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Éducation</th>
                                    <td><?php echo safe_htmlspecialchars($row['Education']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Aide</th>
                                    <td><?php echo safe_htmlspecialchars($row['help']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Aide 2</th>
                                    <td><?php echo safe_htmlspecialchars($row['help2']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Personne accompagnante</th>
                                    <td><?php echo safe_htmlspecialchars($row['accompagnant_id']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Accompagné par</th>
                                    <td><?php echo safe_htmlspecialchars($row['accompanied_by']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pay" role="tabpanel" aria-labelledby="pay-tab">
                    <!-- Contenu pour la section Paiement -->
                </div>
                <div class="tab-pane fade" id="leaves" role="tabpanel" aria-labelledby="leaves-tab">
                    <!-- Contenu pour la section Feuilles -->
                </div>
                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                    <!-- Contenu pour la section Présence du personnel -->
                </div>
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    <!-- Contenu pour la section Documents -->
                </div>
                <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <!-- Contenu pour la section Chronologie -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
