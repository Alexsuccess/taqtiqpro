<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

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

// Fonction pour exécuter une requête SQL et récupérer les résultats
function executeSQLQuery($sql, $conn) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur dans la requête SQL: " . $conn->error);
    }
    return $result;
}

// Types de comptes à afficher
$typesComptes = ['client', 'prestataire', 'candidat', 'Entreprise', 'Agent', 'Agence'];

// Requête pour récupérer les destinataires (télévendeurs ou employés)
$sqlDestinataires = "SELECT id, nom, prenom FROM userss WHERE compte IN ('télévendeur', 'Employé', 'Entreprise', 'prestataire' , 'Agent', 'Agence')";
$resultDestinataires = executeSQLQuery($sqlDestinataires, $conn);
$destinataires = [];
if ($resultDestinataires->num_rows > 0) {
    while ($row = $resultDestinataires->fetch_assoc()) {
        $destinataires[] = $row;
    }
}

// Traitement de l'insertion des données sélectionnées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['destinataire']) && isset($_POST['utilisateurs'])) {
        $destinataire = $_POST['destinataire'];
        $utilisateurs = json_decode($_POST['utilisateurs']);

        // Préparation de la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO utilisateurs_destinataires (id_utilisateur, id_destinataire) VALUES (?, ?)");

        // Liaison des paramètres et exécution de la requête pour chaque utilisateur sélectionné
        foreach ($utilisateurs as $userId) {
            $stmt->bind_param("ii", $userId, $destinataire);
            $stmt->execute();
        }

        // Fermeture du statement
        $stmt->close();

        // Réponse à renvoyer en cas de succès
        echo "Insertion réussie !";
    } else {
        // Gérer le cas où les données requises ne sont pas reçues
        echo "Erreur : Données manquantes.";
    }

    // Terminer le script PHP après le traitement POST
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Assignations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .alert {
            color: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            text-align: center;
        }
        .alert-orange {
            background-color: orange;
        }
        .alert-red {
            background-color: red;
        }
        .alert-blue {
            background-color: blue;
        }
        .header, .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>

    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgb(0,0,64);
            color: white;
        }

        .options {
            display: flex;
            align-items: center;
        }

        .options button {
            margin-right: 10px;
            padding: 8px 15px;
            background-color: rgb(0,0,64);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .options button:hover {
            background-color: blue;
        }

        /* Styles pour la modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .user-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .user-item {
            margin-bottom: 5px;
        }
    </style>
    <style>
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>
<body>
    <div class="header text-center">
        <h1>Gestion des Assignations</h1>
        <button style="background-color: red; color: white;" onclick="location.href='../../admin.php'">Retour</button>
    </div>
    <div style="background-color: white;" class="container">
<?php
$conn = new mysqli($servername, $username, $password, $dbname);

foreach ($typesComptes as $index => $typeCompte) {
    $sql = "SELECT dd.id, dd.compte, dd.nom, dd.prenom, dd.email, dd.pays, dd.telephone, dd.statut, 
                   dest.nom AS destinataire_nom, dest.prenom AS destinataire_prenom 
            FROM userss AS dd 
            LEFT JOIN utilisateurs_destinataires AS ud ON dd.id = ud.id_utilisateur 
            LEFT JOIN userss AS dest ON ud.id_destinataire = dest.id 
            WHERE dd.compte = '$typeCompte'";
    $result = executeSQLQuery($sql, $conn);

    echo "<h2>" . ucfirst($typeCompte) . "s</h2>";
    $tableId = "appelsTable_$index";
    echo "<table id='$tableId' class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID candidat</th>";
    echo "<th>Nom</th>";
    echo "<th>Prénom</th>";
    echo "<th>Email</th>";
    echo "<th>Téléphone</th>";
    echo "<th>Pays</th>";
    echo "<th>Ville</th>";
    echo "<th>Profession</th>";
    echo "<th>Confié à</th>";
    echo "<th>Confier à</th>";
    echo "<th>Option</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Sécuriser les valeurs des colonnes avec des valeurs par défaut si elles sont nulles ou non définies
            $nomDestinataire = !empty($row['destinataire_nom']) ? $row['destinataire_nom'] . ' ' . $row['destinataire_prenom'] : 'Non confié';
            $ville = !empty($row['Ville']) ? htmlspecialchars($row['Ville']) : 'Non spécifiée';
            $profession = !empty($row['Profession']) ? htmlspecialchars($row['Profession']) : 'Non spécifiée';

            echo "<tr class='rendez-vous-row'>";
            echo "<td>CAND00" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pays']) . "</td>";
            echo "<td>" . htmlspecialchars($ville) . "</td>";
            echo "<td>" . htmlspecialchars($profession) . "</td>";
            echo "<td>" . htmlspecialchars($nomDestinataire) . "</td>";
            echo "<td class='confier-cell'>";
            echo "<input type='checkbox' class='confier-checkbox' data-user-id='" . $row['id'] . "' name='confier[]'>";
            echo "</td>";
            echo "<td><button class='btn btn-info' data-user-id='" . $row['id'] . "' onclick='voirPlus(" . $row['id'] . ")'>Détails</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>Aucun résultat trouvé.</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

$conn->close();
?>

    </div>

    <!-- Modal pour confier l'utilisateur -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <h2>Assigner à:</h2>
                <form id="confierForm" method="post">
                    <input type="hidden" id="utilisateursSelectionnes" name="utilisateurs">
                    <select id="destinataire" name="destinataire" class="form-control">
                        <option value="">Choisir un destinataire</option>
                        <?php foreach ($destinataires as $destinataire) : ?>
                            <option value="<?php echo htmlspecialchars($destinataire['id']); ?>"><?php echo htmlspecialchars($destinataire['nom']) . ' ' . htmlspecialchars($destinataire['prenom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="user-list">
                        <!-- Liste des utilisateurs sélectionnés -->
                    </div>
                    <button type="submit" id="confirmConfier" class="btn btn-primary mt-2">Confirmer</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialisation de DataTables pour chaque table
            $('table[id^="appelsTable_"]').DataTable();

            // Vérification des dates des rendez-vous
            $('.rendez-vous-row').each(function() {
                var rendezVousDate = $(this).find('.rendez-vous-date').text();
                var now = new Date();
                var rendezVous = new Date(rendezVousDate);
                if (rendezVous < now) {
                    $(this).addClass('past');
                } else if (rendezVous.toDateString() === now.toDateString()) {
                    $(this).addClass('present');
                } else {
                    $(this).addClass('future');
                }
            });

            // Modal pour confier l'utilisateur
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];
            var selectedUsers = [];

            // Ouvrir le modal
            $(".confier-checkbox").change(function() {
                var userId = $(this).data("user-id");
                if ($(this).is(":checked")) {
                    selectedUsers.push(userId);
                } else {
                    selectedUsers = selectedUsers.filter(function(id) {
                        return id !== userId;
                    });
                }
                modal.style.display = "block";
            });

            // Fermeture du modal
            span.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Formulaire de confirmation
            $("#confirmConfier").click(function(event) {
                event.preventDefault();

                if (selectedUsers.length === 0 || $("#destinataire").val() === "") {
                    alert("Veuillez sélectionner des utilisateurs et un destinataire.");
                    return;
                }

                $("#utilisateursSelectionnes").val(JSON.stringify(selectedUsers));
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        destinataire: $("#destinataire").val(),
                        utilisateurs: $("#utilisateursSelectionnes").val()
                    },
                    success: function(response) {
                        alert(response);
                        modal.style.display = "none";
                        location.reload();
                    },
                    error: function() {
                        alert("Une erreur s'est produite.");
                    }
                });
            });

            // Voir plus de détails
            function voirPlus(userId) {
                window.open("details.php?user_id=" + userId, "_blank");
            }

            // Changer le statut de l'utilisateur
            $(".toggle-status").click(function() {
                var userId = $(this).data("user-id");
                var currentStatus = $(this).data("current-status");
                var newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    url: "",
                    method: "POST",
                    data: {
                        user_id: userId,
                        new_status: newStatus
                    },
                    success: function(response) {
                        if (response === "success") {
                            location.reload();
                        } else {
                            alert("Erreur lors de la mise à jour du statut.");
                        }
                    }
                });
            });
        });

                function voirPlus(userId) {
            var url = 'details.php?id=' + userId;
            var newWindow = window.open(url, '_blank', 'width=800,height=600');
            newWindow.focus();
        }
    </script>

</body>
</html>
