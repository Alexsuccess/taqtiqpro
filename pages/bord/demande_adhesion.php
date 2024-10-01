<!DOCTYPE html>
<html lang="fr">
<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['id'];

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

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom_entreprise = $_POST['nom_entreprise'];
    $adresse_entreprise = $_POST['adresse_entreprise'];
    $telephone_entreprise = $_POST['telephone_entreprise'];
    $fax_entreprise = $_POST['fax_entreprise'];
    $courriel_entreprise = $_POST['courriel_entreprise'];
    $type_societe = $_POST['type_societe'];
    $nom_proprietaire = $_POST['nom_proprietaire'];
    $adresse_proprietaire = $_POST['adresse_proprietaire'];
    $ville_proprietaire = $_POST['ville_proprietaire'];
    $code_postal = $_POST['code_postal'];
    $province = $_POST['province'];
    $telephone_proprietaire = $_POST['telephone_proprietaire'];
    $courriel_proprietaire = $_POST['courriel_proprietaire'];
    $signature_autorisee = $_POST['signature_autorisee'];
    $date_signature = $_POST['date_signature'];
    $nom_signature = $_POST['nom_signature'];
    $titre_signature = $_POST['titre_signature'];

    // Préparer la requête SQL pour insérer les données dans la table
    $sql = "INSERT INTO entreprise_inscription (nom_entreprise, adresse_entreprise, telephone_entreprise, fax_entreprise, courriel_entreprise, type_societe, nom_proprietaire, adresse_proprietaire, ville_proprietaire, code_postal, province, telephone_proprietaire, courriel_proprietaire, signature_autorisee, date_signature, nom_signature, titre_signature)
    VALUES ('$nom_entreprise', '$adresse_entreprise', '$telephone_entreprise', '$fax_entreprise', '$courriel_entreprise', '$type_societe', '$nom_proprietaire', '$adresse_proprietaire', '$ville_proprietaire', '$code_postal', '$province', '$telephone_proprietaire', '$courriel_proprietaire', '$signature_autorisee', '$date_signature', '$nom_signature', '$titre_signature')";

    if ($conn->query($sql) === TRUE) {
        echo "L'inscription a été enregistrée avec succès.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription d'entreprise</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            margin: auto;
            padding: 20px;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        textarea {
            resize: vertical;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .signature-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .signature-section .form-group {
            margin-bottom: 5px;
        }

        .signature-section input[type="text"] {
            background-color: #f5f5f5;
            border: none;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Formulaire d'inscription d'entreprise</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="nom-legal">Nom légal :</label>
            <input type="text" id="nom-legal" name="nom_legal" required>
        </div>

        <div class="form-group">
            <label for="no-permis">No permis :</label>
            <input type="text" id="no-permis" name="no_permis" required>
        </div>

        <div class="form-group">
            <label for="raison-social">Raison sociale :</label>
            <input type="text" id="raison-social" name="raison_sociale" required>
        </div>

        <div class="form-group">
            <label for="neq">NEQ :</label>
            <input type="text" id="neq" name="neq">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="rbq">RBQ :</label>
                <input type="text" id="rbq" name="rbq">
            </div>
            <div class="form-group">
                <label for="apchq">APCHQ :</label>
                <input type="text" id="apchq" name="apchq">
            </div>
        </div>

        <div class="form-group">
            <label for="nom-contact">Nom du contact :</label>
            <input type="text" id="nom-contact" name="nom_contact" required>
        </div>

        <div class="form-group">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required>
        </div>

        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="courriel">Courriel :</label>
                <input type="email" id="courriel" name="courriel" required>
            </div>
        </div>

        <div class="form-group">
            <label for="telecopie">Télécopie :</label>
            <input type="tel" id="telecopie" name="telecopie">
        </div>

        <div class="form-group">
            <label for="site-internet">Site internet :</label>
            <input type="text" id="site-internet" name="site_internet">
        </div>

        <div class="form-group">
            <label for="specialites">Spécialités et catégories souhaités :</label>
            <textarea id="specialites" name="specialites" rows="3"></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="valeur-min">Valeur minimale des produits :</label>
                <input type="number" id="valeur-min" name="valeur_min">
            </div>
            <div class="form-group">
                <label for="valeur-max">Valeur maximale des produits :</label>
                <input type="number" id="valeur-max" name="valeur_max">
            </div>
        </div>

        <div class="form-group">
            <label for="rayon">Rayon (Km) :</label>
            <input type="number" id="rayon" name="rayon">
        </div>

        <div class="form-group">
            <label for="regions-desservies">Régions desservies :</label>
            <input type="text" id="regions-desservies" name="regions_desservies">
        </div>

        <div class="form-group">
            <label for="assureur">Assurance responsabilité - Assureur :</label>
            <input type="text" id="assureur" name="assureur">
        </div>

        <div class="form-group">
            <label for="agent">Agent :</label>
            <input type="text" id="agent" name="agent">
        </div>

        <div class="form-group">
            <label for="date-expiration">Date d'expiration :</label>
            <input type="date" id="date-expiration" name="date_expiration">
        </div>

        <div class="form-group">
            <label for="montant-assure">Montant assuré :</label>
            <input type="text" id="montant-assure" name="montant_assure">
        </div>

        <div class="form-group">
            <label for="numero-police">Numéro de police :</label>
            <input type="text" id="numero-police" name="numero_police">
        </div>

        <h3>PROPRIETAIRE OU PARTENAIRE</h3>

        <div class="form-row">
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="nom-famille">Nom de famille :</label>
                <input type="text" id="nom-famille" name="nom_famille" required>
            </div>
        </div>

        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre">
        </div>

        <div class="form-group">
            <label for="date-naissance">Date de naissance (JJ/MM/AA) :</label>
            <input type="date" id="date-naissance" name="date_naissance">
        </div>

        <div class="form-group">
            <label for="nas">N.A.S. :</label>
            <input type="text" id="nas" name="nas">
        </div>

        <div class="form-group">
            <label for="pourcentage-propriete">Pourcentage de propriété :</label>
            <input type="number" id="pourcentage-propriete" name="pourcentage_propriete" required>
        </div>

        <div class="form-group">
            <label for="adresse-proprietaire">Adresse :</label>
            <input type="text" id="adresse-proprietaire" name="adresse_proprietaire">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="ville-proprietaire">Ville :</label>
                <input type="text" id="ville-proprietaire" name="ville_proprietaire">
            </div>
            <div class="form-group">
                <label for="code-postal">Code postal :</label>
                <input type="text" id="code-postal" name="code_postal">
            </div>
            <div class="form-group">
                <label for="province">Province :</label>
                <input type="text" id="province" name="province">
            </div>
        </div>

        <div class="form-group">
            <label for="telephone-proprietaire">Téléphone :</label>
            <input type="tel" id="telephone-proprietaire" name="telephone_proprietaire">
        </div>

        <div class="form-group">
            <label for="courriel-proprietaire">Courriel :</label>
            <input type="email" id="courriel-proprietaire" name="courriel_proprietaire">
        </div>

        <div class="signature-section">
            <div class="form-group">
                <label for="signature-autorisee">Signature autorisée :</label>
                <input type="text" id="signature-autorisee" name="signature_autorisee">
            </div>
            <div class="form-group">
                <label for="date-signature">Date :</label>
                <input type="date" id="date-signature" name="date_signature">
            </div>
            <div class="form-group">
                <label for="nom-signature">Nom :</label>
                <input type="text" id="nom-signature" name="nom_signature">
            </div>
            <div class="form-group">
                <label for="titre-signature">Titre :</label>
                <input type="text" id="titre-signature" name="titre_signature">
            </div>
        </div>

        <h3>PROPRIETAIRE OU PARTENAIRE 2</h3>

        <!-- Répétez la même section pour un deuxième propriétaire ou partenaire si nécessaire -->

        <button type="submit" class="btn-submit">Soumettre la demande</button>

        <div class="form-footer">
            <p>Par la présente, j’autorise IMMO-SOLUTIONS INC. ou son mandataire à vérifier toutes informations permettant d’évaluer la satisfaction de notre clientèle, la solvabilité auprès de notre institution bancaire ou toute autre compagnie de crédit et/ou fournisseur et transmettre les informations à ses partenaires et collaborateurs de la police d’assurance, la validité de nos licences ainsi que tous renseignements pertinents au dossier. (Ces renseignements demeureront strictement confidentiels et seront utilisé uniquement dans le cadre des activités d’IMMONIVO.)</p>
            <p>Retourner par courriel à : </p>
        </div>
    </form>
</div>

</body>
</html>
