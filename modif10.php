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

$codeutilisateur = '';
$documents = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['codeutilisateur'])) {
    $codeutilisateur = $_GET['codeutilisateur'];

    // Requête pour récupérer les informations de l'utilisateur
    $sql = "SELECT ds.*, ds.full_name, ds.preno, ds.email, ds.codeutilisateur, ds.phone, ds.country, ds.city, dd.statut, dd.help2, ds.user_id 
            FROM formulaire_immigration_session1 AS ds 
            LEFT JOIN userss AS dd ON dd.id = ds.user_id 
            WHERE ds.user_id = ? AND ds.codeutilisateur = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $codeutilisateur);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }

    // Requête pour récupérer les documents
    $sqlDocuments = "SELECT documents FROM formulaire_immigration_session2 WHERE user_id = ? AND codeutilisateur = ? group by documents";
    $stmtDocuments = $conn->prepare($sqlDocuments);
    $stmtDocuments->bind_param("is", $userId, $codeutilisateur);
    $stmtDocuments->execute();
    $resultDocuments = $stmtDocuments->get_result();
    $documents = $resultDocuments->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['codeutilisateur'])) {
    $codeutilisateur = $_POST['codeutilisateur'];
    $selectedDocuments = $_POST['selected_documents'] ?? [];
    $full_name = $_POST['full_name'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];

    // Mettre à jour les informations de l'utilisateur
    $sqlUpdateUser = "UPDATE formulaire_immigration_session1 SET full_name = ?, preno = ?, email = ?, phone = ?, country = ?, city = ? WHERE codeutilisateur = ? AND user_id = ?";
    $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
    $stmtUpdateUser->bind_param("sssssssi", $full_name, $prenom, $email, $phone, $country, $city, $codeutilisateur, $userId);

    if ($stmtUpdateUser->execute()) {
        echo "Mise à jour réussie.";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }

    $target_dir = "uploads/";

    // Mise à jour des documents existants
    foreach ($selectedDocuments as $index => $docName) {
        if (isset($_FILES['documents']['name'][$index]) && $_FILES['documents']['name'][$index]) {
            $filename = $_FILES['documents']['name'][$index];
            $target_file = $target_dir . basename($filename);

            if (move_uploaded_file($_FILES['documents']['tmp_name'][$index], $target_file)) {
                // Supprimer l'ancien document
                $oldFilePath = $target_dir . $docName;
                if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Remplacer dans la liste
                $documents[$index] = $filename;
            }
        }
    }

    // Ajout de nouveaux documents
    if (isset($_FILES['new_documents']['name'])) {
        foreach ($_FILES['new_documents']['name'] as $key => $newFileName) {
            if ($newFileName) {
                $newTargetFile = $target_dir . basename($newFileName);

                if (move_uploaded_file($_FILES['new_documents']['tmp_name'][$key], $newTargetFile)) {
                    // Insérer les nouveaux documents dans la base de données
                    $sqlInsertDocument = "INSERT INTO formulaire_immigration_session2 (user_id, codeutilisateur, documents, datet) VALUES (?, ?, ?, NOW())";
                    $stmtInsertDocument = $conn->prepare($sqlInsertDocument);
                    $stmtInsertDocument->bind_param("iss", $userId, $codeutilisateur, $newFileName);
                    $stmtInsertDocument->execute();

                    $documents[] = $newFileName; // Ajouter le nouveau document à la liste
                }
            }
        }
    }

    // Mise à jour des documents dans la base de données
    $updatedDocuments = implode(',', $documents);
    $sqlUpdateDocument = "UPDATE formulaire_immigration_session2 SET documents = ?, datet = NOW() WHERE codeutilisateur = ? AND user_id = ?";
    $stmtUpdateDocument = $conn->prepare($sqlUpdateDocument);
    $stmtUpdateDocument->bind_param("ssi", $updatedDocuments, $codeutilisateur, $userId);

    if ($stmtUpdateDocument->execute()) {
        echo "Mise à jour des documents réussie.";
    } else {
        echo "Erreur lors de la mise à jour des documents : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Documents</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .file-container {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .file-names {
            margin-top: 5px;
        }
    </style>
    <script>
        function addDocumentField() {
            const container = document.getElementById('new-documents-container');
            const newField = document.createElement('div');
            newField.className = 'form-group';
            newField.innerHTML = '<input type="file" name="new_documents[]" class="form-control-file">';
            container.appendChild(newField);
        }
    </script>
</head>
<body class="container my-5">
    <h2 class="mb-4">Modifier les informations</h2>
    <?php if (isset($user)): ?>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="codeutilisateur" value="<?php echo htmlspecialchars($codeutilisateur); ?>">
        <div class="form-group">
            <label>Nom Complet</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($user['preno']); ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label>Pays</label>
            <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($user['country']); ?>" required>
        </div>
        <div class="form-group">
            <label>Ville</label>
            <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($user['city']); ?>" required>
        </div>

        <!-- Modification des documents existants -->
<h4>Documents existants</h4>
<?php if (!empty($documents)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Document Actuel</th>
            <th>Remplacer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $index => $doc): ?>
            <?php if (is_array($doc)) { $docName = $doc['documents']; } else { $docName = $doc; } ?>
            <tr>
                <td><?php echo htmlspecialchars($docName); ?></td>
                <td>
                    <input type="file" name="documents[]" class="form-control-file">
                    <input type="hidden" name="selected_documents[]" value="<?php echo htmlspecialchars($docName); ?>">
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>


        <!-- Ajout de nouveaux documents -->
        <h4>Ajouter de nouveaux documents</h4>
        <div id="new-documents-container" class="file-container">
            <div class="form-group">
                <input type="file" name="new_documents[]" class="form-control-file">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addDocumentField()">Ajouter un autre document</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
    </form>
    <?php else: ?>
    <p>Utilisateur non trouvé.</p>
    <?php endif; ?>
</body>
</html>
