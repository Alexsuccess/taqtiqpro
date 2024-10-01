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

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête SQL pour sélectionner les données où photot n'est pas null
$sql = "SELECT ds.*, dd.nom, dd.prenom, dd.compte, dd.statut, dd.help2
        FROM formulaire_immigration_session1 AS ds
        LEFT JOIN userss AS dd ON ds.user_id = dd.id
        WHERE ds.codeutilisateur IS NOT NULL";

$result = $conn->query($sql);

// Vérifier si des résultats ont été trouvés
if ($result && $result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulaire Immigration - Sessions</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .audio-player {
                display: flex;
                align-items: center;
            }
            .audio-player audio {
                margin-right: 10px;
            }
            .action-buttons button {
                margin-right: 5px;
            }
        </style>
    </head>
    <body class="container my-5">
        <h2 class="mb-4">Compétences Candidats</h2>
        <?php
        $currentUserId = null;
        while ($row = $result->fetch_assoc()) {
            if ($currentUserId !== $row['user_id']) {
                // Nouvelle table pour un nouveau user_id
                if ($currentUserId !== null) {
                    // Fermer la table précédente si ce n'est pas la première
                    echo '</tbody></table>';
                }
                // Commencer une nouvelle table
                ?>
                <h3>Candidat(s) de : <?php echo $row['nom']; ?> <?php echo $row['prenom']; ?> : <strong style="color: blue;"><?php echo $row['compte']; ?></strong> </h3>
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom Complet</th>
                            <th>Prenom</th>
                            <th>Pays</th>
                            <th>Ville</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Expérience</th>
                            <th>Photo</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $currentUserId = $row['user_id'];
            }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['preno']); ?></td>
                <td><?php echo htmlspecialchars($row['country']); ?></td>
                <td><?php echo htmlspecialchars($row['city']); ?></td>
                <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['experience']); ?></td>
                <td><img style="width: 60px; height: 60px;" src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo"></td>
                <td><?php echo htmlspecialchars($row['help2'] ?? ''); ?></td>
                <td class="action-buttons">
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                        <input type="hidden" name="codeutilisateur" value="<?php echo $row['codeutilisateur']; ?>">
                        <button class="btn btn-secondary" type="button" onclick="voirPlus('<?php echo $row['codeutilisateur']; ?>')">Voir plus</button>
                    </form>
                </td>
            </tr>
            <?php
        }
        // Fermer la dernière table
        echo '</tbody></table>';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
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
    <?php
} else {
    echo "Aucun résultat trouvé";
}

$conn->close();
?>
