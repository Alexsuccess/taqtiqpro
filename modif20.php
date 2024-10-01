<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])) {
    $code = $_GET['code'];

    $sql = "SELECT c.nom, c.prenom, c.email, c.sexe, c.pays, c.code, c.prof,
                   d.diplome, d.passeport, d.certificat_naissance, d.certificat_scolarite, d.mandat_representation
            FROM candidats c
            LEFT JOIN documentss d ON c.code = d.code WHERE c.code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $candidat = $result->fetch_assoc();
    } else {
        echo "Candidat non trouvé.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code'])) {
    $code = $_POST['code'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $sexe = $_POST['sexe'];
    $pays = $_POST['pays'];
    $prof = $_POST['prof'];

    $sql = "UPDATE candidats SET nom = ?, prenom = ?, email = ?, sexe = ?, pays = ?, prof = ? WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nom, $prenom, $email, $sexe, $pays, $prof, $code);

    if ($stmt->execute()) {
        echo "Mise à jour réussie.";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Candidat</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">
    <h2 class="mb-4">Modifier Candidat</h2>
    <?php if (isset($candidat)): ?>
        <form method="post" action="">
            <input type="hidden" name="code" value="<?php echo htmlspecialchars($candidat['code']); ?>">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($candidat['nom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($candidat['prenom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($candidat['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Sexe</label>
                <input type="text" name="sexe" class="form-control" value="<?php echo htmlspecialchars($candidat['sexe']); ?>" required>
            </div>
            <div class="form-group">
                <label>Pays</label>
                <input type="text" name="pays" class="form-control" value="<?php echo htmlspecialchars($candidat['pays']); ?>" required>
            </div>
            <div class="form-group">
                <label>Profession</label>
                <input type="text" name="prof" class="form-control" value="<?php echo htmlspecialchars($candidat['prof']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    <?php else: ?>
        <p>Candidat non trouvé.</p>
    <?php endif; ?>
</body>
</html>
