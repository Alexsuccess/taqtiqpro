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

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$files = [
    "diplome", "cv", "certificat_naissance", "certificat_scolarite", "passeport", 
    "attestation_etude", "plan_cadre", "attestation_enregistrement", "releve_note", 
    "experience_professionnelle", "permis_conduire", "mandat_representation", "acte_mariage"
];

$fileNames = [];
foreach ($files as $file) {
    if ($file == "releve_note" && isset($_FILES[$file])) {
        // Gestion de plusieurs fichiers pour "releve_note"
        $fileNames[$file] = [];
        foreach ($_FILES[$file]['name'] as $key => $name) {
            if ($_FILES[$file]['error'][$key] == 0) {
                $uniqueName = time() . '_' . uniqid() . '_' . basename($name);
                $targetFilePath = $targetDir . $uniqueName;
                move_uploaded_file($_FILES[$file]["tmp_name"][$key], $targetFilePath);
                $fileNames[$file][] = $uniqueName;
            }
        }
        // Convertir le tableau en chaîne de caractères séparée par des virgules
        $fileNames[$file] = implode(",", $fileNames[$file]);
    } else {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
            $uniqueName = time() . '_' . uniqid() . '_' . basename($_FILES[$file]["name"]);
            $targetFilePath = $targetDir . $uniqueName;
            move_uploaded_file($_FILES[$file]["tmp_name"], $targetFilePath);
            $fileNames[$file] = $uniqueName;
        } else {
            $fileNames[$file] = null;
        }
    }
}

// Préparer et lier
$stmt = $conn->prepare("INSERT INTO documentss (conseiller, nom, tel, courriel, diplome, cv, certificat_naissance, certificat_scolarite, passeport, attestation_etude, plan_cadre, attestation_enregistrement, releve_note, experience_professionnelle, permis_conduire, mandat_representation, acte_mariage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssssss",
    $_POST['conseiller'], $_POST['nom'], $_POST['tel'], $_POST['courriel'], 
    $fileNames['diplome'], $fileNames['cv'], $fileNames['certificat_naissance'], $fileNames['certificat_scolarite'],
    $fileNames['passeport'], $fileNames['attestation_etude'], $fileNames['plan_cadre'], $fileNames['attestation_enregistrement'],
    $fileNames['releve_note'], // Assurez-vous que c'est une chaîne de caractères ou NULL
    $fileNames['experience_professionnelle'], $fileNames['permis_conduire'], $fileNames['mandat_representation'],
    $fileNames['acte_mariage']
);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Nouvelle entrée créée avec succès";
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents au Dossier</title>
    <style type="text/css">
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1, h2 {
    text-align: center;
    color: #333;
}

.question {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"], input[type="email"], input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    background: #5cb85c;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

button:hover {
    background: #4cae4c;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Documents au Dossierddddddddddd</h1>
        <form id="documentsForm" action="" method="post" enctype="multipart/form-data">
            <div class="question">
                <label for="conseiller">Nom du conseiller:</label>
                <input type="text" id="conseiller" name="conseiller">
            </div>
            <div class="question">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="question">
                <label for="tel">No. Tél:</label>
                <input type="text" id="tel" name="tel">
            </div>
            <div class="question">
                <label for="courriel">Courriel:</label>
                <input type="email" id="courriel" name="courriel" required>
            </div>
            <h2>Étape 1</h2>
            <div class="question">
                <label for="diplome">Diplôme:</label>
                <input type="file" id="diplome" name="diplome">
            </div>
            <div class="question">
                <label for="cv">Curriculum vitae:</label>
                <input type="file" id="cv" name="cv">
            </div>
            <div class="question">
                <label for="certificat_naissance">Certificat de naissance:</label>
                <input type="file" id="certificat_naissance" name="certificat_naissance">
            </div>
            <div class="question">
                <label for="certificat_scolarite">Certificat de scolarité:</label>
                <input type="file" id="certificat_scolarite" name="certificat_scolarite">
            </div>
            <div class="question">
                <label for="passeport">Passeport valide avec photo:</label>
                <input type="file" id="passeport" name="passeport">
            </div>
            <div class="question">
                <label for="attestation_etude">Attestation d’étude:</label>
                <input type="file" id="attestation_etude" name="attestation_etude">
            </div>
            <div class="question">
                <label for="plan_cadre">Plan cadre de son école (infirmière/ médical):</label>
                <input type="file" id="plan_cadre" name="plan_cadre">
            </div>
            <div class="question">
                <label for="attestation_enregistrement">Attestation d’enregistrement du pays (professionnels):</label>
                <input type="file" id="attestation_enregistrement" name="attestation_enregistrement">
            </div>
            <div class="question">
                <label for="releve_note">Relevé de note:</label>
                <input type="file" id="releve_note" name="releve_note[]" multiple>
            </div>
            <div class="question">
                <label for="experience_professionnelle">Lettre ou relevé de ses services professionnelles récents:</label>
                <input type="file" id="experience_professionnelle" name="experience_professionnelle">
            </div>
            <div class="question">
                <label for="permis_conduire">Copie du permis de conduire:</label>
                <input type="file" id="permis_conduire" name="permis_conduire">
            </div>
            <div class="question">
                <label for="mandat_representation">Copie du mandat de représentation :</label>
                <input type="file" id="mandat_representation" name="mandat_representation">
            </div>
            <div class="question">
                <label for="acte_mariage">Extrait de l’acte de mariage (obligatoire si couple):</label>
                <input type="file" id="acte_mariage" name="acte_mariage">
            </div>
            <button type="submit">Soumettre</button>
        </form>
    </div>
</body>
</html>
