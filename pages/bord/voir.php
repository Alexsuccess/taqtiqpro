<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations des Inscriptions et Utilisateurs</title>
    <style type="text/css">


.container {
    width: 100%;
    margin-left: -1%;
    background: #fff;
  
}

h1 {
    text-align: center;
    margin-bottom: 20px;
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
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Informations des precessus et explications de la procédure</h1>
        <table id="infoTable">
            <thead>
                <tr>
                  
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Pays</th>
                    <th>Langue Verbale</th>
                    <th>Langue Écrite</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Type</th>
                    <th>Poste</th>
                    <th>Tentative de réccuperation d'une demande</th>
                    <th>adresse est à l'extérieur du Canada</th>
                    <th>Accepte les droits et responsabilités</th>
                    <th>Accepte l'attestation</th>
                    <th>Date d'enregistrement</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données
                $conn = new mysqli('4w0vau.myd.infomaniak.com', '4w0vau_dreamize', 'Pidou2016', '4w0vau_dreamize');
                
                // Vérifier la connexion
                if ($conn->connect_error) {
                    die("Échec de la connexion : " . $conn->connect_error);
                }
                
                // Requête pour récupérer les informations
                $sql = "SELECT i.id AS inscription_id, i.verbal_language, i.recover, i.created_at,  i.postal_code, i.attestation, i.written_language, i.accept_rights, i.international_address, i.email AS inscription_email, i.phone, i.postal_address, u.nom, u.prenom, u.pays
                        FROM inscriptions i
                        JOIN userss u ON i.user_id = u.id";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Afficher les données pour chaque ligne
                    while($row = $result->fetch_assoc()) {
                       
                        echo "<tr>
                                
                                <td>{$row['nom']}</td>
                                <td>{$row['prenom']}</td>
                                <td>{$row['pays']}</td>
                                <td>{$row['verbal_language']}</td>
                                <td>{$row['written_language']}</td>
                                <td>{$row['inscription_email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['postal_address']}</td>
                                <td>{$row['postal_code']}</td>
                                <td>{$row['recover']}</td>
                                <td>{$row['international_address']}</td>
                                <td>{$row['accept_rights']}</td>
                                <td>{$row['attestation']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Aucune donnée trouvée</td></tr>";
                }
                
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
