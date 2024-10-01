<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer des emails</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            border: 1px solid #ccc;
            padding: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Envoyer des emails</h1>
        <form id="emailForm">
            <div class="form-group">
                <label for="recipients">Destinataires (séparez les emails par une virgule):</label>
                <input type="text" id="recipients" name="recipients" placeholder="exemple1@mail.com, exemple2@mail.com" required>
            </div>
            <div class="form-group">
                <label for="subject">Sujet:</label>
                <input type="text" id="subject" name="subject" placeholder="Sujet de l'email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Message de l'email" required></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">Joindre un fichier PDF:</label>
                <input type="file" id="attachment" name="attachment" accept="application/pdf">
            </div>
            <div class="form-group">
                <button type="button" onclick="sendEmail()">Envoyer</button>
            </div>
        </form>
    </div>
    <script>
        function sendEmail() {
            const recipients = document.getElementById('recipients').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const attachment = document.getElementById('attachment').files[0];

            if (attachment) {
                alert('Les pièces jointes ne peuvent pas être automatiquement ajoutées via mailto. Veuillez les ajouter manuellement dans votre client de messagerie.');
            }

            const mailtoLink = `mailto:${recipients}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`;
            window.location.href = mailtoLink;
        }
    </script>
</body>
</html>
