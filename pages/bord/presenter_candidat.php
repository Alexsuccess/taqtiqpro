<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérification du type de requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Fetch Data
        if ($_POST['action'] === 'fetch_data') {
            $filterValue = isset($_POST['filter']) ? "%" . $_POST['filter'] . "%" : '';  // Ajout des wildcards pour la recherche
            $category = isset($_POST['category']) ? $_POST['category'] : 'ALL';

            // Requête pour obtenir les candidats
            $sql = "SELECT * FROM candidats WHERE type_candidat = 'UriCanada'";
            if ($category !== 'ALL') {
                $sql .= " AND categorie = ?";
            }
            if ($filterValue) {
                $sql .= ($category === 'ALL' ? " AND" : " AND") . " prof LIKE ?";
            }

            $stmt = $conn->prepare($sql);

            // Association des paramètres
            if ($category !== 'ALL' && $filterValue) {
                $stmt->bind_param("ss", $category, $filterValue);
            } elseif ($category !== 'ALL') {
                $stmt->bind_param("s", $category);
            } elseif ($filterValue) {
                $stmt->bind_param("s", $filterValue);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data['candidats'][] = $row;
                }
            }

            // Requête pour obtenir les compétences
            $sql2 = "SELECT competence1.Nom, competence1.prenom, competence1.tel, competence1.mail, competence1.agen, competence1.agent, competence1.codeutilisateur, competence1.pays, competence1.ville, competence1.id,
                            competence2.skillTitle, competence2.description, competence2.tools, competence2.references
                    FROM competence1
                    LEFT JOIN competence2 ON competence1.codeutilisateur = competence2.codeutilisateur";
            if ($category !== 'ALL') {
                $sql2 .= " WHERE competence1.categorie = ?";
            }
            $sql2 .= " GROUP BY competence1.id, competence2.skillTitle";

            $stmt2 = $conn->prepare($sql2);
            if ($category !== 'ALL') {
                $stmt2->bind_param("s", $category);
            }

            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $data['competences'][] = $row2;
                }
            }

            // Retourner les données au format JSON
            echo json_encode($data);
            exit();
        }

        // Fetch Categories
        elseif ($_POST['action'] === 'fetch_categories') {
            $categories = array();

            // Requête pour obtenir les catégories des candidats
            $sql = "SELECT DISTINCT categorie FROM candidats WHERE type_candidat = 'UriCanada'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row['categorie'];
                }
            }

            // Requête pour obtenir les catégories des compétences
            $sql2 = "SELECT DISTINCT categorie FROM competence1";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    if (!in_array($row2['categorie'], $categories)) {
                        $categories[] = $row2['categorie'];
                    }
                }
            }

            // Retourner les catégories au format JSON
            echo json_encode(['categories' => $categories]);
            exit();
        }

        // Place Order
        elseif ($_POST['action'] === 'place_order') {
            $selectedCandidates = isset($_POST['candidates']) ? $_POST['candidates'] : array();
            $selectedCompetences = isset($_POST['competences']) ? $_POST['competences'] : array();

            $nomm = isset($_POST['nomm']) ? $_POST['nomm'] : '';
            $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
            $couriel = isset($_POST['couriel']) ? $_POST['couriel'] : '';
            $villee = isset($_POST['villee']) ? $_POST['villee'] : '';
            $date = isset($_POST['date']) ? $_POST['date'] : '';
            $procedures = isset($_POST['procedures']) ? $_POST['procedures'] : '';
            $exigences = isset($_POST['exigences']) ? $_POST['exigences'] : '';

            if (empty($selectedCandidates) && empty($selectedCompetences)) {
                echo json_encode(array('status' => 'error', 'message' => 'Veuillez sélectionner au moins un candidat.'));
                exit();
            }

            $candidates = implode(',', $selectedCandidates);
            $competences = implode(',', $selectedCompetences);

            // Préparation de la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO commandes22 (nomm, telephone, couriel, villee, date, procedures, exigences, candidats, competence_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt === false) {
                echo json_encode(['status' => 'error', 'message' => 'Erreur de préparation de la requête : ' . $conn->error]);
                exit();
            }

            // Lier les paramètres
            $stmt->bind_param("sssssssss", $nomm, $telephone, $couriel, $villee, $date, $procedures, $exigences, $candidates, $competences);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Votre réservation a été enregistrée avec succès. Veuillez noter que la réservation des candidats ne garantit pas qu\'ils soient promis à votre entreprise. Elle sera confirmée que lorsque les contrats sont signés et procédures entièrement réglées conformément aux critères de notre plateforme Üri Canada. Sachez que l\'arrivée des employés est en fonction de la durée des procédures et du gouvernementales ainsi que le pays de provenance.'
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la commande : ' . $stmt->error]);
            }

            $stmt->close();
            exit();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation des Candidats</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    body {
        background-image: url('font.jpeg');
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
    }
    
    
    
