<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $immigration_type = $_POST['immigration_type'];

    // En fonction du type d'immigration, insérer les données dans la table appropriée
    switch ($immigration_type) {
        case "permanent_residence":
            // Récupérer les données spécifiques à Résidence permanente
            $permanent_residence_field1 = $_POST['permanent_residence_field1'];
            $permanent_residence_field2 = $_POST['permanent_residence_field2'];
            $permanent_residence_field3 = $_POST['permanent_residence_field3'];
            $permanent_residence_field4 = $_POST['permanent_residence_field4'];
            $permanent_residence_field5 = $_POST['permanent_residence_field5'];

            // Préparer la requête avec des paramètres de requête préparée
            $sql = "INSERT INTO residence_permanente (champ1, champ2, champ3, champ4, champ5, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("ssssss", $permanent_residence_field1, $permanent_residence_field2, $permanent_residence_field3, $permanent_residence_field4, $permanent_residence_field5, $userId);
            break;

        case "family_reunification":
            // Récupérer les données spécifiques à Regroupement familial
            $family_member = $_POST['family_member'];
            $city = $_POST['city'];
            $relationship = $_POST['relationship'];
            $age = $_POST['age'];
            $occupation = $_POST['occupation'];
            // Ajoutez les autres champs si nécessaire

            // Requête SQL pour insérer les données dans la table appropriée
            $sql = "INSERT INTO regroupement_familial (personne_famille, ville, relation, age, occupation, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("sssiss", $family_member, $city, $relationship, $age, $occupation, $userId);
            break;

        case "study_permit":
            // Récupérer les données spécifiques à Permis d'études
            $institution = $_POST['institution'];
            $autonomy = $_POST['autonomy'];
            $program = $_POST['program'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            // Ajoutez les autres champs si nécessaire

            // Requête SQL pour insérer les données dans la table appropriée
            $sql = "INSERT INTO permis_etudes (etablissement, autonomie_bancaire, programme_etudes, date_debut, date_fin, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("ssssss", $institution, $autonomy, $program, $start_date, $end_date, $userId);
            break;

        case "work_permit":
            // Récupérer les données spécifiques à Permis de travail
            $employer = $_POST['employer'];
            $job_title = $_POST['job_title'];
            $salary = $_POST['salary'];
            $contract_type = $_POST['contract_type'];
            $start_date = $_POST['start_date'];
            // Ajoutez les autres champs si nécessaire

            // Requête SQL pour insérer les données dans la table appropriée
            $sql = "INSERT INTO permis_travail (employeur, titre_poste, salaire, type_contrat, date_debut, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("ssdsss", $employer, $job_title, $salary, $contract_type, $start_date, $userId);
            break;

        // Ajoutez d'autres cas pour les
        case "online_application":
            // Récupérer les données spécifiques au Dépôt de demande de résidence permanente en ligne
            $application_type = $_POST['application_type'];
            // Ajoutez les autres champs si nécessaire

            // Requête SQL pour insérer les données dans la table appropriée
            $sql = "INSERT INTO depot_demande_residence (type_demande) VALUES (?)";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("s", $application_type);
            break;

        case "provincial_nominee_programs":
            // Récupérer les données spécifiques aux Programmes de nomination provinciale
            $province = $_POST['province'];
            // Ajoutez les autres champs si nécessaire

            // Requête SQL pour insérer les données dans la table appropriée
            $sql = "INSERT INTO programmes_nomination_provinciale (province) VALUES (?)";
            $stmt = $conn->prepare($sql);
            // Lier les paramètres
            $stmt->bind_param("s", $province);
            break;

case "express_entry":
    // Récupérer les données spécifiques à Entrée express au Canada
    $experience_points = $_POST['experience_points'];
    $education_level = $_POST['education_level'];
    $language_skills = $_POST['language_skills'];
    $work_experience_canada = $_POST['work_experience_canada'];
    $job_offer = $_POST['job_offer'];

    // Requête SQL pour insérer les données dans la table appropriée
    $sql = "INSERT INTO entree_express (points_experience, niveau_education, competences_linguistiques, experience_travail_canada, offre_emploi_valide, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
    $stmt = $conn->prepare($sql);
    // Lier les paramètres
    $stmt->bind_param("isssss", $experience_points, $education_level, $language_skills, $work_experience_canada, $job_offer, $userId);
    break;

case "more_options":
    // Récupérer les données spécifiques pour "Autres"
    $other_field1 = $_POST['other_field1'];
    $other_field2 = $_POST['other_field2'];
    $other_field3 = $_POST['other_field3'];
    $other_field4 = $_POST['other_field4'];
    $other_field5 = $_POST['other_field5'];
    // Ajoutez d'autres champs si nécessaire

    // Requête SQL pour insérer les données dans la table appropriée
    $sql = "INSERT INTO autres_options (champ1, champ2, champ3, champ4, champ5, user_id, datee) VALUES (?, ?, ?, ?, ?, ?, now())";
    $stmt = $conn->prepare($sql);
    // Lier les paramètres
    $stmt->bind_param("ssssss", $other_field1, $other_field2, $other_field3, $other_field4, $other_field5, $userId);
    break;

        // Ajoutez d'autres cas pour les autres options si nécessaire

        default:
            // Ne rien faire si aucune option valide n'est sélectionnée
            break;
    }

    // Exécuter la requête préparée
    if ($stmt->execute()) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur lors de l'enregistrement: " . $conn->error;
    }

    // Fermer la requête et la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motifs de travail</title>
    <style type="text/css">
        /* styles.css */

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

