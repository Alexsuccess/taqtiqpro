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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $entreprise_nom = $_POST['entreprise_nom'];

$entree1 = $_POST['entree1'];
$entree2 = $_POST['entree2'];
    
    $noms1 = $_POST['noms1'];
    $noms2 = $_POST['noms2'];
    $noms3 = $_POST['noms3'];
    $noms4 = $_POST['noms4'];
    $noms5 = $_POST['noms5'];
    $noms6 = $_POST['noms6'];
    $date_signature = $_POST['date_signature'];
    $date_debut = $_POST['date_debut'];   
    $signature = $_POST['signature']; 
    // Préparer et lier
    $stmt = $conn->prepare("INSERT INTO contrats (entreprise_nom, entree1, entree2,  noms1, noms2, noms3, noms4, noms5, noms6, date_signature, date_debut, signature, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssi", $entreprise_nom, $entree1, $entree2,  $noms1, $noms2, $noms3, $noms4, $noms5, $noms6, $date_signature, $date_debut, $signature, $userId);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Contrat enregistré avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


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

// Préparer la requête SQL pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];

    $telephone = $row['telephone'];
    
    $email = $row['email'];

    $type = $row['compte'];
    $statut = $row['statut'];

    // Vérifier le type et le statut de l'utilisateur
    if (
        $type !== "Entreprise" &&
        $type !== "Prestataire" &&
        $type !== "Marketing" ||
        $statut != 1 // comparaison non stricte si $statut peut être une chaîne
    ) {
        // Rediriger vers la page de connexion si le type n'est pas parmi ceux spécifiés ou le statut n'est pas 1
        header("Location: acceuil.php");
        exit();
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas trouvé dans la base de données
    header("Location: acceuil.php");
    exit();
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contrat</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contract-header {
            background-color: white;
            color: rgb(0,0,64);
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .section-title {
            color: #007bff;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .contract-body {
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 2px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            max-width: 100px;
        }

        .header .company-info {
            text-align: right;
        }

        .header .company-info h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }

        .header .company-info p {
            margin: 0;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">



        <div class="contract-header">
            <img style="width: 10%; height: 10%;" src="logooo.jpg" alt="Company Logo"> <h1>Contrat de recrutement de travailleurs internationaux </h1>
        </div>

        <form action="" method="POST">
            <section>
                <div class="contract-body">
                    <h2 class="section-title">Entreprise</h2>
                    <p> Le présent CONTRAT est un contrat de (« Entreprise ») d'entrée en vigueur » </p>
                  
                    <div class="row">
                        <div class="col-md-12">
                           <strong>Entre</strong> 
                            <div class="form-group">
                                <label for="entreprise_nom">Nom de l'Entreprise / Adresse de l'Entreprise / Numéro de Téléphone / Adresse Courriel</label>
                                <input type="text" class="form-control" id="entreprise_nom" name="entreprise_nom" value="<?php echo htmlspecialchars($nom . ' ' . $prenom); ?>" required>
                            </div>
                          <strong>ET</strong>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="entreprise_adresse">ÜRI Canada Inc (9497-1231 Québec Inc) (« l’Agence ») Situé 1565 Boul. de L’Avenir Laval, Québec H7S2N5</label>
                                
                            </div>
                        </div>


                        </div>

                    </div>
                </div>
            </section>




            <div class="contract-body">
                <h2 class="section-title">Agence placement et de recrutement international</h2>
                <p>Cette entente décrit les conditions dans lesquelles l'agence fournira des services à l’entreprise.</p>
            </div>

            <!-- Engagement Section -->
            <div class="contract-body">
                <h2 class="section-title">Responsabilités et engagement de ÜRI Canada</h2>
                <p>Le client demande à ÜRI Canada, et celui-ci accepte, de représenter le client au sujet d’une demande de Permis de travail – un travailleur étranger.</p>
                <p>En contrepartie des frais payés et en raison de l’affaire mentionnée ci-dessus, le ÜRI Canada s’engage à:</p>

                <h3 class="section-title">Avant le dépôt de la demande</h3>
                <div class="form-group">
                    <textarea class="form-control" rows="5" disabled>
- Évaluer les qualités requises pour le poste ;
- informer le client des étapes à suivre ;
- conseiller le client à propos des documents requis en appui de sa demande ;
- examiner et analyser les documents reçus en appui des études, de la formation, de l’expérience de travail et de l’état civil du client ;
- informer le client si des preuves supplémentaires sont requises ;
- communiquer avec l’employeur et prendre toute l’information nécessaire ;
- agir dans le meilleur intérêt du client dans le cadre de la loi canadienne et/ou québécoise.
                    </textarea>
                </div>

                <h3 class="section-title">Soumission de la demande</h3>
                <div class="form-group">
                    <textarea class="form-control" rows="3" disabled>
- Soumettre la trousse de demande du client au bureau appropriée du gouvernement désigné et vérifier qu’elle a bien été reçue ;
- fournir au client son numéro de dossier d’immigration.
                    </textarea>
                </div>

                <h3 class="section-title">Après le dépôt de la demande</h3>
                <div class="form-group">
                    <textarea class="form-control" rows="5" disabled>
- informer le client de l’état d’avancement de sa demande ;
- tenir le client à jour de l’état d’avancement de l’affaire et répondre à toutes les demandes raisonnables du client et/ou en son nom ;
- agir à titre d’intermédiaire entre le gouvernement canadien/québécois et le client ;
- intervenir auprès des autorités canadiennes/québécoises dans le cas de problème en lien avec le traitement de la demande ;
- assurer toute la correspondance avec Service canada/gouvernement du Québec au nom du client pour ce qui est de la demande du client.
                    </textarea>
                </div>
            </div>

            <!-- Responsabilités Section -->
            <div class="contract-body">
                <h2 class="section-title">Responsabilités et Engagement du Client</h2>
                <div class="form-group">
                    <textarea class="form-control" rows="5" disabled>
• Les responsabilités consistent notamment à fournir à l'Agence toutes informations qui peuvent et aide l’agence à mener à bien son entreprise à la réalisation de son mandat et s'engage à collaborer en fournissant toutes les informations et documents en anglais ou en français ou traduite en anglais ou en français utiles facilitant la démarche auprès des institutions compétentes. Les supports de promotion les plus à jour, les 
détails des frais et les exigences des postes et recrutements, correspondantes concernant l’Agence et l’entreprise, ainsi qu'à fournir à l'Agence un support technique pour le recrutement des travailleurs; 

• L’Agence remettra une lettre d’acceptation aux candidats  sous l’autorisation de l’entreprise dans un délai de trois jours ouvrables, à condition que les candidats soient admissibles et qu’ils aient payé des frais relatifs qui sont non remboursables; 

• En contrepartie des services fournis par l'Agence ÜRI Canada Inc conformément à la présente convention, l’entreprise s'engage à lui verser les frais de services, telle que décrite ci-dessous, 

▪ Les obligations du membre en vertu du contrat de service professionnel sont nuls si le client
fournis en toute connaissance de cause des renseignements importants inexacts, trompeurs ou
faux. Les obligations financières du ou des clients demeurent. 

Le client s’engage à fournir l’ensemble des documents demandés dans un délai raisonnable. Ce délai ne devant pas dépasser 3 mois de la date de signature de ce contrat de service
professionnel.

                    </textarea>
                </div>
            </div>


<div class="contract-body">

                <h3 class="section-title">SERVICES DE L’AGENCE</h3>
                <div class="form-group">
 
                <div class="form-control" rows="5" style="height: auto;">
                    <p>• Recrutera des travailleurs internationaux au compte et pour l’entreprise et fournira aux responsables des informations précises sur l’employé;</p>
                    <p>• Se conformera rigoureusement sur toutes les instructions données par l’entreprise à tout moment, et ne fera aucune déclaration, garantie, promesse, contrat, entente ou tout autre acte liant l’entreprise. L’entreprise ne peut être tenu responsable d'actes ou de manquements de la part de l’Agence, advenant une déviation qui est au-delà de ces instructions ou contraires à celles-ci;</p>
                    <p>• Ne recrutera que des travailleurs locaux et internationaux qualifiés qui répondent aux critères et aux conditions des postes d’emploi enclin à répondre aux postes à pourvoir;</p>
                    <p>• Représentera l’entreprise de manière professionnelle et courtoise et maintiendra une image professionnelle en tout temps;</p>
                    <p>• Aura procuration d’agir au nom et pour le compte de l’entreprise <input type="text" class="form-control" id="entree1" name="entree1" required> dans le cadre de l’embauche, recrutement et le placement des nouveaux collaborateurs. Ces pouvoirs incluent, mais ne se limitent pas à, la publication d'offres d'emploi, la réception et la sélection de candidatures, la conduite d'entretiens d'embauche, la négociation des conditions d'embauche et la signature des contrats de travail au nom de <input type="text" class="form-control" id="entree2" name="entree2" required>.</p>
                    <p>• À l’autorisation de faire en son nom toutes les démarches liées à l’accès ou la création du compte en ligne pour la demande d’EIMT, effectuer la demande d’EIMT, la demande du permis de Travail auprès du gouvernement du Canada, le CAQ (Certificat d’Acceptation du Québec) et tous documents pertinents en rapport avec ladite démarche du candidat retenu.</p>
                    <p>• Veillera à ce que tous les documents requis pour l’obtention des certifications et autorisations tel que le CAQ, permis de travail pour le EIMT soient soumis correctement, et dans les délais et conformément aux politiques de l’entreprise et l’immigration;</p>
                    <p>• Devra présélectionner les candidats potentiels afin de s'assurer de leur admissibilité à entrer au Canada et obtenir un permis de travail;</p>
                    <p>• Devra se conformer aux réglementations canadiennes et locales en vigueur dans le pays et la région dans lesquels il/elle mène ses activités de recrutement professionnel;</p>
                    <p>• Reconnaît qu'il est potentiellement un employé de l’entreprise ou de l’agence et que selon la présente convention et constitue une certaine interprétation mais ne crée une relation de partenariat ou de co-entreprise entre l’entreprise et l'Agence;</p>
                    <p>• Tout paiement devra se faire par l’entreprise directement à l’Agence par le biais d’un paiement par chèque, transfert ou par virement bancaire;</p>
                    <p>• Doit recevoir une autorisation préalable pour l'utilisation du nom et du logo de l’entreprise dans tout support visuel marketing ou tout type de documentation créée par l'Agence;</p>
                    <p>• Pour valider le recrutement du travailleur en son nom, l’Agence doit transmettre par courriel, poste recommandée ou toute autre voie de communication qu’il est possible de retracer, la totalité des documents exigés pour le recrutement de son candidat. L’Agence peut se présenter à l’entreprise pour remettre les dossiers des travailleurs au personnel de l’entreprise;</p>
                    <p>• L’Agence pourrait réclamer les frais de services de recrutement pour un travailleur déjà soumis à l’entreprise avec ou sans un autre Agence;</p>
                    <p>• L’Agence n’est pas dans l’obligation de divulguer à l’entreprise tous les intervenants, partenaires ou associés opérant avec lui. L’entreprise admettre une intervention d’Agences non acceptés ou identifiés au préalable par sa direction.</p>
                </div>

         
                </div>
 </div>

            <div class="contract-body">
                <h2 class="section-title">Honoraires, méthode de facturation et conditions</h2>
                <div class="form-group">

                 <textarea class="form-control" rows="5" disabled>
Les honoraires professionnels fixes pour les services cités ci- dessus sont de : 6500$ annuel.  

Le montant indiqué ci-dessus doit être payé par le client et est sujet à changement par accord mutuel entre les parties. Tout service extra (non stipulé du présent contrat) sollicité par le client à ÜRI Canada et dont le ÜRI Canada a accepté le mandat, sera facturé au Client au taux horaire de CND$ 390.

Les frais du gouvernement seront à la charge du client (CND$ 444 Immigration Québec + CND$ 1.000 Service Canada + CND$ 155 permis de travail) excluant tous les frais accessoires, immigration, frais de matériel et d’outils, d'assurance  maladie et autres frais afférents aux candidats); 

Les débours relativement aux frais de messager seront à la charge de ÜRI Canada.

Si le Client réside au Canada ou si le contrat de service est signé au Canada, les taxes de vente
Fédérale et provinciale s’appliqueront.

Le Client autorise ÜRI Canada à transférer les fonds reçus dans son compte (en fidéicommis) pour le paiement des services professionnels rendus.


                  </textarea>

            </div>

            <!-- Services Section -->
            <div class="contract-body">
                <h2 class="section-title">Échéancier des paiements</h2>
                <textarea class="form-control" rows="5" disabled>Paiement : CND$ 6.500 + CND$ 1.599 (frais du gouvernement) à la signature du contrat de service .
 
Le taux des frais de services est basé sur le nombre de recrutés par l'Agence au cours de chaque  année fiscale. Une année fiscale débute en janvier et se termine en décembre; 

• L'Agence convient qu'il / elle exploite une entreprise indépendante et qu’il/elle est entièrement responsable de toutes ses dépenses. L’entreprise ne sera pas responsable des coûts encourus par l’Agence  lors de l'exécution ou de la tentative de réalisation de l'une des activités décrites dans la présente convention;
• Si le l’entreprise décide de ne pas poursuivre ses engagements au niveau du contrat de travail avec le travailleur, pour quelque raison que ce soit, la totalité des frais engendrés par l’Agence, la procédure et autre frais afférents seront remboursé à l’agence et les frais de relocalisation lui seront remboursés. L'Agence ne renoncera pas à dû sur les frais de service. L’Agence se réserve le droit d'ajuster ce montant du montant dû à l'Agence, le cas échéant;
• Les frais de services sont payés entièrement à l'Agence au plus tard 15 jours après la signature du contrat. L’entreprise procédera par chèque ou par dépôt direct sur le compte bancaire désigné par l’Agence, dans les sept (7) à dix (10) jours ouvrables après la réception de la facture de l’Agence. 
</textarea>
            </div>




            <!-- Services Section -->
            <div class="contract-body">
                <h2 class="section-title">DURÉE ET RÉSILIATION</h2>
                <textarea class="form-control" rows="5" disabled>• La période de validité de cet accord est à partir de la date de signature du présent contrat. Cet accord peut être résilié à la réception d'un préavis  écrit de 30 jours de l'une ou l'autre des parties; 
• En cas de résiliation de cet accord, toute somme gagnée par l'Agence pour les  travailleurs déjà envoyés, soumis, recrutés et/ou signés sera versée à l'Agence à mesure que les dates de signatures et d’entrés en poste sont payés et encaissés; 
• En cas de résiliation pour quelque raison que ce soit, chaque partie rend immédiatement à l’autre tout bien, accès et autre appartenant à l’autre qui est en sa possession. 

</textarea>
            </div>





            <!-- Services Section -->
            <div class="contract-body">
                <h2 class="section-title">DROIT APPLICABLE</h2>
                <textarea class="form-control" rows="5" disabled>Dans le cas d’un conflit, le client et ÜRI Canada doivent s’efforcer autant que possible de résoudre le problème entre les deux parties. Si le conflit ne peut pas être réglé, 
• La présente convention, son interprétation et tous les différends qui en découlent sont régis par les lois de la province de Québec, sans égard à son choix de règles de loi. 

</textarea>
            </div>
            <!-- Services Section -->





    <style>

        canvas {
            border: 1px solid #000;
            width: 100%; /* Largeur maximale */
            height: 200px; /* Hauteur définie */
        }
        textarea {
            width: 100%;
            height: 200px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-warning {
            background-color: #ffc107;
            margin-top: 10px;
        }
    </style>





            <!-- Dates Section -->
            <div class="contract-body">
                <h2 class="section-title">Signataire</h2>
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="noms1">Nom et prénom</label>
                    <input type="text" class="form-control" id="noms1" name="noms1" value="<?php echo htmlspecialchars($nom . ' ' . $prenom); ?>" required>
                </div>
</div>
<div class="col-md-6">
                                <div class="form-group">
                    <label for="noms2">Titre</label>
                    <input type="text" class="form-control" id="noms2" name="noms2" value="<?php echo htmlspecialchars($type); ?>" required>
                </div>
</div>
<div class="col-md-6">
                                <div class="form-group">
                    <label for="noms3">Adresse</label>
                    <input type="text" class="form-control" id="noms3" name="noms3" required>
                </div>
</div>
<div class="col-md-6">
                                <div class="form-group">
                    <label for="noms4">Numéro de téléphone </label>
                    <input type="text" class="form-control" id="noms4" name="noms4" value="<?php echo htmlspecialchars($telephone); ?>" required>
                </div>
</div>
<div class="col-md-6">
                                <div class="form-group">
                    <label for="noms5">Numéro de cellulaire </label>
                    <input type="text" class="form-control" id="noms5" name="noms5" value="<?php echo htmlspecialchars($telephone); ?>" required>
                </div>
</div>
<div class="col-md-6">
                                <div class="form-group">
                    <label for="noms6">Adresse courriel </label>
                    <input type="email" class="form-control" id="noms6" name="noms6" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

</div>

<div class="col-md-6">

                <div class="form-group">
                    <label for="date_signature">Date de Signature</label>
                    <input type="date" class="form-control" id="date_signature" name="date_signature" required>
                </div>
</div>
<div class="col-md-6">
                <div class="form-group">
                    <label for="date_debut">Entreprise</label>
                    <input type="text" class="form-control" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($nom . ' ' . $prenom); ?>" required>
                </div>
            </div>
</div>

    <div class="container">
        <h2>Signature</h2>
        
            <div class="form-group">
                <label for="signature">Dessinez votre signature ci-dessous :</label>
                <canvas id="signatureCanvas" required></canvas>
                <br>
                <button type="button" class="btn btn-warning" id="clearBtn">Effacer</button>
                <br><br>
                <!-- Champ caché pour stocker les données de la signature -->
                <input type="hidden" id="signature" name="signature" required>
            </div>
    </div>




</div>


            <div class="contract-body text-center">
              <img style="width: 100%;" src="titi.PNG">  

<div class="form-group">
    <label>
        <input type="checkbox" name="accept_terms" required> J'accepte les 
        <a href="pages/bord/contracts.html" target="_blank">termes du contrat</a>
    </label>
</div>
                <button type="submit" class="btn btn-primary">Soumettre le Contrat</button>
            </div>
        </form>
    </div>
</body>
    <!-- Script JavaScript pour la signature -->
    <!-- Script JavaScript pour la signature -->
    <script>
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        const clearBtn = document.getElementById('clearBtn');
        const signatureInput = document.getElementById('signature');

        // Définir les dimensions du canvas pour correspondre à l'affichage
        canvas.width = canvas.offsetWidth;
        canvas.height = 200;

        let drawing = false;

        // Commencer le dessin quand l'utilisateur appuie sur la souris
        canvas.addEventListener('mousedown', function(e) {
            drawing = true;
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        // Dessiner lorsque la souris se déplace
        canvas.addEventListener('mousemove', function(e) {
            if (drawing) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        });

        // Arrêter le dessin quand l'utilisateur relâche la souris
        canvas.addEventListener('mouseup', function() {
            drawing = false;
            ctx.beginPath(); // Préparer pour un nouveau tracé
        });

        // Empêcher les gestes tactiles d'interférer avec le dessin
        canvas.addEventListener('mouseleave', function() {
            drawing = false;
        });

        // Effacer le canvas
        clearBtn.addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        // Sauvegarder la signature en tant qu'image base64 dans un champ caché
        document.querySelector('form').addEventListener('submit', function() {
            signatureInput.value = canvas.toDataURL('image/png'); // Enregistrer la signature comme image base64
        });
    </script>

</html>
