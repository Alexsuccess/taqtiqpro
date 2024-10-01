<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Analyse Préliminaire</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #004b87;
            color: white;
            padding: 20px;
        }
        .important {
            background-color: red;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
        }
        .form-section {
            background-color: #e9f1f7;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .form-section h5 {
            background-color: #004b87;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .table-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        .table {
            background-color: #f2f6f9;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header text-center">
        <h1>COMMISSION DE LA CONSTRUCTION DU QUÉBEC</h1>
        <h2>DEMANDE D'ANALYSE PRÉLIMINAIRE</h2>
        <p>RECONNAISSANCE DE L'EXPÉRIENCE DE TRAVAIL</p>
       <p> (RECRUTEMENT INTERNATIONAL)
POUR UN MÉTIER (SAUF CELUI DE GRUTIER) <p>
    </div>

    <!-- Important Message -->
    <div class="important">
        <strong>IMPORTANT:</strong> Pour toute question, veuillez écrire à l'adresse courriel suivante : <strong>reconnaissance@ccq.org</strong>
    </div>
 <p style="color: red;">Les champs marqués d’un astérisque (*) sont obligatoires. <p>
    <!-- Form Section 1 - Identification du demandeur -->
    <div class="container form-section">
        <h5>1. IDENTIFICATION DU DEMANDEUR</h5>
<form>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nom">Nom*</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
        </div>
        <div class="form-group col-md-6">
            <label for="prenom">Prénom*</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="tel">N° de téléphone principal*</label>
            <input type="tel" class="form-control" id="tel" name="telephone_principal" placeholder="Téléphone principal" required>
        </div>
        <div class="form-group col-md-6">
            <label for="autre_tel">Autre n° de téléphone</label>
            <input type="tel" class="form-control" id="autre_tel" name="autre_telephone" placeholder="Autre téléphone">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="numero">No*</label>
            <input type="text" class="form-control" id="numero" name="numero" placeholder="Numéro" required>
        </div>
        <div class="form-group col-md-2">
            <label for="rue">Rue*</label>
            <input type="text" class="form-control" id="rue" name="rue" placeholder="Rue" required>
        </div>
        <div class="form-group col-md-2">
            <label for="appartement">No d’appartement*</label>
            <input type="text" class="form-control" id="appartement" name="appartement" placeholder="Appartement" required>
        </div>
        <div class="form-group col-md-2">
            <label for="case_postale">Case postale</label>
            <input type="text" class="form-control" id="case_postale" name="case_postale" placeholder="Case postale">
        </div>
        <div class="form-group col-md-2">
            <label for="ville">Ville*</label>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" required>
        </div>
        <div class="form-group col-md-2">
            <label for="province">Province*</label>
            <input type="text" class="form-control" id="province" name="province" placeholder="Province" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="pays">Pays*</label>
            <input type="text" class="form-control" id="pays" name="pays" placeholder="Pays" required>
        </div>
        <div class="form-group col-md-4">
            <label for="code_postal">Code postal*</label>
            <input type="text" class="form-control" id="code_postal" name="code_postal" placeholder="Code postal" required>
        </div>
        <div class="form-group col-md-4">
            <label for="email">Adresse courriel*</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Adresse courriel" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="metier">Métier pour lequel vous désirez faire l’étude*</label>
            <input type="text" class="form-control" id="metier" name="metier" placeholder="Métier" required>
        </div>
        <div class="form-group col-md-4">
            <label for="sexe">Sexe*</label>
            <select class="form-control" id="sexe" name="sexe" required>
                <option value="" disabled selected>Choisir...</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="date_naissance">Date de naissance (AAAA-MM-JJ)*</label>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
        </div>
    </div>
</form>

    </div>

<!-- Form Section 2 - Identification de l'employeur -->
<div class="container form-section">
    <h5>2. IDENTIFICATION DE L'EMPLOYEUR</h5>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nom-entreprise-employeur">Nom de l'entreprise*</label>
                <input type="text" class="form-control" id="nom-entreprise-employeur" name="nom_entreprise_employeur" placeholder="Nom de l'entreprise">
            </div>
            <div class="form-group col-md-6">
                <label for="numero-ccq-employeur">N d’employeur à la CCQ</label>
                <input type="text" class="form-control" id="numero-ccq-employeur" name="numero_ccq_employeur" placeholder="Numéro CCQ">
            </div>

            <div class="form-group col-md-6">
                <label for="telephone-principal-employeur">N° de téléphone principal* </label>
                <input type="tel" class="form-control" id="telephone-principal-employeur" name="telephone_principal_employeur" placeholder="Téléphone principal">
            </div>
            <div class="form-group col-md-6">
                <label for="responsable-entreprise-employeur">Nom et fonction de la personne responsable de l’entreprise</label>
                <input type="text" class="form-control" id="responsable-entreprise-employeur" name="responsable_entreprise_employeur" placeholder="Nom et fonction">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="numero-employeur">No* </label>
                <input type="text" class="form-control" id="numero-employeur" name="numero_employeur" placeholder="Numéro">
            </div>
            <div class="form-group col-md-3">
                <label for="rue-employeur">Rue* </label>
                <input type="text" class="form-control" id="rue-employeur" name="rue_employeur" placeholder="Rue">
            </div>

            <div class="form-group col-md-3">
                <label for="bureau-local-employeur">N° de bureau ou de local*</label>
                <input type="text" class="form-control" id="bureau-local-employeur" name="bureau_local_employeur" placeholder="Bureau ou local">
            </div>
            <div class="form-group col-md-3">
                <label for="case-postale-employeur">Case postale*</label>
                <input type="text" class="form-control" id="case-postale-employeur" name="case_postale_employeur" placeholder="Case postale">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="ville-employeur">Ville* </label>
                <input type="text" class="form-control" id="ville-employeur" name="ville_employeur" placeholder="Ville">
            </div>
            <div class="form-group col-md-4">
                <label for="province-employeur">Province* </label>
                <input type="text" class="form-control" id="province-employeur" name="province_employeur" placeholder="Province">
            </div>

            <div class="form-group col-md-4">
                <label for="code-postal-employeur">Code postal*</label>
                <input type="text" class="form-control" id="code-postal-employeur" name="code_postal_employeur" placeholder="Code postal">
            </div>
        </div>
    </form>
</div>

    </div>

    <!-- Table Section - Documents Requis -->
    <div class="container table-section">
        <h5>3. DOCUMENTS REQUIS POUR LA RECONNAISSANCE DE L'EXPÉRIENCE DE TRAVAIL</h5>
        <h7><strong style="color: blue;">Salarié</strong> </h7>
<p> 1. Une ou plusieurs fiches d’expérience de travail prouvant au moins 35 % des heures d’apprentissage du métier (voir la Fiche d’expérience
de travail – Salarié à la suite du présent formulaire), signées par le responsable de l’entreprise pour laquelle vous avez effectué des
tâches liées à votre métier</br>
2. Des preuves de rémunération pour valider chacune des fiches d’expérience de travail (relevés de paie, déclaration de revenus) </p>
<hr>
<h7><strong style="color: blue;">Travailleur autonom</strong> </h7>

<p> 1. Une ou plusieurs fiches d’expérience de travail prouvant au moins 35 % des heures d’apprentissage du métier (voir la Fiche d’expérience
de travail – Travailleur autonome à la suite du présent formulaire), en y indiquant les informations pour chaque contrat.</br>
2. La preuve de déclaration de revenus pour chaque année revendiquée.</br>
3. La preuve qui démontre l’exécution des travaux, pour chaque contrat soumis (ex. : facture, contrat, lettre de donneur d’ouvage)</p>
<hr>
<p><strong>Aux fins d’analyse de votre demande, vous devez démontrer de l’expérience de travail équivalant minimalement à 35 % de
l’apprentissage du métier visé, soi</strong> </p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Salarié</th>
                    <th>Travailleur autonome</th>
                    <th>Heures minimales requises</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Fiches d'expérience prouvant l'apprentissage de 35 %.</td>
                    <td>Fiches indiquant l'exécution des travaux.</td>
                    <td>700 heures</td>
                </tr>
                <tr>
                    <td>Relevé de paie signé par l'employeur.</td>
                    <td>Preuve de factures, contrats.</td>
                    <td>1 400 heures</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>2 100 heures</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>2 800 heures</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>3 500 heures</td>
                </tr>
            </tbody>
        </table>
    </div>















    <!-- Header -->
    <div class="header">
        <h1>FICHE D'EXPÉRIENCE DE TRAVAIL – SALARIÉ</h1>
        <p>Remplissez autant de fiches que nécessaire pour démontrer l’ensemble des heures d’expérience de travail que vous souhaitez faire reconnaître.</p>
    </div>

    <!-- Form Section 1 - Identification du demandeur -->
    <div class="container form-section">
        <h5>1. IDENTIFICATION DU DEMANDEUR</h5>
        <form>
            <div class="form-group">
                <label for="metier">Métier pour lequel vous désirez faire reconnaître des heures</label>
                <input type="text" class="form-control" id="metier" placeholder="Entrez le métier">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" placeholder="Nom">
                </div>
                <div class="form-group col-md-6">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" placeholder="Prénom">
                </div>
            </div>
        </form>
    </div>

    <!-- Form Section 2 - Identification de l'entreprise -->
    <div class="container form-section">
        <h5>2. IDENTIFICATION DE L'ENTREPRISE</h5>
        <form>
            <div class="form-group">
                <label for="nom-entreprise">Nom de l'entreprise</label>
                <input type="text" class="form-control" id="nom-entreprise" placeholder="Nom de l'entreprise">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tel-principal">N° de téléphone principal</label>
                    <input type="tel" class="form-control" id="tel-principal" placeholder="Téléphone principal">
                </div>
                <div class="form-group col-md-6">
                    <label for="fonction-personne">Nom ou fonction de la personne responsable</label>
                    <input type="text" class="form-control" id="fonction-personne" placeholder="Fonction ou nom">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" placeholder="Adresse complète">
                </div>
                <div class="form-group col-md-6">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" placeholder="Ville">
                </div>
            </div>
        </form>
    </div>

    <!-- Form Section 3 - Sommaire des heures travaillées par année -->
    <div class="container form-section">
        <h5>3. SOMMAIRE DES HEURES TRAVAILLÉES PAR ANNÉE</h5>
        <form>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="annee1">Année</label>
                    <input type="text" class="form-control" id="annee1" placeholder="Année">
                </div>
                <div class="form-group col-md-9">
                    <label for="heures1">Total des heures pour cette année</label>
                    <input type="text" class="form-control" id="heures1" placeholder="Nombre d'heures">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="annee2">Année</label>
                    <input type="text" class="form-control" id="annee2" placeholder="Année">
                </div>
                <div class="form-group col-md-9">
                    <label for="heures2">Total des heures pour cette année</label>
                    <input type="text" class="form-control" id="heures2" placeholder="Nombre d'heures">
                </div>
            </div>
        </form>
    </div>

    <!-- Form Section 4 - Description des types de chantier -->
    <div class="container form-section">
        <h5>4. DESCRIPTION DES TYPES DE CHANTIER</h5>
        <form>
            <div class="form-group">
                <label for="chantier">Types de chantier</label>
                <textarea class="form-control" id="chantier" rows="3" placeholder="Description des types de chantier"></textarea>
            </div>
        </form>
    </div>

    <!-- Form Section 5 - Description des tâches -->
    <div class="container form-section">
        <h5>5. DESCRIPTION DES TÂCHES</h5>
        <form>
            <div class="form-group">
                <label for="tache1">Description détaillée de la tâche</label>
                <textarea class="form-control" id="tache1" rows="2" placeholder="Tâche 1"></textarea>
            </div>
            <div class="form-group">
                <label for="tache2">Description détaillée de la tâche</label>
                <textarea class="form-control" id="tache2" rows="2" placeholder="Tâche 2"></textarea>
            </div>
            <div class="form-group">
                <label for="tache3">Description détaillée de la tâche</label>
                <textarea class="form-control" id="tache3" rows="2" placeholder="Tâche 3"></textarea>
            </div>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
