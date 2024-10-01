<?php
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

// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données du formulaire
    $projet = htmlspecialchars($_POST['projet']);
    $urlSite = htmlspecialchars($_POST['urlSite']);
    $domaine = htmlspecialchars($_POST['domaine']);
    $succesActuel = htmlspecialchars($_POST['succesActuel']);
    $objectifSouhaite = htmlspecialchars($_POST['objectifSouhaite']);
    $prixTriomphe = htmlspecialchars($_POST['prixTriomphe']);
    $maintenirAcquerir = htmlspecialchars($_POST['maintenirAcquerir']);
    $imaginerSucces = htmlspecialchars($_POST['imaginerSucces']);
    $reveFou = htmlspecialchars($_POST['reveFou']);
    $partagerAide = htmlspecialchars($_POST['partagerAide']);
    $nomPrenom = htmlspecialchars($_POST['nomPrenom']);
    $couleurPersonnalite = htmlspecialchars($_POST['couleurPersonnalite']);
    $meilleurContact = htmlspecialchars($_POST['meilleurContact']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $courriel = htmlspecialchars($_POST['courriel']);

    // Préparation de la requête SQL d'insertion avec des requêtes préparées pour éviter les injections SQL
    $sql = "INSERT INTO formulaire_contact (projet, url_site, domaine_activite, succes_actuel, objectif_souhaite, prix_triomphe, maintenir_acquerir, imaginer_succes, reve_professionnel, partager_aide, nom_prenom, couleur_personnalite, meilleur_contact, telephone, courriel) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Préparer la requête
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Binder les paramètres et exécuter la requête
    $stmt->bind_param("ssssssssssssss", $projet, $urlSite, $domaine, $succesActuel, $objectifSouhaite, $prixTriomphe, $maintenirAcquerir, $imaginerSucces, $reveFou, $partagerAide, $nomPrenom, $couleurPersonnalite, $meilleurContact, $telephone, $courriel);
    
    if ($stmt->execute()) {
        // Redirection après insertion réussie
        header("Location: confirmation.php"); // Adapter le chemin vers votre page de confirmation
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Fermeture du statement
    $stmt->close();
} else {
    // Si la méthode de requête n'est pas POST, sortir sans rien faire
    exit();
}

// Fermeture de la connexion
$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
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

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .form-step h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
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
        <h1>Bonjour [Prénom],</h1>
        <h2>Afin de mieux vous connaître, merci de répondre aux questions suivantes :</h2>
    </div>

    <form id="formContact" method="POST" action="">
        <div id="step1" class="form-step active">
            <h2>1/15 Vous avez un projet de :</h2>
            <div class="form-group">
                <label for="projet">Ce champ est obligatoire</label>
                <select class="form-control" id="projet" name="projet" required>
                    <option value="">Sélectionnez votre projet</option>
                    <option value="Community management">Community management</option>
                    <option value="Tunnel de Vente">Tunnel de Vente</option>
                    <option value="Site internet">Site internet</option>
                    <option value="Publicité">Publicité</option>
                    <option value="Blog">Blog</option>
                    <option value="Création graphique">Création graphique</option>
                    <option value="Logo">Logo</option>
                    <option value="Vidéo de vente">Vidéo de vente</option>
                    <option value="Autre">Autre, précisez</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step2" class="form-step">
            <h2>2/15 Quelle est l'URL de votre Site Web / Tunnel..?</h2>
            <div class="form-group">
                <input type="url" class="form-control" id="urlSite" name="urlSite" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step3" class="form-step">
            <h2>3/15 Dans quel domaine d'activité êtes-vous et depuis combien de temps ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="domaine" name="domaine" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step4" class="form-step">
            <h2>4/15 Votre succès se chiffre à combien actuellement ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="succesActuel" name="succesActuel">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step5" class="form-step">
            <h2>5/15 Quel est l'objectif souhaité ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="objectifSouhaite" name="objectifSouhaite">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step6" class="form-step">
            <h2>6/15 Quel est votre fourchette de prix pour votre triomphe sur les réseaux ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="prixTriomphe" name="prixTriomphe">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step7" class="form-step">
            <h2>7/15 Voulez-vous maintenir vos clients ou simplement en acquérir de nouveaux ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="maintenirAcquerir" name="maintenirAcquerir">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step8" class="form-step">
            <h2>8/15 À l’aide de notre petit coup de baguette, comment imaginez-vous votre succès avec tous les outils à votre portée ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="imaginerSucces" name="imaginerSucces">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step9" class="form-step">
            <h2>9/15 Quel serait votre rêve professionnel le plus fou aujourd’hui ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="reveFou" name="reveFou">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step10" class="form-step">
            <h2>10/15 Veuillez partager tout ce qui aidera à préparer notre réunion...</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="partagerAide" name="partagerAide">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step11" class="form-step">
            <h2>11/15 Quel est votre Nom et Prénom ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="nomPrenom" name="nomPrenom" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step12" class="form-step">
            <h2>12/15 Quelle est la couleur de votre personnalité ?</h2>
            <div class="form-group">
                <select class="form-control" id="couleurPersonnalite" name="couleurPersonnalite" required>
                    <option value="">Choisissez une option</option>
                    <option value="Bleu">Bleu : Analyste</option>
                    <option value="Rouge">Rouge : Fonceur</option>
                    <option value="Jaune">Jaune : Chaleureux</option>
                    <option value="Vert">Vert : Artiste</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step13" class="form-step">
            <h2>13/15 Le meilleur moyen pour vous contacter ?</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="meilleurContact" name="meilleurContact">
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant</button>
        </div>

        <div id="step14" class="form-step">
            <h2>14/15 Téléphone et courriel</h2>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="courriel">Courriel</label>
                <input type="email" class="form-control" id="courriel" name="courriel" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="prevStep()">Précédent</button>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    var currentStep = 1;

    function nextStep() {
        document.getElementById('step' + currentStep).classList.remove('active');
        currentStep++;
        document.getElementById('step' + currentStep).classList.add('active');
    }

    function prevStep() {
        document.getElementById('step' + currentStep).classList.remove('active');
        currentStep--;
        document.getElementById('step' + currentStep).classList.add('active');
    }
</script>

</body>
</html>
