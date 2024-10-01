<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section-title {
            background-color: #ccc;
            padding: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .question {
            margin-bottom: 15px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .checkbox-group label {
            margin-left: 10px;
            margin-right: 20px;
        }
        .textarea {
            width: 100%;
            height: 80px;
            resize: none;
        }
    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            background-color: #e6f3ff;
            padding: 10px;
            border: 1px solid #000;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
        }
        .form-section {
            border: 1px solid #000;
            margin-bottom: 20px;
            padding: 10px;
        }
        .form-section h3 {
            background-color: #000;
            color: #fff;
            padding: 5px;
            margin: -10px -10px 10px -10px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .form-group label {
            flex-basis: 30%;
            text-align: right;
            margin-right: 10px;
        }
        .form-group input, .form-group select {
            flex-basis: 65%;
            padding: 5px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .checkbox-group label {
            margin-left: 10px;
        }
        .footer {
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Uri Canada Logo" style="float: left;">
            <h1>Formulaire d'inscription de membre de l'Association des professionnels de la construction et de l'habitation du Québec (Uri Canada)</h1>
        </div>

        <div class="form-section">
            <h3>1. À l'usage du bureau régional</h3>
            <div class="form-group">
                <label for="region">Région</label>
                <input type="text" id="region" name="region" placeholder="Veuillez choisir la région">
            </div>
            <div class="form-group">
                <label>Type d'adhésion</label>
                <div>
                    <input type="checkbox" id="conditionnel" name="type_adhesion" value="conditionnel">
                    <label for="conditionnel">Conditionnel</label>
                    <input type="checkbox" id="adhesion" name="type_adhesion" value="adhesion">
                    <label for="adhesion">Adhésion</label>
                    <input type="checkbox" id="renouvellement" name="type_adhesion" value="renouvellement">
                    <label for="renouvellement">Renouvellement</label>
                    <input type="checkbox" id="reintegration" name="type_adhesion" value="reintegration">
                    <label for="reintegration">Réintégration</label>
                </div>
            </div>
            <div class="form-group">
                <label for="periode">Période en vigueur</label>
                <input type="text" id="periode" name="periode">
                <label for="du">Du</label>
                <input type="text" id="du" name="du">
                <label for="au">Au</label>
                <input type="text" id="au" name="au">
            </div>
            <div class="form-group">
                <label for="numero_membre">N° du membre</label>
                <input type="text" id="numero_membre" name="numero_membre">
                <label for="categorie_membre">Catégorie de membre</label>
                <input type="text" id="categorie_membre" name="categorie_membre">
            </div>
        </div>

        <div class="form-section">
            <h3>2. Identification du membre (CARACTÈRES D'IMPRIMERIE)</h3>
            <div class="form-group">
                <label for="nom_usuel">Nom usuel de l'entreprise (Nom d'emprunt)</label>
                <input type="text" id="nom_usuel" name="nom_usuel">
            </div>
            <div class="form-group">
                <label for="nom_legal">Nom légal de l'entreprise (Incluant le nom de tous les sociétaires, selon le cas)</label>
                <input type="text" id="nom_legal" name="nom_legal">
            </div>
            <div class="form-group">
                <label for="dirigeant">Nom du principal dirigeant de l'entreprise</label>
                <input type="text" id="dirigeant" name="dirigeant">
                <label for="fonction">Titre ou fonction</label>
                <input type="text" id="fonction" name="fonction">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse de l'entreprise</label>
                <input type="text" id="adresse" name="adresse">
            </div>
            <div class="form-group">
                <label for="municipalite">Municipalité / Province / Code postal</label>
                <input type="text" id="municipalite" name="municipalite">
            </div>
            <div class="form-group">
                <label for="adresse_facturation">Adresse de facturation (si différente)</label>
                <input type="text" id="adresse_facturation" name="adresse_facturation">
            </div>
            <div class="form-group">
                <label for="municipalite_facturation">Municipalité / Province / Code postal</label>
                <input type="text" id="municipalite_facturation" name="municipalite_facturation">
            </div>
            <div class="form-group">
                <label for="telephones">Téléphones</label>
                <input type="text" id="telephones_bureau" name="telephones_bureau" placeholder="Bureau">
                <input type="text" id="telephones_telec" name="telephones_telec" placeholder="Téléc.">
                <input type="text" id="telephones_cell" name="telephones_cell" placeholder="Cell.">
                <input type="text" id="telephones_res" name="telephones_res" placeholder="Rés.">
            </div>
            <div class="form-group">
                <label for="courriel">Courriel électronique</label>
                <input type="email" id="courriel" name="courriel">
            </div>
            <div class="form-group">
                <label for="dossier_rbq">Dossier R.B.Q. #</label>
                <input type="text" id="dossier_rbq" name="dossier_rbq">
                <label for="numero_entreprise">Numéro d'entreprise du Québec (NEQ)</label>
                <input type="text" id="numero_entreprise" name="numero_entreprise">
            </div>
        </div>

        <div class="form-section">
            <h3>3. Désirez-vous recevoir gratuitement la revue QUEBEC HABITATION ?</h3>
            <div class="checkbox-group">
                <input type="checkbox" id="revue_oui" name="revue" value="oui">
                <label for="revue_oui">Oui</label>
                <input type="checkbox" id="revue_non" name="revue" value="non">
                <label for="revue_non">Non</label>
            </div>
        </div>

        <div class="form-section">
            <h3>Je consens à recevoir par messagerie électronique...</h3>
            <div class="checkbox-group">
                <input type="checkbox" id="consentement_oui" name="consentement" value="oui">
                <label for="consentement_oui">Oui</label>
                <input type="checkbox" id="consentement_non" name="consentement" value="non">
                <label for="consentement_non">Non</label>
            </div>
        </div>

        <div class="form-section">
            <h3>4. En payant les frais d’adhésion...</h3>
            <div class="checkbox-group">
                <input type="checkbox" id="don_5" name="don" value="5">
                <label for="don_5">5$</label>
                <input type="checkbox" id="don_15" name="don" value="15">
                <label for="don_15">15$</label>
                <input type="checkbox" id="don_25" name="don" value="25">
                <label for="don_25">25$</label>
                <input type="checkbox" id="don_autre" name="don" value="autre">
                <label for="don_autre">Autre</label>
                <input type="text" id="don_autre_montant" name="don_autre_montant" placeholder="$">
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="fondation_oui" name="fondation" value="oui">
                <label for="fondation_oui">Oui</label>
                <input type="checkbox" id="fondation_non" name="fondation" value="non">
                <label for="fondation_non">Non</label>
            </div>
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
        <section style="width: 99%;" class="form-section">

            
                <div class="form-group">
                    <label for="nom_legal">NOM LÉGAL DE L'ENTREPRISE :</label>
                    <input type="text" id="nom_legal" name="nom_legal">
                </div>
                <div class="form-group">
                    <label for="num_membre">N° DE MEMBRE  :</label>
                    <input type="text" id="num_membre" name="num_membre" value="">
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





                <section style="width: 99%;" class="form-section">

            
              <label>1.1 L’entreprise <del>désire obtenir</del> le cautionnement de licence de la Régie du bâtiment du Québec (RBQ) par police d’assurance cautionnement collective offert par l'Association des professionnels de construction et de l'habitation du Québec inc. (Uri Canada) prévu aux articles 27 et 28 du Règlement sur la qualification des entrepreneurs et des constructeurs propriétaires (L.R.Q., c. B-1.1 r.1) (ci-après « Règlement sur la qualification »).</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="cautionnement1">
                    <label class="form-check-label" for="cautionnement1">Cautionnement</label>
                </div>
            
        </section>




                <section style="width: 99%;" class="form-section">

              <label>1.2 L’entreprise <del>désire obtenir</del> le cautionnement pour fraude, malversation ou détournement de fonds (FMD) prévu à l’article 78 du Règlement sur le plan de garantie des bâtiments résidentiels neufs (L.R.Q., c. B-1.1 r.8) (ci-après « Règlement sur le plan de garantie ») en faveur de la Garantie de Construction résidentielle GCR.</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="cautionnement2">
                    <label class="form-check-label" for="cautionnement2">Cautionnement</label>
                </div>
                </div>
            
        </section>











    <div class="container mt-4">
        <div class="section-title">2. LICENCES</div>

        <div class="question">
            <p>2.1 Votre entreprise demande ou détient la ou les sous-catégories de licence suivantes (cocher toutes les cases qui s'appliquent) :</p>
            <div class="checkbox-group">
                <input type="checkbox" id="entrepreneur_general_1" name="licence[]" value="entrepreneur_general_1">
                <label for="entrepreneur_general_1">Entrepreneur général 1.1.1 et/ou 1.1.2</label>
                <input type="checkbox" id="entrepreneur_general_autre" name="licence[]" value="entrepreneur_general_autre">
                <label for="entrepreneur_general_autre">Entrepreneur général autre</label>
                <input type="checkbox" id="entrepreneur_specialise" name="licence[]" value="entrepreneur_specialise">
                <label for="entrepreneur_specialise">Entrepreneur spécialisé</label>
            </div>
        </div>

        <div class="question">
            <p>2.2 Une licence a-t-elle déjà été refusée ou révoquée par la RBQ à une entreprise dont vous ou l'un des autres dirigeants de votre entreprise avez été le dirigeant?</p>
            <div class="checkbox-group">
                <input type="radio" id="licence_refusee_oui" name="licence_refusee" value="oui">
                <label for="licence_refusee_oui">Oui</label>
                <input type="radio" id="licence_refusee_non" name="licence_refusee" value="non">
                <label for="licence_refusee_non">Non</label>
            </div>
            <p>Si oui, précisez l'entreprise, la date et les raisons du refus ou de la révocation (joindre une annexe si requis).</p>
            <textarea class="textarea" name="details_refus_revoque"></textarea>
        </div>

        <div class="question">
            <p>2.3 Une demande de cautionnement de licence a-t-elle déjà été refusée ou un cautionnement a-t-il déjà été révoqué par une caution (assureur, association ou autre), pour l'une des entreprises dont vous ou l'un des autres dirigeants de votre entreprise avez été le dirigeant?</p>
            <div class="checkbox-group">
                <input type="radio" id="caution_refusee_oui" name="caution_refusee" value="oui">
                <label for="caution_refusee_oui">Oui</label>
                <input type="radio" id="caution_refusee_non" name="caution_refusee" value="non">
                <label for="caution_refusee_non">Non</label>
            </div>
            <p>Si oui, précisez l'entreprise, le nom de la caution, la date et les raisons du refus ou de la révocation (joindre une annexe si requis).</p>
            <textarea class="textarea" name="details_caution_revoque"></textarea>
        </div>
    </div>





    </div>






























</div>

    </div>
</body>


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

</html>
