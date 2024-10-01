<?php
// Vérifiez d'abord si l'ID de la catégorie à supprimer est présent dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connexion à la base de données (à adapter avec vos informations de connexion)
    $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

    if (!$con) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Requête SQL pour supprimer la catégorie en fonction de l'ID
    $sql = "DELETE FROM categories22 WHERE id = $id";

    // Exécutez la requête de suppression
    if (mysqli_query($con, $sql)) {
        // Redirigez l'utilisateur vers la page "table.php" après la suppression
        header("Location: table.php");
    } else {
        echo "Erreur lors de la suppression de la catégorie : " . mysqli_error($con);
    }

    // Fermez la connexion à la base de données
    mysqli_close($con);
}
?>





