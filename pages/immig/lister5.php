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
// Requêtes pour chaque table
$queries = [
    'residence_permanente' => "SELECT * FROM residence_permanente as r left join userss u on r.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId",


    'regroupement_familial' => "SELECT * FROM regroupement_familial as s left join userss u on s.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId",


    'permis_etudes' => "SELECT * FROM permis_etudes as t left join userss u on t.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId",

    'permis_travail' => "SELECT * FROM permis_travail as v left join userss u on v.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId",


    'entree_express' => "SELECT * FROM entree_express as w left join userss u on w.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId",


    'autres_options' => "SELECT * FROM autres_options as x left join userss u on x.user_id = u.id left join utilisateurs_destinataires2 as dd on dd.id_destinataire = u.id where dd.id_utilisateur = $userId"
];

$results = [];

foreach ($queries as $table => $query) {
    $results[$table] = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
    <script>
        function filterTable(tableId, inputId) {
            let input = document.getElementById(inputId);
            let filter = input.value.toLowerCase();
            let table = document.getElementById(tableId);
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                let td = tr[i].getElementsByTagName("td");
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <h2  style="margin-top: 2%;">Résidence Permanente</h2><br>
    <div class="search-bar">
        <input type="text" id="searchResidencePermanente" onkeyup="filterTable('tableResidencePermanente', 'searchResidencePermanente')" placeholder="Rechercher dans Résidence Permanente...">
    </div>
    <table id="tableResidencePermanente">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Profession</th>
            <th>Statut matrimonial</th>
            <th>Nombre d'enfants</th>
            <th>Nationalité</th>
            <th>Langues parlées</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['residence_permanente']->num_rows > 0) {
            while($row = $results['residence_permanente']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["champ1"] . "</td>
                    <td>" . $row["champ2"] . "</td>
                    <td>" . $row["champ3"] . "</td>
                    <td>" . $row["champ4"] . "</td>
                    <td>" . $row["champ5"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>

    <h2>Regroupement Familial</h2><br>
    <div class="search-bar">
        <input type="text" id="searchRegroupementFamilial" onkeyup="filterTable('tableRegroupementFamilial', 'searchRegroupementFamilial')" placeholder="Rechercher dans Regroupement Familial...">
    </div>
    <table id="tableRegroupementFamilial">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Personne Famille</th>
            <th>Ville</th>
            <th>Relation</th>
            <th>Age</th>
            <th>Occupation</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['regroupement_familial']->num_rows > 0) {
            while($row = $results['regroupement_familial']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["personne_famille"] . "</td>
                    <td>" . $row["ville"] . "</td>
                    <td>" . $row["relation"] . "</td>
                    <td>" . $row["age"] . "</td>
                    <td>" . $row["occupation"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>

    <h2>Permis d'Études</h2><br>
    <div class="search-bar">
        <input type="text" id="searchPermisEtudes" onkeyup="filterTable('tablePermisEtudes', 'searchPermisEtudes')" placeholder="Rechercher dans Permis d'Études...">
    </div>
    <table id="tablePermisEtudes">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Établissement</th>
            <th>Autonomie Bancaire</th>
            <th>Programme d'Études</th>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['permis_etudes']->num_rows > 0) {
            while($row = $results['permis_etudes']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["etablissement"] . "</td>
                    <td>" . $row["autonomie_bancaire"] . "</td>
                    <td>" . $row["programme_etudes"] . "</td>
                    <td>" . $row["date_debut"] . "</td>
                    <td>" . $row["date_fin"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>

    <h2>Permis de Travail</h2><br>
    <div class="search-bar">
        <input type="text" id="searchPermisTravail" onkeyup="filterTable('tablePermisTravail', 'searchPermisTravail')" placeholder="Rechercher dans Permis de Travail...">
    </div>
    <table id="tablePermisTravail">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Employeur</th>
            <th>Titre Poste</th>
            <th>Salaire</th>
            <th>Type de Contrat</th>
            <th>Date Début</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['permis_travail']->num_rows > 0) {
            while($row = $results['permis_travail']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["employeur"] . "</td>
                    <td>" . $row["titre_poste"] . "</td>
                    <td>" . $row["salaire"] . "</td>
                    <td>" . $row["type_contrat"] . "</td>
                    <td>" . $row["date_debut"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>

    <h2>Entrée Express</h2><br>
    <div class="search-bar">
        <input type="text" id="searchEntreeExpress" onkeyup="filterTable('tableEntreeExpress', 'searchEntreeExpress')" placeholder="Rechercher dans Entrée Express...">
    </div>
    <table id="tableEntreeExpress">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Points Expérience</th>
            <th>Niveau d'Éducation</th>
            <th>Compétences Linguistiques</th>
            <th>Expérience Travail Canada</th>
            <th>Offre Emploi Valide</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['entree_express']->num_rows > 0) {
            while($row = $results['entree_express']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["points_experience"] . "</td>
                    <td>" . $row["niveau_education"] . "</td>
                    <td>" . $row["competences_linguistiques"] . "</td>
                    <td>" . $row["experience_travail_canada"] . "</td>
                    <td>" . $row["offre_emploi_valide"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>

    <h2>Autres Options</h2><br>
    <div class="search-bar">
        <input type="text" id="searchAutresOptions" onkeyup="filterTable('tableAutresOptions', 'searchAutresOptions')" placeholder="Rechercher dans Autres Options...">
    </div>
    <table id="tableAutresOptions">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Motif</th>
            <th>Message</th>
            <th>Ville</th>
            <th>Email</th>
            <th>Contact</th>
            <th>ID Client</th>
            <th>Date</th>
        </tr>
        <?php
        if ($results['autres_options']->num_rows > 0) {
            while($row = $results['autres_options']->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["prenom"] . "</td>
                    <td>" . $row["champ1"] . "</td>
                    <td>" . $row["champ2"] . "</td>
                    <td>" . $row["champ3"] . "</td>
                    <td>" . $row["champ4"] . "</td>
                    <td>" . $row["champ5"] . "</td>
                    <td>CL00" . $row["user_id"] . "</td>
                    <td>" . $row["datee"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat</td></tr>";
        }
        ?>
    </table>
</body>
</html>
