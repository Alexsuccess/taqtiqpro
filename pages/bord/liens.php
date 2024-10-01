<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupérer les liens
$sql = "SELECT id, compte, nom_lien, lien FROM links";
$result = $conn->query($sql);

// Récupérer les utilisateurs
$sql_users = "SELECT id, email, compte, nom, prenom FROM userss ORDER BY compte";
$result_users = $conn->query($sql_users);

// Organiser les utilisateurs par type de compte
$users = [];
if ($result_users->num_rows > 0) {
    while($row = $result_users->fetch_assoc()) {
        $users[$row['compte']][] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liens Partagés</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
    </style>
    <script>
        function filterUsers() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("userSearch");
            filter = input.value.toUpperCase();
            table = document.getElementById("userTable");
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
</head>
<body>
<div class="container">
    <h2>Partager les liens</h2>
    <form method="post" action="">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Type de compte</th>
                    <th>Nom du lien</th>
                    <th>Lien</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="radio" name="selected_link" value="<?php echo htmlspecialchars($row['lien']); ?>" data-lien="<?php echo htmlspecialchars($row['lien']); ?>"></td>
                            <td><?php echo htmlspecialchars($row["compte"]); ?></td>
                            <td><?php echo htmlspecialchars($row["nom_lien"]); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row["lien"]); ?>" target="_blank"><?php echo htmlspecialchars($row["lien"]); ?></a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun lien trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="button" id="nextBtn" class="btn btn-primary">Suivant</button>
    </form>
</div>

<div class="container" id="userSelection" style="display:none;">
    <h2>Sélectionnez les utilisateurs</h2>
    <input type="text" id="userSearch" onkeyup="filterUsers()" placeholder="Rechercher des utilisateurs..." class="form-control mb-3">
    <table class="table" id="userTable">
        <thead>
            <tr>
                <th></th>
                <th>Type de compte</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $compte => $compteUsers): ?>
                <tr><td colspan="5"><strong><?php echo htmlspecialchars($compte); ?></strong></td></tr>
                <?php foreach ($compteUsers as $user): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_users[]" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                        <td><?php echo htmlspecialchars($user['compte']); ?></td>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" id="sendEmailBtn" class="btn btn-primary">Envoyer le lien par mail</button>
</div>

<script>
document.getElementById('nextBtn').addEventListener('click', function() {
    var selectedLink = document.querySelector('input[name="selected_link"]:checked');
    if (selectedLink) {
        document.getElementById('userSelection').style.display = 'block';
        this.style.display = 'none';
    } else {
        alert('Veuillez sélectionner un lien.');
    }
});

document.getElementById('sendEmailBtn').addEventListener('click', function() {
    var selectedEmails = Array.from(document.querySelectorAll('input[name="selected_users[]"]:checked')).map(function(checkbox) {
        return checkbox.value;
    });

    if (selectedEmails.length === 0) {
        alert('Veuillez sélectionner au moins un utilisateur.');
        return;
    }

    var selectedLink = document.querySelector('input[name="selected_link"]:checked').getAttribute('data-lien');
    var mailtoLink = 'mailto:' + selectedEmails.join(',') + 
                 '?subject=Lien partagé' + 
                 '&body=' + encodeURIComponent(
                    'Cher Client,\n\n' +
                    'Nous espérons que vous allez bien.\n\n' +
                    'Nous vous écrivons pour partager un lien important que vous trouverez ci-dessous. Veuillez cliquer sur le lien pour renseigner vos informations.\n\n' +
                    'Lien : ' + selectedLink + '\n\n' +
                    
                    'Nous vous serions reconnaissants de bien vouloir accuser réception de ce message afin que nous puissions être sûrs que vous l\'avez bien reçu. Si vous avez la moindre question ou rencontrez un quelconque problème, n\'hésitez pas à nous en informer.\n\n' +
                    'Merci beaucoup pour votre coopération.\n\n' +
                    'Cordialement,\n' +
                    'Uri Canada'
                 );

    window.location.href = mailtoLink;
});
</script>
</body>
</html>



 