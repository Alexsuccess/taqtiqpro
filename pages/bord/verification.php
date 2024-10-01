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
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire
    $nsf = $_POST['nsf'];
    $date_nsf = $_POST['date_nsf'];
    $bilan_verification = $_POST['bilan_verification'];
    $fiche_credit_date = $_POST['fiche_credit_date'];
    $fiche_credit_nom = $_POST['fiche_credit_nom'];
    $site_web = $_POST['site_web'];
    $nouveaux_mot_cle = $_POST['nouveaux_mot_cle'];
    $migration = $_POST['migration'];
    $changement_proprietaire = $_POST['changement_proprietaire'];
    $montant_travaux = $_POST['montant_travaux'];
    $montant_travaux_minimum = $_POST['montant_travaux_minimum'];
    $montant_travaux_maximum = $_POST['montant_travaux_maximum'];
    $autorise = $_POST['autorise'];
    $date = $_POST['date'];
    $par = $_POST['par'];
    $notes_verification = $_POST['notes_verification'];
    $verification_preliminaire = $_POST['verification_preliminaire'];
    $avis_resiliation_assurance = $_POST['avis_resiliation_assurance'];
    $signatures = $_POST['signatures'];
    $entente_nom_legal = $_POST['entente_nom_legal'];
    $attente_presentees = $_POST['attente_presentees'];
    $mode_paiement = $_POST['mode_paiement'];
    $dpa_exp = $_POST['dpa_exp'];
    $methode_factures = $_POST['methode_factures'];
    $courriel_facturation = $_POST['courriel_facturation'];
    $verifie_par = $_POST['verifie_par'];
    $verifie_par_nom = $_POST['verifie_par_nom'];
    $recommende = $_POST['recommende'];
    $decision_permanente = $_POST['decision_permanente'];
    $instructions = $_POST['instructions'];

    // Préparer et lier la requête
    $stmt = $conn->prepare("INSERT INTO formulaire_verification (nsf, date_nsf, bilan_verification, fiche_credit_date, fiche_credit_nom, site_web, nouveaux_mot_cle, migration, changement_proprietaire, montant_travaux, montant_travaux_minimum, montant_travaux_maximum, autorise, date, par, notes_verification, verification_preliminaire, avis_resiliation_assurance, signatures, entente_nom_legal, attente_presentees, mode_paiement, dpa_exp, methode_factures, courriel_facturation, verifie_par, verifie_par_nom, recommande, decision_permanente, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssssssssssssssssssssssss", $nsf, $date_nsf, $bilan_verification, $fiche_credit_date, $fiche_credit_nom, $site_web, $nouveaux_mot_cle, $migration, $changement_proprietaire, $montant_travaux, $montant_travaux_minimum, $montant_travaux_maximum, $autorise, $date, $par, $notes_verification, $verification_preliminaire, $avis_resiliation_assurance, $signatures, $entente_nom_legal, $attente_presentees, $mode_paiement, $dpa_exp, $methode_factures, $courriel_facturation, $verifie_par, $verifie_par_nom, $recommende, $decision_permanente, $instructions);

    // Exécuter la requête
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Vérification</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .form-section {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-section h5 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .radio-group label {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Formulaire de Vérification</h1>
    </header>
    <main class="container">
        <form id="verification-form" class="form-row" action="" method="POST">

            <div class="form-section col-md-3">
                <label for="nsf">NSF :</label>
                <input type="text" class="form-control" id="nsf" name="nsf" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="date_nsf">Date NSF :</label>
                <input type="date" class="form-control" id="date_nsf" name="date_nsf" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="bilan_verification">Bilan :</label>
                <input type="text" class="form-control" id="bilan_verification" name="bilan_verification" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="fiche_credit_date">Fiche de Crédit (Date) :</label>
                <input type="date" class="form-control" id="fiche_credit_date" name="fiche_credit_date" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="fiche_credit_nom">Nom :</label>
                <input type="text" class="form-control" id="fiche_credit_nom" name="fiche_credit_nom" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="site_web">Site Web :</label>
                <input type="text" class="form-control" id="site_web" name="site_web" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="nouveaux_mot_cle">Nouveaux mot clé :</label>
                <input type="text" class="form-control" id="nouveaux_mot_cle" name="nouveaux_mot_cle" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="migration">Migration :</label>
                <input type="text" class="form-control" id="migration" name="migration">
            </div>

            <div class="form-section col-md-3">
                <label for="changement_proprietaire">Changement de propriétaire :</label>
                <input type="text" class="form-control" id="changement_proprietaire" name="changement_proprietaire" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="montant_travaux">Montant des travaux désirés :</label>
                <input type="text" class="form-control" id="montant_travaux" name="montant_travaux" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="montant_travaux_minimum">Minimum :</label>
                <input type="text" class="form-control" id="montant_travaux_minimum" name="montant_travaux_minimum" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="montant_travaux_maximum">Maximum :</label>
                <input type="text" class="form-control" id="montant_travaux_maximum" name="montant_travaux_maximum" required="required">
            </div>

            <div class="form-section col-md-3">
                <label>Autorisé :</label>
                <div class="radio-group" required="required">
                    <label><input type="radio" name="autorise" value="accepté"> Accepté pour migration</label>
                    <label><input type="radio" name="autorise" value="rejeté"> Rejeté</label>
                </div>
            </div>

            <div class="form-section col-md-3">
                <label for="date">Date :</label>
                <input type="date" class="form-control" id="date" name="date" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="par">Par :</label>
                <input type="text" class="form-control" id="par" name="par" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="notes_verification">Notes :</label>
                <textarea class="form-control" id="notes_verification" name="notes_verification" required="required"></textarea>
            </div>

            <div class="form-section col-md-3">
                <label for="verification_preliminaire">Vérification préliminaire effectué par :</label>
                <input type="text" class="form-control" id="verification_preliminaire" name="verification_preliminaire" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="avis_resiliation_assurance">Avis de résiliation assurance :</label>
                <input type="text" class="form-control" id="avis_resiliation_assurance" name="avis_resiliation_assurance" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="signatures">Signatures :</label>
                <textarea class="form-control" id="signatures" name="signatures" required="required"></textarea>
            </div>

            <div class="form-section col-md-3">
                <label for="entente_nom_legal">Entente au nom légal signée :</label>
                <input type="text" class="form-control" id="entente_nom_legal" name="entente_nom_legal" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="attente_presentees">Attente présentées et signées :</label>
                <textarea class="form-control" id="attente_presentees" name="attente_presentees" required="required"></textarea>
            </div>

            <div class="form-section col-md-3">
                <label>Mode de paiement :</label>
                <div class="radio-group" required="required">
                    <label><input type="radio" name="mode_paiement" value="chèque"> Chèque</label>
                    <label><input type="radio" name="mode_paiement" value="DPA Bancaire"> DPA Bancaire</label>
                    <label><input type="radio" name="mode_paiement" value="DPA carte de crédit"> DPA carte de crédit</label>
                </div>
            </div>

            <div class="form-section col-md-3">
                <label for="dpa_exp">Exp :</label>
                <input type="date" class="form-control" id="dpa_exp" name="dpa_exp" required="required">
            </div>

            <div class="form-section col-md-3">
                <label>Méthode de factures :</label>
                <div class="radio-group">
                    <label><input type="radio" name="methode_factures" value="courriel" required="required"> Courriel</label>
                </div>
            </div>

            <div class="form-section col-md-3">
                <label for="courriel_facturation">Courriel de facturation :</label>
                <input type="email" class="form-control" id="courriel_facturation" name="courriel_facturation" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="verifie_par">Approuvé comme "vérifié à 360" le :</label>
                <input type="date" class="form-control" id="verifie_par" name="verifie_par" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="verifie_par_nom">Par :</label>
                <input type="text" class="form-control" id="verifie_par_nom" name="verifie_par_nom" required="required">
            </div>

            <div class="form-section col-md-3">
                <label for="recommende">Recommandé :</label>
                <textarea class="form-control" id="recommende" name="recommende" required="required"></textarea>
            </div>

            <div class="form-section col-md-3">
                <label for="decision_permanente">Décision permanente :</label>
                <textarea class="form-control" id="decision_permanente" name="decision_permanente" required="required"></textarea>
            </div>

            <div class="form-section col-md-3">
                <label for="instructions">Instructions :</label>
                <textarea class="form-control" id="instructions" name="instructions" required="required"></textarea>
            </div>
            
            <div class="form-section col-md-12">
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Formulaire de Vérification. Tous droits réservés.</p>
    </footer>
    <!-- Lien vers Bootstrap JS et jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
