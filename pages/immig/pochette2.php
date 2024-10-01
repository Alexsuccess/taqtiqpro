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

// Fonction pour générer un code unique
function generateUniqueCode($conn) {
    $code = bin2hex(random_bytes(4)); // Générer un code aléatoire de 8 caractères
    $sql = "SELECT COUNT(*) as count FROM referencestto WHERE code_unique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Vérifier si le code est unique
    while ($row['count'] > 0) {
        $code = bin2hex(random_bytes(4)); // Générer un nouveau code si celui-ci existe déjà
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }

    return $code;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Générer un code unique pour cet enregistrement complet
    $code_unique = generateUniqueCode($conn);
    
    // Préparer la requête d'insertion avec des paramètres liés
    $sql = "INSERT INTO referencestto (nom_agent, numero_permis, agence, complete_par, region, ville, categorie, nom, contact, telephone, code_unique, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  $userId)";
    
    // Préparer l'instruction SQL
    $stmt = $conn->prepare($sql);
    
    // Vérifier si la préparation a réussi
    if ($stmt === false) {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    } else {
        // Récupérer les valeurs du formulaire
        $nom_agent = $_POST['nom_agent'];
        $numero_permis = $_POST['numero_permis'];
        $agence = $_POST['agence'];
        $complete_par = $_POST['complete_par'];

        $region = $_POST['region'];
        $ville = $_POST['ville'];
        // Préparer les tableaux pour les catégories
        $categories = [
            'Notaire', 'Courtiers', 'Inspecteurs', 'Évaluateurs', 'Arpenteurs géomètres',
            'Entrepreneur général', 'Assurances', 'Déménageur', 'Designer intérieur',
            'Armoires de cuisine', 'Électricien', 'Plomberie', 'Puits artésiens'
        ];
        
        // Préparer les tableaux pour les noms, contacts et téléphones correspondants
        $noms = [
            $_POST['notaire_nom'], $_POST['courtiers_nom'], $_POST['inspecteurs_nom'],
            $_POST['evaluateurs_nom'], $_POST['arpenteurs_nom'], $_POST['entrepreneur_nom'],
            $_POST['assurances_nom'], $_POST['demenageur_nom'], $_POST['designer_nom'],
            $_POST['armoires_nom'], $_POST['electricien_nom'], $_POST['plomberie_nom'],
            $_POST['puits_nom']
        ];
        
        $contacts = [
            $_POST['notaire_contact'], $_POST['courtiers_contact'], $_POST['inspecteurs_contact'],
            $_POST['evaluateurs_contact'], $_POST['arpenteurs_contact'], $_POST['entrepreneur_contact'],
            $_POST['assurances_contact'], $_POST['demenageur_contact'], $_POST['designer_contact'],
            $_POST['armoires_contact'], $_POST['electricien_contact'], $_POST['plomberie_contact'],
            $_POST['puits_contact']
        ];
        
        $telephones = [
            $_POST['notaire_telephone'], $_POST['courtiers_telephone'], $_POST['inspecteurs_telephone'],
            $_POST['evaluateurs_telephone'], $_POST['arpenteurs_telephone'], $_POST['entrepreneur_telephone'],
            $_POST['assurances_telephone'], $_POST['demenageur_telephone'], $_POST['designer_telephone'],
            $_POST['armoires_telephone'], $_POST['electricien_telephone'], $_POST['plomberie_telephone'],
            $_POST['puits_telephone']
        ];
        
        // Binder les paramètres et exécuter la requête pour chaque catégorie
        foreach ($categories as $index => $categorie) {
            $nom = $noms[$index];
            $contact = $contacts[$index];
            $telephone = $telephones[$index];
            
            // Binder les paramètres à l'instruction SQL
            $stmt->bind_param("sssssssssss", $nom_agent, $numero_permis, $agence, $complete_par, $region, $ville, $categorie, $nom, $contact, $telephone, $code_unique);
            
            // Exécuter la requête
            if ($stmt->execute() === false) {
                echo "Erreur lors de l'insertion : " . $stmt->error;
            }
        }
        
        // Fermer la déclaration préparée
        $stmt->close();
    }
    
    // Fermer la connexion à la base de données
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Références</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80%;
            height: 80%;
            background: url('log.jpeg') no-repeat center center;
            background-size: contain;
            opacity: 0.1;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .logo {
            width: 200px;
            height: auto;
        }

        .title {
            text-align: right;
        }

        .title h1 {
            margin: 0;
            color: #007bff;
        }

        .info {
            margin: 20px 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-item label {
            width: 150px;
            font-weight: bold;
        }

        .info-item input {
            flex: 1;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

.info {
    display: flex;
    flex-wrap: wrap;
}

.info-item {
    flex: 1 1 45%; /* 45% de la largeur disponible pour chaque élément, permettant de garder un espace de 5% entre les colonnes */
    margin: 10px;
}

.info-item label {
    display: block;
    margin-bottom: 5px;
}

.info-item input {
    width: 100%;
    padding: 5px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="log.jpeg" alt="Logo" class="logo">
            <div >
                <h1>Références personnalisées </h1>
            </div>

            <div class="title">
                <h1><h1></h1>
            </div>
        </div>
        <form action="" method="post">
  <div class="info">
    <div class="info-item">
        <label for="nom_agent">Nom de l'agent :</label>
        <input type="text" id="nom_agent" name="nom_agent">
    </div>
    <div class="info-item">
        <label for="numero_permis">Numéro de permis :</label>
        <input type="text" id="numero_permis" name="numero_permis">
    </div>
    <div class="info-item">
        <label for="agence">Agence :</label>
        <input type="text" id="agence" name="agence">
    </div>
    <div class="info-item">
        <label for="complete_par">Complété par :</label>
        <input type="text" id="complete_par" name="complete_par">
    </div>
    <div class="info-item">
        <label for="region">Pays :</label>
        <input type="text" id="region" name="region">
    </div>
    <div class="info-item">
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville">
    </div>
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
                    <tr>
                        <td>Notaire :</td>
                        <td><input type="text" id="notaire_nom" name="notaire_nom"></td>
                        <td><input type="text" id="notaire_contact" name="notaire_contact"></td>
                        <td><input type="text" id="notaire_telephone" name="notaire_telephone"></td>
                    </tr>
                    <tr>
                        <td>Courtiers :</td>
                        <td><input type="text" id="courtiers_nom" name="courtiers_nom"></td>
                        <td><input type="text" id="courtiers_contact" name="courtiers_contact"></td>
                        <td><input type="text" id="courtiers_telephone" name="courtiers_telephone"></td>
                    </tr>
                    <tr>
                        <td>Inspecteurs :</td>
                        <td><input type="text" id="inspecteurs_nom" name="inspecteurs_nom"></td>
                        <td><input type="text" id="inspecteurs_contact" name="inspecteurs_contact"></td>
                        <td><input type="text" id="inspecteurs_telephone" name="inspecteurs_telephone"></td>
                    </tr>
                    <tr>
                        <td>Évaluateurs :</td>
                        <td><input type="text" id="evaluateurs_nom" name="evaluateurs_nom"></td>
                        <td><input type="text" id="evaluateurs_contact" name="evaluateurs_contact"></td>
                        <td><input type="text" id="evaluateurs_telephone" name="evaluateurs_telephone"></td>
                    </tr>
                    <tr>
                        <td>Arpenteurs géomètres :</td>
                        <td><input type="text" id="arpenteurs_nom" name="arpenteurs_nom"></td>
                        <td><input type="text" id="arpenteurs_contact" name="arpenteurs_contact"></td>
                        <td><input type="text" id="arpenteurs_telephone" name="arpenteurs_telephone"></td>
                    </tr>
                    <tr>
                        <td>Entrepreneur général :</td>
                        <td><input type="text" id="entrepreneur_nom" name="entrepreneur_nom"></td>
                        <td><input type="text" id="entrepreneur_contact" name="entrepreneur_contact"></td>
                        <td><input type="text" id="entrepreneur_telephone" name="entrepreneur_telephone"></td>
                    </tr>
                    <tr>
                        <td>Assurances :</td>
                        <td><input type="text" id="assurances_nom" name="assurances_nom"></td>
                        <td><input type="text" id="assurances_contact" name="assurances_contact"></td>
                        <td><input type="text" id="assurances_telephone" name="assurances_telephone"></td>
                    </tr>
                    <tr>
                        <td>Déménageur :</td>
                        <td><input type="text" id="demenageur_nom" name="demenageur_nom"></td>
                        <td><input type="text" id="demenageur_contact" name="demenageur_contact"></td>
                        <td><input type="text" id="demenageur_telephone" name="demenageur_telephone"></td>
                    </tr>
                    <tr>
                        <td>Designer intérieur :</td>
                        <td><input type="text" id="designer_nom" name="designer_nom"></td>
                        <td><input type="text" id="designer_contact" name="designer_contact"></td>
                        <td><input type="text" id="designer_telephone" name="designer_telephone"></td>
                    </tr>
                    <tr>
                        <td>Armoires de cuisine :</td>
                        <td><input type="text" id="armoires_nom" name="armoires_nom"></td>
                        <td><input type="text" id="armoires_contact" name="armoires_contact"></td>
                        <td><input type="text" id="armoires_telephone" name="armoires_telephone"></td>
                    </tr>
                    <tr>
                        <td>Électricien :</td>
                        <td><input type="text" id="electricien_nom" name="electricien_nom"></td>
                        <td><input type="text" id="electricien_contact" name="electricien_contact"></td>
                        <td><input type="text" id="electricien_telephone" name="electricien_telephone"></td>
                    </tr>
                    <tr>
                        <td>Plomberie :</td>
                        <td><input type="text" id="plomberie_nom" name="plomberie_nom"></td>
                        <td><input type="text" id="plomberie_contact" name="plomberie_contact"></td>
                        <td><input type="text" id="plomberie_telephone" name="plomberie_telephone"></td>
                    </tr>
                    <tr>
                        <td>Puits artésiens :</td>
                        <td><input type="text" id="puits_nom" name="puits_nom"></td>
                        <td><input type="text" id="puits_contact" name="puits_contact"></td>
                        <td><input type="text" id="puits_telephone" name="puits_telephone"></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit">Soumettre</button>
        </form>
    </div>
</body>
</html>
