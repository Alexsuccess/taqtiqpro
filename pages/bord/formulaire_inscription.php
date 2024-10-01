<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement des requêtes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fetch_data') {
    $filterValue = isset($_POST['filter']) ? $_POST['filter'] : '';

    // Exécutez la requête SQL pour obtenir les données
    $sql = "SELECT * FROM inscriptions_membres";
    if ($filterValue) {
        $sql .= " WHERE membreType = '$filterValue'";
    }
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Fermez la connexion
    $conn->close();

    // Retourner les données au format JSON
    echo json_encode($data);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Inscriptions des Membres</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            text-align: center;
            padding: 12px;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .form-group label {
            font-weight: bold;
        }
        select.form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
    </style>
</head>
<body>

<div style="margin-left: 1%;" class="container">
    <h1 class="text-center mb-4">Gestion des Inscriptions des Membres</h1>
    
    <div class="form-group">
        <label for="filterSelect">Filtrer par Type de Membre:</label>
        <select class="form-control" id="filterSelect">
            <option value="">Tous</option>
            <option value="entrepreneur">Entrepreneur</option>
            <option value="courtier">Courtier</option>
            <option value="commercant">Commerçant</option>
            <option value="courtier">Courtier</option>
            <option value="hypothecaire">Hypothécaire</option>
            <option value="fournisseur">Fournisseur</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type de Membre</th>
                    <th>Type d'Entrepreneur</th>
                    <th>Type de Courtier</th>
                    <th>Type Hypothécaire</th>
                    <th>Type Fournisseur</th>
                    <th>Numéro de Permis</th>
                    <th>Catégories de Spécialités</th>
                    <th>Valeur Projet Min</th>
                    <th>Valeur Projet Max</th>
                    <th>Zone Géographique</th>
                    <th>Rayon</th>
                    <th>Régions Desservies</th>
                    <th>Services Offerts</th>
                    <th>Forfait</th>
                </tr>
            </thead>
            <tbody id="dataTableBody">
                <!-- Les données seront insérées ici par JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchAndRenderData(filterValue = '') {
            $.ajax({
                url: '',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'fetch_data',
                    filter: filterValue
                },
                success: function(data) {
                    renderTable(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erreur lors de la récupération des données:', textStatus, errorThrown);
                }
            });
        }

        function renderTable(data) {
            const tbody = $('#dataTableBody');
            tbody.empty();
            data.forEach(member => {
                tbody.append(`
                    <tr>
                        <td>${member.id}</td>
                        <td>${member.membreType}</td>
                        <td>${member.entrepreneurType || 'N/A'}</td>
                        <td>${member.courtierType || 'N/A'}</td>
                        <td>${member.hypothecaireType || 'N/A'}</td>
                        <td>${member.fournisseurType || 'N/A'}</td>
                        <td>${member.permisNo || 'N/A'}</td>
                        <td>${member.specialitesCategories || 'N/A'}</td>
                        <td>${member.valeurProjetMin || 'N/A'}</td>
                        <td>${member.valeurProjetMax || 'N/A'}</td>
                        <td>${member.zoneGeographique || 'N/A'}</td>
                        <td>${member.rayon || 'N/A'}</td>
                        <td>${member.regionsDesservies || 'N/A'}</td>
                        <td>${member.servicesOfferts || 'N/A'}</td>
                        <td>${member.forfait || 'N/A'}</td>
                    </tr>
                `);
            });
        }

        // Initial fetch
        fetchAndRenderData();

        // Filter functionality
        $('#filterSelect').change(function() {
            const filterValue = $(this).val();
            fetchAndRenderData(filterValue);
        });
    });
</script>

</body>
</html>
