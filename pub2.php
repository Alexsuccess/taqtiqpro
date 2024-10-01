<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Scripts nécessaires pour Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGaZ4yYa2XpI5llVk/dZlFQ1T" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-smHYkd3O8B+Q1KWGF2H5aKcJbzhb9uh9GF3jXG5xUJ0Oj5jIO7Ew5K7czl4v1H4M" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        font-family: 'Arial', sans-serif;
    }

    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .product-card {
        margin: 20px 0;
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-info {
        padding: 10px;
    }

    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 5px;
    }

    .header {
        background-color:rgb(0,0,64);
        color: white;
        padding: 10px 0;
    }

    .header a {
        color: white;
        margin: 0 15px;
    }

    .header .cart {
        position: relative;
    }

    .header .cart .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
    }

    footer {
        background-color: #343a40;
        color: white;
        text-align: center;
        padding: 20px 0;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    .carousel-item-next,
    .carousel-item-prev,
    .carousel-item.active {
        animation: fadeIn 1s;
    }

    .carousel-item-next.active,
    .carousel-item-prev.active {
        animation: fadeOut 1s;
    }

.ticker-wrap {
    width: 100%;
    overflow: hidden;
    background-color: #f1f1f1;
    padding: 10px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
}

.ticker {
    display: flex;
    width: max-content;
    animation: ticker 20s linear infinite;
}

.ticker__item {
    flex: 0 0 auto;
    padding: 0 2rem;
    font-size: 1.2rem;
    color: #333;
    white-space: nowrap;
}

@keyframes ticker {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

    .product-carousel img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-carousel {
        margin-bottom: 20px;
    }

    .product-carousel-indicators li {
        background-color: #000;
    }

    .navbar-nav .nav-item .nav-link {
        color: white !important;
    }

    .dropdown-menu {
        background-color: #343a40;
    }

    .dropdown-menu .dropdown-item {
        color: white;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #495057;
    }

/* Style pour le modal */
.modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    padding: 20px;
    background-color: #fff;
}

/* Style pour l'en-tête du modal */
.modal-header {
    border-bottom: none;
    position: relative;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

/* Style pour le bouton de fermeture */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 1.2rem;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

/* Style pour le corps du modal */
.modal-body {
    padding: 20px;
}

.form-group label {
    font-weight: bold;
    color: #555;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 1rem;
}

/* Style pour le pied de page du modal */
.modal-footer {
    border-top: none;
    padding: 10px 20px;
}

.btn-secondary, .btn-primary {
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover, .btn-primary:hover {
    background-color: #555;
    color: #fff;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

</style>

</head>


<body style="background-image: url(fonff.jpg);">
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">
                    <img style="border-radius: 50%; width: 50px; height: 50px;" src="uri.jpg" alt="Logo">

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">À propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                CRM
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Module 1</a>
                                <a class="dropdown-item" href="#">Module 2</a>
                                <a class="dropdown-item" href="#">Module 3</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Immonivo
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Module 1</a>
                                <a class="dropdown-item" href="#">Module 2</a>
                                <a class="dropdown-item" href="#">Module 3</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                WiseWork
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Module 1</a>
                                <a class="dropdown-item" href="#">Module 2</a>
                                <a class="dropdown-item" href="#">Module 3</a>
                            </div>
                        </li>
                    </ul>
                    <a href="#" class="cart"><i class="fas fa-shopping-cart"></i><span class="badge">0</span></a>
                    <a href="#" class="cart"><i class="fas fa-envelope"></i><span class="badge">0</span></a>
                </div>
            </nav>
        </div>
    </header>

   <div class="container mt-3 pt-4">
    <!-- Carousel for advertisements -->
    <div id="advertisementCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/services/668de0e9459b9.jpeg" class="d-block w-100" alt="Ad 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Lit VIP</h5>
                    <p>Nouvelle sortie des lits VIP</p>
                    <p><strong>Prix: 100€</strong></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="uploads/services/paint.jpg" class="d-block w-100" alt="Ad 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Produit 2</h5>
                    <p>Description du produit 2</p>
                    <p><strong>Prix: 200€</strong></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="uploads/services/667eae16a9ae5.jpg" class="d-block w-100" alt="Ad 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Produit 3</h5>
                    <p>Description du produit 3</p>
                    <p><strong>Prix: 300€</strong></p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="uploads/services/canapa.jpg" class="d-block w-100" alt="Ad 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Produit 3</h5>
                    <p>Description du produit 3</p>
                    <p><strong>Prix: 300€</strong></p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="uploads/services/canapee.jpg" class="d-block w-100" alt="Ad 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Produit 3</h5>
                    <p>Description du produit 3</p>
                    <p><strong>Prix: 300€</strong></p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="uploads/services/zzz.jpeg" class="d-block w-100" alt="Ad 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Produit 3</h5>
                    <p>Description du produit 3</p>
                    <p><strong>Prix: 300€</strong></p>
                </div>
            </div>
        </div>
    </div>




</div>
<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des catégories
$categoriesQuery = "SELECT * FROM categories22";
$categoriesResult = $conn->query($categoriesQuery);

// Récupération des produits en fonction de la catégorie sélectionnée
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';

$productQuery = "SELECT * FROM servicess";
if ($category_id) {
    $productQuery .= " WHERE category_id = $category_id";
}
if ($search_term) {
    $productQuery .= $category_id ? " AND name LIKE '%$search_term%'" : " WHERE name LIKE '%$search_term%'";
}
$productResult = $conn->query($productQuery);
?>


    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .product-carousel img {
            width: 100%;
            height: 200px; /* Taille fixe des images */
            object-fit: cover; /* Pour s'adapter au cadre tout en conservant les proportions */
        }
    </style>
</head>
<body>
<div style="background-color: white;" class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <h4>Catégories</h4>
            <ul class="list-group">
                <li class="list-group-item"><a href="?category_id=">ALL</a></li>
                <?php while ($category = $categoriesResult->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        <a href="?category_id=<?= $category['id'] ?>"><?= $category['sous_categorie'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-9">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recherche produit..." name="search_term" value="<?= htmlspecialchars($search_term) ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Recherche</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <?php while ($product = $productResult->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <div id="productCarousel<?= $product['id'] ?>" class="carousel slide product-carousel" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $images = explode('; ', $product['images']);
                                    foreach ($images as $index => $image) {
                                        $active = $index === 0 ? 'active' : '';
                                        echo "<div class='carousel-item $active'>";
                                        echo "<img src='uploads/services/$image' class='d-block w-100' alt='Product Image'>";
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                                <a class="carousel-control-prev" href="#productCarousel<?= $product['id'] ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Précédent</span>
                                </a>
                                <a class="carousel-control-next" href="#productCarousel<?= $product['id'] ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Suivant</span>
                                </a>
                            </div>
                            <div class="product-info">
                                <h5><?= htmlspecialchars($product['name']) ?></h5>
                                <p><?= htmlspecialchars($product['description']) ?></p>
                                <p><strong>Prix: <?= htmlspecialchars($product['price']) ?>€</strong></p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal<?= $product['id'] ?>">Commander</button>
                            </div>
                        </div>
                    </div>

<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $product_id = $_POST['product_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $quantite = $_POST['quantite'];

    // Prépare et exécute la requête d'insertion
    $sql = "INSERT INTO ordersxx (product_id, nom, prenom, pays, ville, telephone, email, quantite) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssi", $product_id, $nom, $prenom, $pays, $ville, $telephone, $email, $quantite);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Commande passée avec succès!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Erreur: ' . $conn->error];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit();
}
?>
            <!-- Modal -->
                    
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="orderModal<?= $product['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel<?= $product['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="orderForm<?= $product['id'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel<?= $product['id'] ?>">Commander <?= htmlspecialchars($product['name']) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire de commande ici -->
                    <input type="hidden" id="product_id" name="product_id" value="<?= $product['id'] ?>">

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>

                    <div class="form-group">
                        <label for="pays">Pays</label>
                        <input type="text" class="form-control" id="pays" name="pays" required>
                    </div>

                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" required>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="quantite">Nombre de produits à acheter</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Commander</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('orderForm<?= $product['id'] ?>').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message,
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Une erreur s\'est produite',
            });
        });
    });
</script>



                <?php } ?>
            </div>
        </div>
    </div>
</div>



<?php
$conn->close();
?>


            <!-- Repeat this block for more products -->
        </div>


                <div class="ticker-wrap mt-5">
            <div class="ticker">
                <div class="ticker__item">Nouveau produit disponible !</div>
                <div class="ticker__item">Réductions sur plusieurs articles !</div>
                <div class="ticker__item">Livraison gratuite à partir de 50€ d'achat !</div>
                <div class="ticker__item">Inscrivez-vous à notre newsletter pour des offres exclusives !</div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Votre Marketplace. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('addToCartBtn').addEventListener('click', function () {
        var quantity = document.getElementById('quantity').value;
        // Ajoutez ici le code pour ajouter le produit et la quantité au panier
        console.log('Produit ajouté au panier avec quantité:', quantity);
        $('#orderModal').modal('hide');
    });
</script>
<script>
    $(document).ready(function(){
        // Initialisation du carousel d'annonces avec défilement automatique
        $('#advertisementCarousel').carousel({
            interval: 2000, // Changement d'image toutes les 5 secondes
            pause: false // Désactiver la pause au survol
        });
    });
</script>

</body>

</html>
