<?php
// Configuration de la base de données
$host = '4w0vau.myd.infomaniak.com';
$dbname = '4w0vau_dreamize';
$username = '4w0vau_dreamize';
$password = 'Pidou2016';

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom_demandeur = $_POST['nom_demandeur'];
    $nom_entreprise = $_POST['nom_entreprise'];
    $adresse_entreprise = $_POST['adresse_entreprise'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];
    $courriel = $_POST['courriel'];
    $description = $_POST['description'];
    $regions = isset($_POST['regions']) ? implode(", ", $_POST['regions']) : "";

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO partenairess (nom_demandeur, nom_entreprise, adresse_entreprise, ville, code_postal, telephone, courriel, description, regions)
            VALUES (:nom_demandeur, :nom_entreprise, :adresse_entreprise, :ville, :code_postal, :telephone, :courriel, :description, :regions)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_demandeur', $nom_demandeur);
    $stmt->bindParam(':nom_entreprise', $nom_entreprise);
    $stmt->bindParam(':adresse_entreprise', $adresse_entreprise);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':code_postal', $code_postal);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':courriel', $courriel);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':regions', $regions);

    if ($stmt->execute()) {
        echo "Les données ont été enregistrées avec succès.";
    } else {
        echo "Une erreur est survenue lors de l'enregistrement des données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment devenir partenaire - Immonivo</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
        }

        header, footer {
            background-color: #333;
            color: #fff;
            padding: 1em 0;
            text-align: center;
        }

        header h1, footer nav ul {
            margin: 0;
            padding: 0;
        }

        footer nav ul {
            list-style: none;
        }

        footer nav ul li {
            display: inline;
            margin-right: 15px;
        }

        footer nav ul li a {
            text-decoration: none;
            color: #fff;
        }

        main {
            padding: 1em;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            color: #444;
            border-bottom: 2px solid #333;
            padding-bottom: 0.5em;
        }

        form {
            background-color: #f9f9f9;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 0.5em 0 0.2em;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        textarea {
            height: 100px;
        }

        button {
            display: inline-block;
            padding: 0.5em 2em;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .regions label {
            display: block;
            margin-bottom: 0.5em;
        }

        .regions input {
            margin-right: 0.5em;
        }

        #intro, #form-section, #advertisement {
            margin-bottom: 2em;
        }

        #advertisement ul {
            list-style: disc;
            margin-left: 1em;
        }

        #advertisement ul li {
            margin-bottom: 0.5em;
        }

        #advertisement a {
            color: #5cb85c;
            text-decoration: none;
        }

        #advertisement a:hover {
    </style>
</head>
<body>
    <header>
        <h1>Comment devenir partenaire</h1>
    </header>
    <main>
        <section id="intro">
            <p>Les partenaires recommandés d’Immonivo passent tous par un processus de vérification rigoureux afin d’offrir les meilleurs. Ce qui nous permet de proposer des entreprises professionnelles les plus fiables du pays à nos membres.</p>
            <p>Vous désirez offrir vos services dans le répertoire des partenaires d’IMMONIVO? Soumettez votre candidature en suivant les étapes ci-dessous :</p>
            <ul>
                <li>L’entreprise doit avoir un minimum de deux (2) années de vie</li>
                <li>Elle doit aussi offrir ses services dans</li>
                <li>La vérification de ses compétences sera effectuée de façon très approfondie</li>
            </ul>
            <p>Merci de compléter les documents appropriés mentionné ci-dessous :</p>
            <ul>
                <li>Remplissez le formulaire d’adhésion en ligne</li>
                <li>Liste de vos références*</li>
                <li>Sélectionnez le forfait d’adhésion qui vous convient</li>
            </ul>
        </section>

        <section id="form-section">
            <h2>Formulaire d'adhésion</h2>
            <p>Faites-vous connaître de nos membres. Les champs identifiés par un astérisque (*) sont obligatoires.</p>
