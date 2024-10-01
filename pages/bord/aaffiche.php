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

// Requête SQL pour récupérer les commandes
$sql = "SELECT * FROM commandes22";
$result = $conn->query($sql);

$commandes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidats_ids = explode(',', $row['candidats']);
        $candidats_noms = array();
        $competences_noms = array();

        foreach ($candidats_ids as $id) {
            // Requête pour vérifier dans la table candidats
            $candidat_sql = "SELECT nom FROM candidats WHERE id = ?";
            $stmt = $conn->prepare($candidat_sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $candidat_result = $stmt->get_result();
            if ($candidat_result->num_rows > 0) {
                $candidat_row = $candidat_result->fetch_assoc();
                $candidats_noms[] = $candidat_row['nom'];
            } else {
                // Requête pour vérifier dans la table competence1
                $competence_sql = "SELECT Nom FROM competence1 WHERE id = ?";
                $stmt = $conn->prepare($competence_sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $competence_result = $stmt->get_result();
                if ($competence_result->num_rows > 0) {
                    $competence_row = $competence_result->fetch_assoc();
                    $competences_noms[] = $competence_row['Nom'];
                }
            }
            $stmt->close();
        }

        $row['candidats_noms'] = implode(', ', array_merge($candidats_noms, $competences_noms));
        $commandes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { margin-bottom: 20px; }
        .card-header { background-color: #007bff; color: #fff; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Liste des Commandes</h1>
        <?php if (count($commandes) > 0): ?>
            <?php foreach ($commandes as $commande): ?>
                <div class="card">
                    <div class="card-header">
                        Commande #<?php echo htmlspecialchars($commande['id']); ?> - <?php echo htmlspecialchars($commande['nomm']); ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Détails de la Commande</h5>
                        <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($commande['telephone']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($commande['couriel']); ?></p>
                        <p><strong>Ville:</strong> <?php echo htmlspecialchars($commande['villee']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($commande['date']); ?></p>
                        <p><strong>Exigences:</strong> <?php echo htmlspecialchars($commande['exigences']); ?></p>
                        <p><strong>Candidats:</strong> <?php echo htmlspecialchars($commande['candidats_noms']); ?></p>
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($commande['user_idd']); ?></p>
                        <p><strong>Date de Création:</strong> <?php echo htmlspecialchars($commande['created_at']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune commande trouvée.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
