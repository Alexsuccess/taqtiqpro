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

// Vérifier si l'e-mail est reçu
if (isset($_POST['email'])) {
    // Récupérer l'e-mail depuis la requête POST
    $email = $_POST['email'];

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
    exit();
}

// Obtenir les types de comptes distincts
$sql_types = "SELECT DISTINCT type FROM userss WHERE type IS NOT NULL";
$result_types = $conn->query($sql_types);

$types = [];
if ($result_types->num_rows > 0) {
    while($row = $result_types->fetch_assoc()) {
        $types[] = $row['type'];
    }
}

// Tableau associant les types de comptes à leurs initiales
$type_initials = [
    'Client' => 'CL',
    'Prestataire' => 'ENT',
    'Employé' => 'EMP',
    'Candidat' => 'CAN',
    'Televendeur' => 'TEL',
    'Agence de Marketing' => 'Mark',
    'Modérateur' => 'ENT',
    // Ajoutez d'autres types de comptes ici
];

// Fonction pour échapper les valeurs et éviter les erreurs de dépréciation
function safe_htmlspecialchars($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
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
    <h1>Tableaux des Utilisateurs CRM</h1>

    <?php foreach ($types as $type): ?>
        <?php
        // Requête pour récupérer les utilisateurs de chaque type
        $sql_users = "SELECT * FROM userss WHERE type = '$type'";
        $result_users = $conn->query($sql_users);
        ?>
        <h2>Nos <?= safe_htmlspecialchars($type) ?></h2><br>
        <input type="text" id="searchInput_<?= safe_htmlspecialchars($type) ?>" onkeyup="searchTable('<?= safe_htmlspecialchars($type) ?>')" placeholder="Rechercher dans <?= safe_htmlspecialchars($type) ?>...">
        <table id="table_<?= safe_htmlspecialchars($type) ?>">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Pays</th>
                    
                
                    <th>Photo de profil</th>
                    <th>Statut</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php if ($result_users->num_rows > 0): ?>
                    <?php while($row = $result_users->fetch_assoc()): ?>
                        <?php
                        $type_initial = isset($type_initials[$type]) ? $type_initials[$type] : 'UK'; // 'UK' pour inconnu
                        ?>
                        <tr>
                            <td><?= $type_initial . '00' . safe_htmlspecialchars($row["id"]) ?></td>
                            <td><?= safe_htmlspecialchars($row["nom"]) ?></td>
                            <td><?= safe_htmlspecialchars($row["prenom"]) ?></td>
                            <td><?= safe_htmlspecialchars($row["pays"]) ?></td>
                            
                          
                            <td><img src='uploads/<?= safe_htmlspecialchars($row["profile_pic"]) ?>' alt='Profile Image' style='width: 50px; height: 50px;'></td>
                            <td><?= safe_htmlspecialchars($row["help"]) ?></td>
                            
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan='12'>Aucun utilisateur trouvé pour ce type de compte</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <script>
        // Fonction pour valider
        function valider(email) {
            // Requête AJAX pour mettre à jour la table userss avec l'email spécifié
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // Mettez à jour avec le nom correct de votre script PHP
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Utilisateur activé avec succès !");
                    location.reload();
                }
            };
            xhr.send("email=" + email);
        }

        // Fonction de recherche dans la table
        function searchTable(type) {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput_" + type);
            filter = input.value.toUpperCase();
            table = document.getElementById("table_" + type);
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

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
