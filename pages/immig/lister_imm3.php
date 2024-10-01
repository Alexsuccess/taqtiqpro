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

// Fonction pour générer une chaîne aléatoire
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Vérifier l'action POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'toggle') {
        if (isset($_POST['current_status'])) {
            $current_status = $_POST['current_status'];
            $new_status = $current_status == 1 ? 0 : 1;
            $sql = "UPDATE userss SET statut = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $new_status, $id);
            if (!$stmt->execute()) {
                echo "Erreur lors de la mise à jour du statut : " . $conn->error;
            }
        } else {
            echo "Paramètres manquants pour l'action 'toggle'.";
        }
    } elseif ($action == 'delete') {
        try {
            // Commencer une transaction
            $conn->begin_transaction();

            // Supprimer dans la table `userss`
            $sql1 = "DELETE FROM userss WHERE id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $stmt1->execute();

            // Supprimer dans la table `formulaire_immigration_session1`
            $sql2 = "DELETE FROM formulaire_immigration_session1 WHERE user_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();

            // Valider la transaction
            $conn->commit();
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $conn->rollback();
            echo "Erreur lors de la suppression du record : " . $e->getMessage();
        }
    } elseif ($action == 'generate_code') {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $code = generateRandomString(8); // Générer un code aléatoire de longueur 8
            $sql = "UPDATE userss SET help = 'validé', help2 = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $code, $email);
            if (!$stmt->execute()) {
                echo "Erreur lors de la génération du code : " . $conn->error;
            }
        } else {
            echo "Paramètre 'email' manquant pour l'action 'generate_code'.";
        }
    } else {
        echo "Action non reconnue : " . htmlspecialchars($action);
    }
}

// Requête SQL pour sélectionner les données où photot n'est pas null
$sql = "SELECT ds.*, dd.nom, dd.prenom, dd.email, ds.country, ds.phone, ds.photo, dd.statut, dd.help2, sis.payment, sis.documents, ds.experience, ds.photot FROM formulaire_immigration_session1 AS ds LEFT JOIN userss AS dd ON dd.id = ds.user_id LEFT JOIN formulaire_immigration_session2 AS sis ON dd.id = sis.user_id LEFT JOIN competence1 AS c1 ON dd.id = c1.user_id WHERE photot IS NOT NULL GROUP BY ds.user_id";
$result = $conn->query($sql);

// Vérifier si des résultats ont été trouvés
if ($result && $result->num_rows > 0) {
    // Affichage des résultats dans un tableau HTML
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
        <h2 class="mb-4">Enroulements</h2>
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Nom Complet</th>
                     <th>Prenom</th>
                     <th>Pays</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                
                    <th>Photo</th>
                    <th>Code</th>
                    <th>Audio</th>
                    <th>Statut</th>
                    <th>Info</th>
                    <th>Champs Manquants</th>
                    <th>Actions</th>
                    <th>Générer Code</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Vérifier si tous les champs sont remplis et collecter les champs manquants
                    $isComplete = true;
                    $missingFields = [];
                    $fields = [
                        'nom' => 'Nom',
                        'email' => 'Email',
                        'phone' => 'Téléphone',
                        'statut' => 'Statut',
                        'help2' => 'Code',
                        'payment' => 'Profession', // Modifier l'étiquette ici
                        'documents' => 'Documents',
                        'experience' => 'Expérience',
                        'photot' => 'Photo'
                    ];

                    foreach ($fields as $field => $label) {
                        if (empty($row[$field])) {
                            $isComplete = false;
                            $missingFields[] = $label;
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($row['country']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        
                        <td><img style="width: 60px; height: 60px;" src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo"></td>
                        <td><?php echo htmlspecialchars($row['help2'] ?? ''); ?></td>
                        <td class="audio-player">
                            <audio controls>
                                <source src="uploads/<?php echo htmlspecialchars($row['photot']); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>

                            <?php echo $row['statut'] == 1 ? '<img style="width: 35%;height: 35%;" src="active.PNG" alt="image">' : '<img style="width: 35%;height: 35%;" src="desactivee.png" alt="image">'; ?>
                        </td>
                        <td>
                            <?php echo $isComplete ? '<img style="width: 25%;height: 25%;" src="complet.png" alt="image"> Dossier Complet' : '<img style="width: 25%;height: 25%;" src="incom.png" alt="image">  Dossier Incomplet'; ?>
                        </td>
                        <td>
                            <?php echo !$isComplete ? implode(', ', $missingFields) : ''; ?>
                        </td>
                        <td class="action-buttons">
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $row['statut']; ?>">
                                <button class="btn btn-primary" type="submit" name="action" value="toggle">
                                    <?php echo $row['statut'] == 1 ? 'Desactiver' : 'Activer'; ?>
                                </button><br>
                            </form><br>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                <button type="submit" name="action" value="delete"><img style="width: 15%;height: 15%;" src="supprimer.png" alt="image"> </button><br>
                            </form><br>
                            <button class="btn btn-info" onclick="voirPlus('<?php echo $row['user_id']; ?>')"><img style="width: 25%;height: 25%;" src="voirplus.png" alt="image"></button>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                <button class="btn btn-warning" type="submit" name="action" value="generate_code" >Générer Code</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        function voirPlus(userId) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'voir_plus.php?user_id=' + userId;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "Aucun résultat trouvé.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
