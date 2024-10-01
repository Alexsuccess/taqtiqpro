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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire avec vérification
    $recover = isset($_POST['recover']) ? $_POST['recover'] : '';
    $verbal_language = isset($_POST['verbal_language']) ? $_POST['verbal_language'] : '';
    $written_language = isset($_POST['written_language']) ? $_POST['written_language'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $confirm_email = isset($_POST['confirm_email']) ? $_POST['confirm_email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $postal_address = isset($_POST['postal_address']) ? $_POST['postal_address'] : '';
    $postal_code = isset($_POST['postal_code']) ? $_POST['postal_code'] : '';
    $international_address = isset($_POST['international_address']) ? 1 : 0;
    $accept_rights = isset($_POST['accept_rights']) ? $_POST['accept_rights'] : '';
    $attestation = isset($_POST['attestation']) ? $_POST['attestation'] : '';

    // Préparer la requête SQL avec des instructions préparées
    $stmt = $conn->prepare("INSERT INTO inscriptions (recover, verbal_language, written_language, email, confirm_email, phone, postal_address, postal_code, international_address, accept_rights, attestation, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssi", $recover, $verbal_language, $written_language, $email, $confirm_email, $phone, $postal_address, $postal_code, $international_address, $accept_rights, $attestation, $userId);

    // Exécuter la requête
    if ($stmt->execute() === TRUE) {
        echo "Nouvel enregistrement créé avec succès";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestations de Service d'Accompagnement pour Emploi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Prestations de Service d'Accompagnement pour Emploi</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">ÜRI Canada</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#section1">Ce qu'offrent ces prestations</a></li>
                <li class="nav-item"><a class="nav-link" href="#section2">Êtes-vous admissible</a></li>
                <li class="nav-item"><a class="nav-link" href="#section3">Présenter une demande</a></li>
                <li class="nav-item"><a class="nav-link" href="#section4">Une fois votre demande présentée</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <section id="section1">
            <h2 style="color: blue; text-decoration-line :underline; ">Ce qu'offrent ces prestations</h2>
            <p>Les prestations d’accompagnement emploi vous offres jusqu'à 18 mois d'aide à l’emploi si vous ne pouvez pas trouver un travaille au Canada. 
Vous devez obtenir une approbation de dossier d’ÛRI Canada indiquant que vous êtes conforme à notre bassin de profils recherchés.  Ces raisons incluent une aisance dans la procédure afin de combler les profils de nos clients rapidement. Dans le cas ou votre candidature est en attente, elle sera maintenue dans notre base de données pour une éventuelle opportunité.  <br>

Prestations d’accompagnement à l’emploi
</p>
        </section>

        <section id="section2">
            <h2 style="color: blue; text-decoration-line :underline; ">Êtes-vous admissible</h2>
            <p>Les renseignements ci-dessous devraient servir de lignes directrices. Nous vous encourageons à présenter une demande de prestation dès que possible et nous laisser déterminer si vous êtes admissible.<br>
Vous devez démontrer que :<br>
•   Vous êtes diplômé dans le domaine (sous toutes réserves)<br>
•   Vous avez de l’expérience dans le domaine<br>
•   Vous êtes aptes et disposé à travailler sur une longue période<br>
•   vous pouvez travailler temps plein sans soucis médicales;<br>
•   votre dossier légal est vierge;<br><br>
Pendant que vous recevez des prestations d’accompagnement à l’emploi, vous devez demeurer autrement disponible pour travailler, si ce n’est pas votre condition veuillez nous en faire part dans l’immédiat.<br><br>





Prestations de service d’accompagnement pour emploi
</p>
        </section>

        <section id="section3">
            <h2 style="color: blue; text-decoration-line :underline; ">Présenter une demande</h2>
            <p>Présentez votre demande dès que possible après avoir décidé de sauter le pas.</p>
            <h3>Suivez ces étapes pour remplir votre demande :</h3>
            <ul>
            <img style="width: 100%; height: 50%;" src="demande.PNG" alt="demande">

            </ul>
            <p>ÜRI Canada recueille les renseignements personnels que vous fournissez dans une demande de prestations de service d’accompagnement immigration afin d'évaluer si vous êtes admissible à des prestations. En commençant cette demande, vous consentez aux modalités de l'énoncé de confidentialité. Veuillez lire l'énoncé de confidentialité.</p>
            <p><strong>Si vous connaissez déjà la procédure:</strong></p>
            <p><strong>Présenter une demande</strong></p>
            <p>Rassemblez d’abord les informations nécessaires. Dans le cadre de la procédure de demande, vous devrez nous fournir des renseignements et des documents.</p>
            <p>N’attendez pas d’avoir tous les documents pour présenter votre demande. Remplissez et présentez votre demande en ligne immédiatement. Vous pouvez envoyer les documents nécessaires après avoir présenté votre demande. Toutes les candidatures soumises feront partie de notre base de données de travailleurs étrangers :</p>
            <ul>
                <li>Renseignements personnels</li>
                <li>Parcours professionnels</li>
                <li>Parcours académique (diplôme)</li>
                <li>Lettre de confirmation d'emploi</li>
            </ul>

            <h3> <img style="width: 10%; height: 5%;" src="ytt.PNG" alt="demande">Étape 1 : Remplissez la demande en ligne</h3><br>
            <p>Il vous faudra environ 1 heure pour remplir la demande en ligne. Si vous ne remplissez pas toute la demande d'un seul coup, vous pouvez y revenir à l'aide d'un mot de passe temporaire que vous recevez quand vous commencez à remplir votre demande. Vos renseignements sont sauvegardés à partir du moment où vous commencez à remplir votre demande. Si vous ne présentez pas la demande dans la semaine :</p>
            <ul>
                <li>elle sera supprimée;</li>
                <li>vous devrez remplir une nouvelle demande.</li>
            </ul>
            <p>Quand vous présentez une demande de prestations de service d’accompagnement pour emploi, nous vous demanderons votre adresse courriel. Nous pourrions vous envoyer un courriel pour vous fournir des renseignements ou pour vous demander de nous appeler si nous ne pouvons pas vous joindre par téléphone.</p>

            <h3><img style="width: 10%; height: 5%;" src="ddd.PNG" alt="demande">Étape 2 : Fournissez les documents nécessaires</h3>
            <p>Une fois que vous avez présenté votre demande en ligne, soumettez-nous les documents nécessaires. Vous pouvez :</p>
            <ul>
                <li>nous les envoyer par courriel;</li>
                <li>les déposer à un Centre de service ÜRI Canada;</li>
                <li>les déposer chez un agent accrédité d’ÜRI Canada.</li>
            </ul>

            <h3><img style="width: 10%; height: 5%;" src="ccc.PNG" alt="demande">Étape 3 : Un relevé des prestations et un code d'accès</h3>
            <p>Une fois votre demande reçue et que votre profil soit approuvé, nous vous enverrons un devis des prestations avec un code d'accès. Vous avez besoin de ce code pour vous renseigner sur votre demande. Le fait de recevoir un devis du relevé des prestations de service d’accompagnement pour emploi ne signifie pas que nous avons rendu une décision sur votre demande.</p>

            <h3><img style="width: 10%; height: 5%;" src="fff.PNG" alt="demande">Étape 4 : Vérifiez l'état de votre demande</h3>
            <p>Pour vérifier l'état de votre demande, vous pouvez :</p>
            <ul>
                <li>vous inscrire ou vous connecter à uricanada.com;</li>
                <li>communiquer avec Service ÜRI Canada.</li>
            </ul>
        </section>

        <section id="section4">
            <h2 style="color: blue; text-decoration-line :underline; ">Une fois votre demande présentée</h2><br>
            
            <strong style="color: red;">Début de la demande</strong>
        </section>

        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Virement bancaire (à voir avec quel fournisseur WU-RIA ou autre)</h2>
            <p>Grâce au virement bancaire vous pouvez déposer automatiquement vos paiements dans le compte et éviter les retards occasionnés par les transferts. Déposez directement chez ÜRI Canada! C'est pratique, sécuritaire et fiable.</p>
            <p>Vous avez choisi de remplir votre demande en français. Vous ne pourrez pas changer pour l'anglais après que vous aurez débuté votre session en ligne. Si vous désirez changer la langue, vous devez le faire avant de commencer.</p>
            <p><strong>Important</strong></p>
            <p>Les réponses aux questions et aux champs accompagnés d'un astérisque (*) sont obligatoires. Utilisez seulement les boutons « Page suivante » et « Page précédente » pour naviguer dans la demande.</p>
            <p>Tentez-vous de récupérer une demande que vous avez commencée dans la présente semaine, mais que vous n'avez pas fini de remplir (obligatoire) ?</p>
             <form method="POST" action="">


                <div class="form-check">
                    <input class="form-check-input" type="radio" name="recover" id="yes" value="yes">
                    <label class="form-check-label" for="yes">Oui</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="recover" id="no" value="no">
                    <label class="form-check-label" for="no">Non</label>
                </div>
           

        </section>

        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Virement pour ÜRI Canada</h2>
            <h3>Emploi et Développement ÜRI Canada</h3>
            <p><strong>Avant de vous inscrire</strong></p>
            <p>Vous aurez besoin des renseignements suivants :</p>
            <ul>
                <li>votre numéro de dossier interne;</li>
                <li>le nom de l’institution financière;</li>
                <li>le numéro de transit de notre succursale;</li>
                <li>le numéro de notre compte.</li>
            </ul>
            <p>Nos informations bancaires vous seront acheminées dans un courriel suite à l’acceptation des prestations de services. Si vous n’avez pas un compte bancaire, vous pouvez tout de même demander ces renseignements à votre institution financière.</p>
            <p><strong>Type de demande</strong></p>
            <p>Les réponses aux questions et aux champs accompagnés d'un astérisque (*) sont obligatoires.</p>
            <p><strong>Les prestations</strong></p>
            <p>Vous devez sélectionner le type de prestation de service que vous voulez. En cas d’incertitude, lors de processus nous redéfinirons la meilleure option pour votre situation.</p>
            <p><strong>Renseignements sur l'identité</strong></p>
            <p>Il sera considéré comme acquis que vous avez signé notre contrat de service pour votre demande de prestations si vous poursuivez et soumettez :
<br>•   votre numéro de passeport;<br>
•   certificat de naissance;<br>
•   le nom de famille à la naissance d’un de vos parents.<br>
Vous devez inscrire votre nom légal. Si votre nom légal n'est pas celui qui apparait sur votre permis/passeport, vous devez mettre à jour votre dossier.
Nous utiliserons les renseignements fournis pour valider votre identité. Si certains renseignements sont différents de ceux que vous avez fournis lors de votre demande de prestation, le traitement de votre pourrait en être retardé.
Pour récupérer une demande partiellement remplie vous devrez réinscrire vos renseignements personnels exactement comme ils ont été entrés la première fois. 
Les réponses aux questions et aux champs accompagnés d'un astérisque ( * ) sont obligatoires.
.</p>

            <p><strong>Validation de l'identité</strong></p>
            <p>Veuillez vérifier les renseignements fournis. Si les renseignements sont exacts cliquez sur le bouton « Page suivante ». Si vous désirez modifier vos renseignements, cliquez sur le bouton « Page précédente »..</p>


            <p><strong>Mot de passe temporaire</strong></p>
            <p>Veuillez vérifier les renseignements fournis. Si les renseignements sont exacts cliquez sur le bouton « Page suivante ». Si vous désirez modifier vos renseignements, cliquez sur le bouton « Page précédente ».
            <p>Veuillez vérifier les renseignements fournis. Si les renseignements sont exacts cliquez sur le bouton « Page suivante ». Si vous désirez modifier vos renseignements, cliquez sur le bouton « Page précédente ».<br><br>
Mot de passe temporaire
<strong>Votre mot de passe temporaire est :</strong><br>
<strong style="color: red;">ASFK-774J</strong><br><br>
Si vous perdez votre session, ce mot de passe vous permettra de continuer à remplir votre demande. Veuillez vous assurer de noter votre mot de passe exactement tel qu'indiqué.
Ce mot de passe temporaire a été choisi au hasard. Votre mot de passe et les renseignements que vous avez inscrits au dernier écran en exécution sont essentiels à la récupération de votre demande partiellement remplie. Votre mot de passe demeurera actif durant 1 semaine. Si vous ne pouvez pas compléter votre demande en entier durant cette période, votre demande sera supprimée et vous devrez débuter une nouvelle demande.
ÜRI Canada prend toutes les mesures nécessaires afin que vos transactions électroniques avec nous soient sécuritaires, et que vos renseignements personnels soient protégés.
</p>
        </section>




        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Renseignements personnels</h2>
            <p>Aide pour cette page</p>
            <p>Les réponses aux questions et aux champs accompagnés d'un astérisque ( * ) sont obligatoires.</p><br>
              
             <p><strong style="color: blue;"> Je préfère être servi(e) :</strong></p> 
           
                <div class="form-group">
                    <label>*Une réponse est obligatoire (Verbalement) :</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="verbal_language" id="verbalEnglish" value="Anglais" required>
                        <label class="form-check-label" for="verbalEnglish">Anglais</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="verbal_language" id="verbalFrench" value="Français" required>
                        <label class="form-check-label" for="verbalFrench">Français</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>*Une réponse est obligatoire (Par écrit) :</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="written_language" id="writtenEnglish" value="Anglais" required>
                        <label class="form-check-label" for="writtenEnglish">Anglais</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="written_language" id="writtenFrench" value="Français" required>
                        <label class="form-check-label" for="writtenFrench">Français</label>
                    </div>
                </div>

             <p>   Votre adresse courriel pourrait être communiquée via notre Guichet-Emplois afin de vous aider à trouver un emploi potentiel. Votre adresse courriel pourrait également être partagée avec votre notre réseau de client et/ou fournisseurs de services autorisés pour vous orienter vers des programmes, formations et des services d'emplois.
ÜRI Canada pourrait communiquer avec vous par courriel pour vous fournir des renseignements ou vous demander de nous téléphoner.
Les renseignements concernant votre demande peuvent être communiqués par courriel. </p>

                <div class="form-group">
                    <label for="email">Adresse courriel *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="confirm_email">Confirmez votre adresse courriel *</label>
                    <input type="email" class="form-control" id="confirm_email" name="confirm_email" required>
                </div>

<p>Il est important de fournir un numéro de téléphone où nous pouvons communiquer avec vous ou auquel nous pouvons vous laisser un message. Si nous ne pouvons pas vous joindre, nous devrons communiquer avec vous par courriel, ce qui pourrait retarder le traitement de votre demande.
Numéro de téléphone principal</p>

                <div class="form-group">
                    <label for="phone">Numéro *</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="postal_address">Type *</label>
                    <select type="text" class="form-control" id="postal_address" name="postal_address" required>
                     <option>Résidentiel</option>
                     <option>Céllulaire</option>   
                    </select>
                </div>

                <div class="form-group">
                    <label for="postal_code">Poste</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code">
                    <small class="form-text text-muted">Entrez votre code postal et sélectionnez « Cherchez l'adresse » pour afficher votre adresse postale.</small>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="international_address" name="international_address">
                    <label class="form-check-label" for="international_address">Cochez si l'adresse est à l'extérieur du Canada</label>
                </div>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Lorsque vous demandez des prestations de service d'accompagnement d’emploi, nous visons à :</h2>
            <p>•    vous donner un service rapide et courtois;<br>
•   vous informer des programmes et services offerts;<br>
•   vous servir dans la langue officielle de votre choix;<br>
•   établir une période de prestations, si vous respectez les critères d'admissibilité précisés dans nos règlement d'application;<br>
•   traiter votre demande d'accompagnement d’emploi dans le même délai, qu'elle ait été faite en ligne, en personne ou par courrier;<br>
•   vous donner des renseignements exacts au sujet de votre demande; y compris sur la façon dont vous pouvez partager les prestations parentales avec votre conjoint ou conjoint de fait admissible et vous indiquer si vous devez ou non observer un délai de carence (période d'attente); <br>
•   de vous informer des décisions rendues concernant votre demande et vous expliquer la marche à suivre si vous êtes en désaccord avec une décision.
</p>

        </section>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Vos responsabilités :</h2>
            <p>Lorsque vous demandez des prestations d’accompagnement, vous devez :<br>
•   déclarer avec exactitude toute période d'incapacité;<br>
•   obtenir un certificat médical confirmant la durée de votre incapacité;<br>
•   fournir tous les renseignements et documents requis;<br>
•   déclarer les périodes où vous serez absent de votre lieu de résidence et/ou toute absence du Canada;<br>
•   déclarer tout emploi, que vous travailliez pour le compte de quelqu'un d'autre ou à votre compte;<br>
•   déclarer avec exactitude toute rémunération brute provenant d'un emploi dans les semaines où vous avez gagné ces sommes, de même que toute autre somme que vous pourriez recevoir
</p>

        </section>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Autres renseignements importants:</h2>
            <p><em>Absence du Canada</em> <br>
Vous devez nous aviser de tous vos déplacements hors du pays. 
</p>

        </section>

        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Autres renseignements importants:</h2>
            <p><em>ntérêts</em> <br>
Des intérêts sont ajoutés sur les dettes.  Pour celles découlant de fausses déclarations. Ils sont calculés quotidiennement et composés mensuellement, au taux moyen de la Banque du Canada plus 3 %.
</p>

        </section>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Fausses déclarations ou trompeuses:</h2>
            <p><br>
Si vous ne dévoilez pas certains éléments d'information, ou si vous faites sciemment une déclaration fausse ou trompeuse, vous commettez une infraction pouvant entraîner une annulation de prestation et vous vous exposez à de graves pénalités, voire des poursuites. Cependant, en informant ÜRI Canada de la situation avant qu'elle ne soit sous enquête, nous pouvons vous aider à ce que le gouvernement renonce aux poursuites ou aux pénalités monétaires.<br>
 <em>Sommes impayées</em> <br>
Si vous avez une dette impayée avec le programme de  formation ÜRI emploi ou l'Agence du revenu du Canada, ou si vous faites l'objet d'une ordonnance de saisie du ministère de la Justice pour une somme impayée, ces sommes pourront être déduites directement de vos salaires. Informez-vous des dispositions de remboursement en composant le numéro de téléphone indiqué sur l'avis qui vous sera envoyée.

</p>

        </section>

                <div class="form-group">
                    <label>*Une réponse est obligatoire Moi, Nom du candidat, j'ai lu et j'ai bien compris mes droits et responsabilités, et :</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accept_rights" id="acceptRights" value="Accepte" required>
                        <label class="form-check-label" for="acceptRights">J'accepte mes droits et responsabilités.</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accept_rights" id="declineRights" value="N'accepte pas" required>
                        <label class="form-check-label" for="declineRights">Je n'accepte pas mes droits et responsabilités et je veux abandonner ma demande de prestations d'accompagnement-emploi.</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>*Une réponse est obligatoire Moi, Nom du candidat</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attestation" id="acceptAttestation" value="Accepte" required>
                        <label class="form-check-label" for="acceptAttestation">Accepte l'attestation ci-dessus et je désire présenter ma demande de prestations d'accompagnement emploi en ligne.</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attestation" id="declineAttestation" value="N'accepte pas" required>
                        <label class="form-check-label" for="declineAttestation">N’accepte pas l'attestation ci-dessus et je désire abandonner ma demande de prestations d'accompagnement emploi en ligne.</label>
                    </div>
                </div>





            <h3>Confirmation et renseignements</h3>
            <p>Aide pour cette page</p>
            <p>Merci - Nous avons reçu votre demande. Avant de recevoir des prestations, il y aura un délai de carence (période d'attente) de 1 semaine pour lequel aucune action ne sera effectuée.</p>
            <p>Numéro de confirmation : 152930751</p>
            <p>Nom : Nom du candidat</p>
            <p>Date reçue (heure de l'Atlantique) : 04/06/2024 20:01</p>
            <p>Si vous avez des renseignements à ajouter ou à modifier, NE remplissez PAS une autre demande en ligne; veuillez communiquer avec nous en téléphonant au ou par écrit.</p>
            <button class="btn btn-primary">Imprimer la page de confirmation</button>
            <button class="btn btn-primary">Imprimer les Droits et responsabilités</button>
            
            <h4>Documents ou renseignements requis</h4>
            <p>Avant que votre demande puisse être finalisée vous devez :</p>
            <ul>
                <li>Soumettez un attestation d’emploi signé par votre employeur ou une preuve d’emploi équivalente.</li>
            </ul>
            <p>Omettre de fournir tous documents ou renseignements requis pourrait causer un délai dans le traitement de votre demande et pourrait avoir une incidence sur votre admissibilité aux prestations.</p>
            <p>Si vous n'avez pas encore ajouté ces documents à votre demande, vous pouvez les téléverser plus tard à l'aide de Mon dossier ÜRI Canada.</p>
            <p>Si nécessaire, apporter tous documents ou renseignements à l'une des adresses suivante :</p>
            <ul>
                <li>Centre Service ÜRI Canada</li>
                <li>Adresse des agences partenaires</li>
                <li>Ou les remettre en personne à un Centre Service ÜRI Canada près de chez vous</li>
            </ul>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Formulaires électroniques si besoin:</h2>
            <p>Télécharger et imprimer une copie du formulaire <br>
•   Attestation d’emploi
</p>

        </section>

        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Notes additionnelles:</h2>
            <p>consulter dans Mon dossier ÜRI Canada. Conservez les versions originales pour 6 ans au cas où nous en aurions besoin.
Pour prouver votre admissibilité et pour recevoir tout traitement auquel vous pourriez avoir droit, vous devrez remplir des déclarations tous les trois mois. Si vous ne le faites pas, vous pourriez perdre le droit à vos prestations et ne plus recevoir de suivis de satisfaction ponctuelle.
Vous devez indiquer sur vos déclarations que vous êtes disponible pour travailler.
Si un problème médical subvient durant la période de la procédure ou pendant une longue période et vous empêche d'effectuer régulièrement tout genre de travail, vous devez nous prévenir dans les plus brefs délais.

</p>

        </section>


        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Quelle est la prochaine étape ?</h2>
            <p>•    Nous vous ferons parvenir un <strong style="text-decoration-line: underline;">Relevé des prestations</strong>  qui comprend votre<strong style="text-decoration-line: underline;"> code d'accès</strong>. Lisez les instructions pour savoir comment remplir votre demande de service en accédant à notre<strong style="text-decoration-line: underline;"> Service par Internet</strong> ou notre <strong style="text-decoration-line: underline;">Service de prestation en personne</strong>.<br>
•   Si vous avez présenté une demande d'accompagnement emploi au cours du dernier mois, vous ne recevrez pas de nouveau code d'accès par courriel mais par le biais de votre agence. Vous devez utiliser le même code d'accès que celui que vous utilisiez pour remplir vos suivis de prestation toutes les trois mois lorsque vous serez en poste sur le sol canadien et accéder aux renseignements sur votre demande d'accompagnement emploi.<br>
•   Après avoir présenté une demande de prestations d'accompagnement emploi et que votre profile est acceptés, vous pourrez suivre l’évolution de votre dossier et certaines communications entre les différents intervenants. 

</p>

        </section>



        <section>
            <h2 style="color: blue; text-decoration-line :underline; ">Mon dossier ÜRI Canada:</h2>
            <p>Pour obtenir des renseignements sur votre demande, accéder à votre portail, ou pour mettre à jour votre adresse postale ou vos renseignements, consultez Mon dossier ÜRI Canada ou appeler notre Service d'information téléphonique au <strong style="text-decoration-line: underline;"> +1 (514) 677-7760</strong>.

</p>

        </section>


            <button onclick="location.href='../../candidat.php'" class="btn btn-secondary">Retour à la page principale</button>

        </section>
        <br>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
    </div>

    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 ÜRI Canada</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
