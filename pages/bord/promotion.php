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

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promotion_name = $_POST['promotion_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (isset($_POST['update']) && !empty($_POST['update'])) {
        // Mise à jour de la promotion existante
        $promotion_id = $_POST['update'];

        $stmt = $conn->prepare("UPDATE promotions SET promotion_name = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("sssi", $promotion_name, $start_date, $end_date, $promotion_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Ajout d'une nouvelle promotion
        $stmt = $conn->prepare("INSERT INTO promotions (promotion_name, start_date, end_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $promotion_name, $start_date, $end_date);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: admin.php?page=" . base64_encode('pages/bord/promotion'));
    exit();
}

// Traitement de la suppression
if (isset($_GET['delete'])) {
    $promotion_id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM promotions WHERE id = ?");
    $stmt->bind_param("i", $promotion_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php?page=" . base64_encode('pages/bord/promotion'));
    exit();
}

// Récupération des promotions
$result = $conn->query("SELECT * FROM promotions ORDER BY start_date DESC");
$promotions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $promotions[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Promotions</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            
            color: #fff;
            padding: 1em 0;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        main {
            padding: 2em;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-section,
        .list-section {
            margin-bottom: 2em;
        }

        form label {
            display: block;
            margin: 0.5em 0 0.2em;
        }

        form input[type="text"],
        form input[type="date"],
        form button {
            display: block;
            width: 100%;
            margin-bottom: 1em;
            padding: 0.8em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2em;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body><br><br>
    <header>
        <h1>Gestion des Promotions</h1>
    </header>

    <main>
        <section class="form-section">
            <h2><?php echo isset($_GET['edit']) ? 'Modifier la Promotion' : 'Ajouter une Promotion'; ?></h2>
            <form action="" method="POST">
                <input type="hidden" name="update" value="<?php echo isset($_GET['edit']) ? htmlspecialchars($_GET['edit']) : ''; ?>">
                <label for="promotion_name">Nom de la Promotion:</label>
                <input type="text" id="promotion_name" name="promotion_name" value="<?php echo isset($promotion) ? htmlspecialchars($promotion['promotion_name']) : ''; ?>" required>

                <label for="start_date">Date de Début:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo isset($promotion) ? htmlspecialchars($promotion['start_date']) : ''; ?>" required>

                <label for="end_date">Date de Fin:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo isset($promotion) ? htmlspecialchars($promotion['end_date']) : ''; ?>" required>

                <button type="submit"><?php echo isset($_GET['edit']) ? 'Mettre à Jour' : 'Enregistrer la Promotion'; ?></button>
            </form>
        </section>

        <section class="list-section">
            <h2>Promotions Enregistrées</h2>
            <?php if (count($promotions) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de la Promotion</th>
                            <th>Date de Début</th>
                            <th>Date de Fin</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promotions as $promotion): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($promotion['promotion_name']); ?></td>
                                <td><?php echo htmlspecialchars($promotion['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($promotion['end_date']); ?></td>
                                <td>
                                    <a href="admin.php?page=<?php echo base64_encode('pages/bord/promotion'); ?>&edit=<?php echo $promotion['id']; ?>">Modifier</a>
                                    <a href="admin.php?page=<?php echo base64_encode('pages/bord/promotion'); ?>&delete=<?php echo $promotion['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune promotion enregistrée.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
