<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Importation de données Excel</title>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Importation de données Excel</title>
  <style>
      input[type="file"] {
          display: none;
      }
      label {
          background-color: #3498db;
          color: #fff;
          padding: 10px 15px;
          border-radius: 5px;
          cursor: pointer;
      }
      .table-wrapper {
          max-width: 280%;
          overflow-x: auto; /* Ajouté pour permettre le défilement horizontal */
      }
      table {
          width: 1600px; /* Largeur fixe pour illustrer le défilement horizontal */
          border-collapse: collapse;
          margin-top: 20px;
      }
      table, th, td {
          border: 1px solid #ddd;
      }
      th, td {
          padding: 8px;
          text-align: left;
      }
  </style>

  <style>
    /* Existing styles */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a {
        color: #3498db;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
        border-radius: 5px;
    }
    .pagination a:hover {
        background-color: #3498db;
        color: white;
    }
  </style>

  <style>
    /* Existing styles */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a {
        color: #3498db;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
        border-radius: 5px;
    }
    .pagination a:hover {
        background-color: #3498db;
        color: white;
    }
  </style>
</head>
<body>
  <div style="margin-left: -3.5%;" class="container"><br>
      <h2>Importation de données Excel vers la base de données</h2><br>
      <form action="" method="post" enctype="multipart/form-data">
          <label for="file">Sélectionnez un fichier CSV</label>
          <input type="file" id="file" name="file" accept=".csv, .xlsx, .xls">
          <input type="submit" name="import" value="Importer">
      </form>
      
      <form method="GET" action="admin.php">
          <input type="hidden" name="page" value="<?php echo base64_encode('pages/import/import'); ?>">
          <input type="text" name="search" placeholder="Rechercher...">
          <input type="submit" value="Rechercher">
      </form>

<?php
// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Pagination settings
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET["page_number"]) ? intval($_GET["page_number"]) : 1;
if ($page < 1) $page = 1; // Ensure page is at least 1
$start_from = ($page - 1) * $limit;

// Recherche
$search_query = "";
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $search_query = "AND (Categorie LIKE '%$search%' OR Organisations LIKE '%$search%' OR Prenom LIKE '%$search%' OR Nom LIKE '%$search%' OR Courriel LIKE '%$search%' OR Ville LIKE '%$search%')";
}

$sql = "SELECT * FROM client WHERE Organisations != '' $search_query LIMIT $start_from, $limit";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='width: 280%;' class='table-wrapper'>";
    echo "<table>";
    echo "<thead><tr>";
    echo "<th>Catégorie</th><th>Organisations</th><th>Prénom</th><th>Nom</th><th>Courriel</th><th>Ville</th><th>Tel Organisation</th><th>Tel Cellulaire</th><th>Tel Contact</th><th>Adresse</th><th>No APCHQ</th><th>NEQ</th><th>No RBQ</th><th>No ENL</th><th>Sous-Catégories Licence</th><th>Vendeur</th><th>No Répondant</th>";
    echo "</tr></thead><tbody>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Categorie"] . "</td>";
        echo "<td>" . $row["Organisations"] . "</td>";
        echo "<td>" . $row["Prenom"] . "</td>";
        echo "<td>" . $row["Nom"] . "</td>";
        echo "<td>" . $row["Courriel"] . "</td>";
        echo "<td>" . $row["Ville"] . "</td>";
        echo "<td>" . $row["Tel_Organisation"] . "</td>";
        echo "<td>" . $row["Tel_Celulaire"] . "</td>";
        echo "<td>" . $row["Tel_Contact"] . "</td>";
        echo "<td>" . $row["Adresse"] . "</td>";
        echo "<td>" . $row["No_APCHQ"] . "</td>";
        echo "<td>" . $row["NEQ"] . "</td>";
        echo "<td>" . $row["No_RBQ"] . "</td>";
        echo "<td>" . $row["No_ENL"] . "</td>";
        echo "<td>" . $row["Sous_Categories_Licence"] . "</td>";
        echo "<td>" . $row["VENDEUR"] . "</td>";
        echo "<td>" . $row["No_Repondant"] . "</td>";
        echo "</tr>";
    }
    
    // Pagination
    $sql = "SELECT COUNT(id_client) FROM client WHERE Organisations != '' $search_query";
    $rs_result = $conn->query($sql);
    $row = $rs_result->fetch_row();
    $total_records = $row[0];
    $total_pages = ceil($total_records / $limit);

    $current_group = ceil($page / 10); // Calculate current group of 10 pages
    $start_group = ($current_group - 1) * 10 + 1; // Start page of the current group
    $end_group = min($start_group + 9, $total_pages); // End page of the current group

    $pagLink = "<div style='margin-left : -25%;' class='pagination'>";
    if ($current_group > 1) {
        $prev_group_page = $start_group - 1;
        $pagLink .= "<a href='admin.php?page=".base64_encode('pages/import/import')."&page_number=".$prev_group_page."&search=".$search."'>Précédent</a>";
    }

    for ($i = $start_group; $i <= $end_group; $i++) {
        $pagLink .= "<a href='admin.php?page=".base64_encode('pages/import/import')."&page_number=".$i."&search=".$search."'>".$i."</a>";
    }

    if ($current_group * 10 < $total_pages) {
        $next_group_page = $end_group + 1;
        $pagLink .= "<a href='admin.php?page=".base64_encode('pages/import/import')."&page_number=".$next_group_page."&search=".$search."'>Suivant</a>";
    }

    $pagLink .= "</div>";
    echo $pagLink;

    echo "</tbody></table></div>";
} else {
    echo "<p class='text-center'>Aucun client trouvé.</p>";
}

