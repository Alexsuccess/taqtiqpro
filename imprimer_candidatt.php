<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Récupérer l'ID du candidat depuis les paramètres GET
$candidatId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

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

// Récupérer les informations du candidat
$candidat_sql = "SELECT rr.id, rr.nom, rr.prenom, rr.email, rr.sexe, rr.pays, ff.profile_pic 
                 FROM candidats rr 
                 LEFT JOIN userss ff ON rr.user_id = ff.id 
                 WHERE rr.user_id = ?";
$stmt = $conn->prepare($candidat_sql);
$stmt->bind_param("i", $candidatId);
$stmt->execute();
$candidat_result = $stmt->get_result()->fetch_assoc();

// Récupérer les parcours académiques
$parcours_academique_sql = "SELECT * FROM parcours_academique WHERE user_id = ?";
$parcours_academique_stmt = $conn->prepare($parcours_academique_sql);
$parcours_academique_stmt->bind_param("i", $candidatId);
$parcours_academique_stmt->execute();
$parcours_academique_result = $parcours_academique_stmt->get_result();

// Récupérer les parcours professionnels
$parcours_professionnel_sql = "SELECT * FROM parcours_professionnel WHERE user_id = ?";
$parcours_professionnel_stmt = $conn->prepare($parcours_professionnel_sql);
$parcours_professionnel_stmt->bind_param("i", $candidatId);
$parcours_professionnel_stmt->execute();
$parcours_professionnel_result = $parcours_professionnel_stmt->get_result();

// Récupérer les compétences
$competences_sql = "SELECT * FROM competence2 WHERE user_id = ?";
$competences_stmt = $conn->prepare($competences_sql);
$competences_stmt->bind_param("i", $candidatId);
$competences_stmt->execute();
$competences_result = $competences_stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV du Candidat</title>
    <style>
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
                <?php if (isset($candidat_result['profile_pic']) && !empty($candidat_result['profile_pic'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($candidat_result['profile_pic']); ?>" alt="Photo du candidat">
                <?php else: ?>
                    <p>Photo du candidat</p>
                <?php endif; ?>
            </div>
            <div>
                <h1><?php echo isset($candidat_result['prenom']) ? htmlspecialchars($candidat_result['prenom'] . ' ' . $candidat_result['nom']) : 'Nom inconnu'; ?></h1>
                <h2><?php echo isset($candidat_result['email']) ? htmlspecialchars($candidat_result['email']) : 'Email inconnu'; ?></h2>
                <h2><?php echo isset($candidat_result['sexe']) && isset($candidat_result['pays']) ? htmlspecialchars($candidat_result['sexe'] . ', ' . $candidat_result['pays']) : 'Sexe et pays inconnus'; ?></h2>
            </div>
        </div>
        <div class="cv-section">
            <h2>Informations Personnelles</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo isset($candidat_result['id']) ? htmlspecialchars($candidat_result['id']) : 'ID inconnu'; ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo isset($candidat_result['nom']) ? htmlspecialchars($candidat_result['nom']) : 'Nom inconnu'; ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo isset($candidat_result['prenom']) ? htmlspecialchars($candidat_result['prenom']) : 'Prénom inconnu'; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo isset($candidat_result['email']) ? '<a href="mailto:' . htmlspecialchars($candidat_result['email']) . '">' . htmlspecialchars($candidat_result['email']) . '</a>' : 'Email inconnu'; ?></td>
                </tr>
                <tr>
                    <th>Sexe</th>
                    <td><?php echo isset($candidat_result['sexe']) ? htmlspecialchars($candidat_result['sexe']) : 'Sexe inconnu'; ?></td>
                </tr>
                <tr>
                    <th>Pays</th>
                    <td><?php echo isset($candidat_result['pays']) ? htmlspecialchars($candidat_result['pays']) : 'Pays inconnu'; ?></td>
                </tr>
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
                                <td><?php echo htmlspecialchars($row['diplome']); ?></td>
                                <td><?php echo htmlspecialchars($row['institution']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_obtention']); ?></td>
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
                                <td><?php echo htmlspecialchars($row['poste']); ?></td>
                                <td><?php echo htmlspecialchars($row['entreprise']); ?></td>
                                <td><?php echo htmlspecialchars($row['periode']); ?></td>
                                <td><?php echo htmlspecialchars($row['pays']); ?></td>
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
                                <td><?php echo htmlspecialchars($row['skillTitle']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['tools']); ?></td>
                                <td><?php echo htmlspecialchars($row['references']); ?></td>
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
