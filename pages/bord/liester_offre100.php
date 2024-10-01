<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Récupère l'ID de l'utilisateur
$userIdd = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupère les informations de l'utilisateur
$stmt = $conn->prepare("SELECT id, nom, prenom, prof FROM userss WHERE id = ?");
$stmt->bind_param("i", $userIdd);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usernamext = $row['id'];
    $usernamex = $row['nom'];
    $prenom = $row['prenom'];
    $profession = $row['prof'];  // On récupère le domaine d'activité
} else {
    $usernamex = "Utilisateur inconnu";
}

// Stocke l'heure de connexion actuelle si elle n'est pas déjà dans la session
if (!isset($_SESSION['last_login'])) {
    $_SESSION['last_login'] = date("Y-m-d H:i:s");  // Définit l'heure actuelle comme dernière connexion
}

// Notification de nouvelles offres
$lastLogin = $_SESSION['last_login'];  // Récupère l'heure de la dernière connexion depuis la session
$newOffersStmt = $conn->prepare("SELECT COUNT(*) as new_offers FROM offre WHERE submission_date > ?");
$newOffersStmt->bind_param("s", $lastLogin);
$newOffersStmt->execute();
$newOffersResult = $newOffersStmt->get_result();
$newOffersRow = $newOffersResult->fetch_assoc();

if ($newOffersRow['new_offers'] > 0) {
    echo '<div class="alert alert-info">Vous avez ' . $newOffersRow['new_offers'] . ' nouvelles offres disponibles depuis votre dernière connexion.</div>';
}

