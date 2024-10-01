 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
/* Conteneur général */
.container {
    width: 100%;
    overflow-x: auto; /* Rendre le tableau défilable horizontalement si nécessaire */
    margin: 0 auto;
}

/* Stylisation du tableau */
.custom-table {
    width: 100%;
    border-collapse: collapse; /* Fusionne les bordures des cellules */
    font-size: 12px; /* Taille réduite de la police */
}

/* Bordures et espacement */
.custom-table th, .custom-table td {
    border: 1px solid #ddd; /* Ajoute des bordures discrètes */
    padding: 8px; /* Espacement interne */
    text-align: left;
    white-space: nowrap; /* Empêche le texte de déborder sur plusieurs lignes */
}

/* Ajustement des mots longs */
.custom-table td {
    word-break: break-word; /* Casse les mots longs pour éviter qu'ils débordent */
}

/* En-têtes */
.custom-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

/* Alternance de couleurs pour les lignes */
.custom-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Coloration des cellules au survol */
.custom-table tr:hover {
    background-color: #ddd;
}

/* Responsive : Ajuste la taille des colonnes */
@media screen and (max-width: 600px) {
    .custom-table th, .custom-table td {
        font-size: 10px; /* Réduit encore plus la taille des textes pour les petits écrans */
    }
}

    </style>


<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../acceuil.php");
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
    cand.code AS code,
    cand.datee AS datee,
     us.nom AS nomn,
    us.prenom AS prenomn,   

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

LEFT JOIN userss as us on us.id = cand.user_id
WHERE cand.user_id = $userId
GROUP BY us.id
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
    ds.datet AS datee,
    fi.nom AS nomn,
    fi.prenom AS prenomn,   
    '' AS specail, 
    '' AS ecrit, 
    '' AS parle, 
    '' AS permi, 
    '' AS enfant,

    '' AS code,
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

LEFT JOIN userss as fi on fi.id = ds.user_id

WHERE ds.user_id = $userId
";

$resulti = $conn->query($sql);


$sqlDestinataires = "
    SELECT Nom AS Nom, Prenom AS Prenom, Courriel AS Courriel, Ville AS Ville, Tel_Organisation AS Tel_Organisation, Categorie AS Categorie, Organisations AS Organisations FROM client
    UNION
    SELECT nom AS Nom, prenom AS Prenom, email AS Courriel, telephone AS Ville, ville AS Tel_Organisation, '' AS Categorie, '' AS Organisations FROM userss WHERE compte IN ('Entreprise', 'Prestataire')
";

$resultDestinataires = $conn->query($sqlDestinataires);



