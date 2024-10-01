<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupérer les catégories principales avec leurs sous-catégories
$sql_categories = "SELECT DISTINCT categorie_principale FROM categories22 group by categorie_principale";
$result_categories = $conn->query($sql_categories);

// Récupérer toutes les sous-catégories par catégorie principale
$categories_with_subcategories = [];
$sql_all_categories = "SELECT id, categorie_principale, sous_categorie FROM categories22";
$result_all_categories = $conn->query($sql_all_categories);
if ($result_all_categories->num_rows > 0) {
    while ($row = $result_all_categories->fetch_assoc()) {
        $categories_with_subcategories[$row['categorie_principale']][] = [
            'id' => $row['id'],
            'sous_categorie' => $row['sous_categorie']
        ];
    }
}

// Gérer le formulaire de soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? null;
    $subcategory = $_POST['subcategory'] ?? null;
    $name = $_POST['name'] ?? null;
    $price = $_POST['price'] ?? null;
    $description = $_POST['description'] ?? null;
    $type = $_POST['type'] ?? null;
    $images = [];

    // Gérer le téléchargement des images
    if (isset($_FILES['images'])) {
        $total = count($_FILES['images']['name']);
        for ($i = 0; $i < $total; $i++) {
            $filename = $_FILES['images']['name'][$i];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $newFilename = uniqid() . '.' . $extension; // Générer un nom de fichier unique
            $images[] = $newFilename; // Enregistrer seulement le nom du fichier
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $newFilePath = "uploads/" . ($type === 'product' ? 'products' : 'services') . "/" . $newFilename;
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    // Fichier téléchargé avec succès
                }
            }
        }
    }

    // Convertir les images en une chaîne séparée par des points-virgules
    $images_string = implode('; ', $images);

    // Préparer la requête SQL en fonction du type
    if ($type === 'product') {
        // Requête pour les produits
        $sql = "INSERT INTO productss (category_id, name, price, images) VALUES (?, ?, ?, ?)";
    } else {
        // Requête pour les services
        $sql = "INSERT INTO servicess (category_id, name, price, images, description) VALUES (?, ?, ?, ?, ?)";
    }

    // Préparer la déclaration et lier les paramètres
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Erreur de préparation de la requête SQL: ' . $conn->error);
    }

    // Lier les paramètres à la requête
    $stmt->bind_param("issss", $subcategory, $name, $price, $images_string, $description);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "<script>alert('Enregistrement réussi'); window.location.href='';</script>";
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer Produits/Prestations</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
        }
        .preview-img {
            display: inline-block;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            background: #f8f8f8;
            border-radius: 5px;
        }
        .preview-img img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        header, footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
    <script>
        function loadSubcategories(categorie_principale) {
            var subcategories = <?php echo json_encode($categories_with_subcategories); ?>;
            var subcategoryOptions = subcategories[categorie_principale];
            var select = document.getElementById('serviceSubcategory');
            select.innerHTML = '';
            subcategoryOptions.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option.id;
                opt.textContent = option.sous_categorie;
                select.appendChild(opt);
            });
        }

        function previewImages(input, previewContainerId) {
            var previewContainer = document.getElementById(previewContainerId);
            previewContainer.innerHTML = '';
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    var div = document.createElement('div');
                    div.className = 'preview-img';
                    div.appendChild(img);
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    </script>
</head>
<body>
<header>
    <h1>IZISHOP - E-Commerce</h1>
</header>
<div class="container">
    <h2>Enregistrer Produits/Prestations</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" id="type" name="type">

        <div class="form-group">
            <label for="selectType">Sélectionnez la catégorie principale:</label>
            <select id="selectType" class="form-control" onchange="loadSubcategories(this.value)">
                <option value="">-- Sélectionner --</option>
                <?php
                if ($result_categories->num_rows > 0) {
                    while ($row = $result_categories->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['categorie_principale']) . '">' . htmlspecialchars($row['categorie_principale']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Formulaire de service -->
        <div id="serviceForm" style="display:none;">
            <div class="form-group">
                <label for="serviceSubcategory">Sous-catégorie de Prestation:</label>
                <select id="serviceSubcategory" name="subcategory" class="form-control">
                    <!-- Les options seront chargées dynamiquement par JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="serviceName">Libellé:</label>
                <input type="text" id="serviceName" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="servicePrice">Prix:</label>
                <input type="number" id="servicePrice" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="serviceImages">Images:</label>
                <input type="file" id="serviceImages" name="images[]" class="form-control" multiple onchange="previewImages(this, 'serviceImagesPreview')">
            </div>

            <div class="form-group">
                <label for="serviceDescription">Déscription:</label>
                
                <textarea type="text" id="serviceDescription" name="description" class="form-control" required>

                </textarea>
            </div>

            <div id="serviceImagesPreview" class="mb-3"></div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
<footer>
    <p>© 2024 IZISHOP. Tous droits réservés.</p>
</footer>
<script>
    function resetForm() {
        document.querySelector('form').reset();
        document.getElementById('serviceForm').style.display = 'none';
    }

    document.getElementById('selectType').addEventListener('change', function() {
        var type = this.value === '1' ? 'product' : 'service';
        document.getElementById('type').value = type;
        document.getElementById('serviceForm').style.display = (type === 'service') ? 'block' : 'none';
    });
</script>
</body>
</html>
