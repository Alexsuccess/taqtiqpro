<?php
// Établir la connexion à la base de données (remplacez les valeurs par les vôtres)
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données soumises par le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier et récupérer les données de la section "bureau-section"
    $region = isset($_POST['region']) ? $_POST['region'] : '';
    $bureau_type = isset($_POST['bureau_type']) ? $_POST['bureau_type'] : '';
    $periode_du = isset($_POST['periode_du']) ? $_POST['periode_du'] : '';


    $nom_usuel = isset($_POST['nom_usuel']) ? $_POST['nom_usuel'] : '';
    $nom_legal = isset($_POST['nom_legal']) ? $_POST['nom_legal'] : '';
    $dirigeant = isset($_POST['dirigeant']) ? $_POST['dirigeant'] : '';
    $titre = isset($_POST['titre']) ? $_POST['titre'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
    $municipalite = isset($_POST['municipalite']) ? $_POST['municipalite'] : '';
    $facturation = isset($_POST['facturation']) ? $_POST['facturation'] : '';
    $facturation_municipalite = isset($_POST['facturation_municipalite']) ? $_POST['facturation_municipalite'] : '';
    $telephone_bureau = isset($_POST['telephone_bureau']) ? $_POST['telephone_bureau'] : '';
    $telephone_cell = isset($_POST['telephone_cell']) ? $_POST['telephone_cell'] : '';
    $telephone_res = isset($_POST['telephone_res']) ? $_POST['telephone_res'] : '';
    $courriel = isset($_POST['courriel']) ? $_POST['courriel'] : '';
    $rbq = isset($_POST['rbq']) ? $_POST['rbq'] : '';
    $neq = isset($_POST['neq']) ? $_POST['neq'] : '';




    $periode_au = isset($_POST['periode_au']) ? $_POST['periode_au'] : '';
    $num_membre = isset($_POST['num_membre']) ? $_POST['num_membre'] : '';
    $categorie_membre = isset($_POST['categorie_membre']) ? $_POST['categorie_membre'] : '';

    // Vérifier et récupérer les données de la section "membershipForm"
    $revue = isset($_POST['revue']) ? $_POST['revue'] : '';
    $consent = isset($_POST['consent']) ? $_POST['consent'] : '';
    $don = isset($_POST['don']) ? $_POST['don'] : '';
    $donAutre = isset($_POST['donAutre']) ? $_POST['donAutre'] : '';

    // Vérifier et récupérer les données de la section "7. Paiement"
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $montantCotisation = isset($_POST['montantCotisation']) ? $_POST['montantCotisation'] : '';
    $chargeAdditionnelle = isset($_POST['chargeAdditionnelle']) ? $_POST['chargeAdditionnelle'] : '';
    $sousTotal = isset($_POST['sousTotal']) ? $_POST['sousTotal'] : '';
    $tps = isset($_POST['tps']) ? $_POST['tps'] : '';
    $tvq = isset($_POST['tvq']) ? $_POST['tvq'] : '';
    $donFondation = isset($_POST['donFondation']) ? $_POST['donFondation'] : '';
    $totalDu = isset($_POST['totalDu']) ? $_POST['totalDu'] : '';

    // Requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO membres (region, bureau_type, periode_du, periode_au, num_membre, categorie_membre, nom_usuel, nom_legal, dirigeant, titre, adresse, municipalite, facturation, facturation_municipalite, telephone_bureau, telephone_cell, telephone_res, courriel, rbq, neq,
            revue, consent, don, don_autre, categorie, montant_cotisation, charge_additionnelle, sous_total, tps, tvq, don_fondation, total_du)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Préparer la requête
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête SQL : " . $conn->error;
    } else {
        // Liage des paramètres et exécution de la requête
        $stmt->bind_param("ssssssssssssssssssssssssssssssss", 
                        $region, $bureau_type, $periode_du, $periode_au, $num_membre, $categorie_membre, $nom_usuel, $nom_legal, $dirigeant, $titre, $adresse, $municipalite, $facturation, $facturation_municipalite, $telephone_bureau, $telephone_cell, $telephone_res, $courriel, $rbq, $neq,
                        $revue, $consent, $don, $donAutre,
                        $categorie, $montantCotisation, $chargeAdditionnelle, $sousTotal, $tps, $tvq, $donFondation, $totalDu);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Les données ont été enregistrées avec succès.";
        } else {
            echo "Erreur : " . $stmt->error;
        }

        // Fermer la déclaration
        $stmt->close();
    }

    // Fermer la connexion
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <style type="text/css">
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header {
    text-align: center;
    margin-bottom: 20px;
}

.logo {
    width: 100px;
    display: block;
    margin: 0 auto;
}

h1 {
    font-size: 1.2em;
    color: #333;
    margin-bottom: 10px;
}

section {
    margin-bottom: 20px;
}

.bureau-section,
.identification-section {
    background-color: #e5f3ff;
    border: 1px solid #000;
    padding: 10px;
}

.bureau-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bureau-header label {
    font-weight: bold;
}

.bureau-header select {
    padding: 5px;
    border: 1px solid red;
}

.bureau-details {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
    margin-top: 10px;
}

