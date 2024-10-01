<?php
// Vérifier si le code utilisateur à afficher est spécifié dans l'URL
if (isset($_GET['codeutilisateur'])) {
    $codeutilisateur = $_GET['codeutilisateur'];

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

    // Récupérer les informations de l'utilisateur à partir du `codeutilisateur`
    $sql = "SELECT * FROM userss ";
    $stmt = $conn->prepare($sql);
 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $nom = $user['nom'];
        $prenom = $user['prenom'];
        $type = $user['type'];
        $statut = $user['statut'];
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }

    // Récupérer les données des sessions de formulaire
    $sql1 = "SELECT * FROM formulaire_immigration_session1 WHERE codeutilisateur = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $codeutilisateur);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $session1 = $result1->fetch_assoc();

    $sql2 = "SELECT * FROM formulaire_immigration_session2 WHERE codeutilisateur = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $codeutilisateur);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $session2 = $result2->fetch_assoc();

    $sql3 = "SELECT * FROM formulaire_immigration_session3 WHERE codeutilisateur = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $codeutilisateur);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $session3 = $result3->fetch_assoc();

    // Récupérer les compétences
    $sqlComp1 = "SELECT * FROM competence1 WHERE codeutilisateur = ?";
    $stmtComp1 = $conn->prepare($sqlComp1);
    $stmtComp1->bind_param("i", $codeutilisateur);
    $stmtComp1->execute();
    $resultComp1 = $stmtComp1->get_result();
    $competences1 = $resultComp1->fetch_all(MYSQLI_ASSOC);

    $sqlComp2 = "SELECT * FROM competence2 WHERE codeutilisateur = ?";
    $stmtComp2 = $conn->prepare($sqlComp2);
    $stmtComp2->bind_param("i", $codeutilisateur);
    $stmtComp2->execute();
    $resultComp2 = $stmtComp2->get_result();
    $competences2 = $resultComp2->fetch_all(MYSQLI_ASSOC);

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Code utilisateur non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de <?php echo htmlspecialchars($prenom . ' ' . $nom); ?></title>
       <div class="section">
       
        <div class="photo">
            <img src="uploads/<?php echo htmlspecialchars($session1['photo']); ?>">
        </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
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
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
        }
        .section p {
            margin: 5px 0;
        }
        .photo {
            text-align: center;
        }
        .photo img {
            max-width: 150px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><?php echo htmlspecialchars($session1['full_name']); ?> <?php echo htmlspecialchars($session1['preno']); ?></h1>
      
    </div>

    <div class="section">
        <h2>Informations Personnelles</h2>
        <p><strong>Nom Complet:</strong> <?php echo htmlspecialchars($session1['full_name']); ?></p>
        <p><strong>Prénom:</strong> <?php echo htmlspecialchars($session1['preno']); ?></p>
        <p><strong>Date de Naissance:</strong> <?php echo htmlspecialchars($session1['dob']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($session1['email']); ?></p>
        <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($session1['phone']); ?></p>
        <p><strong>Pays:</strong> <?php echo htmlspecialchars($session1['country']); ?></p>
        <p><strong>Ville:</strong> <?php echo htmlspecialchars($session1['city']); ?></p>
        <p><strong>État Civil:</strong> <?php echo htmlspecialchars($session1['marital_status']); ?></p>
    </div>

 

    <div class="section">
        <h2>Message</h2>
        <p><?php echo nl2br(htmlspecialchars($session1['experience'])); ?></p>
    </div>

    <div class="section">
        <h2>Compétences</h2>
        <?php foreach ($competences1 as $comp1): ?>
            <h3><?php echo htmlspecialchars($comp1['Nom'] . ' ' . $comp1['prenom']); ?></h3>
         
        <?php endforeach; ?>
        <?php foreach ($competences2 as $comp2): ?>
            <h3><?php echo htmlspecialchars($comp2['skillTitle']); ?></h3>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($comp2['description'])); ?></p>
            <p><strong>Outils:</strong> <?php echo htmlspecialchars($comp2['tools']); ?></p>
            <p><strong>Références:</strong> <?php echo htmlspecialchars($comp2['references']); ?></p>
        <?php endforeach; ?>
    </div>

    <div class="section">
        <h2>Accord de Service et Paiement</h2>
        <p><strong>Accord de Service:</strong> <?php echo $session2['service_agreement'] ? 'Oui' : 'Non'; ?></p>
        <p><strong>Profession:</strong> <?php echo htmlspecialchars($session2['payment']); ?></p>
        <p><strong>Documents:</strong>
    <?php
    // Séparer les documents par une virgule ou un autre séparateur approprié
    $documents = explode(',', $session2['documents']);
    foreach ($documents as $document) {
        // Supprimer les espaces blancs au début et à la fin
        $document = trim($document);
        // Afficher le lien vers le document
        echo '<a href="uploads/' . htmlspecialchars($document) . '" target="_blank">' . htmlspecialchars($document) . '</a><br>';
    }
    ?>
</p>

    </div>

    <div class="section">
        <h2>Validation Client et Paiement Final</h2>
        <p><strong>Validation Client:</strong> <?php echo $session3['client_approval'] ? 'Oui' : 'Non'; ?></p>
        <p><strong>Paiement Final:</strong> <?php echo htmlspecialchars($session3['final_payment']); ?></p>
        <p><strong>Méthode de Paiement:</strong> <?php echo htmlspecialchars($session3['payment_method']); ?></p>
    </div>
</div>

</body>
</html>
