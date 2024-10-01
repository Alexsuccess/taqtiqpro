<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Documents</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Permet de faire défiler horizontalement sur mobile */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: nowrap; /* Empêche le texte de se couper sur les petits écrans */
        }

        table th {
            background-color: #f2f2f2;
        }

        /* Styles spécifiques pour les colonnes larges */
        table th:nth-child(1), table td:nth-child(1) {
            width: 50px; /* Largeur pour l'ID */
        }

        table th:nth-child(n+7), table td:nth-child(n+7) {
            min-width: 150px; /* Colonnes larges pour les documents */
        }

        /* Style pour les liens de téléchargement */
        .download-link {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }

        .download-link:hover {
            text-decoration: underline;
        }

        /* Style pour le lien "Voir plus" */
        #voirPlusLink {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #007bff;
            cursor: pointer;
        }

        #voirPlusLink:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Documents</h1>
        <table id="documentsTable">
            <thead>
                <tr>
                  
                    <th>Conseiller</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Courriel</th>
                    <th>Diplôme</th>
                    <th>CV</th>
                    <th>Certificat de Naissance</th>
                    <th>Certificat de Scolarité</th>
                    <th>Passeport</th>
                    <th>Attestation d'Études</th>
                    <th>Plan Cadre</th>
                    <th>Attestation d'Enregistrement</th>
                    <th>Relevé de Notes</th>
                    <th>Expérience Professionnelle</th>
                    <th>Permis de Conduire</th>
                    <th>Mandat de Représentation</th>
                    <th>Acte de Mariage</th>
                </tr>
            </thead>
            <tbody id="documentsTableBody">
<?php
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

                // Requête SQL pour récupérer tous les documents
                $sql = "SELECT * FROM documentss AS ee 
        LEFT JOIN userss AS xx ON xx.help2 = ee.conseiller left join utilisateurs_destinataires as ud on ud.id_utilisateur = xx.id
        WHERE ee.conseiller IS NOT NULL";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                     
                        echo "<td>" . $row['conseiller'] . "</td>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $row['tel'] . "</td>";
                        echo "<td>" . $row['courriel'] . "</td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['diplome'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['cv'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['certificat_naissance'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['certificat_scolarite'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['passeport'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['attestation_etude'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['plan_cadre'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['attestation_enregistrement'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['releve_note'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['experience_professionnelle'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['permis_conduire'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['mandat_representation'] . "' download>Télécharger</a></td>";
                        echo "<td><a class='download-link' href='uploads/" . $row['acte_mariage'] . "' download>Télécharger</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='18'>Aucun document trouvé.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <div id="voirPlusLink">Voir plus</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const voirPlusLink = document.getElementById('voirPlusLink');
            voirPlusLink.addEventListener('click', function() {
                alert('Fonctionnalité "Voir plus" à implémenter.');
            });
        });
    </script>
</body>
</html>