.radio-group,
.bureau-details div {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.radio-group input {
    margin-bottom: 5px;
}

.radio-group label,
.bureau-details label {
    font-weight: bold;
    text-align: center;
    margin-bottom: 5px;
}

.bureau-details input {
    padding: 5px;
    border: 1px solid #ccc;
}

.periode {
    grid-column: span 2;
}

.periode input {
    width: calc(50% - 10px);
    margin-right: 10px;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
    width: 48%;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input {
    padding: 5px;
    border: 1px solid #ccc;
}

input[placeholder="Bureau"],
input[placeholder="Cell."],
input[placeholder="Rés."] {
    width: calc(33.33% - 10px);
    margin-right: 10px;
}

#membershipForm {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    width: 100%;
}

.section {
    margin-bottom: 20px;
}

h3 {
    font-size: 16px;
    margin-bottom: 10px;
    color: #333;
}

label {
    display: block;
    margin-bottom: 10px;
    font-size: 14px;
}

input[type="radio"],
input[type="checkbox"] {
    margin-right: 10px;
}

input[type="text"],
input[type="email"] {
    padding: 8px;
    margin-left: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: calc(100% - 20px);
}

.payment-details label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.payment-details input[type="text"] {
    width: 100px;
    text-align: right;
}

.payment-details input[type="text"]:first-of-type {
    width: calc(100% - 120px);
}













.container {
    width: 70%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header {
    text-align: center;
    margin-bottom: 20px;
}

.header-top, .header-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.header-top div, .header-bottom div {
    flex: 1;
    padding: 10px;
}

.header-bottom div {
    text-align: center;
}

.header-bottom div:last-child {
    font-size: 24px;
    font-weight: bold;
    color: red;
}

header label, header input, header p, header span {
    display: block;
    margin-bottom: 5px;
}

header input {
    width: 80%;
    padding: 5px;
    border: 1px solid #ccc;
}

.form-section {
    background-color: #e5f3ff;
    border: 1px solid #000;
    padding: 10px;
    text-align: center;
}

.form-section .logo {
    text-align: left;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
    width: 90%;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input, .form-group textarea {
    padding: 5px;
    border: 1px solid #ccc;
    width: calc(100% - 10px);
}
















body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-section {
    background-color: #e5f3ff;
    border: 1px solid #000;
    padding: 20px;
    margin-bottom: 20px;
}

.form-section h3 {
    background-color: #ccc;
    padding: 10px;
    margin: -20px -20px 20px -20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.checkbox-group, .radio-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.checkbox-group label, .radio-group label {
    margin: 0 10px 0 0;
}

textarea {
    padding: 10px;
    border: 1px solid #ccc;
    width: 100%;
    margin-top: 10px;
    height: 80px;
}

input[type="checkbox"], input[type="radio"] {
    margin-right: 5px;
}


button[type="submit"]:hover {
    background-color: #45a049;
}

/* Responsive adjustments */
@media screen and (max-width: 600px) {
    .container {
        padding: 10px;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    select {
        font-size: 12px;
    }
}
















body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    background-color: #444;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    text-transform: uppercase;
}

.section {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.options {
    margin-bottom: 10px;
}

.options input {
    margin-right: 10px;
}

textarea {
    width: 100%;
    height: 80px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

.initials-section {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.initials-section label {
    margin-right: 10px;
}

.initials-section input {
    width: 50px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}












body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    background-color: #444;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    text-transform: uppercase;
}

.section {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.options {
    margin-bottom: 10px;
}

.options input {
    margin-right: 10px;
}

textarea {
    width: 100%;
    height: 80px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

.initials-section {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.initials-section label {
    margin-right: 10px;
}

.initials-section input {
    width: 50px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}















h3 {
    background-color: #ddd;
    padding: 10px;
    border-radius: 4px;
    margin: 20px 0 10px;
}

.section {
    margin-bottom: 20px;
}

.section label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
}

.section div {
    margin-bottom: 10px;
}

.section input[type="radio"] {
    margin: 0 5px 0 0;
}

.section textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.signature label, .signature input[type="text"], .signature input[type="date"] {
    display: inline-block;
    width: 30%;
    margin-right: 5%;
}

.signature input[type="text"], .signature input[type="date"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}


    </style>
</head>
<body>

        <div  class="container">
        <header>
            <img src="logo.png" alt=" Logo" class="logo">
            <h1>Formulaire d'inscription de membre de l'Association des professionnels de la construction et de l'habitation du Québec</h1>
        </header>
        <form style="width: 97%;" method="POST" action="" id="membershipForm">
        <section  class="bureau-section">
            <div class="bureau-header">
                <label for="region">Région</label>
                <select id="region">
                    <option value="">Veuillez choisir la région</option>
                    <!-- Ajouter des options supplémentaires ici -->
                </select>
            </div>
            <div class="bureau-details">
                <div class="radio-group">
                    <input type="radio" id="conditionnel" name="bureau_type" value="conditionnel">
                    <label for="conditionnel">Condi-<br>tionnel</label>
                </div>
                <div class="radio-group">
                    <input type="radio" id="adhesion" name="bureau_type" value="adhesion">
                    <label for="adhesion">Adhésion</label>
                </div>
                <div class="radio-group">
                    <input type="radio" id="renouvellement" name="bureau_type" value="renouvellement">
                    <label for="renouvellement">Renou-<br>vellement</label>
                </div>
                <div class="radio-group">
                    <input type="radio" id="reinte-gration" name="bureau_type" value="reinte-gration">
                    <label for="reinte-gration">Réinté-<br>gration</label>
                </div>
                <div class="periode">
                    <label>Période en vigueur</label>
                    <input type="text" name="periode_du" placeholder="Du">
                    <input type="text" name="periode_au" placeholder="Au">
                </div>
                <div>
                    <label>No du membre</label>
                    <input type="text" name="num_membre">
                </div>
                <div>
                    <label>Catégorie de membre</label>
                    <input type="text" name="categorie_membre">
                </div>
            </div>
        </section>


        <section style="width: 98%;" class="identification-section">
            <h2>2. Identification du membre (CARACTÈRES D'IMPRIMERIE)</h2>
            
                <div class="form-group">
                    <label for="nom_usuel">Nom usuel de l’entreprise (Nom d’emprunt)</label>
                    <input type="text" id="nom_usuel" name="nom_usuel">
                </div>
                <div class="form-group">
                    <label for="nom_legal">Nom légal de l’entreprise (Incluant le nom de tous les sodétenaires, selon le cas)</label>
                    <input type="text" id="nom_legal" name="nom_legal">
                </div>
                <div class="form-group">
                    <label for="dirigeant">Nom du principal dirigeant de l’entreprise</label>
                    <input type="text" id="dirigeant" name="dirigeant">
                    <label for="titre">Titre ou fonction</label>
                    <input type="text" id="titre" name="titre">
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse de l’entreprise</label>
                    <input type="text" id="adresse" name="adresse">
                    <label for="municipalite">Municipalité / Province / Code Postal</label>
                    <input type="text" id="municipalite" name="municipalite">
                </div>
                <div class="form-group">
                    <label for="facturation">Adresse de facturation (si différente)</label>
                    <input type="text" id="facturation" name="facturation">
                    <label for="facturation_municipalite">Municipalité / Province / Code Postal</label>
                    <input type="text" id="facturation_municipalite" name="facturation_municipalite">
                </div>
                <div class="form-group">
                    <label>Téléphones</label>
                    <input type="text" id="telephone_bureau" name="telephone_bureau" placeholder="Bureau">
                    <input type="text" id="telephone_cell" name="telephone_cell" placeholder="Cell.">
                    <input type="text" id="telephone_res" name="telephone_res" placeholder="Rés.">
                </div>
                <div class="form-group">
                    <label for="courriel">Courrier électronique</label>
                    <input type="email" id="courriel" name="courriel">
                </div>
                <div class="form-group">
                    <label for="rbq">Dossier R.B.Q. #</label>
                    <input type="text" id="rbq" name="rbq">
                    <label for="neq">Numéro d’entreprise du Québec (NEQ)</label>
                    <input type="text" id="neq" name="neq">
                </div>
           
        </section>
    </div>

    <div style="width:  70%; margin-left: 15%; background-color: white;"  >
        <div  class="section">
            <h3>3. Désirez-vous recevoir gratuitement la revue QUÉBEC HABITATION?</h3>
            <label><input type="radio" name="revue" value="oui"> Oui</label>
            <label><input type="radio" name="revue" value="non"> Non</label>
        </div>
        <div class="section">
            <h3>Je consens à recevoir par messagerie électronique...</h3>
            <label><input type="radio" name="consent" value="oui"> Oui</label>
            <label><input type="radio" name="consent" value="non"> Non</label>
        </div>
        <div class="section">
            <h3>4. En payant les frais d’adhésion, votre entreprise désire-t-elle faire un don annuel à la Fondation de l’?</h3>
            <label><input type="radio" name="don" value="5%"> 5%</label>
            <label><input type="radio" name="don" value="15%"> 15%</label>
            <label><input type="radio" name="don" value="25%"> 25%</label>
            <label><input type="radio" name="don" value="autre"> Autre: <input type="text" name="donAutre" size="4"> </label>
            <label><input type="checkbox" name="taxReceipt"> Un reçu d’impôt sera émis à l’entreprise pour tout montant égal ou supérieur à 25$.</label>
        </div>
        <div class="section">
            <h3>5. Privilège de membre et Règlements généraux</h3>
            <p>Nous désirons devenir membre actif de l’Association régionale mentionnée au présent formulaire ainsi que de l’Association des professionnels de la construction
et de l’habitation du Québec inc. Nous reconnaissons pouvoir consulter les Règlements généraux de ces deux (2) associations à leur siège social respectif et ce,
pendant les heures raisonnables d’affaires. Nous nous engageons à respecter ces Règlements généraux intégralement. Toutes modifications inhérentes aux
informations contenues sur la présente devront être transmises sans délai à votre Association régionale.
Sous réserve des Règlements généraux et du paiement des frais de cotisation, la qualité de membre sera renouvelée d’année en année pour une durée d’un an
additionnel commençant à la date anniversaire de sa délivrance. Lors du renouvellement, toutes les informations déjà enregistrées à l’Association régionale seront
reconduites si cette dernière reçoit uniquement un chèque couvrant les frais de cotisation, sans note de changement(s). Nous reconnaissons que les deux (2) asso-
ciations peuvent nous expulser comme membre si nous ne respectons pas leurs Règlements généraux. Nous reconnaissons que ces deux (2) associations ne seront
pas tenues de renouveler notre qualité de membre, et qu’à défaut de paiement à la date anniversaire, notre statut de membre sera annulé après soixante (60) jours</p>
        </div>
        <div class="section">
            <h3>6. Engagement de l’entreprise</h3>
            <p>L’entreprise s’engage à respecter toutes les obligations prévues au présent formulaire et certifie que les renseignements donnés dans celui-ci, ainsi que tous les
documents qui l’accompagnent sont vrais, exacts et complets. L’entreprise autorise l’Association des professionnels de la construction et de l’habitation du
Québec inc. et la Régionale à vérifier leur véracité auprès de toute personne et s’engage à leur fournir, sur demande, tout consentement écrit à cette fin</p>
        </div>
        <div class="section">
            <h3>7. Paiement</h3>
            <label>Catégorie de membre </label>
            <label><input type="radio" name="categorie" value="general"> Général</label>
            <label><input type="radio" name="categorie" value="specialise"> Spécialisé</label>
            <label><input type="radio" name="categorie" value="fournisseur"> Fournisseur</label>
            <label><input type="radio" name="categorie" value="associe"> Associé</label>

            <div class="payment-details">
                <label>Montant de la cotisation: <input type="text" name="montantCotisation" id="montantCotisation" value="0.00$"></label>
                <label>Charge additionnelle: <input type="text" name="chargeAdditionnelle" id="chargeAdditionnelle" value="200.00$"></label>
                <label>Sous-total: <input type="text" name="sousTotal" id="sousTotal" value="0.00$"></label>
                <label>TPS: <input type="text" name="tps" id="tps" value="0.00$"></label>
                <label>TVQ: <input type="text" name="tvq" id="tvq" value="0.00$"></label>
                <label>Don Fondation: <input type="text" name="donFondation" id="donFondation" value="0.00$"></label>
                <label>Total dû: <input type="text" name="totalDu" id="totalDu" value="0.00$"></label>
            </div>
        </div>
    </div>

    <div class="container">
        <header>
            <div class="header-top">
                <div>
                    <label for="region">Faire le chèque à l'ordre de</label>
                    <input type="text" id="region" name="region" placeholder="Veuillez choisir la région">
                </div>
                <div>
                    <p>Un avis de cotisation vous sera transmis.</p>
                </div>
            </div>
            <div class="header-bottom">
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom">
                    <span>(EN LETTRES MOULÉES)</span>
                </div>
                <div>
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date">
                    <span>(année / mois / jour)</span>
                </div>
                <div>
                    <p>Signature du représentant dûment autorisé de l'entreprise</p>
                </div>
                <div>
                    <p>00000</p>
                </div>
            </div>
        </header>
        <section style="width: 96%;" class="form-section">

            
                <div class="form-group">
                    <label for="nom_legal">NOM LÉGAL DE L'ENTREPRISE :</label>
                    <input type="text" id="nom_legal" name="nom_legal">
                </div>
                <div class="form-group">
                    <label for="num_membre">N° DE MEMBRE  :</label>
                    <input type="text" id="num_membre" name="num_membre" value="2222222222">
                </div>
                <div class="form-group">
                    <label for="num_dossier_rbq">N° DE DOSSIER RBQ :</label>
                    <input type="text" id="num_dossier_rbq" name="num_dossier_rbq">
                </div>
                <div class="form-group">
                    <label for="principal_dirigeant">NOM DU PRINCIPAL DIRIGEANT (personne physique) :</label>
                    <input type="text" id="principal_dirigeant" name="principal_dirigeant">
                </div>
                <div class="form-group">
                    <label for="autres_dirigeants">NOM DES AUTRES DIRIGEANTS :</label>
                    <textarea id="autres_dirigeants" name="autres_dirigeants"></textarea>
                    <p>(personne physique étant soit administrateur, répondant RBQ ou actionnaire de plus de 20 %)</p>
                </div>
            
        </section>
    </div>

    <div class="container">
        <!-- Section 1: TYPE DE CAUTIONNEMENT REQUIS -->
        <section class="form-section">
            <h3>1. TYPE DE CAUTIONNEMENT REQUIS</h3>
            <div class="form-group">
                <input type="checkbox" id="cautionnement1" name="cautionnement1">
                <label for="cautionnement1">1.1 L'entreprise désire obtenir le cautionnement de licence de la Régie du bâtiment du Québec (RBQ) par police d'assurance cautionnement collective offert par l'Association des professionnels de construction et de l'habitation du Québec inc. (APCHQ) prévu aux articles 27 et 28 du <em>Règlement sur la qualification des entrepreneurs et des constructeurs propriétaires</em> (L.R.Q. c. B-1.1 r.1) (ci-après "Règlement sur la qualification").</label>
            </div>
            <div class="form-group">
                <input type="checkbox" id="cautionnement2" name="cautionnement2">
                <label for="cautionnement2">1.2 L'entreprise désire obtenir le cautionnement pour fraude, malversation ou détournement de fonds (FMD) prévu à l'article 78 du <em>Règlement sur le plan de garantie des bâtiments résidentiels neufs</em> (L.R.Q. c. B-1.1 r.8) (ci-après "Règlement sur le plan de garantie") en faveur de la Garantie de Construction résidentielle GCR.</label>
            </div>
        </section>
        <!-- Section 2: LICENCES -->
        <section class="form-section">
            <h3>2. LICENCES</h3>
            <div class="form-group">
                <label for="licences">2.1 Votre entreprise demande ou détient la ou les sous-catégories de licence suivantes (cocher toutes les cases qui s'appliquent) :</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="entrepreneur_general" name="entrepreneur_general">
                    <label for="entrepreneur_general">Entrepreneur général 1.1.1 et/ou 1.1.2</label>
                    <input type="checkbox" id="entrepreneur_autre" name="entrepreneur_autre">
                    <label for="entrepreneur_autre">Entrepreneur général autre</label>
                    <input type="checkbox" id="entrepreneur_specialise" name="entrepreneur_specialise">
                    <label for="entrepreneur_specialise">Entrepreneur spécialisé</label>
                </div>
            </div>
            <div class="form-group">
                <label>2.2 Une licence a-t-elle déjà été refusée ou révoquée par la RBQ à une entreprise dont vous ou l'un des autres dirigeants de votre entreprise avez été le dirigeant?</label>
                <div class="radio-group">
                    <input type="radio" id="licence_refusee_oui" name="licence_refusee" value="oui">
                    <label for="licence_refusee_oui">Oui</label>
                    <input type="radio" id="licence_refusee_non" name="licence_refusee" value="non">
                    <label for="licence_refusee_non">Non</label>
                </div>
                <textarea id="details_licence_refusee" name="details_licence_refusee" placeholder="Si oui, précisez l'entreprise, la date et les raisons du refus ou de la révocation (joindre une annexe si requis)."></textarea>
            </div>
            <div class="form-group">
                <label>2.3 Une demande de cautionnement de licence a-t-elle déjà été refusée ou un cautionnement a-t-il déjà été révoqué par une caution (assureur, association ou autre), pour l'une des entreprises dont vous ou l'un des autres dirigeants de votre entreprise avez été le dirigeant?</label>
                <div class="radio-group">
                    <input type="radio" id="caution_refusee_oui" name="caution_refusee" value="oui">
                    <label for="caution_refusee_oui">Oui</label>
                    <input type="radio" id="caution_refusee_non" name="caution_refusee" value="non">
                    <label for="caution_refusee_non">Non</label>
                </div>
                <textarea id="details_caution_refusee" name="details_caution_refusee" placeholder="Si oui, précisez l'entreprise, le nom de la caution, la date et les raisons du refus ou de la révocation (joindre une annexe si requis)."></textarea>
            </div>
        </section>
    </div>














    <div class="container">
        <h3>3. INSOLVABILITÉ ET LITIGES</h3>
        
            <div class="section">
                <label for="question-3-1">
                    3.1 Au cours des trois (3) dernières années, vous-même, l’un des dirigeants de votre entreprise ou l’une des entreprises pour lesquelles vous ou l’un des dirigeants de votre entreprise avez été dirigeant avez fait une proposition à vos créanciers ou une faillite?
                </label>
                <div class="options">
                    <input type="radio" id="q3-1-yes" name="q3-1" value="yes">
                    <label for="q3-1-yes">Oui</label>
                    <input type="radio" id="q3-1-no" name="q3-1" value="no">
                    <label for="q3-1-no">Non</label>
                </div>
                <label for="details-3-1">Si oui, précisez l’entreprise le cas échéant et la date de la proposition ou de la faillite et fournissez le certificat de libération, le cas échéant.</label>
                <textarea id="details-3-1" name="details-3-1"></textarea>
            </div>

            <div class="section">
                <label for="question-3-2">
                    3.2 Au cours des trois (3) dernières années avez-vous ou l’un des dirigeants de votre entreprise été dirigeant d’une entreprise de construction dans les douze (12) mois précédant la cessation d’activités d’entrepreneur de cette entreprise?
                </label>
                <div class="options">
                    <input type="radio" id="q3-2-yes" name="q3-2" value="yes">
                    <label for="q3-2-yes">Oui</label>
                    <input type="radio" id="q3-2-no" name="q3-2" value="no">
                    <label for="q3-2-no">Non</label>
                </div>
                <label for="details-3-2">Si oui, précisez l’entreprise, la cause de la cessation des activités et la date de cette cessation (joindre une annexe si requis).</label>
                <textarea id="details-3-2" name="details-3-2"></textarea>
            </div>

            <div class="initials-section">
                <label for="initials">INITIALES</label>
                <input type="text" id="initials" name="initials">
            </div>

            <h3>3. INSOLVABILITÉ ET LITIGES (SUITE)</h3>

            <div class="section">
                <label for="question-3-3">
                    3.3 Est-ce que vous-même, les dirigeants de votre entreprise, ou la ou les entreprises pour lesquelles vous êtes ou avez été dirigeant a/ont actuellement des jugements rendus condamnant au paiement de sommes qui n'ont pas été acquittées?
                </label>
                <div class="options">
                    <input type="radio" id="q3-3-yes" name="q3-3" value="yes">
                    <label for="q3-3-yes">Oui</label>
                    <input type="radio" id="q3-3-no" name="q3-3" value="no">
                    <label for="q3-3-no">Non</label>
                </div>
                <label for="details-3-3">Si oui, précisez la personne ou l'entreprise en défaut, le numéro de dossier de cour, le montant dû et les raisons du non-paiement.</label>
                <textarea id="details-3-3" name="details-3-3"></textarea>
            </div>
            

       <div class="container">
        <h3>3. INSOLVABILITÉ ET LITIGES</h3>
        
            <div class="section">
                <label for="question-3-1">
                    3.1 Au cours des trois (3) dernières années, vous-même, l’un des dirigeants de votre entreprise ou l’une des entreprises pour lesquelles vous ou l’un des dirigeants de votre entreprise avez été dirigeant avez fait une proposition à vos créanciers ou une faillite?
                </label>
                <div class="options">
                    <input type="radio" id="q3-1-yes" name="q3-1" value="yes">
                    <label for="q3-1-yes">Oui</label>
                    <input type="radio" id="q3-1-no" name="q3-1" value="no">
                    <label for="q3-1-no">Non</label>
                </div>
                <label for="details-3-1">Si oui, précisez l’entreprise le cas échéant et la date de la proposition ou de la faillite et fournissez le certificat de libération, le cas échéant.</label>
                <textarea id="details-3-1" name="details-3-1"></textarea>
            </div>

            <div class="section">
                <label for="question-3-2">
                    3.2 Au cours des trois (3) dernières années avez-vous ou l’un des dirigeants de votre entreprise été dirigeant d’une entreprise de construction dans les douze (12) mois précédant la cessation d’activités d’entrepreneur de cette entreprise?
                </label>
                <div class="options">
                    <input type="radio" id="q3-2-yes" name="q3-2" value="yes">
                    <label for="q3-2-yes">Oui</label>
                    <input type="radio" id="q3-2-no" name="q3-2" value="no">
                    <label for="q3-2-no">Non</label>
                </div>
                <label for="details-3-2">Si oui, précisez l’entreprise, la cause de la cessation des activités et la date de cette cessation (joindre une annexe si requis).</label>
                <textarea id="details-3-2" name="details-3-2"></textarea>
            </div>

            <div class="initials-section">
                <label for="initials">INITIALES</label>
                <input type="text" id="initials" name="initials">
            </div>

            <h3>3. INSOLVABILITÉ ET LITIGES (SUITE)</h3>

            <div class="section">
                <label for="question-3-3">
                    3.3 Est-ce que vous-même, les dirigeants de votre entreprise, ou la ou les entreprises pour lesquelles vous êtes ou avez été dirigeant a/ont actuellement des jugements rendus condamnant au paiement de sommes qui n'ont pas été acquittées?
                </label>
                <div class="options">
                    <input type="radio" id="q3-3-yes" name="q3-3" value="yes">
                    <label for="q3-3-yes">Oui</label>
                    <input type="radio" id="q3-3-no" name="q3-3" value="no">
                    <label for="q3-3-no">Non</label>
                </div>
                <label for="details-3-3">Si oui, précisez la personne ou l'entreprise en défaut, le numéro de dossier de cour, le montant dû et les raisons du non-paiement.</label>
                <textarea id="details-3-3" name="details-3-3"></textarea>
            </div>

            <h3>4. OBLIGATIONS</h3>

            <div class="section">
                <label for="obligations-4-1">
                    4.1 Sur approbation de la présente demande, L’APCHQ s’engage à fournir le ou les cautionnement(s) requis au paragraphe 1 du présent formulaire.
                </label>
            </div>
            <div class="section">
                <label for="obligations-4-2">
                    4.2 L’entreprise s’engage à indemniser l’APCHQ pour tout dommage que cette dernière aura subi suite à un paiement effectué conformément au Règlement sur la qualification ou au Règlement sur le plan de garantie.
                </label>
            </div>
            <div class="section">
                <label for="obligations-4-3">
                    4.3 Le cautionnement de licence RBQ sera valide à compter de la date indiquée au certificat de cautionnement pour tout détenteur de licence ou à compter de l’émission de la licence. L’APCHQ pourra, à sa seule discrétion, mettre fin au cautionnement sur avis écrit d’au moins soixante (60) jours à la RBQ et à l’entreprise.
                </label>
            </div>
            <div class="section">
                <label for="obligations-4-4">
                    4.4 Le cautionnement FMD sera valide à compter de la date qui est indiquée au certificat de cautionnement, émis par l’APCHQ en faveur de la Garantie de construction résidentielle (GCR), lorsque son titulaire est détenteur de la licence RBQ sous-catégorie 1.1.1 et/ou 1.1.2 ou à compter de l’émission de la licence. L’APCHQ pourra, à sa seule discrétion, mettre fin au cautionnement sur avis écrit d’au moins soixante (60) jours à la GCR et à l’entreprise.
                </label>
            </div>

            <h3>5. ENGAGEMENT DE L’ENTREPRISE — VÉRACITÉ DES RENSEIGNEMENTS — SIGNATURE OBLIGATOIRE DE L’ENTREPRISE</h3>

            <div class="section">
                <label for="engagement">
                    L’entreprise s’engage à respecter toutes les obligations prévues au présent formulaire et certifie que les renseignements donnés dans celui-ci, ainsi que tous les documents qui l’accompagnent sont vrais, exacts et complets. L’entreprise autorise l’APCHQ, en vertu de la Loi sur la protection des renseignements personnels dans le secteur privé (L.R.Q. c. P-39.1), à recueillir auprès de tiers, détenir ou communiquer à des tiers toute information requise pour vérifier l’exactitude des renseignements fournis.
                </label>
            </div>





























    <div class="container">
        <h3>3. INSOLVABILITÉ ET LITIGES</h3>
        <form>
            <div class="section">
                <label>3.1 Au cours des trois (3) dernières années, vous-même, l’un des dirigeants de votre entreprise ou l’une des entreprises pour lesquelles vous ou l’un des dirigeants de votre entreprise avez été dirigeant avez fait une proposition à vos créanciers ou une faillite?</label>
                <div>
                    <input type="radio" name="q3_1" id="q3_1_oui" value="oui">
                    <label for="q3_1_oui">Oui</label>
                    <input type="radio" name="q3_1" id="q3_1_non" value="non">
                    <label for="q3_1_non">Non</label>
                </div>
                <label>Si oui, précisez l’entreprise le cas échéant et la date de la proposition ou de la faillite et fournissez le certificat de libération, le cas échéant.</label>
                <textarea name="details_q3_1" rows="4"></textarea>
            </div>
            <div class="section">
                <label>3.2 Au cours des trois (3) dernières années avez-vous ou l’un des dirigeants de votre entreprise été dirigeant d’une entreprise de construction dans les douze (12) mois précédant la cessation d’activités d’entrepreneur de cette entreprise?</label>
                <div>
                    <input type="radio" name="q3_2" id="q3_2_oui" value="oui">
                    <label for="q3_2_oui">Oui</label>
                    <input type="radio" name="q3_2" id="q3_2_non" value="non">
                    <label for="q3_2_non">Non</label>
                </div>
                <label>Si oui, précisez l’entreprise, la cause de la cessation des activités et la date de cette cessation (joindre une annexe si requis) :</label>
                <textarea name="details_q3_2" rows="4"></textarea>
            </div>
            <div class="section">
                <label>Initiales</label>
                <table>
                    <tr>
                        <td><input type="text" name="initiales_1"></td>
                        <td><input type="text" name="initiales_2"></td>
                        <td><input type="text" name="initiales_3"></td>
                    </tr>
                </table>
            </div>
        </form>

        <h3>4. OBLIGATIONS</h3>
        <p>4.1 Sur approbation de la présente demande, L’APCHQ s’engage à fournir le ou les cautionnement(s) requis au paragraphe 1 du présent formulaire.</p>
        <p>4.2 L’entreprise s’engage à indemniser l’APCHQ pour tout dommage que cette dernière aura subi suite à un paiement effectué conformément au Règlement sur la qualification ou au Règlement sur le plan de garantie.</p>
        <p>4.3 Le cautionnement de licence RBQ sera valide à compter de la date qui est indiquée au certificat de cautionnement pour tout détenteur de licence ou à compter de l’émission de la licence. L’APCHQ pourra, à sa seule discrétion, mettre fin au cautionnement sur avis écrit d’au moins soixante (60) jours à la RBQ et à l’entreprise.</p>
        <p>4.4 Le cautionnement FMD sera valide à compter de la date qui est indiquée au certificat de cautionnement, émis par l’APCHQ en faveur de la Garantie de construction résidentielle (GCR), lorsque son titulaire est détenteur de la licence RBQ sous-catégorie 1.1.1 et/ou 1.1.2 ou à compter de l’émission de la licence. L’APCHQ pourra, à sa seule discrétion, mettre fin au cautionnement sur avis écrit d’au moins soixante (60) jours à la GCR et à l’entreprise.</p>

        <h3>5. ENGAGEMENT DE L’ENTREPRISE — VÉRACITÉ DES RENSEIGNEMENTS — SIGNATURE OBLIGATOIRE DE L’ENTREPRISE</h3>
        <p>L’entreprise s’engage à respecter toutes les obligations prévues au présent formulaire et certifie que les renseignements donnés dans celui-ci, ainsi que tous les documents qui l’accompagnent sont vrais, exacts et complets. L’entreprise autorise l’APCHQ, en vertu de la Loi sur la protection des renseignements personnels dans le secteur privé (L.R.Q. c. P-39.1), à recueillir auprès de tiers, détenir ou communiquer à des tiers intéressés tous les renseignements pertinents pouvant être requis.</p>
        <div class="signature">
            <label>Nom du dirigeant dûment autorisé (en lettres moulées)</label>
            <input type="text" name="nom_dirigeant">
            <label>Date</label>
            <input type="date" name="date_dirigeant">
            <label>Signature du dirigeant dûment autorisé</label>
            <input type="text" name="signature_dirigeant">
        </div>

        <h3>6. CAUTION PERSONNELLE DU(DES) PRINCIPAL(PRINCIPAUX) DIRIGEANT(S)</h3>
        <p>Je (nous) soussigné(e)(s), déclare (déclarons) que tous les renseignements contenus dans ce formulaire sont vrais et reconnaît (reconnaissons) que toute fausse déclaration est passible d’une sanction pouvant aller à la révocation du cautionnement ou même de l’adhésion à titre de membre. J’autorise (nous autorisons) l’APCHQ, en vertu de la Loi sur la protection des renseignements personnels dans le secteur privé (L.R.Q. c. P-39.1), à recueillir auprès de tiers, détenir ou communiquer à des tiers intéressés tous les renseignements personnels pertinents pouvant être requis.</p>
        <p>Je (nous), soussigné(e)(s), convient (conviennent) de m’engager (nous engager) solidairement avec l’entreprise identifiée aux présentes, envers l’APCHQ, à titre de caution, pour toute obligation découlant de l’application du Règlement sur la qualification (cautionnement RBQ) et/ou du Règlement sur le plan de garantie (cautionnement FMD).</p>
        
        <div class="section">
            <table>
                <tr>
                    <td><label for="nom_1">NOM (EN LETTRES MOULÉES)</label></td>
                    <td><input  name="nom_1" id="nom_1" rows="2"></td>
                    <td><label for="date_naissance_1">Date de naissance (année / mois / jour)</label></td>
                    <td><input name="date_naissance_1" id="date_naissance_1" rows="2"></td>
                </tr>
                <tr>
                    <td><label for="signature_1">Signature</label></td>
                    <td><input name="signature_1" id="signature_1" rows="2"></td>
                    <td><label for="date_signature_1">Date de signature</label></td>
                    <td><input name="date_signature_1" id="date_signature_1" rows="2"></td>
                </tr>
                <tr>
                    <td><label for="nom_2">NOM (EN LETTRES MOULÉES)</label></td>
                    <td><input name="nom_2" id="nom_2" rows="2"></td>
                    <td><label for="date_naissance_2">Date de naissance (année / mois / jour)</label></td>
                    <td><input name="date_naissance_2" id="date_naissance_2" rows="2"></td>
                </tr>
                <tr>
                    <td><label for="signature_2">Signature</label></td>
                    <td><input name="signature_2" id="signature_2" rows="2"></td>
                    <td><label for="date_signature_2">Date de signature</label></td>
                    <td><input name="date_signature_2" id="date_signature_2" rows="2"></td>
                </tr>
                <tr>
                    <td><label for="nom_3">NOM (EN LETTRES MOULÉES)</label></td>
                    <td><input name="nom_3" id="nom_3" rows="2"></td>
                    <td><label for="date_naissance_3">Date de naissance (année / mois / jour)</label></td>
                    <td><input name="date_naissance_3" id="date_naissance_3" rows="2"></td>
                </tr>
                <tr>
                    <td><label for="signature_3">Signature</label></td>
                    <td><input name="signature_3" id="signature_3" rows="2"></td>
                    <td><label for="date_signature_3">Date de signature</label></td>
                    <td><input name="date_signature_3" id="date_signature_3" rows="2"></td>
                </tr>
            </table>
        </div>
    </div>

<button style="
    background-color: #45a049;
    color: #fff;
    padding: 12px 24px;
    border: none;
    margin-left: 80%;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s ease;
" type="submit">Valider</button>
<br><br>
</form>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const montantCotisation = document.getElementById('montantCotisation');
    const chargeAdditionnelle = document.getElementById('chargeAdditionnelle');
    const sousTotal = document.getElementById('sousTotal');
    const tps = document.getElementById('tps');
    const tvq = document.getElementById('tvq');
    const donFondation = document.getElementById('donFondation');
    const totalDu = document.getElementById('totalDu');

    function calculateTotal() {
        const montant = parseFloat(montantCotisation.value.replace('$', '')) || 0;
        const charge = parseFloat(chargeAdditionnelle.value.replace('$', '')) || 0;
        const don = parseFloat(donFondation.value.replace('$', '')) || 0;

        const subTotal = montant + charge;
        const tpsAmount = subTotal * 0.05;
        const tvqAmount = subTotal * 0.09975;
        const total = subTotal + tpsAmount + tvqAmount + don;

        sousTotal.value = subTotal.toFixed(2) + '$';
        tps.value = tpsAmount.toFixed(2) + '$';
        tvq.value = tvqAmount.toFixed(2) + '$';
        totalDu.value = total.toFixed(2) + '$';
    }

    montantCotisation.addEventListener('input', calculateTotal);
    chargeAdditionnelle.addEventListener('input', calculateTotal);
    donFondation.addEventListener('input', calculateTotal);

    calculateTotal(); // initial calculation
});


    </script>

</body>
</html>
