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

// Récupérer les données des candidats et leurs documents
$candidats_sql = "SELECT rr.id, rr.nom, rr.prenom, rr.email, rr.user_id, rr.sexe, rr.pays, doc.nom_fichier, doc.chemin_fichier
                  FROM candidats rr 
                  LEFT JOIN utilisateurs_destinataires2 dd ON rr.user_id = dd.id_destinataire 
                  LEFT JOIN userss fr ON fr.id = rr.user_id 
                  LEFT JOIN documents doc ON rr.user_id = doc.user_id 
                  WHERE dd.id_utilisateur = ?";
$stmt = $conn->prepare($candidats_sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Organiser les données des candidats et leurs documents
$candidats = [];
while ($row = $result->fetch_assoc()) {
    $candidatId = $row['id'];
    if (!isset($candidats[$candidatId])) {
        $candidats[$candidatId] = [
            'id' => $row['id'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'email' => $row['email'],
            'sexe' => $row['sexe'],
            'pays' => $row['pays'],
            'user_id' => $row['user_id'],
            'documents' => []
        ];
    }
    if ($row['nom_fichier'] && $row['chemin_fichier']) {
        $candidats[$candidatId]['documents'][] = [
            'nom_fichier' => $row['nom_fichier'],
            'chemin_fichier' => $row['chemin_fichier']
        ];
    }
}

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
    </style>
    <script>
        function imprimerCandidat(userId) {
            // Ouvrir une nouvelle fenêtre modale avec les détails du candidat
            var url = 'imprimer_candidatt.php?user_id=' + userId;
            var windowName = 'CandidatDetails';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
    </script>
</head>
<body>
    <h1>Données des Candidats</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Pays</th>
                <th>Documents</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($candidats) > 0): ?>
                <?php foreach ($candidats as $candidat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($candidat['id']); ?></td>
                        <td><?php echo htmlspecialchars($candidat['nom']); ?></td>
                        <td><?php echo htmlspecialchars($candidat['prenom']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($candidat['email']); ?>"><?php echo htmlspecialchars($candidat['email']); ?></a></td>
                        <td><?php echo htmlspecialchars($candidat['sexe']); ?></td>
                        <td><?php echo htmlspecialchars($candidat['pays']); ?></td>
                        <td>
                            <?php if (count($candidat['documents']) > 0): ?>
                                <ul>
                                    <?php foreach ($candidat['documents'] as $document): ?>
                                        <li><a href="uploads/documentss/<?php echo htmlspecialchars($document['chemin_fichier']); ?>" download><?php echo htmlspecialchars($document['nom_fichier']); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                Aucun document
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick="imprimerCandidat(<?php echo $candidat['user_id']; ?>)">Imprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Aucun candidat trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
