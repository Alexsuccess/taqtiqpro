<?php
// Vérifier si un ID de candidat est passé en GET
if (isset($_GET['candidat_id'])) {
    $candidat_id = $_GET['candidat_id'];

    // Connexion à la base de données
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $dbname = "4w0vau_dreamize";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer toutes les informations du candidat
    $candidat_details_sql = "SELECT * FROM candidats as dd LEFT JOIN userss ff on dd.user_id=ff.id  WHERE dd.id = $candidat_id";
    $candidat_details_result = $conn->query($candidat_details_sql);

    // Récupérer les parcours académiques
    $parcours_academique_sql = "SELECT * FROM parcours_academique WHERE candidat_id = $candidat_id";
    $parcours_academique_result = $conn->query($parcours_academique_sql);

    // Récupérer les parcours professionnels
    $parcours_professionnel_sql = "SELECT * FROM parcours_professionnel WHERE candidat_id = $candidat_id";
    $parcours_professionnel_result = $conn->query($parcours_professionnel_sql);

    // Récupérer les compétences
    $competences_sql = "SELECT * FROM competence2 WHERE user_id = $candidat_id";
    $competences_result = $conn->query($competences_sql);

    if ($candidat_details_result->num_rows > 0) {
        $candidat = $candidat_details_result->fetch_assoc();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV du Candidat</title>
    <style>
        /* Styles pour la mise en page du CV */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .cv-container {
            width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cv-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .cv-photo {
            flex: 0 0 150px;
            height: 150px;
            background-color: #ddd;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
        }
        .cv-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .cv-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .cv-header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .cv-section {
            margin-bottom: 20px;
        }
        .cv-section h2 {
            margin-bottom: 10px;
            font-size: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .cv-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .cv-section th, .cv-section td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .cv-section th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <div class="cv-header">
            <div class="cv-photo">
                <!-- Remplacez l'URL de l'image par la photo du candidat -->
                <img src="uploads/<?php echo $candidat['profile_pic']; ?>" alt="Photo du candidat">
            </div>
            <div>
                <h1><?php echo $candidat['prenom'] . ' ' . $candidat['nom']; ?></h1>
                <h2><?php echo $candidat['email']; ?></h2>
                <h2><?php echo $candidat['sexe'] . ', ' . $candidat['pays']; ?></h2>
            </div>
        </div>
        <div class="cv-section">
            <h2>Informations Personnelles</h2>
            <table>
                <tr>
                    <th>Nom</th>
                    <td><?php echo $candidat['nom']; ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo $candidat['prenom']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $candidat['email']; ?></td>
                </tr>
                <tr>
                    <th>Sexe</th>
                    <td><?php echo $candidat['sexe']; ?></td>
                </tr>
                <tr>
                    <th>Pays</th>
                    <td><?php echo $candidat['pays']; ?></td>
                </tr>
                <!-- Ajoutez d'autres informations ici -->
            </table>
        </div>
        <div class="cv-section">
            <h2>Parcours Académique</h2>
            <table>
                <thead>
                    <tr>
                        <th>Diplôme</th>
                        <th>Institution</th>
                        <th>Date d'obtention</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($parcours_academique_result->num_rows > 0): ?>
                        <?php while($row = $parcours_academique_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['diplome']; ?></td>
                                <td><?php echo $row['institution']; ?></td>
                                <td><?php echo $row['date_obtention']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun parcours académique trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="cv-section">
            <h2>Parcours Professionnel</h2>
            <table>
                <thead>
                    <tr>
                        <th>Poste</th>
                        <th>Entreprise</th>
                        <th>Période</th>
                        <th>Pays</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($parcours_professionnel_result->num_rows > 0): ?>
                        <?php while($row = $parcours_professionnel_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['poste']; ?></td>
                                <td><?php echo $row['entreprise']; ?></td>
                                <td><?php echo $row['periode']; ?></td>
                                <td><?php echo $row['pays']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucun parcours professionnel trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="cv-section">
            <h2>Compétences</h2>
            <table>
                <thead>
                    <tr>
                        <th>Intitulé de la compétence</th>
                        <th>Description</th>
                        <th>Outils</th>
                        <th>Références</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($competences_result->num_rows > 0): ?>
                        <?php while($row = $competences_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['skillTitle']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['tools']; ?></td>
                                <td><?php echo $row['references']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucune compétence trouvée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
