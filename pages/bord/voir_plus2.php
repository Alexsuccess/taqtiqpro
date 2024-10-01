<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Aucun candidat trouvé.";
        exit;
    }
} else {
    echo "ID de candidat manquant.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Candidat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
            max-width: 900px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h4 {
            color: #007bff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-check-label {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Fiche employé- campagnes</h1>
        <form>
            <div class="form-group">
                <label for="employeeType">Type d’employé (temps plein/partiel)</label>
                <input type="text" class="form-control" id="employeeType" value="<?php echo $row['employee_type']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="employeeID">ID</label>
                <input type="text" class="form-control" id="employeeID" value="<?php echo $row['employee_id']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" class="form-control" id="occupation" value="<?php echo $row['occupation']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="hireDate">Date d’embauche</label>
                <input type="date" class="form-control" id="hireDate" value="<?php echo $row['hire_date']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="employeeNumber">Employé #</label>
                <input type="text" class="form-control" id="employeeNumber" value="<?php echo $row['employee_number']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="civility">Civilité</label>
                <input type="text" class="form-control" id="civility" value="<?php echo $row['civility']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="lastName">Nom de naissance</label>
                <input type="text" class="form-control" id="lastName" value="<?php echo $row['last_name']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" id="firstName" value="<?php echo $row['first_name']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="contactInfo">Coordonnées</label>
                <input type="text" class="form-control" id="contactInfo" value="<?php echo $row['contact_info']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="sex">Sexe</label>
                <input type="text" class="form-control" id="sex" value="<?php echo $row['sex']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" value="<?php echo $row['address']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" class="form-control" id="phone" value="<?php echo $row['phone']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="ssn"># sécurité sociale</label>
                <input type="text" class="form-control" id="ssn" value="<?php echo $row['ssn']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="siret">Siret #</label>
                <input type="text" class="form-control" id="siret" value="<?php echo $row['siret']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="urssaf">Urssaf #</label>
                <input type="text" class="form-control" id="urssaf" value="<?php echo $row['urssaf']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="apeCode">Code APE</label>
                <input type="text" class="form-control" id="apeCode" value="<?php echo $row['ape_code']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="birthDate">Date de naissance</label>
                <input type="date" class="form-control" id="birthDate" value="<?php echo $row['birth_date']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="maritalStatus">État matrimonial</label>
                <input type="text" class="form-control" id="maritalStatus" value="<?php echo $row['marital_status']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="children">Nombre d’enfants</label>
                <input type="text" class="form-control" id="children" value="<?php echo $row['children']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="pets">Animaux de compagnie</label>
                <input type="text" class="form-control" id="pets" value="<?php echo $row['pets']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="jobTitle">Titre du poste</label>
                <input type="text" class="form-control" id="jobTitle" value="<?php echo $row['job_title']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="supervisor">Superviseur</label>
                <input type="text" class="form-control" id="supervisor" value="<?php echo $row['supervisor']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="associatedBroker">Courtier associé</label>
                <input type="text" class="form-control" id="associatedBroker" value="<?php echo $row['associated_broker']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="department">Département</label>
                <input type="text" class="form-control" id="department" value="<?php echo $row['department']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="workingHours">Heures de travail</label>
                <input type="text" class="form-control" id="workingHours" value="<?php echo $row['working_hours']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="shift">Quart de travail</label>
                <input type="text" class="form-control" id="shift" value="<?php echo $row['shift']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="workBonus">Prime de travail</label>
                <input type="text" class="form-control" id="workBonus" value="<?php echo $row['work_bonus']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="totalSales">Total des ventes</label>
                <input type="number" class="form-control" id="totalSales" value="<?php echo $row['total_sales']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="averageSales">Ventes moyennes</label>
                <input type="number" class="form-control" id="averageSales" value="<?php echo $row['average_sales']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="discount">Ristourne</label>
                <input type="text" class="form-control" id="discount" value="<?php echo $row['discount']; ?>" readonly>
            </div>
        </form>
        <a href="hum2.php" class="btn btn-secondary btn-block">Retour à la liste</a>
    </div>
</body>
</html>
