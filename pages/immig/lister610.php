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

// Initialiser la variable de recherche
$search = "";

// Vérifier si une recherche est effectuée
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = $conn->real_escape_string($search); // Échapper les caractères spéciaux pour la sécurité
}

// Récupérer les données des candidats avec les documents associés
$candidats_sql = "SELECT c.id, c.nom, c.prenom, c.email, c.sexe, c.pays, c.user_id,
                  GROUP_CONCAT(CONCAT(d.nom_fichier, '::', d.date_modification, '::', d.chemin_fichier, '::', d.candidat_id) SEPARATOR ', ') AS documents
                  FROM candidats c
                  LEFT JOIN documents d ON c.id = d.candidat_id
                  WHERE (c.nom LIKE '%$search%' OR c.prenom LIKE '%$search%' OR c.email LIKE '%$search%' OR c.sexe LIKE '%$search%' OR c.pays LIKE '%$search%')
                  GROUP BY c.id, c.nom, c.prenom, c.email, c.sexe, c.pays";
$candidats_result = $conn->query($candidats_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Données</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 8px;
            width: 80%;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-container button {
            padding: 8px 16px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function imprimerCandidat(candidatId) {
            // Ouvrir une nouvelle fenêtre modale avec les détails du candidat
            var url = 'imprime_candidat1.php?candidat_id=' + candidatId;
            var windowName = 'CandidatDetails';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
    </script>
</head>
<body>
    <h1>Données des Candidats</h1>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Rechercher des candidats..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Pays</th>
                <th>Nom du Document</th>
                <th>Date de Modification</th>
                <th>Chemin du Fichier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($candidats_result->num_rows > 0): ?>
                <?php while($row = $candidats_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['prenom']; ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                        <td><?php echo $row['sexe']; ?></td>
                        <td><?php echo $row['pays']; ?></td>
                        <td>
                            <?php 
                            if ($row['documents']) {
                                $documents = explode(', ', $row['documents']);
                                foreach ($documents as $document) {
                                    list($nom_fichier, $date_modification, $chemin_fichier, $candidat_id) = explode('::', $document);
                                    echo htmlspecialchars($nom_fichier) . '<br>';
                                }
                            } else {
                                echo 'Aucun document';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if ($row['documents']) {
                                $documents = explode(', ', $row['documents']);
                                foreach ($documents as $document) {
                                    list($nom_fichier, $date_modification, $chemin_fichier, $candidat_id) = explode('::', $document);
                                    echo htmlspecialchars($date_modification) . '<br>';
                                }
                            } else {
                                echo 'Aucune date';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if ($row['documents']) {
                                $documents = explode(', ', $row['documents']);
                                foreach ($documents as $document) {
                                    list($nom_fichier, $date_modification, $chemin_fichier, $candidat_id) = explode('::', $document);
                                    echo '<a href="path_to_documents/' . htmlspecialchars($chemin_fichier) . '" target="_blank">' . htmlspecialchars($chemin_fichier) . '</a><br>';
                                }
                            } else {
                                echo 'Aucun chemin';
                            }
                            ?>
                        </td>
                        <td>
                            <button onclick="imprimerCandidat(<?php echo $candidat_id; ?>)">Imprimer</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">Aucun candidat trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
