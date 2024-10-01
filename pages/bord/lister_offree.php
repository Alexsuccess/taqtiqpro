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

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Gérer les actions (activation, mise en attente, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $offreId = $_POST['offre_id'];

    if ($action == 'activer') {
        $sql = "UPDATE offres_emploi SET statut = '1' WHERE id = ?";
    } elseif ($action == 'mettre_en_attente') {
        $sql = "UPDATE offres_emploi SET statut = '0' WHERE id = ?";
    } elseif ($action == 'supprimer') {
        $sql = "DELETE FROM offres_emploi WHERE id = ?";
    }

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $offreId);
        $stmt->execute();
        $stmt->close();
    }
}

// Récupérer les offres d'emploi
$sql = "SELECT * FROM offres_emploi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Offres d'Emploi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .card-body {
            padding: 20px;
        }
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #ced4da;
        }
        .btn-activate {
            background-color: #28a745;
            color: white;
        }
        .btn-wait {
            background-color: #ffc107;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-5">Liste des Offres d'Emploi</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-header">
                    <?php echo htmlspecialchars($row['titre']); ?>
                </div>
                <div class="card-body">
                    <p><strong>Pays :</strong> <?php echo htmlspecialchars($row['pays']); ?></p>
                    <p><strong>Ville :</strong> <?php echo htmlspecialchars($row['ville']); ?></p>
                    <p><strong>Localisation :</strong> <?php echo htmlspecialchars($row['localisation']); ?></p>
                    <p><strong>Salaire :</strong> <?php echo number_format($row['salaire'], 2, ',', ' '); ?> FCFA</p>
                    <p><strong>Nombre de postes :</strong> <?php echo htmlspecialchars($row['nombre_poste']); ?></p>
                    <p><strong>Type de contrat :</strong> <?php echo htmlspecialchars($row['type_contrat']); ?></p>
                    <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                </div>
                <div class="card-footer text-right">
                    <form method="POST" action="">
                        <input type="hidden" name="offre_id" value="<?php echo $row['id']; ?>">
                        <?php if ($row['statut'] == '0'): ?>
                            <span class="badge badge-warning">En attente</span>
                            <button type="submit" name="action" value="activer" class="btn btn-activate">Activer</button>
                        <?php else: ?>
                            <span class="badge badge-success">Activé</span>
                            <button type="submit" name="action" value="mettre_en_attente" class="btn btn-wait">Mettre en attente</button>
                        <?php endif; ?>
                        <button type="submit" name="action" value="supprimer" class="btn btn-delete">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">Aucune offre d'emploi n'a été trouvée.</p>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Fermeture de la connexion
$conn->close();
?>
