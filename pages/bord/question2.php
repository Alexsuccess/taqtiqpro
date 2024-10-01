<?php

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
// Préparer et lier
$stmt = $conn->prepare("INSERT INTO responses (q0, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q11_justification, q12, q13, q14, q14_details, q15_min, q15_max, q16, q17, q18, q19, q20, q21, q22, q22_details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssssssssssssssss",
    $_POST['q0'], $_POST['q1'], $_POST['q2'], $_POST['q3'], $_POST['q4'], $_POST['q5'], $_POST['q6'], $_POST['q7'], $_POST['q8'],
    $_POST['q9'], $_POST['q10'], $_POST['q11'], $_POST['q11_justification'], $_POST['q12'], $_POST['q13'],
    $_POST['q14'], $_POST['q14_details'], $_POST['q15_min'], $_POST['q15_max'], $_POST['q16'], $_POST['q17'],
    $_POST['q18'], $_POST['q19'], $_POST['q20'], $_POST['q21'], $_POST['q22'], $_POST['q22_details']
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
    <title>Questionnaire d'Embauche</title>
      <style type="text/css">
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 60%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1 {
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

textarea, input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

textarea {
    resize: vertical;
    min-height: 50px;
}

button {
    background: #5cb85c;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background: #4cae4c;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Questionnaire d'Embauche</h1>
        <p>Ce questionnaire doit être dûment remplit par l’employeur. Si le télévendeur pose les questions, celui-ci se doit d’envoyer les réponses afin de valider et de lui faire parvenir le contrat et la procuration pour signature.</p>
        <form id="questionnaireForm" action="" method="post">
          <div class="question">
                <label for="q0">Entrez votre Matricule</label>
                <textarea id="q0" name="q0" required></textarea>
            </div>
            <div class="question">
                <label for="q1">1) Est-ce qu’embaucher un travailleur étranger comblera-t-il une pénurie de main-d’œuvre ?</label>
                <textarea id="q1" name="q1" required></textarea>
            </div>
            <div class="question">
                <label for="q2">2) Décrivez les avantages qui découleront de l’embauche d’un travailleur étranger :</label>
                <textarea id="q2" name="q2" required></textarea>
            </div>
            <div class="question">
                <label for="q3">3) Décrivez en détails la principale activité du poste.</label>
                <textarea id="q3" name="q3" required></textarea>
            </div>
            <div class="question">
                <label for="q4">4) Décrivez en détails les tâches principales du poste offert.</label>
                <textarea id="q4" name="q4" required></textarea>
            </div>
            <div class="question">
                <label for="q5">5) En quoi le besoin de faire appel au travailleur étranger est nécessaire à votre entreprise ?</label>
                <textarea id="q5" name="q5" required></textarea>
            </div>
            <div class="question">
                <label for="q6">6) Quelles sont les conséquences sur vos activités si le poste reste vacant ?</label>
                <textarea id="q6" name="q6" required></textarea>
            </div>
            <div class="question">
                <label for="q7">7) Date prévue du début de l’emploi et la durée (en mois)</label>
                <input type="text" id="q7" name="q7" required>
            </div>
            <div class="question">
                <label for="q8">8) Justifiez la durée d’emploi demandée en fonction des activités au sein de l’entreprise.</label>
                <textarea id="q8" name="q8" required></textarea>
            </div>
            <div class="question">
                <label for="q9">9) Combien d’heure de travail par jour et combien de jour par semaine</label>
                <input type="text" id="q9" name="q9" required>
            </div>
            <div class="question">
                <label for="q10">10) Quel est le salaire de base par heure $</label>
                <input type="text" id="q10" name="q10" required>
            </div>
            <div class="question">
                <label for="q11">11) Exigences linguistiques :</label>
                <select id="q11" name="q11" required>
                    <option value="Français">Français</option>
                    <option value="Anglais">Anglais</option>
                    <option value="Français ou anglais">Français ou anglais</option>
                    <option value="Français et anglais">Français et anglais</option>
                </select>
                <textarea id="q11_justification" name="q11_justification" placeholder="Justifiez si aucune exigence"></textarea>
            </div>
            <div class="question">
                <label for="q12">12) Exigences minimales de scolarité/ expérience relatives au poste.</label>
                <select id="q12" name="q12" required>
                    <option value="Aucune étude">Aucune étude</option>
                    <option value="Études secondaire">Études secondaire</option>
                    <option value="Diplôme collégial">Diplôme collégial</option>
                    <option value="Autres">Autres</option>
                </select>
            </div>
            <div class="question">
                <label for="q13">13) Décrivez en détails les inquiétudes concernant la sécurité ou les dangers associés à l’activité commerciale ou au lieu de travail.</label>
                <textarea id="q13" name="q13" required></textarea>
            </div>
            <div class="question">
                <label for="q14">14) Est-ce que vous allez fournir un logement convenable et abordable au travailleur ?</label>
                <input type="radio" id="q14_yes" name="q14" value="yes" required> Oui
                <input type="radio" id="q14_no" name="q14" value="no"> Non
                <textarea id="q14_details" name="q14_details" placeholder="Expliquez en détails (loyer, type d’hébergement, nombre de chambres et salle de bain) ou comment allez-vous l’assister" required></textarea>
            </div>
            <div class="question">
                <label for="q15">15) Indiquer l’échelle salariale (max et min pour ce type de travail dans votre entreprise)</label>
                <input type="text" id="q15_min" name="q15_min" placeholder="Minimum" required>
                <input type="text" id="q15_max" name="q15_max" placeholder="Maximum" required>
            </div>
            <div class="question">
                <label for="q16">16) Avez-vous mis les employés à pied au cours des 12 derniers mois? Si oui pourquoi, combien? Était-ce à cause de la Covid?</label>
                <textarea id="q16" name="q16" required></textarea>
            </div>
            <div class="question">
                <label for="q17">17) Quel est le nombre actuel de préposés à l’entretien ménager citoyens ou résidents permanents à votre emploi actuellement? Quel est le salaire minimum et maximum de ces préposés à l’entretien ménager?</label>
                <textarea id="q17" name="q17" required></textarea>
            </div>
            <div class="question">
                <label for="q18">18) Quel est le nombre total d’employés étrangers embauchés à l’aide d’une EIMT qui travaillent actuellement pour vous?</label>
                <textarea id="q18" name="q18" required></textarea>
            </div>
            <div class="question">
                <label for="q19">19) Combien de temps de pause? Pause rémunérée ou non? Poste syndiqué?</label>
                <textarea id="q19" name="q19" required></textarea>
            </div>
            <div class="question">
                <label for="q20">20) Fournir les adresses des différents lieux de travail où l’employé va se déplacer pour remplir ses tâches :</label>
                <textarea id="q20" name="q20" required></textarea>
            </div>
            <div class="question">
                <label for="q21">21) Avez-vous un compte à Guichet Emploi, Arrima, Mifi</label>
                <textarea id="q21" name="q21" required></textarea>
            </div>
            <div class="question">
                <label for="q22">Si oui, le quel? Voulez vous faire les démarches par vous-même?</label>
                <input type="radio" id="q22_yes" name="q22" value="yes" required> Oui, pas de soucis
                <input type="radio" id="q22_no" name="q22" value="no"> Non
                <textarea id="q22_details" name="q22_details" placeholder="Le candidat viendra de lui-même sans débourser majeur de votre part, seriez-vous prêt et disposer de lui offrir un contrat de 2 ans à temps plein sachant que notre politique de garantie de satisfaction vous offre 3 mois. Cela vous donne l’opportunité que le candidat peut-être remplacé sans frais dans les 3 mois." required></textarea>
            </div>
            <button type="submit">Soumettre</button>
        </form>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
