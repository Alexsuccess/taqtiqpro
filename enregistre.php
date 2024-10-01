<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créez une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $prof = $_POST['prof'];
    $Ville = $_POST['Ville'];
    $Profession = $_POST['Profession'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $codee = $_POST['codee'];
    $dep = $_POST['dep'];
    $compte = $_POST['compte'];
    $help = $_POST['password'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $seul = $_POST['seul'];
    $accompanied_by = ($seul === 'non') ? $_POST['accompanied_by'] : null;

    // Gérer le téléchargement de l'image
    $profile_pic = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileSize = $_FILES['profile_pic']['size'];
        $fileType = $_FILES['profile_pic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_pic = $newFileName;
        }
    }

    // Préparer la déclaration SQL
    if ($accompanied_by !== null) {
        $stmt = $conn->prepare("INSERT INTO userss (compte, nom, prenom, prof, pays, Ville, Profession, email, codee, telephone, password, help, dep, profile_pic, statut, accompanied_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1', ?)");
        $stmt->bind_param("sssssssssssssss", $compte, $nom, $prenom, $prenom, $pays, $Ville, $Profession, $email, $codee, $telephone, $password, $help, $dep, $profile_pic, $accompanied_by);
    } else {
        $stmt = $conn->prepare("INSERT INTO userss (compte, nom, prenom, prof, pays, Ville, Profession, email, codee, telephone, password, help, dep, profile_pic, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt->bind_param("ssssssssssssss", $compte, $nom, $prenom, $prof, $pays, $Ville, $Profession, $email, $codee, $telephone, $password, $help, $dep, $profile_pic);
    }

    try {
        if ($stmt->execute()) {
            echo "Enregistrement réussi";
            header("Location: acceuil.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            $error_message = "L'utilisateur existe déjà.";
        } else {
            $error_message = "Erreur: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Site Metas -->
    <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Site Icon -->
    <link rel="icon" href="images/fevicon.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            background-image: url(font4.jpg);
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .profile-pic {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }

        .profile-pic img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #007bff;
            background-color: #f0f0f0;
            /* Ensuring the circle shape */
        }

        .profile-pic label {
            width: 120px;
            height: 120px;
            display: inline-block;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 3px solid #007bff;
            background-color: #f0f0f0;
            /* Ensuring the circle shape */
            cursor: pointer;
        }

        .profile-pic input {
            display: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .form-control {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }

        .password-field {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .main_bt {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
        }

        .main_bt:hover {
            background: #0056b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 2.5rem;
        }

        .password-wrapper .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 0.5rem;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = field.nextElementSibling.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function previewProfilePic(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('profile_pic');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="profile-pic">
            <label for="profile_pic_input">
                <img width="210" src="images/logo/logo.png" alt="#" />
            </label>
        </div>
        <div class="acceuil_form">
            <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
                <fieldset>
                    <div class="form-group">
                        <label class="form-label">Type de compte</label>
                        <select name="compte" class="form-control" required>
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
                        <label class="form-label">Êtes-vous seul ?</label>
                        <select name="seul" class="form-control" onchange="toggleAccompaniedSelect(this.value)"
                            required>
                            <option value="oui">oui</option>
                            <option value="non">non</option>
                        </select>
                    </div>
                    <div class="form-group" id="accompanied-select" style="display: none;">
                        <label class="form-label">Sélectionner votre parrain qui vous accompagne</label>
                        <select name="accompanied_by" class="form-control">
                            <option value="" disabled selected>Choisir votre parrain</option>
                            <?php
                            // Connexion à la base de données
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Vérifier la connexion à la base de données
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch users from database
                            $query = "SELECT id, nom, prenom, compte FROM userss WHERE compte IN ('Agent', 'Agence')";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nom'] . ' ' . $row['prenom'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="form-group">
                            <label class="form-label">Département</label>
                            <input type="text" name="dep" placeholder="Département" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" placeholder="Nom" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">NUI / Prenom</label>
                        <input type="text" name="prenom" placeholder="Prénom" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profession</label>
                        <input type="text" name="prof" placeholder="Profession" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Indicateur pays</label>
                        <input type="text" name="codee" placeholder="Code" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pays</label>
                        <select name="pays" class="form-control" required>
                            <option value="" disabled selected>Choisir le pays</option>
                            <!-- Liste des options pays -->

                            <option value="Canada">Canada</option>
                            <option value="Algérie">Algérie</option>
                            <option value="Angola">Angola</option>
                            <option value="Bénin">Bénin</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cabo Verde">Cabo Verde</option>
                            <option value="Cameroun">Cameroun</option>
                            <option value="République Centrafricaine">République Centrafricaine</option>
                            <option value="Tchad">Tchad</option>
                            <option value="Comores">Comores</option>
                            <option value="Congo">Congo</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Égypte">Égypte</option>
                            <option value="Guinée Équatoriale">Guinée Équatoriale</option>
                            <option value="Érythrée">Érythrée</option>
                            <option value="Eswatini">Eswatini</option>
                            <option value="Éthiopie">Éthiopie</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambie">Gambie</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Guinée">Guinée</option>
                            <option value="Guinée-Bissau">Guinée-Bissau</option>
                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libye">Libye</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Mali">Mali</option>
                            <option value="Mauritanie">Mauritanie</option>
                            <option value="Maurice">Maurice</option>
                            <option value="Maroc">Maroc</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Namibie">Namibie</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigéria">Nigéria</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Sénégal">Sénégal</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Somalie">Somalie</option>
                            <option value="Afrique du Sud">Afrique du Sud</option>
                            <option value="Soudan du Sud">Soudan du Sud</option>
                            <option value="Soudan">Soudan</option>
                            <option value="Tanzanie">Tanzanie</option>
                            <option value="Togo">Togo</option>
                            <option value="Tunisie">Tunisie</option>
                            <option value="Ouganda">Ouganda</option>
                            <option value="Zambie">Zambie</option>
                            <option value="Zimbabwe">Zimbabwe</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ville</label>
                        <input type="text" name="Ville" placeholder="Ville" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profession</label>
                        <input type="text" name="Profession" placeholder="Profession" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                       
                            <div class="password-wrapper">
            <input 
                id="confirm_password" 
                type="password" 
                name="password" 
                placeholder="Mot de passe" 
                class="form-control" 
                required 
            />
            <i id="toggle_visibility" class="fas fa-eye toggle-visibility"></i>
        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <div class="password-wrapper">
                            <input id="confirm_password" type="password" name="confirm_password"
                                placeholder="Confirmer le mot de passe" class="form-control" required />
                            <i id="toggle_visibility" class="fas fa-eye toggle-visibility"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Numéro de téléphone</label>
                        <input type="text" name="telephone" placeholder="Numéro de téléphone" class="form-control"
                            required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Photo de profil</label>
                        <input type="file" name="profile_pic" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </fieldset>
            </form>
        </div>
    </div>
    <script>
        function toggleAccompaniedSelect(value) {
            var accompaniedSelect = document.getElementById('accompanied-select');
            accompaniedSelect.style.display = (value === 'non') ? 'block' : 'none';
        }

        function validateForm() {
            var seul = document.querySelector('select[name="seul"]').value;
            if (seul === 'non') {
                var accompaniedBy = document.querySelector('select[name="accompanied_by"]').value;
                if (!accompaniedBy) {
                    alert('Veuillez sélectionner un parrain.');
                    return false;
                }
            }
            return true;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('confirm_password');
            const toggleVisibilityIcon = document.getElementById('toggle_visibility');

            toggleVisibilityIcon.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleVisibilityIcon.classList.remove('fa-eye');
                    toggleVisibilityIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleVisibilityIcon.classList.remove('fa-eye-slash');
                    toggleVisibilityIcon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>

</html>