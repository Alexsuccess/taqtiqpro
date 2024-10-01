<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlDestinataires = "
    SELECT Nom AS Nom, Prenom AS Prenom, Courriel AS Courriel, Ville AS Ville, Tel_Organisation AS Tel_Organisation, Categorie AS Categorie, Organisations AS Organisations 
    FROM client 
    WHERE Courriel IS NOT NULL
    UNION
    SELECT nom AS Nom, prenom AS Prenom, email AS Courriel, telephone AS Tel_Organisation, ville AS Ville, '' AS Categorie, '' AS Organisations 
    FROM userss 
    WHERE compte IN ('Entreprise', 'Prestataire') AND email IS NOT NULL
";

$resultDestinataires = $conn->query($sqlDestinataires);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<style type="text/css">
body {
    background-image: url('titi.png');
    background-size: cover;
    background-attachment: fixed;
    font-family: 'Roboto', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    width: 85%;
    margin: 30px auto;
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #4CAF50;
    text-align: center;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 8px;
    overflow: hidden;
}

.table thead {
    background-color: #4CAF50;
    color: white;
}

.table thead th {
    padding: 12px;
    text-align: left;
}

.table tbody tr {
    transition: background-color 0.3s;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table tbody td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.table tbody td:first-child {
    width: 50px;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #4CAF50;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #007BFF;
}

.btn-success {
    background-color: #28A745;
}

.btn:hover {
    background-color: #45a049;
}

#companySelection {
    margin-top: 30px;
}

input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.alert {
    padding: 15px;
    background-color: #f44336;
    color: white;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert.success {
    background-color: #4CAF50;
}

.alert.info {
    background-color: #2196F3;
}

.alert.warning {
    background-color: #ff9800;
}
</style>

</head>
<body style="border-style: double; background-image: url(titi.png);">
    <div style="width: 150%; background-color: white;" class="container">
        <div id="companySelection">
            <h2>Sélectionner les entreprises</h2>
            <form id="emailForm">
                <div class="form-check">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                    <label class="form-check-label" for="selectAll">Sélectionner toutes les entreprises avec un email</label>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Checkbox</th>
                            <th>Categorie</th>
                            <th>Organisations</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Ville</th>
                            <th>Email</th>
                            <th>Tel Organisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultDestinataires->num_rows > 0) {
                            while ($rowD = $resultDestinataires->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='selected_users[]' data-nom='" . htmlspecialchars($rowD['Nom'] ?? '') . "' value='" . htmlspecialchars($rowD['Courriel'] ?? '') . "'></td>";
                                echo "<td>" . htmlspecialchars($rowD['Categorie'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Organisations'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Nom'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Prenom'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Ville'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Courriel'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Tel_Organisation'] ?? '') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Aucune entreprise trouvée.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="button" id="sendEmailBtn" class="btn btn-success">Envoyer les emails</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true
            });
        });

        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_users[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('sendEmailBtn').addEventListener('click', function() {
            var selectedEmails = Array.from(document.querySelectorAll('input[name="selected_users[]"]:checked')).map(function(checkbox) {
                return checkbox.value;
            });

            if (selectedEmails.length === 0) {
                alert('Veuillez sélectionner au moins une entreprise.');
                return;
            }
var mailtoLink = 'mailto:' +
    '?subject=' + encodeURIComponent('Informations sur les candidats') +
    '&body=' + encodeURIComponent(
        'Bonjour cher client,\n\n' +
        'Bienvenue sur votre nouvelle plateforme de recrutement personnalisé, conçue pour être simple, rapide et efficace.\n\n' +
        'ÜRI Canada, expert en recrutement local et international, vous propose une solution complète pour sélectionner les meilleurs talents étrangers qualifiés et francophones à travers le monde.\n\n' +
        'Comment ça marche ?\n' +
        '1. Connectez-vous à notre portail.\n' +
        '2. Créez votre profil ou connectez-vous avec votre courriel et votre mot de passe temporaire : 1234 (secteur de la construction).\n' +
        '3. Trouvez ou commandez vos talents en un clic. Rien de plus simple !\n\n' +
        'Cliquez simplement sur le lien suivant : https://admin.izishope.com/pages/bord/presenter_candidat\n\n' +
        'Pour le reste, nous nous occupons de tout. C\'est aussi simple que cela !\n\n' +
        'Chez ÜRI Canada, votre partenaire de choix pour maintenir vos équipes à flot avec une main-d\'œuvre qualifiée.\n\n' +
        'Nous serions ravis de mettre notre expertise à votre service.\n\n' +
        'Cordialement,\n' +
        'Alexandra / L\'équipe ÜRI Canada Inc.\n' +
        'contact@uricanada.com\n' +
        'www.uricanada.com\n\n' +
        'Permis: AP:2403926\n' +
        'Permis: AR2403828'
    ) +
    '&bcc=' + encodeURIComponent(selectedEmails.join(','));


            window.location.href = mailtoLink;
        });
    </script>
</body>
</html>
