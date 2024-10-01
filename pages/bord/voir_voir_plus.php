<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

// Récupérer le code du candidat depuis l'URL
if (!isset($_GET['code'])) {
    header("Location: liste_candidats.php");
    exit();
}

$code = $_GET['code'];

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
$sql = "SELECT c.*, d.*
        FROM candidats c
        LEFT JOIN documentss d ON c.code = d.code
        WHERE c.code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$candidat_result = $stmt->get_result();

if ($candidat_result->num_rows == 0) {
    echo "Candidat non trouvé.";
    exit();
}

$candidat = $candidat_result->fetch_assoc();

// Récupérer le parcours académique
$sql_academique = "SELECT * FROM parcours_academique WHERE code = ?";
$stmt_academique = $conn->prepare($sql_academique);
$stmt_academique->bind_param("s", $code); // Utiliser "s" pour la chaîne de caractères
$stmt_academique->execute();
$parcours_academique_result = $stmt_academique->get_result();

// Récupérer le parcours professionnel
$sql_professionnel = "SELECT * FROM parcours_professionnel WHERE code = ?";
$stmt_professionnel = $conn->prepare($sql_professionnel);
$stmt_professionnel->bind_param("s", $code); // Utiliser "s" pour la chaîne de caractères
$stmt_professionnel->execute();
$parcours_professionnel_result = $stmt_professionnel->get_result();


// Récupérer le parcours professionnel
$sql_professionnel2 = "SELECT * FROM competencess2 WHERE code = ?";
$stmt_professionnel2 = $conn->prepare($sql_professionnel2);
$stmt_professionnel2->bind_param("s", $code); // Utiliser "s" pour la chaîne de caractères
$stmt_professionnel2->execute();
$parcours_professionnel_result2 = $stmt_professionnel2->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du candidat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .field-label {
            font-weight: bold;
            color: #007bff;
        }
        .document a {
            color: #007bff;
        }
        .document a:hover {
            text-decoration: underline;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
<div class="header">
    <h1>Détails du Candidat</h1>
    <p><strong>CAND00:</strong> <?php echo htmlspecialchars($candidat['id'] ?? 'Non spécifié'); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($candidat['email'] ?? 'Non spécifié'); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($candidat['contact'] ?? 'Non spécifié'); ?></p>
    <p><strong>Profession:</strong> <?php echo htmlspecialchars($candidat['prof'] ?? 'Non spécifié'); ?></p>
    <p><strong>Sexe:</strong> <?php echo htmlspecialchars($candidat['sexe'] ?? 'Non spécifié'); ?></p>
    <p><strong>Pays:</strong> <?php echo htmlspecialchars($candidat['pays'] ?? 'Non spécifié'); ?></p>
</div>

        <div class="section">
            <h2>Parcours Académique</h2>
            <?php if ($parcours_academique_result->num_rows > 0) { ?>
                <ul>
                    <?php while ($parcours_academique = $parcours_academique_result->fetch_assoc()) { ?>
                        <li>
                            <p><span class="field-label">Diplôme:</span> <?php echo htmlspecialchars($parcours_academique['diplome']); ?></p>
                            <p><span class="field-label">Institution:</span> <?php echo htmlspecialchars($parcours_academique['institution']); ?></p>
                            <p><span class="field-label">Date d'obtention:</span> <?php echo htmlspecialchars($parcours_academique['date_obtention']); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucun parcours académique trouvé.</p>
            <?php } ?>
        </div>

        <div class="section">
            <h2>Parcours Professionnel</h2>
            <?php if ($parcours_professionnel_result->num_rows > 0) { ?>
                <ul>
                    <?php while ($parcours_professionnel = $parcours_professionnel_result->fetch_assoc()) { ?>
                        <li>
                            <p><span class="field-label">Poste:</span> <?php echo htmlspecialchars($parcours_professionnel['poste']); ?></p>
                            <p><span class="field-label">Entreprise:</span> <?php echo htmlspecialchars($parcours_professionnel['entreprise']); ?></p>
                            <p><span class="field-label">Période:</span> <?php echo htmlspecialchars($parcours_professionnel['periode']); ?></p>
                            <p><span class="field-label">Pays:</span> <?php echo htmlspecialchars($parcours_professionnel['pays']); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucun parcours professionnel trouvé.</p>
            <?php } ?>
        </div>


        <div class="section">
            <h2>Compétences</h2>
            <?php if ($parcours_professionnel_result2->num_rows > 0) { ?>
                <ul>
                    <?php while ($parcours_professionnel2 = $parcours_professionnel_result2->fetch_assoc()) { ?>
                        <li>
                            <p><span class="field-label">Intitulé:</span> <?php echo htmlspecialchars($parcours_professionnel2['intitule']); ?></p>
                            <p><span class="field-label">Déscription:</span> <?php echo htmlspecialchars($parcours_professionnel2['description']); ?></p>
                            <p><span class="field-label">Outils:</span> <?php echo htmlspecialchars($parcours_professionnel2['outils']); ?></p>
                            <p><span class="field-label">Références:</span> <?php echo htmlspecialchars($parcours_professionnel2['references2']); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucune Compétence trouvée.</p>
            <?php } ?>
        </div>








        <div class="section">
            <h2>Documents</h2>
            <div class="document">
                <span class="field-label">Diplôme:</span> 
                <?php if (!empty($candidat['diplome'])) { ?>
                    <a href="../../uploads/<?php echo htmlspecialchars($candidat['diplome']); ?>" target="_blank">Télécharger</a>
                <?php } else { echo "Absent"; } ?>
            </div>
            <div class="document">
                <span class="field-label">CV:</span> 
                <?php if (!empty($candidat['cv'])) { ?>
                    <a href="../../uploads/<?php echo htmlspecialchars($candidat['cv']); ?>" target="_blank">Télécharger</a>
                <?php } else { echo "Absent"; } ?>
            </div>
            <div class="document">
                <span class="field-label">Certificat de naissance:</span> 
                <?php if (!empty($candidat['certificat_naissance'])) { ?>
                    <a href="../../uploads/<?php echo htmlspecialchars($candidat['certificat_naissance']); ?>" target="_blank">Télécharger</a>
                <?php } else { echo "Absent"; } ?>
            </div>
            <div class="document">
                <span class="field-label">Certificat de scolarité:</span> 
                <?php if (!empty($candidat['certificat_scolarite'])) { ?>
                    <a href="../../uploads/<?php echo htmlspecialchars($candidat['certificat_scolarite']); ?>" target="_blank">Télécharger</a>
                <?php } else { echo "Absent"; } ?>
            </div>
            <div class="document">
                <span class="field-label">Passeport:</span> 
                <?php if (!empty($candidat['passeport'])) { ?>
                    <a href="../../uploads/<?php echo htmlspecialchars($candidat['passeport']); ?>" target="_blank">Télécharger</a>
                <?php } else { echo "Absent"; } ?>
            </div>
        </div>

        <a href="liste_candidats.php" class="btn btn-primary back-button">Retour à la liste des candidats</a>
    </div>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
