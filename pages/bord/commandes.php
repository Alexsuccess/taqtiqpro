<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
// Activer les rapports d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si le formulaire de mise à jour du statut a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $newStatus = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($orderId > 0 && !empty($newStatus)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);

        if ($stmt->execute()) {
            echo "Statut mis à jour avec succès.";
            // Vérifier si le nouveau statut est "validée"
            if ($newStatus === 'validée') {
                // Récupérer l'email de l'utilisateur
                $emailResult = $conn->query("SELECT email FROM orders WHERE id = $orderId");
                $emailRow = $emailResult->fetch_assoc();
                $email = $emailRow['email'];
                
                // Générer le lien mailto
                $subject = "Commande validée";
                $body = "Bonjour,\n\nVotre commande a été validée.\n\nCordialement,\nVotre équipe.";
                echo "<script>
                    var mailtoLink = 'mailto:$email?subject=' + encodeURIComponent('$subject') + '&body=' + encodeURIComponent('$body');
                    window.location.href = mailtoLink;
                </script>";
            }
        } else {
            echo "Erreur: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Données invalides.";
    }
}

// Gestion de la recherche
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
}

// Récupérer les commandes de la base de données
$sql = "SELECT dd.*, accompagnant.nom AS user_nom, accompagnant.prenom AS user_prenom 
        FROM orders AS dd 
        LEFT JOIN userss utilisateur ON utilisateur.id = dd.user_id
        LEFT JOIN userss accompagnant ON accompagnant.id = utilisateur.accompanied_by";

if (!empty($searchQuery)) {
    $searchQuery = $conn->real_escape_string($searchQuery); // Sécuriser la requête
    $sql .= " WHERE model LIKE '%$searchQuery%' OR ff.nom LIKE '%$searchQuery%' OR country LIKE '%$searchQuery%' OR city LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR package LIKE '%$searchQuery%'";
}

$result = $conn->query($sql);

// Récupérer les statistiques des commandes
$stats = [
    'total' => $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'],
    'en_attente' => $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'en attente'")->fetch_assoc()['count'],
    'validee' => $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'validée'")->fetch_assoc()['count'],
    'livree' => $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'livrée'")->fetch_assoc()['count'],
    'supprimee' => $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'supprimée'")->fetch_assoc()['count'],
];

$conn->close();
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table thead th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Gestion des Commandes</h2>

    <form class="form-inline mb-4" method="get" action="#">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Assignation</th>
                <th>Modèle</th>
                <th>Package</th>
                <th>Nom</th>
                <th>Pays</th>
                <th>Ville</th>
                <th>Quartier</th>
                <th>Email</th>
                <th>Message</th>
                <th>Statut</th>
                <th>Action</th>
                <th>Voir plus</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_nom'] ?? ''); ?> <?php echo htmlspecialchars($row['user_prenom'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['model'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['package'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['country'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['city'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['quartier'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['message'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['status'] ?? ''); ?></td>
                        <td>
                            <form id="updateStatusForm-<?php echo $row['id']; ?>" method="post" action="">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <select name="status" class="form-control status-select" data-email="<?php echo htmlspecialchars($row['email'] ?? ''); ?>" data-name="<?php echo htmlspecialchars($row['name'] ?? ''); ?>">
                                        <option value="en attente" <?php if ($row['status'] == 'en attente') echo 'selected'; ?>>En attente</option>
                                        <option value="validée" <?php if ($row['status'] == 'validée') echo 'selected'; ?>>Validée</option>
                                        <option value="livrée" <?php if ($row['status'] == 'livrée') echo 'selected'; ?>>Livrée</option>
                                        <option value="supprimée" <?php if ($row['status'] == 'supprimée') echo 'selected'; ?>>Supprimée</option>
                                    </select>
                                </div>
                                <button type="submit" name="update_status" class="btn btn-primary">Mettre à jour</button>
                            </form>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="voirPlus('<?php echo htmlspecialchars($row['code_unique']); ?>');" class="btn btn-info">Références</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">Aucune commande trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <p style="background-color: blue; color: white; width: 20%;">Total des commandes: <?php echo $stats['total']; ?></p>
        <p style="background-color: orange; color: white; width: 20%;">Commandes en attente: <?php echo $stats['en_attente']; ?></p>
        <p style="background-color: green; color: white; width: 20%;">Commandes validées: <?php echo $stats['validee']; ?></p>
        <p style="background-color: black; color: white; width: 20%;">Commandes livrées: <?php echo $stats['livree']; ?></p>
        <p style="background-color: red; color: white; width: 20%;">Commandes supprimées: <?php echo $stats['supprimee']; ?></p>
    </div>
</div>

<script>
function voirPlus(code_unique) {
    window.open("voir_plus11.php?code_unique=" + encodeURIComponent(code_unique), "VoirPlusWindow", "width=800,height=600,scrollbars=yes,resizable=yes");
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
