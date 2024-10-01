<?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérez l'ID de l'utilisateur
$userId = $_SESSION['id'];





ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération du dernier ID inséré dans la table competence1
$sql = "SELECT MAX(id) AS last_id FROM competence1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];
} else {
    $last_id = 0;
}

// Génération automatique du code utilisateur en incrémentant le dernier ID
$codeutilisateur = $last_id + 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si le tableau $_POST['Nom'] est défini et s'il contient des éléments
    if (isset($_POST['Nom']) && is_array($_POST['Nom']) && count($_POST['Nom']) > 0) {
        // Préparation de la requête SQL d'insertion pour la table competence1
        $stmt1 = $conn->prepare("INSERT INTO competence1 (codeutilisateur, Nom, prenom, pays, ville, tel, mail, agen, agent, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt1) {
            die("Erreur de préparation de la requête pour la table competence1: " . $conn->error);
        }

        // Préparation de la requête SQL d'insertion pour la table competence2
        $stmt2 = $conn->prepare("INSERT INTO competence2 (codeutilisateur, skillTitle, description, tools, `references`, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt2) {
            die("Erreur de préparation de la requête pour la table competence2: " . $conn->error);
        }

        // Récupération des données du formulaire
        $noms = $_POST['Nom'];
        $prenoms = $_POST['prenom'];
        $pays = $_POST['pays'];
        $villes = $_POST['ville']; 

        $tel = $_POST['tel'];
        $mail = $_POST['mail'];
        $agen = $_POST['agen'];
        $agent = $_POST['agent'];

        $skillTitles = $_POST['skillTitle'];
        $descriptions = $_POST['description'];
        $tools = $_POST['tools'];
        $references = $_POST['references'];

        // Insertion des données dans les tables competence1 et competence2
        foreach ($skillTitles as $key => $skillTitle) {
            // Insertion dans la table competence1
            $stmt1->bind_param("sssssssssi", $codeutilisateur, $noms[$key], $prenoms[$key], $pays[$key], $villes[$key], $tel[$key], $mail[$key], $agen[$key], $agent[$key], $userId);
            $result1 = $stmt1->execute();

            if (!$result1) {
                die("Erreur lors de l'insertion dans la table competence1: " . $stmt1->error);
            }

            // Insertion dans la table competence2
            $stmt2->bind_param("sssssi", $codeutilisateur, $skillTitle, $descriptions[$key], $tools[$key], $references[$key], $userId);
            $result2 = $stmt2->execute();

            if (!$result2) {
                die("Erreur lors de l'insertion dans la table competence2: " . $stmt2->error);
            }
        }

        echo "Compétences enregistrées avec succès!";
    } else {
        echo "Aucune compétence n'a été ajoutée.";
    }

    // Fermeture des requêtes
    $stmt1->close();
    $stmt2->close();
}

// Fermeture de la connexion
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer vos compétences</title>
    <!-- Liens vers les bibliothèques CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>




 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            display: flex;
            align-items: center;
        }

        #logo img {
            width: 40px; /* Ajustez la taille de votre logo */
            height: auto;
            margin-right: 10px;
        }

        #logo h3 {
            margin: 0;
        }

        #main-menu {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #main-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        #main-menu li {
            margin: 0 15px;
        }

        #main-menu a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        #right-menu {
            display: flex;
            align-items: center;
        }

        #right-menu a {
            margin-right: 15px;
            text-decoration: none;
            color: #fff;
        }

        .button-primary {
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;

        }


        .file-label {
    position: relative;
    cursor: pointer;
}

.file-icon {
    font-size: 24px; /* Ajustez la taille selon vos préférences */
    display: inline-block;
}

.file-label:hover .file-icon::before {
    content: "Joindre votre fichier";
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    visibility: visible;
    opacity: 1;
    transition: visibility 0s, opacity 0.2s linear;
}

.file-label:hover .file-icon {
    opacity: 0.7;
}

    </style>



    <style type="text/css">


body {
    font-family: 'Helvetica', sans-serif;
}

.container {
    max-width: 600px;
}