/* Style de base pour le menu */
#categoryMenu {
    list-style: none;
    border-right: 1px solid #ddd;
    margin: 0;
    padding: 0;
    position: fixed;
    margin-top: 30px;
    max-height: 100vh; /* Hauteur maximale pour le défilement */
    overflow-y: auto; /* Activation du défilement vertical */
}

#categoryMenu li {
    cursor: pointer;
    padding: 10px 15px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease, color 0.3s ease;
    color: #1a5276;
}

#categoryMenu li:hover {
    background-color: #e9ecef;
}

#categoryMenu li.active {
    background-color: #fff;
    color: #555555;
}

/* Style pour le bouton du menu */
#menuButton {
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    color: #1a5276;
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1000;
}

/* Style pour le conteneur du menu */
#menuContainer {
    position: relative;
}

/* Style pour l'affichage du menu */
#categoryMenuWrapper {
    display: none;
    position: fixed;
    top: 0;
    right: 0;
    width: 250px;
    height: 100%;
    background-color: #d0ece7;
    border-left: 1px solid #ddd;
    z-index: 999;
    overflow-y: auto; /* Activation du défilement vertical dans le conteneur */
}

#categoryMenuWrapper.active {
    display: block;
}

#closeMenu {
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    color: #1a5276;
    position: absolute;
    top: 10px;
    right: 10px;
}