$conn->close();
?>

  </div>
</body>
</html>

<?php
if (isset($_POST['import'])) {
    $file = $_FILES['file']['tmp_name'];

    // Connexion à la base de données
    $conn = new mysqli("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $handle = fopen($file, "r");
    if ($handle) {
        while (($data = fgetcsv($handle, 0, ";")) !== false) {
            // Convertir les données en UTF-8
            $data = array_map('utf8_encode', $data);

            $Categorie = trim($data[0]);
            $Organisations = trim($data[1]);
            $Prenom = trim($data[2]);
            $Nom = trim($data[3]);
            $Courriel = trim($data[4]);
            $Ville = trim($data[5]);
            $Tel_Organisation = trim($data[6]);
            $Tel_Celulaire = trim($data[7]);
            $Tel_Contact = trim($data[8]);
            $Adresse = trim($data[9]);
            $No_APCHQ = trim($data[10]);
            $NEQ = trim($data[11]);
            $No_RBQ = trim($data[12]);
            $No_ENL = trim($data[13]);
            $Sous_Categories_Licence = trim($data[14]);
            $VENDEUR = trim($data[15]);
            $No_Repondant = trim($data[16]);

            // Hachage du mot de passe
            $password = password_hash('1234', PASSWORD_BCRYPT);

            // Insérer les données dans la table `client`
            $query = "INSERT INTO client (Categorie, Organisations, Prenom, Nom, Courriel, Ville, Tel_Organisation, Tel_Celulaire, Tel_Contact, Adresse, No_APCHQ, NEQ, No_RBQ, No_ENL, Sous_Categories_Licence, VENDEUR, No_Repondant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("sssssssssssssssss", $Categorie, $Organisations, $Prenom, $Nom, $Courriel, $Ville, $Tel_Organisation, $Tel_Celulaire, $Tel_Contact, $Adresse, $No_APCHQ, $NEQ, $No_RBQ, $No_ENL, $Sous_Categories_Licence, $VENDEUR, $No_Repondant);
                if ($stmt->execute()) {
                    // Données insérées avec succès dans la table `client`
                } else {
                    // Erreur d'insertion dans la table `client`
                    echo "Erreur: " . $stmt->error;
                }
                $stmt->close();
            } else {
                // Erreur de préparation de la requête pour `client`
                echo "Erreur: " . $conn->error;
            }

            // Insérer les données dans la table `userss`
            $query = "INSERT INTO userss (compte, nom, prenom, email, telephone, password, profile_pic, type, statut, created_at) VALUES ('Entreprise', ?, ?, ?, ?, ?, 'papa.jpg', ?, '1', now())";
            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ssssss", $Nom, $Prenom, $Courriel, $Tel_Celulaire, $password, $Organisations);
                if ($stmt->execute()) {
                    // Données insérées avec succès dans la table `userss`
                } else {
                    // Erreur d'insertion dans la table `userss`
                    echo "Erreur: " . $stmt->error;
                }
                $stmt->close();
            } else {
                // Erreur de préparation de la requête pour `userss`
                echo "Erreur: " . $conn->error;
            }
        }
        fclose($handle);
    } else {
        echo "Erreur lors de l'ouverture du fichier.";
    }

    $conn->close();
    header('Location: #'); // Rediriger vers la page d'importation
}
?>
