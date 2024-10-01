<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collecte d'Informations</title>
    <style>
        h1 {
            text-align: center;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
        }

        legend {
            padding: 0 10px;
            font-weight: bold;
        }

        label {
            display: inline-block;
            width: 120px;
            margin-right: 10px;
        }

        input[type="text"], input[type="email"] {
            width: calc(100% - 140px);
            padding: 5px;
            margin-bottom: 10px;
        }

        select {
            width: calc(100% - 140px);
            padding: 5px;
            margin-bottom: 10px;
        }

        button[type="button"] {
            display: inline-block;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        button {
            cursor: pointer;
        }

        .academic-entry, .professional-entry {
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"], .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 3px;
        }

        .button-group {
            text-align: center;
            margin-top: 20px;
        }

        .button-group button {
            padding: 10px 20px;
            margin: 0 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Collecte d'Informations sur le CandidatTTTTTTTTT</h1>
    <form id="infoForm">
        <fieldset>
            <legend>Informations Personnelles</legend>
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Prénom:</label>
            <input type="text" id="surname" name="surname" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="gender">Sexe:</label>
            <select id="gender" name="gender" required>
                <option value="male">Masculin</option>
                <option value="female">Féminin</option>
                <option value="other">Autre</option>
            </select><br>
            <label for="country">Pays:</label>
            <input type="text" id="country" name="country" required><br>
        </fieldset>
        <fieldset>
            <legend>Parcours Académique</legend>
            <div id="academicInfo">
                <div class="academic-entry">
                    <label for="degree">Diplôme:</label>
                    <input type="text" class="degree" name="degree[]" required>
                    <label for="institution">Institution:</label>
                    <input type="text" class="institution" name="institution[]" required>
                    <label for="graduationDate">Date d'obtention:</label>
                    <input type="text" class="graduationDate" name="graduationDate[]" required>
                    <button type="button" onclick="removeAcademicEntry(this)">Supprimer</button>
                </div>
            </div>
            <button type="button" id="addAcademic">Ajouter un diplôme</button>
        </fieldset>
        <fieldset>
            <legend>Parcours Professionnel</legend>
            <div id="professionalInfo">
                <div class="professional-entry">
                    <label for="position">Poste:</label>
                    <input type="text" class="position" name="position[]" required>
                    <label for="company">Entreprise:</label>
                    <input type="text" class="company" name="company[]" required>
                    <label for="period">Période:</label>
                    <input type="text" class="period" name="period[]" required>
                    <label for="country">Pays:</label>
                    <input type="text" class="jobCountry" name="jobCountry[]" required>
                    <button type="button" onclick="removeProfessionalEntry(this)">Supprimer</button>
                </div>
            </div>
            <button type="button" id="addProfessional">Ajouter un poste</button>
        </fieldset>
        <fieldset>
            <legend>Documents à Télécharger</legend>
            <div class="form-group">
                <label for="documents">Télécharger les documents nécessaires (CV, lettre de motivation, diplômes, etc.)</label>
                <input type="file" id="documents" name="documents[]" multiple>
            </div>
            <div class="form-group">
                <label>Documents sélectionnés :</label>
                <table id="documentsTable">
                    <thead>
                        <tr>
                            <th>Nom du fichier</th>
                            <th>Date de dernière modification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les documents sélectionnés seront affichés ici -->
                    </tbody>
                </table>
            </div>
        </fieldset>
        <button type="submit">Soumettre</button>
    </form>
    <script>
        document.getElementById('addAcademic').addEventListener('click', function() {
            const academicInfo = document.getElementById('academicInfo');
            const newEntry = document.createElement('div');
            newEntry.classList.add('academic-entry');
            newEntry.innerHTML = `
                <label for="degree">Diplôme:</label>
                <input type="text" class="degree" name="degree[]" required>
                <label for="institution">Institution:</label>
                <input type="text" class="institution" name="institution[]" required>
                <label for="graduationDate">Date d'obtention:</label>
                <input type="text" class="graduationDate" name="graduationDate[]" required>
                <button type="button" onclick="removeAcademicEntry(this)">Supprimer</button>
            `;
            academicInfo.appendChild(newEntry);
        });

        document.getElementById('addProfessional').addEventListener('click', function() {
            const professionalInfo = document.getElementById('professionalInfo');
            const newEntry = document.createElement('div');
            newEntry.classList.add('professional-entry');
            newEntry.innerHTML = `
                <label for="position">Poste:</label>
                <input type="text" class="position" name="position[]" required>
                <label for="company">Entreprise:</label>
                <input type="text" class="company" name="company[]" required>
                <label for="period">Période:</label>
                <input type="text" class="period" name="period[]" required>
                <label for="jobCountry">Pays:</label>
                <input type="text" class="jobCountry" name="jobCountry[]" required>
                <button type="button" onclick="removeProfessionalEntry(this)">Supprimer</button>
            `;
            professionalInfo.appendChild(newEntry);
        });

        function removeAcademicEntry(button) {
            const entry = button.parentElement;
            entry.parentElement.removeChild(entry);
        }

        function removeProfessionalEntry(button) {
            const entry = button.parentElement;
            entry.parentElement.removeChild(entry);
        }

        document.getElementById('documents').addEventListener('change', function(event) {
            const tableBody = document.getElementById('documentsTable').querySelector('tbody');
            tableBody.innerHTML = ''; // Clear the table

            Array.from(event.target.files).forEach(file => {
                const row = document.createElement('tr');
                const fileNameCell = document.createElement('td');
                const fileDateCell = document.createElement('td');
                const fileDateInput = document.createElement('input');

                fileNameCell.textContent = file.name;
                fileDateInput.type = 'date';
                fileDateInput.name = 'fileDates[]';
                fileDateInput.required = true;

                fileDateCell.appendChild(fileDateInput);
                row.appendChild(fileNameCell);
                row.appendChild(fileDateCell);
                tableBody.appendChild(row);
            });
        });

        document.getElementById('infoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                if (!data[key]) {
                    data[key] = [];
                }
                data[key].push(value);
            });
            console.log('Form Data:', data);
            alert('Informations soumises avec succès!');
            // Ajouter ici le code pour envoyer les données au serveur si nécessaire
        });
    </script>
</body>
</html>
