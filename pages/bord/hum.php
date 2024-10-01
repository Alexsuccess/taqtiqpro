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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_type = $_POST['employeeType'];
    $employee_id = $_POST['employeeID'];
    $occupation = $_POST['occupation'];
    $hire_date = $_POST['hireDate'];
    $employee_number = $_POST['employeeNumber'];
    $civility = $_POST['civility'];
    $last_name = $_POST['lastName'];
    $first_name = $_POST['firstName'];
    $contact_info = $_POST['contactInfo'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $ssn = $_POST['ssn'];
    $siret = $_POST['siret'];
    $urssaf = $_POST['urssaf'];
    $ape_code = $_POST['apeCode'];
    $birth_date = $_POST['birthDate'];
    $marital_status = $_POST['maritalStatus'];
    $children = $_POST['children'];
    $pets = $_POST['pets'];
    $job_title = $_POST['jobTitle'];
    $supervisor = $_POST['supervisor'];
    $associated_broker = $_POST['associatedBroker'];
    $department = $_POST['department'];
    $working_hours = $_POST['workingHours'];
    $shift = $_POST['shift'];
    $work_bonus = $_POST['workBonus'];
    $total_sales = $_POST['totalSales'];
    $average_sales = $_POST['averageSales'];
    $discount = $_POST['discount'];
    $work_hours = implode(",", $_POST['workHours']);
    $affiliations = implode(",", $_POST['affiliations']);
    $insurance = implode(",", $_POST['insurance']);
    $work_shift = $_POST['workShift'];
    $websites = implode(",", $_POST['websites']);

    $sql = "INSERT INTO employees (
                employee_type, employee_id, occupation, hire_date, employee_number, 
                civility, last_name, first_name, contact_info, sex, address, phone, 
                email, ssn, siret, urssaf, ape_code, birth_date, marital_status, 
                children, pets, job_title, supervisor, associated_broker, department, 
                working_hours, shift, work_bonus, total_sales, average_sales, discount, 
                work_hours, affiliations, insurance, work_shift, websites
            ) VALUES (
                '$employee_type', '$employee_id', '$occupation', '$hire_date', '$employee_number',
                '$civility', '$last_name', '$first_name', '$contact_info', '$sex', '$address', '$phone',
                '$email', '$ssn', '$siret', '$urssaf', '$ape_code', '$birth_date', '$marital_status',
                '$children', '$pets', '$job_title', '$supervisor', '$associated_broker', '$department',
                '$working_hours', '$shift', '$work_bonus', '$total_sales', '$average_sales', '$discount',
                '$work_hours', '$affiliations', '$insurance', '$work_shift', '$websites'
            )";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel enregistrement créé avec succès";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Employé</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-check-label {
            margin-right: 15px;
        }
    </style>

        <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #343a40;
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

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-control, .form-check-input {
            border-radius: 5px;
        }

        .form-control:focus, .form-check-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        .section-title {
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-label {
            margin-right: 15px;
        }
    </style>
</head>

<body style="background-color: rgb(0,0, 64);">
    <div class="container">
        <h2 class="my-4">Fiche employé- campagnes</h2>
        <form id="employeeForm" action="" method="POST">
            <div class="form-group">
                <label for="employeeType">Type d’employé</label>
                <select class="form-control" id="employeeType" name="employeeType" required>
                    <option value="temps plein">Temps plein</option>
                    <option value="temps partiel">Temps partiel</option>
                </select>
            </div>
            <div class="form-group">
                <label for="employeeID">Code d'accès</label>
                <input type="text" class="form-control" id="employeeID" name="employeeID" required>
            </div>
            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" class="form-control" id="occupation" name="occupation" required>
            </div>
            <div class="form-group">
                <label for="hireDate">Date d’embauche</label>
                <input type="date" class="form-control" id="hireDate" name="hireDate" required>
            </div>
            <div class="form-group">
                <label for="employeeNumber">Employé #</label>
                <input type="text" class="form-control" id="employeeNumber" name="employeeNumber" required>
            </div>
            <div class="form-group">
                <label for="civility">Civilité</label>
                <input type="text" class="form-control" id="civility" name="civility" required>
            </div>
            <div class="form-group">
                <label for="lastName">Nom de naissance</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="contactInfo">Coordonnées</label>
                <input type="text" class="form-control" id="contactInfo" name="contactInfo" required>
            </div>
            <div class="form-group">
                <label for="sex">Sexe</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="male" value="homme" required>
                    <label class="form-check-label" for="male">Homme</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="female" value="femme" required>
                    <label class="form-check-label" for="female">Femme</label>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="ssn"># Sécurité Sociale</label>
                <input type="text" class="form-control" id="ssn" name="ssn" required>
            </div>
            <div class="form-group">
                <label for="siret">Siret #</label>
                <input type="text" class="form-control" id="siret" name="siret" required>
            </div>
            <div class="form-group">
                <label for="urssaf">Urssaf #</label>
                <input type="text" class="form-control" id="urssaf" name="urssaf" required>
            </div>
            <div class="form-group">
                <label for="apeCode">Code APE</label>
                <input type="text" class="form-control" id="apeCode" name="apeCode" required>
            </div>
            <div class="form-group">
                <label for="birthDate">Date de naissance</label>
                <input type="date" class="form-control" id="birthDate" name="birthDate" required>
            </div>
            <div class="form-group">
                <label for="maritalStatus">Situation conjugale</label>
                <select class="form-control" id="maritalStatus" name="maritalStatus" required>
                    <option value="célibataire">Célibataire</option>
                    <option value="marié">Marié</option>
                    <option value="conjoint de fait">Conjoint de fait</option>
                </select>
            </div>
            <div class="form-group">
                <label for="children">Nombre d’enfants</label>
                <input type="number" class="form-control" id="children" name="children" required>
            </div>
            <div class="form-group">
                <label for="pets">Animaux : nom de l‘animal</label>
                <input type="text" class="form-control" id="pets" name="pets">
            </div>
            <div class="form-group">
                <label for="jobTitle">Fonction/ profession</label>
                <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
            </div>
            <div class="form-group">
                <label for="supervisor">Responsable de l’employé</label>
                <input type="text" class="form-control" id="supervisor" name="supervisor" required>
            </div>
            <div class="form-group">
                <label for="associatedBroker">Courtier associé</label>
                <input type="text" class="form-control" id="associatedBroker" name="associatedBroker" required>
            </div>
            <div class="form-group">
                <label for="department">Département</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>
            <div class="form-group">
                <label for="workingHours">Nombre d’heures</label>
                <input type="number" class="form-control" id="workingHours" name="workingHours" required>
            </div>
            <div class="form-group">
                <label for="shift">Quart de travail</label>
                <input type="text" class="form-control" id="shift" name="shift" required>
            </div>
            <div class="form-group">
                <label for="workBonus">Prime de travail</label>
                <input type="number" class="form-control" id="workBonus" name="workBonus" required>
            </div>
            <div class="form-group">
                <label for="totalSales">Total des ventes</label>
                <input type="number" class="form-control" id="totalSales" name="totalSales" required>
            </div>
            <div class="form-group">
                <label for="averageSales">Ventes moyennes</label>
                <input type="number" class="form-control" id="averageSales" name="averageSales" required>
            </div>
            <div class="form-group">
                <label for="discount">Ristourne</label>
                <input type="number" class="form-control" id="discount" name="discount" required>
            </div>

            <h4 class="mt-4">Heures de travail</h4>
            <div class="form-group">
                <label>Entrepreneurs</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="7h30-12h" id="entrepreneur1" name="workHours[]">
                    <label class="form-check-label" for="entrepreneur1">7h30-12h</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="7h30-17h" id="entrepreneur2" name="workHours[]">
                    <label class="form-check-label" for="entrepreneur2">7h30-17h</label>
                </div>
            </div>

            <div class="form-group">
                <label>Entreprises/commerçants/professionnels</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="9h-12h" id="enterprise1" name="workHours[]">
                    <label class="form-check-label" for="enterprise1">9h-12h</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="9h-17h" id="enterprise2" name="workHours[]">
                    <label class="form-check-label" for="enterprise2">9h-17h</label>
                </div>
            </div>

            <div class="form-group">
                <label>Maisons</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="9h-20h" id="house1" name="workHours[]">
                    <label class="form-check-label" for="house1">9h-20h</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="12h-20h" id="house2" name="workHours[]">
                    <label class="form-check-label" for="house2">12h-20h</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="16h-20h" id="house3" name="workHours[]">
                    <label class="form-check-label" for="house3">16h-20h</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="17h-20h" id="house4" name="workHours[]">
                    <label class="form-check-label" for="house4">17h-20h</label>
                </div>
            </div>

            <h4 class="mt-4">Départements (21 juillet 2022)</h4>
            <div class="form-group">
                <label for="department">Département</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="Téléprospection - Maison">Téléprospection - Maison</option>
                    <option value="Télévendeur pochettes/sites web interactifs/tunnels de ventes (2B)">Télévendeur pochettes/sites web interactifs/tunnels de ventes (2B)</option>
                    <option value="Télévendeur espaces publicitaires (Immonivo)">Télévendeur espaces publicitaires (Immonivo)</option>
                    <option value="Affiliations">Affiliations</option>
                    <option value="Immigration">Immigration</option>
                    <option value="Assurances">Assurances</option>
                </select>
            </div>

            <h4 class="mt-4">Affiliations</h4>
            <div class="form-group">
                <label>Affiliations</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Courtiers" id="affiliation1" name="affiliations[]">
                    <label class="form-check-label" for="affiliation1">Courtiers</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Entrepreneurs" id="affiliation2" name="affiliations[]">
                    <label class="form-check-label" for="affiliation2">Entrepreneurs</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Commerçants" id="affiliation3" name="affiliations[]">
                    <label class="form-check-label" for="affiliation3">Commerçants</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Professionnels" id="affiliation4" name="affiliations[]">
                    <label class="form-check-label" for="affiliation4">Professionnels</label>
                </div>
            </div>

            <h4 class="mt-4">Assurances</h4>
            <div class="form-group">
                <label>Assurances</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Client" id="insurance1" name="insurance[]">
                    <label class="form-check-label" for="insurance1">Client</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Entreprise" id="insurance2" name="insurance[]">
                    <label class="form-check-label" for="insurance2">Entreprise</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Entrepreneurs" id="insurance3" name="insurance[]">
                    <label class="form-check-label" for="insurance3">Entrepreneurs</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Courtiers" id="insurance4" name="insurance[]">
                    <label class="form-check-label" for="insurance4">Courtiers</label>
                </div>
            </div>

            <h4 class="mt-4">Horaires</h4>
            <div class="form-group">
                <label for="workingHours">Jour ou Soir</label>
                <select class="form-control" id="workShift" name="workShift" required>
                    <option value="Jour">Jour</option>
                    <option value="Soir">Soir</option>
                </select>
            </div>

            <h4 class="mt-4">Entreprises et sites web à venir (postes à combler)</h4>
            <div class="form-group">
                <label for="websites">Entreprises et sites web</label>
                <select class="form-control" id="websites" name="websites[]" multiple required>
                    <option value="Izishope">Izishope</option>
                    <option value="Immigration">Immigration</option>
                    <option value="Accès finance">Accès finance</option>
                    <option value="Immonivo">Immonivo</option>
                    <option value="Références X">Références X (leads)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>


</body>

</html>
