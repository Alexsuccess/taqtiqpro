<?php

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
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

// Étape 1: Informations Personnelles
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == 1) {
    // Récupération des données de l'étape 1
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Exemple d'enregistrement dans la base de données ou autre traitement
    // Exemple avec MySQLi
    $stmt = $conn->prepare("INSERT INTO informations_personnelles22 (nom, prenom) VALUES (?, ?)");
    $stmt->bind_param("ss", $nom, $prenom);

    // Exécution de la requête
    if ($stmt->execute()) {
        // Succès
        echo "Informations personnelles enregistrées avec succès.";
    } else {
        // Erreur
        echo "Erreur lors de l'enregistrement des informations personnelles: " . $stmt->error;
    }

    // Fermeture du statement
    $stmt->close();
}

// Étape 2: Type d'Immigration et Documents Personnels
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == 2) {
    // Récupération des données de l'étape 2
    $typeImmigration = $_POST['typeImmigration'];
    $documents = $_FILES['documents'];

    // Gérer le téléchargement de documents (exemples à adapter selon vos besoins)
    $uploadedFiles = uploadDocuments($documents);

    // Exemple d'enregistrement dans la base de données ou autre traitement
    // ...

}

// Étape 3: Parcours Académique, Parcours Professionnel, Compétences
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == 3) {
    // Récupération des données de l'étape 3
    if (isset($_POST['parcoursAcademique'])) {
        foreach ($_POST['parcoursAcademique'] as $pa) {
            $etablissement = $pa['etablissement'];
            $diplome = $pa['diplome'];
            $anneeObtention = $pa['anneeObtention'];
            // Insérer dans la base de données ou autre traitement
        }
    }

    if (isset($_POST['parcoursProfessionnel'])) {
        foreach ($_POST['parcoursProfessionnel'] as $pp) {
            $entreprise = $pp['entreprise'];
            $poste = $pp['poste'];
            $anneeExperience = $pp['anneeExperience'];
            // Insérer dans la base de données ou autre traitement
        }
    }

    if (isset($_POST['competences'])) {
        foreach ($_POST['competences'] as $competence) {
            $competenceName = $competence['competence'];
            $anneeExperienceCompetence = $competence['anneeExperienceCompetence'];
            $reference = $competence['reference'];
            // Insérer dans la base de données ou autre traitement
        }
    }

}

// Étape 4: Formulaire Spécifique
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == 4) {
    // Traitement spécifique à l'étape 4
}

// Fonction pour télécharger les documents
function uploadDocuments($documents) {
    // Exemple de gestion de téléchargement de fichiers
    $uploadedFiles = [];

    foreach ($documents['tmp_name'] as $key => $tmp_name) {
        $file_name = $documents['name'][$key];
        $file_size = $documents['size'][$key];
        $file_tmp = $documents['tmp_name'][$key];
        $file_type = $documents['type'][$key];

        $file_ext = strtolower(end(explode('.', $file_name)));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            echo "extension not allowed, please choose a JPEG or PNG file.";
            continue;
        }

        if ($file_size > 2097152) {
            echo 'File size must be less than 2 MB';
            continue;
        }

        if (move_uploaded_file($file_tmp, "uploads/" . $file_name)) {
            $uploadedFiles[] = "uploads/" . $file_name;
        } else {
            echo 'Upload error';
        }
    }

    return $uploadedFiles;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Immigration</title>
    <style type="text/css">
        .container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.form {
    display: block;
}

.fieldset {
    display: none;
    border: none;
}

.fieldset.active {
    display: block;
}

legend {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button.prevBtn {
    background-color: #f1f1f1;
    color: black;
    margin-right: 10px;
}

button[type="submit"] {
    background-color: #008CBA;
}

.addAcademicBtn,
.addProfessionalBtn,
.addSkillBtn {
    margin-top: 10px;
    background-color: #008CBA;
}

.addAcademicBtn:hover,
.addProfessionalBtn:hover,
.addSkillBtn:hover {
    background-color: #005580;
}

.step {
    display: none;
}

.step.active {
    display: block;
}

.error {
    color: red;
    margin-bottom: 10px;
}

#specificFormContainer {
    margin-bottom: 20px;
}

