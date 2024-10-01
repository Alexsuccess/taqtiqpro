<?php
// Démarrer la session si ce n'est pas déjà fait
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Vérifier si l'ID de l'utilisateur à afficher est spécifié dans l'URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Connexion à la base de données
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $dbname = "4w0vau_dreamize";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Préparer la requête SQL pour récupérer toutes les informations de l'utilisateur
    $sql = "SELECT u.*, 
                   c1.Nom AS competence1_nom, 
                   c1.prenom AS competence1_prenom, 
                   c1.pays AS competence1_pays, 
                   c1.ville AS competence1_ville, 
                   c1.tel AS competence1_tel, 
                   c1.mail AS competence1_mail, 
                   c1.agen AS competence1_agen, 
                   c1.agent AS competence1_agent, 
                   c2.skillTitle AS competence2_title, 
                   c2.description AS competence2_description, 
                   c2.tools AS competence2_tools, 
                   c2.references AS competence2_references, 
                   fis.full_name AS immigration_full_name, 
                   fis.preno AS immigration_preno, 
                   fis.dob AS immigration_dob, 
                   fis.email AS immigration_email, 
                   fis.phone AS immigration_phone, 
                   fis.country AS immigration_country, 
                   fis.city AS immigration_city, 
                   fis.marital_status AS immigration_marital_status, 
                   fis.immigration_type AS immigration_type, 
                   fis.employeur AS immigration_employeur, 
                   fis.education AS immigration_education, 
                   fis.experience AS immigration_experience, 
                   fis.photo AS immigration_photo, 
                   fis.photot AS immigration_photot, 
                   sis.service_agreement AS immigration_service_agreement, 
                   sis.payment AS immigration_payment, 
                   sis.documents AS immigration_documents 
            FROM userss AS u
            LEFT JOIN competence1 AS c1 ON u.id = c1.user_id
            LEFT JOIN competence2 AS c2 ON u.id = c2.user_id
            LEFT JOIN formulaire_immigration_session1 AS fis ON u.id = fis.user_id
            LEFT JOIN formulaire_immigration_session2 AS sis ON u.id = sis.user_id
            WHERE u.id = ?";
    
    // Préparer l'instruction SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de <?php echo htmlspecialchars($row['prenom'] . ' ' . $row['nom']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .cv-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cv-header h1 {
            margin-bottom: 10px;
        }

        .cv-header img {
            max-width: 150px;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .cv-section {
            margin-bottom: 20px;
        }

        .cv-section h2 {
            border-bottom: 2px solid #6c757d;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #343a40;
        }

        .cv-section p {
            margin-bottom: 10px;
        }

        .cv-section ul {
            list-style-type: none;
            padding: 0;
        }

        .cv-section li {
            margin-bottom: 10px;
        }

        .cv-section a {
            color: #007bff;
        }

        .cv-section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container bg-white p-4 rounded shadow">
        <div class="cv-header">
            <h1><?php echo htmlspecialchars($row['prenom'] . ' ' . $row['nom']); ?></h1>
            <?php if (!empty($row['immigration_photot'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($row['immigration_photot']); ?>" alt="Photo de profil">
            <?php endif; ?>
        </div>

        <div class="cv-section">
            <h2>Informations personnelles</h2>
            <p>Email : <?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?></p>
            <p>Téléphone : <?php echo isset($row['telephone']) ? htmlspecialchars($row['telephone']) : ''; ?></p>
            <p>Pays : <?php echo isset($row['pays']) ? htmlspecialchars($row['pays']) : ''; ?></p>
        </div>

        <div class="cv-section">
            <h2>Compétences</h2>
            <ul>
                <li> Nom : <?php echo isset($row['competence1_nom']) ? htmlspecialchars($row['competence1_nom']) : 'Non spécifié'; ?></li>
                <li> Prénom : <?php echo isset($row['competence1_prenom']) ? htmlspecialchars($row['competence1_prenom']) : 'Non spécifiée'; ?></li>
                <li> Pays : <?php echo isset($row['competence1_pays']) ? htmlspecialchars($row['competence1_pays']) : 'Non spécifiée'; ?></li>
                <li> Ville : <?php echo isset($row['competence1_ville']) ? htmlspecialchars($row['competence1_ville']) : 'Non spécifiée'; ?></li>
                <li> Compétence : <?php echo isset($row['competence2_title']) ? htmlspecialchars($row['competence2_title']) : 'Non spécifiée'; ?></li>
                <li> Description : <?php echo isset($row['competence2_description']) ? htmlspecialchars($row['competence2_description']) : 'Non spécifiée'; ?></li>
                <li> Outils : <?php echo isset($row['competence2_tools']) ? htmlspecialchars($row['competence2_tools']) : 'Non spécifiés'; ?></li>
                <li> Références : <?php echo isset($row['competence2_references']) ? htmlspecialchars($row['competence2_references']) : 'Non spécifiés'; ?></li>
            </ul>
        </div>

        <div class="cv-section">
            <h2>Formulaire d'immigration - Session 1</h2>
            <p>Éducation : <?php echo isset($row['immigration_education']) ? htmlspecialchars($row['immigration_education']) : 'Non spécifiée'; ?></p>
            <p>Expérience : <?php echo isset($row['immigration_experience']) ? htmlspecialchars($row['immigration_experience']) : 'Non spécifiée'; ?></p>
            <p>Fonction : <?php echo isset($row['immigration_payment']) ? htmlspecialchars($row['immigration_payment']) : 'Non spécifiée'; ?></p>
        </div>

        <?php
        // Récupérer les documents associés à cet utilisateur
        $sql_documents = "SELECT documents FROM formulaire_immigration_session2 WHERE user_id = ?";
        $stmt_documents = $conn->prepare($sql_documents);
        $stmt_documents->bind_param("i", $user_id);
        $stmt_documents->execute();
        $result_documents = $stmt_documents->get_result();

        if ($result_documents->num_rows > 0) {
        ?>
        <div class="cv-section">
            <h2>Documents</h2>
            <ul>
                <?php while ($row_doc = $result_documents->fetch_assoc()): ?>
                    <?php 
                    // Séparer les documents par virgule
                    $documents = explode(',', $row_doc['documents']); 
                    foreach ($documents as $document):
                        $document = trim($document); // enlever les espaces
                        if (!empty($document)): // vérifier si le document n'est pas vide
                    ?>
                        <li><?php echo htmlspecialchars($document); ?>: <a href="uploads/<?php echo htmlspecialchars($document); ?>" target="_blank">Voir le document</a></li>
                    <?php endif; endforeach; ?>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php } ?>

        <div class="cv-section">
            <h2>Statut</h2>
            <p><?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Non spécifié'; ?></p>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        echo "Utilisateur non trouvé.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID utilisateur non spécifié.";
}
?>
