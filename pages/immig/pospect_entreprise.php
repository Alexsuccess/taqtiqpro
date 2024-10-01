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
$sql_session1 = "SELECT 
    u.*,
    f1.*
FROM 
    userss u
INNER JOIN 
    formulaire_immigration_session11 f1 ON u.id = f1.user_id";
$result_session1 = $conn->query($sql_session1);

// Session 2
$sql_session2 = "SELECT 
    u.*,
    f2.*
FROM 
    userss u
INNER JOIN 
    formulaire_immigration_session22 f2 ON u.id = f2.user_id";
$result_session2 = $conn->query($sql_session2);

// Session 3
$sql_session3 = "SELECT 
    u.*,
    f3.*
FROM 
    userss u
INNER JOIN 
    formulaire_immigration_session33 f3 ON u.id = f3.user_id";
$result_session3 = $conn->query($sql_session3);

?>


<?php
// Vérifier si l'e-mail est reçu
if (isset($_POST['email'])) {
    // Récupérer l'e-mail depuis la requête POST
    $email = $_POST['email'];

    // Informations de connexion à la base de données
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

    // Générer un code aléatoire
    $code = generateRandomString(8); // Fonction pour générer une chaîne aléatoire de longueur 8

    // Requête SQL pour mettre à jour la table userss
    $sql = "UPDATE userss SET help = 'validé', help2 = '$code' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour de l'utilisateur : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Erreur : Aucun e-mail reçu";
}

// Fonction pour générer une chaîne aléatoire
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
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
    <h1>Embauches des entreprises</h1>
    <input type="text" id="searchInput1" onkeyup="searchTable(1)" placeholder="Rechercher dans Session 1...">
    <table id="table1">
        <thead>
            <tr>
                <th>Identifiant unique</th>
                <th>Logo</th>
                
                <th>Nom Entreprise</th>
                <th>Nom et Prenom du contact</th>
                <th>pays</th>
                <th>Ville</th>
                <th>Téléphone</th>
                 <th>Email</th>
                
                <th>Date de création</th>
                <th>Raison sociale</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
<?php
if ($result_session1->num_rows > 0) {
    while($row = $result_session1->fetch_assoc()) {
        echo "<tr>
        <td>CL00" . $row["user_id"]. "</td>
            <td style='width: 20%; height: 20%;'><img style='width: 20%; height: 20%;' src='uploads/" . $row['photo'] . "' alt='Profile Image'></td>
            
             <td>" . $row["full_name"]. " " . $row["prenom"]. "</td>
             <td>" . $row["preno"]. "</td>
             <td>" . $row["country"]. "</td>
             <td>" . $row["city"]. "</td>
            <td>" . $row["phone"]. "</td>
           <td>" . $row["email"]. "</td>
             
            <td>" . $row["dob"]. "</td>
            <td>" . $row["marital_status"]. "</td>     
            <td>" . $row["experience"]. "</td>
            <td>" . $row["datet"]. "</td>
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
