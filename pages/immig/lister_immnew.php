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
$sql_comptes = "SELECT DISTINCT compte FROM userss WHERE compte IS NOT NULL AND help2 IS NULL";
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
 <h1 style="color: red; font-size: 55px;">Prospects</h1>

    <?php foreach ($comptes as $compte): ?>
        <?php
        // Utilisation du mapping pour obtenir le libellé à afficher
        $display_compte = isset($compte_labels[$compte]) ? $compte_labels[$compte] : $compte;
        
        // Requête pour récupérer les utilisateurs de chaque compte
        $sql_users = "SELECT * FROM userss WHERE compte = '$compte' AND help2 IS NULL";
        $result_users = $conn->query($sql_users);
        ?>
        <h2><?= safe_htmlspecialchars($display_compte) ?></h2><br>
        <input type="text" id="searchInput_<?= safe_htmlspecialchars($compte) ?>" onkeyup="searchTable('<?= safe_htmlspecialchars($compte) ?>')" placeholder="Rechercher dans <?= safe_htmlspecialchars($display_compte) ?>...">
        <table id="table_<?= safe_htmlspecialchars($compte) ?>">
            <thead>
                <tr>
                    <th>Code candidat</th>
                    <th>Catégorie</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Code régional</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Profession</th>
                    <th>agent / agence</th>
                    <th>Département</th>
                    <th>Date de création</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM userss WHERE compte = '$compte' AND help2 IS NULL";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-id='" . safe_htmlspecialchars($row['id']) . "'>";
                        echo "<td class='id'>CAND00" . safe_htmlspecialchars($row['id']) . "</td>";
                        echo "<td class='prof'>" . safe_htmlspecialchars($row['prof']) . "</td>";
                        echo "<td class='nom'>" . safe_htmlspecialchars($row['nom']) . "</td>";
                        echo "<td class='prenom'>" . safe_htmlspecialchars($row['prenom']) . "</td>";
                        echo "<td class='pays'>" . safe_htmlspecialchars($row['pays']) . "</td>";
                         echo "<td class='Ville'>" . safe_htmlspecialchars($row['Ville']) . "</td>";
                         echo "<td class='codee'>" . safe_htmlspecialchars($row['codee']) . "</td>";
                        echo "<td class='telephone'>" . safe_htmlspecialchars($row['telephone']) . "</td>";
                        echo "<td>" . safe_htmlspecialchars($row['email']) . "</td>";
                        echo "<td class='profession'>" . safe_htmlspecialchars($row['Profession']) . "</td>";
                        echo "<td class='accompagne'>" . safe_htmlspecialchars($row['accompagne']) . "</td>";
                        echo "<td class='dep'>" . safe_htmlspecialchars($row['dep']) . "</td>";
                        echo "<td class='created_at'>" . safe_htmlspecialchars($row['created_at']) . "</td>";
                        echo "<td><button style='background-color: green;' onclick=\"valider('" . safe_htmlspecialchars($row['id']) . "')\">Activer</button>
                                  <button style='background-color: red;' onclick=\"validerx('" . safe_htmlspecialchars($row['id']) . "')\">Supprimer</button>
                                  <button style='background-color: blue;' onclick=\"validerxx('" . safe_htmlspecialchars($row['id']) . "')\">Modifier</button></td>";
                        echo "</tr>";
                    }
                }
                ?>
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


    </script>