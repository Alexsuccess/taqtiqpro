<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des réponses</title>
    <link rel="stylesheet" href="styles.css">
<style>
    /* Style pour le modal */
    .modal {
        display: none; /* Caché par défaut */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 110%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5); /* Fond semi-transparent */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 100%;
        max-width: 1000px;
        overflow-y: auto; /* Scroll si le contenu est trop grand */
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

    /* Style pour la table principale et le modal */
    table {
        width: 120%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-left: -10%;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table th {
        background-color: #f2f2f2;
    }

    /* Style spécifique pour le modal */
    #myModal .modal-content {
        max-height: 70vh; /* Limiter la hauteur du modal pour un scroll vertical */
    }

    #myModal table {
        width: 100%;
        margin-left: 1%;
        border-collapse: collapse;
        margin-bottom: 0; /* Supprimer la marge inférieure pour éviter l'espacement entre les tables */
    }

    #myModal th, #myModal td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #myModal th {
        background-color: #f2f2f2;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Affichage des réponses</h1>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Rechercher par ID...">
        <table id="responsesTable">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Question 1</th>
                    <th>Question 2</th>
                    <th>Question 3</th>
                    <!-- Ajoutez ici autant de colonnes que nécessaires -->
                    <th>Question 4</th>
                    <th>Question 5</th>
                    <th>Question 6</th>
                    <th>Question 7</th>

                    <th>Question 8</th>
                    <th>Question 9</th>
                </tr>
            </thead>
            <tbody>
<?php
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

// Requête SQL pour récupérer les données de la table 'responses'
$sql = "SELECT * FROM responses AS ee 
        LEFT JOIN userss AS xx ON xx.help2 = ee.q0 left join utilisateurs_destinataires as ud on ud.id_utilisateur = xx.id
        WHERE ee.q0 IS NOT NULL";

$result = $conn->query($sql);

if (!$result) {
    // Gestion de l'erreur de requête
    die("Erreur dans la requête : " . $conn->error);
}

if ($result->num_rows > 0) {
    // Affichage initial limité à 10 lignes
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['q0'] . "</td>";
        echo "<td>" . $row['q1'] . "</td>";
        echo "<td>" . $row['q2'] . "</td>";
        echo "<td>" . $row['q3'] . "</td>";
        // Ajoutez ici autant de colonnes que nécessaires
        echo "<td>" . $row['q4'] . "</td>";
        echo "<td>" . $row['q5'] . "</td>";
        echo "<td>" . $row['q6'] . "</td>";
        echo "<td>" . $row['q7'] . "</td>";
        echo "<td>" . $row['q8'] . "</td>";
        // Ajoutez ici autant de colonnes que nécessaires
        echo "<td>" . $row['q9'] . "</td>";
        echo "</tr>";
        $count++;
        // Limite initiale à 10 lignes
        if ($count >= 10) {
            break;
        }
    }
} else {
    echo "<tr><td colspan='6'>Aucun résultat trouvé.</td></tr>";
}

$conn->close();
?>

            </tbody>
        </table>
        <!-- Bouton "Voir plus" pour ouvrir le modal -->
        <button onclick="openModal()">Voir plus</button>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Toutes les réponses</h2>
                <table id="fullResponsesTable">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Question 10</th>
                            <th>Question 11</th>
                            <th>Question 12</th>
                            <!-- Ajoutez ici autant de colonnes que nécessaires -->
                            <th>Question 13</th>
                            <th>Question 14</th>

                            <th>Question 15</th>
                            <th>Question 16</th>
                            <th>Question 17</th>
                            <!-- Ajoutez ici autant de colonnes que nécessaires -->
                            <th>Question 18</th>
                            <th>Question 19</th>

                            <th>Question 20</th>
                            <!-- Ajoutez ici autant de colonnes que nécessaires -->
                            <th>Question 21</th>
                            <th>Question 22</th>

                            <th>Question 23</th>
                            <!-- Ajoutez ici autant de colonnes que nécessaires -->
                            <th>Question 24</th>
                            <th>Question 25</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
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
// Requête SQL pour récupérer toutes les données de la table 'responses'
$sqlModal = "SELECT * FROM responses AS ee 
        LEFT JOIN userss AS xx ON xx.help2 = ee.q0 left join utilisateurs_destinataires as ud on ud.id_utilisateur = xx.id
        WHERE ee.q0 IS NOT NULL";
$resultModal = $conn->query($sqlModal);

if ($resultModal->num_rows > 0) {
    while ($rowModal = $resultModal->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowModal['q0'] . "</td>";
        echo "<td>" . $rowModal['q10'] . "</td>";
        echo "<td>" . $rowModal['q11'] . "</td>";
        echo "<td>" . $rowModal['q11_justification'] . "</td>";
        // Ajoutez ici autant de colonnes que nécessaires
        echo "<td>" . $rowModal['q13'] . "</td>";
        echo "<td>" . $rowModal['q14'] . "</td>";

        echo "<td>" . $rowModal['q14_details'] . "</td>";
        echo "<td>" . $rowModal['q15_min'] . "</td>";
        echo "<td>" . $rowModal['q15_max'] . "</td>";
        echo "<td>" . $rowModal['q16'] . "</td>";
        // Ajoutez ici autant de colonnes que nécessaires
        echo "<td>" . $rowModal['q17'] . "</td>";
        echo "<td>" . $rowModal['q18'] . "</td>";

        echo "<td>" . $rowModal['q19'] . "</td>";
        echo "<td>" . $rowModal['q20'] . "</td>";
        // Ajoutez ici autant de colonnes que nécessaires
        echo "<td>" . $rowModal['q21'] . "</td>";
        echo "<td>" . $rowModal['q22'] . "</td>";
       echo "<td>" . $rowModal['q22_details'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Aucun résultat trouvé.</td></tr>";
}

$conn->close();
?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        // Fonction pour ouvrir le modal
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Fonction pour fermer le modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
</body>
</html>