/* Media queries pour rendre le menu responsive */
@media (min-width: 3009px) {
    #menuButton {
        display: none;
    }

    #categoryMenuWrapper {
        display: block;
        position: static;
        width: auto;
        height: auto;
        border-left: none;
        background-color: transparent;
    }

    #closeMenu {
        display: none;
    }
}

    
    .btn-selected {
        background-color: #28a745; /* Couleur pour la sélection */
        color: white;
        border: 1px solid #28a745; /* Bordure pour correspondre à la couleur */
        padding: 8px 12px;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .btn-selected:hover {
        background-color: #218838; /* Couleur de survol pour la sélection */
    }
    
    .btn-deselected {
        background-color: #dc3545; /* Couleur pour la désélection */
        color: white;
        border: 1px solid #dc3545; /* Bordure pour correspondre à la couleur */
        padding: 8px 12px;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .btn-deselected:hover {
        background-color: #c82333; /* Couleur de survol pour la désélection */
    }
    
    .btn-group {
        margin-top: 10px;
    }
    
    .btn-group button {
        margin-right: 5px;
    }
    
    .btn-group .btn {
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .btn-group .btn:hover {
        opacity: 0.9;
    }
    
    .modal-content {
        border-radius: 8px;
    }
    
    .modal-header {
        border-bottom: 1px solid #ddd;
        background-color: #f8f9fa;
    }
    
    .modal-footer {
        border-top: 1px solid #ddd;
    }
    
    .modal-footer .btn {
        border-radius: 4px;
        padding: 10px 15px;
    }
    
    .alert {
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }


    .selected-items-container {
        margin-bottom: 20px;
    }

    .selected-item {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        width: 20%;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .selected-item button {
        margin-left: 10px;
    }
    .card {
    position: relative;
    background-color: #fff;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Ensure content is clipped within the card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px); /* Lift the card slightly on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}

.card-image {
    margin-top: 16px; /* Adjusted to make space for the image */
    width: 120px; /* Adjusted for better responsiveness */
    height: 120px; /* Adjusted for better responsiveness */
    border-radius: 50%;
    overflow: hidden;
    position: relative; /* Changed from absolute for better flexibility */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card-image img {
    width: 100%;
    height: auto; /* Ensure aspect ratio is maintained */
    object-fit: cover; /* Ensure image covers the container */
    transition: transform 0.3s ease;
}

.card-image:hover img {
    transform: scale(1.1); /* Slight zoom effect on hover */
}

.card-body {
    padding: 1.5rem;
}

.image-text-container {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.card-image {
    margin-right: 1rem; /* Add space between the image and text */
}

.card-image img {
    max-width: 100%;
    height: auto;
    border-radius: 0.25rem; /* Optional: adds rounded corners to the image */
}

.card-text {
    margin: 0; /* Remove default margin */
    font-size: 1.25rem; /* Adjust as needed */
}


@media (max-width: 768px) {
    .card {
        width: 100%;
    }
    .card-image {
        width: 100px; /* Adjusted size for smaller screens */
        height: 100px; /* Adjusted size for smaller screens */
    }
}

    .icon,.worker{  
        width: 28px;
        height: 23px;
        padding: 2px;
        color:#0062FF;
    }
    .reference{
        color:#0062FF;
    }
    *{
        color: #555555;
    }
    .work{;
        padding:5px;
        color:#cacfd2 ;
    }
    /* Conteneur principal avec espacement et alignement */
.justify-content-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

/* Styles pour l'étiquette de recherche */
label[for="filterSelect"] {
    color: #AAAAAA;
    font-weight: bold;
    margin-right: 1rem;
}

/* Styles pour l'input de recherche */
#filterSelect {
    width: 100%;
    max-width: 350px;
    padding: 0.5rem;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

/* Conteneur pour les boutons */
.d-flex {
    display: flex;
    align-items: center;
}

/* Styles pour les boutons */
.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border: 1px solid transparent;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn i {
    margin-right: 0.5rem;
}

/* Styles pour le bouton Réserver */
.btn[data-toggle="modal"] {
    background-color: #ffffff;
    color: #1a5276;
    border-color: #85c1e9;
}

.btn[data-toggle="modal"]:hover {
    background-color: #f0f0f0;
}

/* Styles pour le bouton Commander */
#placeOrderBtn {
    background-color: #2980b9;
    color: white;
    border-color: #2980b9;
}

#placeOrderBtn:hover {
    background-color: #1f5b8a;
}

/* Media queries pour rendre le design responsive */
@media (max-width: 768px) {
    .justify-content-between {
        flex-direction: column;
        align-items: flex-start;
    }

    #filterSelect {
        max-width: 100%;
        margin-bottom: 1rem;
    }

    .d-flex {
        width: 100%;
        justify-content: space-between;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .btn:last-child {
        margin-bottom: 0;
    }
}

#candidatesContainer {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 16px;
    margin-top: 70px;
    margin: 0 30px;
}

@media (max-width: 1200px) {
    #candidatesContainer {
        grid-template-columns: repeat(3, 1fr); 
    }
}

@media (max-width: 900px) {
    #candidatesContainer {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    #candidatesContainer {
        grid-template-columns: 1fr; 
    }
}

</style>


</head>
<body>
<div class="container-fluid">
    <div class="row">
    <!-- margin-top: 120px; -->
        <div style=" background-color: white ;" class="">
        <div id="menuContainer">
        <button id="menuButton" aria-label="Toggle menu">
            <span class="menu-icon">&#9776;</span> <!-- Menu icon (three horizontal lines) -->
        </button>
        <nav id="categoryMenuWrapper">
            <button style="margin-top: -20px;" id="closeMenu" aria-label="Close menu">&times;</button>
            <ul id="categoryMenu" class="list-group mb-5">
                <!-- Les catégories seront insérées ici par JavaScript -->
            </ul>
        </nav>
    </div>
        </div>
        <div class="col-md-12">
            <h1 class="text-center my-4" style="color: white;">Réservation des Candidats ÜRI Canada</h1>


<div id="selectedCandidatesContainer" class="selected-items-container">
    <h3 style="color: white;">Candidat(s) Sélectionné(s)</h3>
    <div id="selectedCandidatesList"></div>
</div>

<div id="selectedCompetencesContainer" class="selected-items-container">
    <div id="selectedCompetencesList"></div>
</div>

<div class=" justify-content-between d-flex mb-2">
    <div>
        <label for="filterSelect"><strong>Rechercher par Profession :</strong> </label>
        <input type="text" id="filterSelect" style=" width: 350px;" class="form-control" placeholder="Entrez la profession">             
    </div>
    <div class="d-flex">
            <button style="width:150px;height:45px; border-color:#85c1e9; " class="btn" data-toggle="modal" data-target="#orderModal"><i class="fas fa-ticket-alt" style='padding:10px;color:#1a5276 ;'></i>Réserver</button>
            <button style="margin-left:10px; width:150px;height:45px;background-color: #2980b9;color:white;"class="btn" onclick="window.location.href='https://admin.izishope.com/pages/bord/questionnaire.php';" id="placeOrderBtn">
            <i class="fas fa-shopping-cart" style='color:white;margin-right:10px;'></i>Commander</button>
    </div>
</div>


            <div class="card-columns" id="candidatesContainer" style="margin-top: 70px;">
                <!-- Les candidats seront insérés ici par JavaScript -->
            </div>

            <div class="card-columns" id="competencesContainer">
                <!-- Les compétences seront insérées ici par JavaScript -->
            </div>

            
        </div>




    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#d0ece7;">
                <h5 class="modal-title" id="orderModalLabel">Détails de la Commande</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="orderForm">
                    <div class="form-group">
                        <label for="nomm">Nom de l'entreprise :</label>
                        <input type="text" class="form-control" id="nomm" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone :</label>
                        <input type="text" class="form-control" id="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="couriel">Couriel :</label>
                        <input type="email" class="form-control" id="couriel" required>
                    </div>
                    <div class="form-group">
                        <label for="villee">Ville :</label>
                        <input type="text" class="form-control" id="villee" required>
                    </div>
                    <div class="form-group">
                        <label for="orderDate">Date d'embauche:</label>
                        <input type="date" class="form-control" id="orderDate" required>
                    </div>

                    <div class="form-group">
                        <label for="procedures">Voulez vous commencer votre procedure  dès maintenant ?</label>
                        <select class="form-control" id="procedures" required>
                       <option>OUI</option>
                       <option>NON</option>
                    </select>
                    </div>

                    <div class="form-group">
                        <label for="orderExigences">Exigences :</label>
                        <textarea class="form-control" id="orderExigences" required></textarea>
                    </div>


        <input type="checkbox" id="terms" name="terms" required="required">
        J'accepte les <a href="contracts.html" target="_blank">termes du contrat</a>
   <br>

                </form>
            </div>

 



            <div class="modal-footer">
                <button type="button" style="border-color:#cc99ff;" class="btn" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn" style="background-color:#cc99ff;color:white;" id="submitOrderBtn">Réserver</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    //stocker les icon
   $images = [
    "./images/travail.png",
    "./images/blogger.png",
    "./images/entretien.png",
    "./images/dns.png",
    "./images/linternet.png",
    "./images/nuage.png",
    "./images/stockage-en-ligne.png",
    "./images/voyage.png",
    "./images/le-restaurant.png",
    "./images/nomade-numerique.png",
];

// Chargement des catégories lors du chargement de la page
$.ajax({
    url: '',
    type: 'POST',
    data: { action: 'fetch_categories' },
    dataType: 'json',
    success: function(response) {
        var categories = response.categories;
        var categoryMenu = $('#categoryMenu');
        
        // Ajouter l'élément ALL
        categoryMenu.append('<li class=" " data-category="ALL"><i class="fas fa-briefcase worker"></i>ALL</li>');
        
        $.each(categories, function(index, category) {
            // Créer un élément img avec le chemin absolu de l'image
            var imgSrc = $images[index] || './images/voyage.png';
            
            categoryMenu.append('<li class="" data-category="' + category + '">' +
                '<img src="' + imgSrc + '" class="icon" alt="Category icon">' +
                category + '</li>');
        });
    },
    error: function(xhr, status, error) {
        console.error("Erreur AJAX:", error);
    }
});



    // Chargement des données lors du chargement de la page
    loadData('');

    // Filtrage des candidats par profession
    $('#filterSelect').on('input', function() {
        var filterValue = $(this).val();
        loadData(filterValue);
    });

    // Changement de catégorie
    $(document).on('click', '#categoryMenu li', function() {
        $('#categoryMenu li').removeClass('active');
        $(this).addClass('active');
        var selectedCategory = $(this).data('category');
        var filterValue = $('#filterSelect').val();
        loadData(filterValue, selectedCategory);
    });

    // Fonction pour charger les données
    function loadData(filterValue, category = 'ALL') {
        $.ajax({
            url: '',
            type: 'POST',
            data: { action: 'fetch_data', filter: filterValue, category: category },
            dataType: 'json',
            success: function(response) {
                var candidates = response.candidats;
                var competences = response.competences;

                var candidatesContainer = $('#candidatesContainer');
                var competencesContainer = $('#competencesContainer');
                candidatesContainer.empty();
                competencesContainer.empty();


                $images = [
                    "./images/profil/profile2.jpg",
                    "./images/profil/profile3.jpg",
                    "./images/profil/profile1.jpg",
                ];
$.each(candidates, function(index, candidat) {
    var imgSrc = $images[index] || './images/profile2.jpg';

    var card = '<div class="card mb-5">' +
        '<div class="card-body">' +
            '<div class="d-flex align-items-center mb-3">' + // Container for image and text
                '<div class="card-image me-3">' + // Adding margin to the right
                    '<img src="profile2.png" alt="" class="img-fluid">' + // Ensure image is responsive
                '</div>' +

                '<h5 class="card-text mb-0">' + // Remove margin-bottom
                    candidat.prof +
                '</h5>' +
            '</div>' +
            '<div class="d-flex justify-content-between">' +
                '<h6 class="card-title" style="color:#1a5276 ;">' + candidat.prenom + '</h6>' +
                '<h6 class="card-title reference">Cand2024' + candidat.id + '</h6>' +
            '</div>' +
            '<p class="card-text"><i class="fas fa-graduation-cap work"></i>Diplomé(e) : Oui</p>' +
            '<p class="card-text"><i class="fas fa-star work"></i>Spécialité : ' + candidat.special + '</p>' +
            '<p class="card-text"><i class="fas fa-user-clock work"></i>Expérience : ' + candidat.exp + '</p>' +
            '<p class="card-text"><i class="fas fa-language work"></i>Langues - Parlé : ' + candidat.parle + ', Écrit : ' + candidat.ecrit + '</p>' +
            '<p class="card-text"><i class="fas fa-id-card work"></i>Permis de conduire : ' + candidat.permis + '</p>' +
            '<div class="d-flex justify-content-end">' +
                '<button class="btn select-candidate" style="background-color:#2980b9;color:white;" data-id="' + candidat.id + '">Sélectionner</button>' +
                // Bouton Télécharger PDF
                '<button class="btn download-pdf" data-id="' + candidat.code + '" onclick="voirPlus2(\'' + candidat.code + '\')" style="background-color:green; color:white;">Détails</button>' +
            '</div>' +
        '</div>' +
    '</div>';

    candidatesContainer.append(card);
});


                $.each(competences, function(index, competence) {
                    
                    var card = '<div class="card">' +
                        '<div class="card-body">' +
                        ' <div class="card-image">'+
                            '<img src="' + imgSrc + '" alt="" class="padding:15px;">'+
                        '</div>'+
                  '  <div class="d-flex justify-content-between">'
                        '<p class="card-text">Prénom : ' + competence.skillTitle + '</p>' +
                        '<h5 class="card-title reference">Cand2024' + competence.id + '</h5>' +
                   ' </div>'
                        '<p class="card-text"style="color:#1a5276 ;">Profession : ' + competence.prenom + '</p>' +
                        '<p class="card-text"><i class="fas fa-graduation-cap work"></i>Diplomé(e) : Oui</p>' +
                        '<p class="card-text"><i class="fas fa-language work"></i>Langues - Parlé : ' + competence.parle + ', Écrit : ' + competence.ecrit + '</p>' +
                        '<p class="card-text"><i class="fas fa-id-card work"></i>Permis de conduire : ' + competence.permi + '</p>' +
                        '<button class="btn btn-primary select-competence" style="background-color:#2980b9;color:white;" data-id="' + competence.id + '">Sélectionner</button>' +

                    '<button class="btn download-pdf" data-id="' + competence.codeutilisateur + '" onclick="voirPlus20(\'' + competence.codeutilisateur + '\')" style="background-color:green; color:white;">Détails</button>' +
                        '</div>' +
                        '</div>';
                    competencesContainer.append(card);
                });
            }
        });
    }
    

    // Sélectionner/Désélectionner les candidats
    $(document).on('click', '.select-candidate', function() {
        var candidateId = $(this).data('id');
        var selectedCandidates = $('#selectedCandidatesList');
        var exists = selectedCandidates.find('div[data-id="' + candidateId + '"]').length > 0;

        if (exists) {
            selectedCandidates.find('div[data-id="' + candidateId + '"]').remove();
        } else {
            selectedCandidates.append('<div data-id="' + candidateId + '" class="selected-item">' +
                '<span>Candidat Cand2024' + candidateId + '</span>' +
                '<button class="btn btn-danger btn-sm remove-item" data-id="' + candidateId + '">Supprimer</button>' +
                '</div>');
        }
    });

    // Sélectionner/Désélectionner les compétences
    $(document).on('click', '.select-competence', function() {
        var competenceId = $(this).data('id');
        var selectedCompetences = $('#selectedCompetencesList');
        var exists = selectedCompetences.find('div[data-id="' + competenceId + '"]').length > 0;

        if (exists) {
            selectedCompetences.find('div[data-id="' + competenceId + '"]').remove();
        } else {
            selectedCompetences.append('<div data-id="' + competenceId + '" class="selected-item">' +
                '<span>Compétence ' + competenceId + '</span>' +
                '<button class="btn btn-danger btn-sm remove-item" data-id="' + competenceId + '">Supprimer</button>' +
                '</div>');
        }
    });

    // Supprimer les éléments sélectionnés
    $(document).on('click', '.remove-item', function() {
        $(this).parent().remove();
    });

    // Passer la commande
    $('#submitOrderBtn').click(function() {
        var selectedCandidates = $('#selectedCandidatesList .selected-item').map(function() {
            return $(this).data('id');
        }).get();
        var selectedCompetences = $('#selectedCompetencesList .selected-item').map(function() {
            return $(this).data('id');
        }).get();

        var nomm = $('#nomm').val();
        var telephone = $('#telephone').val();
        var couriel = $('#couriel').val();
        var villee = $('#villee').val();
        var date = $('#orderDate').val();
        var procedures = $('#procedures').val();
        var exigences = $('#orderExigences').val();

        if (selectedCandidates.length === 0 && selectedCompetences.length === 0) {
            alert('Veuillez sélectionner au moins un candidat ou une compétence.');
            return;
        }

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'place_order',
                candidates: selectedCandidates,
                competences: selectedCompetences,
                nomm: nomm,
                telephone: telephone,
                couriel: couriel,
                villee: villee,
                date: date,
                procedures: procedures,
                exigences: exigences
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#orderModal').modal('hide');
                    $('#orderForm')[0].reset();
                    $('#selectedCandidatesList').empty();
                    $('#selectedCompetencesList').empty();
                } else {
                    alert(response.message);
                }
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menuButton');
    const closeMenuButton = document.getElementById('closeMenu');
    const menuWrapper = document.getElementById('categoryMenuWrapper');

    menuButton.addEventListener('click', function() {
        menuWrapper.classList.add('active');
    });

    closeMenuButton.addEventListener('click', function() {
        menuWrapper.classList.remove('active');
    });
});

    window.voirPlus2 = function(code) {
        var url = 'voir_voir_plus2.php?code=' + encodeURIComponent(code);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };

    window.voirPlus20 = function(codeutilisateur) {
        var url = 'voir_voir_plus20.php?codeutilisateur=' + encodeURIComponent(codeutilisateur);
        var newWindow = window.open(url, '_blank', 'width=800,height=600');
        newWindow.focus();
    };
</script>

</body>
</html>
