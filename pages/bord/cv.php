<?php
// Vérifier si l'ID de l'utilisateur est passé en paramètre GET
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);

    // Connexion à la base de données
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $dbname = "4w0vau_dreamize";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Préparer la requête SQL pour récupérer tous les détails de l'employé
    $sql = "SELECT * FROM employees22 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'employé existe
    if ($result->num_rows > 0) {
        // Récupérer les données de l'employé
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Détails de l'employé - <?= htmlspecialchars($row['last_name'] . ' ' . $row['first_name']) ?></title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f8f9fa;
                    font-family: Arial, sans-serif;
                }
                .container {
                    margin-top: 50px;
                }
                h1 {
                    color: #343a40;
                    margin-bottom: 30px;
                }
                ul {
                    list-style-type: none;
                    padding: 0;
                }
                li {
                    background-color: #ffffff;
                    margin-bottom: 10px;
                    padding: 10px;
                    border: 1px solid #dee2e6;
                    border-radius: 5px;
                }
                li strong {
                    color: #007bff;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <h1>Détails de l'employé <?= htmlspecialchars($row['last_name'] . ' ' . $row['first_name']) ?></h1>
<ul>
    <li><strong>ID :</strong> <?= isset($row['id']) ? htmlspecialchars($row['id']) : '' ?></li>
    <li><strong>Civilité :</strong> <?= isset($row['civility']) ? htmlspecialchars($row['civility']) : '' ?></li>
    <li><strong>Nom :</strong> <?= isset($row['last_name']) ? htmlspecialchars($row['last_name']) : '' ?></li>
    <li><strong>Prénom :</strong> <?= isset($row['first_name']) ? htmlspecialchars($row['first_name']) : '' ?></li>
    <li><strong>Prénom usuel :</strong> <?= isset($row['usual_first_name']) ? htmlspecialchars($row['usual_first_name']) : '' ?></li>
    <li><strong>Date de naissance :</strong> <?= isset($row['birth_date']) ? htmlspecialchars($row['birth_date']) : '' ?></li>
    <li><strong>Sexe :</strong> <?= isset($row['sex']) ? htmlspecialchars($row['sex']) : '' ?></li>
    <li><strong>Adresse :</strong> <?= isset($row['address']) ? htmlspecialchars($row['address']) : '' ?></li>
    <li><strong>Informations de contact :</strong> <?= isset($row['contact_info']) ? htmlspecialchars($row['contact_info']) : '' ?></li>
    <li><strong>Ville :</strong> <?= isset($row['city']) ? htmlspecialchars($row['city']) : '' ?></li>
    <li><strong>Pays :</strong> <?= isset($row['country']) ? htmlspecialchars($row['country']) : '' ?></li>
    <li><strong>Téléphone :</strong> <?= isset($row['phone']) ? htmlspecialchars($row['phone']) : '' ?></li>
    <li><strong>Email :</strong> <?= isset($row['email']) ? htmlspecialchars($row['email']) : '' ?></li>
    <li><strong>Numéro de sécurité sociale :</strong> <?= isset($row['ssn']) ? htmlspecialchars($row['ssn']) : '' ?></li>
    <li><strong>SIRET :</strong> <?= isset($row['siret']) ? htmlspecialchars($row['siret']) : '' ?></li>
    <li><strong>URSSAF :</strong> <?= isset($row['urssaf']) ? htmlspecialchars($row['urssaf']) : '' ?></li>
    <li><strong>Statut matrimonial :</strong> <?= isset($row['marital_status']) ? htmlspecialchars($row['marital_status']) : '' ?></li>
    <li><strong>Nombre d'enfants :</strong> <?= isset($row['children']) ? htmlspecialchars($row['children']) : '' ?></li>
    <li><strong>Heures de travail :</strong> <?= isset($row['working_hours']) ? htmlspecialchars($row['working_hours']) : '' ?></li>
    <li><strong>Titre du poste :</strong> <?= isset($row['job_title']) ? htmlspecialchars($row['job_title']) : '' ?></li>
    <li><strong>Courtier :</strong> <?= isset($row['courtier']) ? (htmlspecialchars($row['courtier']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Agent :</strong> <?= isset($row['agent']) ? (htmlspecialchars($row['agent']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Associé :</strong> <?= isset($row['associe']) ? (htmlspecialchars($row['associe']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Référence :</strong> <?= isset($row['reference']) ? (htmlspecialchars($row['reference']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Département :</strong> <?= isset($row['department']) ? htmlspecialchars($row['department']) : '' ?></li>
    <li><strong>Nombre d'heures :</strong> <?= isset($row['number_hours']) ? htmlspecialchars($row['number_hours']) : '' ?></li>
    <li><strong>Travail de jour :</strong> <?= isset($row['jour']) ? (htmlspecialchars($row['jour']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Travail de soir :</strong> <?= isset($row['soir']) ? (htmlspecialchars($row['soir']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Les deux :</strong> <?= isset($row['les2']) ? (htmlspecialchars($row['les2']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Type d'employé :</strong> <?= isset($row['employee_type']) ? htmlspecialchars($row['employee_type']) : '' ?></li>
    <li><strong>Superviseur :</strong> <?= isset($row['supervisor']) ? htmlspecialchars($row['supervisor']) : '' ?></li>
    <li><strong>ID d'utilisateur :</strong> <?= isset($row['idd']) ? htmlspecialchars($row['idd']) : '' ?></li>
    <li><strong>Occupation :</strong> <?= isset($row['occupation']) ? htmlspecialchars($row['occupation']) : '' ?></li>
    <li><strong>Date d'embauche :</strong> <?= isset($row['hireDate']) ? htmlspecialchars($row['hireDate']) : '' ?></li>
    <li><strong>Numéro d'employé :</strong> <?= isset($row['employeeNumber']) ? htmlspecialchars($row['employeeNumber']) : '' ?></li>
    <li><strong>Bonus de travail :</strong> <?= isset($row['workBonus']) ? htmlspecialchars($row['workBonus']) : '' ?></li>
    <li><strong>Ventes totales :</strong> <?= isset($row['totalSales']) ? htmlspecialchars($row['totalSales']) : '' ?></li>
    <li><strong>Ventes moyennes :</strong> <?= isset($row['averageSales']) ? htmlspecialchars($row['averageSales']) : '' ?></li>
    <li><strong>Remise :</strong> <?= isset($row['discount']) ? htmlspecialchars($row['discount']) : '' ?></li>
    <li><strong>Heures d'entrepreneurs :</strong> <?= isset($row['entrepreneursHours']) ? htmlspecialchars($row['entrepreneursHours']) : '' ?></li>
    <li><strong>Heures EPP :</strong> <?= isset($row['eppHours']) ? htmlspecialchars($row['eppHours']) : '' ?></li>
    <li><strong>Heures MAPC :</strong> <?= isset($row['mapcHours']) ? htmlspecialchars($row['mapcHours']) : '' ?></li>
    <li><strong>Maison :</strong> <?= isset($row['maison']) ? (htmlspecialchars($row['maison']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Télévendeur 1 :</strong> <?= isset($row['televendeur1']) ? (htmlspecialchars($row['televendeur1']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Télévendeur 2 :</strong> <?= isset($row['televendeur2']) ? (htmlspecialchars($row['televendeur2']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Affiliations :</strong> <?= isset($row['affiliations']) ? (htmlspecialchars($row['affiliations']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Immigration :</strong> <?= isset($row['immigration']) ? (htmlspecialchars($row['immigration']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Assurances :</strong> <?= isset($row['assurances']) ? (htmlspecialchars($row['assurances']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Entrepreneurs :</strong> <?= isset($row['entrepreneurs']) ? (htmlspecialchars($row['entrepreneurs']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Entreprises :</strong> <?= isset($row['entreprises']) ? (htmlspecialchars($row['entreprises']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Commerçants :</strong> <?= isset($row['commercants']) ? (htmlspecialchars($row['commercants']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Professionnels :</strong> <?= isset($row['professionnels']) ? (htmlspecialchars($row['professionnels']) == 1 ? 'oui' : 'non') : '' ?></li>
    <li><strong>Shift de travail :</strong> <?= isset($row['workShift']) ? htmlspecialchars($row['workShift']) : '' ?></li>
    <li><strong>Izishope :</strong> <?= isset($row['izishope']) ? htmlspecialchars($row['izishope']) : '' ?></li>
    <li><strong>Site d'immigration :</strong> <?= isset($row['immigrationSite']) ? htmlspecialchars($row['immigrationSite']) : '' ?></li>
    <li><strong>Accès aux finances :</strong> <?= isset($row['accessFinance']) ? htmlspecialchars($row['accessFinance']) : '' ?></li>
    <li><strong>Immonivo :</strong> <?= isset($row['immonivo']) ? htmlspecialchars($row['immonivo']) : '' ?></li>
    <li><strong>Références X :</strong> <?= isset($row['referencesX']) ? htmlspecialchars($row['referencesX']) : '' ?></li>
</ul>

        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Aucun employé trouvé avec cet identifiant.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
} else {
    echo "Identifiant d'utilisateur non spécifié.";
}
?>
