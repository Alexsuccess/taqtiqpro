<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les champs sont définis et non vides
    if (isset($_POST['categorie_principale']) && isset($_POST['sous_categorie'])) {
        // Récupérer les données du formulaire
        $categorie_principale = $_POST['categorie_principale'];
        $sous_categorie = $_POST['sous_categorie'];
        
        // Connexion à la base de données (à adapter avec vos informations de connexion)
        $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

        // Vérifier la connexion
        if (!$con) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }

        // Échapper les données pour éviter les injections SQL
        $categorie_principale = mysqli_real_escape_string($con, $categorie_principale);
        $sous_categorie = mysqli_real_escape_string($con, $sous_categorie);

        // Requête SQL pour insérer la catégorie et la sous-catégorie dans la table
        $sql = "INSERT INTO categories22 (categorie_principale, sous_categorie) 
                VALUES ('$categorie_principale', '$sous_categorie')";

        // Exécuter la requête d'insertion
        if (mysqli_query($con, $sql)) {
            echo "Catégorie et sous-catégorie enregistrées avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement de la catégorie et de la sous-catégorie : " . mysqli_error($con);
        }

        // Fermer la connexion à la base de données
        mysqli_close($con);
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Catégorie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
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
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
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
<body>
    <h1>Ajouter une Catégorie et une Sous-catégorie</h1>

    <form action="" method="POST">
        <label for="categorie_principale">Catégorie Principale :</label>
        <select name="categorie_principale" id="categorie_principale" required>
            <option value="Prestation">Prestation</option>
           <option value="Produits">Produit</option>
        </select>

        <label for="sous_categorie">Sous-catégorie :</label>
        <input type="text" name="sous_categorie" id="sous_categorie" required>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
