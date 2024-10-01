<<?php
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

// Session 1
$sql_session1 = "SELECT * FROM userss WHERE compte = 'Employé'";
$result_session1 = $conn->query($sql_session1);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs ayant postulé</title>
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
    <h1>Infos Prospects Employés</h1>
    <input type="text" id="searchInput1" onkeyup="searchTable(1)" placeholder="Rechercher dans Session 1...">
    <table id="table1">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Identifiant unique</th>
                <th>Téléphone</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pays</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
<?php
if ($result_session1->num_rows > 0) {
    while($row = $result_session1->fetch_assoc()) {
        // Determine the status text based on the 'statut' value
        $statutText = $row["statut"] == 1 ? "Actif" : "Inactif";

        echo "<tr>
            <td style='width: 20%; height: 20%;'><img style='width: 20%; height: 20%;' src='uploads/" . $row['profile_pic'] . "' alt='Profile Image'></td>
            <td>EMP" . $row["id"]. "</td>
            <td>" . $row["telephone"]. "</td>
            <td>" . $row["nom"]. "</td>
            <td>" . $row["prenom"]. "</td>
            <td>" . $row["pays"]. "</td>
            <td>" . $row["email"]. "</td>     
            <td>" . $row["telephone"]. "</td>
            <td>" . $statutText . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='15'>Aucun résultat pour la session 1</td></tr>";
}
?>


        </tbody>
    </table>




<script>
            // Fonction pour valider
        function valider(email) {
            // Requête AJAX pour mettre à jour la table userss avec l'email spécifié
            var xhr = new XMLHttpRequest();
            xhr.open("POST", " ", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Utilisateur validé avec succès !");
                    // Rafraîchir la page après la validation
                    location.reload();
                }
            };
            xhr.send("email=" + email);
        }

    function searchTable(sessionNumber) {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput" + sessionNumber);
        filter = input.value.toUpperCase();
        table = document.getElementById("table" + sessionNumber);
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
