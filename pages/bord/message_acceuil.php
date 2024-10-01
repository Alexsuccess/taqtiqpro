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
// Requête pour vérifier si `help2` est null
$query = "SELECT * FROM userss as dd left join candidats as xx on xx.tel=dd.telephone WHERE dd.id = $userId AND xx.tel IS  NULL";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user) {
    $username = $user['nom']; // Modifier en fonction de la colonne contenant le nom de l'utilisateur
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenue - CRM</title>
        <style>

            .container {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
             
                width: 100%;
            }
            h1 {
                color: #333;
            }
            p {
                font-size: 1.2em;
                margin: 10px 0;
                color: #555;
            }
            .instructions img {
                width: 100%;
                border-radius: 5px;
                margin: 10px 0;
            }
            .btn {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                color: #fff;
                background-color: #007BFF;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                font-size: 1em;
            }
            .btn:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
           <h1>Bienvenue, <?php echo htmlspecialchars($username ?? 'Utilisateur'); ?>!</h1>
<p>Bienvenue dans le CRM! 🎉 Si c'est votre première fois de vous connecter, nous sommes ravis de vous accueillir dans notre communauté. Avant de commencer à explorer toutes les fonctionnalités que nous avons à offrir, nous vous invitons à compléter votre dossier. Une fois que toutes les informations sont en place, votre compte sera approuvé, et vous serez prêt à profiter pleinement de votre expérience ici !</p>
<p>Pas d'inquiétude, c'est facile! Suivez simplement les étapes ci-dessous, et vous serez prêt en un rien de temps :</p>

            <div class="instructions">
                <img src="pages/bord/complet.PNG" alt="Capture d'écran 1"><br><br><br>
                <img src="pages/bord/complet2.PNG" alt="Capture d'écran 2">
                <img src="capture3.png" alt="Capture d'écran 3">
            </div>
            <a href="candidat.php?page=<?php echo base64_encode('pages/immig/ajout2');?>" class="btn">Compléter votre dossier</a>
        </div>
    </body>
    </html>
<?php
} else {
    // Rediriger vers une autre page si l'utilisateur a déjà complété le dossier
    header("Location: candidat.php?page=" . base64_encode('pages/bord/lister'));
    exit();
}
?>