input[type="date"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    /* Autres styles personnalisés */
}

input[type="email"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    /* Autres styles personnalisés */
}


label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    cursor: pointer;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Motifs du voyage</h1>
        <form id="motifsForm" method="post" action="">
            <div class="form-group">
                <label for="immigration_type">Type d'immigration :</label>
                <select id="immigration_type" name="immigration_type" onchange="showFields()">
                    <option></option>
                    <option value="permanent_residence">Résidence permanente</option>
                    <option value="family_reunification">Regroupement familial</option>
                    <option value="study_permit">Permis d'études</option>
                    <option value="work_permit">Permis de travail</option>
                    <option value="express_entry">Entrée express au Canada</option>
                    <option value="more_options">Autres</option>
                </select>
            </div>
            <!-- Champs dynamiques ici -->
            <div id="dynamicFields"></div>
            <button type="submit">Enregistrer</button>
        </form>
    </div>

    <script>
        function showFields() {
            var select = document.getElementById("immigration_type");
            var selectedOption = select.options[select.selectedIndex].value;
            var dynamicFields = document.getElementById("dynamicFields");
            dynamicFields.innerHTML = ""; // Efface les champs précédents

            // Affiche les champs appropriés en fonction du type sélectionné
            switch (selectedOption) {
                case "permanent_residence":
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="permanent_residence_field1">Profession :</label>
                            <input type="text" id="permanent_residence_field1" name="permanent_residence_field1" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_residence_field2">Statut matrimonial :</label>
                            <input type="text" id="permanent_residence_field2" name="permanent_residence_field2" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_residence_field3">Nombre d'enfants :</label>
                            <input type="text" id="permanent_residence_field3" name="permanent_residence_field3" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_residence_field4">Nationalité :</label>
                            <input type="text" id="permanent_residence_field4" name="permanent_residence_field4" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_residence_field5">Langues parlées :</label>
                            <input type="text" id="permanent_residence_field5" name="permanent_residence_field5" required>
                        </div>
                        <!-- Ajoutez d'autres champs pour Résidence permanente ici -->
                    `;
                    break;
                case "family_reunification":
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="family_member">Personne de famille :</label>
                            <input type="text" id="family_member" name="family_member" required>
                        </div>
                        <div class="form-group">
                            <label for="city">Ville :</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="relationship">Relation :</label>
                            <input type="text" id="relationship" name="relationship" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Âge :</label>
                            <input type="number" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="occupation">Email de la personne à contacter :</label>
                            <input type="email" id="occupation" name="occupation" required>
                        </div>
                        <!-- Ajoutez d'autres champs pour Regroupement familial ici -->
                    `;
                    break;
                case "study_permit":
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="institution">Établissement :</label>
                            <input type="text" id="institution" name="institution" required>
                        </div>
                        <div class="form-group">
                            <label for="autonomy">Autonomie bancaire :</label>
                            <input type="text" id="autonomy" name="autonomy" required>
                        </div>
                        <div class="form-group">
                            <label for="program">Programme d'études :</label>
                            <input type="text" id="program" name="program" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Date de début (année/mois) :</label>
                            <input type="date" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Date de fin (année/mois) :</label>
                            <input type="date" id="end_date" name="end_date" required>
                        </div>
                        <!-- Ajoutez d'autres champs pour Permis d'études ici -->
                    `;
                    break;

                    case "express_entry":
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="experience_points">Points d'expérience :</label>
                            <input type="number" id="experience_points" name="experience_points" required>
                        </div>
                        <div class="form-group">
                            <label for="education_level">Niveau d'éducation :</label>
                            <input type="text" id="education_level" name="education_level" required>
                        </div>
                        <div class="form-group">
                            <label for="language_skills">Compétences linguistiques :</label>
                            <input type="text" id="language_skills" name="language_skills" required>
                        </div>
                        <div class="form-group">
                            <label for="work_experience_canada">Expérience de travail au Canada (Oui/Non) :</label>
                            <input type="text" id="work_experience_canada" name="work_experience_canada" required>
                        </div>
                        <div class="form-group">
                            <label for="job_offer">Offre d'emploi valide (Oui/Non) :</label>
                            <input type="text" id="job_offer" name="job_offer" required>
                        </div>
                        <!-- Ajoutez d'autres champs pour Permis d'études ici -->
                    `;
                    break;

                    case "more_options":
                    dynamicFields.innerHTML = `
<div class="form-group">
    <label for="other_field1">Motif / Objet :</label>
    <input type="text" id="other_field1" name="other_field1" required>
</div>
<div class="form-group">
    <label for="other_field2">Description :</label>
    <input type="text" id="other_field2" name="other_field2" required>
</div>
<div class="form-group">
    <label for="other_field3">Lieu :</label>
    <input type="text" id="other_field3" name="other_field3" required>
</div>
<div class="form-group">
    <label for="other_field4">Email :</label>
    <input type="email" id="other_field4" name="other_field4" required>
</div>
<div class="form-group">
    <label for="other_field5">Contact :</label>
    <input type="text" id="other_field5" name="other_field5" required>
</div>

                    `;
                    break;

                case "work_permit":
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="employer">Employeur :</label>
                    <select id="employer" name="employer" >
                        <option value="eimt_international_recruitment">EIMT (si recrutement à l’international)</option>
                        <option value="mifi_procedures">Démarches avec le MIFI</option>
                        <option value="caq_procedures">Démarches CAQ</option>
                        <option value="work_permit_application">Demande de permis de travail</option>
                        <option value="concierge_service_employee_welcome">Service de conciergerie pour l’accueil de l’employé</option>
                        <option value="accompaniment_2_days">Possibilité de 2 jours d’accompagnements</option>
                        <option value="concierge_service_housing_search">Service de conciergerie pour la recherche de logement</option>
                        <option value="foreign_employees">Employés étrangers</option>
                        <option value="pvt_permit_procedures">Démarches pour le permis PVT</option>
                        <option value="caq_procedures">Démarches pour le CAQ</option>
                        <option value="work_permit_request">Demande pour le permis de travail</option>
                        <option value="permanent_residence_request">Demande pour la résidence permanente</option>
                        <option value="study_permit_procedures">Démarches pour le permis d'études</option>
                        <option value="insurance">Assurance</option>
                        <option value="no_employer">Aucun</option>
                    </select>
                        </div>
                        <div class="form-group">
                            <label for="job_title">Titre du poste :</label>
                            <input type="text" id="job_title" name="job_title" required>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salaire :</label>
                            <input type="number" id="salary" name="salary" required>
                        </div>
<select id="contract_type" name="contract_type" required>
    <option value="CDI">CDI (Contrat à Durée Indéterminée)</option>
    <option value="CDD">CDD (Contrat à Durée Déterminée)</option>
    <option value="Stage">Stage</option>
    <option value="Alternance">Alternance</option>
    <option value="Freelance">Freelance</option>
    <option value="Intérim">Intérim</option>
    <option value="Apprentissage">Apprentissage</option>
    <option value="Contrat de chantier">Contrat de chantier</option>
    <option value="Contrat saisonnier">Contrat saisonnier</option>
    <option value="Contrat de professionnalisation">Contrat de professionnalisation</option>
    <option value="Contrat d'extra">Contrat d'extra</option>
</select>

                        <div class="form-group">
                            <label for="start_date">Date de début :</label>
                            <input type="date" id="start_date" name="start_date" required>
                        </div>
                        <!-- Ajoutez d'autres champs pour Permis de travail ici -->
                    `;
                    break;
                // Ajoutez d'autres cas pour les autres options si nécessaire
                default:
                    // Si l'option sélectionnée ne nécessite pas de champs spécifiques, ne rien afficher
                    dynamicFields.innerHTML = "";
                    break;
            }
        }
    </script>
</body>
</html>
