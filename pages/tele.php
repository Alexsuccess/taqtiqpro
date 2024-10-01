<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement des Fichiers d'Immigration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select, input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .file-list {
            margin-top: 30px;
        }
        .file-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Enregistrement des Fichiers d'Immigration</h1>
    <form id="immigrationForm">
        <div class="form-group">
            <label for="typeImmigration">Type d'immigration</label>
            <input type="text" id="typeImmigration" name="typeImmigration" required>
        </div>
        <div class="form-group">
            <label for="etape">N° de l'étape</label>
            <input type="number" id="etape" name="etape" required>
        </div>
        <div class="form-group">
            <label for="nomFichier">Nom du fichier</label>
            <input type="text" id="nomFichier" name="nomFichier" required>
        </div>
        <div class="form-group">
            <label for="fichier">Fichier</label>
            <input type="file" id="fichier" name="fichier" required>
        </div>
        <button type="button" onclick="enregistrerFichier()">Enregistrer</button>
    </form>

    <div class="file-list" id="fileList"></div>
</div>

<script>
    const fichiersImmigration = [];

    function enregistrerFichier() {
        const typeImmigration = document.getElementById('typeImmigration').value;
        const etape = document.getElementById('etape').value;
        const nomFichier = document.getElementById('nomFichier').value;
        const fichier = document.getElementById('fichier').files[0];

        if (typeImmigration && etape && nomFichier && fichier) {
            fichiersImmigration.push({
                typeImmigration,
                etape,
                nomFichier,
                fichier
            });

            afficherFichiers();
            document.getElementById('immigrationForm').reset();
        } else {
            alert('Veuillez remplir tous les champs.');
        }
    }

    function afficherFichiers() {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';

        const groupedFiles = fichiersImmigration.reduce((acc, file) => {
            if (!acc[file.typeImmigration]) {
                acc[file.typeImmigration] = {};
            }
            if (!acc[file.typeImmigration][file.etape]) {
                acc[file.typeImmigration][file.etape] = [];
            }
            acc[file.typeImmigration][file.etape].push(file);
            return acc;
        }, {});

        for (const type in groupedFiles) {
            const typeGroup = document.createElement('div');
            typeGroup.classList.add('file-group');
            const typeHeading = document.createElement('h2');
            typeHeading.textContent = `Type d'immigration: ${type}`;
            typeGroup.appendChild(typeHeading);

            for (const etape in groupedFiles[type]) {
                const etapeGroup = document.createElement('div');
                const etapeHeading = document.createElement('h3');
                etapeHeading.textContent = `N° de l'étape: ${etape}`;
                etapeGroup.appendChild(etapeHeading);

                const fileList = document.createElement('ul');
                groupedFiles[type][etape].forEach(file => {
                    const listItem = document.createElement('li');
                    listItem.textContent = file.nomFichier;
                    fileList.appendChild(listItem);
                });

                etapeGroup.appendChild(fileList);
                typeGroup.appendChild(etapeGroup);
            }

            fileList.appendChild(typeGroup);
        }
    }
</script>

</body>
</html>
