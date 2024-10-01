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
        background-color: #343a40;
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


<body>
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

<div style="padding: 20px; font-family: Arial, sans-serif; line-height: 1.6;">
    <h2 style="text-align: center; color: #2E86C1;">Bienvenue chez Uri Canada</h2>
    <p style="text-align: justify; color: #555555;">
        Uri Canada est une entreprise de référence spécialisée dans les prestations de services immobiliers, les revêtements et la construction de bâtiments. Nous sommes fiers de notre expertise et de notre engagement envers l'excellence, qui nous permettent de fournir des solutions innovantes et personnalisées à nos clients à travers tout le Canada.
    </p>
    <p style="text-align: justify; color: #555555;">
        <strong>Nos Services Immobiliers</strong><br>
        Chez Uri Canada, nous offrons une gamme complète de services immobiliers adaptés à vos besoins spécifiques. Que vous cherchiez à acheter, vendre ou louer une propriété, notre équipe d'experts est là pour vous accompagner à chaque étape du processus. Nous croyons en une approche personnalisée, où chaque client est traité avec le plus grand soin et respect. Notre objectif est de faciliter votre parcours immobilier en vous offrant des conseils professionnels et en vous aidant à prendre des décisions éclairées.
    </p>
    <p style="text-align: justify; color: #555555;">
        <strong>Revêtements de Qualité Supérieure</strong><br>
        Nous comprenons l'importance de la qualité et de la durabilité lorsqu'il s'agit de revêtements pour vos espaces intérieurs et extérieurs. Uri Canada propose une variété de solutions de revêtement, allant des sols en bois dur aux carreaux en céramique, en passant par les revêtements muraux innovants. Nos produits sont soigneusement sélectionnés pour répondre aux normes les plus élevées et offrir une esthétique raffinée à vos espaces de vie et de travail. Nos artisans qualifiés s'assurent que chaque installation est réalisée avec une précision et un soin méticuleux, garantissant ainsi un résultat impeccable.
    </p>
    <p style="text-align: justify; color: #555555;">
        <strong>Construction de Bâtiments</strong><br>
        La construction de bâtiments est au cœur de notre activité chez Uri Canada. Nous nous engageons à créer des structures robustes, sûres et esthétiquement agréables qui répondent aux besoins variés de nos clients. Que ce soit pour des projets résidentiels, commerciaux ou industriels, notre équipe de professionnels expérimentés travaille en étroite collaboration avec vous pour concrétiser votre vision. De la conception à la réalisation, nous prenons en charge tous les aspects du projet, en veillant à respecter les délais et les budgets. Notre engagement envers la qualité et l'innovation se reflète dans chaque bâtiment que nous construisons.
    </p>
    <p style="text-align: justify; color: #555555;">
        <strong>Notre Engagement envers l'Excellence</strong><br>
        Chez Uri Canada, l'excellence est plus qu'un objectif, c'est notre raison d'être. Nous nous efforçons constamment d'améliorer nos services et nos produits pour dépasser les attentes de nos clients. Nous investissons dans la formation continue de notre équipe et dans l'adoption de technologies de pointe pour rester à la pointe de l'industrie. Notre engagement envers la durabilité et le respect de l'environnement guide également nos actions, nous permettant de contribuer positivement à la société tout en offrant des solutions durables à nos clients.
    </p>
    <p style="text-align: justify; color: #555555;">
        En choisissant Uri Canada, vous optez pour une entreprise qui place vos besoins au centre de ses préoccupations. Notre dévouement, notre expertise et notre passion pour ce que nous faisons nous distinguent et nous permettent de fournir des résultats exceptionnels. Nous sommes impatients de collaborer avec vous et de vous aider à réaliser vos projets immobiliers, de revêtement et de construction avec succès.
    </p>
    <p style="text-align: center; color: #555555;">
        <em>Contactez-nous dès aujourd'hui pour découvrir comment Uri Canada peut vous accompagner dans la réalisation de vos projets.</em>
    </p>
</div>

    <!-- Ticker for company logos -->
<div class="ticker-wrap">
    <div class="ticker">
            <div class="ticker__item"><img src="logo11.png" alt="Company 1"></div>
            <div class="ticker__item"><img src="logo12.jpg" alt="Company 2"></div>
            <div class="ticker__item"><img src="logo14.jpg" alt="Company 3"></div>
            <div class="ticker__item"><img src="logo15+.jpg" alt="Company 4"></div>
            <div class="ticker__item"><img src="logo16.png" alt="Company 5"></div>
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
