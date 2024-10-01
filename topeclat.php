<?php
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

// Récupérer les utilisateurs
$query = "SELECT id, nom, prenom, telephone, prof AS role, profile_pic, compte, help2 FROM userss";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Récupérer les types de comptes distincts
$query_roles = "SELECT DISTINCT compte FROM userss";
$result_roles = $conn->query($query_roles);
$roles = $result_roles->fetch_all(MYSQLI_ASSOC);

// Gérer les requêtes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'getUser') {
        $id = intval($_POST['id']);
        $query = $conn->prepare("SELECT * FROM userss WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
        echo json_encode($user);
        exit;
    } elseif ($action === 'deleteUser') {
        $id = intval($_POST['id']);
        $query = $conn->prepare("DELETE FROM userss WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        echo "User deleted";
        exit;
    } elseif ($action === 'addUser') {
        $compte = $_POST['compte'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $prof = $_POST['prof'];
        $pays = $_POST['pays'];
        $Ville = $_POST['Ville'];
        $Profession = $_POST['Profession'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $Education = $_POST['Education'];
        $Competences = $_POST['Competences'];

        $query = $conn->prepare("INSERT INTO userss (compte, nom, prenom, prof, pays, Ville, Profession, email, telephone, password, Education, Competences, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'papa.jpg')");
        $query->bind_param("ssssssssssss", $compte, $nom, $prenom, $prof, $pays, $Ville, $Profession, $email, $telephone, $password, $Education, $Competences);
        $query->execute();
        echo "User added";
        exit;
    } elseif ($action === 'editUser') {
        $id = intval($_POST['id']);
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $telephone = $_POST['telephone'];
        $role = $_POST['role'];
        $query = $conn->prepare("UPDATE userss SET nom = ?, prenom = ?, telephone = ?, prof = ? WHERE id = ?");
        $query->bind_param("ssssi", $nom, $prenom, $telephone, $role, $id);
        $query->execute();
        echo "User updated";
        exit;
    } elseif ($action === 'activateUser') {
        $id = intval($_POST['id']);

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

    $code = generateRandomString(8);
    $sql = "UPDATE userss SET help = 'validé', help2 = '$code' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur activé avec succès";
    } else {
        echo "Erreur lors de l'activation de l'utilisateur : " . $conn->error;
    }
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répertoire personnel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
        body {
            background-image: url(ooo.avif);
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 18rem;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            height: 280px;
            object-fit: cover;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .badge {
            font-size: 0.9em;
        }
        .btn-custom {
            border-radius: 50px;
            padding: 10px 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-dark {
            background-color: #343a40;
            border: none;
        }
        .section {
            display: none;
        }
        .list-view .card {
            display: flex;
            flex-direction: row;
        }
        .list-view .card img {
            width: 100px;
            height: auto;
        }
        .list-view .card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>

</head>
<body>
<div  class="container">
    <h1 class="mt-4 text-center" style="color: white;">Répertoire Utilisateurs / Prospects</h1>
    <div class="row search-container">
        <div class="col-md-4">
            <div class="form-group">
                <label for="role" style="color: white;">Type de compte</label>
                <select id="role" class="form-control">
                    <option value="">Sélectionner</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars($role['compte']) ?>"><?= htmlspecialchars($role['compte']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="search">Recherche par mots-clés</label>
                <input type="text" id="search" class="form-control" placeholder="Recherche">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-4">
        <div>
            <button class="btn btn-primary btn-custom" onclick="viewCard()">Vue Carte</button>
            <button class="btn btn-secondary btn-custom" onclick="viewList()">Affichage en liste</button>
        </div>
        <div>
            <button class="btn btn-success btn-custom" onclick="showModal('addModal')">Ajouter du personnel</button>
            <button class="btn btn-warning btn-custom" onclick="filterUsers('prospects')">Prospects</button>
            <button class="btn btn-info btn-custom" onclick="filterUsers('utilisateurs')">Utilisateurs</button>
        </div>
    </div>
    <div style="width: 2000px; margin-left: -40%;" class="card-container" id="personnel-container">
        <?php foreach ($users as $user): ?>
        <div class="card" data-compte="<?= htmlspecialchars($user['compte'] ?? '') ?>" data-help2="<?= htmlspecialchars($user['help2'] ?? '') ?>">
            <img src="uploads/<?= htmlspecialchars($user['profile_pic'] ?? '') ?>" class="card-img-top" alt="Profile Image">
            <div class="card-body">
                <h2 class="card-text"><?= htmlspecialchars($user['compte'] ?? '') ?></h2>
                <h5 class="card-title"><?= htmlspecialchars($user['prenom'] ?? '') . ' ' . htmlspecialchars($user['nom'] ?? '') ?></h5>
                <p class="card-text"><?= htmlspecialchars($user['pays'] ?? '') ?></p>
                <p class="card-text"><?= htmlspecialchars($user['Ville'] ?? '') ?></p>
                <p class="card-text"><?= htmlspecialchars($user['prof'] ?? '') ?></p>
                <p class="card-text"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <p class="card-text"><?= htmlspecialchars($user['telephone'] ?? '') ?></p>
                <span class="badge badge-primary"><?= htmlspecialchars($user['role'] ?? '') ?></span>
                <div class="mt-3">
                    <button class="btn btn-info btn-sm" onclick="viewMore(<?= $user['id'] ?>)">Voir Plus</button>
                    <button class="btn btn-warning btn-sm" onclick="showModal('editModal', <?= $user['id'] ?>)">Modifier</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Supprimer</button>
                    <?php if (is_null($user['help2'])): ?>
                        <button class="btn btn-success btn-sm" onclick="activateUser(<?= $user['id'] ?>)">Activer</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Ajouter Personnel -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Ajouter d'un,uttilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="compte">Type de compte</label>
                            <select type="text" id="compte" name="compte" class="form-control" required>
                            <option>Employé</option>
                            <option>Agence</option>
                            <option>Agent</option>
                            <option>Candidat</option>
                            <option>Entreprise</option>
                            <option>Televendeur</option>
                            <option>Client</option>
                            <option>Marketing</option>

                            <option>Courtier immobilier</option>
                            <option>Entrepreneur</option>
                            <option>Hypothécaire</option>
                            <option>Commerçant</option>
                          </select>
                        </div>


                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="prof">Profession</label>
                            <input type="text" id="prof" name="prof" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pays">Pays</label>
                            <input type="text" id="pays" name="pays" class="form-control" required>
                        </div>

                            <label for="Ville">Ville</label>
                            <input type="text" id="Ville" name="Ville" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" id="telephone" name="telephone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="Profession">Spécialité</label>
                            <input type="text" id="Profession" name="Profession" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="Education">Education</label>
                            <input type="text" id="Education" name="Education" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="Competences">Competences</label>
                            <input type="text" id="Competences" name="Competences" class="form-control" required>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="addUser()">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Modifier Personnel -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modification de l'utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id">
                        <div class="form-group">
                            <label for="edit-nom">Nom</label>
                            <input type="text" id="edit-nom" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-prenom">Prénom</label>
                            <input type="text" id="edit-prenom" name="prenom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-telephone">Téléphone</label>
                            <input type="text" id="edit-telephone" name="telephone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-role">Rôle</label>
                            <input type="text" id="edit-role" name="role" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="editUser()">Modifier</button>
                    </form>
                </div>
            </div>
        </div>


    </div>


</div>
    <div class="table-container">
        <table style="background-color: white;" class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['nom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['prenom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['telephone'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['role'] ?? '') ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="viewMore(<?= $user['id'] ?>)">Voir Plus</button>
                        <button class="btn btn-warning btn-sm" onclick="showModal('editModal', <?= $user['id'] ?>)">Modifier</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Supprimer</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var keyword = $(this).val().toLowerCase();
            $('.card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1)
            });
        });

        $('#role').on('change', function() {
            var selectedRole = $(this).val();
            $('.card').filter(function() {
                $(this).toggle($(this).data('compte') === selectedRole || selectedRole === '')
            });
        });
    });

    function showModal(modalId, userId = null) {
        if (userId) {
            // Fetch and populate user data
            $.post('', {action: 'getUser', id: userId}, function(data) {
                var user = JSON.parse(data);
                $('#edit-id').val(user.id);
                $('#edit-nom').val(user.nom);
                $('#edit-prenom').val(user.prenom);
                $('#edit-telephone').val(user.telephone);
                $('#edit-role').val(user.prof);
            });
        }
        $('#' + modalId).modal('show');
    }

function addUser() {
    const formData = $('#addForm').serialize();
    $.post('', formData + '&action=addUser', function(response) {
        alert(response);
        location.reload();
    });
}

function editUser() {
    const formData = $('#editForm').serialize();
    $.post('', formData + '&action=editUser', function(response) {
        alert(response);
        location.reload();
    });
}

function deleteUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        $.post('', { action: 'deleteUser', id: userId }, function(response) {
            alert(response);
            location.reload();
        });
    }
}

    function activateUser(id) {
        $.post('', {action: 'activateUser', id: id}, function(response) {
            alert(response);
            location.reload();
        });
    }



    function filterUsers(type) {
        $('.card').filter(function() {
            if (type === 'prospects') {
                return $(this).data('help2') === '';
            } else if (type === 'utilisateurs') {
                return $(this).data('help2') !== '';
            }
            return false;
        }).toggle();
    }

            // Fonction pour voir plus de détails
            window.viewMore = function(id) {
                var url = 'plus.php?id=' + encodeURIComponent(id);
                var newWindow = window.open(url, '_blank', 'width=800,height=600');
                newWindow.focus();
            };

    function viewCard() {
        $('.card-container').show();
        $('.table-container').hide();
    }

    function viewList() {
        $('.card-container').hide();
        $('.table-container').show();
    }

    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var searchValue = $(this).val().toLowerCase();
            $('.card').each(function() {
                var name = $(this).find('.card-title').text().toLowerCase();
                $(this).toggle(name.indexOf(searchValue) > -1);
            });
        });

        $('#role').on('change', function() {
            var selectedRole = $(this).val().toLowerCase();
            $('.card').each(function() {
                var role = $(this).data('compte').toLowerCase();
                $(this).toggle(role.indexOf(selectedRole) > -1 || selectedRole === '');
            });
        });
    });
</script>
</body>
</html>
