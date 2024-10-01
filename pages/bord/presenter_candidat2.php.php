<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement des requêtes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'fetch_data') {
        $filterValue = isset($_POST['filter']) ? $_POST['filter'] : '';
        $category = isset($_POST['category']) ? $_POST['category'] : 'ALL';

        // Requête pour obtenir les candidats
        $sql = "SELECT * FROM candidats";
        if ($category !== 'ALL') {
            $sql .= " WHERE categorie = '$category'";
        }
        if ($filterValue) {
            $sql .= ($category === 'ALL' ? " WHERE" : " AND") . " prof LIKE '%$filterValue%'";
        }
        $result = $conn->query($sql);

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
            $sql2 .= " WHERE competence1.categorie = '$category'";
        }
        $sql2 .= " GROUP BY competence1.id, competence2.skillTitle";
        $result2 = $conn->query($sql2);

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

        $sql = "SELECT DISTINCT categorie FROM candidats";
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
        $exigences = isset($_POST['exigences']) ? $_POST['exigences'] : '';

        if (empty($selectedCandidates) && empty($selectedCompetences)) {
            echo json_encode(array('status' => 'error', 'message' => 'Veuillez sélectionner au moins un candidat.'));
            exit();
        }

        if (!empty($date) && !empty($exigences)) {
            $allSelectedIds = array_merge($selectedCandidates, $selectedCompetences);
            $candidatesList = implode(',', $allSelectedIds);

            $stmt = $conn->prepare("INSERT INTO commandes22 (nomm, telephone, couriel, villee, date, exigences, candidats, user_idd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $userId = 1; // Remplacez par l'ID utilisateur approprié si nécessaire
            $stmt->bind_param("sssssssi", $nomm, $telephone, $couriel, $villee, $date, $exigences, $candidatesList, $userId);

            if ($stmt->execute()) {
                echo json_encode(array('status' => 'success', 'message' => 'Réservation passée avec succès.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Erreur lors de la passation de la commande. ' . $stmt->error));
            }
            $stmt->close();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Veuillez remplir tous les champs.'));
        }
        exit();
    }
}
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
            background-image: url(17.jpg);
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
            column-count: 3;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-body input[type="checkbox"] {
            margin-right: 10px;
        }
        #categoryMenu {
            list-style: none;
            padding: 0;
        }
        #categoryMenu li {
            cursor: pointer;
            padding: 5px 10px;
            margin: 5px 0;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        #categoryMenu li.active {
            background-color: #007bff;
            color: white;
        }
        .btn-selected {
            background-color: green;
            color: white;
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
            <h1 class="text-center my-4" style="color: white;">Réservation des Candidats</h1>

            <div class="filter-container mb-4">
                <label for="filterSelect" style="color: white;"><strong>Rechercher par Profession :</strong> </label>
                <input type="text" id="filterSelect" class="form-control" placeholder="Entrez la profession">
            </div>

            <div class="card-columns" id="candidatesContainer">
                <!-- Les candidats seront insérés ici par JavaScript -->
            </div>

            <div class="card-columns" id="competencesContainer">
                <!-- Les compétences seront insérées ici par JavaScript -->
            </div>

            <button id="placeOrderBtn" class="btn btn-primary btn-block" data-toggle="modal" data-target="#orderModal" style="font-size: 40px;">Réserver</button>
        </div>
    </div><br><br><br>
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
                        <label for="orderDate">Date :</label>
                        <input type="date" class="form-control" id="orderDate" required>
                    </div>

                    <div class="form-group">
                        <label for="orderExigences">Exigences :</label>
                        <textarea class="form-control" id="orderExigences" rows="3" required></textarea>
                    </div>
                </form>
                <div id="selectedCandidates">
                    <h5>Candidats Sélectionnés :</h5>
                    <ul id="selectedCandidatesList"></ul>
                </div>
                <div id="selectedCompetences">
                    
                    <ul id="selectedCompetencesList"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="confirmOrderBtn">Confirmer la Réservation</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    fetchCategories();

    // Filtrer les candidats et les compétences
    $('#filterSelect').on('keyup', function() {
        var filterValue = $(this).val();
        fetchData(filterValue);
    });

    // Fetch categories from the server
    function fetchCategories() {
        $.ajax({
            url: '',
            method: 'POST',
            data: { action: 'fetch_categories' },
            dataType: 'json',
            success: function(response) {
                var categories = response.categories;
                var categoryMenu = $('#categoryMenu');
                categoryMenu.empty();

                var allCategoriesItem = $('<li class="list-group-item category-item">Tous</li>');
                allCategoriesItem.on('click', function() {
                    fetchData('', 'ALL');
                });
                categoryMenu.append(allCategoriesItem);

                categories.forEach(function(category) {
                    var categoryItem = $('<li class="list-group-item category-item">' + category + '</li>');
                    categoryItem.on('click', function() {
                        fetchData('', category);
                    });
                    categoryMenu.append(categoryItem);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Fetch data from the server
    function fetchData(filter, category) {
        $.ajax({
            url: '',
            method: 'POST',
            data: { action: 'fetch_data', filter: filter, category: category },
            dataType: 'json',
            success: function(response) {
                var candidates = response.candidats;
                var competences = response.competences;
                var candidatesContainer = $('#candidatesContainer');
                var competencesContainer = $('#competencesContainer');

                candidatesContainer.empty();
                competencesContainer.empty();

                if (candidates) {
                    candidates.forEach(function(candidate) {
                        var candidateCard = $('<div class="card candidate-card"></div>');
                        var cardBody = $('<div class="card-body"></div>');
                        cardBody.append('<h4 style="color : blue;" class="card-title">Cand2024' + candidate.id + '</h4>');
                        cardBody.append('<h5 class="card-title">' + candidate.prof + '</h5>');
                  
                        cardBody.append('<p class="card-text">Prénom : ' + candidate.prenom + '</p>');
                        cardBody.append('<p class="card-text">Pays : ' + candidate.pays + '</p>');

                        cardBody.append('<p class="card-text">Spécialité : ' + candidate.special + '</p>');
                        cardBody.append('<p class="card-text">Expérience : ' + candidate.exp + '</p>');
                        cardBody.append('<p class="card-text">Langues P : ' + candidate.parle + ' E :  ' + candidate.ecrit + '</p>');
                        cardBody.append('<p class="card-text">Permis de conduire : ' + candidate.permi + '</p>');

                        var selectButton = $('<button class="btn btn-primary select-candidate-btn" data-id="' + candidate.id + '">Sélectionner</button>');
                        selectButton.on('click', function() {
                            $(this).toggleClass('btn-selected');
                            selectCandidate(candidate.id, candidate.nom + ' ' + candidate.prenom);
                        });
                        cardBody.append(selectButton);

                        candidateCard.append(cardBody);
                        candidatesContainer.append(candidateCard);
                    });
                } 

                if (competences) {
                    competences.forEach(function(competence) {
                        var competenceCard = $('<div class="card competence-card"></div>');
                        var cardBody = $('<div class="card-body"></div>');
                        cardBody.append('<h4 style="color : blue;" class="card-title">Cand2024' + competence.id + '</h4>');
                        cardBody.append('<h5 class="card-title">' + competence.skillTitle + '</h5>');
                 
                        cardBody.append('<p class="card-text">Prénom : ' + competence.prenom + '</p>');
                        cardBody.append('<p class="card-text">Pays : ' + competence.pays + '</p>');
                        cardBody.append('<p class="card-text">Références : ' + competence.references + '</p>');
                        cardBody.append('<p class="card-text">Langues : P : ' + competence.parle + '  E :  ' + competence.ecrit + '</p>');
                      
                        cardBody.append('<p class="card-text">Permis de conduire : ' + competence.permi + '</p>');

                        var selectButton = $('<button class="btn btn-primary select-competence-btn" data-id="' + competence.id + '">Sélectionner</button>');
                        selectButton.on('click', function() {
                            $(this).toggleClass('btn-selected');
                            selectCompetence(competence.id, competence.skillTitle);
                        });
                        cardBody.append(selectButton);

                        competenceCard.append(cardBody);
                        competencesContainer.append(competenceCard);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Sélectionner un candidat
    function selectCandidate(id, name) {
        var selectedCandidatesList = $('#selectedCandidatesList');
        var candidateItem = $('<li>' + name + ' <button class="btn btn-danger btn-sm remove-candidate-btn" data-id="' + id + '">&times;</button></li>');
        candidateItem.find('.remove-candidate-btn').on('click', function() {
            candidateItem.remove();
            $('.select-candidate-btn[data-id="' + id + '"]').removeClass('btn-selected');
        });
        selectedCandidatesList.append(candidateItem);
    }

    // Sélectionner une compétence
    function selectCompetence(id, title) {
        var selectedCompetencesList = $('#selectedCompetencesList');
        var competenceItem = $('<li>' + title + ' <button class="btn btn-danger btn-sm remove-competence-btn" data-id="' + id + '">&times;</button></li>');
        competenceItem.find('.remove-competence-btn').on('click', function() {
            competenceItem.remove();
            $('.select-competence-btn[data-id="' + id + '"]').removeClass('btn-selected');
        });
        selectedCompetencesList.append(competenceItem);
    }

    // Confirmer la réservation
    $('#confirmOrderBtn').on('click', function() {
        var selectedCandidates = [];
        $('#selectedCandidatesList li').each(function() {
            selectedCandidates.push($(this).find('.remove-candidate-btn').data('id'));
        });

        var selectedCompetences = [];
        $('#selectedCompetencesList li').each(function() {
            selectedCompetences.push($(this).find('.remove-competence-btn').data('id'));
        });

        var orderData = {
            action: 'place_order',
            candidates: selectedCandidates,
            competences: selectedCompetences,
            nomm: $('#nomm').val(),
            telephone: $('#telephone').val(),
            couriel: $('#couriel').val(),
            villee: $('#villee').val(),
            date: $('#orderDate').val(),
            exigences: $('#orderExigences').val()
        };

        $.ajax({
            url: '',
            method: 'POST',
            data: orderData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#orderModal').modal('hide');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Initial fetch to display all data
    fetchData('', 'ALL');
});

</script>
</body>
</html>