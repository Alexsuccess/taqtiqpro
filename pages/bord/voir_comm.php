<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traitement des actions (Valider, Refuser, En attente, Supprimer)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code_commande = $_POST['code_commande'];
    
    if (isset($_POST['valider'])) {
        $status = 'Validé';
    } elseif (isset($_POST['refuser'])) {
        $status = 'Refusé';
    } elseif (isset($_POST['en_attente'])) {
        $status = 'En attente';
    } elseif (isset($_POST['supprimer'])) {
        $deleteQuery = "DELETE FROM commandes51 WHERE code_commande = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $code_commande);
        $stmt->execute();
        $stmt->close();
    }

    // Mettre à jour le statut de la commande si ce n'est pas une suppression
    if (isset($status)) {
        $updateQuery = "UPDATE commandes51 SET statut = ? WHERE code_commande = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $status, $code_commande);
        $stmt->execute();
        $stmt->close();
    }
}

// Récupérer les commandes avec les services associés
$query = "
    SELECT 
        c.nom,
        c.pays,
        c.ville,
        c.contact,
        c.email,
        c.code_commande, 
        c.date_debut, 
        c.duree_emploi, 
        c.heures_travail, 
        c.salaire, 
        c.exigences_linguistiques, 
        c.justification, 
        c.exigences_scolarite, 
        c.securite, 
        c.logement, 
        c.billet_avion, 
        c.vehicule, 
        c.transport, 
        c.nourriture, 
        c.autre, 
        c.explications, 
        c.assistance, 
        c.employes_etrangers, 
        c.nombre_etrangers, 
        c.eimt_numero, 
        c.premiere_fois, 
        c.nombre_personnes,
        c.statut,  /* Ajout du champ statut */
        c.datte,
        cs.service_title,
        cs.quantity
    FROM commandes51 c
    LEFT JOIN commande_services50 cs ON c.code_commande = cs.code_commande
    ORDER BY c.code_commande
";

$result = $conn->query($query);

$commandes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $commandes[$row['code_commande']]['details'] = [
            'nom' => $row['nom'],
            'pays' => $row['pays'],
            'ville' => $row['ville'],
            'contact' => $row['contact'],
            'email' => $row['email'],
            'date_debut' => $row['date_debut'],
            'duree_emploi' => $row['duree_emploi'],
            'heures_travail' => $row['heures_travail'],
            'salaire' => $row['salaire'],
            'exigences_linguistiques' => $row['exigences_linguistiques'],
            'justification' => $row['justification'],
            'exigences_scolarite' => $row['exigences_scolarite'],
            'securite' => $row['securite'],
            'logement' => $row['logement'],
            'billet_avion' => $row['billet_avion'],
            'vehicule' => $row['vehicule'],
            'transport' => $row['transport'],
            'nourriture' => $row['nourriture'],
            'autre' => $row['autre'],
            'explications' => $row['explications'],
            'assistance' => $row['assistance'],
            'employes_etrangers' => $row['employes_etrangers'],
            'nombre_etrangers' => $row['nombre_etrangers'],
            'eimt_numero' => $row['eimt_numero'],
            'premiere_fois' => $row['premiere_fois'],
            'nombre_personnes' => $row['nombre_personnes'],
            'datte' => $row['datte'],
            'statut' => $row['statut']
        ];
        $commandes[$row['code_commande']]['services'][] = [
            'title' => $row['service_title'],
            'quantity' => $row['quantity']
        ];
    }
} else {
    echo "Aucune commande trouvée.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 30px;
        }
        .commande-card {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .commande-card h5 {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin: 0;
            border-radius: 10px 10px 0 0;
        }
        .service-list {
            margin-top: 15px;
            list-style-type: none;
            padding-left: 0;
        }
        .service-list li {
            background-color: #e9ecef;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .action-buttons {
            margin-top: 15px;
        }
        .action-buttons form {
            display: inline-block;
        }
        .action-buttons button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Liste des Commandes</h1>
        <?php foreach ($commandes as $code_commande => $commande): ?>
            <div class="commande-card p-3">
                <h5>Commande Code: <?php echo htmlspecialchars($code_commande); ?></h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nom de l'entreprise:</strong> <?php echo htmlspecialchars($commande['details']['nom']); ?></p>
                        <p><strong>Pays:</strong> <?php echo htmlspecialchars($commande['details']['pays']); ?></p>
                        <p><strong>Ville:</strong> <?php echo htmlspecialchars($commande['details']['ville']); ?></p>

                        <p><strong>Contact:</strong> <?php echo htmlspecialchars($commande['details']['contact']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($commande['details']['email']); ?></p>
                        <p><strong>Heures de travail:</strong> <?php echo htmlspecialchars($commande['details']['heures_travail']); ?></p>
                        <p><strong>Salaire:</strong> <?php echo htmlspecialchars($commande['details']['salaire']); ?></p>
                        <p><strong>Exigences linguistiques:</strong> <?php echo htmlspecialchars($commande['details']['exigences_linguistiques']); ?></p>
                        <p><strong>Justification:</strong> <?php echo htmlspecialchars($commande['details']['justification']); ?></p>
                        <p><strong>Exigences scolaires:</strong> <?php echo htmlspecialchars($commande['details']['exigences_scolarite']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date de début:</strong> <?php echo htmlspecialchars($commande['details']['date_debut']); ?></p>
                        <p><strong>Durée de l'emploi:</strong> <?php echo htmlspecialchars($commande['details']['duree_emploi']); ?></p>
                        <p><strong>Sécurité:</strong> <?php echo htmlspecialchars($commande['details']['securite']); ?></p>
                        <p><strong>Logement:</strong> <?php echo $commande['details']['logement'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Billet d'avion:</strong> <?php echo $commande['details']['billet_avion'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Véhicule:</strong> <?php echo $commande['details']['vehicule'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Transport:</strong> <?php echo $commande['details']['transport'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Nourriture:</strong> <?php echo $commande['details']['nourriture'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Autre:</strong> <?php echo $commande['details']['autre'] ? 'Oui' : 'Non'; ?></p>
                        <p><strong>Date de la commande:</strong> <?php echo htmlspecialchars($commande['details']['datte']); ?></p>
                    </div>
                </div>
                <h6>Services associés:</h6>
                <ul class="service-list">
                    <?php foreach ($commande['services'] as $service): ?>
                        <li>
                            <?php echo htmlspecialchars($service['title']) . " - Quantité: " . htmlspecialchars($service['quantity']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Statut de la commande:</strong> <?php echo htmlspecialchars($commande['details']['statut']); ?></p>
                <div class="action-buttons">
                    <form method="post" action="">
                        <input type="hidden" name="code_commande" value="<?php echo htmlspecialchars($code_commande); ?>">
                        <button type="submit" name="valider" class="btn btn-success">Valider</button>
                        <button type="submit" name="refuser" class="btn btn-danger">Refuser</button>
                        <button type="submit" name="en_attente" class="btn btn-warning">Mettre en attente</button>
                        <button type="submit" name="supprimer" class="btn btn-dark">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
