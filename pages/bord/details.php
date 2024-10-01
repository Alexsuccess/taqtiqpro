<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur à afficher depuis les paramètres de l'URL
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($userId <= 0) {
    echo "ID utilisateur non valide.";
    exit();
}

// Fonction pour exécuter une requête SQL et récupérer les résultats
function executeSQLQuery($sql, $conn) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur dans la requête SQL: " . $conn->error);
    }
    return $result;
}

// Types de comptes à afficher
$typesComptes = ['client', 'prestataire', 'candidat', 'Entreprise'];

// Requête pour récupérer les destinataires (télévendeurs ou employés)
$sqlDestinataires = "SELECT id, nom, prenom FROM userss WHERE compte IN ('télévendeur', 'Employé', 'Entreprise', 'prestataire')";
$resultDestinataires = executeSQLQuery($sqlDestinataires, $conn);
$destinataires = [];
if ($resultDestinataires->num_rows > 0) {
    while ($row = $resultDestinataires->fetch_assoc()) {
        $destinataires[] = $row;
    }
}

// Vérifier si le formulaire de confier a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['utilisateurs']) && isset($_POST['destinataire'])) {
    // Récupérer les données du formulaire
    $utilisateurs = json_decode($_POST['utilisateurs']);
    $destinataire = intval($_POST['destinataire']);
    $codeutilisateurs = json_decode($_POST['codeutilisateurs']);

    // Préparer la requête pour insérer dans utilisateurs_destinataires
    $sqlInsert = "INSERT INTO utilisateurs_destinataires (id_utilisateur, id_destinataire, codeutilisateur, date_confiance) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($sqlInsert);

    // Exécuter la requête pour chaque utilisateur sélectionné
    foreach ($utilisateurs as $index => $utilisateurId) {
        $utilisateurId = intval($utilisateurId);
        $codeutilisateur = $codeutilisateurs[$index];
        $stmt->bind_param("iis", $utilisateurId, $destinataire, $codeutilisateur);
        $stmt->execute();
    }

    // Vérifier si l'insertion a réussi
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Utilisateurs assignés avec succès !');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'assignation des utilisateurs. Veuillez réessayer plus tard.');</script>";
    }

    // Fermer le statement
    $stmt->close();
}

// Requête SQL pour sélectionner les données des employés de l'entreprise spécifique
$sql = "SELECT ds.*, dd.nom, dd.prenom, dd.compte, dd.statut, dd.help2, ds.codeutilisateur
        FROM formulaire_immigration_session1 AS ds
        LEFT JOIN userss AS dd ON ds.user_id = dd.id
        WHERE dd.id = ? AND ds.codeutilisateur IS NOT NULL";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si des résultats ont été trouvés
if ($result && $result->num_rows > 0) {
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Compétences Candidats</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <style>
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }
            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }
            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body style="background-image: url(yyy.avif);" class="container my-5">
        <h2 class="mb-4">Compétences Candidats</h2>
        <table style="background-color: white;" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Agence</th>
                    <th>Nom Complet</th>
                    <th>Prénom</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Expérience</th>
                    <th>Photo</th>
                    <th>Actions</th>

                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nom']); ?> <?php echo htmlspecialchars($row['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['preno']); ?></td>
                    <td><?php echo htmlspecialchars($row['country']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['experience']); ?></td>
                    <td><img style="width: 60px; height: 60px;" src="../../uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo"></td>
                    <td>
                        <input type='checkbox' class='confier-checkbox' data-user-id='<?php echo $row["user_id"]; ?>' data-codeutilisateur='<?php echo $row["codeutilisateur"]; ?>' name="confier[]">
                    
                    </td>

                    <td>
                        
                         <button class="btn btn-secondary" type="button" onclick="voirPlus('<?php echo $row['codeutilisateur']; ?>')">Voir plus</button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <!-- Modal pour confier l'utilisateur -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-body">
                    <h2>Assigner à:</h2>
                    <form id="confierForm" method="post">
                        <input type="hidden" id="utilisateursSelectionnes" name="utilisateurs">
                        <input type="hidden" id="codeUtilisateursSelectionnes" name="codeutilisateurs">
                        <select id="destinataire" name="destinataire" class="form-control">
                            <option value="">Choisir un destinataire</option>
                            <?php foreach ($destinataires as $destinataire) : ?>
                                <option value="<?php echo htmlspecialchars($destinataire['id']); ?>"><?php echo htmlspecialchars($destinataire['nom'] . ' ' . $destinataire['prenom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary">Confier</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Scripts JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
$('.table').DataTable();

            // Script pour le modal
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];

            function showModal() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Script pour afficher le modal quand une case est cochée
            $('.confier-checkbox').on('change', function() {
                var selectedUsers = [];
                var selectedCodes = [];
                $('.confier-checkbox:checked').each(function() {
                    selectedUsers.push($(this).data('user-id'));
                    selectedCodes.push($(this).data('codeutilisateur'));
                });

                if (selectedUsers.length > 0) {
                    $('#utilisateursSelectionnes').val(JSON.stringify(selectedUsers));
                    $('#codeUtilisateursSelectionnes').val(JSON.stringify(selectedCodes));
                    showModal();
                }
            });
        });

        function voirPlus(codeutilisateur) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'voir_pluss.php?codeutilisateur=' + codeutilisateur;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
    </script>
</body>
</html>

<?php
} else {
echo "Aucun résultat trouvé.";
}

// Fermer la connexion à la base de données
$conn->close();
?>