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
$user_id = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    $upload_directory = 'uploads/';
    $filename = time() . '_' . basename($file['name']);
    $target_file = $upload_directory . $filename;

    // Vérifiez si le fichier est une image
    $check = getimagesize($file['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $sql = "UPDATE userss SET profile_pic = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('si', $filename, $user_id);
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['filename'] = $filename;
                } else {
                    $response['error'] = 'Erreur lors de la mise à jour de la base de données.';
                }
                $stmt->close();
            } else {
                $response['error'] = 'Erreur lors de la préparation de la requête.';
            }
        } else {
            $response['error'] = 'Erreur lors du téléchargement du fichier.';
        }
    } else {
        $response['error'] = 'Le fichier n\'est pas une image valide.';
    }
} else {
    
}



$conn->close();
?>




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

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérez les informations de l'utilisateur
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $email = $row['email'];
    $profile_pic = $row['profile_pic'];
    $pays = $row['pays'];
    $telephone = $row['telephone'];
} else {
    $nom = "Utilisateur inconnu";
}

// Vérifier si la requête POST a été soumise
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs du formulaire sont définis
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['Localisation'], $_POST['Education'], $_POST['Competences'])) {
        
        // Récupérer les valeurs du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $Profession = $_POST['Profession'];
        $Localisation = $_POST['Localisation'];
        $Education = $_POST['Education'];
        $Competences = $_POST['Competences'];

        // Gérer le téléchargement de la nouvelle photo de profil
        $target_dir = "uploads/cv/";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Renommer le fichier avec un nom unique pour éviter les conflits
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
        $profile_pic = basename($target_file); // Nouveau nom unique pour le fichier

        // Vérifier si le répertoire de destination existe sinon le créer
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Enregistrer le fichier téléchargé
        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["cv"]["name"])) . " a été téléchargé.";
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }

        // Préparer la requête SQL pour mettre à jour les informations de l'utilisateur
        $sql = "UPDATE userss SET nom=?, prenom=?, email=?, telephone=?, Profession=?, Localisation=?, Education=?, Competences=?, profile_pic=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $nom, $prenom, $email, $telephone, $Profession, $Localisation, $Education, $Competences, $profile_pic, $userId);
        
        // Exécuter la requête
        if ($stmt->execute()) {
            // Rediriger vers la page de profil avec un message de succès
            echo '<script>window.location.href = "acceuil.php?success=1";</script>';
            exit();
        } else {
            echo "Erreur lors de la mise à jour des informations de l'utilisateur.";
        }

        // Fermer la connexion à la base de données
        $stmt->close();
    } else {
        echo "Tous les champs du formulaire doivent être définis.";
    }
}

