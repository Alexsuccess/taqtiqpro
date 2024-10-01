<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer le code unique depuis la requête GET
$code_unique = isset($_GET['code_unique']) ? $_GET['code_unique'] : '';

// Préparer les requêtes pour récupérer les données
$sql_orders = "SELECT * FROM orders WHERE code_unique = ?";
$sql_formulaire = "SELECT * FROM formulaire_approche_visuelle WHERE code_unique = ?";
$sql_referencestto = "SELECT * FROM referencestto WHERE code_unique = ?";

// Préparer et exécuter les requêtes
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("s", $code_unique);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

$stmt_formulaire = $conn->prepare($sql_formulaire);
$stmt_formulaire->bind_param("s", $code_unique);
$stmt_formulaire->execute();
$result_formulaire = $stmt_formulaire->get_result();

$stmt_referencestto = $conn->prepare($sql_referencestto);
$stmt_referencestto->bind_param("s", $code_unique);
$stmt_referencestto->execute();
$result_referencestto = $stmt_referencestto->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails pour Code Unique <?php echo htmlspecialchars($code_unique); ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Détails pour Code Unique <?php echo htmlspecialchars($code_unique); ?></h2>

    <!-- Table Orders -->
    <h3>Informations générales</h3>
    <table>
        <thead>
<tr>
    <th>Modèle</th>
    <th>Nom</th>
    <th>Pays</th>
    <th>Ville</th>
    <th>Quartier</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date de commande</th>
    <th>Forfait</th>
    <th>Statut</th>
</tr>

        </thead>
        <tbody>
            <?php if ($result_orders->num_rows > 0): ?>
                <?php while ($row = $result_orders->fetch_assoc()): ?>
                    <tr>
                    
                        <td><?php echo htmlspecialchars($row['model']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['country']); ?></td>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><?php echo htmlspecialchars($row['quartier']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['package']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13">Aucune donnée trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Table Formulaire Approche Visuelle -->
    <h3>Formulaire Approche Visuelle</h3>
    <table>
        <thead>
<tr>
    <th>Format de l'en-tête</th>
    <th>Approche visuelle</th>
    <th>Ton</th>
    <th>Affichage des propriétés</th>
    <th>Mini pub</th>
    <th>Logos</th>
    <th>Liste de références</th>
    <th>Annonceurs</th>
    <th>Outils</th>
    <th>Boost</th>
    <th>Afficher l'adresse</th>
    <th>Afficher les contacts</th>
    <th>Afficher les heures</th>
    <th>Infos de l'annonce</th>
    <th>Affichage sur la page d'accueil</th>
    <th>Affichage hebdomadaire</th>
    <th>Créé le</th>
</tr>

        </thead>
        <tbody>
            <?php if ($result_formulaire->num_rows > 0): ?>
                <?php while ($row = $result_formulaire->fetch_assoc()): ?>
                    <tr>
                        
                        <td><?php echo htmlspecialchars($row['headerFormat']); ?></td>
                        <td><?php echo htmlspecialchars($row['visualApproach']); ?></td>
                        <td><?php echo htmlspecialchars($row['tone']); ?></td>
                        <td><?php echo htmlspecialchars($row['propertiesDisplay']); ?></td>
                        <td><?php echo htmlspecialchars($row['miniPub']); ?></td>
                        <td><?php echo htmlspecialchars($row['logos']); ?></td>
                        <td><?php echo htmlspecialchars($row['referenceList']); ?></td>
                        <td><?php echo htmlspecialchars($row['advertisers']); ?></td>
                        <td><?php echo htmlspecialchars($row['tools']); ?></td>
                        <td><?php echo htmlspecialchars($row['boost']); ?></td>
                        <td><?php echo htmlspecialchars($row['showAddress']); ?></td>
                        <td><?php echo htmlspecialchars($row['showContacts']); ?></td>
                        <td><?php echo htmlspecialchars($row['showHours']); ?></td>
                        <td><?php echo htmlspecialchars($row['annonce_info']); ?></td>
                        <td><?php echo htmlspecialchars($row['homepageDisplay']); ?></td>
                        <td><?php echo htmlspecialchars($row['weeklyDisplay']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="19">Aucune donnée trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Table Referencestto -->
    <h3>References</h3>
    <table>
        <thead>
            <tr>

                <th>Catégorie</th>
                <th>Nom</th>
                <th>Contact</th>
                <th>Téléphone</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_referencestto->num_rows > 0): ?>
                <?php while ($row = $result_referencestto->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['categorie']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td><?php echo htmlspecialchars($row['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14">Aucune donnée trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
