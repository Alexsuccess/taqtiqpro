<?php
// Configuration de connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Supprimer un employé
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM employees22 WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id); // 'i' pour un entier
    if ($stmt->execute()) {
        echo "Employé supprimé avec succès";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
}

// Accepter un employé (compléter les informations)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept'])) {
    // Récupérer les valeurs du formulaire
    $update_id = $_POST['update_id'];
    $supervisor = $_POST['supervisor'];
    $idd = $_POST['idd'];
    $occupation = $_POST['occupation'];
    $hireDate = $_POST['hireDate'];
    $employeeNumber = $_POST['employeeNumber'];
    $workBonus = $_POST['workBonus'];
    $totalSales = $_POST['totalSales'];
    $averageSales = $_POST['averageSales'];
    $discount = $_POST['discount'];
    $entrepreneursHours = $_POST['entrepreneursHours'];
    $eppHours = $_POST['eppHours'];
    $mapcHours = $_POST['mapcHours'];
    $maison = isset($_POST['maison']) ? 1 : 0;
    $televendeur1 = isset($_POST['televendeur1']) ? 1 : 0;
    $televendeur2 = isset($_POST['televendeur2']) ? 1 : 0;
    $affiliations = isset($_POST['affiliations']) ? 1 : 0;
    $immigration = isset($_POST['immigration']) ? 1 : 0;
    $assurances = isset($_POST['assurances']) ? 1 : 0;
    $entrepreneurs = isset($_POST['entrepreneurs']) ? 1 : 0;
    $entreprises = isset($_POST['entreprises']) ? 1 : 0;
    $commercants = isset($_POST['commercants']) ? 1 : 0;
    $professionnels = isset($_POST['professionnels']) ? 1 : 0;
    $workShift = $_POST['workShift'];
    $izishope = $_POST['izishope'];
    $immigrationSite = $_POST['immigrationSite'];
    $accessFinance = $_POST['accessFinance'];
    $immonivo = $_POST['immonivo'];
    $referencesX = $_POST['referencesX'];

    // Préparer la requête de mise à jour
    $sql = "UPDATE employees22 SET 
                supervisor = '$supervisor',
                idd = '$idd',
                occupation = '$occupation',
                hireDate = '$hireDate',
                employeeNumber = '$employeeNumber',
                workBonus = '$workBonus',
                totalSales = '$totalSales',
                averageSales = '$averageSales',
                discount = '$discount',
                entrepreneursHours = '$entrepreneursHours',
                eppHours = '$eppHours',
                mapcHours = '$mapcHours',
                maison = '$maison',
                televendeur1 = '$televendeur1',
                televendeur2 = '$televendeur2',
                affiliations = '$affiliations',
                immigration = '$immigration',
                assurances = '$assurances',
                entrepreneurs = '$entrepreneurs',
                entreprises = '$entreprises',
                commercants = '$commercants',
                professionnels = '$professionnels',
                workShift = '$workShift',
                izishope = '$izishope',
                immigrationSite = '$immigrationSite',
                accessFinance = '$accessFinance',
                immonivo = '$immonivo',
                referencesX = '$referencesX'
            WHERE id = '$update_id'";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
