<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start(); // Démarrer la session pour stocker les informations de l'utilisateur connecté
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variable pour stocker le message d'erreur
$error_message = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer la déclaration SQL pour vérifier si l'email existe dans la base de données
    $stmt = $conn->prepare("SELECT * FROM userss WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // L'email existe, vérifier le mot de passe et le statut du compte
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            if ($row['statut'] == 1) {
                // Stocker l'ID de l'utilisateur dans la session
                $_SESSION['id'] = $row['id'];

                // Rediriger en fonction du type d'utilisateur
                $redirections = [
                    "Client" => "candidat.php",
                    "Employé" => "employe.php",
                    "Candidat" => "candidat.php",
                    "Entreprise" => "entreprise.php",
                    "Agent" => "agent.php",
                    "Modérateur" => "admin.php",
                    "Prestataire" => "entreprise.php",
                    "Televendeur" => "telephoniste.php",
                    "Agence de Marketing" => "telephoniste.php"
                ];

                if (isset($row['compte']) && isset($redirections[$row['compte']])) {
                    header("Location: " . $redirections[$row['compte']]);
                    exit(); // Arrêter l'exécution du script après la redirection
                }
            } else {
                // Compte désactivé
                $error_message = "Votre compte a été désactivé. Contactez l'administrateur par email : achillempombatindi@gmail.com";
            }
        } else {
            // Mot de passe incorrect
            $error_message = "Le mot de passe ne correspond pas. Contactez l'administrateur par email : achillempombatindi@gmail.com";
        }
    } else {
        // L'email n'existe pas
        $error_message = "Ce compte n'existe pas.";
    }

    $stmt->close();
}

$conn->close();
?>


    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Site Metas -->
    <title>Pluto</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Site Icon -->
    <link rel="icon" href="canada.jpg" type="canada.jpg" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Site CSS -->
    <link rel="stylesheet" href="style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- Color CSS -->
    <link rel="stylesheet" href="css/colors.css" />
    <!-- Select Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css" />
    <!-- Calendar File CSS -->
    <link rel="stylesheet" href="js/semantic.min.css" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="inner_page login" style="background-image: url(font2.jpeg);">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section">
                    <div class="logo_login">
                        <div class="center">
                            <img width="210" src="images/logo/logo.png" alt="#" />
                        </div>
                    </div>
                    <div class="login_form">
                        <form method="post" action="">
                            <fieldset>
                                <div class="field">
                                    <label class="label_field">Email Address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required="required">
                                </div>
                                <div class="field">
                                    <label class="label_field">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                                </div>
                                <div class="field">
                                    <label class="label_field hidden">hidden label</label>
                                    <label class="form-check-label"><input type="checkbox" class="form-check-input"> Remember Me</label>
                                    <a class="forgot" href="enregistre.php">Créer un compte</a><br>
                                    <a class="forgot" style="color: blue;" href="acceuil.php">Choix de connexion</a>
                                </div>
                                <?php if ($error_message != ""): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error_message; ?>
                                </div>
                                <?php endif; ?>
                                <div class="field margin_0">
                                    <label class="label_field hidden">hidden label</label>
                                    <button class="main_bt">Connexion</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Wow Animation -->
    <script src="js/animate.js"></script>
    <!-- Select Country -->
    <script src="js/bootstrap-select.js"></script>
    <!-- Nice Scrollbar -->
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <!-- Custom JS -->
    <script src="js/custom.js"></script>
</body>
</html>
