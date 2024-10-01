<!DOCTYPE html>
<html lang="fr">
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

// Requête SQL pour obtenir les données des candidats et formulaires d'immigration
$sql = "
SELECT 
    cand.categorie AS categorie, 
    cand.nom AS nom, 
    cand.prenom AS prenom, 
    cand.email AS email,
    cand.id AS idd,
    cand.etape AS etape,
    cand.validation AS validation,
    cand.procedure1 AS procedure1, 
    cand.prof AS prof,
    cand.paiement AS payment, 
    cand.sexe AS sexe, 
    cand.pays AS pays, 
    cand.city AS ville, 
    cand.region AS region, 
    cand.exp AS exp, 
    CONCAT_WS(', ', 
        COALESCE(doc.diplome, ''), 
        COALESCE(doc.cv, ''), 
        COALESCE(doc.certificat_naissance, ''), 
        COALESCE(doc.certificat_scolarite, ''), 
        COALESCE(doc.passeport, ''), 
        COALESCE(doc.attestation_etude, ''), 
        COALESCE(doc.plan_cadre, ''), 
        COALESCE(doc.attestation_enregistrement, ''), 
        COALESCE(doc.releve_note, ''), 
        COALESCE(doc.experience_professionnelle, ''), 
        COALESCE(doc.permis_conduire, ''), 
        COALESCE(doc.mandat_representation, ''), 
        COALESCE(doc.acte_mariage, '')
    ) AS documents, 
    cand.specail AS specail, 
    cand.ecrit AS ecrit, 
    cand.parle AS parle, 
    cand.permi AS permi, 
    cand.enfant AS enfant,



    proff.poste AS poste,
    proff.entreprise AS entreprise,
    proff.periode AS periode,
    proff.pays AS payss,
    acc.diplome AS diplome,
    acc.institution AS institution,
    acc.date_obtention AS date_obtention,
    comp.intitule AS intitule,
    comp.description AS description,
    comp.outils AS outils,
    comp.references2 AS references2,




    '' AS codeutilisateur,
    cand.code AS id, -- Ajout de l'identifiant pour les candidats
    'candidat' AS type -- Ajout d'un type pour identifier la table
FROM candidats AS cand
LEFT JOIN documentss AS doc ON cand.code = doc.code

LEFT JOIN parcours_academique AS acc on acc.code = cand.code

LEFT JOIN parcours_professionnel AS proff on proff.code = cand.code

LEFT JOIN competencess2 AS comp on comp.code = cand.code

WHERE cand.user_id = $userId
UNION


SELECT 
    '' AS categorie,
    ds.full_name AS nom, 
    ds.preno AS prenom, 
    ds.email AS email,
    ds.etape AS etape,  
    ds.payment2 AS payment,
    ds.id AS idd,
    ds.procedurei AS procedure1,
    ds.validation AS validation,
    ff.payment AS prof,
    ff.documents AS documents,
    '' AS sexe, 
    ds.country AS pays, 
    ds.city AS ville, 
    '' AS region, 
    ds.experience AS exp, 
    '' AS specail, 
    '' AS ecrit, 
    '' AS parle, 
    '' AS permi, 
    '' AS enfant,


    '' AS poste,
    '' AS entreprise,
    '' AS periode,
    '' AS payss,
    '' AS diplome,
    '' AS institution,
    '' AS date_obtention,
    '' AS intitule,
    '' AS description,
    '' AS outils,
    '' AS references2,





    ds.codeutilisateur AS codeutilisateur, -- Utilisation du codeutilisateur pour les formulaires
    ds.codeutilisateur AS id, -- Ajout de l'identifiant pour les formulaires
    'formulaire' AS type -- Ajout d'un type pour identifier la table
FROM 
    formulaire_immigration_session1 AS ds 
LEFT JOIN 
    formulaire_immigration_session2 AS ff 
ON 
    ds.codeutilisateur = ff.codeutilisateur
WHERE 
    ds.codeutilisateur IS NOT NULL
    AND ds.user_id = $userId
";
$result = $conn->query($sql);

// Fermer la connexion
$conn->close();
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étapes de Progression</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .step-wrapper {
            margin: 20px 0;
        }
        .step-wrapper-inner {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .step {
            position: relative;
            width: 180px;
            padding: 10px;
            color: white;
            font-weight: bold;
        }
        .step.completed {
            background-color: #3498db;
        }
        .step:not(.completed) {
            background-color: #7f8c8d;
        }
        .arrow {
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-top: 50px solid #3498db;
            margin-top: 20px;
        }
        .step.completed .arrow {
            border-top-color: #e67e22;
        }
        .step-title {
            margin-top: 10px;
        }
        .step-point {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #2980b9;
            margin: 0 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Les délais varient selon le pays de résidence et le pays de diplomation.</h2>
        <p>Le candidat n’est pas soumis aux étapes 3 et 4 s’il détient ou détiendra un permis de travail ouvert.</p>
    </div>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="step-wrapper">
            <div class="person-info">
                <h3><?php echo htmlspecialchars($row['prenom'] . ' ' . $row['nom']); ?></h3>
                <p><strong>Profession:</strong> <?php echo htmlspecialchars($row['prof']); ?></p>
            </div>
            <div class="step-wrapper-inner">
                <?php
                $etape = (int)$row['etape'];
                $titles = [
                    1 => "SÉLECTION",
                    2 => "OBTENIR L'ADMISSIBILITÉ",
                    3 => "DÉMARCHES POUR OBTENIR LE CAQ",
                    4 => "DÉMARCHES POUR OBTENTION DU PERMIS DE TRAVAIL",
                    5 => "INTÉGRATION EN EMPLOI"
                ];
                for ($i = 1; $i <= 5; $i++):
                    $isCompleted = $i <= $etape;
                ?>
                    <div class="step <?php echo $isCompleted ? 'completed' : ''; ?>">
                        <div>Étape <?php echo $i; ?></div>
                        <div class="arrow <?php echo $isCompleted ? 'completed' : ''; ?>"></div>
                        <div class="step-title"><?php echo $titles[$i]; ?></div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
