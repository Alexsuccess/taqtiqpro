<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord de l'Administrateur</title>
    <style>

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        nav {
            background-color:rgb(0,0,64);
            color: black;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        nav select {
            background-color: white;
            color: black;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .search-input {
            width: 30%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Enregistrez vous produits / Services</h1>
    </header>
    <div class="container">
        <nav>
            <select id="select-option">
                <option value="categories2">Lister les Catégories</option>
                <option value="products">Lister les Produits</option>
                <option value="orders">Lister les Commandes</option>
            </select>
        </nav>

        <div id="categories2-table" style="display: none;">
            <h2>Liste des Catégories</h2>
            <input type="text" class="search-input" id="categories2-search" placeholder="Rechercher dans les Catégories">
            <table>
                <button value="valeurs de target01" onclick="OuvrirFenetre('ajouter1.php')" class="btn">Ajouter</button>
                <tr>
                    <th>categorie_principale</th>
                    <th>sous categorie</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Assurez-vous d'avoir une connexion à la base de données
                $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

                if (!$con) {
                    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
                }

                $query = "SELECT * FROM categories22";
                $result = mysqli_query($con, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['categorie_principale']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sous_categorie']) . "</td>";
                    echo "<td>";
                    echo '<a class="btn btn-edit" value="valeurs de target01" onclick="OuvrirFenetre(\'modif1.php?id='.$row['id'].'\')">Modifier</a>';
                    echo '<a class="btn btn-delete" href="supprimer.php?id=' . $row['id'] . '">Supprimer</a>';
                    echo "</td>";
                    echo "</tr>";
                }

                mysqli_close($con);
                ?>
            </table>
        </div>

        <div id="products-table" style="display: none;">
            <h2>Liste des Produits</h2>
            <input type="text" class="search-input" id="products-search" placeholder="Rechercher dans les Produits">
            <table>
                <button value="valeurs de target01" onclick="OuvrirFenetre('enregistrer.php')" class="btn">Ajouter</button>
                <tr>
                    <th>Catégorie</th>
                    <th>Nom du Produit / Prestation</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                    
                </tr>
                <?php
                $con = mysqli_connect("4w0vau.myd.infomaniak.com", "4w0vau_dreamize", "Pidou2016", "4w0vau_dreamize");

                if (!$con) {
                    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
                }

                $queryy = "SELECT * FROM servicess as dd LEFT JOIN categories22 as xxd ON xxd.id = dd.category_id";
                $resulty = mysqli_query($con, $queryy);

                while ($row = mysqli_fetch_assoc($resulty)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['categorie_principale']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                   $image_files = explode(';', $row['images']);

echo "<td style='width: 100px; height: 100px;'>";
foreach ($image_files as $image) {
    $image = trim($image); // Enlever les espaces blancs autour
    if (!empty($image)) { // Vérifier que le nom du fichier n'est pas vide
        echo "<img src='uploads/services/" . htmlspecialchars($image) . "' alt='Image' style='max-width: 100px; max-height: 100px; margin: 2px;'>";
    }
}
echo "</td>";
                    
                    echo "</tr>";
                }

                mysqli_close($con);
                ?>
            </table>
        </div>

        <div id="orders-table" style="display: none;">
            <h2>Liste des Commandes</h2>
            <input type="text" class="search-input" id="orders-search" placeholder="Rechercher dans les Commandes">
            <table>
                <tr>
                    <th>ID de la Commande</th>
                    <th>Date de la Commande</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                <!-- Remplissez cette table avec des données de la base de données -->
                <tr>
                    <td>Commande #1</td>
                    <td>01/01/2023</td>
                    <td>En attente</td>
                    <td>
                        <button style="background-color: blue;" class="btn">Voir</button>
                        <button class="btn">Valider</button>
                        <button style="background-color: red;" class="btn">Supprimer</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<br><br><br><br>
    <footer>
        <p>© 2024 IZISHOP




<script>
    const selectOption = document.getElementById('select-option');
    const categories2Table = document.getElementById('categories2-table');
    const productsTable = document.getElementById('products-table');
    const ordersTable = document.getElementById('orders-table');
    const categories2Search = document.getElementById('categories2-search');
    const productsSearch = document.getElementById('products-search');
    const ordersSearch = document.getElementById('orders-search');

    selectOption.addEventListener('change', function() {
        categories2Table.style.display = 'none';
        productsTable.style.display = 'none';
        ordersTable.style.display = 'none';

        if (selectOption.value === 'categories2') {
            categories2Table.style.display = 'block';
        } else if (selectOption.value === 'products') {
            productsTable.style.display = 'block';
        } else if (selectOption.value === 'orders') {
            ordersTable.style.display = 'block';
        }
    });

    categories2Search.addEventListener('input', function() {
        searchTable(categories2Table, categories2Search.value);
    });

    productsSearch.addEventListener('input', function() {
        searchTable(productsTable, productsSearch.value);
    });

    ordersSearch.addEventListener('input', function() {
        searchTable(ordersTable, ordersSearch.value);
    });

    function searchTable(table, searchText) {
        const rows = table.getElementsByTagName('tr');

        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchText.toLowerCase())) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>
<script language="JavaScript" type="text/javascript">
    function OuvrirFenetre(url) {
        var nomFenetre = "fenetre_" + new Date().getTime(); // Génère un nom de fenêtre unique
        window.open(url, nomFenetre, "width=600,height=600,resizable=1,scrollbars=0,top=100,left=10");
    }
</script>
