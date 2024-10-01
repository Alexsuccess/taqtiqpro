<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Connexion à la base de données
    $servername = "4w0vau.myd.infomaniak.com";
    $username = "4w0vau_dreamize";
    $password = "Pidou2016";
    $dbname = "4w0vau_dreamize";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'] ?? '';
        $pays = $_POST['pays'] ?? '';
        $ville = $_POST['ville'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';



        $date_debut = $_POST['date_debut'] ?? '';
        $duree_emploi = $_POST['duree_emploi'] ?? '';
        $heures_travail = $_POST['heures_travail'] ?? '';
        $salaire = $_POST['salaire'] ?? '';
        $exigences_linguistiques = $_POST['exigences_linguistiques'] ?? '';
        $justification = $_POST['justification'] ?? '';
        $exigences_scolarite = $_POST['exigences_scolarite'] ?? '';
        $securite = $_POST['securite'] ?? '';
        $logement = isset($_POST['logement']) ? 1 : 0;
        $billet_avion = isset($_POST['billet_avion']) ? 1 : 0;
        $vehicule = isset($_POST['vehicule']) ? 1 : 0;
        $transport = isset($_POST['transport']) ? 1 : 0;
        $nourriture = isset($_POST['nourriture']) ? 1 : 0;
        $autre = isset($_POST['autre']) ? 1 : 0;
        $explications = $_POST['explications'] ?? '';
        $assistance = $_POST['assistance'] ?? '';
        $employes_etrangers = $_POST['employes_etrangers'] ?? '';
        $nombre_etrangers = $_POST['nombre_etrangers'] ?? '';
        $eimt_numero = $_POST['eimt_numero'] ?? '';
        $premiere_fois = $_POST['premiere_fois'] ?? '';
        $nombre_personnes = $_POST['nombre_personnes'] ?? '';
        $selected_services = json_decode($_POST['selected_services'], true);

        // Générer un code de commande unique
        $code_commande = strtoupper(bin2hex(random_bytes(4))); // Génère un code de 8 caractères hexadécimaux

        // Insérer les informations de la commande
        $stmt = $conn->prepare("INSERT INTO commandes51 (code_commande, nom, pays, ville, contact, email, date_debut, duree_emploi, heures_travail, salaire, exigences_linguistiques, justification, exigences_scolarite, securite, logement, billet_avion, vehicule, transport, nourriture, autre, explications, assistance, employes_etrangers, nombre_etrangers, eimt_numero, premiere_fois, nombre_personnes, statut, datte) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'En attente', now())");
        $stmt->bind_param("sssssssssssssssssssssssssss", $code_commande, $nom, $pays, $ville, $contact, $email, $date_debut, $duree_emploi, $heures_travail, $salaire, $exigences_linguistiques, $justification, $exigences_scolarite, $securite, $logement, $billet_avion, $vehicule, $transport, $nourriture, $autre, $explications, $assistance, $employes_etrangers, $nombre_etrangers, $eimt_numero, $premiere_fois, $nombre_personnes);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Vérifier si l'ID de commande a été correctement inséré
        if ($order_id) {
            // Insérer les services sélectionnés
            foreach ($selected_services as $service) {
                $title = $service['title'];
                $quantity = $service['quantity'];
                $stmt = $conn->prepare("INSERT INTO commande_services50 (code_commande, service_title, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $code_commande, $title, $quantity);
                $stmt->execute();
            }
        } else {
            echo "Erreur lors de l'insertion de la commande.";
        }

        $stmt->close();
        $conn->close();

        // Redirection après succès
        header("Location: confirmation.php");
        exit();
    }

    // Récupérer les services depuis la base de données
    $services_query = "SELECT * FROM services50";
    $services_result = $conn->query($services_query);

    $services = [];
    if ($services_result->num_rows > 0) {
        while ($row = $services_result->fetch_assoc()) {
            $services[] = $row;
        }
    }

    $conn->close();
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            background-image: url('tt.avif');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
        }

        .container-fluid {
            display: flex;
            height: 100vh;
            padding: 0;
        }

        .nav-container {
            flex: 0 0 250px;
            background-color: white;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .content-container {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: rgba(26, 26, 26, 0.8);
        }

        .nav-link {
            color: #007bff;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #f0f0f0;
        }

        .nav-link.active {
            background-color: #007bff;
            color: white;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-body {
            background-color: #f8f9fa;
        }

        .scrollable-content {
            max-height: 200px;
            overflow-y: auto;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        .selected-service {

            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selected-service .service-title {
            font-weight: bold;
        }

        .selected-service .quantity {
            font-style: italic;
        }

        #commanderBtn {
            border-radius: 20px;
        }

        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>

<body style="background-image: url(tt.avif);">
    <div>
        <div class="container-fluid">
            <!-- Menu de filtrage par catégorie -->
            <div class="nav-container">
                <div class="search-bar">
                    <input type="text" id="search" class="form-control" placeholder="Rechercher un service...">
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#" onclick="showSection('all')">Tous</a>
                    <a class="nav-link" href="#" onclick="showSection('btp')">BTP</a>
                    <a class="nav-link" href="#" onclick="showSection('administratif')">Administratif</a>
                    <a class="nav-link" href="#" onclick="showSection('informatique')">Informatique</a>
                    <a class="nav-link" href="#" onclick="showSection('santé')">Santé</a>
                    <a class="nav-link" href="#" onclick="showSection('mécanique')">Mécanique</a>
                    <a class="nav-link" href="#" onclick="showSection('aéronautique')">Aéronautique</a>
                    <a class="nav-link" href="#" onclick="showSection('transport')">Transport</a>
                    <a class="nav-link" href="#" onclick="showSection('minier')">Minier</a>
                    <a class="nav-link" href="#" onclick="showSection('autre')">Autre</a>
                </nav>
            </div>

            <!-- Contenu des services -->
            <div class="content-container">
                <div id="selected-services">
                    <h3 class="text-white mb-4">Services sélectionnés</h3>
                    <div id="selected-services-list" class="row ml-5"></div>
                </div>

                <div class="container mt-5">
                    <!-- Sections de contenu pour chaque catégorie -->
                    <div id="all" class="content-section show">
                        <div class="row">
                            <!-- Card pour chaque catégorie -->
                            <?php
                            // Créez un tableau pour stocker les images aléatoires par catégorie
                            $categoryImages = [];

                            // Parcourez les services pour sélectionner une image aléatoire pour chaque catégorie
                            foreach ($services as $service) {
                                $category = strtolower($service['category']);
                                if (!isset($categoryImages[$category])) {
                                    $categoryImages[$category] = [];
                                }
                                $categoryImages[$category][] = $service['img'];
                            }

                            // Sélectionnez une image aléatoire pour chaque catégorie
                            foreach (['btp', 'administratif', 'informatique', 'santé', 'mécanique', 'aéronautique', 'transport', 'minier', 'autre'] as $category) {
                                $images = $categoryImages[strtolower($category)] ?? [];
                                $randomImage = !empty($images) ? $images[array_rand($images)] : '../../other.jpeg'; // Image par défaut si aucune image n'est trouvée
                            ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card category-card <?php echo htmlspecialchars($category); ?>">
                                        <div class="card-header">
                                            <h5 class="card-title"><?php echo ucfirst(htmlspecialchars($category)); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="<?php echo htmlspecialchars($randomImage); ?>" class="card-img-top pb-3" alt="<?php echo htmlspecialchars($category); ?>">
                                            <button class="btn btn-info" style="width: 310px;" type="button" data-toggle="collapse"
                                                data-target="#collapse-<?php echo htmlspecialchars($category); ?>" aria-expanded="false"
                                                aria-controls="collapse-<?php echo htmlspecialchars($category); ?>">
                                                Afficher les services
                                            </button>
                                            <div class="collapse mt-3" id="collapse-<?php echo htmlspecialchars($category); ?>">
                                                <div class="scrollable-content">
                                                    <div class="list-group">
                                                        <?php foreach ($services as $service): ?>
                                                            <?php if (strtolower($service['category']) === strtolower($category)): ?>
                                                                <div class="list-group-item service-card">
                                                                    <h6><?php echo htmlspecialchars($service['title']); ?></h6>
                                                                    <input type="checkbox" data-title="<?php echo htmlspecialchars($service['title']); ?>">
                                                                    Sélectionner
                                                                    <input type="number" min="1" value="1" class="form-control mt-2" placeholder="Quantité">
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <button class="btn btn-primary mt-4" id="commanderBtn" data-toggle="modal"
                            data-target="#commanderModal">Commander</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="commanderModal" tabindex="-1" role="dialog" aria-labelledby="commanderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Services sélectionnés :</h5>
                        <ul class="row" id="modal-services-list"></ul>
                        <input type="hidden" id="selected_services" name="selected_services">


                        <form id="orderForm" method="POST" action="">
                            <input type="hidden" id="selected-services-data" name="selected_services">
                            <div class="form-group">
                                <label for="nom">Nom de l'entreprise</label>
                                <input type="text" id="nom" name="nom" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="contact">Nom & Prénom du Résponsable</label>
                                <input type="text" id="contact" name="contact" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="pays">Téléphone</label>
                                <input type="text" id="pays" name="pays" class="form-control" required="required">
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required="required">
                            </div>


                            <div class="form-group">
                                <label for="ville">Ville</label>
                                <input type="text" id="ville" name="ville" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="pays">Pays</label>
                                <input type="text" id="pays" name="pays" class="form-control" required="required">
                            </div>





                            <div class="form-group">
                                <label for="date_debut">Date prévue du début de l’emploi et la durée (en mois)</label>
                                <input type="date" id="date_debut" name="date_debut" class="form-control"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label for="duree_emploi">Durée de l’emploi demandé</label>
                                <input type="text" id="duree_emploi" name="duree_emploi" class="form-control"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label for="heures_travail">Combien d’heure de travail par jour et combien de jour par
                                    semaine</label>
                                <input type="text" id="heures_travail" name="heures_travail" class="form-control"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label for="salaire">Quel est le salaire de base par heure ($)</label>
                                <input type="number" step="0.01" id="salaire" name="salaire" class="form-control"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label>Exigences linguistiques :</label>
                                <div class="form-check">
                                    <input type="radio" id="francais" name="exigences_linguistiques" value="francais"
                                        class="form-check-input">
                                    <label class="form-check-label" for="francais">Français</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="anglais" name="exigences_linguistiques" value="anglais"
                                        class="form-check-input">
                                    <label class="form-check-label" for="anglais">Anglais</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="francais_anglais" name="exigences_linguistiques"
                                        value="francais_anglais" class="form-check-input">
                                    <label class="form-check-label" for="francais_anglais">Français et anglais</label>
                                </div>
                                <div class="form-group">
                                    <label for="justification">S’il n y a pas d’exigence, justifiez.</label>
                                    <input type="text" id="justification" name="justification" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Exigences minimales de scolarité/ expérience relatives au poste.</label>

                                <div class="form-check">
                                    <input type="radio" id="etudes_secondaire" name="exigences_scolarite"
                                        value="etudes_secondaire" class="form-check-input">
                                    <label class="form-check-label" for="etudes_secondaire">Études secondaire</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="diplome_collegial" name="exigences_scolarite"
                                        value="diplome_collegial" class="form-check-input">
                                    <label class="form-check-label" for="diplome_collegial">Diplôme collégial</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="aucune_etude" name="exigences_scolarite"
                                        value="aucune_etude" class="form-check-input">
                                    <label class="form-check-label" for="aucune_etude">Aucune</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="securite">Il y a-t-il des inquiétudes concernant la sécurité ou les dangers
                                    associés à l’activité commerciale ou au lieu de travail? Si oui, décrivez en
                                    détails</label>
                                <textarea id="securite" name="securite" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Est-ce que vous fournissez :</label>
                                <div class="form-check">
                                    <input type="checkbox" id="logement" name="logement" class="form-check-input">
                                    <label class="form-check-label" for="logement">Un logement convenable et abordable
                                        au travailleur</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="billet_avion" name="billet_avion"
                                        class="form-check-input">
                                    <label class="form-check-label" for="billet_avion">Billet d’avion</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="vehicule" name="vehicule" class="form-check-input">
                                    <label class="form-check-label" for="vehicule">Véhicule</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="transport" name="transport" class="form-check-input">
                                    <label class="form-check-label" for="transport">Transport</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="nourriture" name="nourriture" class="form-check-input">
                                    <label class="form-check-label" for="nourriture">Nourriture</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="autre" name="autre" class="form-check-input">
                                    <label class="form-check-label" for="autre">Autre</label>
                                </div>
                                <div class="form-group">
                                    <label for="explications">Si oui expliquez en détails</label>
                                    <textarea id="explications" name="explications" class="form-control"
                                        rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="assistance">Si non, comment allez-vous l’assister?</label>
                                    <textarea id="assistance" name="assistance" class="form-control"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Avez-vous des employés étrangers déjà en place?</label>
                                <div class="form-check">
                                    <input type="radio" id="etrangers_oui" name="employes_etrangers" value="oui"
                                        class="form-check-input">
                                    <label class="form-check-label" for="etrangers_oui">Oui</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="etrangers_non" name="employes_etrangers" value="non"
                                        class="form-check-input">
                                    <label class="form-check-label" for="etrangers_non">Non</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nombre_etrangers">Si oui, quel est le nombre total d’employés étrangers
                                    embauchés à l’aide d’une EIMT qui travaillent actuellement pour vous?</label>
                                <input type="number" id="nombre_etrangers" name="nombre_etrangers" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eimt_numero">Numéro du EIMT :</label>
                                <input type="text" id="eimt_numero" name="eimt_numero" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Est-ce la première fois que vous prévoyez embaucher à l’étranger?</label>
                                <div class="form-check">
                                    <input type="radio" id="premiere_oui" name="premiere_fois" value="oui"
                                        class="form-check-input">
                                    <label class="form-check-label" for="premiere_oui">Oui</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="premiere_non" name="premiere_fois" value="non"
                                        class="form-check-input">
                                    <label class="form-check-label" for="premiere_non">Non</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Combien de personnes?</label>
                                <div class="form-check">
                                    <input type="radio" id="moins_50" name="nombre_personnes" value="moins_50"
                                        class="form-check-input">
                                    <label class="form-check-label" for="moins_50">Moins de 50</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="plus_50" name="nombre_personnes" value="plus_50"
                                        class="form-check-input">
                                    <label class="form-check-label" for="plus_50">Plus de 50</label>
                                </div>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" id="logement" name="logement" class="form-check-input"
                                    required="required">
                                <label class="form-check-label" for="logement">J'accepte les termes du contrat</label>
                            </div>


                            <input type="hidden" id="selected_services" name="selected_services">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>







                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Fonction pour afficher ou cacher les sections selon la catégorie sélectionnée
                function showSection(category) {
                    var sections = document.querySelectorAll('.category-card');
                    sections.forEach(function(section) {
                        if (category === 'all' || section.classList.contains(category)) {
                            section.parentElement.style.display = 'block';
                        } else {
                            section.parentElement.style.display = 'none';
                        }
                    });
                }

                // Ajout des événements de filtrage
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        const category = this.getAttribute('onclick').match(/'(\w+)'/)[1];
                        showSection(category);
                        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                        this.classList.add('active');
                    });
                });

                // Fonction pour ajouter ou enlever des services sélectionnés
                document.querySelectorAll('.service-card input[type="checkbox"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const title = this.getAttribute('data-title');
                        const quantity = this.parentElement.querySelector('input[type="number"]').value;
                        const selectedList = document.getElementById('selected-services-list');

                        if (this.checked) {
                            // Crée un nouvel élément de service sélectionné
                            const listItem = document.createElement('div');
                            listItem.className = 'selected-service mr-3';
                            listItem.innerHTML = `
                    <span class="service-title mr-3">${title}</span>
                    <span class="quantity mr-4">Quantité: ${quantity}</span>
                    <button class="btn btn-danger btn-sm remove-btn">Supprimer</button>
                `;
                            selectedList.appendChild(listItem);

                            // Ajoute un événement pour supprimer l'élément
                            listItem.querySelector('.remove-btn').addEventListener('click', () => {
                                checkbox.checked = false;
                                selectedList.removeChild(listItem);
                            });
                        } else {
                            // Supprime l'élément de la liste si décoché
                            Array.from(selectedList.children).forEach(item => {
                                if (item.querySelector('.service-title').textContent === title) {
                                    selectedList.removeChild(item);
                                }
                            });
                        }
                    });
                });

                // Fonction pour préparer les données avant la commande
                document.getElementById('commanderBtn').addEventListener('click', function() {
                    const selectedServices = [];
                    document.querySelectorAll('.service-card').forEach(card => {
                        const checkbox = card.querySelector('input[type="checkbox"]');
                        if (checkbox.checked) {
                            const title = checkbox.getAttribute('data-title');
                            const quantity = card.querySelector('input[type="number"]').value;
                            selectedServices.push({
                                title,
                                quantity
                            });
                        }
                    });
                    // Assurez-vous que le champ de formulaire dans le modal est correctement défini
                    document.getElementById('selected_services').value = JSON.stringify(selectedServices);
                });

                // Afficher les éléments sélectionnés dans le modal
                $('#commanderModal').on('show.bs.modal', function() {
                    const selectedList = document.getElementById('selected-services-list');
                    const modalServicesList = document.getElementById('modal-services-list');
                    modalServicesList.innerHTML = selectedList.innerHTML;
                });

                // Afficher toutes les sections au chargement initial
                showSection('all');
            })
        </script>



</body>

</html>