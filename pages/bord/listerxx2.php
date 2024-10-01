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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "enregistrer_appel") {

    // Récupération et nettoyage des données du formulaire
    $date_appel = htmlspecialchars($_POST['date_appel']);
    $heure_appel = htmlspecialchars($_POST['heure_appel']);
    $status = htmlspecialchars($_POST['status']);
    $a_qui_parle = htmlspecialchars($_POST['a_qui_parle']);
    $tache = htmlspecialchars($_POST['tache']);
    $raison_appel = htmlspecialchars($_POST['raison_appel']);
    $campagne = htmlspecialchars($_POST['campagne']);
    $rendez_vous_date = htmlspecialchars($_POST['rendez_vous_date']);
    $rendez_vous_heure = htmlspecialchars($_POST['rendez_vous_heure']);
    $personne_id = htmlspecialchars($_POST['personne_id']); // Récupération de l'ID de la personne

    // Préparation de la requête SQL avec des paramètres sécurisés (préparée)
    $sql = "INSERT INTO appels_telephoniques (personne_id, telephoniste, date_appel, heure_appel, status, a_qui_parle, tache, raison_appel, campagne, rendez_vous_date, rendez_vous_heure, user_id)
            VALUES (?, '1', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Préparation de la requête SQL avec une instruction préparée
    $statement = $conn->prepare($sql);
    if ($statement === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $statement->bind_param("isssssssssi", $personne_id, $date_appel, $heure_appel, $status, $a_qui_parle, $tache, $raison_appel, $campagne, $rendez_vous_date, $rendez_vous_heure, $userId);

    // Exécution de la requête SQL préparée
    if ($statement->execute()) {
        echo "L'enregistrement a été ajouté avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $statement->error;
    }

    // Fermeture du statement et de la connexion
    $statement->close();
    $conn->close();
} else {
    // Si le formulaire n'a pas été soumis via POST ou si l'action n'est pas définie, afficher un message d'erreur ou rediriger si nécessaire
    echo "";
}
?>
















<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

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

// Fonction pour exécuter une requête SQL et récupérer les résultats
function executeSQLQuery($sql, $conn) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur dans la requête SQL: " . $conn->error);
    }
    return $result;
}

// Types de comptes à afficher
$typesComptes = ['client', 'prestataire', 'candidat' , 'Entreprise'];

// Requête pour récupérer les destinataires (télévendeurs ou employés)
$sqlDestinataires = "SELECT id, nom, prenom FROM userss WHERE compte IN ('télévendeur', 'Employé')";
$resultDestinataires = executeSQLQuery($sqlDestinataires, $conn);
$destinataires = [];
if ($resultDestinataires->num_rows > 0) {
    while ($row = $resultDestinataires->fetch_assoc()) {
        $destinataires[] = $row;
    }
}

// Traitement de la mise à jour des données sélectionnées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['destinataire']) && isset($_POST['utilisateurs'])) {
        $destinataire = $_POST['destinataire'];
        $utilisateurs = json_decode($_POST['utilisateurs']);

        // Validation des données (à compléter selon vos besoins)

        // Préparation de la requête d'update
        $sql = "UPDATE utilisateurs_destinataires SET id_utilisateur = ? WHERE id_destinataire = ?";
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres et exécution de la requête pour chaque utilisateur sélectionné
        foreach ($utilisateurs as $userId) {
            $stmt->bind_param("ii", $destinataire, $userId);
            $stmt->execute();
        }

        // Fermeture du statement
        $stmt->close();

        // Réponse à renvoyer en cas de succès (à adapter selon vos besoins)
        echo "Action OK !";
    } else {
        // Gérer le cas où les données requises ne sont pas reçues
        echo "";
    }

    // Terminer le script PHP après le traitement POST
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>

<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "Accès non autorisé";
    exit();
}

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

