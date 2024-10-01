<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de Bienvenue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container p {
            font-size: 16px;
            margin-bottom: 20px;
            text-align: left;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .buttons button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body style="background-image: url(images/fondd.jpg);">

<div class="container">
    <h1>Bonjour,</h1>
    <p>
        En référence à votre besoin de mains-d’œuvre, vous trouverez ci-joint l'offre de service que nous proposons.<br><br>
        Nous recrutons selon vos besoins, qu'ils s'avèrent générales, techniques ou plus spécifiques. <br><br>
        Nous accompagnons les entreprises, services RH et agences dans le processus complet du recrutement local et international.<br><br>
        Si toutefois votre souhait serait d'occuper rapidement des postes plus techniques ou spécifiques, svp soumettez vos besoins dans l'immédiat afin de mieux combler vos postes vacants.<br><br>
        Je vous invite à en prendre connaissance et nous ferons un suivi avec vous sous peu.<br><br>
        D'ici là, si vous avez des questions ou des interrogations, n'hésitez surtout pas à nous en faire part en communiquant avec nous.<br><br>
        Cordialement,<br><br>
        ÜRI Canada Inc<br>
        Bur : 514-584-0440 x 104<br><br>
        Permis: AP:2403926<br>
        Permis: AR2403828<br>
    </p>
    <div class="buttons">
        <button style="background-color: red;" onclick="window.location.href='../../login.php'">Retour</button>
        <button onclick="window.location.href='question2.php'">Continuerrr</button>
        
    </div>
</div>

</body>
</html>
