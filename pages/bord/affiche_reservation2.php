<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>

        .table {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Liste des réservations des candidats de Ustaff</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Réservation</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Date</th>
                        <th>Exigences</th>
                        <th>Candidats</th>
                   
                        <th>Date de Création</th>
                    </tr>
                </thead>
                <tbody id="orders-container">
                    <!-- Les commandes seront injectées ici -->
                    <?php
                    // Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Requête pour récupérer les commandes avec les candidats et les compétences
                    $sql = "
                    SELECT 
                        c.id as order_id, 
                        c.nomm, 
                        c.telephone, 
                        c.couriel, 
                        c.villee, 
                        c.date, 
                        c.exigences, 
                        c.created_at, 
                        GROUP_CONCAT(DISTINCT CONCAT(cand.prenom, ' ', cand.nom) SEPARATOR ', ') as candidats,
                        GROUP_CONCAT(DISTINCT CONCAT(comp.prenom, ' ', comp.Nom) SEPARATOR ', ') as competences
                    FROM commandes220 c
                    LEFT JOIN candidats cand ON FIND_IN_SET(cand.id, c.candidats)
                    LEFT JOIN competence1 comp ON FIND_IN_SET(comp.id, c.competence_id)
                    GROUP BY c.id
                    ";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>RESV00" . $row["order_id"] . "</td>";
                            echo "<td>" . $row["nomm"] . "</td>";
                            echo "<td>" . $row["telephone"] . "</td>";
                            echo "<td>" . $row["couriel"] . "</td>";
                            echo "<td>" . $row["villee"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["exigences"] . "</td>";
                           echo "<td>" . $row["candidats"] . "</td>";

                           
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Aucune commande trouvée</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
