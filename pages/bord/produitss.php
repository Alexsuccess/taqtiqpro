<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .product {
            border: 1px solid #ccc;
            width: calc(25% - 20px); /* 4 cases par ligne */
            margin-bottom: 20px;
            padding: 10px;
            box-sizing: border-box;
        }
        .product img {
            width: 100%; /* Pour que toutes les images aient la même largeur */
            height: 200px; /* Hauteur fixe pour toutes les images */
            object-fit: cover; /* Pour conserver les proportions et couvrir la zone */
            border-radius: 5px;
        }
        .product-info {
            margin-bottom: 10px;
        }
        .product-info h2 {
            margin: 5px 0;
        }
        .product-description {
            margin-bottom: 10px;
        }
        .product-price {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .order-btn {
            background-color: rgb(0,0,64);
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            display: block;
            width: 100%;
        }

        /* Media queries pour améliorer l'affichage sur les téléphones */
        @media (max-width: 1200px) {
            .product {
                width: calc(33.33% - 20px); /* 3 cases par ligne */
            }
        }

        @media (max-width: 768px) {
            .product {
                width: calc(50% - 20px); /* 2 cases par ligne */
            }
        }

        @media (max-width: 480px) {
            .product {
                width: 100%; /* 1 case par ligne */
            }
        }
    </style>
</head>
<body>

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

    // Récupérer les produits depuis la base de données
    $sql = "SELECT * FROM produitss";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Afficher chaque produit
        while($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            // Afficher la première image du produit
            $images = explode(",", $row['image_path']); // Séparer les chemins des images
            if (!empty($images[0])) {
                echo "<img src='uploads/images/" . $images[0] . "' alt='" . $row['nom_produit'] . "'>";
            } else {
                echo "<img src='uploads/images/placeholder.jpg' alt='Image indisponible'>";
            }
            echo "<div class='product-info'>";
            echo "<h8 style='color: blue;'>" . $row['nom_produit'] . "</h8>";
            echo "<p class='product-description'>" . $row['description'] . "</p>";
            echo "<p class='product-price'>$" . $row['prix'] . "</p>";
           echo "<a href='pages/bord/detail_produit.php?id=" . $row['id'] . "' class='order-btn' target='_blank'>Détail</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Aucun produit trouvé.";
    }
    // Fermer la connexion
    $conn->close();
    ?>
</div>

</body>
</html>
