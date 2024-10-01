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

require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        //Server smtp
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@uricanada.com';
        $mail->Password   = 'Succe$$2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SSL;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('info@uricanada.com', 'URI Canada');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "L'e-mail n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }
}

// NOUVEAU : Gestion de la requête AJAX pour l'envoi d'e-mail
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sendEmail') {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    
    $result = sendEmail($to, $subject, $body);
    
    if ($result === true) {
        echo json_encode(['success' => true, 'message' => 'E-mail envoyé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => $result]);
    }
    exit;
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


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<style type="text/css">
/* Global Styling */

/* Table Styling */
.table {
    margin-bottom: 1rem;
    background-color: #fff;
    border-collapse: separate;
    border-spacing: 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table th, 
.table td {
    padding: 12px;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    text-align: center;
    word-wrap: break-word;
}

.table thead th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    border-bottom: 2px solid #007bff;
}

.table tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #e9ecef;
}

.table-responsive {
    display: block;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}


/* Button Styling */
.btn {
    border-radius: 20px;
    padding: 10px 20px;
    margin: 10px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

/* Checkbox Styling */
input[type="checkbox"] {
    transform: scale(1.5);
    margin: 5px;
}


.text-green {
    color: green;
}

.text-red {
    color: red;
}

</style>

    <style>
        .button-container {
            position: relative;
            display: flex;
            justify-content: flex-end;
            margin-top: 20px; /* Ajustez cette valeur pour l'espacement vertical si nécessaire */
        }
        .button-container button {
            margin-left: 10px; /* Espacement entre les boutons */
        }
        .button-container img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>
    <div style="background-color: white;" class="container">
        <h1 style="margin-left: 50%;">Dossiers des candidats</h1>  

    <div class="button-container">
        <button onclick="voirPlus41()">
            <img src="dia.png" title="Diagramme" alt="Diagramme">
        </button>
        <button onclick="voirPlus410()">
            <img src="ajoutt.png" title="Ajouter" alt="Ajouter">
        </button>
    </div>
        <form id="candidateForm">
            <table style="margin-left: -50%; background-color: white;" class="table table-striped table-hover">
                <thead>
                    <tr>

                        <th>Check</th>
                        <th>ID</th>
                        <th>Catégories</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Sexe</th>
                        <th>Pays</th>
                        <th>Code régional</th>
                        <th>Ville</th>
                        <th>Expérience</th>
                        <th>Spécialité</th>
                        <th>Langue écrite</th>
                        <th>Langue parlée</th>
                        <th>Permis</th>
                     
                       
                        <th>Documents Complétés</th>
<th>Validation du Dossier</th>
<th>État du Paiement</th>
<th>Étape Actuelle</th>
<th>Procédure</th>
<th>Actions________________________</th>


                        <!-- Ajoutez d'autres colonnes ici selon vos besoins -->
                    </tr>
                </thead>
                <tbody>
<?php
while ($row = $resulti->fetch_assoc()) {
$documentsComplete = ($row['documents'] === '1') 
    ? '<span class="text-green">Complété</span>' 
    : '<span class="text-red">Incomplet</span>';

$validationStatus = ($row['validation'] === '1') 
    ? '<span class="text-green">Validé</span>' 
    : '<span class="text-red">Non Validé</span>';

$paymentStatus = ($row['payment'] === '1') 
    ? '<span class="text-green">Payé</span>' 
    : '<span class="text-red">Non Payé</span>';

$proceduress = ($row['procedure1'] === '1') 
    ? '<span class="text-green">Encours</span>' 
    : '<span class="text-red">Non Encours</span>';

    $currentStep = htmlspecialchars($row['etape'] ?? 'Non spécifié');



    $userCode = htmlspecialchars($row['code'] ?? '');
    $type = htmlspecialchars($row['type'] ?? '');
$userCodes = htmlspecialchars($row['id'] ?? '');
    echo "<tr>";
    echo "<td><input type='checkbox' class='candidate-checkbox' name='candidates[]' data-nom='" . htmlspecialchars($row['nom'] ?? '') . "' data-prof='" . htmlspecialchars($row['prof'] ?? '') . "' data-city='" . htmlspecialchars($row['city'] ?? '') . "'  data-parle='" . htmlspecialchars($row['parle'] ?? '') . "'  data-pays='" . htmlspecialchars($row['pays'] ?? '') . "'  data-ecrit='" . htmlspecialchars($row['ecrit'] ?? '') . "'  data-prenom='" . htmlspecialchars($row['prenom'] ?? '') . "'  data-poste='" . htmlspecialchars($row['poste'] ?? '') . "' data-entreprise='" . htmlspecialchars($row['entreprise'] ?? '') . "'  data-periode='" . htmlspecialchars($row['periode'] ?? '') . "'     data-payss='" . htmlspecialchars($row['payss'] ?? '') . "'    data-institution='" . htmlspecialchars($row['institution'] ?? '') . "'  data-diplome='" . htmlspecialchars($row['diplome'] ?? '') . "'  data-date_obtention='" . htmlspecialchars($row['date_obtention'] ?? '') . "'   data-intitule='" . htmlspecialchars($row['intitule'] ?? '') . "'  data-description='" . htmlspecialchars($row['description'] ?? '') . "'   data-outils='" . htmlspecialchars($row['outils'] ?? '') . "'  data-references2='" . htmlspecialchars($row['references2'] ?? '') . "'></td>";
    echo "<td>CAND2024" . htmlspecialchars($row['idd'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['categorie'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['prenom'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['prof'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['sexe'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['pays'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['region'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['city'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['exp'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['specail'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['ecrit'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['parle'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['permi'] ?? '') . "</td>";

    echo '<td>' . $documentsComplete . '</td>';
    echo '<td>' . $validationStatus . '</td>';
    echo '<td>' . $paymentStatus . '</td>';
    echo '<td>' . $currentStep . '</td>';
    echo '<td>' . $proceduress . '</td>';
    echo '<td>

        <button type="button" onclick="performAction(\'valider\', \'' . htmlspecialchars($row['id'] ?? '') . '\', \'' . htmlspecialchars($row['type'] ?? '') . '\')"><img style="width : 30px; height: 30px;" src="val.jpg" title="Valider"></button>


        <button type="button" onclick="performAction(\'payer\', \'' . htmlspecialchars($row['id'] ?? '') . '\', \'' . htmlspecialchars($row['type'] ?? '') . '\')"><img style="width : 30px; height: 30px;" src="pay.png" title="Payer"></button>


        <button type="button" onclick="performAction(\'changer_etape\', \'' . htmlspecialchars($row['id'] ?? '') . '\', \'' . htmlspecialchars($row['type'] ?? '') . '\')"><img style="width : 30px; height: 30px;" src="etape.png" title="Changer étape"></button>


        <button type="button" onclick="performAction(\'debut_procedure\', \'' . htmlspecialchars($row['id'] ?? '') . '\', \'' . htmlspecialchars($row['type'] ?? '') . '\')"><img style="width : 30px; height: 30px;" src="proc.png" title="Débuter la procédure"></button>


    <button data-user-code="' . htmlspecialchars($userCodes) . '" onclick="voirPlus(\'' . htmlspecialchars($userCodes) . '\')"><img style="width : 30px; height: 30px;" src="det.png" title="Voir lus"></button>
    
    <button data-user-code="' . htmlspecialchars($userCodes) . '" onclick="voirPlus2(\'' . htmlspecialchars($userCodes) . '\')"><img style="width : 50px; height: 50px;" src="telecharger.avif" title="Télécharger en pdf"></button>

    <button data-user-code="' . htmlspecialchars($userCodes) . '" onclick="voirPlus4(\'' . htmlspecialchars($userCodes) . '\')"><img style="width : 30px; height: 30px;" src="modi.jpg" title="Modifier"></button>


    </td>';
    echo '</tr>';
}
?>

                </tbody>
            </table>
            <button type="button" id="nextBtn" class="btn btn-primary">Suivant</button>
        </form>

        <!-- Section pour sélectionner les entreprises et envoyer les emails -->
        <div id="companySelection" style="display:none;">
            <h2>Sélectionner les entreprises</h2>
            <form id="emailForm">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Checkbox</th>
                            <th>Categorie</th>
                            <th>Organisations</th>
                            <th>Nom</th>
                            
                            <th>Prénom</th>
                            <th>Ville</th>
                            <th>Email</th>
                            <th>Tel Organisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultDestinataires->num_rows > 0) {
                            while ($rowD = $resultDestinataires->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='selected_users[]' data-nom='" . htmlspecialchars($rowD['Nom'] ?? '') . "' value='" . htmlspecialchars($rowD['Courriel'] ?? '') . "'></td>";
                                echo "<td>" . htmlspecialchars($rowD['Categorie'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Organisations'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Nom'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Prenom'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Tel_Organisation'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Courriel'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($rowD['Ville'] ?? '') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Aucune entreprise trouvée.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="button" id="sendEmailBtn" class="btn btn-success">Envoyer les emails</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    function performAction(action, id, type) {
        let newStep = '';
        if (action === 'changer_etape') {
            newStep = prompt('Entrez la nouvelle étape :');
        }
        $.ajax({
            type: 'POST',
            url: '',
            data: {
                action: action,
                id: id,
                type: type,
                new_step: newStep
            },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert('Une erreur est survenue.');
            }
        });
    }

    $(document).ready(function() {
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        var selectedCandidates = document.querySelectorAll('input[name="candidates[]"]:checked');
        if (selectedCandidates.length > 0) {
            document.getElementById('companySelection').style.display = 'block';
            this.style.display = 'none';
        } else {
            alert('Veuillez sélectionner au moins un candidat.');
        }
    });

    document.getElementById('sendEmailBtn').addEventListener('click', function() {
        var selectedEmails = Array.from(document.querySelectorAll('input[name="selected_users[]"]:checked')).map(function(checkbox) {
            return checkbox.value;
        });

        var candidateList = Array.from(document.querySelectorAll('input[name="candidates[]"]:checked')).map(function(checkbox) {
            return {
                nom: checkbox.getAttribute('data-nom'),
                prenom: checkbox.getAttribute('data-prenom'),
                email: checkbox.getAttribute('data-email'),
                tel: checkbox.getAttribute('data-tel'),
                prof: checkbox.getAttribute('data-prof'),
                typeposte: checkbox.getAttribute('data-typeposte'),
                pays: checkbox.getAttribute('data-pays'),
                city: checkbox.getAttribute('data-city'),
                parle: checkbox.getAttribute('data-parle'),
                ecrit: checkbox.getAttribute('data-ecrit'),
                permi: checkbox.getAttribute('data-permi'),
                
                diplome: checkbox.getAttribute('data-diplome'),
                institution: checkbox.getAttribute('data-institution'),
                date_obtention: checkbox.getAttribute('data-date_obtention'),
                poste: checkbox.getAttribute('data-poste'),
                entreprise: checkbox.getAttribute('data-entreprise'),
                periode: checkbox.getAttribute('data-periode'),
                payss: checkbox.getAttribute('data-payss'),
                
                intitule: checkbox.getAttribute('data-intitule'),
                outils: checkbox.getAttribute('data-outils'),
                references2: checkbox.getAttribute('data-references2')
            };
        });

        if (selectedEmails.length === 0) {
            alert('Veuillez sélectionner au moins une entreprise.');
            return;
        }

        var candidateDetails = candidateList.map(function(candidate) {
            return `
${candidate.prof}
CAND2024
Prénom: ${candidate.prenom}
Pays: ${candidate.pays}
Langue parlée: ${candidate.parle}
Langue écrite: ${candidate.ecrit}
Permis de conduire: ${candidate.permi || ''}

Parcours Académique:
Diplome: ${candidate.diplome}
Institution: ${candidate.institution}
Date obtention: ${candidate.date_obtention}

Parcours professionnel:
Poste: ${candidate.poste}
Entreprise: ${candidate.entreprise}
Période: ${candidate.periode}
Pays: ${candidate.payss}

Compétences:
Intitulé: ${candidate.intitule}
Outils: ${candidate.outils}
Références: ${candidate.references2}

----------------------------------------
`;
        }).join('\n\n');

        var mailtoLink = 'mailto:' +
                         '?subject=Informations sur les candidats' + 
                         '&body=' + encodeURIComponent(
                            'Bonjour,\n\n' +
                            'Voici les détails des profils candidats potentiels que nous vous proposons:\n\n' +
                            candidateDetails + '\n\n' +
                            'Laurent  Conseiller | Équipe satisfaction client.\n\n' +
                            '1565, boul. de l’Avenir | Laval (Québec) H7S2N5,\n' +
                            'C 514 584 0440 x 101 ou 514 677-7760 T  450-437-7444'
                         ) +
                         '&bcc=' + encodeURIComponent(selectedEmails.join(','));

    
                          
        // Envoyer un e-mail à chaque destinataire sélectionné
        selectedEmails.forEach(function(email) {
            $.ajax({
                type: 'POST',
                url: 'envoi_email.php',
                data: {
                    action: 'sendEmail',
                    to: email,
                    subject: 'Informations sur les candidats',
                    body: emailBody
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('E-mail envoyé avec succès à ' + email);
                    } else {
                        alert('Erreur lors de l'envoi de l'e-mail à ' + email + ': ' + result.message);
                    }
                },
                error: function() {
                    alert('Une erreur est survenue lors de l'envoi de l'e-mail à ' + email);
                }
            });
        });
    });
    });

    // Fonction pour voir plus de détails
    window.voirPlus = function(code) {
        var url = 'voir_voir_plus.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };

    window.voirPlus2 = function(code) {
        var url = 'voir_voir_plus2.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };
    window.voirPlus4 = function(code) {
        var url = 'modifier.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };

    window.voirPlus41 = function(code) {
        var url = 'etapes2.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };

    window.voirPlus410 = function(code) {
        var url = '../immig/ajout2.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=1200,height=900');
        newWindow.focus();
    };
</script>

</body>
</html>
