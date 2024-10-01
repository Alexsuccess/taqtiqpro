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


// Récupérer toutes les catégories
$categories_query = "SELECT DISTINCT category FROM services50";
$categories_result = $conn->query($categories_query);
$categories = [];
if ($categories_result->num_rows > 0) {
    while ($row = $categories_result->fetch_assoc()){
        $categories[] = htmlspecialchars($row['category']);
    }
}

// Récupérer les services depuis la base de données
$services_query = "SELECT * FROM services50";
$services_result = $conn->query($services_query);

$services = [];
if ($services_result->num_rows > 0) {
    while ($row = $services_result->fetch_assoc()) {
        $row['title'] = htmlspecialchars($row['title']);
        $row['category'] = htmlspecialchars($row['category']);
        $services[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <main>
        <!-- entête de la page -->
        <header>
            <div class="navbar">
                <button type="button" class="sidebar-toggler d-md-none" onclick="return toggleSidebar();">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="#" class="navbar-brand">Services selection</a>
                <a href="#" class="navbar-brand" style="font-weight: bold; text-decoration: none; margin-left: 20%;">
    Commandez votre main-d'œuvre en toute simplicité sur ÜRI Canada
</a>

            </div>
            <div></div>
        </header>

        <!-- Liste de tous les services -->
        <section class="main-section">
            <aside>
                <div class="p-2 p-md-3">
                    <div class="search-bar mb-2 mb-md-3">
                        <input type="search" class="form-control" placeholder="Rechercher un service...">
                    </div>
                    <nav>
                        <a href="#all" class="category-item" data-category-item="all" onclick="return filterServices('all');">Tous</a>
                        <?php foreach($categories as $category): ?>
                            <a href="#<?= $category ?>" class="category-item" data-category-item="<?= $category ?>" onclick="return filterServices('<?= $category ?>');"><?= $category ?></a>
                        <?php endforeach ?>
                    </nav>
                </div>
            </aside>
            <div class="container-fluid">
                <div class="row p-2 p-md-3">
                    <?php foreach($services as $service): ?>
                        <div class="col-sm-6 col-lg-4 mb-2 mb-md-3 service-card-wr" data-id="<?= $service['id'] ?>" data-category="<?= $service['category'] ?>">
                            <div class="service-card">
                                <div class="img-wr">
                                    <img src="assets/img/btp.jpeg" alt="<?= $service['title'] ?>">
                                </div>
                                <div class="details">
                                    <h4 class="title"><?= $service['title'] ?></h4>
                                    <div class="category">
                                        <i class="fa fa-tag"></i>
                                        <small><?= $service['category'] ?></small>
                                    </div>
                                </div>
                                <div class="input-wr">
                                    <button type="button" class="btn-minus" onclick="return increaseServices(this, -1, <?= $service['id'] ?>);">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="text" value="1">
                                    <button type="button" class="btn-plus" onclick="return increaseServices(this, 1, <?= $service['id'] ?>);">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <button type="button" class="btn-select" onclick="return selectService(this, <?= $service['id'] ?>, '<?= $service['title'] ?>');">
                                    <i class="fa fa-check"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </main>

    <button type="button" id="cta-order" onclick="return toggleOffcanvas();">
        <i class="fa fa-shopping-cart"></i>
        <small></small>
    </button>

    <div class="offcanvas">
        <div class="inner p-2 p-md-3">
            <h3>Services séléctionnés</h3>
            <hr>
            <ul class="selected-services"></ul>
            <button type="button" class="btn btn-primary btn-order" data-toggle="modal" data-target="#commanderModal">Commander</button>
        </div>
    </div>

    <div class="modal fade" id="commanderModal" tabindex="-1" role="dialog" aria-labelledby="commanderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Services sélectionnés :</h5>
                    <ul id="selectedServicesList"></ul>







                <form id="orderForm" method="POST" action="">
                     <input type="hidden" id="selected-services-data" name="selected_services">
                    <div class="form-group">
                        <label for="nom">Nom de l'entreprise</label>
                        <input type="text" id="nom" name="nom" class="form-control" required="required">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact">Nom & Prénom du responsable</label>
                        <input type="text" id="contact" name="contact" class="form-control" required="required">
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
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required="required">
                    </div>


                    <div class="form-group">
                        <label for="date_debut">Date prévue du début de l’emploi et la durée (en mois)</label>
                        <input type="date" id="date_debut" name="date_debut" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="duree_emploi">Durée de l’emploi demandée</label>
                        <input type="text" id="duree_emploi" name="duree_emploi" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="heures_travail">Combien d’heure de travail par jour et combien de jour par semaine</label>
                        <input type="text" id="heures_travail" name="heures_travail" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="salaire">Quel est le salaire de base par heure ($)</label>
                        <input type="number" step="0.01" id="salaire" name="salaire" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>Exigences linguistiques :</label>
                        <div class="form-check">
                            <input type="radio" id="francais" name="exigences_linguistiques" value="francais" class="form-check-input">
                            <label class="form-check-label" for="francais">Français</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="anglais" name="exigences_linguistiques" value="anglais" class="form-check-input">
                            <label class="form-check-label" for="anglais">Anglais</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="francais_anglais" name="exigences_linguistiques" value="francais_anglais" class="form-check-input">
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
                            <input type="radio" id="aucune_etude" name="exigences_scolarite" value="aucune_etude" class="form-check-input">
                            <label class="form-check-label" for="aucune_etude">Aucune étude</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="etudes_secondaire" name="exigences_scolarite" value="etudes_secondaire" class="form-check-input">
                            <label class="form-check-label" for="etudes_secondaire">Études secondaire</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="diplome_collegial" name="exigences_scolarite" value="diplome_collegial" class="form-check-input">
                            <label class="form-check-label" for="diplome_collegial">Diplôme collégial</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="securite">Il y a-t-il des inquiétudes concernant la sécurité ou les dangers associés à l’activité commerciale ou au lieu de travail? Si oui, décrivez en détails</label>
                        <textarea id="securite" name="securite" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Est-ce que vous fournissez :</label>
                        <div class="form-check">
                            <input type="checkbox" id="logement" name="logement"  class="form-check-input">
                            <label class="form-check-label" for="logement">Un logement convenable et abordable au travailleur</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="billet_avion" name="billet_avion" class="form-check-input">
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
                            <textarea id="explications" name="explications" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="assistance">Si non, comment allez-vous l’assister?</label>
                            <textarea id="assistance" name="assistance" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Avez-vous des employés étrangers déjà en place?</label>
                        <div class="form-check">
                            <input type="radio" id="etrangers_oui" name="employes_etrangers" value="oui" class="form-check-input">
                            <label class="form-check-label" for="etrangers_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="etrangers_non" name="employes_etrangers" value="non" class="form-check-input">
                            <label class="form-check-label" for="etrangers_non">Non</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_etrangers">Si oui, quel est le nombre total d’employés étrangers embauchés à l’aide d’une EIMT qui travaillent actuellement pour vous?</label>
                        <input type="number" id="nombre_etrangers" name="nombre_etrangers" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="eimt_numero">Numéro du EIMT :</label>
                        <input type="text" id="eimt_numero" name="eimt_numero" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Est-ce la première fois que vous prévoyez embaucher à l’étranger?</label>
                        <div class="form-check">
                            <input type="radio" id="premiere_oui" name="premiere_fois" value="oui" class="form-check-input">
                            <label class="form-check-label" for="premiere_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="premiere_non" name="premiere_fois" value="non" class="form-check-input">
                            <label class="form-check-label" for="premiere_non">Non</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Combien de personnes?</label>
                        <div class="form-check">
                            <input type="radio" id="moins_50" name="nombre_personnes" value="moins_50" class="form-check-input">
                            <label class="form-check-label" for="moins_50">Moins de 50</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="plus_50" name="nombre_personnes" value="plus_50" class="form-check-input">
                            <label class="form-check-label" for="plus_50">Plus de 50</label>
                        </div>
                    </div>

                        <div class="form-check">
                            <input type="checkbox" id="logement" name="logement" class="form-check-input" required="required">
                            <label class="form-check-label" for="logement">J'acèpte les tèrmes du contrat</label>
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
        function filterServices(category = null){
            if(!category) category = decodeURIComponent(window.location.hash.replace('#', ''));
            if(!category) category = 'all';
            const cards = document.querySelectorAll('.service-card-wr');
            if(cards.length){
                cards.forEach((card) => {
                    if(category == 'all' && !card.classList.contains('active')){
                        card.classList.add('active');
                        return;
                    }
                    const tmp = card.dataset.category;
                    if(tmp != category && card.classList.contains('active')){
                        card.classList.remove('active');
                    }else if(tmp == category && !card.classList.contains('active')){
                        card.classList.add('active');
                    }
                });
            }
            const as = document.querySelectorAll(`.category-item`);
            if(as){
                as.forEach((a) => {
                    const tmp = a.dataset.categoryItem;
                    if(tmp != category && a.classList.contains('active')){
                        a.classList.remove('active');
                    }else if(tmp == category && !a.classList.contains('active')){
                        a.classList.add('active');
                    }
                });
            }
        }
        function toggleSidebar(){
            const sidebar = document.querySelector('aside');
            if(sidebar){
                sidebar.classList.toggle('active');
            }
        }
        function getSavedSelectedServices(){
            const json = localStorage.getItem('saved-services');
            return json ? JSON.parse(json) : {};
        }
        function saveSelectedServices(obj){
            localStorage.setItem('saved-services', JSON.stringify(obj));
        }
        function refreshSelectedServices(){
            const selectedServices = getSavedSelectedServices();
            const cards = document.querySelectorAll('.service-card-wr');
            const offcanvasUl = document.querySelector('.offcanvas ul.selected-services');
            if(offcanvasUl) offcanvasUl.innerHTML = '';
            if(cards.length){
                cards.forEach((card) => card.classList.remove('selected'));
            }
            Object.entries(selectedServices).map(([id, {title, quantity}]) => {
                if(quantity > 0){
                    const card = document.querySelector(`.service-card-wr[data-id="${id}"]`);
                    if(card){
                        if(!card.classList.contains('selected')) card.classList.add('selected');

                        const input = card.querySelector('.input-wr input');
                        if(input) input.value = quantity;
                    }

                    if(offcanvasUl){
                        const li = document.createElement('li');
                        li.innerHTML = `<span>${title} <strong><small>(${quantity})</small></strong></span>`;
                        offcanvasUl.appendChild(li);
                    }
                }
            });

            let count = 0;
            Object.values(selectedServices).forEach(({quantity}) => count += quantity);
            const ctaOrderSmall = document.querySelector('#cta-order small');
            if(ctaOrderSmall){
                ctaOrderSmall.textContent = count;
                if(count > 0){
                    ctaOrderSmall.classList.add('active');
                }else{
                    ctaOrderSmall.classList.remove('active');
                }
            }

            const selectedServicesInput = document.getElementById('selected_services');
            if(selectedServicesInput){
                selectedServicesInput.value = JSON.stringify(Object.values(selectedServices));
            }
        }
        function selectService(btn, id, title){
            const selectedServices = getSavedSelectedServices();
            let quantity = 1;
            if(selectedServices[id] && selectedServices[id].quantity){
                quantity = 0;
            }else{
                const input = btn.previousElementSibling.querySelector('input');
                if(input){
                    quantity = Math.abs(parseInt(input.value.trim().replace(' ', '')));
                }
            }
            selectedServices[id] = {id, title, quantity};
            saveSelectedServices(selectedServices);
            refreshSelectedServices();
        }
        function increaseServices(btn, quantity, id){
            const input = quantity < 0 ? btn.nextElementSibling : btn.previousElementSibling;
            if(input){
                let val = parseInt(input.value.trim());
                if((quantity < 0 && val + quantity >= 1) || quantity > 0) val += quantity;
                input.value = val;
                
                const selectedServices = getSavedSelectedServices();
                if(selectedServices[id] && selectedServices[id].quantity && val){
                    selectedServices[id].quantity = val;
                    saveSelectedServices(selectedServices);
                    refreshSelectedServices();
                }
            }
        }
        function toggleOffcanvas(){
            const offcanvas = document.querySelector('.offcanvas');
            if(offcanvas){
                offcanvas.classList.toggle('active');
            }
        }

        (() => {
            filterServices();
            refreshSelectedServices();

            const searchInput = document.querySelector('.search-bar input');
            if(searchInput){
                searchInput.addEventListener('input', function(){
                    const keyword = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.service-card-wr');
                    if(cards.length){
                        cards.forEach((card) => {
                            const title = card.querySelector('.title');
                            const category = card.querySelector('.category');
                            let show = false;
                            if(title){
                                show = title.textContent.toLowerCase().includes(keyword);
                            }
                            if(!show && category){
                                show = category.textContent.toLowerCase().includes(keyword);
                            }
                            if(show && !card.classList.contains('active')) card.classList.add('active');
                            else if(!show && card.classList.contains('active')) card.classList.remove('active');
                        });
                    }
                });
            }

            const offcanvas = document.querySelector('.offcanvas');
            if(offcanvas){
                offcanvas.addEventListener('click', (e) => {
                    if(e.target !== e.currentTarget)return;
                    toggleOffcanvas();
                });
            }
        })();
    </script>
</body>
</html>
