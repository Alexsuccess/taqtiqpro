    <?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['user_id'];

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

// Requête SQL pour récupérer les commandes et les informations des utilisateurs
$sql = "SELECT orders50.nom AS nom_commande, orders50.prenom AS prenom_commande, orders50.moyen_paiement, orders50.livraison, orders50.pays AS pays_commande, 
               orders50.ville AS ville_commande, orders50.email AS email_commande, orders50.total, orders50.created_at AS date_commande,
               Users.name AS nom_utilisateur, Users.prenom AS prenom_utilisateur, Users.telephone, Users.pays AS pays_utilisateur, Users.ville AS ville_utilisateur, Users.email AS email_utilisateur
        FROM orders50
        LEFT JOIN Users ON orders50.user_id = Users.id
        ORDER BY orders50.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Liste des Commandes et Informations Utilisateur</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table style="margin-left: -20%;" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nom Client</th>
                    <th>Prénom Client</th>
                    <th>Moyen Paiement</th>
                    <th>Livraison</th>
                    <th>Pays Client</th>
                    <th>Ville Client</th>
                    <th>Email Client</th>
                    <th>Total</th>
                    <th>Date de Commande</th>
                    <th>Nom Ambassadeur</th>
                    <th>Prénom Ambassadeur</th>
                    <th>Téléphone Ambassadeur</th>
                    <th>Pays Ambassadeur</th>
                    <th>Ville Ambassadeur</th>
                    <th>Email Ambassadeur</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['moyen_paiement']); ?></td>
                        <td><?php echo htmlspecialchars($row['livraison']); ?></td>
                        <td><?php echo htmlspecialchars($row['pays_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['ville_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['email_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['total']); ?> FCFA</td>
                        <td><?php echo htmlspecialchars($row['date_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($row['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($row['pays_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($row['ville_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($row['email_utilisateur']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Aucune commande trouvée.</p>
    <?php endif; ?>

</div>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
