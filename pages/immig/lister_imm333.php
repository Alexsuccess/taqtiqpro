
<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['id'];

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

// Fonction pour générer une chaîne aléatoire
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Vérifier l'action POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actionn'])) {
    $id = $_POST['id'];
    $action = $_POST['actionn'];

    if ($action == 'toggle') {
        if (isset($_POST['current_status'])) {
            $current_status = $_POST['current_status'];
            $new_status = $current_status == 1 ? 0 : 1;
            $sql = "UPDATE userss SET statut = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $new_status, $id);
            if (!$stmt->execute()) {
                echo "Erreur lors de la mise à jour du statut : " . $conn->error;
            }
        } else {
            echo "Paramètres manquants pour l'action 'toggle'.";
        }
    } elseif ($action == 'delete') {
        try {
            $conn->begin_transaction();

            $sql1 = "DELETE FROM userss WHERE id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $stmt1->execute();

            $sql2 = "DELETE FROM formulaire_immigration_session1 WHERE user_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } elseif ($action == 'generate_code') {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $code = generateRandomString(8);
            $sql = "UPDATE userss SET help = 'validé', help2 = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $code, $email);
            if (!$stmt->execute()) {
                echo "Erreur lors de la génération du code : " . $conn->error;
            }
        } else {
            echo "Email manquant pour 'generate_code'.";
        }
    } elseif ($action == 'valider') {
        $sql = "UPDATE formulaire_immigration_session1 SET statutk = 'validé' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action == 'payer') {
        $sql = "UPDATE formulaire_immigration_session1 SET statut_paiement = 'payé' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action == 'debut') {
        $sql = "UPDATE formulaire_immigration_session1 SET statut_procedure = 'en cours' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } else {
        echo "Action non reconnue : " . htmlspecialchars($action);
    }
}

// Requête SQL pour sélectionner les données
$sql = "SELECT ds.*, ds.full_name, ds.preno, ds.email, ds.codeutilisateur, ds.phone, ds.country, ds.city, dd.statut, dd.help2, ds.user_id FROM formulaire_immigration_session1 AS ds LEFT JOIN userss AS dd ON dd.id = ds.user_id WHERE ds.user_id = $userId AND ds.codeutilisateur IS NOT NULL";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Immigration - Sessions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th {
            background-color: #343a40;
            color: white;
        }
        .action-buttons button {
            margin-right: 5px;
        }
    </style>
</head>
<body class="container my-5">
    <h2 class="mb-4">Compétences Candidats</h2>

    <button class="btn btn-success" onclick="window.location.href='agence.php?page=<?php echo base64_encode('pages/immig/ajout7'); ?>';">Ajouter</button>

    <table class="table table-bordered table-hover" style="margin-top: 3%;">
        <thead class="thead-light">
            <tr>
                <th>Nom Complet</th>
                <th>Prenom</th>
                <th>Pays</th>
                <th>Ville</th>
                <th>Email</th>
                <th>Téléphone</th>
                    <th>Expérience</th>
                    <th>Photo</th>
                <th>Statut</th>
                <th>Etat</th>
                <th>Procedure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['preno']); ?></td>
                    <td><?php echo htmlspecialchars($row['country']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['experience']); ?></td>
                        <td><img style="width: 60px; height: 60px;" src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo"></td>
<td>
    <?php if ($row['statutk'] == 'validé'): ?>
        <span class="text-success font-weight-bold">Validé</span>
    <?php else: ?>
        <span class="text-danger font-weight-bold">Non validé</span>
    <?php endif; ?>
</td>

<td>
    <?php if ($row['statut_paiement'] == 'payé'): ?>
        <span class="text-success font-weight-bold">Payé</span>
    <?php else: ?>
        <span class="text-danger font-weight-bold">Non payé</span>
    <?php endif; ?>
</td>

<td>
    <?php if ($row['statut_procedure'] == 'en cours'): ?>
        <span class="text-success font-weight-bold">En cours</span>
    <?php else: ?>
        <span class="text-danger font-weight-bold">Non en cours</span>
    <?php endif; ?>
</td>
                    <td class="action-buttons">
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <input type="hidden" name="codeutilisateur" value="<?php echo $row['codeutilisateur']; ?>">
                            <button class="btn btn-success" type="submit" name="actionn" value="valider">Valider</button>
                            <button class="btn btn-warning" type="submit" name="actionn" value="payer">Payer</button>
                            <button class="btn btn-info" type="submit" name="actionn" value="debut">Procédure</button>
                                <button class="btn btn-secondary" type="button" onclick="voirPlus('<?php echo $row['codeutilisateur']; ?>')">Voir plus</button>
                                <button class="btn btn-primary" type="button" onclick="modifierUtilisateur('<?php echo $row['codeutilisateur']; ?>')">Modifier</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php $conn->close(); ?>

