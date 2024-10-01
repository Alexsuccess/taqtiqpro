<?php
// Configuration de la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membreType = $_POST['membreType'];
    $entrepreneurType = isset($_POST['entrepreneurType']) ? $_POST['entrepreneurType'] : NULL;
    $courtierType = isset($_POST['courtierType']) ? $_POST['courtierType'] : NULL;
    $hypothecaireType = isset($_POST['hypothecaireType']) ? $_POST['hypothecaireType'] : NULL;
    $fournisseurType = isset($_POST['fournisseurType']) ? $_POST['fournisseurType'] : NULL;
    $permisNo = isset($_POST['permisNo']) ? $_POST['permisNo'] : NULL;
    $specialitesCategories = $_POST['specialitesCategories'];
    $valeurProjetMin = $_POST['valeurProjetMin'];
    $valeurProjetMax = $_POST['valeurProjetMax'];
    $zoneGeographique = $_POST['zoneGeographique'];
    $rayon = $_POST['rayon'];
    $regionsDesservies = $_POST['regionsDesservies'];
    $servicesOfferts = $_POST['servicesOfferts'];
    $forfait = $_POST['forfait'];

    $stmt = $conn->prepare("INSERT INTO inscriptions_membres (membreType, entrepreneurType, courtierType, hypothecaireType, fournisseurType, permisNo, specialitesCategories, valeurProjetMin, valeurProjetMax, zoneGeographique, rayon, regionsDesservies, servicesOfferts, forfait) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssisssss", $membreType, $entrepreneurType, $courtierType, $hypothecaireType, $fournisseurType, $permisNo, $specialitesCategories, $valeurProjetMin, $valeurProjetMax, $zoneGeographique, $rayon, $regionsDesservies, $servicesOfferts, $forfait);

    if ($stmt->execute()) {
        echo "Nouvel enregistrement créé avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription de membre</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-section h4 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-check {
            margin-bottom: 10px;
        }
        .input-group .form-control {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Formulaire d'inscription de membre</h2>
        <form method="post" action="">
            <div class="form-section">
                <h4>1. À l'usage du bureau</h4>
                <div class="form-group">
                    <label>Type de membre</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="entrepreneur" value="entrepreneur">
                        <label class="form-check-label" for="entrepreneur">Entrepreneur</label>
                    </div>
                    <div id="entrepreneurOptions" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="entrepreneurType" id="entrepreneur_general_1" value="entrepreneur_general_1">
                            <label class="form-check-label" for="entrepreneur_general_1">Entrepreneur général 1.1.1 et/ou 1.1.2</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="entrepreneurType" id="entrepreneur_general_2" value="entrepreneur_general_2">
                            <label class="form-check-label" for="entrepreneur_general_2">Entrepreneur général autre</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="entrepreneurType" id="entrepreneur_specialise" value="entrepreneur_specialise">
                            <label class="form-check-label" for="entrepreneur_specialise">Entrepreneur spécialisé</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="commercant" value="commercant">
                        <label class="form-check-label" for="commercant">Commerçant</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="professionnel" value="professionnel">
                        <label class="form-check-label" for="professionnel">Professionnel</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="courtier" value="courtier">
                        <label class="form-check-label" for="courtier">Courtier immobilier résidentiel</label>
                    </div>
                    <div id="courtierOptions" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="courtierType" id="commercial" value="commercial">
                            <label class="form-check-label" for="commercial">Commerciale</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="courtierType" id="specialise" value="specialise">
                            <label class="form-check-label" for="specialise">Spécialisée</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="hypothecaire" value="hypothecaire">
                        <label class="form-check-label" for="hypothecaire">Hypothécaire</label>
                    </div>
                    <div id="hypothecaireOptions" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hypothecaireType" id="assurance" value="assurance">
                            <label class="form-check-label" for="assurance">Assurance</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hypothecaireType" id="planificateur" value="planificateur">
                            <label class="form-check-label" for="planificateur">Planificateur financier</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="fournisseur" value="fournisseur">
                        <label class="form-check-label" for="fournisseur">Fournisseur</label>
                    </div>
                    <div id="fournisseurOptions" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fournisseurType" id="associe" value="associe">
                            <label class="form-check-label" for="associe">Associé</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fournisseurType" id="partenaire" value="partenaire">
                            <label class="form-check-label" for="partenaire">Partenaire</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="membreType" id="no_permis" value="no_permis">
                        <label class="form-check-label" for="no_permis">No permis</label>
                    </div>
                    <div id="noPermisSection" style="display: none;">
                        <label for="permisNo">Insérer Permis : No et Catégories du membre</label>
                        <input type="text" class="form-control" id="permisNo" name="permisNo">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4>2. Cautionnement</h4>
                <p>
                    L’entreprise à le cautionnement de licence de la Régie du bâtiment du Québec (RBQ) par police d’assurance cautionnement collective offert par l'Association des professionnels de construction et de l'habitation du Québec inc. Ou autre assureur prévu aux articles 27 et 28 du Règlement sur la qualification des entrepreneurs et des constructeurs propriétaires (L.R.Q., c. B-1.1 r.1) (ci-après « Règlement sur la qualification »).
                </p>
            </div>

            <div class="form-section">
                <h4>Spécialités et catégories souhaitées</h4>
                <div class="form-group">
                    <label for="specialitesCategories">Mentionnez vos préférences</label>
                    <input type="text" class="form-control" id="specialitesCategories" name="specialitesCategories">
                </div>
                <div class="form-group">
                    <label for="valeurProjet">Valeur de projet client ou transaction souhaitée</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="valeurProjetMin" name="valeurProjetMin" placeholder="Minimum">
                        <div class="input-group-append">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" id="valeurProjetMax" name="valeurProjetMax" placeholder="Maximum">
                        <div class="input-group-append">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="zoneGeographique">Zone géographique couverte</label>
                    <input type="text" class="form-control" id="zoneGeographique" name="zoneGeographique">
                </div>
                <div class="form-group">
                    <label for="rayon">Rayon</label>
                    <input type="number" class="form-control" id="rayon" name="rayon">
                </div>
                <div class="form-group">
                    <label for="regionsDesservies">Régions desservies</label>
                    <input type="text" class="form-control" id="regionsDesservies" name="regionsDesservies">
                </div>
            </div>

            <div class="form-section">
                <h4>3. Services offerts (joindre des pages supplémentaires au besoin)</h4>
                <p>
                    <textarea class="form-control" rows="4" name="servicesOfferts" placeholder="Décrire les services offerts en détail"></textarea>
                </p>
            </div>

            <div class="form-section">
                <h4>4. Privilège de membre et Règlements généraux</h4>
                <p>
                    Nous désirons devenir membre actif de votre Association. Nous nous engageons à respecter ces Règlements généraux intégralement. Toutes modifications inhérentes aux informations contenues sur la présente devront être transmises sans délai à l’entreprise. Sous réserve des Règlements généraux et du paiement des frais de cotisation, la qualité de membre sera renouvelée d’année en année pour une durée d’un an additionnel commençant à la date anniversaire de sa délivrance. Lors du renouvellement, toutes les informations déjà enregistrées à l’entreprise seront reconduites si cette dernière reçoit uniquement un chèque couvrant les frais de cotisation, sans note de changement(s). Nous reconnaissons que l’entreprise peut nous expulser comme membre si nous ne respectons pas leurs Règlements généraux. Nous reconnaissons que l’entreprise n’est pas tenues de renouveler notre qualité de membre, et qu’à défaut de paiement à la date anniversaire, notre statut de membre sera annulé après soixante (30) jours.
                </p>
            </div>

            <div class="form-section">
                <h4>5. Engagement de l’entreprise</h4>
                <p>
                    L’entreprise s’engage à respecter toutes les obligations prévues au présent formulaire et certifie que les renseignements donnés dans celui-ci, ainsi que tous les documents qui l’accompagnent sont vrais, exacts et complets. L’entreprise autorise l’Association à vérifier leur véracité auprès de toute personne et s’engage à leur fournir, sur demande, tout consentement écrit à cette fin.
                </p>
            </div>

            <div class="form-section">
                <h4>6. Forfait</h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forfait" id="gratuit" value="gratuit">
                    <label class="form-check-label" for="gratuit">Gratuit</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forfait" id="platine" value="platine">
                    <label class="form-check-label" for="platine">Platine</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forfait" id="vip" value="vip">
                    <label class="form-check-label" for="vip">VIP</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forfait" id="premium" value="premium">
                    <label class="form-check-label" for="premium">Premium</label>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="membreType"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('#entrepreneurOptions, #courtierOptions, #hypothecaireOptions, #fournisseurOptions, #noPermisSection').forEach(function(section) {
                        section.style.display = 'none';
                    });
                    if (input.checked) {
                        if (input.id === 'entrepreneur') {
                            document.getElementById('entrepreneurOptions').style.display = 'block';
                        } else if (input.id === 'courtier') {
                            document.getElementById('courtierOptions').style.display = 'block';
                        } else if (input.id === 'hypothecaire') {
                            document.getElementById('hypothecaireOptions').style.display = 'block';
                        } else if (input.id === 'fournisseur') {
                            document.getElementById('fournisseurOptions').style.display = 'block';
                        } else if (input.id === 'no_permis') {
                            document.getElementById('noPermisSection').style.display = 'block';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
