// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

// Récupérer le code du candidat depuis l'URL
if (!isset($_GET['codeutilisateur'])) {
    header("Location: liste_candidats.php");
    exit();
}

$codeutilisateur = $_GET['codeutilisateur'];

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

// Récupérer les informations du candidat avec les compétences associées
$sql = "SELECT 
            c1.Nom, c1.prenom, c1.tel, c1.mail, c1.agen, c1.agent, c1.codeutilisateur, 
            c1.pays, c1.ville, c1.id
        FROM competence1 AS c1
        WHERE c1.codeutilisateur = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codeutilisateur);
$stmt->execute();
$candidat_result = $stmt->get_result();

if ($candidat_result->num_rows == 0) {
    echo "Candidat non trouvé.";
    exit();
}

$candidat = $candidat_result->fetch_assoc();

// Récupérer les compétences du candidat
$skills_sql = "SELECT 
                    skillTitle, description, tools, references
                FROM competence2
                WHERE codeutilisateur = ?";
$skills_stmt = $conn->prepare($skills_sql);
$skills_stmt->bind_param("s", $codeutilisateur);
$skills_stmt->execute();
$skills_result = $skills_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV du candidat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CV Professionnel</h1>
        <div class="section">
            <h2>Informations Personnelles</h2>
            <p><strong>Nom:</strong> <?php echo htmlspecialchars($candidat['Nom']); ?></p>
            <p><strong>Prénom:</strong> <?php echo htmlspecialchars($candidat['prenom']); ?></p>
            <p><strong>Pays:</strong> <?php echo htmlspecialchars($candidat['pays']); ?></p>
            <p><strong>Ville:</strong> <?php echo htmlspecialchars($candidat['ville']); ?></p>
            <p><strong>Agence:</strong> <?php echo htmlspecialchars($candidat['agen']); ?></p>
            <p><strong>Agent:</strong> <?php echo htmlspecialchars($candidat['agent']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($candidat['mail']); ?></p>
            <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($candidat['tel']); ?></p>
        </div>

        <div class="section">
            <h2>Compétences</h2>
            <?php if ($skills_result->num_rows > 0) { ?>
                <ul>
                    <?php while ($skill = $skills_result->fetch_assoc()) { ?>
                        <li>
                            <p><span class="field-label">Intitulé:</span> <?php echo htmlspecialchars($skill['skillTitle']); ?></p>
                            <p><span class="field-label">Description:</span> <?php echo htmlspecialchars($skill['description']); ?></p>
                            <p><span class="field-label">Outils:</span> <?php echo htmlspecialchars($skill['tools']); ?></p>
                            <p><span class="field-label">Références:</span> <?php echo htmlspecialchars($skill['references']); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucune compétence trouvée.</p>
            <?php } ?>
        </div>

        <button id="downloadPDF" class="btn btn-success">Télécharger en PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            html2pdf().from(document.body).save('CV_<?php echo htmlspecialchars($candidat['prenom']); ?>.pdf');
        });
    </script>
</body>
</html>

<?php
// Fermer les connexions
$stmt->close();
$skills_stmt->close();
$conn->close();
?>