// Vérifier si les données nécessaires sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId']) && isset($_POST['newStatus'])) {
    $userId = intval($_POST['userId']);
    $newStatus = intval($_POST['newStatus']);

    // Préparer la requête de mise à jour
    $stmt = $conn->prepare("UPDATE userss SET statut = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $userId);

    if ($stmt->execute()) {
        echo "Statut mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour du statut: " . $conn->error;
    }

    // Fermeture du statement
    $stmt->close();
} else {
    echo "";
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgb(0,0,64);
            color: white;
        }

        .options {
            display: flex;
            align-items: center;
        }

        .options button {
            margin-right: 10px;
            padding: 8px 15px;
            background-color: rgb(0,0,64);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .options button:hover {
            background-color: blue;
        }

        /* Styles pour la modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .user-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .user-item {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1 style="color: blue; margin-left: 20%;"> Gestion d'Assignation</h1><br>
    <div class="container">
        <?php
        foreach ($typesComptes as $typeCompte) {
            $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT dd.id, dd.compte, dd.help2, dd.nom, dd.prenom, dd.email, dd.telephone, dd.statut, dest.nom as destinataire_nom, dest.prenom as destinataire_prenom 
                FROM userss as dd 
                LEFT JOIN utilisateurs_destinataires as ud ON dd.id = ud.id_destinataire 
                LEFT JOIN userss as dest ON ud.id_utilisateur = dest.id 
                WHERE dd.compte = '$typeCompte' and ud.id_utilisateur = $userId ";
            $result = executeSQLQuery($sql, $conn);

            echo "<h2>" . ucfirst($typeCompte) . "s</h2>";
            echo "<table style='margin-left : -10%;'>";
            echo "<tr>";
            echo "<th>Nom</th>";
            echo "<th>Prénom</th>";
            echo "<th>Email</th>";
            echo "<th>Téléphone</th>";
            echo "<th>Confié à</th>";
            echo "<th>Confier à</th>";
             echo "<th>Option à</th>";
           
            echo "</tr>";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $statut = isset($row['statut']) ? $row['statut'] : 0;
                    $nomDestinataire = $row['destinataire_nom'] ? $row['destinataire_nom'] . ' ' . $row['destinataire_prenom'] : 'Non confié';
                    echo "<tr>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['telephone'] . "</td>";
                    echo "<td>" . $nomDestinataire . "</td>";
                    echo "<td class='confier-cell'>";
                    echo "<input type='checkbox' class='confier-checkbox' data-user-id='" . $row['id'] . "' name='confier[]'>";
                    echo '<td><button onclick="openGestionModal(' . $row['id'] . ', \'' . $row['nom'] . '\')">Gestion</button></td>';


                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aucun résultat trouvé.</td></tr>";
            }

            echo "</table>";

            $conn->close();
        }
        ?>






        <?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insertion d'un nouvel appel
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telephoniste_id = $_POST['telephoniste'];
    $date_appel = $_POST['date_appel'];
    $heure_appel = $_POST['heure_appel'];
    $status = $_POST['status'];
    $a_qui_parle = $_POST['a_qui_parle'];
    $tache = $_POST['tache'];
    $raison_appel = $_POST['raison_appel'];
    $campagne = $_POST['campagne'];
    $rendez_vous_date = $_POST['rendez_vous_date'];
    $rendez_vous_heure = $_POST['rendez_vous_heure'];

    // Préparation de la requête SQL d'insertion
    $sql = "INSERT INTO appels (telephoniste_id, date_appel, heure_appel, status, a_qui_parle, tache, raison_appel, campagne, rendez_vous_date, rendez_vous_heure)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $telephoniste_id, $date_appel, $heure_appel, $status, $a_qui_parle, $tache, $raison_appel, $campagne, $rendez_vous_date, $rendez_vous_heure);
    
    if ($stmt->execute()) {
        echo "Appel enregistré avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de l'appel: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

    </div>

    <!-- Modal pour confier l'utilisateur -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <h2>Assigner à:</h2>
                <form id="confierForm" method="post">
                    <input type="hidden" id="utilisateursSelectionnes" name="utilisateurs">
                    <select id="destinataire" name="destinataire">
                        <option value="">Choisir un destinataire</option>
                        <?php foreach ($destinataires as $destinataire) : ?>
                            <option value="<?php echo $destinataire['id']; ?>"><?php echo $destinataire['nom'] . ' ' . $destinataire['prenom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="user-list">
                        <!-- Liste des utilisateurs sélectionnés -->
                    </div>
                    <button type="submit" id="confirmConfier">Confirmer</button>
                </form>
            </div>
        </div>
    </div>



    <style>

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select {
            width: calc(100% - 2px); /* Adjust for border width */
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        br {
            clear: both;
        }
    </style>




<!-- Ajoutez ceci dans votre balise body après la fin de votre tableau -->
<div id="gestionModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeGestionModal()">&times;</span>
        <div class="modal-body"><br>
            <h5 id="modal-title" class="modal-title" style="color: red;">Gestion de <?php echo $nom; ?></h5>
           
            <h1>Enregistrer un nouvel appel</h1>
    <form action="" method="POST">
        <input type="hidden" name="personne_id" id="personne_id" value="">
       
        <label for="date_appel">Date de l'appel :</label><br>
        <input type="date" name="date_appel" id="date_appel" required><br><br>

        <label for="heure_appel">Heure de l'appel :</label><br>
        <input type="time" name="heure_appel" id="heure_appel" required><br><br>

        <label for="status">Statut de l'appel :</label><br>
        <select name="status" id="status">
            <option value="Occupé">Occupé</option>
            <option value="Pas de réponse">Pas de réponse</option>
            <option value="Boite vocale">Boite vocale</option>
            <option value="Message vocal">Message vocal</option>
            <option value="Message direct">Message direct</option>
            <option value="Demande un retour d’appel">Demande un retour d’appel</option>
        </select><br><br>

        <label for="a_qui_parle">À qui ai-je parlé :</label><br>
        <input type="text" name="a_qui_parle" id="a_qui_parle"><br><br>

        <label for="tache">Tâche :</label><br>
        <select name="tache" id="tache">
            <option value="A faire">A faire</option>
            <option value="Courriel à envoyer">Courriel à envoyer</option>
            <option value="Rencontre en personne">Rencontre en personne</option>
            <option value="À rappeler">À rappeler</option>
            <option value="À Assigner">À Assigner</option>
        </select><br><br>

        <label for="raison_appel">Raison de l’appel :</label><br>
        <select name="raison_appel" id="raison_appel">
            <optgroup label="Campagne de démarchage">
                <option value="Emploi">Emploi</option>
                <option value="Sollicitation">Sollicitation</option>
                <option value="Hockey">Hockey</option>
                <option value="Déneigement">Déneigement</option>
                <option value="Assurances">Assurances</option>
                <option value="Partenaire">Partenaire</option>
                <option value="Client">Client</option>
            </optgroup>
            <optgroup label="Autres raisons">
                <option value="Marketing">Marketing</option>
                <option value="E-commerce">E-commerce</option>
                <option value="Comptabilité">Comptabilité</option>
                <option value="Administration">Administration</option>
                <option value="Partenariat">Partenariat</option>
            </optgroup>
        </select><br><br>

        <label for="campagne">Campagne :</label><br>
        <input type="text" name="campagne" id="campagne"><br><br>

        <label for="rendez_vous_date">Date du rendez-vous :</label><br>
        <input type="date" name="rendez_vous_date" id="rendez_vous_date"><br><br>

        <label for="rendez_vous_heure">Heure du rendez-vous :</label><br>
        <input type="time" name="rendez_vous_heure" id="rendez_vous_heure"><br><br>

        <button type="submit" name="action" value="enregistrer_appel">Enregistrer l'appel</button>
    </form>
        </div>
    </div>
</div>

<script>
    // Fonction pour ouvrir la modal de gestion
    // Fonction pour ouvrir la modal de gestion
function openGestionModal(id, nom) {
    // Mettez à jour le contenu du modal avec le nom et l'ID corrects
    document.getElementById('gestionModal').style.display = 'block';
    document.getElementById('modal-title').textContent = 'Gestion de ' + nom;
    document.getElementById('personne_id').value = id; // Mettez à jour l'ID de la personne dans le champ caché
}


function closeGestionModal() {
    document.getElementById('gestionModal').style.display = 'none';
}


    // Fonction pour fermer la modal en cliquant sur la croix
    var close = document.getElementsByClassName("close")[0];
    close.onclick = function() {
        modal.style.display = "none";
    }
</script>



<script>
    // JavaScript pour basculer le statut Activer/Désactiver
    var toggleButtons = document.querySelectorAll('.toggle-status');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-user-id');
            var currentStatus = parseInt(this.getAttribute('data-current-status'));

            // Inverser le statut actuel
            var newStatus = (currentStatus === 1) ? 0 : 1;

            // Envoyer la requête AJAX pour mettre à jour le statut
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // Adapter le chemin du script de mise à jour
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Afficher la réponse du serveur (facultatif)
                        // Mettre à jour le texte du bouton et le statut
                        if (newStatus === 1) {
                            button.textContent = "Désactiver";
                            button.setAttribute('data-current-status', '1');
                        } else {
                            button.textContent = "Activer";
                            button.setAttribute('data-current-status', '0');
                        }
                    } else {
                        console.error("Erreur lors de la requête: " + xhr.status);
                    }
                }
            };

            // Préparer les données à envoyer
            var formData = "userId=" + encodeURIComponent(userId) + "&newStatus=" + encodeURIComponent(newStatus);
            xhr.send(formData);
        });
    });

    // Modal JavaScript
    var modal = document.getElementById("myModal");
    var btnsConfier = document.querySelectorAll('.confier-checkbox');
    var span = document.getElementsByClassName("close")[0];
    var form = document.getElementById("confierForm");

    // Ouvrir la modal lorsqu'un checkbox est coché
    for (var i = 0; i < btnsConfier.length; i++) {
        btnsConfier[i].addEventListener('change', function() {
            var checkedUsers = document.querySelectorAll('.confier-checkbox:checked');
            if (checkedUsers.length > 0) {
                modal.style.display = "block";
                // Mettre à jour les utilisateurs sélectionnés dans le champ caché
                var selectedUserIds = Array.from(checkedUsers).map(cb => cb.getAttribute('data-user-id'));
                document.getElementById("utilisateursSelectionnes").value = JSON.stringify(selectedUserIds);
            } else {
                modal.style.display = "none";
            }
        });
    }

    // Fermer la modal lorsque l'utilisateur clique sur ×
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Fermer la modal lorsque l'utilisateur clique en dehors de la modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Soumettre le formulaire lorsque l'utilisateur confirme la confiance
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher la soumission par défaut

        var destinataire = document.getElementById("destinataire").value;
        var checkedUsers = document.querySelectorAll('.confier-checkbox:checked');
        var userIds = Array.from(checkedUsers).map(cb => cb.getAttribute('data-user-id'));

        // Vérifier si un destinataire a été sélectionné
        if (destinataire === "") {
            alert("Veuillez choisir un destinataire.");
            return;
        }

        // Vérifier si des utilisateurs ont été sélectionnés
        if (userIds.length === 0) {
            alert("Veuillez sélectionner au moins un utilisateur à confier.");
            return;
        }

        // Envoi des données au serveur via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText); // Afficher la réponse du serveur (facultatif)
                    // Vous pouvez ajouter ici du code pour gérer la réponse, par exemple actualiser la page ou afficher un message à l'utilisateur
                } else {
                    console.error("Erreur lors de la requête: " + xhr.status);
                }
            }
        };

        // Préparer les données à envoyer
        var formData = "destinataire=" + encodeURIComponent(destinataire) + "&utilisateurs=" + encodeURIComponent(JSON.stringify(userIds));
        xhr.send(formData);

        // Fermer la modal après traitement
        modal.style.display = "none";
    });
</script>
</body>
</html>