<form id="adhesion-form" action="" method="post">
    <label for="nom_demandeur">Nom du demandeur * :</label>
    <input type="text" id="nom_demandeur" name="nom_demandeur" required>

    <label for="nom_entreprise">Nom de l’entreprise * :</label>
    <input type="text" id="nom_entreprise" name="nom_entreprise" required>

    <label for="adresse_entreprise">Adresse de l'entreprise * :</label>
    <input type="text" id="adresse_entreprise" name="adresse_entreprise" required>

    <label for="ville">Ville * :</label>
    <input type="text" id="ville" name="ville" required>

    <label for="code_postal">Code postal * :</label>
    <input type="text" id="code_postal" name="code_postal" required>

    <label for="telephone">Numéro de téléphone * :</label>
    <input type="text" id="telephone" name="telephone" required>

    <label for="courriel">Adresse courriel * :</label>
    <input type="email" id="courriel" name="courriel" required>

    <label for="description">Description des produits et services offerts :</label>
    <textarea id="description" name="description"></textarea>

    <label>Régions desservies :</label>
    <div class="regions">
        <label><input type="checkbox" name="regions[]" value="Bas-St-Laurent"> Bas-St-Laurent</label>
        <label><input type="checkbox" name="regions[]" value="Côte-Nord"> Côte-Nord</label>
        <label><input type="checkbox" name="regions[]" value="Saguenay – Lac-Saint-Jean"> Saguenay – Lac-Saint-Jean</label>
        <label><input type="checkbox" name="regions[]" value="Gaspésie – Îles-de-la-Madeleine"> Gaspésie – Îles-de-la-Madeleine</label>
        <label><input type="checkbox" name="regions[]" value="Québec"> Québec</label>
        <label><input type="checkbox" name="regions[]" value="Chaudière-Appalaches"> Chaudière-Appalaches</label>
        <label><input type="checkbox" name="regions[]" value="Mauricie"> Mauricie</label>
        <label><input type="checkbox" name="regions[]" value="Laval"> Laval</label>
        <label><input type="checkbox" name="regions[]" value="Estrie"> Estrie</label>
        <label><input type="checkbox" name="regions[]" value="Lanaudière"> Lanaudière</label>
        <label><input type="checkbox" name="regions[]" value="Montréal"> Montréal</label>
        <label><input type="checkbox" name="regions[]" value="Laurentides"> Laurentides</label>
        <label><input type="checkbox" name="regions[]" value="Outaouais"> Outaouais</label>
        <label><input type="checkbox" name="regions[]" value="Montérégie"> Montérégie</label>
        <label><input type="checkbox" name="regions[]" value="Abitibi-Témiscamingue"> Abitibi-Témiscamingue</label>
    </div>

    <button type="submit">Envoyer</button>
</form>

            <p>Un conseiller communiquera avec vous dans les meilleurs délais.</p>
        </section>

        <section id="advertisement">
            <h2>Annoncer via nos publications</h2>
            <p>Maximisez la visibilité de votre entreprise auprès du plus grand réseau des clients dans l’immobilier au Québec en annonçant sur l’une de nos plateformes exclusives.</p>
            <p>Immonivo s’adresse directement aux clients et courtiers grâce à ses multiples canaux spécialisés. Assurez-vous de vous démarquer auprès de cette clientèle de choix en élaborant un plan de visibilité infaillible avec votre représentant.</p>


           <img style="margin-left: -2%; width: 90%;" src="capture7.PNG">

            <p>De plus, les partenaires d’Immonivo :</p>
            <ul>
                <li>ont jusqu’à 20% de rabais sur tous les tarifs publicitaires réguliers;</li>
                <li>sont référés directement aux clients par les courtiers et conseillers;</li>
                <li>accèdent à des prix préférentiels sur les services réservés aux membres d’Immonivo;</li>
                <li>reçoivent les publications qui portent sur les dernières nouvelles de l’industrie de l’immobilier;</li>
                <li>bénéficient d’une présence dans le répertoire en plus d’une fiche détaillée permettant de mettre de l’avant leur entreprise.</li>
            </ul>
            <p>N’hésitez pas à consulter notre équipe afin d’en savoir davantage sur la création de publicité. Pour plus d’information, écrivez-nous au <a href="mailto:partenaires@immonivo.com">partenaires@immonivo.com</a>.</p>
        </section>
    </main>
    <footer>
        <nav>
            <ul>
                <li><a href="#intro">Comment devenir partenaire</a></li>
                <li><a href="#form-section">Formulaire d'adhésion</a></li>
                <li><a href="#advertisement">Annoncer dans nos publications</a></li>
            </ul>
        </nav>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>