// Récupérer les informations de l'utilisateur depuis la base de données
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // L'utilisateur existe, récupérer ses informations
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $email = $row['email'];
    $telephone = $row['telephone'];
    $profile_pic = $row['profile_pic'];
    $pays = $row['pays'];
    $Localisation = $row['Localisation'];
    $Profession = $row['Profession'];
    $Education = $row['Education'];
    $Competences = $row['Competences'];
} else {
    // L'utilisateur n'existe pas, rediriger vers la page de connexion
    header("Location: acceuil.php");
    exit();
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>



    <?php
// Démarrez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Récupérez l'ID de l'utilisateur
$userId = $_SESSION['id'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs du formulaire sont définis
    if (isset($_POST['OldPassword']) && isset($_POST['NewPassword']) && isset($_POST['NewPasswordConfirm'])) {
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

        // Récupérer l'ancien mot de passe de la base de données
        $sql = "SELECT password FROM userss WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldPasswordHash = $row['password'];

            // Vérifier si l'ancien mot de passe correspond
            if (password_verify($_POST['OldPassword'], $oldPasswordHash)) {
                // Vérifier si les nouveaux mots de passe correspondent
                if ($_POST['NewPassword'] === $_POST['NewPasswordConfirm']) {
                    // Mettre à jour le mot de passe dans la base de données
                    $newPasswordHash = password_hash($_POST['NewPassword'], PASSWORD_DEFAULT);
            // Nouveau mot de passe non haché
            $newPassword = $_POST['NewPassword'];
            // Mettre à jour le mot de passe dans la base de données
            $updateSql = "UPDATE userss SET password = ?, help = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ssi", $newPasswordHash, $newPassword, $userId);

                    if ($updateStmt->execute()) {
                        echo "Le mot de passe a été mis à jour avec succès.";
                        echo '<script>window.location.href = "acceuil.php?success=1";</script>';
                        exit(); // Arrêter l'exécution du script après la redirection
                    } else {
                        echo "Erreur lors de la mise à jour du mot de passe.";
                    }
                    $updateStmt->close();
                } else {
                    echo "Les nouveaux mots de passe ne correspondent pas.";
                }
            } else {
                echo "L'ancien mot de passe est incorrect.";
            }
        } else {
            echo "Utilisateur introuvable.";
        }

        // Fermer la connexion à la base de données
        $stmt->close();
        $conn->close();
    } else {
        echo "Tous les champs du formulaire doivent être définis.";
    }
}
?>
    <style>
        .rounded-circle {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ccc;
        }

        .edit-icon {
            cursor: pointer;
            font-size: 18px;
            color: #333;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
<style type="text/css">

.tab-pane {
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin: 20px auto;
    max-width: 800px;
}

.card-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.small {
    font-size: 14px;
    color: #666;
}

.row {
    display: flex;
    margin-bottom: 15px;
}

.label {
    font-weight: bold;
    color: #333;
}

.col-lg-3, .col-md-4 {
    flex: 0 0 25%;
    max-width: 25%;
    padding-right: 10px;
    box-sizing: border-box;
}

.col-lg-9, .col-md-8 {
    flex: 0 0 75%;
    max-width: 75%;
    padding-left: 10px;
    box-sizing: border-box;
}

a {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>
    <div class="pagetitle">
      <h1>Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

        <img src="uploads/<?php echo $row['profile_pic']; ?>" onclick="openModal('<?php echo $row['profile_pic']; ?>')" style="cursor: pointer;" alt="Profile" class="rounded-circle" id="profile-picture">
        <input type="file" id="profile-photo-input" style="display: none;" onchange="updateProfilePhoto(this)">
        <div class="edit-icon" onclick="chooseNewCoverPhoto()">✎</div>

              <h5><?php echo $prenom; ?>  <?php echo $nom; ?></h5><br>
              <h6><?php echo $Profession; ?></h6>
                                <p style="text-align: center;"><?php echo $email; ?></p>
                                <p style="text-align: center;">Téléphone : <?php echo $telephone; ?></p>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Vos Informations</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le Profil</button>
                </li>


                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

    <div class="tab-pane fade show active profile-overview" id="profile-overview">
        <h5 class="card-title">A propos de vous</h5>
        <p class="small fst-italic">Avant de procéder à toute modification de vos informations personnelles ou de votre mot de passe, veuillez prendre quelques instants pour vérifier attentivement les détails que vous avez saisis. Assurez-vous que les informations sont correctes et à jour. De plus, veuillez choisir un mot de passe sécurisé, comportant des caractères alphanumériques et des symboles spéciaux, pour garantir la sécurité de votre compte. Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter. Merci pour votre attention.</p><br>

        <h5 class="card-title">Details du Profil</h5>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Nom et prénom</div>
            <div class="col-lg-9 col-md-8"><?php echo $prenom; ?> <?php echo $nom; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Profession</div>
            <div class="col-lg-9 col-md-8"><?php echo $Profession; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Email</div>
            <div class="col-lg-9 col-md-8"><?php echo $email; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Contact</div>
            <div class="col-lg-9 col-md-8"><?php echo $telephone; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Education</div>
            <div class="col-lg-9 col-md-8"><?php echo $Education; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Compétences</div>
            <div class="col-lg-9 col-md-8"><?php echo $Competences; ?></div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">curriculum vitae</div>
            <div class="col-lg-9 col-md-8"><a href="uploads/cv/<?php echo $profile_pic; ?>" target="_blank">CV</a></div>
        </div>
    </div>


                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="pays" class="col-md-4 col-lg-3 col-form-label">Photo de Profil</label>
<div class="col-md-8 col-lg-9">
        <img src="uploads/<?php echo $row['profile_pic']; ?>" onclick="openModal('<?php echo $row['profile_pic']; ?>')" style="cursor: pointer;" alt="Profile" class="rounded-circle" id="profile-picture">
        <input type="file" id="profile-photo-input" style="display: none;" onchange="updateProfilePhoto(this)">
        <div class="edit-icon" onclick="chooseNewCoverPhoto()">✎</div>
    <div class="pt-2">
        <a href="#" class="btn btn-primary btn-sm" id="pays" name="pays" title="Upload new profile image" onclick="uploadpays()"><i class="bi bi-upload"></i></a>
        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" onclick="removepays()"><i class="bi bi-trash"></i></a>
    </div>
</div>

                    </div>

                    <div class="row mb-3">
                      <label for="nom" class="col-md-4 col-lg-3 col-form-label">Prénom</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Prénom" value="<?php echo $nom; ?>" required>
                      </div>
                    </div>



                    <div class="row mb-3">
                      <label for="prenom" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Nom" value="<?php echo $prenom; ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $email; ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="telephone" class="col-md-4 col-lg-3 col-form-label">Téléphone</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="telephone" value="<?php echo $telephone; ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="Profession" class="col-md-4 col-lg-3 col-form-label">Profession</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="Profession" name="Profession" placeholder="Profession" value="<?php echo $Profession; ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="Localisation" class="col-md-4 col-lg-3 col-form-label">Localisation</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="Localisation" name="Localisation" placeholder="Localisation" value="<?php echo $Localisation; ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="Education" class="col-md-4 col-lg-3 col-form-label">Education</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea class="form-control" id="Education" name="Education" rows="3" placeholder="Education" required><?php echo $Education; ?></textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Competences" class="col-md-4 col-lg-3 col-form-label">Compétences</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea class="form-control" id="Competences" name="Competences" rows="3" placeholder="Competences" required><?php echo $Competences; ?></textarea>
                      </div>
                    </div>



                            <div class="form-group">
                                <label for="cv" class="col-sm-2 control-label">CV</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="cv" name="cv" placeholder="Importez votre CV">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="checkbox" id="terms_condition_check" class="chk-col-red filled-in" required>
                                    <label for="terms_condition_check">J'accepte les <a href="#">conditions d'utilisation</a></label>
                                </div>
                            </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form class="form-horizontal" method="post" action="">

                    <div class="row mb-3">
                      <label for="OldPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-9">
                        <input  type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Ancien mot de passe" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="NewPassword" class="col-md-4 col-lg-3 col-form-label">nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input  type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="Nouveau mot de passe" required>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="NewPasswordConfirm" class="col-md-4 col-lg-3 col-form-label">Ré-entrez le nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="password" class="form-control" id="NewPasswordConfirm" name="NewPasswordConfirm" placeholder="Confirmez  votre Nouveau mot de passe" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>







 <script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer tous les boutons d'onglet
    var tabButtons = document.querySelectorAll('.nav-tabs .nav-link');

    // Ajouter un gestionnaire d'événement clic à chaque bouton d'onglet
    tabButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Empêcher le comportement par défaut du lien
            event.preventDefault();

            // Retirer la classe 'active' de tous les boutons d'onglet
            tabButtons.forEach(function(btn) {
                btn.classList.remove('active');
            });

            // Ajouter la classe 'active' au bouton d'onglet cliqué
            button.classList.add('active');

            // Récupérer l'ID de la sous-page à afficher
            var target = button.getAttribute('data-bs-target');

            // Masquer toutes les sous-pages
            var tabContents = document.querySelectorAll('.tab-pane');
            tabContents.forEach(function(content) {
                content.classList.remove('show', 'active');
            });

            // Afficher la sous-page correspondante
            var targetContent = document.querySelector(target);
            targetContent.classList.add('show', 'active');
        });
    });
});