<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des candidats et de leurs documents
$sql = "SELECT c.nom, c.prenom, c.email, c.sexe, c.pays, c.code, c.id, c.prof,
        d.diplome, d.passeport, d.certificat_naissance, d.certificat_scolarite, d.mandat_representation, c.statutx, c.statut_paiement, c.statut_procedure
        FROM candidats c
        LEFT JOIN documentss d ON c.code = d.code 
        WHERE c.user_id = $userId";
$result = $conn->query($sql);

// Traitement des actions du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'valider') {
        // Action pour valider le statut
        $sql = "UPDATE candidats SET statutx = 'validé' WHERE id = $id";
        $conn->query($sql);
    } elseif ($action == 'payer') {
        // Action pour mettre à jour le statut de paiement
        $sql = "UPDATE candidats SET statut_paiement = 'payé' WHERE id = $id";
        $conn->query($sql);
    } elseif ($action == 'debut') {
        // Action pour démarrer la procédure
        $sql = "UPDATE candidats SET statut_procedure = 'en cours' WHERE id = $id";
        $conn->query($sql);
    }
}

$conn->close();
?>

<style>
    .table th {
        background-color: #343a40;
        color: white;
    }
</style>

<div>
    <table style="margin-top: 3%;" class="table table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Pays</th>
                <th>Profession</th>
                <th>Diplôme</th>
                <th>Passeport</th>
                <th>Certificat de Naissance</th>
                <th>Certificat de Scolarité</th>
                <th>Mandat de Représentation</th>
                <th>Statut</th>
                <th>Etat</th>
                <th>Procedure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["sexe"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["pays"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["prof"]) . "</td>";
        echo "<td>" . (!empty($row["diplome"]) ? 'Présent' : 'Non Présent') . "</td>";
        echo "<td>" . (!empty($row["passeport"]) ? 'Présent' : 'Non Présent') . "</td>";
        echo "<td>" . (!empty($row["certificat_naissance"]) ? 'Présent' : 'Non Présent') . "</td>";
        echo "<td>" . (!empty($row["certificat_scolarite"]) ? 'Présent' : 'Non Présent') . "</td>";
        echo "<td>" . (!empty($row["mandat_representation"]) ? 'Présent' : 'Non Présent') . "</td>";

        // Affichage du statutk
        echo "<td>";
        if ($row['statutx'] == 'validé') {
            echo "<span class='text-success font-weight-bold'>Validé</span>";
        } else {
            echo "<span class='text-danger font-weight-bold'>Non validé</span>";
        }
        echo "</td>";

        // Affichage du statut_paiement
        echo "<td>";
        if ($row['statut_paiement'] == 'payé') {
            echo "<span class='text-success font-weight-bold'>Payé</span>";
        } else {
            echo "<span class='text-danger font-weight-bold'>Non payé</span>";
        }
        echo "</td>";

        // Affichage du statut_procedure
        echo "<td>";
        if ($row['statut_procedure'] == 'en cours') {
            echo "<span class='text-success font-weight-bold'>En cours</span>";
        } else {
            echo "<span class='text-danger font-weight-bold'>Non en cours</span>";
        }
        echo "</td>";

        // Boutons d'action
        echo "<td class='action-buttons'>";
        echo "<form action='' method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<button class='btn btn-success' type='submit' name='action' value='valider'>Valider</button>";
        echo "</form>";

        echo "<form action='' method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<button class='btn btn-warning' type='submit' name='action' value='payer'>Payer</button>";
        echo "</form>";

        echo "<form action='' method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<button class='btn btn-info' type='submit' name='action' value='debut'>Procédure</button>";
        echo "</form>";

                                echo "<button class='btn btn-primary' onclick=\"voirPlus8('" . $row['code'] . "')\">Voir plus</button>";

                              echo "<button class='btn btn-primary' onclick=\"modifierCandidat('" . $row['code'] . "')\">Modifier</button>";
                            echo "</td>";
        echo "</td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>Aucun candidat trouvé.</td></tr>";
}
?>

        </tbody>
    </table>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        function voirPlus(codeutilisateur) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'voir_pluss.php?codeutilisateur=' + codeutilisateur;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }

        function modifierUtilisateur(codeutilisateur) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'modif10.php?codeutilisateur=' + codeutilisateur;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }

            // Fonction pour voir plus de détails
            window.voirPlus8 = function(code) {
                var url = 'pages/bord/voir_voir_plus.php?code=' + encodeURIComponent(code);
                var newWindow = window.open(url, '_blank', 'width=800,height=600');
                newWindow.focus();
            };

            window.modifierCandidat = function(code) {
                var url = 'pages/bord/modif20.php?code=' + encodeURIComponent(code);
                var newWindow = window.open(url, '_blank', 'width=800,height=600');
                newWindow.focus();
            };
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
