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
// Récupérer les données des candidats
$candidats_sql = "SELECT * FROM candidats";
$candidats_result = $conn->query($candidats_sql);

// Récupérer les parcours académiques
$parcours_academique_sql = "SELECT * FROM parcours_academique as rr left join utilisateurs_destinataires2 as dd on rr.user_id = dd.id_destinataire where dd.id_utilisateur = $userId";
$parcours_academique_result = $conn->query($parcours_academique_sql);

// Récupérer les parcours professionnels
$parcours_professionnel_sql = "SELECT * FROM parcours_professionnel";
$parcours_professionnel_result = $conn->query($parcours_professionnel_sql);

// Récupérer les documents
$documents_sql = "SELECT * FROM documents";
$documents_result = $conn->query($documents_sql);

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
</head>
<body><br><br>
    <h1>Données des Candidats</h1><br>

    <h2>Candidats</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Pays</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($candidats_result->num_rows > 0): ?>
                <?php while($row = $candidats_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['prenom']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['sexe']; ?></td>
                        <td><?php echo $row['pays']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun candidat trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Parcours Académique</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Candidat</th>
                <th>Diplôme</th>
                <th>Institution</th>
                <th>Date d'obtention</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($parcours_academique_result->num_rows > 0): ?>
                <?php while($row = $parcours_academique_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['candidat_id']; ?></td>
                        <td><?php echo $row['diplome']; ?></td>
                        <td><?php echo $row['institution']; ?></td>
                        <td><?php echo $row['date_obtention']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun parcours académique trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Parcours Professionnel</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Candidat</th>
                <th>Poste</th>
                <th>Entreprise</th>
                <th>Période</th>
                <th>Pays</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($parcours_professionnel_result->num_rows > 0): ?>
                <?php while($row = $parcours_professionnel_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['candidat_id']; ?></td>
                        <td><?php echo $row['poste']; ?></td>
                        <td><?php echo $row['entreprise']; ?></td>
                        <td><?php echo $row['periode']; ?></td>
                        <td><?php echo $row['pays']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun parcours professionnel trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Documents</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Candidat</th>
                <th>Nom du Fichier</th>
                <th>Date de Modification</th>
                <th>Télécharger le Fichier</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($documents_result->num_rows > 0): ?>
                <?php while($row = $documents_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['candidat_id']; ?></td>
                        <td><?php echo $row['nom_fichier']; ?></td>
                        <td><?php echo $row['date_modification']; ?></td>
                        <td><a href="uploads/documentss/<?php echo htmlspecialchars($row['chemin_fichier']); ?>" download><?php echo htmlspecialchars($row['chemin_fichier']); ?></a></td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun document trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
