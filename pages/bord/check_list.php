<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Vérification 360</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin-top: 20px;
        }

        .form-container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header img {
            width: 100px;
            margin-bottom: 20px;
        }

        .form-check-list {
            list-style: none;
            padding: 0;
        }

        .form-check-list li {
            margin-bottom: 15px;
        }

        .form-check-list li label {
            margin-left: 10px;
            font-weight: bold;
            color: #007bff; /* Couleur de texte bleu */
        }

        .form-check-list li input[type="checkbox"] {
            margin-right: 10px;
        }

        .text-muted {
            color: #6c757d; /* Texte gris */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 16px;
            padding: 10px 20px;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container form-container">
    <div class="form-header">
        <img src="xxx.PNG" alt="Logo">
        <h2>Check list :</h2>
    </div>
    
    <div class="form-section">
        <p><strong>Procédure d’accréditation.</strong><br>
        Les documents suivants doivent être complétés, signés et retournés au complet pour traitement du dossier :</p>
    </div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Informations de connexion à la base de données
                $servername = "4w0vau.myd.infomaniak.com";
                $username = "4w0vau_dreamize";
                $password = "Pidou2016";
                $dbname = "4w0vau_dreamize";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $convention_service = isset($_POST['convention_service']) ? 1 : 0;
    $formulaire_adhesion = isset($_POST['formulaire_adhesion']) ? 1 : 0;
    $autorisation_image = isset($_POST['autorisation_image']) ? 1 : 0;
    $avis_divulgation = isset($_POST['avis_divulgation']) ? 1 : 0;
    $assurance_responsabilite = isset($_POST['assurance_responsabilite']) ? 1 : 0;
    $accord_debit = isset($_POST['accord_debit']) ? 1 : 0;
    $specimen_cheque = isset($_POST['specimen_cheque']) ? 1 : 0;
    $identite_gouvernementale = isset($_POST['identite_gouvernementale']) ? 1 : 0;
    $licence_rbq = isset($_POST['licence_rbq']) ? 1 : 0;
    $copie_req = isset($_POST['copie_req']) ? 1 : 0;
    $permis_opc = isset($_POST['permis_opc']) ? 1 : 0;
    $contrat_commercant = isset($_POST['contrat_commercant']) ? 1 : 0;
    $formulaire_resolution = isset($_POST['formulaire_resolution']) ? 1 : 0;

    // Préparer et exécuter la requête
    $stmt = $conn->prepare("INSERT INTO formulaire (convention_service, formulaire_adhesion, autorisation_image, avis_divulgation, assurance_responsabilite, accord_debit, specimen_cheque, identite_gouvernementale, licence_rbq, copie_req, permis_opc, contrat_commercant, formulaire_resolution) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiiiiiiiiii", $convention_service, $formulaire_adhesion, $autorisation_image, $avis_divulgation, $assurance_responsabilite, $accord_debit, $specimen_cheque, $identite_gouvernementale, $licence_rbq, $copie_req, $permis_opc, $contrat_commercant, $formulaire_resolution);

    if ($stmt->execute()) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>
    <!-- Formulaire HTML -->
    <form method="POST" action="">
        <ul class="form-check-list">
            <li><input type="checkbox" id="convention_service" name="convention_service"> <label for="convention_service">Convention de service, <strong>signé par tous les actionnaires</strong></label></li>
            <li><input type="checkbox" id="formulaire_adhesion" name="formulaire_adhesion"> <label for="formulaire_adhesion">Formulaire d’adhésion signé</label></li>
            <li><input type="checkbox" id="autorisation_image" name="autorisation_image"> <label for="autorisation_image">Autorisation de l’utilisation d’image <strong>signé</strong></label></li>
            <li><input type="checkbox" id="avis_divulgation" name="avis_divulgation"> <label for="avis_divulgation">Avis de divulgation d’information <strong>signé</strong></label></li>
            <li><input type="checkbox" id="assurance_responsabilite" name="assurance_responsabilite"> <label for="assurance_responsabilite">Copie de la preuve d’assurance responsabilité civile <strong>valide</strong></label></li>
            <li><input type="checkbox" id="accord_debit" name="accord_debit"> <label for="accord_debit">Accord de débit préautorisé <strong>(Rempli et signé)</strong></label></li>
            <li><input type="checkbox" id="specimen_cheque" name="specimen_cheque"> <label for="specimen_cheque">Spécimen de chèque / Carte de crédit <strong>valide</strong></label></li>
            <li><input type="checkbox" id="identite_gouvernementale" name="identite_gouvernementale"> <label for="identite_gouvernementale">Pièce d’identité gouvernementale valide avec photo <strong>(permis de conduire, assurance-maladie)</strong> pour chacun des propriétaires</label></li>
            <li><input type="checkbox" id="licence_rbq" name="licence_rbq"> <label for="licence_rbq">Copie de la licence RBQ <strong>valide</strong></label></li>
            <li><input type="checkbox" id="copie_req" name="copie_req"> <label for="copie_req">Copie REQ <strong>valide</strong></label></li>
        </ul>

        <div class="form-section">
            <p><strong>Si le cas s’applique</strong></p>
            <ul class="form-check-list">
                <li><input type="checkbox" id="permis_opc" name="permis_opc"> <label for="permis_opc">Permis de l’Office de protection du consommateur (OPC) pour les commerçants itinérants <strong>si le cas s’applique</strong></label></li>
                <li><input type="checkbox" id="contrat_commercant" name="contrat_commercant"> <label for="contrat_commercant">Contrat vierge du commerçant itinérant <strong>si le cas s’applique</strong></label></li>
                <li><input type="checkbox" id="formulaire_resolution" name="formulaire_resolution"> <label for="formulaire_resolution">Formulaire de résolution de contrat de l’office de protection du consommateur (OPC)</label></li>
            </ul>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block">Soumettre</button>
    </form>

    <div class="form-section">
        <p class="text-muted"><small><strong>TOUS LES DOCUMENTS RESTENT DANS LES ARCHIVES D’IMMO-SOLUTIONS ET LES COPIES DE PERMIS DANS NOTRE SYSTÈME INFORMATIQUE.</strong></small></p>
        <p><strong>Une fois l’ensemble des documents complétés, faire parvenir par courriel à :</strong><br> Info@immo-solutions.ca</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