function uploadpays() {
    // Afficher une boîte de dialogue de sélection de fichier
    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';

    fileInput.onchange = function() {
        var file = fileInput.files[0];
        if (file) {
            // Envoyer le fichier au serveur via une requête AJAX
            var formData = new FormData();
            formData.append('pays', file);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Mettre à jour l'image de profil affichée sur la page
                    var paysElement = document.getElementById('pays');
                    paysElement.src = URL.createObjectURL(file);
                } else {
                    console.error('Erreur lors de l\'envoi de l\'image de profil : ' + xhr.statusText);
                }
            };
            xhr.send(formData);
        }
    };

    fileInput.click();
}




// Fonction pour gérer le clic sur le bouton "Remove my profile image"
function removepays() {
    // Envoyer une requête AJAX au serveur pour supprimer l'image de profil actuelle
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Mettre à jour l'image de profil affichée sur la page avec une image par défaut
            var paysElement = document.getElementById('pays');
            paysElement.src = 'defaultpays.png';
        } else {
            console.error('Erreur lors de la suppression de l\'image de profil : ' + xhr.statusText);
        }
    };
    xhr.send();
}

</script>


    <script>
        function chooseNewCoverPhoto() {
            document.getElementById('profile-photo-input').click();
        }

        function updateProfilePhoto(input) {
            if (input.files && input.files[0]) {
                var formData = new FormData();
                formData.append('profile_pic', input.files[0]);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            document.getElementById('profile-picture').src = 'uploads/' + response.filename;
                        } else {
                            alert('Erreur : ' + response.error);
                        }
                    } else {
                        alert('Erreur lors de l\'envoi de la requête.');
                    }
                };

                xhr.send(formData);
            }
        }
    </script>