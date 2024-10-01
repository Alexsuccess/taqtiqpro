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
        select {
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
    <h1>Modification de la catégorie</h1>

    <?php
    // Vérifiez d'abord si un ID est présent dans l'URL
    if (isset($_GET['id'])) {
        // Récupérez l'ID de l'URL
        $id = $_GET['id'];
        
        // Connexion à la base de données (à adapter avec vos informations de connexion)
        $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

        if (!$con) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }

        // Requête SQL pour récupérer la catégorie en fonction de l'ID
        $sql = "SELECT * FROM categories22 WHERE id = $id";
        
        // Exécutez la requête
        $result = mysqli_query($con, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // Récupérez les données de la catégorie
            $category = mysqli_fetch_assoc($result);
        } else {
            // Gérez le cas où aucune catégorie correspondante n'est trouvée
            echo "Catégorie non trouvée.";
            exit; // Vous pouvez rediriger l'utilisateur ou faire d'autres actions ici
        }
    }
    ?>

    <?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les champs sont définis et non vides
    if (isset($_POST['id']) && isset($_POST['categorie_principale']) && isset($_POST['sous_categorie'])) {
        // Récupérer les données du formulaire
        $id = $_POST['id'];
        $categorie_principale = $_POST['categorie_principale'];
        $sous_categorie = $_POST['sous_categorie'];
        
        // Connexion à la base de données (à adapter avec vos informations de connexion)
        $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

        // Vérifier la connexion
        if (!$con) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }

        // Échapper les données pour éviter les injections SQL
        $id = mysqli_real_escape_string($con, $id);
        $categorie_principale = mysqli_real_escape_string($con, $categorie_principale);
        $sous_categorie = mysqli_real_escape_string($con, $sous_categorie);

        // Requête SQL pour mettre à jour la catégorie dans la base de données
        $sql = "UPDATE categories22 SET categorie_principale = '$categorie_principale', sous_categorie = '$sous_categorie' WHERE id = $id";

        // Exécuter la requête de mise à jour
        if (mysqli_query($con, $sql)) {
            echo "La catégorie a été mise à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de la catégorie : " . mysqli_error($con);
        }

        // Fermer la connexion à la base de données
        mysqli_close($con);
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
}
?>


    <form action="" method="POST">
        <!-- Utilisez un champ caché pour l'ID -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label for="categorie_principale">Catégorie Principale :</label>
        <input type="text" name="categorie_principale" id="categorie_principale" required value="<?php echo $category['categorie_principale']; ?>">

        <label for="sous_categorie">Sous-catégorie :</label>
        <input type="text" name="sous_categorie" id="sous_categorie" required value="<?php echo $category['sous_categorie']; ?>">

        <input type="submit" value="Modifier la Catégorie">
    </form>
</body>
</html>