form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}



.container {
    width: 50%;
    margin: 50px auto;
}

form {
    display: grid;
    gap: 10px;
}

label {
    font-weight: bold;
}

textarea {
    resize: vertical;
}




    </style>





<style type="text/css">
        /* Styles pour le conteneur principal */
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Styles pour le titre */
h2 {
    text-align: center;
    margin-bottom: 30px;
}

/* Styles pour les étiquettes */
label {
    font-weight: bold;
}

/* Styles pour les boutons */
.btn-primary,
.btn-success,
.btn-danger {
    margin-top: 20px;
    margin-right: 10px;
}

/* Styles pour les formulaires de compétences */
.skill {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    background-color: #fff;
}

/* Styles pour les boutons de suppression */
.removeSkill {
    margin-top: 20px;
}

/* Styles pour les notifications */
#response {
    margin-top: 20px;
    text-align: center;
}

/* Ajoutez ici d'autres styles personnalisés selon vos besoins */


    </style>
<body>



<div class="container">
    <h2>Déposer vos compétences</h2>
    <!-- Formulaire pour déposer les compétences -->
    <form id="skillsForm" method="post">
        <div id="skillsContainer">
            <div class="form-group">
                <label for="Nom">Nom :</label>
                <input type="text" class="form-control" name="Nom[]" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prenom :</label>
                <input type="text" class="form-control" name="prenom[]" required>
            </div>
            <div class="form-group">
                <label for="pays">Pays :</label>
                <input type="text" class="form-control" name="pays[]" placeholder="Séparez les outils par des virgules">
            </div>
            <div class="form-group">
                <label for="ville">Ville :</label>
                <input type="text" class="form-control" name="ville[]" placeholder="Séparez les outils par des virgules">
            </div>
            <div class="form-group">
                <label for="tel">Téléphone :</label>
                <input type="text" class="form-control" name="tel[]" placeholder="Séparez les outils par des virgules">
            </div>
            <div class="form-group">
                <label for="mail">Email :</label>
                <input type="email" class="form-control" name="mail[]" placeholder="Séparez les outils par des virgules">
            </div>
            <div class="form-group">
                <label for="agen">Avez vous une agence qui vous accompagne ? :</label>
                <select type="text" class="form-control" name="agen[]" placeholder="Séparez les outils par des virgules">
                <option>OUI</option>
                <option>NON</option>
                </select>
            </div>
            <div class="form-group">
                <label for="agent">Si oui entrez son Nom :</label>
                <input type="text" class="form-control" name="agent[]" placeholder="Séparez les outils par des virgules">
            </div>
            <!-- Formulaire de compétence par défaut -->
            <div class="skill">
                <div class="form-group">
                    <label for="skillTitle">Intitulé de la compétence :</label>
                    <input type="text" class="form-control" name="skillTitle[]" required>
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tools">Outils / Technologies :</label>
                    <input type="text" class="form-control" name="tools[]" placeholder="Séparez les outils par des virgules">
                </div>
                <div class="form-group">
                    <label for="references">Références :</label>
                    <textarea class="form-control" name="references[]" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-danger removeSkill">Supprimer</button>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="addSkill">Ajouter une compétence</button>
        <button type="submit" class="btn btn-success">Soumettre</button>
    </form>
    <!-- Div pour afficher les notifications -->
    <div id="response"></div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    // Fonction pour ajouter un formulaire de compétence
    $("#addSkill").click(function() {
        var newSkill = $(".skill:first").clone(); // Clone le premier formulaire de compétence
        newSkill.find("input, textarea").val(""); // Efface les valeurs des champs
        newSkill.find(".removeSkill").show(); // Affiche le bouton de suppression
        $("#skillsContainer").append(newSkill); // Ajoute le nouveau formulaire à la fin du conteneur
    });

    // Fonction pour supprimer un formulaire de compétence
    $(document).on("click", ".removeSkill", function() {
        $(this).closest(".skill").remove(); // Supprime le formulaire de compétence parent
    });
</script>
</body>
</html>
