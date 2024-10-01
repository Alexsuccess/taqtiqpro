<?php
// Configurer les informations de connexion à la base de données
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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $civility = $_POST['civility'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $usualFirstName = $_POST['usualFirstName'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $contactInfo = $_POST['contactInfo'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $ssn = $_POST['ssn'];
    $siret = $_POST['siret'];
    $urssaf = $_POST['urssaf'];
    $maritalStatus = $_POST['maritalStatus'];
    $children = $_POST['children'];
    $workingHours = $_POST['workingHours'];
    $jobTitle = $_POST['jobTitle'];
    $courtier = isset($_POST['courtier']) ? 1 : 0;
    $agent = isset($_POST['agent']) ? 1 : 0;
    $associe = isset($_POST['associe']) ? 1 : 0;
    $reference = isset($_POST['reference']) ? 1 : 0;
    $department = $_POST['department'];
    $numberHours = $_POST['numberHours'];
    $jour = isset($_POST['jour']) ? 1 : 0;
    $soir = isset($_POST['soir']) ? 1 : 0;
    $les2 = isset($_POST['les2']) ? 1 : 0;
    $employeeType = $_POST['employeeType'];

    // Préparer la requête SQL
    $sql = "INSERT INTO employees22 (
        civility, last_name, first_name, usual_first_name, birth_date, sex, address, contact_info, city, country, phone, email, ssn, siret, urssaf, marital_status, children, working_hours, job_title, courtier, agent, associe, reference, department, number_hours, jour, soir, les2, employee_type
    ) VALUES (
        '$civility', '$lastName', '$firstName', '$usualFirstName', '$birthDate', '$sex', '$address', '$contactInfo', '$city', '$country', '$phone', '$email', '$ssn', '$siret', '$urssaf', '$maritalStatus', '$children', '$workingHours', '$jobTitle', '$courtier', '$agent', '$associe', '$reference', '$department', '$numberHours', '$jour', '$soir', '$les2', '$employeeType'
    )";

    // Exécuter la requête SQL
    if ($conn->query($sql) === TRUE) {
        echo "Enregistrement réussi";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Employé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .form-group {
            margin-bottom: 1rem;
            padding-right: 15px;
            padding-left: 15px;
            flex: 1;
        }
    </style>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #343a40;
            text-align: center;
        }

        h1 {
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-check-label {
            margin-right: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
        }

        .success-message {
            color: #28a745;
            font-size: 0.9rem;
        }

        .section-title {
            font-size: 1.25rem;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #007bff;
        }

        .divider {
            margin: 30px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .form-check-inline {
            display: inline-block;
            margin-right: 10px;
        }

        .form-check-inline input {
            margin-right: 5px;
        }
    </style>
</head>
<body style="background-color: rgb(0,0,64);">
    <div class="container">
        <h1 class="text-center">Fiche Employé</h1>
        <form id="employeeForm" method="post" action="">
            <!-- Civilité -->
            <div class="form-group">
                <label>Civilité</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civility" id="monsieur" value="Monsieur">
                    <label class="form-check-label" for="monsieur">Monsieur</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civility" id="madame" value="Madame">
                    <label class="form-check-label" for="madame">Madame</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civility" id="mlle" value="Mlle">
                    <label class="form-check-label" for="mlle">Mlle</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civility" id="autre" value="Autre">
                    <label class="form-check-label" for="autre">Autre</label>
                </div>
            </div>

            <!-- Nom de naissance -->
            <!-- Ligne 1 -->
            <div class="form-row">
                <!-- Nom de naissance -->
                <div class="form-group col-md-4">
                    <label for="lastName">Nom de naissance</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <!-- Prénom -->
                <div class="form-group col-md-4">
                    <label for="firstName">Prénom</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <!-- Prénom usuel -->
                <div class="form-group col-md-4">
                    <label for="usualFirstName">Prénom usuel</label>
                    <input type="text" class="form-control" id="usualFirstName" name="usualFirstName">
                </div>
            </div>

            <!-- Date de naissance -->
            <!-- Ligne 2 -->
            <div class="form-row">
                <!-- Date de naissance -->
                <div class="form-group col-md-4">
                    <label for="birthDate">Date de naissance</label>
                    <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                </div>
                <!-- Sexe -->
                <div class="form-group col-md-4">
                    <label>Sexe</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="homme" value="Homme" required>
                        <label class="form-check-label" for="homme">Homme</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="femme" value="Femme">
                        <label class="form-check-label" for="femme">Femme</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="autres" value="Autres">
                        <label class="form-check-label" for="autres">Autres</label>
                    </div>
                </div>
                <!-- Adresse -->
                <div class="form-group col-md-4">
                    <label for="address">Adresse</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
            </div>

            <!-- Coordonnées -->
            <!-- Ligne 3 -->
            <div class="form-row">
                <!-- Coordonnées -->
                <div class="form-group col-md-4">
                    <label for="contactInfo">Coordonnées</label>
                    <input type="text" class="form-control" id="contactInfo" name="contactInfo" required>
                </div>
                <!-- Ville -->
                <div class="form-group col-md-4">
                    <label for="city">Ville</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <!-- Pays -->
                <div class="form-group col-md-4">
                    <label for="country">Pays</label>
                    <input type="text" class="form-control" id="country" name="country" required>
                </div>
            </div>

            <!-- Téléphone -->
            <!-- Ligne 4 -->
            <div class="form-row">
                <!-- Téléphone -->
                <div class="form-group col-md-4">
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <!-- Email -->
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <!-- Sécurité sociale -->
                <div class="form-group col-md-4">
                    <label for="ssn"># sécurité sociale</label>
                    <input type="text" class="form-control" id="ssn" name="ssn" required>
                </div>
            </div>



            <div class="form-row">
                <!-- Siret -->
                <div class="form-group col-md-4">
                    <label for="siret">Siret #</label>
                    <input type="text" class="form-control" id="siret" name="siret">
                </div>
                <!-- Urssaf -->
                <div class="form-group col-md-4">
                    <label for="urssaf"># Urssaf</label>
                    <input type="text" class="form-control" id="urssaf" name="urssaf">
                </div>
                <!-- Situation conjugale -->
                <div class="form-group col-md-4">
                    <label for="maritalStatus">Situation conjugale</label>
                    <select class="form-control" id="maritalStatus" name="maritalStatus" required>
                        <option value="Célibataire">Célibataire</option>
                        <option value="Marié">Marié</option>
                        <option value="Conjoint de fait">Conjoint de fait</option>
                    </select>
                </div>
            </div>


            <div class="form-row">
                <!-- Nombre d’enfants -->
                <div class="form-group col-md-4">
                    <label for="children">Nombre d’enfants</label>
                    <input type="number" class="form-control" id="children" name="children">
                </div>
                <!-- Heures de travail -->
                <div class="form-group col-md-4">
                    <label for="workingHours">Heures de travail</label>
                    <input type="text" class="form-control" id="workingHours" name="workingHours" required>
                </div>
                <!-- Fonction/profession -->
                <div class="form-group col-md-4">
                    <label for="jobTitle">Fonction/profession</label>
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                </div>
            </div>

            <!-- Courtier/agent/associé/référence -->
            <div class="form-group">
                <label>Courtier/agent/associé/référence</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="courtier" name="courtier" value="Courtier">
                    <label class="form-check-label" for="courtier">Courtier</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="agent" name="agent" value="Agent">
                    <label class="form-check-label" for="agent">Agent</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="associe" name="associe" value="Associé">
                    <label class="form-check-label" for="associe">Associé</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="reference" name="reference" value="Référence">
                    <label class="form-check-label" for="reference">Référence</label>
                </div>
            </div>

            <!-- Département -->
            <div class="form-group">
                <label for="department">Département</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="vente">Vente</option>
                    <option value="administration">Administration</option>
                    <option value="marketing">Marketing</option>
                    <option value="communication">Communication</option>
                    <option value="comptabilite">Comptabilité</option>
                    <option value="it">IT</option>
                    <option value="backend">Backend</option>
                    <option value="frontend">Frontend</option>
                    <option value="experience_client">Expérience client</option>
                </select>
            </div>

            <!-- Nombre d’heures -->
            <div class="form-group">
                <label for="numberHours">Nombre d’heures</label>
                <select class="form-control" id="numberHours" name="numberHours" required>
                    <option value="20-25h">20h-25h</option>
                    <option value="30-45h">30-45h</option>
                    <option value="45h+">45h et +</option>
                </select>
            </div>

            <!-- Quart de travail -->
            <div class="form-group">
                <label>Quart de travail</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="jour" name="jour" value="Jour">
                    <label class="form-check-label" for="jour">Jour</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="soir" name="soir" value="Soir">
                    <label class="form-check-label" for="soir">Soir</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="les2" name="les2" value="Les deux">
                    <label class="form-check-label" for="les2">Les deux</label>
                </div>
            </div>

            <!-- Type d’employé -->
            <div class="form-group">
                <label for="employeeType">Type d’employé</label>
                <select class="form-control" id="employeeType" name="employeeType" required>
                    <option value="temps_plein">Temps plein</option>
                    <option value="temps_partiel">Temps partiel</option>
                    <option value="a_la_pige">À la pige</option>
                </select>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
