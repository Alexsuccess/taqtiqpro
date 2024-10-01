<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Pagination
$limit = 10; // Nombre d'entreprises par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM entreprises55 WHERE nom LIKE '%$search%' OR responsable LIKE '%$search%' LIMIT $start, $limit";
$result = $conn->query($sql);

$entreprises = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $entreprises[] = $row;
    }
}

// Total des entreprises pour la pagination
$total = $conn->query("SELECT COUNT(id) AS total FROM entreprises55 WHERE nom LIKE '%$search%' OR responsable LIKE '%$search%'")->fetch_assoc()['total'];
$pages = ceil($total / $limit);

// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Entreprises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            background-color: #e9ecef;
        }
        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-header {
            background-color: #343a40;
            color: #fff;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(52, 58, 64, 0.05);
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Liste des Entreprises</h1>
    <div class="table-responsive">
        <table id="entreprisesTable" class="display table table-striped table-bordered">
            <thead class="table-header">
                <tr>
                    <th>ID</th>
                    <th>Nom de l'entreprise</th>
                    <th>Responsable</th>
                    <th>Ville</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($entreprises): ?>
                    <?php foreach ($entreprises as $entreprise): ?>
                        <tr>
                            <td><?= htmlspecialchars($entreprise['id']) ?></td>
                            <td><?= htmlspecialchars($entreprise['nom']) ?></td>
                            <td><?= htmlspecialchars($entreprise['responsable']) ?></td>
                            <td><?= htmlspecialchars($entreprise['ville']) ?></td>
                            <td><?= htmlspecialchars($entreprise['telephone']) ?></td>
                            <td><?= htmlspecialchars($entreprise['email']) ?></td>
                            <td><?= htmlspecialchars($entreprise['date_creation']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucune entreprise trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
$(document).ready(function() {
    $('#entreprisesTable').DataTable({
        "paging": true,       // Pagination activée
        "searching": true,    // Recherche activée
        "ordering": true,     // Tri des colonnes activé
        "info": true,         // Informations sur la pagination
        "lengthChange": true, // Option de sélection du nombre de lignes à afficher
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/French.json"
        }
    });
});

</script>

</body>
</html>
