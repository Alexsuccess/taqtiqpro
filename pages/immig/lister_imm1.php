<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fonction pour générer une chaîne aléatoire
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Vérifier si l'e-mail est reçu pour activation
if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'activate') {
    $id = $_POST['id'];
    $code = generateRandomString(8);
    $sql = "UPDATE userss SET help = 'validé', help2 = '$code' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur activé avec succès";
    } else {
        echo "Erreur lors de l'activation de l'utilisateur : " . $conn->error;
    }
    $conn->close();
    exit();
}

// Vérifier si l'e-mail est reçu pour suppression
if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM userss WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur supprimé avec succès";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
    }
    $conn->close();
    exit();
}

// Vérifier si les données de modification sont reçues
if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $telephone = $_POST['telephone'];
    $profession = $_POST['profession'];
    $accompagne = $_POST['accompagne'];
    $sql = "UPDATE userss SET nom = '$nom', prenom = '$prenom', pays = '$pays', telephone = '$telephone', Profession = '$profession', accompagne = '$accompagne' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur modifié avec succès";
    } else {
        echo "Erreur lors de la modification de l'utilisateur : " . $conn->error;
    }
    $conn->close();
    exit();
}

// Obtenir les comptes de comptes distincts
$sql_comptes = "SELECT DISTINCT compte FROM userss WHERE compte IS NOT NULL AND help2 IS NOT NULL";
$result_comptes = $conn->query($sql_comptes);

$comptes = [];
if ($result_comptes->num_rows > 0) {
    while ($row = $result_comptes->fetch_assoc()) {
        $comptes[] = $row['compte'];
    }
}

// Tableau associant les comptes de comptes à leurs initiales
$compte_labels = [
    'Client' => 'Candidat',
    'Prestataire' => 'Entreprise',
    'Modérateur' => 'Administrateur',
    // Ajoutez d'autres mappings si nécessaire
];

// Tableau associant les comptes de comptes à leurs initiales
$compte_initials = [
    'Candidat' => 'CAN',
    'Candidat_izishop' => 'CANIZI',
    'Client_izishop' => 'CLIZI',
    'Entreprise' => 'ENT',
    'Employé' => 'EMP',
    'Televendeur' => 'TEL',
    'Agence de Marketing' => 'Mark',
    'Administrateur' => 'ADM',
    // Ajoutez d'autres comptes de comptes ici
];

// Fonction pour échapper les valeurs et éviter les erreurs de dépréciation
function safe_htmlspecialchars($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>Utilisateurs ayant postulé</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type="text/css">
        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"] {
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
    <h1  style="color: green; font-size: 55px;">Utilisateurs</h1>

    <?php foreach ($comptes as $compte): ?>
        <?php
        // Utilisation du mapping pour obtenir le libellé à afficher
        $display_compte = isset($compte_labels[$compte]) ? $compte_labels[$compte] : $compte;
        
        // Requête pour récupérer les utilisateurs de chaque compte
        $sql_users = "SELECT * FROM userss WHERE compte = '$compte' AND help2 IS NOT NULL";
        $result_users = $conn->query($sql_users);
        ?>
        <h2><?= safe_htmlspecialchars($display_compte) ?></h2><br>
        <input type="text" id="searchInput_<?= safe_htmlspecialchars($compte) ?>" onkeyup="searchTable('<?= safe_htmlspecialchars($compte) ?>')" placeholder="Rechercher dans <?= safe_htmlspecialchars($display_compte) ?>...">
        <table id="table_<?= safe_htmlspecialchars($compte) ?>">
            <thead>
                <tr>
                    <th style="color: black;">Code candidat</th>
                     <th style="color: black;">Catégories</th>
                    <th style="color: black;">Nom</th>
                    <th style="color: black;">Prénom</th>
                    <th style="color: black;">Pays</th>
                    <th style="color: black;">Ville</th>
                    <th style="color: black;">Email</th>
                     <th style="color: black;">Code régional</th>
                    <th style="color: black;">Téléphone</th>
                    <th style="color: black;">Profession</th>
                    <th style="color: black;">agent / agence</th>
                    <th style="color: black;">Département</th>
                    <th style="color: black;">Photo de profil</th>
                    <th style="color: black;">Statut</th>
                    <th style="color: black;">Code</th>
                    <th style="color: black;">Date de création</th>
                    <th style="color: black;">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_users->num_rows > 0): ?>
                    <?php while($row = $result_users->fetch_assoc()): ?>
                        <?php
                        // Obtenir l'initial correspondant au compte de compte
                        $initial = isset($compte_initials[$display_compte]) ? $compte_initials[$display_compte] : 'UNK';
                        
                        // Générer l'identifiant en combinant l'initial avec l'ID utilisateur
                        $user_id = $initial . sprintf('%03d', $row["id"]);
                        ?>
