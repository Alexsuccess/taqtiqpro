<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $contact = $_POST['contact'];
    $nombre = $_POST['nombre'];
    $product_id = $_POST['product_id']; // Récupérer l'ID du produit

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

    // Préparer et exécuter la requête SQL pour insérer les données
    $sql = "INSERT INTO commandess (nom, prenom, pays, ville, contact, nombre_produit, product_id) VALUES ('$nom', '$prenom', '$pays', '$ville', '$contact', $nombre, $product_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Commande enregistrée avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la commande: " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Produit</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
        }
        .product-info {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .product-info .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 10px;
        }
        .product-info img {
            width: 100%; /* Image prend toute la largeur */
            height: auto;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .product-info img:hover {
            transform: scale(1.1);
        }
        .product-info h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }
        .product-description {
            margin-bottom: 20px;
            color: #666;
        }
        .product-price {
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .order-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .order-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body style="background-image: url(images/font6.jpeg);">

<div class="container">
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

    // Vérifier si l'ID du produit est passé en paramètre
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        // Récupérer les informations du produit depuis la base de données
        $sql = "SELECT * FROM  produitss  WHERE id = $product_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nom_produit = $row['nom_produit'];
            $description = $row['description'];
            $prix = $row['prix'];
            $images = explode(",", $row['image_path']); // Séparer les chemins des images
        } else {
            echo "Produit non trouvé.";
            exit(); // Arrêter l'exécution si le produit n'est pas trouvé
        }
    } else {
        echo "ID du produit non spécifié.";
        exit(); // Arrêter l'exécution si l'ID du produit n'est pas passé en paramètre
    }
    ?>

    <div class="product-info">
        <h2><?php echo $nom_produit; ?></h2>
        <div class="image-grid">
            <?php foreach ($images as $image) : ?>
                <img src="../../uploads/images/<?php echo $image; ?>" alt="<?php echo $nom_produit; ?>">
            <?php endforeach; ?>
        </div>
        <p class="product-description"><?php echo $description; ?></p>
        <p class="product-price">$<?php echo $prix; ?></p>
        <!-- Bouton pour ouvrir le modal -->
        <button class="order-btn" data-toggle="modal" data-target="#orderModal">Commander</button>
    </div>
</div>

<!-- Modal pour le formulaire de commande -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Passer une commande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de commande -->
<!-- Formulaire de commande -->
<form action="" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"> <!-- Champ caché pour stocker l'ID du produit -->
    <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="form-group">
        <label for="prenom">Prénom:</label>
        <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>
    <div class="form-group">
        <label for="pays">Pays:</label>
        <input type="text" class="form-control" id="pays" name="pays" required>
    </div>
    <div class="form-group">
        <label for="ville">Ville:</label>
        <input type="text" class="form-control" id="ville" name="ville" required>
    </div>
    <div class="form-group">
        <label for="contact">Contact:</label>
        <input type="text" class="form-control" id="contact" name="contact" required>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre de produit sollicité:</label>
        <input type="number" class="form-control" id="nombre" name="nombre" required>
    </div>
    <!-- Ajoutez ici d'autres champs du formulaire -->
    <button type="submit" class="btn btn-primary">Passer la commande</button>
</form>

            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
