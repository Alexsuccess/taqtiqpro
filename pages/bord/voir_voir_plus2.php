<!DOCTYPE html>
<html lang="fr">
<head>
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
$prenom_candidat = htmlspecialchars($candidat['prenom']); // Récupérer le prénom du candidat

// Récupérer le parcours académique
$sql_academique = "SELECT * FROM parcours_academique WHERE code = ?";
$stmt_academique = $conn->prepare($sql_academique);
$stmt_academique->bind_param("s", $code);
$stmt_academique->execute();
$parcours_academique_result = $stmt_academique->get_result();

// Récupérer le parcours professionnel
$sql_professionnel = "SELECT * FROM parcours_professionnel WHERE code = ?";
$stmt_professionnel = $conn->prepare($sql_professionnel);
$stmt_professionnel->bind_param("s", $code);
$stmt_professionnel->execute();
$parcours_professionnel_result = $stmt_professionnel->get_result();

// Récupérer les compétences
$sql_competences = "SELECT * FROM competencess2 WHERE code = ?";
$stmt_competences = $conn->prepare($sql_competences);
$stmt_competences->bind_param("s", $code);
$stmt_competences->execute();
$competences_result = $stmt_competences->get_result();
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV du candidat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f0f0;
        color: #333;
        line-height: 1.6;
    }
    .container {
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
    h1 {
        font-size: 2.5em;
        color: rgb(0,0,64);
        text-align: center;
    }
    h2 {
        font-size: 1.8em;
        color: #555;
        margin-top: 20px;
        border-bottom: 2px solid rgb(0,0,64);

    }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid; /* Empêche la coupure de section entre deux pages */
        }
    p {
        font-size: 1.2em;

    }
    .field-label {
        
        color: #333;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
    li {
  
        border-bottom: 1px dashed #ddd;
        page-break-inside: avoid;
        page-break-after: auto;
    }
    .hide-in-pdf {
        display: block;
        margin-top: 20px;
    }
    .btn {
        padding: 10px 20px;
        font-size: 1.1em;
        color: white;
        background-color: rgb(0,0,64);
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #45a049;
    }
    /* Styles pour l'entête et le pied de page */
    .header {
        text-align: center;
        margin-bottom: 20px;

        border-bottom: 2px solid #ddd;
    }
    .footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 10px;
        border-top: 2px solid #ddd;
        font-size: 0.9em;
        color: #666;
    }
    .header img {
        width: 150px;

    }
</style>
</head>
<body>
    <div class="container">
        <!-- Entête de l'entreprise -->
        <div class="header">
            <img src="logouri.PNG" alt="Logo de l'entreprise"> <!-- Remplacez par le chemin de votre logo -->
                    <p><strong> CV Professionnel</strong>
    </p>
            <p>Service de placement et recrutement local et international <br> location de main-d'œuvre</p>
            <p>(514) 677-7760 | contact@uricanada.com</p>
        </div>


      <h3  style="margin-left: 20%;"> 
        <strong><strong><?php echo htmlspecialchars($candidat['prof']); ?></strong>
    </h3> 
        <!-- Contenu du CV -->
<div class="section">
    <h2>Informations Personnelles</h2>
    <p><strong>Candidat:</strong> <?php echo isset($candidat['prenom']) ? htmlspecialchars($candidat['prenom']) : ''; ?> 00<?php echo isset($candidat['id']) ? htmlspecialchars($candidat['id']) : ''; ?></p>
    <p><strong>Langue parlée:</strong> <?php echo isset($candidat['parle']) ? htmlspecialchars($candidat['parle']) : 'Non spécifié'; ?></p>
    <p><strong>Langue écrite:</strong> <?php echo isset($candidat['ecrit']) ? htmlspecialchars($candidat['ecrit']) : 'Non spécifié'; ?></p>
    <p><strong>Pays:</strong> <?php echo isset($candidat['pays']) ? htmlspecialchars($candidat['pays']) : 'Non spécifié'; ?></p>
    <p><strong>CCQ:</strong> <?php echo isset($candidat['hum']) ? htmlspecialchars($candidat['hum']) : 'Non spécifié'; ?></p>
    <p><strong>ASP:</strong> <?php echo isset($candidat['hum1']) ? htmlspecialchars($candidat['hum1']) : 'Non spécifié'; ?></p>
</div>


        <!-- Ajout des autres sections ici (parcours académique, professionnel, compétences) -->
                <!-- Parcours Professionnel -->
        <div class="section">
            <h2 class="cv-section-title">Parcours Professionnel</h2>
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
        <!-- Parcours Académique -->
        <div class="section">
            <h2 class="cv-section-title">Parcours Académique</h2>
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



        <!-- Compétences -->
        <div class="section">
            <h2 class="cv-section-title">Compétences</h2>
            <?php if ($competences_result->num_rows > 0) { ?>
                <ul>
                    <?php while ($competences = $competences_result->fetch_assoc()) { ?>
                        <li>
                            <p><span class="field-label">Intitulé:</span> <?php echo htmlspecialchars($competences['intitule']); ?></p>
                            <p><span class="field-label">Description:</span> <?php echo htmlspecialchars($competences['description']); ?></p>
                            <p><span class="field-label">Outils:</span> <?php echo htmlspecialchars($competences['outils']); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucune compétence trouvée.</p>
            <?php } ?>
        </div>

        <!-- Pied de page de l'entreprise -->
    <div class="footer">
        <div class="contact-info">
            <span class="icon">📍</span>Üri Canada, Laval, Québec Canada
            <span class="icon">☎️</span> (514) 677-7760
            <span class="icon">📧</span> contact@uricanada.com
        </div>
    </div>

        <!-- Bouton de téléchargement PDF -->
        <button id="downloadPDF" class="btn btn-success hide-in-pdf">Télécharger en PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById("downloadPDF").addEventListener("click", function() {
            // Masquer les éléments avec la classe 'hide-in-pdf' avant la génération du PDF
            var hideElements = document.querySelectorAll('.hide-in-pdf');
            hideElements.forEach(function(el) {
                el.style.display = 'none';
            });

            var element = document.querySelector('.container');
            var opt = {
                margin:       0.5,
                filename:     'cv_candidat_<?php echo $prenom_candidat; ?>.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(element).set(opt).save().then(function() {
                // Réafficher les boutons une fois le PDF généré
                hideElements.forEach(function(el) {
                    el.style.display = 'block';
                });
            });
        });
    </script>
</body>
</html>
