<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs et Candidats</title>
    <style type="text/css">
        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"] {
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Utilisateurs et Candidats</h1>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Rechercher...">
    <table id="dataTable">
        <tr>
            <th>Code</th>
            <th>Prenom</th>
            <th>Profession</th>
            <th>Pays</th>
            <th>Ville</th>
            <th>Localisationn</th>
            <th>Education</th>
            <th>Competences</th>
        </tr>
        <?php
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

        // Requête pour obtenir les données de la table userss
        $sql_users = "SELECT * FROM userss";
        $result_users = $conn->query($sql_users);

        // Requête pour obtenir les données de la table candidats
        $sql_candidats = "SELECT * FROM candidats";
        $result_candidats = $conn->query($sql_candidats);

        // Affichage des données de la table userss
        if ($result_users->num_rows > 0) {
            while ($row = $result_users->fetch_assoc()) {
                echo "<tr>
                    <td>CAND00" . $row['id'] . "</td>
                    <td>" . $row['prenom'] . "</td>
                    <td>" . $row['Profession'] . "</td>
                    <td>" . $row['pays'] . "</td>
                    <td>" . $row['Ville'] . "</td> 
                    <td>" . $row['Localisation'] . "</td>
                    <td>" . $row['Education'] . "</td> 
                    <td>" . $row['Competences'] . "</td>
                </tr>";
            }
        }

        // Affichage des données de la table candidats
        if ($result_candidats->num_rows > 0) {
            while ($row = $result_candidats->fetch_assoc()) {
                echo "<tr>
                    <td>CAND00" . $row['id'] . "</td>
                    <td>" . $row['prenom'] . "</td>
                    <td>" . $row['prof'] . "</td>
                    <td>" . $row['pays'] . "</td>
                    <td></td>
                    <td></td> 
                     <td></td>
                    <td></td>                    
                </tr>";
            }
        }

        $conn->close();
        ?>
    </table>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
