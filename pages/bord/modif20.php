<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $categorie = $_POST['categorie'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $sexe = $_POST['sexe'];
        $pays = $_POST['pays'];
        $prof = $_POST['prof'];


        $city = $_POST['city'];
        $specail = $_POST['specail'];
        $exp = $_POST['exp'];
        $permi = $_POST['permi'];
        $enfant = $_POST['enfant'];
        // Mise à jour des informations du candidat
        $stmt = $conn->prepare("UPDATE candidats SET categorie = ?, nom = ?, prenom = ?, email = ?, sexe = ?, pays = ?, prof = ?, city = ?, specail = ?, exp = ?, permi = ?, enfant = ? WHERE code = ?");
        $stmt->bind_param("sssssssssssss", $categorie, $nom, $prenom, $email, $sexe, $pays, $prof, $city, $specail, $exp, $permi, $enfant, $code);
        $stmt->execute();
        $stmt->close();

        // Mise à jour des parcours académiques
        if (isset($_POST['parcours_academique'])) {
            foreach ($_POST['parcours_academique'] as $id => $parcours) {
                $diplome = $parcours['diplome'];
                $institution = $parcours['institution'];
                $date_obtention = $parcours['date_obtention'];

                if ($id == 'new') {
                    // Ajout d'un nouveau parcours académique
                    $stmt = $conn->prepare("INSERT INTO parcours_academique (code, diplome, institution, date_obtention) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $code, $diplome, $institution, $date_obtention);
                } else {
                    // Mise à jour d'un parcours académique existant
                    $stmt = $conn->prepare("UPDATE parcours_academique SET diplome = ?, institution = ?, date_obtention = ? WHERE id = ?");
                    $stmt->bind_param("sssi", $diplome, $institution, $date_obtention, $id);
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        // Mise à jour des parcours professionnels
        if (isset($_POST['parcours_professionnel'])) {
            foreach ($_POST['parcours_professionnel'] as $id => $parcours) {
                $poste = $parcours['poste'];
                $entreprise = $parcours['entreprise'];
                $periode = $parcours['periode'];
                $pays_prof = $parcours['pays'];

                if ($id == 'new') {
                    // Ajout d'un nouveau parcours professionnel
                    $stmt = $conn->prepare("INSERT INTO parcours_professionnel (code, poste, entreprise, periode, pays) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $code, $poste, $entreprise, $periode, $pays_prof);
                } else {
                    // Mise à jour d'un parcours professionnel existant
                    $stmt = $conn->prepare("UPDATE parcours_professionnel SET poste = ?, entreprise = ?, periode = ?, pays = ? WHERE id = ?");
                    $stmt->bind_param("ssssi", $poste, $entreprise, $periode, $pays_prof, $id);
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        // Gestion des fichiers
        $uploads_dir = '../../uploads';
        $documents = ['diplome', 'cv', 'certificat_naissance', 'certificat_scolarite', 'passeport', 'mandat_representation'];

        foreach ($documents as $document) {
            if (isset($_FILES[$document]) && $_FILES[$document]['error'] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES[$document]['tmp_name'];
                $name = basename($_FILES[$document]['name']);
                move_uploaded_file($tmp_name, "$uploads_dir/$name");

                // Mise à jour du document dans la base de données
                $stmt = $conn->prepare("UPDATE documentss SET $document = ? WHERE code = ?");
                $stmt->bind_param("ss", $name, $code);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo "Mise à jour réussie !";
    }

    // Récupération des informations du candidat
    $stmt = $conn->prepare("SELECT * FROM candidats WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $candidat = $result->fetch_assoc();
    $stmt->close();

    // Récupération des parcours académiques
    $stmt_academique = $conn->prepare("SELECT * FROM parcours_academique WHERE code = ?");
    $stmt_academique->bind_param("s", $code);
    $stmt_academique->execute();
    $parcours_academique_result = $stmt_academique->get_result();

    // Récupération des parcours professionnels
    $stmt_professionnel = $conn->prepare("SELECT * FROM parcours_professionnel WHERE code = ?");
    $stmt_professionnel->bind_param("s", $code);
    $stmt_professionnel->execute();
    $parcours_professionnel_result = $stmt_professionnel->get_result();

} else {
    echo "Code du candidat manquant.";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le candidat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Modifier le candidat</h1>
    <form method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="categorie">Catégorie:</label>
    <select type="text" class="form-control" id="categorie" name="categorie" value="<?php echo htmlspecialchars($candidat['categorie'] ?? ''); ?>">
    <option value="Cadres supérieures">Cadres supérieures</option>
    <option value="Affaires, finance et administration">Affaires, finance et administration</option>
    <option value="Construction">Construction</option>
    <option value="Santé">Santé</option>
    <option value="Informatique">Informatique</option>
    <option value="Enseignement, droit et services sociaux">Enseignement, droit et services sociaux</option>
    <option value="Arts, culture, sports et loisirs">Arts, culture, sports et loisirs</option>
    <option value="Ingénieur">Ingénieur</option> 
    <option value="Restauration">Restauration</option>
    <option value="Vente et services">Vente et services</option>
    <option value="Aéronautique, transport, machinerie et domaines apparentés">Aéronautique, transport, machinerie et domaines apparentés</option>
    <option value="Ressources naturelles, agriculture et production connexe">Ressources naturelles, agriculture et production connexe</option>
    <option value="Fabrication et services d'utilité publique">Fabrication et services d'utilité publique</option>
    <option value="Autre">Autre</option>
 </select> 
</div>
<div class="form-group">
    <label for="nom">Nom:</label>
    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($candidat['nom'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="prenom">Prénom:</label>
    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($candidat['prenom'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($candidat['email'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="sexe">Sexe:</label>
    <input type="text" class="form-control" id="sexe" name="sexe" value="<?php echo htmlspecialchars($candidat['sexe'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="pays">Pays:</label>
    <input type="text" class="form-control" id="pays" name="pays" value="<?php echo htmlspecialchars($candidat['pays'] ?? ''); ?>">
</div>

<div class="form-group">
    <label for="city">Ville:</label>
    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($candidat['city'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="prof">Profession:</label>
    <input type="text" class="form-control" id="prof" name="prof" value="<?php echo htmlspecialchars($candidat['prof'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="specail">Spécialité:</label>
    <input type="text" class="form-control" id="specail" name="specail" value="<?php echo htmlspecialchars($candidat['specail'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="exp">Années d’expérience :</label>
    <input type="text" class="form-control" id="exp" name="exp" value="<?php echo htmlspecialchars($candidat['exp'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="permi">Permis de conduire:</label>
    <input type="text" class="form-control" id="permi" name="permi" value="<?php echo htmlspecialchars($candidat['permi'] ?? ''); ?>">
</div>
<div class="form-group">
    <label for="enfant">Nombre d'enfant:</label>
    <input type="text" class="form-control" id="enfant" name="enfant" value="<?php echo htmlspecialchars($candidat['enfant'] ?? ''); ?>">
</div>



        <h2>Parcours Académique</h2>
        <?php if ($parcours_academique_result->num_rows > 0) { ?>
            <?php while ($parcours_academique = $parcours_academique_result->fetch_assoc()) { ?>
                <div class="form-group">
                    <label for="diplome_<?php echo $parcours_academique['id']; ?>">Diplôme:</label>
                    <input type="text" class="form-control" id="diplome_<?php echo $parcours_academique['id']; ?>" name="parcours_academique[<?php echo $parcours_academique['id']; ?>][diplome]" value="<?php echo htmlspecialchars($parcours_academique['diplome']); ?>">
                </div>
                <div class="form-group">
                    <label for="institution_<?php echo $parcours_academique['id']; ?>">Institution:</label>
                    <input type="text" class="form-control" id="institution_<?php echo $parcours_academique['id']; ?>" name="parcours_academique[<?php echo $parcours_academique['id']; ?>][institution]" value="<?php echo htmlspecialchars($parcours_academique['institution']); ?>">
                </div>
                <div class="form-group">
                    <label for="date_obtention_<?php echo $parcours_academique['id']; ?>">Date d'obtention:</label>
                    <input type="text" class="form-control" id="date_obtention_<?php echo $parcours_academique['id']; ?>" name="parcours_academique[<?php echo $parcours_academique['id']; ?>][date_obtention]" value="<?php echo htmlspecialchars($parcours_academique['date_obtention']); ?>">
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun parcours académique trouvé.</p>
        <?php } ?>
        <div class="form-group">
            <button type="button" class="btn btn-secondary" onclick="addAcademique()">Ajouter un parcours académique</button>
        </div>

        <h2>Parcours Professionnel</h2>
        <?php if ($parcours_professionnel_result->num_rows > 0) { ?>
            <?php while ($parcours_professionnel = $parcours_professionnel_result->fetch_assoc()) { ?>
                <div class="form-group">
                    <label for="poste_<?php echo $parcours_professionnel['id']; ?>">Poste:</label>
                    <input type="text" class="form-control" id="poste_<?php echo $parcours_professionnel['id']; ?>" name="parcours_professionnel[<?php echo $parcours_professionnel['id']; ?>][poste]" value="<?php echo htmlspecialchars($parcours_professionnel['poste']); ?>">
                </div>
                <div class="form-group">
                    <label for="entreprise_<?php echo $parcours_professionnel['id']; ?>">Entreprise:</label>
                    <input type="text" class="form-control" id="entreprise_<?php echo $parcours_professionnel['id']; ?>" name="parcours_professionnel[<?php echo $parcours_professionnel['id']; ?>][entreprise]" value="<?php echo htmlspecialchars($parcours_professionnel['entreprise']); ?>">
                </div>
                <div class="form-group">
                    <label for="periode_<?php echo $parcours_professionnel['id']; ?>">Période:</label>
                    <input type="text" class="form-control" id="periode_<?php echo $parcours_professionnel['id']; ?>" name="parcours_professionnel[<?php echo $parcours_professionnel['id']; ?>][periode]" value="<?php echo htmlspecialchars($parcours_professionnel['periode']); ?>">
                </div>
                <div class="form-group">
                    <label for="pays_prof_<?php echo $parcours_professionnel['id']; ?>">Pays:</label>
                    <input type="text" class="form-control" id="pays_prof_<?php echo $parcours_professionnel['id']; ?>" name="parcours_professionnel[<?php echo $parcours_professionnel['id']; ?>][pays]" value="<?php echo htmlspecialchars($parcours_professionnel['pays']); ?>">
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun parcours professionnel trouvé.</p>
        <?php } ?>
        <div class="form-group">
            <button type="button" class="btn btn-secondary" onclick="addProfessionnel()">Ajouter un parcours professionnel</button>
        </div>

        <h2>Documents</h2>
        <div class="form-group">
            <label for="diplome">Diplôme:</label>
            <input type="file" class="form-control-file" id="diplome" name="diplome">
        </div>
        <div class="form-group">
            <label for="cv">CV:</label>
            <input type="file" class="form-control-file" id="cv" name="cv">
        </div>
        <div class="form-group">
            <label for="certificat_naissance">Certificat de naissance:</label>
            <input type="file" class="form-control-file" id="certificat_naissance" name="certificat_naissance">
        </div>
        <div class="form-group">
            <label for="certificat_scolarite">Certificat de scolarité:</label>
            <input type="file" class="form-control-file" id="certificat_scolarite" name="certificat_scolarite">
        </div>
        <div class="form-group">
            <label for="passeport">Passeport:</label>
            <input type="file" class="form-control-file" id="passeport" name="passeport">
        </div>
        <div class="form-group">
            <label for="mandat_representation">Mandat de représentation:</label>
            <input type="file" class="form-control-file" id="mandat_representation" name="mandat_representation">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script>
function addAcademique() {
    const formGroup = document.createElement('div');
    formGroup.className = 'form-group';
    formGroup.innerHTML = `
        <label for="diplome_new">Diplôme:</label>
        <input type="text" class="form-control" id="diplome_new" name="parcours_academique[new][diplome]">
        <label for="institution_new">Institution:</label>
        <input type="text" class="form-control" id="institution_new" name="parcours_academique[new][institution]">
        <label for="date_obtention_new">Date d'obtention:</label>
        <input type="text" class="form-control" id="date_obtention_new" name="parcours_academique[new][date_obtention]">
    `;
    document.querySelector('form').insertBefore(formGroup, document.querySelector('form').querySelector('.form-group:last-child'));
}

function addProfessionnel() {
    const formGroup = document.createElement('div');
    formGroup.className = 'form-group';
    formGroup.innerHTML = `
        <label for="poste_new">Poste:</label>
        <input type="text" class="form-control" id="poste_new" name="parcours_professionnel[new][poste]">
        <label for="entreprise_new">Entreprise:</label>
        <input type="text" class="form-control" id="entreprise_new" name="parcours_professionnel[new][entreprise]">
        <label for="periode_new">Période:</label>
        <input type="text" class="form-control" id="periode_new" name="parcours_professionnel[new][periode]">
        <label for="pays_prof_new">Pays:</label>
        <input type="text" class="form-control" id="pays_prof_new" name="parcours_professionnel[new][pays]">
    `;
    document.querySelector('form').insertBefore(formGroup, document.querySelector('form').querySelector('.form-group:last-child'));
}
</script>
</body>
</html>