// Vérifie si la méthode HTTP est POST pour une nouvelle postulation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['offreId'], $_POST['residence'], $_POST['experience'], $_POST['disponibilite'], $_POST['salaire'])) {
        $offreId = $_POST['offreId'];
        $residence = $_POST['residence'];
        $experience = $_POST['experience'];
        $disponibilite = $_POST['disponibilite'];
        $salaire = $_POST['salaire'];
        $messages = $_POST['messages'];
        $competence = $_POST['competence'];

        $stmtCheck = $conn->prepare("SELECT id FROM postulations WHERE offre_id = ? AND user_idd = ?");
        $stmtCheck->bind_param("ii", $offreId, $userIdd);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            echo '<div class="alert alert-warning">Vous avez déjà postulé à cette offre.</div>';
        } else {
            $stmt = $conn->prepare("INSERT INTO postulations (offre_id, user_idd, residence, experience, disponibilite, salaire, messages, competence) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisissss", $offreId, $userIdd, $residence, $experience, $disponibilite, $salaire, $messages, $competence);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Votre demande a été envoyée. Le commanditaire vous contactera si possible par messagerie.</div>';
            } else {
                echo '<div class="alert alert-danger">Erreur lors de l\'enregistrement: ' . $stmt->error . '</div>';
            }
            $stmt->close();
        }
        $stmtCheck->close();
    } else {
        echo '<div class="alert alert-warning">Tous les champs requis ne sont pas définis.</div>';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisekork</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: rgb(199,199,199);
            color: rgb(12,35,66);
            padding: 10px;
            text-align: center;
        }

        .hero-section {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

     .hidden {
        visibility: hidden;
        height: 0;
        width: 0;
        margin: 0;
        padding: 0;
    }

        .hero-section img {
            width: 100%;
            height: 35%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            animation: fadeInOut 10s infinite;
        }

        @keyframes fadeInOut {
            0%, 20% {
                opacity: 0;
            }
            25%, 75% {
                opacity: 1;
            }
            80%, 100% {
                opacity: 0;
            }
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        

        .search-barss {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
        }

        #services-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            width: 100%;
        }



 
.service-box {
        width: 100%;
        margin: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
        overflow: hidden; /* Cache tout contenu dépassant de la boîte */
    }

    .service-box h2 {
        white-space: nowrap; /* Empêche le texte de se replier sur plusieurs lignes */
        overflow: hidden;
        text-overflow: ellipsis; /* Ajoute des points de suspension (...) pour indiquer que le texte a été coupé */
    }

    .service-info {
        max-height: 150px; /* Hauteur maximale de 100 pixels pour limiter la taille de la boîte */
        overflow-y: auto; /* Ajoute une barre de défilement verticale lorsque le contenu est trop long */
    }
</style>


</head>
<body>
    <div class="search-barss">
        <input type="text" id="serviceSearch" placeholder="Rechercher un service">
        <input type="text" id="locationSearch" placeholder="Emplacement">
        <button class="btn btn-primary" onclick="filterServices()">Rechercher</button>
    </div>

    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Requête pour afficher les offres qui correspondent au domaine d'activité de l'utilisateur en premier
    $sql = "SELECT * FROM offre 
            ORDER BY 
            CASE WHEN job_title  = ? THEN 1 ELSE 2 END, 
            submission_date DESC";
    $stmtOffers = $conn->prepare($sql);
    $stmtOffers->bind_param("s", $profession);
    $stmtOffers->execute();
    $result = $stmtOffers->get_result();

    if ($result->num_rows > 0) {
        echo '<div id="services-container" class="container-fluid">';
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo '<div class="service-box" data-job-title="' . $row['job_title'] . '" data-job-titlee="' . $row['job_titlee'] . '">';
            echo '<h3>' . $row['Entreprise'] . '</h3>';
            echo '<h4>' . $row['job_title'] . '</h4>';
            echo '<p>' . $row['etapes'] . '</p>';
            echo '<p>' . $row['type_poste'] . '</p>';
            echo '<div class="service-info">';
            echo '<p>Lieu : ' . $row['job_titlee'] . '</p>';
            echo '<p>Description: ' . $row['job_description'] . '</p>';
            echo '<p>Exigences: ' . $row['job_requirements'] . '</p>';
            echo '</div>';
            echo '<button class="btn btn-primary" onclick="showPostulationModal(\'' . $row['job_title'] . '\', ' . $row['id'] . ')">Postuler</button>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "Aucune offre disponible.";
    }

    $stmtOffers->close();
    $conn->close();
    ?>
    
    <!-- Modal de Postulation -->
    <!-- Modal de Postulation -->
    <form id="postulationForm" method="POST" action="">
<div id="successMessage" class="alert alert-success" style="display: none;">Enregistrement réussi.</div>
        <input type="hidden" id="offreId" name="offreId" value="1">
        <!-- Ajoutez d'autres champs requis ici -->
        <div class="modal fade" id="postulationModal" tabindex="-1" role="dialog" aria-labelledby="postulationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postulationModalLabel">Postuler pour <span id="modalJobTitle"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire pour saisir les informations de postulation -->
                        <div class="form-group">
                            <label for="residence">Nom complet du candidat</label>
                            <input type="text" class="form-control" id="residence" name="residence" placeholder="Entrez le nom complet du candidat pour lequel vous postulez" required>
                        </div>
                        <div class="form-group">
                            <label for="experience">Années d'expérience</label>
                            <input type="number" class="form-control" id="experience" name="experience" placeholder="Entrez le nombre d'années d'expérience" required>
                        </div>
                        <div class="form-group">
                            <label for="disponibilite">Disponibilité</label>
                            <input type="text" class="form-control" id="disponibilite" name="disponibilite" placeholder="Entrez votre disponibilité" required>
                        </div>
                        <div class="form-group">
                            <label for="salaire">Salaire souhaité</label>
                            <input type="text" class="form-control" id="salaire" name="salaire" placeholder="Entrez le salaire souhaité" required>
                        </div>
                         <div class="form-group">
                            <label for="messages">Message</label>
                            <textarea type="text" class="form-control" id="messages" name="messages" placeholder="Saisissez votre message" required>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="competence">Domaine de compétence</label>
                            <select type="text" class="form-control" id="competence" name="competence" required>
                                      <option>Electricien</option>
        <option>Plombier</option>
        <option>Mécanicien</option>
        <option>Menuisier</option>
        <option>Soudeur</option>
        <option>Maçon</option>
        <option>Peintre</option>
        <option>Charpentier</option>
        <option>Technicien HVAC</option>
        <option>Électromécanicien</option>
        <option>Ingénieur civil</option>
        <option>Architecte</option>
        <option>Technicien de laboratoire</option>
        <option>Infirmier</option>
        <option>Médecin généraliste</option>
        <option>Chirurgien</option>
        <option>Pharmacien</option>
        <option>Dentiste</option>
        <option>Technicien informatique</option>
        <option>Développeur web</option>
        <option>Développeur mobile</option>
        <option>Analyste de données</option>
        <option>Data Scientist</option>
        <option>Spécialiste SEO</option>
        <option>Designer graphique</option>
        <option>Photographe</option>
        <option>Vidéographe</option>
        <option>Chef cuisinier</option>
        <option>Pâtissier</option>
        <option>Boucher</option>
        <option>Poissonnier</option>
        <option>Serveur</option>
        <option>Sommelier</option>
        <option>Gérant de restaurant</option>
        <option>Agent de sécurité</option>
        <option>Agent de nettoyage</option>
        <option>Concierge</option>
        <option>Réceptionniste</option>
        <option>Secrétaire</option>
        <option>Assistant administratif</option>
        <option>Comptable</option>
        <option>Auditeur</option>
        <option>Contrôleur financier</option>
        <option>Consultant en gestion</option>
        <option>Gestionnaire de projet</option>
        <option>Responsable marketing</option>
        <option>Spécialiste en relations publiques</option>
        <option>Community manager</option>
        <option>Responsable des ressources humaines</option>
        <option>Coach professionnel</option>
        <option>Formateur</option>
        <option>Éducateur</option>
        <option>Professeur</option>
        <option>Assistant social</option>
        <option>Psychologue</option>
        <option>Orthophoniste</option>
        <option>Kinésithérapeute</option>
        <option>Chiropraticien</option>
        <option>Technicien agricole</option>
        <option>Ingénieur agronome</option>
        <option>Vétérinaire</option>
        <option>Géomètre</option>
        <option>Urbaniste</option>
        <option>Technicien en environnement</option>
        <option>Ingénieur en environnement</option>
        <option>Technicien en énergies renouvelables</option>
        <option>Ingénieur en énergies renouvelables</option>
        <option>Chauffeur</option>
        <option>Conducteur de bus</option>
        <option>Conducteur de train</option>
        <option>Pilote</option>
        <option>Steward</option>
        <option>Hôtesse de l'air</option>
        <option>Logisticien</option>
        <option>Responsable des achats</option>
        <option>Magasinier</option>
        <option>Chef de chantier</option>
        <option>Conducteur de travaux</option>
        <option>Manœuvre</option>
        <option>Éboueur</option>
        <option>Jardinier</option>
        <option>Paysagiste</option>
        <option>Ouvrier agricole</option>
        <option>Viticulteur</option>
        <option>Fromager</option>
        <option>Boulanger</option>
        <option>Éleveur</option>
        <option>Pêcheur</option>
        <option>Agriculteur</option>
        <option>Technicien de maintenance</option>
        <option>Technicien en télécommunications</option>
        <option>Installateur de panneaux solaires</option>
        <option>Installateur de chauffage</option>
        <option>Responsable de la qualité</option>
        <option>Responsable de la production</option>
        <option>Technicien de production</option>
        <option>Opérateur de machine</option>
        <option>Agent de fabrication</option>
        <option>Soudeur en tuyauterie</option>
        <option>Soudeur en structure métallique</option>
        <option>Autres</option> 
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button style="background-color: red;" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Postuler</button> <!-- Modifiez le type du bouton pour soumettre le formulaire -->
                    </div>
                </div>
            </div>
        </div>
    </form>


    <footer style="background-color: rgb(199,199,199); color: black;">
        <p>&copy; 2023 WiseWork</p>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        function filterServices() {
            var serviceSearch = document.getElementById('serviceSearch').value.toLowerCase();
            var locationSearch = document.getElementById('locationSearch').value.toLowerCase();

            var serviceBoxes = document.querySelectorAll('.service-box');
            var filteredServiceBoxes = [];

            serviceBoxes.forEach(function(box) {
                var jobTitle = box.getAttribute('data-job-title').toLowerCase();
                var jobLocation = box.getAttribute('data-job-titlee').toLowerCase();

                if (jobTitle.includes(serviceSearch) && jobLocation.includes(locationSearch)) {
                    filteredServiceBoxes.push(box.parentElement); // Ajoutez le parent de la boîte de service
                }
            });

            // Affiche uniquement les services filtrés
            var servicesContainer = document.getElementById('services-container');
            servicesContainer.innerHTML = ''; // Efface le contenu actuel
            filteredServiceBoxes.forEach(function(box) {
                servicesContainer.appendChild(box); // Ajoutez chaque boîte filtrée au conteneur de services
            });
        }

        function showPostulationModal(jobTitle, offreId) {
            // Mettre à jour le titre de l'offre dans le modal
            document.getElementById('postulationModalLabel').textContent = 'Postuler pour ' + jobTitle;
            // Mettre à jour l'ID de l'offre dans le champ caché
            document.getElementById('offreId').value = offreId;
            // Afficher le modal
            $('#postulationModal').modal('show');
        }

        function submitPostulation() {
            // Récupérer les valeurs saisies dans le formulaire
            var offreId = document.getElementById('offreId').value;
            var residence = document.getElementById('residence').value;
            var experience = document.getElementById('experience').value;
            var disponibilite = document.getElementById('disponibilite').value;
            var salaire = document.getElementById('salaire').value;
            var messages = document.getElementById('messages').value;
            var competence = document.getElementById('competence').value;

            // Créer un objet FormData pour envoyer les données au backend
            var formData = new FormData();
            formData.append('offreId', offreId);
            formData.append('residence', residence);
            formData.append('experience', experience);
            formData.append('disponibilite', disponibilite);
            formData.append('salaire', salaire);
            formData.append('messages', messages);
            formData.append('competence', competence);

            // Envoyer les données au backend via une requête AJAX
            fetch('', { // Spécifiez l'URL correcte pour le traitement de la soumission du formulaire
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Afficher le message "Enregistrement réussi"
                    document.getElementById('successMessage').style.display = 'block';
                    // Masquer le message après 3 secondes
                    setTimeout(function() {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000);
                    return response.json();
                }
                throw new Error('Erreur lors de la soumission du formulaire');
            })
            .then(data => {
                // Fermer le modal après la soumission
                $('#postulationModal').modal('hide');
                // Réinitialiser le formulaire
                document.getElementById('postulationForm').reset();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        }

        // Attend que le DOM soit entièrement chargé
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionne l'élément du message de réussite
            var successMessage = document.getElementById('successMessage');
            // Si l'élément existe
            if (successMessage) {
                // Masque le message après 3 secondes (3000 millisecondes)
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>

</body>
</html>
