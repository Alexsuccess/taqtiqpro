<?php
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

$mandatoryFiles = ["diplome", "passeport", "certificat_naissance", "mandat_representation", "certificat_scolarite"];
$optionalFiles = ["cv", "attestation_etude", "plan_cadre", "attestation_enregistrement", "releve_note", "experience_professionnelle", "permis_conduire", "acte_mariage"];

$files = array_merge($mandatoryFiles, $optionalFiles);

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
    $fileNames['releve_note'], $fileNames['experience_professionnelle'], $fileNames['permis_conduire'], $fileNames['mandat_representation'],
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
    <style>
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
            background: #995c;
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
        .optional-docs-container {
            margin-top: 20px;
        }
    </style>
    <script>
        function addOptionalDocument() {
            const optionalDocsContainer = document.getElementById('optionalDocsContainer');
            const select = document.createElement('select');
            select.name = 'optional_docs[]';
            select.onchange = function() {
                if (this.value !== '') {
                    const inputFile = document.createElement('input');
                    inputFile.type = 'file';
                    inputFile.name = this.value;
                    const div = document.createElement('div');
                    div.classList.add('question');
                    div.appendChild(document.createTextNode(this.options[this.selectedIndex].text + ': '));
                    div.appendChild(inputFile);
                    optionalDocsContainer.appendChild(div);
                }
                this.remove();
            };

            const docs = {
                'cv': 'Curriculum vitae',
                'attestation_etude': 'Attestation d’étude',
                'plan_cadre': 'Plan cadre de son école',
                'attestation_enregistrement': 'Attestation d’enregistrement du pays (professionnels)',
                'releve_note': 'Relevé de note',
                'experience_professionnelle': 'Lettre ou relevé de ses services professionnelles récents',
                'permis_conduire': 'Copie du permis de conduire',
                'acte_mariage': 'Extrait de l’acte de mariage (obligatoire si couple)'
            };

            select.appendChild(new Option('Sélectionnez un document', ''));
            for (const [value, text] of Object.entries(docs)) {
                select.appendChild(new Option(text, value));
            }

            optionalDocsContainer.appendChild(select);
        }
    </script>
</head>
<body style="background-image: url(images/fontt.jpg);">
    <div class="container">
        <h1>Formulaire d'enregistrement des documents</h1>
        <form id="documentsForm" action="" method="post" enctype="multipart/form-data">
            <div class="question">
                <label for="conseiller">Votre Matricule:</label>
                <input type="text" id="conseiller" name="conseiller" required>
            </div>
            <div class="question">
                <label for="nom">Votre Nom:</label>
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
            <h2>Télécharger vos documents</h2>
            <div class="question">
                <label for="diplome">Diplôme:</label>
                <input type="file" id="diplome" name="diplome" required>
            </div>
            <div class="question">
                <label for="passeport">Passeport valide avec photo:</label>
                <input type="file" id="passeport" name="passeport" required>
            </div>
            <div class="question">
                <label for="certificat_naissance">Certificat de naissance:</label>
                <input type="file" id="certificat_naissance" name="certificat_naissance" required>
            </div>
            <div class="question">
                <label for="certificat_scolarite">Certificat de scolarité:</label>
                <input type="file" id="certificat_scolarite" name="certificat_scolarite" required>
            </div>
            <div class="question">
                <label for="mandat_representation">Copie du mandat de représentation:</label>
                <input type="file" id="mandat_representation" name="mandat_representation" required>
            </div>
            <div class="optional-docs-container" id="optionalDocsContainer"></div>
            <button type="button" onclick="addOptionalDocument()">Ajouter un document</button>
            <button type="submit">Soumettre</button>
        </form>
    </div>
</body>
</html>
