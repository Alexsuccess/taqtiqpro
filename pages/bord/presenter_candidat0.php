<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'fetch_data') {
            $filterValue = isset($_POST['filter']) ? $_POST['filter'] : '';
            $category = isset($_POST['category']) ? $_POST['category'] : 'ALL';

            // Requête pour obtenir les candidats
            $sql = "SELECT * FROM candidats WHERE type_candidat = 'UriCanada'";
            if ($category !== 'ALL') {
                $sql .= " AND categorie = ?";
            }
            if ($filterValue) {
                $sql .= ($category === 'ALL' ? " WHERE" : " AND") . " prof LIKE ?";
            }

            $stmt = $conn->prepare($sql);

            if ($category !== 'ALL' && $filterValue) {
                $stmt->bind_param("ss", $category, $filterValue);
            } elseif ($category !== 'ALL') {
                $stmt->bind_param("s", $category);
            } elseif ($filterValue) {
                $filterValue = "%$filterValue%";
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
        } elseif ($_POST['action'] === 'fetch_categories') {
            // Requête pour obtenir les catégories distinctes des deux tables
            $categories = array();

            $sql = "SELECT DISTINCT categorie FROM candidats WHERE type_candidat = 'UriCanada'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row['categorie'];
                }
            }

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
        } elseif ($_POST['action'] === 'place_order') {
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

            // Fermer la requête préparée
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
    <style>
    body {
        background-image: url('17.jpg');
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
    }
    
    .container-fluid {
        padding: 0;
    }
    
    .row {
        margin: 0;
    }
    
    .col-md-3 {
        padding: 0;
    }
    
    .filter-container {
        margin-bottom: 20px;
    }
    
    .card-columns {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Espacement entre les cartes */
    }
    
    .card {
        flex: 1 1 calc(25% - 10px); /* Ajuster la largeur pour 4 colonnes avec espace entre */
        max-width: calc(25% - 10px); /* Limiter la largeur maximale */
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
        height: 300px; /* Hauteur fixe pour les cartes */
        overflow: auto; /* Afficher une barre de défilement si le contenu dépasse */
        background-color: #fff;
        position: relative;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
    }
    
    .card h4 {
        margin-top: 0;
    }
    
    .card-body input[type="checkbox"] {
        margin-right: 10px;
    }
    
    #categoryMenu {
        list-style: none;
        padding: 0;
        position: fixed;
        width: 25%;
        background-color: #fff; /* Ajouté pour le contraste */
        border-right: 1px solid #ddd;
    }
    
    #categoryMenu li {
        cursor: pointer;
        padding: 10px 15px;
        margin: 5px 0;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    #categoryMenu li:hover {
        background-color: #e9ecef;
    }
    
    #categoryMenu li.active {
        background-color: #007bff;
        color: white;
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

</style>


</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div style="margin-top: 120px;" class="col-md-3">
            <ul id="categoryMenu" class="list-group">
                <!-- Les catégories seront insérées ici par JavaScript -->
            </ul>
        </div>
        <div class="col-md-9">
            <h1 class="text-center my-4" style="color: white;">Réservation des Candidats ÜRI Canada</h1>


<div id="selectedCandidatesContainer" class="selected-items-container">
    <h3 style="color: white;">Candidat(s) Sélectionné(s)</h3>
    <div id="selectedCandidatesList"></div>
</div>

<div id="selectedCompetencesContainer" class="selected-items-container">
    <div id="selectedCompetencesList"></div>
</div>
<
            <div style="color: white; width: 40%;" class="filter-container mb-2">
                <label for="filterSelect" style="color: white;"><strong>Rechercher par Profession :</strong> </label>
                <input type="text" id="filterSelect" class="form-control" placeholder="Entrez la profession">

            <button style="margin-left: 170%; margin-top: -6%; width: 150px;" id="placeOrderBtn" class="btn btn-primary btn-block" data-toggle="modal" data-target="#orderModal" style="font-size: 20px;">Réserver</button>

<button onclick="window.location.href='https://admin.izishope.com/pages/bord/questionnaire.php';" 
        id="placeOrderBtn" 
        class="btn btn-danger btn-block"  
        style="margin-left: 200%; margin-top: -6%; width: 150px; font-size: 20px;">
    Commander
</button>

            <br>
            </div>

            <div class="card-columns" id="candidatesContainer">
                <!-- Les candidats seront insérés ici par JavaScript -->
            </div>

            <div class="card-columns" id="competencesContainer">
                <!-- Les compétences seront insérées ici par JavaScript -->
            </div>

            
        </div>




    </div>


    <br><br><br>
</div>

<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Détails de la Commande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="submitOrderBtn">Réserver</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Chargement des catégories lors du chargement de la page
    $.ajax({
        url: '',
        type: 'POST',
        data: { action: 'fetch_categories' },
        dataType: 'json',
        success: function(response) {
            var categories = response.categories;
            var categoryMenu = $('#categoryMenu');
            categoryMenu.append('<li class="list-group-item active" data-category="ALL">ALL</li>');
            $.each(categories, function(index, category) {
                categoryMenu.append('<li class="list-group-item" data-category="' + category + '">' + category + '</li>');
            });
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

                $.each(candidates, function(index, candidat) {
                    var card = '<div class="card">' +
                        '<div class="card-body">' +
                        
                        '<h5 class="card-title">' + candidat.prof + '</h5>' +
                        '<h5 class="card-title">Cand2024' + candidat.id + '</h5>' +
                        '<p class="card-text">Prénom : ' + candidat.prenom + '</p>' +
                        '<p class="card-text">Diplomé(e) : Oui</p>' +
                        '<p class="card-text">Profession : ' + candidat.prof + '</p>' +
                        '<p class="card-text">Spécialité : ' + candidat.special + '</p>' +
                        '<p class="card-text">Expérience : ' + candidat.exp + '</p>' +
                        '<p class="card-text">Langues - Parlé : ' + candidat.parle + ', Écrit : ' + candidat.ecrit + '</p>' +
                        '<p class="card-text">Permis de conduire : ' + candidat.permis + '</p>' +
                        '<button class="btn btn-primary select-candidate" data-id="' + candidat.id + '">Sélectionner</button>' +
                        '</div>' +
                        '</div>';
                    candidatesContainer.append(card);
                });

                $.each(competences, function(index, competence) {
                    var card = '<div class="card">' +
                        '<div class="card-body">' +
                        '<p class="card-text">Profession : ' + competence.skillTitle + '</p>' +
                        '<h5 class="card-title">Cand2024' + competence.id + '</h5>' +
                        
                        '<p class="card-text">Prénom : ' + competence.prenom + '</p>' +
                        '<p class="card-text">Diplomé(e) : Oui</p>' +
                        '<p class="card-text">Langues - Parlé : ' + competence.parle + ', Écrit : ' + competence.ecrit + '</p>' +
                        '<p class="card-text">Permis de conduire : ' + competence.permi + '</p>' +
                        '<button class="btn btn-primary select-competence" data-id="' + competence.id + '">Sélectionner</button>' +
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
</script>

</body>
</html>
