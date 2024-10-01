<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barre de Progression</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .step-container {
            display: flex;
            justify-content: space-between;
            margin: 20px auto;
            max-width: 800px;
            padding: 0;
            list-style-type: none;
        }
        .step {
            text-align: center;
            flex: 1;
            position: relative;
        }
        .step:before {
            content: "";
            position: absolute;
            top: 50%;
            left: -50%;
            width: 100%;
            height: 4px;
            background-color: #d3d3d3;
            z-index: -1;
        }
        .step:first-child:before {
            content: none;
        }
        .step .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background-color: #d3d3d3;
            color: white;
            margin-bottom: 5px;
        }
        .step.completed .step-number,
        .step.completed span {
            background-color: green;
            color: white;
        }
        .step.completed .step-title {
            color: green;
        }
        .step .step-title {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>
<body>

<ul class="step-container">
    <li class="step completed">
        <div class="step-number">✔</div>
        <div class="step-title">Dépot de dossier</div>
    </li>
    <li class="step completed">
        <div class="step-number">✔</div>
        <div class="step-title">Applications</div>
    </li>
    <li class="step current">
        <div class="step-number">3</div>
        <div class="step-title">Grande catégorie professionnelle</div>
    </li>
    <li class="step">
        <div class="step-number">4</div>
        <div class="step-title">Catégorie FÉER</div>
    </li>
    <li class="step">
        <div class="step-number">5</div>
        <div class="step-title">Jeu questionnaire I</div>
    </li>
    <li class="step">
        <div class="step-number">6</div>
        <div class="step-title">Première étape - Terminée</div>
    </li>
</ul>

<script>
    // Exemple pour marquer une étape comme complétée
    function completeStep(stepNumber) {
        const steps = document.querySelectorAll('.step');
        steps[stepNumber - 1].classList.add('completed');
    }

    // Appel de la fonction pour marquer les étapes comme complétées
    completeStep(1);
    completeStep(2);
</script>

</body>
</html>