// Récupérer les employés de la base de données
$sql = "SELECT * FROM employees22";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h2, h3 {
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-check-inline {
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: rgb(0,0,64);
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

header .logo h1 {
    margin: 0;
    color: white;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    padding: 10px 15px;
    display: block;
    transition: background 0.3s;
}

nav ul li a:hover {
    background-color: #45a049;
}

.dropdown {
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    min-width: 160px;
    z-index: 1;
    top: 100;



body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #4CAF50;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

header .logo h1 {
    margin: 0;
    color: white;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    padding: 10px 15px;
    display: block;
    transition: background 0.3s;
}

nav ul li a:hover {
    background-color: #45a049;
}

.dropdown {
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    min-width: 160px;
    z-index: 1;
    top: 100%;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    transition: background 0.3s;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.arrow {
    border: solid white;
    border-width: 0 3px 3px 0;
    display: inline-block;
    padding: 3px;
    margin-left: 5px;
}

.down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
}

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: absolute;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>CRM : Gestion du personnel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../../admin.php">Accueil</a></li>
                <li><a href="../../admin.php">À propos</a></li>
                <li><a href="../../admin.php">Services</a></li>
         
                <li><a href="../../admin.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Gestion des Employés</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead class='thead-light'><tr><th>Nom</th><th>Prénom</th><th>Sexe</th><th>Email</th><th>Actions</th></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['sex'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>
                        <a href='?view_id=" . $row['id'] . "' class='btn btn-sm btn-info'>Voir plus</a>
                        <a href='?accept_id=" . $row['id'] . "' class='btn btn-sm btn-success'>Accepter</a>
                        <a href='#' onclick='ouvrirCV(" . $row['id'] . ")' class='btn btn-sm btn-success'>Détails</a>
                        <a href='?delete_id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Supprimer</a>
                      </td>";
                echo "</tr>";

                // Afficher les détails supplémentaires
                if (isset($_GET['view_id']) && $_GET['view_id'] == $row['id']) {
                    echo "<tr><td colspan='5'>
                            <strong>Détails supplémentaires :</strong><br>
                            Nom: " . $row['last_name'] . "<br>
                            Civilité: " . $row['civility'] . "<br>
                            Prénom Usuel: " . $row['usual_first_name'] . "<br>
                            Date de Naissance: " . $row['birth_date'] . "<br>
                            Adresse: " . $row['address'] . "<br>
                            Infos de Contact: " . $row['contact_info'] . "<br>
                            Ville: " . $row['city'] . "<br>
                            Pays: " . $row['country'] . "<br>
                            Téléphone: " . $row['phone'] . "<br>
                            SSN: " . $row['ssn'] . "<br>
                            SIRET: " . $row['siret'] . "<br>
                            URSSAF: " . $row['urssaf'] . "<br>
                            Statut Matrimonial: " . $row['marital_status'] . "<br>
                            Enfants: " . $row['children'] . "<br>
                            Heures de Travail: " . $row['working_hours'] . "<br>
                            Intitulé du Poste: " . $row['job_title'] . "<br>
                            Courtier: " . ($row['courtier'] ? 'Oui' : 'Non') . "<br>
                            Agent: " . ($row['agent'] ? 'Oui' : 'Non') . "<br>
                            Associé: " . ($row['associe'] ? 'Oui' : 'Non') . "<br>
                            Référence: " . ($row['reference'] ? 'Oui' : 'Non') . "<br>
                            Département: " . $row['department'] . "<br>
                            Nombre d'Heures: " . $row['number_hours'] . "<br>
                            Jour: " . ($row['jour'] ? 'Oui' : 'Non') . "<br>
                            Soir: " . ($row['soir'] ? 'Oui' : 'Non') . "<br>
                            Les 2: " . ($row['les2'] ? 'Oui' : 'Non') . "<br>
                            Type d'Employé: " . $row['employee_type'] . "<br>
                          </td></tr>";
                }

                // Afficher le formulaire pour compléter les informations
                if (isset($_GET['accept_id']) && $_GET['accept_id'] == $row['id']) {
                    echo <<<HTML
                    <form method="POST" action="" class="mt-3">
                        <input type="hidden" name="update_id" value="{$row['id']}">
            <h2>Pour l’interne après l’embauche</h2>

            <div class="form-group">
                <label for="supervisor">Responsable de l’employé</label>
                <input type="text" class="form-control" id="supervisor" name="supervisor">
            </div>

            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="idd" name="idd">
            </div>

            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" class="form-control" id="occupation" name="occupation">
            </div>

            <div class="form-group">
                <label for="hireDate">Date d’embauche</label>
                <input type="date" class="form-control" id="hireDate" name="hireDate">
            </div>

            <div class="form-group">
                <label for="employeeNumber">Employé #</label>
                <input type="text" class="form-control" id="employeeNumber" name="employeeNumber">
            </div>

            <div class="form-group">
                <label for="workBonus">Prime de travail</label>
                <input type="text" class="form-control" id="workBonus" name="workBonus">
            </div>

            <div class="form-group">
                <label for="totalSales">Total des ventes</label>
                <input type="number" class="form-control" id="totalSales" name="totalSales">
            </div>

            <div class="form-group">
                <label for="averageSales">Ventes moyennes</label>
                <input type="number" class="form-control" id="averageSales" name="averageSales">
            </div>

            <div class="form-group">
                <label for="discount">Ristourne</label>
                <input type="text" class="form-control" id="discount" name="discount">
            </div>

            <hr>

            <!-- Campagnes -->
            <h2>Campagnes</h2>
            <!-- Entrepreneurs -->
            <h3>Entrepreneurs</h3>
            <div class="form-group">
                <label>Horaires</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="entrepreneursHours" id="7h30-12h" value="7h30-12h">
                    <label class="form-check-label" for="7h30-12h">7h30-12h</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="entrepreneursHours" id="7h30-17h" value="7h30-17h">
                    <label class="form-check-label" for="7h30-17h">7h30-17h</label>
                </div>
            </div>

            <!-- Entreprises/commerçants/professionnels -->
            <h3>Entreprises/commerçants/professionnels</h3>
            <div class="form-group">
                <label>Horaires</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="eppHours" id="9h-12h" value="9h-12h">
                    <label class="form-check-label" for="9h-12h">9h à 12h</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="eppHours" id="9h-17h" value="9h-17h">
                    <label class="form-check-label" for="9h-17h">9h à 17h</label>
                </div>
            </div>

            <!-- Maisons / assurances particulier / commerciale -->
            <h3>Maisons / assurances particulier / commerciale</h3>
            <div class="form-group">
                <label>Horaires</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mapcHours" id="9h-20h" value="9h-20h">
                    <label class="form-check-label" for="9h-20h">9h à 20h</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mapcHours" id="12h-20h" value="12h-20h">
                    <label class="form-check-label" for="12h-20h">12h à 20h</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mapcHours" id="16h-20h" value="16h-20h">
                    <label class="form-check-label" for="16h-20h">16h à 20h</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mapcHours" id="17h-20h" value="17h-20h">
                    <label class="form-check-label" for="17h-20h">17h à 20h</label>
                </div>
            </div>

            <!-- Départements -->
            <h2>Départements</h2>
            <div class="form-group">
                <label for="teleprospection">Téléprospection</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="maison" name="maison" value="Maison">
                    <label class="form-check-label" for="maison">Maison</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="televendeur1" name="televendeur1" value="Télévendeur 1">
                    <label class="form-check-label" for="televendeur1">Télévendeur pochettes /sites web interactifs/ tunnels de ventes (2B)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="televendeur2" name="televendeur2" value="Télévendeur 2">
                    <label class="form-check-label" for="televendeur2">Télévendeur espaces publicitaires (Immonivo)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="affiliations" name="affiliations" value="Affiliations">
                    <label class="form-check-label" for="affiliations">Affiliations</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="immigration" name="immigration" value="Immigration">
                    <label class="form-check-label" for="immigration">Immigration</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="assurances" name="assurances" value="Assurances">
                    <label class="form-check-label" for="assurances">Assurances</label>
                </div>
            </div>

            <!-- Campagnes spécifiques -->
            <h3>Campagnes spécifiques</h3>
            <div class="form-group">
                <label for="specificCampaigns">Campagnes</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="entrepreneurs" name="entrepreneurs" value="Entrepreneurs">
                    <label class="form-check-label" for="entrepreneurs">Entrepreneurs</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="entreprises" name="entreprises" value="Entreprises">
                    <label class="form-check-label" for="entreprises">Entreprises</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="commercants" name="commercants" value="Commerçants">
                    <label class="form-check-label" for="commercants">Commerçants</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="professionnels" name="professionnels" value="Professionnels">
                    <label class="form-check-label" for="professionnels">Professionnels</label>
                </div>
            </div>

            <div class="form-group">
                <label for="workShift">Quart de travail</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="workShift" id="jourShift" name="jourShift" value="Jour">
                    <label class="form-check-label" for="jourShift">Jour</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="workShift" id="soirShift" name="soirShift" value="Soir">
                    <label class="form-check-label" for="soirShift">Soir</label>
                </div>
            </div>

            <hr>

            <!-- Entreprises et sites web à venir -->
            <h2>Entreprises et sites web à venir (postes à combler)</h2>
            <div class="form-group">
                <label for="izishope">Izishope</label>
                <input type="text" class="form-control" id="izishope" name="izishope">
            </div>

            <div class="form-group">
                <label for="immigrationSite">Immigration</label>
                <input type="text" class="form-control" id="immigrationSite" name="immigrationSite">
            </div>

            <div class="form-group">
                <label for="accessFinance">Accès finance</label>
                <input type="text" class="form-control" id="accessFinance" name="accessFinance">
            </div>

            <div class="form-group">
                <label for="immonivo">Immonivo</label>
                <input type="text" class="form-control" id="immonivo" name="immonivo">
            </div>

            <div class="form-group">
                <label for="referencesX">Références X (leads) a venir</label>
                <input type="text" class="form-control" id="referencesX" name="referencesX">
            </div>
                        <button type="submit" class="btn btn-primary" name="accept">Accepter</button>
                    </form>
HTML;
                }
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé";
        }
        ?>
    </div>


</body>

    
</html>

<?php
// Fermer la connexion
$conn->close();
?>
<script>
function ouvrirCV(userId) {
    var url = 'cv.php?user_id=' + userId;
    var windowName = 'DetailsUtilisateur';
    var windowFeatures = 'width=800,height=600,resizable=yes,scrollbars=yes';
    window.open(url, windowName, windowFeatures);
}
</script>
