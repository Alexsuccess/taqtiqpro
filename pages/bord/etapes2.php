<!DOCTYPE html>
<html lang="fr">
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

// Requête SQL pour obtenir les données des candidats et formulaires d'immigration
$sql = "
SELECT 
    cand.categorie AS categorie, 
    cand.nom AS nom, 
    cand.prenom AS prenom, 
    cand.email AS email,
    cand.id AS idd,
    cand.etape AS etape,
    cand.validation AS validation,
    cand.procedure1 AS procedure1, 
    cand.prof AS prof,
    cand.paiement AS payment, 
    cand.sexe AS sexe, 
    cand.pays AS pays, 
    cand.city AS ville, 
    cand.region AS region, 
    cand.exp AS exp, 
    CONCAT_WS(', ', 
        COALESCE(doc.diplome, ''), 
        COALESCE(doc.cv, ''), 
        COALESCE(doc.certificat_naissance, ''), 
        COALESCE(doc.certificat_scolarite, ''), 
        COALESCE(doc.passeport, ''), 
        COALESCE(doc.attestation_etude, ''), 
        COALESCE(doc.plan_cadre, ''), 
        COALESCE(doc.attestation_enregistrement, ''), 
        COALESCE(doc.releve_note, ''), 
        COALESCE(doc.experience_professionnelle, ''), 
        COALESCE(doc.permis_conduire, ''), 
        COALESCE(doc.mandat_representation, ''), 
        COALESCE(doc.acte_mariage, '')
    ) AS documents, 
    cand.specail AS specail, 
    cand.ecrit AS ecrit, 
    cand.parle AS parle, 
    cand.permi AS permi, 
    cand.enfant AS enfant,
    '' AS codeutilisateur,
    cand.code AS id, -- Ajout de l'identifiant pour les candidats
    'candidat' AS type -- Ajout d'un type pour identifier la table
FROM candidats AS cand
LEFT JOIN documentss AS doc ON cand.code = doc.code

UNION

SELECT 
    '' AS categorie,
    ds.full_name AS nom, 
    ds.preno AS prenom, 
    ds.email AS email,
    ds.etape AS etape,  
    ds.payment2 AS payment2,
    ds.id AS idd,
    ds.procedurei AS procedure1,
    ds.validation AS validation,
    ff.payment AS prof,
    ff.documents AS documents,
    '' AS sexe, 
    ds.country AS pays, 
    ds.city AS ville, 
    '' AS region, 
    ds.experience AS exp, 
    '' AS specail, 
    '' AS ecrit, 
    '' AS parle, 
    '' AS permi, 
    '' AS enfant,
    ds.codeutilisateur AS codeutilisateur, -- Utilisation du codeutilisateur pour les formulaires
    ds.codeutilisateur AS id, -- Ajout de l'identifiant pour les formulaires
    'formulaire' AS type -- Ajout d'un type pour identifier la table
FROM 
    formulaire_immigration_session1 AS ds 
LEFT JOIN 
    formulaire_immigration_session2 AS ff 
ON 
    ds.codeutilisateur = ff.codeutilisateur
WHERE 
    ds.codeutilisateur IS NOT NULL
";

$result = $conn->query($sql);

// Fermer la connexion
$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagramme des Étapes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .chart-container {
            width: 100%;
            max-width: 100%;
            margin: auto;
        }
        .chart-scroll {
            overflow-x: auto;
            padding-bottom: 20px;
        }
        canvas {
            max-width: 100%;
            height: 400px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Diagramme des Étapes pour les Candidats</h2>
        <p>Chaque barre représente les étapes complètes pour chaque candidat.</p>
    </div>

    <!-- Barre de recherche -->
    <div class="search-bar">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un candidat...">
    </div>

    <!-- Conteneur pour le graphique avec défilement horizontal -->
    <div class="chart-scroll">
        <div class="chart-container">
            <canvas id="stepsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Préparer les données pour Chart.js
    const labels = [];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Nombre d\'étapes complètes',
            data: [],
            backgroundColor: '#28a745',
            borderColor: '#1e7e34',
            borderWidth: 1
        }]
    };

    const stepNames = ['SÉLECTION', 'OBTENIR UN CONTRAT', 'OBTENIR L\'ADMISSIBILITÉ', 'DÉMARCHES POUR OBTENIR LE CAQ', 'DÉMARCHES POUR OBTENTION DU PERMIS DE TRAVAIL', 'INTÉGRATION EN EMPLOI'];

    <?php
    // Préparer les données pour l'intégration JavaScript
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo "const rows = " . json_encode($rows) . ";";
    ?>

    // Ajouter les données au graphique
    rows.forEach(row => {
        labels.push(`${row.prenom} ${row.nom}`);
        data.datasets[0].data.push(parseInt(row.etape));
    });

    const ctx = document.getElementById('stepsChart').getContext('2d');
    let chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Étapes Complètes'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Candidats'
                    },
                    ticks: {
                        autoSkip: false // pour afficher toutes les étiquettes
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const stepIndex = tooltipItem.raw - 1;
                            return `Étape : ${stepNames[stepIndex] || 'Inconnue'}`;
                        }
                    }
                }
            }
        }
    });

    // Fonction pour rechercher les candidats
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        // Filtrage des données
        const filteredRows = rows.filter(row => (row.prenom + ' ' + row.nom).toLowerCase().includes(searchTerm));
        const filteredLabels = filteredRows.map(row => `${row.prenom} ${row.nom}`);
        const filteredData = filteredRows.map(row => parseInt(row.etape));

        // Réinitialiser les données du graphique
        chart.data.labels = filteredLabels;
        chart.data.datasets[0].data = filteredData;

        // Mettre à jour le graphique
        chart.update();
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
