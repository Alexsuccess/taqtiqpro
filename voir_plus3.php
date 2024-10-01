<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Référence</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Logo de l'entreprise">
            <h1>Détails de la Référence</h1>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Nom</th>
                    <th>Contact</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Récupérer le code_unique depuis l'URL
            if (isset($_GET['code'])) {
                $code_unique = $_GET['code'];

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

                // Requête SQL pour récupérer les détails basés sur le code_unique
                $sql = "SELECT categorie, nom, contact, telephone, nom_agent, agence, region, ville FROM referencestto WHERE code_unique = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $code_unique);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc(); // Obtenir la première ligne pour afficher nom_agent
                $nom_agent = htmlspecialchars($row['nom_agent']);
                $agence = htmlspecialchars($row['agence']);
                $region = htmlspecialchars($row['region']);
                $ville = htmlspecialchars($row['ville']);
                // Afficher le nom_agent en dehors de la boucle while
              
                            echo "<hr>";
                            echo "<p>Nom de l'agent : $nom_agent</p>";
                            echo "<p>Agence : $agence</p>";
                            echo "<p>Region : $region</p>";
                            echo "<p>Ville : $ville</p><hr>";

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['categorie']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
                    echo "</tr>";

                    // Afficher le reste des lignes
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['categorie']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun détail trouvé pour cette référence</td></tr>";
                }

                // Fermer la connexion à la base de données
                $stmt->close();
                $conn->close();
            } else {
                echo "<tr><td colspan='4'>Code unique non spécifié</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <a class="back-link" href="javascript:window.close()">Fermer</a>
    </div>
</body>
</html>
