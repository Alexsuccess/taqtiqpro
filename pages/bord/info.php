<?php
// Démarrer la session
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

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Nombre d'entrées par page
$limit = 5;

// Page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupération des données
$sql = "SELECT rr.*, dd.nom AS agence_nom, dd.prenom AS agence_prenom, ee.nom AS entreprise_nom, ee.prenom AS entreprise_prenom, 
               xx.full_name, xx.preno, xx.country, xx.city, xx.email, xx.phone, xx.experience, xx.photo, dd.Profession
        FROM utilisateurs_destinataires AS rr
        LEFT JOIN userss AS dd ON dd.id = rr.id_utilisateur
        LEFT JOIN userss AS ee ON ee.id = rr.id_destinataire
        LEFT JOIN formulaire_immigration_session1 AS xx ON xx.codeutilisateur = rr.codeutilisateur
        WHERE xx.codeutilisateur IS NOT NULL";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Informations</title>
    <style type="text/css">




        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }



        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Match Candidat</h1><br><br>
        <table>
            <thead>
                <tr>
                    <th>ID Candidat</th>
                    <th>Agence</th>
                   <th>Profession</th>
                    <th>Nom Complet</th>
                    <th>Prénom</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Expérience</th>
                    <th>Photo</th>
                     <th>Match Candidat</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td>CAND00<?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['Profession'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['agence_nom'] ?? '') . ' ' . htmlspecialchars($row['agence_prenom'] ?? ''); ?></td>
                    
                    <td><?php echo htmlspecialchars($row['full_name'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['preno'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['country'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['city'] ?? ''); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($row['email'] ?? ''); ?>"><?php echo htmlspecialchars($row['email'] ?? ''); ?></a></td>
                    <td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['experience'] ?? ''); ?></td>
                    <td><img style="width: 60px; height: 60px;" src="../../uploads/<?php echo htmlspecialchars($row['photo'] ?? ''); ?>" alt="Photo"></td>
                    <td><?php echo htmlspecialchars($row['entreprise_nom'] ?? '') . ' ' . htmlspecialchars($row['entreprise_prenom'] ?? ''); ?></td>
                    <td>
                        <button class="btn btn-secondary" type="button" onclick="voirPlus('<?php echo htmlspecialchars($row['codeutilisateur'] ?? ''); ?>')">Voir plus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        function voirPlus(codeutilisateur) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'voir_pluss.php?codeutilisateur=' + codeutilisateur;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
    </script>
</body>
</html>