<tr data-id="<?= safe_htmlspecialchars($row["id"]) ?>">
    <td class="user_id" style="color: black;"><?= safe_htmlspecialchars($user_id) ?></td>
    <td class="prof" style="color: black;"><?= safe_htmlspecialchars($row["prof"]) ?></td>
    <td class="nom" style="color: black;"><?= safe_htmlspecialchars($row["nom"]) ?></td>
    <td class="prenom" style="color: black;"><?= safe_htmlspecialchars($row["prenom"]) ?></td>
    <td class="pays" style="color: black;"><?= safe_htmlspecialchars($row["pays"]) ?></td>
    <td class="pays" style="color: black;"><?= safe_htmlspecialchars($row["Ville"]) ?></td>
    <td class="email" style="color: black;"><a style="color: black;" href='mailto:<?= safe_htmlspecialchars($row["email"]) ?>'><?= safe_htmlspecialchars($row["email"]) ?></a></td>
    <td class="codee" style="color: black;"><?= safe_htmlspecialchars($row["codee"]) ?></td>
    <td class="telephone" style="color: black;"><?= safe_htmlspecialchars($row["telephone"]) ?></td>
    <td class="profession" style="color: black;"><?= safe_htmlspecialchars($row["Profession"]) ?></td>
    <td class="accompagne" style="color: black;"><?= safe_htmlspecialchars($row["accompagne"]) ?></td>
    <td class="dep" style="color: black;"><?= safe_htmlspecialchars($row["dep"]) ?></td>
    <td class="profile_pic" style="color: black;"><img src='uploads/<?= safe_htmlspecialchars($row["profile_pic"]) ?>' alt='Profile Image' style='width: 50px; height: 50px;'></td>
    <td class="help" style="color: black;"><?= safe_htmlspecialchars($row["help"]) ?></td>
    <td class="help2" style="color: black;"><?= safe_htmlspecialchars($row["help2"]) ?></td>
    <td class="created_at" style="color: black;"><?= safe_htmlspecialchars($row["created_at"]) ?></td>
    <td class="options" style="color: black;">
        <button onclick='valider("<?= safe_htmlspecialchars($row["id"]) ?>")'>Changer</button>
        <button style="background-color: blue;" onclick='validerxx("<?= safe_htmlspecialchars($row["id"]) ?>")'>Modifier</button>
        <button style="background-color: red;" onclick='validerx("<?= safe_htmlspecialchars($row["id"]) ?>")'>Supprimer</button>
    </td>
</tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan='11'>Aucun utilisateur trouvé pour ce compte de compte</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>


    <!-- Modal de modification -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier l'utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" onsubmit="event.preventDefault(); submitEditForm();">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" name="nom">
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom:</label>
                            <input type="text" class="form-control" name="prenom">
                        </div>
                        <div class="form-group">
                            <label for="pays">Pays:</label>
                            <input type="text" class="form-control" name="pays">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone:</label>
                            <input type="text" class="form-control" name="telephone">
                        </div>
                        <div class="form-group">
                            <label for="profession">Profession:</label>
                            <input type="text" class="form-control" name="profession">
                        </div>
                        <div class="form-group">
                            <label for="accompagne">Accompagné:</label>
                            <input type="text" class="form-control" name="accompagne">
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <script>
        // Fonction pour activer un utilisateur
        function valider(id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Utilisateur activé avec succès !");
                    location.reload();
                }
            };
            xhr.send("id=" + id + "&action=activate");
        }

        // Fonction pour supprimer un utilisateur
        function validerx(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert("Utilisateur supprimé avec succès !");
                        location.reload();
                    }
                };
                xhr.send("id=" + id + "&action=delete");
            }
        }

        // Fonction pour modifier un utilisateur
// Fonction pour modifier un utilisateur
function validerxx(id) {
    // Obtenir les données de l'utilisateur à partir des champs de la ligne du tableau
    var row = document.querySelector("tr[data-id='" + id + "']");
    var nom = row.querySelector(".nom").textContent;
    var prenom = row.querySelector(".prenom").textContent;
    var pays = row.querySelector(".pays").textContent;
    var telephone = row.querySelector(".telephone").textContent;
    var profession = row.querySelector(".profession").textContent;
    var accompagne = row.querySelector(".accompagne").textContent;

    // Remplir le formulaire de modification avec les valeurs actuelles
    var form = document.getElementById("editForm");
    form.id.value = id;
    form.nom.value = nom;
    form.prenom.value = prenom;
    form.pays.value = pays;
    form.telephone.value = telephone;
    form.profession.value = profession;
    form.accompagne.value = accompagne;

    // Afficher le modal
    $('#editModal').modal('show');
}


        // Fonction pour soumettre le formulaire de modification
        function submitEditForm() {
            var form = document.getElementById("editForm");
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Utilisateur modifié avec succès !");
                    location.reload();
                }
            };
            var data = "id=" + form.id.value +
                       "&nom=" + form.nom.value +
                       "&prenom=" + form.prenom.value +
                       "&pays=" + form.pays.value +
                       "&telephone=" + form.telephone.value +
                       "&profession=" + form.profession.value +
                       "&accompagne=" + form.accompagne.value +
                       "&action=edit";
            xhr.send(data);
        }

        // Fonction de recherche dans la table
        function searchTable(compte) {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput_" + compte);
            filter = input.value.toUpperCase();
            table = document.getElementById("table_" + compte);
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

    </script></body>
</html>
