<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichiers d'Immigration</title>
    <style>

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
        h3 {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 5px;
        }
        a {
            color: #007bff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        a:hover {
            text-decoration: underline;
        }
        .file-icon {
            width: 24px;
            height: 24px;
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Affichage des Fichiers d'Immigration</h1>
    <?php
    // Récupérer les types d'immigration distincts
    $sql = "SELECT DISTINCT type_immigration FROM fichiers_immigration";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Affichage des colonnes par type d'immigration
        while ($row = $result->fetch_assoc()) {
            $typeImmigration = $row["type_immigration"];
            echo "<h2>$typeImmigration</h2>";

            // Récupérer les étapes pour chaque type d'immigration
            $sql_etape = "SELECT DISTINCT etape FROM fichiers_immigration WHERE type_immigration = '$typeImmigration'";
            $result_etape = $conn->query($sql_etape);

            if ($result_etape->num_rows > 0) {
                // Affichage des sous-colonnes par étape
                echo "<div style='display:flex; flex-wrap: wrap;'>";
                while ($row_etape = $result_etape->fetch_assoc()) {
                    $etape = $row_etape["etape"];
                    echo "<div style='margin-right: 20px; margin-bottom: 20px;'>";
                    echo "<h3>Étape $etape</h3>";

                    // Récupérer les fichiers pour chaque étape et type d'immigration
                    $sql_files = "SELECT * FROM fichiers_immigration WHERE type_immigration = '$typeImmigration' AND etape = $etape";
                    $result_files = $conn->query($sql_files);

                    if ($result_files->num_rows > 0) {
                        // Affichage des fichiers
                        echo "<ul>";
                        while ($row_file = $result_files->fetch_assoc()) {
                            $nomFichier = $row_file["nom_fichier"];
                            $cheminFichier = $row_file["chemin_fichier"];
                            $extension = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
                            $iconPath = "icons/$extension-icon.png";
                            if (!file_exists($iconPath)) {
                                // Si l'icône pour cette extension n'existe pas, utiliser une icône par défaut
                                $iconPath = "uploads/immig/iconepdf.png";
                            }
                            echo "<li><a href='uploads/immig/$cheminFichier' download><img src='$iconPath' alt='$extension' class='file-icon'>$nomFichier</a></li>";
                        }                        echo "</ul>";
                    } else {
                        echo "Aucun fichier trouvé.";
                    }
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "Aucune étape trouvée pour ce type d'immigration.";
            }
        }
    } else {
        echo "Aucun type d'immigration trouvé.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>

                       
