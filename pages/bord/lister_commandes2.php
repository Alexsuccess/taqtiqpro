<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
CREATE TEMPORARY TABLE temp_commandes_candidats AS
SELECT 
    commandes22.id AS commande_id,
    commandes22.date,
    commandes22.exigences,
    commandes22.user_idd,
    SUBSTRING_INDEX(SUBSTRING_INDEX(commandes22.candidats, ',', numbers.n), ',', -1) AS candidat_id
FROM 
    (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
     UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL 
     SELECT 10) numbers INNER JOIN commandes22 
     ON CHAR_LENGTH(commandes22.candidats)
        -CHAR_LENGTH(REPLACE(commandes22.candidats, ',', ''))>=numbers.n-1;

SELECT 
    tc.commande_id,
    tc.date,
    tc.exigences,
    c.nom AS candidat_nom,
    c.prenom AS candidat_prenom,
    c.prof AS candidat_prof,
    c.pays AS candidat_pays,
    c.city AS candidat_city,
    u.nom AS user_nom,
    u.prenom AS user_prenom,
    u.pays AS user_pays,
    u.ville AS user_ville,
    u.email AS user_email,
    u.telephone AS user_telephone
FROM 
    temp_commandes_candidats tc
LEFT JOIN 
    candidats c ON tc.candidat_id = c.id
LEFT JOIN
    userss u ON tc.user_idd = u.id
ORDER BY 
    tc.commande_id;
";

if ($conn->multi_query($sql)) {
    $data = [];
    do {
        if ($result = $conn->store_result()) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $jsonData = json_encode($data);
            $result->free();
        }
    } while ($conn->next_result());
} else {
    $jsonData = json_encode(["error" => "Error: " . $conn->error]);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes et Candidats</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .loading {
            text-align: center;
            margin-top: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="background-image: url(bbb.jpg);">

<div style="margin-left: 1%; background-color: white;" class="container">
    <h1 class="text-center my-4">Commandes et Candidats</h1>
    <div class="search-bar">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
    </div>
    <div id="loading" class="loading">Chargement...</div>
    <table style="background-color: white;" class="table table-bordered table-striped" id="commandesTable" style="display: none;">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>Date</th>
                <th>Exigences</th>
                <th>Nom du Candidat</th>
                <th>Prénom du Candidat</th>
                <th>Profession du Candidat</th>
                <th>Pays du Candidat</th>
                <th>Ville du Candidat</th>
                <th>Nom de l'Entreprise</th>
                <th>Raison sociale de l'Entreprise</th>
                <th>Pays de l'Entreprise</th>
                <th>Ville de l'Entreprise</th>
                <th>Email de l'Entreprise</th>
                <th>Téléphone de l'Entreprise</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les données seront insérées ici par JavaScript -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    var data = <?php echo $jsonData; ?>;

    if (data.error) {
        $('#loading').text(data.error);
    } else {
        var tableBody = $('#commandesTable tbody');
        data.forEach(function(item) {
            var row = `
                <tr>
                    <td>${item.commande_id}</td>
                    <td>${item.date}</td>
                    <td>${item.exigences}</td>
                    <td>${item.candidat_nom || 'N/A'}</td>
                    <td>${item.candidat_prenom || 'N/A'}</td>
                    <td>${item.candidat_prof || 'N/A'}</td>
                    <td>${item.candidat_pays || 'N/A'}</td>
                    <td>${item.candidat_city || 'N/A'}</td>
                    <td>${item.user_nom || 'N/A'}</td>
                    <td>${item.user_prenom || 'N/A'}</td>
                    <td>${item.user_pays || 'N/A'}</td>
                    <td>${item.user_ville || 'N/A'}</td>
                    <td>${item.user_email || 'N/A'}</td>
                    <td>${item.user_telephone || 'N/A'}</td>
                </tr>
            `;
            tableBody.append(row);
        });
        $('#loading').hide();
        $('#commandesTable').show();

        // Filtrage en temps réel
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#commandesTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    }
});
</script>

</body>
</html>
