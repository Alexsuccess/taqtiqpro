<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        h1 {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom_produit = $_POST["nom_produit"];
    $description = $_POST["description"];
    $categorie_id = $_POST["id"]; // C'est l'ID de la catégorie
    $prix = $_POST["prix"];
    $image = $_FILES["image"]["name"];
    $target_directory = "uploads/images/";

    // Vérifiez que le répertoire de destination existe, sinon, créez-le
    if (!file_exists($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    // Chemin complet du fichier cible
    $target_file = $target_directory . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Connexion à la base de données (à adapter avec vos informations de connexion)
        $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

        if (!$con) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }

        // Requête SQL pour insérer les données du produit dans la table produits
        $sql = "INSERT INTO produits2 (nom_produits, description, categorie_id, prix, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        // Liaison des valeurs aux paramètres de la requête
        mysqli_stmt_bind_param($stmt, "ssids", $nom_produit, $description, $categorie_id, $prix, $image);

        if (mysqli_stmt_execute($stmt)) {
            echo "Le produit a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du produit : " . mysqli_error($con);
        }

        // Fermez la connexion à la base de données
        mysqli_close($con);
    } else {
        echo "Erreur lors de l'upload de l'image.";
    }
}
?>


<body>
    <h1>Page d'Administration</h1>

    <form action=" " method="POST" enctype="multipart/form-data">
        <label for="nom_produit">Nom du Produit:</label>
        <input type="text" name="nom_produit" id="nom_produit" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>



<?php

                $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

                if (!$con) {
                    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
                }

$rslteleveex = $con->query("select * from categories2 ") or die(mysqli_error($con));
        //include ('stagetpconnexion/bd.php');
?>

<label class="control-label">Catégorie</label>
<div class="inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <select name="id" id="id" class="validate[required] text-input form-control">
            <option value="" selected="selected">- Choisissez une catégorie -</option>
            <?php
            while ($rowelevex = mysqli_fetch_assoc($rslteleveex)) {
            ?>
            <option value="<?php echo $rowelevex["id"]; ?>" <?php if ($rowelevex["id"]) { ?> selected <?php } ?>>
                <?php echo $rowelevex["nom_produit"]; ?>
            </option>
            <?php
            }
            ?>
        </select>
    </div>
</div>







        <label for="prix">Prix:</label>
        <input type="number" name="prix" id="prix" required>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <input type="submit" value="Ajouter le Produit">
    </form>
</body>
</html>


