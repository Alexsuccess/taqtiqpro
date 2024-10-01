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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $type_entrepreneur = $_POST['type-entrepreneur'];
    $type_commercant = $_POST['type-commercant'];
    $courtier = $_POST['courtier'];
    $assurance = $_POST['assurance'];
    $type_membre = $_POST['type-membre'];
    $no_permis = $_POST['no-permis'];
    $cautionnement = $_POST['cautionnement'];
    $specialites = $_POST['specialites'];
    $valeur_min = $_POST['valeur-min'];
    $valeur_max = $_POST['valeur-max'];
    $rayon = $_POST['rayon'];
    $regions = $_POST['regions'];
    $forfait = implode(', ', $_POST['forfait']); // Pour gérer les cases à cocher multiples

    // Insertion des données dans la base de données
    $sql = "INSERT INTO inscriptions22 (type_entrepreneur, type_commercant, courtier, assurance, type_membre, no_permis, cautionnement, specialites, valeur_min, valeur_max, rayon, regions, forfait) 
            VALUES (:type_entrepreneur, :type_commercant, :courtier, :assurance, :type_membre, :no_permis, :cautionnement, :specialites, :valeur_min, :valeur_max, :rayon, :regions, :forfait)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':type_entrepreneur', $type_entrepreneur);
    $stmt->bindParam(':type_commercant', $type_commercant);
    $stmt->bindParam(':courtier', $courtier);
    $stmt->bindParam(':assurance', $assurance);
    $stmt->bindParam(':type_membre', $type_membre);
    $stmt->bindParam(':no_permis', $no_permis);
    $stmt->bindParam(':cautionnement', $cautionnement);
    $stmt->bindParam(':specialites', $specialites);
    $stmt->bindParam(':valeur_min', $valeur_min, PDO::PARAM_INT);
    $stmt->bindParam(':valeur_max', $valeur_max, PDO::PARAM_INT);
    $stmt->bindParam(':rayon', $rayon, PDO::PARAM_INT);
    $stmt->bindParam(':regions', $regions);
    $stmt->bindParam(':forfait', $forfait);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!-- Formulaire HTML (comme présenté précédemment) -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription de membre</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group small {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h4 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-label {
            margin-left: 5px;
        }

        .small-section {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
        }

        .highlight {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .small-text {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .highlight {
            border-left: 4px solid #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Formulaire d'inscription de membre</h2>

        <form method="post" action="">
            <!-- Section 1: À l'usage du bureau -->
            <div class="form-section">
                <h4>À l'usage du bureau</h4>

                <div class="form-group">
                    <label for="type-entrepreneur">Type d'entrepreneur</label>
                    <select class="form-control" id="type-entrepreneur" name="type-entrepreneur">
                        <option>Selectionnez</option>
                        <option value="general">Entrepreneur général</option>
                        <option value="autre">Entrepreneur général autre</option>
                        <option value="specialise">Entrepreneur spécialisé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type-commercant">Type de commerçant</label>
                    <select class="form-control" id="type-commercant" name="type-commercant">
                         <option value="Selectionnez">Selectionnez</option>
                        <option value="commercant">Commerçant</option>
                        <option value="professionnel">Professionnel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="courtier">Courtier</label>
                    <select class="form-control" id="courtier" name="courtier">
                         <option value="Selectionnez">Selectionnez</option>
                        <option value="residential">Immobilier résidentiel</option>
                        <option value="commercial">Immobilier commercial</option>
                        <option value="specialized">Immobilier spécialisé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="assurance">Assurance</label>
                    <select class="form-control" id="assurance" name="assurance">
                        <option>Selectionnez</option>
                        <option value="hypothecaire">Hypothécaire</option>
                        <option value="assurance">Assurance</option>
                        <option value="planificateur">Planificateur financier</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type-membre">Type de membre</label>
                    <select class="form-control" id="type-membre" name="type-membre">
                        <option value="Selectionnez">Selectionnez</option>
                        <option value="fournisseur">Fournisseur</option>
                        <option value="associe">Associé</option>
                        <option value="partenaire">Partenaire</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="no-permis">No permis</label>
                    <input type="text" class="form-control" id="no-permis" name="no-permis" placeholder="No permis">
                </div>

                <div class="small-section highlight">
                    <p>
                        L’entreprise à le cautionnement de licence de la Régie du bâtiment du Québec (RBQ) par police d’assurance cautionnement collective offert par l'Association des professionnels de construction et de l'habitation du Québec inc. Ou autre assureur prévu aux articles 27 et 28 du Règlement sur la qualification des entrepreneurs et des constructeurs propriétaires (L.R.Q., c. B-1.1 r.1) (ci-après « Règlement sur la qualification »).
                    </p>
                    <label for="cautionnement">Cautionnement</label>
                    <input type="text" class="form-control" id="cautionnement" name="cautionnement" placeholder="Cautionnement">
                </div>
            </div>

            <!-- Section 2: Spécialités et catégories -->
            <div class="form-section">
                <h4>Spécialités et catégories</h4>

                <div class="form-group">
                    <label for="specialites">Spécialités souhaitées</label>
                    <textarea class="form-control" id="specialites" name="specialites" rows="3" placeholder="Mentionnez vos préférences"></textarea>
                </div>

                <div class="form-group">
                    <label for="valeur-projet">Valeur de projet ou transaction souhaités</label>
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="valeur-min" name="valeur-min" placeholder="Minimum">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="valeur-max" name="valeur-max" placeholder="Maximum">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zone-geographique">Zone géographique couverte</label>
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="rayon" name="rayon" placeholder="Rayon (Km)">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="regions" name="regions" placeholder="Régions desservies">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Engagements et paiement -->
            <div class="form-section">
                <h4>Engagements et paiement</h4>

                <div class="form-group">
                    <label>Privilège de membre</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="forfait-gratuit" name="forfait" value="Gratuit">
                        <label class="form-check-label" for="forfait-gratuit">Gratuit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="forfait-platine" name="forfait" value="Platine">
                        <label class="form-check-label" for="forfait-platine">Platine</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="forfait-vip" name="forfait" value="VIP">
                        <label class="form-check-label" for="forfait-vip">VIP</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="forfait-premium" name="forfait" value="Premium">
                        <label class="form-check-label" for="forfait-premium">Premium</label>
                    </div>
                </div>

                <div class="form-group">
                    <p class="small-text">
                        Faire le virement à <a href="mailto:immonivo@gmail.com">immonivo@gmail.com</a> ou le chèque à l'ordre de 9372-8780 Québec Inc.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Soumettre l'inscription</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