// Fonction pour effectuer l'action appropriée en fonction du type et de l'identifiant
function handleAction($conn, $action, $id, $type, $newStep = null) {
    $sql = '';
    if ($type == 'candidat') {
        switch ($action) {
            case 'valider':
                $sql = "UPDATE candidats SET validation = 1 WHERE code = ?";
                break;
            case 'payer':
                $sql = "UPDATE candidats SET paiement = 1 WHERE code = ?";
                break;
            case 'changer_etape':
                $sql = "UPDATE candidats SET etape = ? WHERE code = ?";
                break;
            case 'debut_procedure':
                $sql = "UPDATE candidats SET procedure1 = 1 WHERE code = ?";
                break;
            default:
                return "Action non reconnue.";
        }
    } elseif ($type == 'formulaire') {
        switch ($action) {
            case 'valider':
                $sql = "UPDATE formulaire_immigration_session1 SET validation = 1 WHERE codeutilisateur = ?";
                break;
            case 'payer':
                $sql = "UPDATE formulaire_immigration_session2 SET payment = 1 WHERE codeutilisateur = ?";
                break;
            case 'changer_etape':
                $sql = "UPDATE formulaire_immigration_session1 SET etape = ? WHERE codeutilisateur = ?";
                break;
            case 'debut_procedure':
                $sql = "UPDATE formulaire_immigration_session1 SET procedure = 1 WHERE codeutilisateur = ?";
                break;
            default:
                return "Action non reconnue.";
        }
    } else {
        return "Type non reconnu.";
    }

    $stmt = $conn->prepare($sql);
    if ($action == 'changer_etape') {
        $stmt->bind_param('ss', $newStep, $id);
    } else {
        $stmt->bind_param('s', $id);
    }
    if ($stmt->execute()) {
        return "Action exécutée avec succès.";
    } else {
        return "Erreur lors de l'exécution de l'action.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;
    $type = $_POST['type'] ?? null;
    $newStep = $_POST['new_step'] ?? null;

    if ($id && $type) {
        $result = handleAction($conn, $action, $id, $type, $newStep);
        echo $result;
    } else {
        echo "Aucun identifiant ou type fourni pour l'action.";
    }
}

// Fermer la connexion
$conn->close();
?>

<body>
    <div style="" class="container">
        <h1>Dossiers des candidats</h1>  
<div class="container">
    <table class="custom-table">
                <thead class="thead-dark">
                    <tr>
                       
                        <th>Nom</th>
                        <th>Prénom</th>
                    
                        <th>Email</th>
                        
                        <th>Expérience</th>
                
                        <th>Documents</th>
                        <th>Validation</th>
                        <th>État</th>
                        <th>Étape</th>
                        <th>Procédure</th>
                    </tr>
                </thead>
                <tbody>
<?php
$importantFields = ['diplome', 'cv', 'certificat_naissance', 'passeport', 'experience_professionnelle'];

while ($row = $resulti->fetch_assoc()) {
    $statutCertifie = ($row['validation'] === '1') 
        ? '<span style="color :green">Certifié</span>' 
        : '<span style="color :red">Non Certifié</span>';

    $documentsStatus = "Incomplet";
    $documentsStatuss = "Intermédiaire";
    $importantCount = 0;

    foreach ($importantFields as $field) {
        if (!empty($row[$field])) {
            $importantCount++;
        }
    }

    if ($importantCount > 0 && $importantCount < count($importantFields)) {
        $documentsStatuss = "importants ";
    } elseif ($importantCount === count($importantFields)) {
        $documentsStatuss = "Intermédiaire";
    }

    if ($importantCount > 0 && $importantCount < count($importantFields)) {
        $documentsStatus = "Complet";
    } elseif ($importantCount === count($importantFields)) {
        $documentsStatus = "Incomplet";
    }


    $validationStatus = ($row['validation'] === '1') 
        ? '<span style="color :green">Validé</span>' 
        : '<span style="color :red">Non Validé</span>';

    $paymentStatus = ($row['payment'] === '1') 
        ? '<span style="color :green">Payé</span>' 
        : '<span style="color :red">Non Payé</span>';

    $proceduress = ($row['procedure1'] === '1') 
        ? '<span style="color :green">En cours</span>' 
        : '<span style="color :red">Non en cours</span>';

    $currentStep = htmlspecialchars($row['etape'] ?? 'Non spécifié');
    $userCode = htmlspecialchars($row['code'] ?? '');
    $type = htmlspecialchars($row['type'] ?? '');
    $userCodes = htmlspecialchars($row['id'] ?? '');



    $userCode = htmlspecialchars($row['code'] ?? '');
    $type = htmlspecialchars($row['type'] ?? '');
$userCodes = htmlspecialchars($row['id'] ?? '');
                        echo "<tr>";
                          
                        $currentStep = htmlspecialchars($row['etape'] ?? 'Non spécifié');
                        echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['prenom'] ?? '') . "</td>";
                       
                        echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
                       
                        echo "<td>" . htmlspecialchars($row['exp'] ?? '') . "</td>";
                       
                        echo "<td>" . htmlspecialchars($documentsStatus) . "</td>";
                        echo "<td>" . $validationStatus . "</td>";
                        echo "<td>" . $paymentStatus . "</td>";
                        echo "<td>" . htmlspecialchars($currentStep) . "</td>";
                        echo "<td>" . $proceduress . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

