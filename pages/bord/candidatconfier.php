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
        WHERE rr.id_destinataire = $userId AND xx.codeutilisateur IS NOT NULL  ";
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
        <h1>Informations des Candidats Assignés</h1>
        <table>
            <thead>
                <tr>
                    
                   
                    <th>Code Candidat</th>
                     <th>Profession</th>
                     <th>Nom</th>
                    <th>Pays</th>
                   
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Expérience</th>
                    <th>Photo</th>
                     <th>Assigné à</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    
                    <td>CAND00<?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['Profession'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['nom'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['country'] ?? ''); ?></td>
                    
                    <td><a href="mailto:<?php echo htmlspecialchars($row['email'] ?? ''); ?>">info@uricanada.com</a></td>
                    <td>450-437-7444</td>
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




















<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.nom, c.prenom, c.email, c.sexe, c.pays, c.code, c.id, c.prof,
        d.diplome, d.passeport, d.certificat_naissance, d.certificat_scolarite, d.mandat_representation, rr.id_utilisateur, c.id
        FROM candidats c
        LEFT JOIN documentss d ON c.code = d.code left join utilisateurs_destinataires as rr on rr.id_utilisateur = c.id WHERE rr.id_destinataire = $userId";
$result = $conn->query($sql);



$conn->close();
?>


    <style>


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

    </style>

    <div>

            <table style="width: 1108px; background-color: white; margin-left: 14.8%;">
                <thead>
                    <tr>
                        
                        <th>Code Candidat</th>
                        <th>Profession</th>
                        <th>Nom</th>
                        <th>Sexe</th>
                        <th>Pays</th>
                    
                        
                        
                        
                        <th>Alertes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $missingDocuments = [];
                            if (!$row['diplome']) {
                                $missingDocuments[] = "Diplôme";
                            }
                            if (!$row['passeport']) {
                                $missingDocuments[] = "Passeport";
                            }
                            if (!$row['certificat_naissance']) {
                                $missingDocuments[] = "Certificat de naissance";
                            }
                            if (!$row['certificat_scolarite']) {
                                $missingDocuments[] = "Certificat de scolarité";
                            }
                            if (!$row['mandat_representation']) {
                                $missingDocuments[] = "Mandat de représentation";
                            }
$userCode = htmlspecialchars($row['code'] ?? '');
echo "<tr>";
echo "<td>CAND00" . htmlspecialchars($row['id'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['prof'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['sexe'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['pays'] ?? '') . "</td>";
echo "<td class='" . (!empty($missingDocuments) ? "red-alert" : "") . "'>";
if (!empty($missingDocuments)) {
    echo "Documents manquants: " . implode(", ", $missingDocuments);
} else {
    echo "Tous les documents sont présents";
}
echo "</td>";
echo "<td><button class='btn btn-secondary' type='button' onclick='voirPlus8(\"" . $row['code'] . "\")'>Voir plus</button></td>";

echo "</tr>";

                        }
                    } else {
                        echo "<tr><td colspan='18'>Aucun candidat trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

    </div>


    <script>


            // Fonction pour voir plus de détails
            window.voirPlus8 = function(code) {
                var url = 'pages/bord/voir_voir_plus.php?code=' + encodeURIComponent(code);
                var newWindow = window.open(url, '_blank', 'width=800,height=600');
                newWindow.focus();
            };
    </script>




    <script type="text/javascript">
        function voirPlus(codeutilisateur) {
            // Ouvrir une nouvelle fenêtre avec les détails de l'utilisateur
            var url = 'voir_pluss2.php?codeutilisateur=' + codeutilisateur;
            var windowName = 'DetailsUtilisateur';
            var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';

            window.open(url, windowName, windowFeatures);
        }
    </script>
</body>
</html>
