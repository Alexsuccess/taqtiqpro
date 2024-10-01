<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Liste des Postulants</title>
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
<h2>Liste des candidats</h2>
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
    <table id='postulantsTable'>
        <thead>
        <tr>
            <th>Titre du job</th>
            <th>Nom du Prestataire</th>
            <th>Résidence</th>
            <th>Années d'expérience</th>
            <th>Disponibilité</th>
            <th>Salaire solicité</th>
            <th>Domaine de compétences</th>
            <th>Message</th>
            <th>Date Postulation</th>
        </tr>
        </thead>
        <tbody>
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
        $user_id = $_SESSION['id'];

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

        // Requête SQL pour récupérer les postulations avec les noms des personnes qui ont postulé
        $sql = "SELECT post.*, off.job_title, off.job_titlee, off.job_requirements, off.job_description, usr.nom
                FROM postulations post
                INNER JOIN offre off ON post.offre_id = off.id
                INNER JOIN userss usr ON post.user_idd = usr.id
                WHERE off.user_id = ?
                ORDER BY post.date_postulation DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Affichage des postulations dans un tableau
        while ($row = $result->fetch_assoc()) {
            echo "<tr style='background-color: white;'>";
            echo "<td>" . $row['job_title'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['residence'] . "</td>";
            echo "<td>" . $row['experience'] . "</td>";
            echo "<td>" . $row['disponibilite'] . "</td>";
            echo "<td>" . $row['salaire'] . "</td>";
            echo "<td>" . $row['competence'] . "</td>";
            echo "<td>" . $row['messages'] . "</td>";
            echo "<td>" . $row['date_postulation'] . "</td>";
            echo "</tr>";
            $totalRecords++;
        }

        // Ferme la connexion
        $stmt->close();
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
<!-- Options de pagination -->
<div class="pagination-container">
    <div>
        <span class="record-count"><?php echo "Affichage de " . $totalRecords . " enregistrement(s)"; ?></span>
    </div>
        <div>
        <button id="prevPageBtn" onclick="prevPage()">Précédent</button>
        <button id="nextPageBtn" onclick="nextPage()">Suivant</button>
    </div>
</div>
<script>
    var currentPage = 0;
    var rowsPerPage = 10;
    var rows = document.getElementById('postulantsTable').getElementsByTagName('tbody')[0].rows;
    var totalPages = Math.ceil(<?php echo $totalRecords; ?> / rowsPerPage);

    // Fonction de tri pour la table
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("postulantsTable");
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
        table = document.getElementById("postulantsTable");
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
        var visibleRows = document.querySelectorAll('#postulantsTable tbody tr[style=""]');
        document.querySelector('.record-count').textContent = "Affichage de " + visibleRows.length + " enregistrement(s) sur " + <?php echo $totalRecords; ?> + " total";
    }

    // Afficher la page initiale
    showPage(currentPage);
</script>
</body>
</html>
