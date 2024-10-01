<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Demande</title>
    <style type="text/css">
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 20px;
}

form {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    font-size: 1.8em;
    color: #333;
    margin-bottom: 20px;
}

fieldset {
    border: 1px solid #ddd;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
}

legend {
    font-weight: bold;
    font-size: 1.2em;
    color: #333;
    padding: 0 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 10px;
}

.form-group {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.form-group label {
    flex: 0 0 200px;
    padding-right: 10px;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group textarea {
    flex: 1;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

input[type="radio"] {
    margin: 0 5px 0 20px;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background-color: #fff;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    background-color: #fff;
}

th {
    background-color: #f4f4f9;
    color: #333;
}

textarea {
    width: 100%;
    min-height: 100px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

button {
    display: block;
    width: 100%;
    padding: 10px;
    margin: 20px 0;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1em;
    cursor: pointer;
    text-align: center;
}

button:hover {
    background-color: #0056b3;
}





body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 20px;
}

form {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    font-size: 1.8em;
    color: #333;
    margin-bottom: 20px;
}

fieldset {
    border: 1px solid #ddd;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
}

legend {
    font-weight: bold;
    font-size: 1.2em;
    color: #333;
    padding: 0 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 10px;
}

.form-group {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.form-group label {
    flex: 0 0 200px;
    padding-right: 10px;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group textarea {
    flex: 1;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

input[type="radio"] {
    margin: 0 5px 0 20px;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background-color: #fff;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    background-color: #fff;
}

th {
    background-color: #f4f4f9;
    color: #333;
}

textarea {
    width: 100%;
    min-height: 100px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

button {
    display: block;
    width: 100%;
    padding: 10px;
    margin: 20px 0;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1em;
    cursor: pointer;
    text-align: center;
}

button:hover {
    background-color: #0056b3;
}


    </style>
</head>
<body>
    <form>
        <h1>DEMANDE PRÉLIMINAIRE ÛMAN RESSOURCES INTERNATIONAL</h1>
        
        <fieldset>
            <legend>(1) IDENTIFICATION</legend>
            <div class="form-group">
                <label for="nom">Nom de famille:</label>
                <input type="text" id="nom" name="nom">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom(s):</label>
                <input type="text" id="prenom" name="prenom">
            </div>

            <div class="form-group">
                <label for="autresNoms">Tous les autres noms que vous avez déjà utilisés, y compris votre nom de jeune fille:</label>
                <input type="text" id="autresNoms" name="autresNoms">
            </div>

            <div class="form-group">
                <label>Sexe:</label>
                <input type="radio" id="homme" name="sexe" value="homme">
                <label for="homme">Homme</label>
                <input type="radio" id="femme" name="sexe" value="femme">
                <label for="femme">Femme</label>
            </div>

            <div class="form-group">
                <label for="dateNaissance">Date de naissance:</label>
                <input type="date" id="dateNaissance" name="dateNaissance">
            </div>

            <div class="form-group">
                <label for="paysNaissance">Pays de naissance:</label>
                <input type="text" id="paysNaissance" name="paysNaissance">
            </div>

            <div class="form-group">
                <label for="nationalites">Nationalité(s):</label>
                <input type="text" id="nationalites" name="nationalites">
            </div>

            <div class="form-group">
                <label for="paysResidence">Pays de résidence actuel:</label>
                <input type="text" id="paysResidence" name="paysResidence">
                <label for="residenceDepuis">Depuis :</label>
                <input type="date" id="residenceDepuis" name="residenceDepuis">
            </div>

            <div class="form-group">
                <label for="numPasseport">Numéro de passeport:</label>
                <input type="text" id="numPasseport" name="numPasseport">
            </div>

            <div class="form-group">
                <label for="paysDelivrance">Pays de délivrance:</label>
                <input type="text" id="paysDelivrance" name="paysDelivrance">
            </div>

            <div class="form-group">
                <label for="dateExpirationPasseport">Date d’expiration:</label>
                <input type="date" id="dateExpirationPasseport" name="dateExpirationPasseport">
            </div>

            <div class="form-group">
                <label>Avez-vous (ou un membre de votre famille – conjoint ou enfant) la résidence permanente au Canada ?</label>
                <input type="radio" id="residenceOui" name="residencePermanente" value="oui">
                <label for="residenceOui">Oui</label>
                <input type="radio" id="residenceNon" name="residencePermanente" value="non">
                <label for="residenceNon">Non</label>
            </div>

            <div class="form-group">
                <label for="quiResidence">Si oui qui :</label>
                <input type="text" id="quiResidence" name="quiResidence">
            </div>

            <div class="form-group">
                <label for="autrePays">Si vous appliquez d'un autre pays que votre pays d'origine, veuillez indiquer :</label>
                <input type="text" id="autrePays" name="autrePays">
            </div>

            <div class="form-group">
                <label for="dureeResidence">Depuis combien de temps résidez-vous dans ce pays?</label>
                <input type="text" id="dureeResidence" name="dureeResidence">
            </div>

            <div class="form-group">
                <label>Êtes-vous entré dans ce pays avec un visa?</label>
                <input type="radio" id="visaOui" name="visa" value="oui">
                <label for="visaOui">Oui</label>
                <input type="radio" id="visaNon" name="visa" value="non">
                <label for="visaNon">Non</label>
            </div>

            <div class="form-group">
                <label for="detailsVisa">Si oui, veuillez spécifier les détails de ce visa</label>
            </div>
            <div class="form-group">
                <label for="categorieVisa">Catégorie de visa:</label>
                <input type="text" id="categorieVisa" name="categorieVisa">
            </div>
            <div class="form-group">
                <label for="dateDelivranceVisa">Date de délivrance:</label>
                <input type="date" id="dateDelivranceVisa" name="dateDelivranceVisa">
            </div>
            <div class="form-group">
                <label for="dateExpirationVisa">Date d’expiration:</label>
                <input type="date" id="dateExpirationVisa" name="dateExpirationVisa">
            </div>
        </fieldset>

        <fieldset>
            <legend>(2) SITUATION FAMILIALE</legend>
            <div class="form-group">
                <label for="etatMatrimonial">État matrimonial actuel:</label>
                <input type="radio" id="celibataire" name="etatMatrimonial" value="celibataire">
                <label for="celibataire">Célibataire</label>
                <input type="radio" id="marie" name="etatMatrimonial" value="marie">
                <label for="marie">Marié(e)</label>
                <input type="radio" id="divorce" name="etatMatrimonial" value="divorce">
                <label for="divorce">Divorcé(e)</label>
                <input type="radio" id="mariageAnnule" name="etatMatrimonial" value="mariageAnnule">
                <label for="mariageAnnule">Mariage annulé</label>
                <input type="radio" id="conjointDeFait" name="etatMatrimonial" value="conjointDeFait">
                <label for="conjointDeFait">Conjoint de fait</label>
                <input type="radio" id="separe" name="etatMatrimonial" value="separe">
                <label for="separe">Séparé(e)</label>
                <input type="radio" id="veuf" name="etatMatrimonial" value="veuf">
                <label for="veuf">Veuf(ve)</label>
            </div>

            <div class="form-group">
                <label for="mariagePlusDuneFois">Si marié : Vous êtes-vous marié plus d’une fois ?</label>
                <input type="radio" id="mariePlusDuneFoisOui" name="mariePlusDuneFois" value="oui">
                <label for="mariePlusDuneFoisOui">Oui</label>
                <input type="radio" id="mariePlusDuneFoisNon" name="mariePlusDuneFois" value="non">
                <label for="mariePlusDuneFoisNon">Non</label>
            </div>
            <div class="form-group">
                <label for="nombreDeFois">Si oui, nombre de fois :</label>
                <input type="number" id="nombreDeFois" name="nombreDeFois">
            </div>

            <div class="form-group">
                <label for="cohabitationDate">Si conjoint de fait : Date depuis laquelle vous cohabitez :</label>
                <input type="date" id="cohabitationDate" name="cohabitationDate">
            </div>
        </fieldset>

        <fieldset>
            <legend>(3) ADRESSE</legend>
            <div class="form-group">
                <label for="adresseResidence">Adresse de résidence:</label>
            </div>
            <div class="form-group">
                <label for="numeroRue">Numéro:</label>
                <input type="text" id="numeroRue" name="numeroRue">
                <label for="rue">Rue:</label>
                <input type="text" id="rue" name="rue">
            </div>
            <div class="form-group">
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville">
                <label for="province">Province / État:</label>
                <input type="text" id="province" name="province">
                <label for="codePostal">Code postal:</label>
                <input type="text" id="codePostal" name="codePostal">
                <label for="pays">Pays:</label>
                <input type="text" id="pays" name="pays">
            </div>

            <div class="form-group">
                <label for="telephone">Numéro de téléphone:</label>
                <label for="telDomicile">Domicile:</label>
                <input type="tel" id="telDomicile" name="telDomicile">
                <label for="telTravail">Travail:</label>
                <input type="tel" id="telTravail" name="telTravail">
                <label for="telAutre">Autre (précisez):</label>
                <input type="tel" id="telAutre" name="telAutre">
            </div>

            <div class="form-group">
                <label for="telecopieur">Numéro de télécopieur:</label>
                <input type="tel" id="telecopieur" name="telecopieur">
            </div>

            <div class="form-group">
                <label for="courriel">Courrier électronique :</label>
            </div>
            <div class="form-group">
                <label for="emailDomicile">Domicile:</label>
                <input type="email" id="emailDomicile" name="emailDomicile">
                <label for="emailTravail">Travail:</label>
                <input type="email" id="emailTravail" name="emailTravail">
            </div>

            <div class="form-group">
                <label for="adresseConjoint">Adresse du conjoint et des enfants à charge (si différente de l’adresse permanente):</label>
            </div>
            <div class="form-group">
                <label for="numeroRueConjoint">Numéro:</label>
                <input type="text" id="numeroRueConjoint" name="numeroRueConjoint">
                <label for="rueConjoint">Rue:</label>
                <input type="text" id="rueConjoint" name="rueConjoint">
                <label for="villeConjoint">Ville:</label>
                <input type="text" id="villeConjoint" name="villeConjoint">
                <label for="provinceConjoint">Province / État:</label>
                <input type="text" id="provinceConjoint" name="provinceConjoint">
                <label for="codePostalConjoint">Code postal:</label>
                <input type="text" id="codePostalConjoint" name="codePostalConjoint">
                <label for="paysConjoint">Pays:</label>
                <input type="text" id="paysConjoint" name="paysConjoint">
            </div>
        </fieldset>

        <fieldset>
            <legend>(4) A- INFORMATIONS SUR LES MEMBRES DE LA FAMILLE (CONJOINT(E) ET ENFANTS SEULEMENT)- Inclure enfants du conjoint(e)</legend>
            <table>
                <tr>
                    <th>Nom de famille à la naissance</th>
                    <th>Prénom</th>
                    <th>Relation</th>
                    <th>Nationalité</th>
                    <th>Date de naissance</th>
                    <th>Date d’expiration du passeport</th>
                </tr>
                <tr>
                    <td><input type="text" name="nomFamilleNaissance1"></td>
                    <td><input type="text" name="prenom1"></td>
                    <td><input type="text" name="relation1"></td>
                    <td><input type="text" name="nationalite1"></td>
                    <td><input type="date" name="dateNaissance1"></td>
                    <td><input type="date" name="dateExpirationPasseport1"></td>
                </tr>
                <tr>
                    <td><input type="text" name="nomFamilleNaissance2"></td>
                    <td><input type="text" name="prenom2"></td>
                    <td><input type="text" name="relation2"></td>
                    <td><input type="text" name="nationalite2"></td>
                    <td><input type="date" name="dateNaissance2"></td>
                    <td><input type="date" name="dateExpirationPasseport2"></td>
                </tr>
                <tr>
                    <td><input type="text" name="nomFamilleNaissance3"></td>
                    <td><input type="text" name="prenom3"></td>
                    <td><input type="text" name="relation3"></td>
                    <td><input type="text" name="nationalite3"></td>
                    <td><input type="date" name="dateNaissance3"></td>
                    <td><input type="date" name="dateExpirationPasseport3"></td>
                </tr>
                <tr>
                    <td><input type="text" name="nomFamilleNaissance4"></td>
                    <td><input type="text" name="prenom4"></td>
                    <td><input type="text" name="relation4"></td>
                    <td><input type="text" name="nationalite4"></td>
                    <td><input type="date" name="dateNaissance4"></td>
                    <td><input type="date" name="dateExpirationPasseport4"></td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend>(4) B- EST-CE QU’ILS VOUS ACCOMPAGNERONT? PRÉCISEZ.</legend>
            <textarea name="accompagnementDetails" rows="4" cols="50"></textarea>
        </fieldset>

        <fieldset>
            <legend>(4) C – SI OUI, VIENDRONT-ILS EN MÊME TEMPS QUE VOUS ?</legend>
            <textarea name="memeTempsDetails" rows="4" cols="50"></textarea>
        </fieldset>

        <fieldset>
            <legend>(4) D – EST-CE QUE VOTRE CONJOINT(E) A L’INTENTION DE TRAVAILLER DANS LE DOMAINE MÉDICAL OU AVEC DE JEUNES ENFANTS ?</legend>
            <textarea name="travailDomaineMedicalDetails" rows="4" cols="50"></textarea>
        </fieldset>
    </form>




    <form>
        <!-- Sections précédentes (1) à (4) non incluses pour concision -->
        
        <!-- Section (5) ÉTUDES -->
        <fieldset>
            <legend>(5) ÉTUDES</legend>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Secondaires, post-secondaires, et universitaires</th>
                            <th>De mois / année</th>
                            <th>À mois / année</th>
                            <th>Nom de l’établissement (ville et pays)</th>
                            <th>Spécialité</th>
                            <th>Nom du Diplôme ou du certificat obtenu</th>
                            <th>Langue d’enseignement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Secondaire</td>
                            <td><input type="text" name="secondaire_de"></td>
                            <td><input type="text" name="secondaire_a"></td>
                            <td><input type="text" name="secondaire_etablissement"></td>
                            <td><input type="text" name="secondaire_specialite"></td>
                            <td><input type="text" name="secondaire_diplome"></td>
                            <td><input type="text" name="secondaire_langue"></td>
                        </tr>
                        <tr>
                            <td>Post-secondaire</td>
                            <td><input type="text" name="post_secondaire_de"></td>
                            <td><input type="text" name="post_secondaire_a"></td>
                            <td><input type="text" name="post_secondaire_etablissement"></td>
                            <td><input type="text" name="post_secondaire_specialite"></td>
                            <td><input type="text" name="post_secondaire_diplome"></td>
                            <td><input type="text" name="post_secondaire_langue"></td>
                        </tr>
                        <tr>
                            <td>Baccalauréat (1er cycle)</td>
                            <td><input type="text" name="baccalaureat_de"></td>
                            <td><input type="text" name="baccalaureat_a"></td>
                            <td><input type="text" name="baccalaureat_etablissement"></td>
                            <td><input type="text" name="baccalaureat_specialite"></td>
                            <td><input type="text" name="baccalaureat_diplome"></td>
                            <td><input type="text" name="baccalaureat_langue"></td>
                        </tr>
                        <tr>
                            <td>Maîtrise (2e cycle)</td>
                            <td><input type="text" name="maitrise_de"></td>
                            <td><input type="text" name="maitrise_a"></td>
                            <td><input type="text" name="maitrise_etablissement"></td>
                            <td><input type="text" name="maitrise_specialite"></td>
                            <td><input type="text" name="maitrise_diplome"></td>
                            <td><input type="text" name="maitrise_langue"></td>
                        </tr>
                        <tr>
                            <td>Doctorat (3e cycle)</td>
                            <td><input type="text" name="doctorat_de"></td>
                            <td><input type="text" name="doctorat_a"></td>
                            <td><input type="text" name="doctorat_etablissement"></td>
                            <td><input type="text" name="doctorat_specialite"></td>
                            <td><input type="text" name="doctorat_diplome"></td>
                            <td><input type="text" name="doctorat_langue"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <label for="autres_etudes">Autres études avec diplôme(s) ou certificat(s) :</label>
                <textarea name="autres_etudes" id="autres_etudes" rows="4"></textarea>
            </div>
        </fieldset>

        <!-- Section (6) CONNAISSANCES LINGUISTIQUES -->
        <fieldset>
            <legend>(6) CONNAISSANCES LINGUISTIQUES</legend>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="4">FRANÇAIS</th>
                            <th colspan="4">ANGLAIS</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Excellent</th>
                            <th>Bon</th>
                            <th>Faible</th>
                            <th>Pas du tout</th>
                            <th>Excellent</th>
                            <th>Bon</th>
                            <th>Faible</th>
                            <th>Pas du tout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Compris</td>
                            <td><input type="radio" name="francais_compris" value="excellent"></td>
                            <td><input type="radio" name="francais_compris" value="bon"></td>
                            <td><input type="radio" name="francais_compris" value="faible"></td>
                            <td><input type="radio" name="francais_compris" value="pas_du_tout"></td>
                            <td><input type="radio" name="anglais_compris" value="excellent"></td>
                            <td><input type="radio" name="anglais_compris" value="bon"></td>
                            <td><input type="radio" name="anglais_compris" value="faible"></td>
                            <td><input type="radio" name="anglais_compris" value="pas_du_tout"></td>
                        </tr>
                        <tr>
                            <td>Parlé</td>
                            <td><input type="radio" name="francais_parle" value="excellent"></td>
                            <td><input type="radio" name="francais_parle" value="bon"></td>
                            <td><input type="radio" name="francais_parle" value="faible"></td>
                            <td><input type="radio" name="francais_parle" value="pas_du_tout"></td>
                            <td><input type="radio" name="anglais_parle" value="excellent"></td>
                            <td><input type="radio" name="anglais_parle" value="bon"></td>
                            <td><input type="radio" name="anglais_parle" value="faible"></td>
                            <td><input type="radio" name="anglais_parle" value="pas_du_tout"></td>
                        </tr>
                        <tr>
                            <td>Lu</td>
                            <td><input type="radio" name="francais_lu" value="excellent"></td>
                            <td><input type="radio" name="francais_lu" value="bon"></td>
                            <td><input type="radio" name="francais_lu" value="faible"></td>
                            <td><input type="radio" name="francais_lu" value="pas_du_tout"></td>
                            <td><input type="radio" name="anglais_lu" value="excellent"></td>
                            <td><input type="radio" name="anglais_lu" value="bon"></td>
                            <td><input type="radio" name="anglais_lu" value="faible"></td>
                            <td><input type="radio" name="anglais_lu" value="pas_du_tout"></td>
                        </tr>
                        <tr>
                            <td>Écrit</td>
                            <td><input type="radio" name="francais_ecrit" value="excellent"></td>
                            <td><input type="radio" name="francais_ecrit" value="bon"></td>
                            <td><input type="radio" name="francais_ecrit" value="faible"></td>
                            <td><input type="radio" name="francais_ecrit" value="pas_du_tout"></td>
                            <td><input type="radio" name="anglais_ecrit" value="excellent"></td>
                            <td><input type="radio" name="anglais_ecrit" value="bon"></td>
                            <td><input type="radio" name="anglais_ecrit" value="faible"></td>
                            <td><input type="radio" name="anglais_ecrit" value="pas_du_tout"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <label for="langue_maternelle">Quelle est votre langue maternelle?</label>
                <input type="text" name="langue_maternelle" id="langue_maternelle">
            </div>
            <div class="form-group">
                <label for="autre_langue">Parlez-vous une autre langue? Si oui, précisez :</label>
                <input type="text" name="autre_langue" id="autre_langue">
            </div>
        </fieldset>
    </form>

    
</body>
</html>
