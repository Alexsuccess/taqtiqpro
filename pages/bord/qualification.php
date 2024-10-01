<?php
// Activation des erreurs PHP pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Paramètres de connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérification si les données POST sont reçues du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prospectName']) && isset($_POST['yourName']) && isset($_POST['offer1']) && isset($_POST['signatureData'])) {
    // Récupération des données depuis le formulaire
    $prospectName = $_POST['prospectName'];
    $yourName = $_POST['yourName'];
    $offer1 = $_POST['offer1'];
    $offer2 = isset($_POST['offer2']) ? $_POST['offer2'] : '';
    $offer3 = isset($_POST['offer3']) ? $_POST['offer3'] : '';
    $signatureData = $_POST['signatureData'];

    // Préparation de la requête SQL pour l'insertion
    $sql = "INSERT INTO qualification_calls (prospect_name, your_name, offer1, offer2, offer3, signature_data) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparation de l'instruction SQL
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Liaison des paramètres et types pour l'instruction préparée
    $stmt->bind_param("ssssss", $prospectName, $yourName, $offer1, $offer2, $offer3, $signatureData);

    // Exécution de l'instruction préparée
    if ($stmt->execute()) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

    // Fermeture de l'instruction préparée
    $stmt->close();
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immonivo Qualification Call</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .script {
            background: #e9f6ff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
        }

        .signature-pad {
            text-align: center;
            margin-top: 20px;
        }

        #signatureCanvas {
            border: 1px solid #ccc;
            width: 100%;
            height: 200px;
            cursor: crosshair;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Script d'Appel de Qualification CRM</h1>
        <div class="script">
            <p>Bonjour <span id="prospectName"></span>, c’est <span id="yourName">le service cleint</span> de Uri Canada. Est-ce que je tombe dans un bon moment? Auriez-vous 2 minutes à me consacrer?</p>
            <p>J’espère que vous passez une bonne journée.</p>
            <p>Nous développons notre plateforme d'immigration en intégrant les entreprises et professionnels dans notre annuaire de références immigration afin d’aider nos Candidats lors des transactions d'immigrations. Nous leur offrons des solutions les plus optimales lors du processus d'immigration. De ce fait, nous aidons également les entreprises comme la vôtre à être plus visibles, à utiliser les plateformes et ressources multicanaux adaptées à l’optimisation vos processus.</p>
            <p>Si oui :</p>
            <p>Ok, super. Quel serait l’aspect ou plusieurs aspects à optimiser dans votre activité? :</p>
            <ul>
                <li>Offre 1: <span id="offer1"></span></li>
                <li>Offre 2: <span id="offer2"></span></li>
                <li>Offre 3: <span id="offer3"></span></li>
            </ul>
            <p>Souhaitez-vous vous renforcer sur un de ces aspects ? Quel domaine souhaitez-vous qu’on vous aide à développer?</p>
            <div id="selectedAspect"></div>
            <p>Super. Puis-je commencer par vous poser quelques questions ?</p>
            <p>[Posez des questions clés de qualification sur leurs problèmes spécifiques afin de pouvoir donner des réponses et des exemples plus pertinents et ciblés].</p>
            <p>Ce sont effectivement des problématiques sur lesquelles nous accompagnons nos clients [Citer les clients et donner des exemples de projets]</p>
            <p>Seriez-vous disponible en début de semaine prochaine pour faire le point ensemble sur votre situation et identifier les aspects sur lesquels notre accompagnement pourrait avoir du sens ? Merci.</p>
        </div>
        <form method="post" action="" onsubmit="updateScript()">
            <div class="form">
                <label for="prospectNameInput">Nom du prospect:</label>
                <input type="text" id="prospectNameInput" name="prospectName" placeholder="Entrez le nom du prospect" required>
                <label for="yourNameInput">Votre nom:</label>
                <input type="text" id="yourNameInput" name="yourName" placeholder="Entrez votre nom" required>
                <label for="offer1Input">Offre 1:</label>
                <input type="text" id="offer1Input" name="offer1" placeholder="Entrez l'offre 1" required>
                <label for="offer2Input">Offre 2:</label>
                <input type="text" id="offer2Input" name="offer2" placeholder="Entrez l'offre 2">
                <label for="offer3Input">Offre 3:</label>
                <input type="text" id="offer3Input" name="offer3" placeholder="Entrez l'offre 3">
            </div>
            <div class="signature-pad">
                <h2>Signature Électronique</h2>
                <canvas id="signatureCanvas" name="signatureData"></canvas>
                <button style="background-color: red;" type="button" onclick="clearSignature()">Effacer</button><br>
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </div>
    <script>
        function updateScript() {
            const prospectName = document.getElementById('prospectNameInput').value;
            const yourName = document.getElementById('yourNameInput').value;
            const offer1 = document.getElementById('offer1Input').value;
            const offer2 = document.getElementById('offer2Input').value;
            const offer3 = document.getElementById('offer3Input').value;

            document.getElementById('prospectName').innerText = prospectName;
            document.getElementById('yourName').innerText = yourName;
            document.getElementById('offer1').innerText = offer1;
            document.getElementById('offer2').innerText = offer2;
            document.getElementById('offer3').innerText = offer3;

            document.getElementById('selectedAspect').innerText = `Aspect choisi: ${prospectName}`;

            // Récupération des données de signature
            const canvas = document.getElementById('signatureCanvas');
            const signatureData = canvas.toDataURL(); // Conversion en format base64

            // Assignation à un champ caché pour soumission
            const signatureField = document.createElement('input');
            signatureField.type = 'hidden';
            signatureField.name = 'signatureData';
            signatureField.value = signatureData;
            document.querySelector('form').appendChild(signatureField);
        }

        // Fonctionnalité de la signature
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;

        // Correction des coordonnées
        function getMousePos(canvas, evt) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: (evt.clientX - rect.left) * (canvas.width / rect.width),
                y: (evt.clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(evt) {
            isDrawing = true;
            const pos = getMousePos(canvas, evt);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }

        function draw(evt) {
            if (!isDrawing) return;
            const pos = getMousePos(canvas, evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }

        function stopDrawing() {
            isDrawing = false;
            ctx.closePath();
        }

        function clearSignature() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
    </script>
</body>
</html>
