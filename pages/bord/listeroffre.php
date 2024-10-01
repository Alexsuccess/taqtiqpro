<?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérez l'ID de l'utilisateur
$userId = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialisez le nombre total d'enregistrements à afficher
$totalRecords = 0;

// Récupérez les offres de l'utilisateur actuellement connecté
if (isset($_GET['jobTitleSearch'])) {
    $search = $_GET['jobTitleSearch'];
    // Requête SQL pour rechercher une offre
    $sql_search = "SELECT * FROM offre WHERE user_id = ? AND (job_title LIKE '%$search%' OR job_titlee LIKE '%$search%' OR job_description LIKE '%$search%' OR job_requirements LIKE '%$search%')";
} else {
    $sql_search = "SELECT * FROM offre WHERE user_id = ?";
}

$stmt_search = $conn->prepare($sql_search);
$stmt_search->bind_param("i", $userId);
$stmt_search->execute();
$result_search = $stmt_search->get_result();

// Mettez à jour le nombre total d'enregistrements
$totalRecords = $result_search->num_rows;

// Afficher les résultats de la recherche

// Fermeture de la connexion
$stmt_search->close();
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Liste des CV</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="../../plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="../../plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="../../css/style.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            color: #333;
            cursor: pointer;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type=text] {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
            border: none;
        }
        .pagination-container {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .pagination-container select {
            margin-right: 10px;
        }
        .record-count {
            margin-top: 10px;
        }
    </style>
</head>
<body class="login-page">
<!-- Contenu du module Consulter CV -->
<h2>Liste des offres d'emplois</h2>
<div class="search-container">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Recherche...">
</div>
<select id="perPageSelect" onchange="changePerPage()">
    <option value="10">10 par page</option>
    <option value="25">25 par page</option>
    <option value="50">50 par page</option>
    <option value="100">100 par page</option>
</select>
<!-- Tableau -->
<div class="table-container">
    <table id='cvTable'>
        <thead>
        <tr>
            <th onclick="sortTable(1)">Titre de l'offre</th>
            <th onclick="sortTable(2)">Lieu</th>
            <th onclick="sortTable(3)">Description</th>
            <th onclick="sortTable(4)">Exigences</th>
            <th onclick="sortTable(5)">Date de soumission</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Affichage des données
        if ($result_search->num_rows > 0) {
            $rowCount = 0;
            while ($row = $result_search->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["job_title"] . "</td>";
                echo "<td>" . $row["job_titlee"] . "</td>";
                echo "<td>" . $row["job_description"] . "</td>";
                echo "<td>" . $row['job_requirements'] . "</td>";
                echo "<td>" . $row["submission_date"] . "</td>";
                echo "</tr>";
                $rowCount++;
            }
        } else {
            echo "<tr><td colspan='9'>Aucun résultat trouvé.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<!-- Options de pagination -->
<div class="pagination-container">
    <div>
<span class="record-count"><?php echo "Affichage de " . $rowCount . " enregistrement(s) sur " . $totalRecords . " total"; ?></span>
    </div>
    <div>
        <button id="prevPageBtn" onclick="prevPage()">Précédent</button>
        <button id="nextPageBtn" onclick="nextPage()">Suivant</button>
    </div>
</div>

<script>
    var currentPage = 0;
    var rowsPerPage = 10;
    var rows = document.getElementById('cvTable').getElementsByTagName('tbody')[0].rows;
    var totalPages = Math.ceil(<?php echo $totalRecords; ?> / rowsPerPage);

    // Fonction de tri pour la table
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("cvTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

    // Fonction de recherche dans la table
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("cvTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";

                } else {
                    tr[i].style.display = "none";
                }
            }
        }
        updateTotalRecords();
    }

    // Fonction pour changer le nombre d'éléments par page
    function changePerPage() {
        var select = document.getElementById("perPageSelect");
        rowsPerPage = parseInt(select.options[select.selectedIndex].value);
        totalPages = Math.ceil(<?php echo $totalRecords; ?> / rowsPerPage);
        currentPage = 0;
        showPage(currentPage);
    }

    // Fonction pour afficher la page précédente
    function prevPage() {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    }

    // Fonction pour afficher la page suivante
    function nextPage() {
        if (currentPage < totalPages - 1) {
            currentPage++;
            showPage(currentPage);
        }
    }

    // Fonction pour afficher la page actuelle
    function showPage(page) {
        var start = page * rowsPerPage;
        var end = start + rowsPerPage;
        for (var i = 0; i < rows.length; i++) {
            if (i >= start && i < end) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
        updateTotalRecords();
    }

    // Fonction pour mettre à jour le nombre total d'enregistrements affichés
    function updateTotalRecords() {
        var visibleRows = document.querySelectorAll('#cvTable tbody tr[style=""]');
        document.querySelector('.record-count').textContent = "Affichage de " + visibleRows.length + " enregistrement(s) sur " + <?php echo $totalRecords; ?> + " total";
    }

    // Afficher la page initiale
    showPage(currentPage);
</script>
</body>
</html>