@media screen and (max-width: 600px) {
    .container {
        width: 90%;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="" id="registrationForm" class="form">
            <!-- Étape 1: Informations Personnelles -->
            <fieldset class="step">
                <legend>Étape 1: Informations Personnelles</legend>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
                <button class="nextBtn" type="button">Suivant</button>
            </fieldset>

            <!-- Étape 2: Type d'Immigration et Documents Personnels -->
            <fieldset class="step">
                <legend>Étape 2: Type d'Immigration et Documents Personnels</legend>
                <label for="typeImmigration">Type d'Immigration:</label>
                <select id="typeImmigration" name="typeImmigration" required>
                    <option value="">Sélectionnez...</option>
                    <option value="travailleur">Travailleur</option>
                    <option value="etude">Étude</option>
                    <option value="regroupement">Regroupement Familial</option>
                    <option value="tourisme">Tourisme</option>
                    <option value="affaire">Affaire</option>
                </select>
                <label for="documents">Documents Personnels:</label>
                <input type="file" id="documents" name="documents[]" multiple>
                <button class="prevBtn" type="button">Précédent</button>
                <button class="nextBtn" type="button">Suivant</button>
            </fieldset>

            <!-- Étape 3: Parcours Académique, Parcours Professionnel, Compétences -->
            <fieldset class="step">
                <legend>Étape 3: Parcours Académique, Parcours Professionnel, Compétences</legend>
                <div id="parcoursAcademiqueFields">
                    <label>Parcours Académique:</label>
                    <div class="academicFields">
                        <div>
                            <label for="etablissement">Établissement:</label>
                            <input type="text" id="etablissement" name="parcoursAcademique[0][etablissement]">
                        </div>
                        <div>
                            <label for="diplome">Diplôme Obtenu:</label>
                            <input type="text" id="diplome" name="parcoursAcademique[0][diplome]">
                        </div>
                        <div>
                            <label for="anneeObtention">Année d'obtention:</label>
                            <input type="text" id="anneeObtention" name="parcoursAcademique[0][anneeObtention]">
                        </div>
                    </div>
                    <button type="button" class="addAcademicBtn">Ajouter un parcours académique</button>
                </div>

                <div id="parcoursProfessionnelFields">
                    <label>Parcours Professionnel:</label>
                    <div class="professionalFields">
                        <div>
                            <label for="entreprise">Entreprise:</label>
                            <input type="text" id="entreprise" name="parcoursProfessionnel[0][entreprise]">
                        </div>
                        <div>
                            <label for="poste">Poste Occupé:</label>
                            <input type="text" id="poste" name="parcoursProfessionnel[0][poste]">
                        </div>
                        <div>
                            <label for="anneeExperience">Année:</label>
                            <input type="text" id="anneeExperience" name="parcoursProfessionnel[0][anneeExperience]">
                        </div>
                    </div>
                    <button type="button" class="addProfessionalBtn">Ajouter un parcours professionnel</button>
                </div>

                <div id="competencesFields">
                    <label>Compétences:</label>
                    <div class="skillsFields">
                        <div>
                            <label for="competence">Compétence:</label>
                            <input type="text" id="competence" name="competences[0][competence]">
                        </div>
                        <div>
                            <label for="anneeExperienceCompetence">Année d'expérience:</label>
                            <input type="text" id="anneeExperienceCompetence" name="competences[0][anneeExperienceCompetence]">
                        </div>
                        <div>
                            <label for="reference">Référence:</label>
                            <input type="text" id="reference" name="competences[0][reference]">
                        </div>
                    </div>
                    <button type="button" class="addSkillBtn">Ajouter une compétence</button>
                </div>

                <button class="prevBtn" type="button">Précédent</button>
                <button class="nextBtn" type="button">Suivant</button>
            </fieldset>

            <!-- Étape 4: Formulaire Spécifique -->
            <fieldset class="step">
                <legend>Étape 4: Formulaire Spécifique</legend>
                <div id="specificFormContainer"></div>
                <button class="prevBtn" type="button">Précédent</button>
                <button type="submit">Soumettre</button>
            </fieldset>
        </form>
    </div>

    <script >
        document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const steps = form.querySelectorAll('.step');
    let currentStep = 0;

    function showStep(index) {
        steps[currentStep].classList.remove('active');
        steps[index].classList.add('active');
        currentStep = index;
        updateButtonVisibility();
    }

    function updateButtonVisibility() {
        const prevBtn = form.querySelector('.prevBtn');
        const nextBtns = form.querySelectorAll('.nextBtn');
        const submitBtn = form.querySelector('button[type="submit"]');

        if (currentStep === 0) {
            prevBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'inline-block';
        }

        if (currentStep === steps.length - 1) {
            nextBtns.forEach(btn => btn.style.display = 'none');
            submitBtn.style.display = 'inline-block';
        } else {
            nextBtns.forEach(btn => btn.style.display = 'inline-block');
            submitBtn.style.display = 'none';
        }
    }

    form.addEventListener('click', function(event) {
        const target = event.target;

        if (target.classList.contains('nextBtn')) {
            if (currentStep < steps.length - 1) {
                // Validation de l'étape avant de passer à l'étape suivante
                if (validateStep(currentStep)) {
                    showStep(currentStep + 1);
                }
            }
        }

        if (target.classList.contains('prevBtn')) {
            if (currentStep > 0) {
                showStep(currentStep - 1);
            }
        }

        // Ajout d'un événement pour ajouter des champs dynamiquement
        if (target.classList.contains('addAcademicBtn')) {
            addAcademicField();
        }

        if (target.classList.contains('addProfessionalBtn')) {
            addProfessionalField();
        }

        if (target.classList.contains('addSkillBtn')) {
            addSkillField();
        }
    });

    function validateStep(step) {
        // Validation des champs pour chaque étape (à implémenter selon vos besoins)
        return true; // Retourne true si la validation réussit
    }

    function addAcademicField() {
        const academicFields = form.querySelector('.academicFields');
        const newField = `
            <div>
                <label for="etablissement">Établissement:</label>
                <input type="text" name="parcoursAcademique[${academicFields.children.length}][etablissement]">
            </div>
            <div>
                <label for="diplome">Diplôme Obtenu:</label>
                <input type="text" name="parcoursAcademique[${academicFields.children.length}][diplome]">
            </div>
            <div>
                <label for="anneeObtention">Année d'obtention:</label>
                <input type="text" name="parcoursAcademique[${academicFields.children.length}][anneeObtention]">
            </div>
        `;
        academicFields.insertAdjacentHTML('beforeend', newField);
    }

    function addProfessionalField() {
        const professionalFields = form.querySelector('.professionalFields');
        const newField = `
            <div>
                <label for="entreprise">Entreprise:</label>
                <input type="text" name="parcoursProfessionnel[${professionalFields.children.length}][entreprise]">
            </div>
            <div>
                <label for="poste">Poste Occupé:</label>
                <input type="text" name="parcoursProfessionnel[${professionalFields.children.length}][poste]">
            </div>
            <div>
                <label for="anneeExperience">Année:</label>
                <input type="text" name="parcoursProfessionnel[${professionalFields.children.length}][anneeExperience]">
            </div>
        `;
        professionalFields.insertAdjacentHTML('beforeend', newField);
    }

    function addSkillField() {
        const skillsFields = form.querySelector('.skillsFields');
        const newField = `
            <div>
                <label for="competence">Compétence:</label>
                <input type="text" name="competences[${skillsFields.children.length}][competence]">
            </div>
            <div>
                <label for="anneeExperienceCompetence">Année d'expérience:</label>
                <input type="text" name="competences[${skillsFields.children.length}][anneeExperienceCompetence]">
            </div>
            <div>
                <label for="reference">Référence:</label>
                <input type="text" name="competences[${skillsFields.children.length}][reference]">
            </div>
        `;
        skillsFields.insertAdjacentHTML('beforeend', newField);
    }

    // Initialisation de la première étape
    showStep(currentStep);
});

    </script>
</body>
</html>
