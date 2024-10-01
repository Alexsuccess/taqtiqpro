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

$sql = "SELECT * FROM appels_telephoniques as dd left join userss as ff on ff.id=dd.personne_id where dd.user_id= $userId";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appels Téléphoniques</title>
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
</head>
<body>

<div class="header text-center">
    <h1>Mon Application de Gestion des Appels</h1>
<button style="background-color: red; color: white;" onclick="location.href='../../telephoniste.php'">Retour</button>

</div>

<div class="container">
    <h1 class="text-center mb-4">Liste des Appels Téléphoniques</h1>
    <table style="margin-left: -35%;" id="appelsTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Client</th>
                <th>Pays</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Telephoniste</th>
                <th>Date Appel</th>
                <th>Heure Appel</th>
                <th>Status</th>
                <th>A Qui Parle</th>
                <th>Tache</th>
                <th>Raison Appel</th>
                <th>Campagne</th>
                <th>Rendez Vous Date</th>
                <th>Rendez Vous Heure</th>
               
                <th>Date Enregistrement</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr class="rendez-vous-row" data-rendez-vous-date="<?php echo htmlspecialchars($row['rendez_vous_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <td>CL00<?php echo htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['nom'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['pays'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['telphone'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['telephoniste'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['date_appel'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['heure_appel'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['a_qui_parle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['tache'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['raison_appel'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['campagne'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['rendez_vous_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['rendez_vous_heure'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        
                        <td><?php echo htmlspecialchars($row['date_enregistrement'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="17">Aucun enregistrement trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="footer text-center">
    <p>&copy; 2024 Mon Application. Tous droits réservés.</p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#appelsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "order": [[0, "asc"]],
            "language": {
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Affichage de la page _PAGE_ de _PAGES_",
                "infoEmpty": "Aucun enregistrement disponible",
                "infoFiltered": "(filtré à partir de _MAX_ enregistrements au total)",
                "search": "Recherche:",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            }
        });

        // Vérifier et appliquer les classes CSS en fonction de la date de rendez-vous
        $('.rendez-vous-row').each(function() {
            var rendezVousDate = $(this).data('rendez-vous-date');
            if (rendezVousDate) {
                var today = new Date();
                var rdvDate = new Date(rendezVousDate);
                var timeDiff = rdvDate - today;
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (daysDiff === 1) {
                    $(this).addClass('alert alert-orange');
                } else if (daysDiff === 0) {
                    $(this).addClass('alert alert-red');
                } else if (daysDiff < 0) {
                    $(this).addClass('alert alert-blue');
                }
            }
        });
    });
</script>

</body>
</html>
