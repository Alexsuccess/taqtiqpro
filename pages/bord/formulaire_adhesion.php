<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
        .section-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin-top: 20px;
            font-weight: bold;
            border-radius: 5px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Formulaire d'inscription</h1>
    </div>
    
    <div class="container mt-4">
        <form action="votre_script_php.php" method="post">
            <!-- Renseignement sur l’entreprise -->
            <div class="section-header">1. Renseignement sur l’entreprise</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom_legal">Nom légal :</label>
                        <input type="text" id="nom_legal" name="nom_legal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="no_permis">No permis :</label>
                        <input type="text" id="no_permis" name="no_permis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="raison_social">Raison sociale :</label>
                        <input type="text" id="raison_social" name="raison_social" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="neq">NEQ :</label>
                        <input type="text" id="neq" name="neq" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nom_contact">Nom du contact :</label>
                        <input type="text" id="nom_contact" name="nom_contact" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="ville" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone :</label>
                        <input type="text" id="telephone" name="telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="courriel">Courriel :</label>
                        <input type="email" id="courriel" name="courriel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tel_fax">Télécopie :</label>
                        <input type="text" id="tel_fax" name="tel_fax" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="site_internet">Site internet :</label>
                        <input type="text" id="site_internet" name="site_internet" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Valeur de projets souhaités -->
            <div class="section-header">2. Valeur de projets souhaités</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="valeur_min">Minimum :</label>
                        <input type="number" id="valeur_min" name="valeur_min" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="valeur_max">Maximum :</label>
                        <input type="number" id="valeur_max" name="valeur_max" class="form-control" step="0.01">
                    </div>
                </div>
            </div>

            <!-- Zone géographique couverte -->
            <div class="section-header">3. Zone géographique couverte</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rayon">Rayon :</label>
                        <input type="number" id="rayon" name="rayon" class="form-control" step="1">
                    </div>
                    <div class="form-group">
                        <label for="regions_desservies">Régions desservies :</label>
                        <textarea id="regions_desservies" name="regions_desservies" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <!-- Assurance responsabilité -->
            <div class="section-header">4. Assurance responsabilité</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="assureur">Assureur :</label>
                        <input type="text" id="assureur" name="assureur" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="agent">Agent :</label>
                        <input type="text" id="agent" name="agent" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date_expiration">Date d’expiration :</label>
                        <input type="date" id="date_expiration" name="date_expiration" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="montant_assure">Montant assuré :</label>
                        <input type="number" id="montant_assure" name="montant_assure" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="num_police">Numéro de police :</label>
                        <input type="text" id="num_police" name="num_police" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Référence bancaire -->
            <div class="section-header">5. Référence Bancaire</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="institution">Institution :</label>
                        <input type="text" id="institution" name="institution" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="succursale">Succursale :</label>
                        <input type="text" id="succursale" name="succursale" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telephone_bancaire">Téléphone :</label>
                        <input type="text" id="telephone_bancaire" name="telephone_bancaire" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="dir_compte">Dir. de compte :</label>
                        <input type="text" id="dir_compte" name="dir_compte" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="numero_compte">Numéro de compte :</label>
                        <input type="text" id="numero_compte" name="numero_compte" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="transit">Transit :</label>
                        <input type="text" id="transit" name="transit" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Fournisseurs -->
            <div class="section-header">5b. Fournisseurs</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fournisseur1_nom">1. Nom :</label>
                        <input type="text" id="fournisseur1_nom" name="fournisseur1_nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fournisseur1_adresse">Adresse :</label>
                        <input type="text" id="fournisseur1_adresse" name="fournisseur1_adresse" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fournisseur1_telephone">Téléphone :</label>
                        <input type="text" id="fournisseur1_telephone" name="fournisseur1_telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fournisseur1_tel_fax">Télécopie :</label>
                        <input type="text" id="fournisseur1_tel_fax" name="fournisseur1_tel_fax" class="form-control">
                    </div>
                </div>
                <!-- Répétez le bloc ci-dessus pour chaque fournisseur supplémentaire -->
            </div>

            <!-- Clients récents -->
            <div class="section-header">5c. Clients (récents)</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client1_nom">1. Nom :</label>
                        <input type="text" id="client1_nom" name="client1_nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="client1_adresse">Adresse :</label>
                        <input type="text" id="client1_adresse" name="client1_adresse" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="client1_telephone">Téléphone :</label>
                        <input type="text" id="client1_telephone" name="client1_telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="client1_tel_fax">Télécopie :</label>
                        <input type="text" id="client1_tel_fax" name="client1_tel_fax" class="form-control">
                    </div>
                </div>
                <!-- Répétez le bloc ci-dessus pour chaque client supplémentaire -->
            </div>

            <!-- Propriétaires ou partenaires -->
            <div class="section-header">6. PROPRIETAIRE OU PARTENAIRE 2</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proprietaire2_prenom">Prénom :</label>
                        <input type="text" id="proprietaire2_prenom" name="proprietaire2_prenom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_nom">Nom de famille :</label>
                        <input type="text" id="proprietaire2_nom" name="proprietaire2_nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_titre">Titre :</label>
                        <input type="text" id="proprietaire2_titre" name="proprietaire2_titre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_date_naissance">Date de naissance (JJ/MM/AA) :</label>
                        <input type="text" id="proprietaire2_date_naissance" name="proprietaire2_date_naissance" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_nas">N.A.S. :</label>
                        <input type="text" id="proprietaire2_nas" name="proprietaire2_nas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_pourcentage_propriete">Pourcentage de propriété :</label>
                        <input type="number" id="proprietaire2_pourcentage_propriete" name="proprietaire2_pourcentage_propriete" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_adresse">Adresse :</label>
                        <input type="text" id="proprietaire2_adresse" name="proprietaire2_adresse" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_ville">Ville :</label>
                        <input type="text" id="proprietaire2_ville" name="proprietaire2_ville" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_code_postal">Code postal :</label>
                        <input type="text" id="proprietaire2_code_postal" name="proprietaire2_code_postal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_province">Province :</label>
                        <input type="text" id="proprietaire2_province" name="proprietaire2_province" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_telephone">Téléphone :</label>
                        <input type="text" id="proprietaire2_telephone" name="proprietaire2_telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_courriel">Courriel :</label>
                        <input type="email" id="proprietaire2_courriel" name="proprietaire2_courriel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_signature">Signature autorisée :</label>
                        <input type="text" id="proprietaire2_signature" name="proprietaire2_signature" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_date">Date :</label>
                        <input type="date" id="proprietaire2_date" name="proprietaire2_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_nom_final">Nom :</label>
                        <input type="text" id="proprietaire2_nom_final" name="proprietaire2_nom_final" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire2_titre_final">Titre :</label>
                        <input type="text" id="proprietaire2_titre_final" name="proprietaire2_titre_final" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Propriétaires ou partenaires 3 -->
            <div class="section-header">7. PROPRIETAIRE OU PARTENAIRE 3</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proprietaire3_prenom">Prénom :</label>
                        <input type="text" id="proprietaire3_prenom" name="proprietaire3_prenom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_nom">Nom de famille :</label>
                        <input type="text" id="proprietaire3_nom" name="proprietaire3_nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_titre">Titre :</label>
                        <input type="text" id="proprietaire3_titre" name="proprietaire3_titre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_date_naissance">Date de naissance (JJ/MM/AA) :</label>
                        <input type="text" id="proprietaire3_date_naissance" name="proprietaire3_date_naissance" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_nas">N.A.S. :</label>
                        <input type="text" id="proprietaire3_nas" name="proprietaire3_nas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_pourcentage_propriete">Pourcentage de propriété :</label>
                        <input type="number" id="proprietaire3_pourcentage_propriete" name="proprietaire3_pourcentage_propriete" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_adresse">Adresse :</label>
                        <input type="text" id="proprietaire3_adresse" name="proprietaire3_adresse" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_ville">Ville :</label>
                        <input type="text" id="proprietaire3_ville" name="proprietaire3_ville" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_code_postal">Code postal :</label>
                        <input type="text" id="proprietaire3_code_postal" name="proprietaire3_code_postal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_province">Province :</label>
                        <input type="text" id="proprietaire3_province" name="proprietaire3_province" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_telephone">Téléphone :</label>
                        <input type="text" id="proprietaire3_telephone" name="proprietaire3_telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_courriel">Courriel :</label>
                        <input type="email" id="proprietaire3_courriel" name="proprietaire3_courriel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_signature">Signature autorisée :</label>
                        <input type="text" id="proprietaire3_signature" name="proprietaire3_signature" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_date">Date :</label>
                        <input type="date" id="proprietaire3_date" name="proprietaire3_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_nom_final">Nom :</label>
                        <input type="text" id="proprietaire3_nom_final" name="proprietaire3_nom_final" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proprietaire3_titre_final">Titre :</label>
                        <input type="text" id="proprietaire3_titre_final" name="proprietaire3_titre_final" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Autorisation -->
            <div class="section-header">Autorisation</div>
            <p>Par la présente, j’autorise IMMO-SOLUTIONS INC. ou son mandataire à vérifier toutes informations permettant d’évaluer la satisfaction de notre clientèle, la solvabilité auprès de notre institution bancaire ou toute autre compagnie de crédit et/ou fournisseur et transmettre les informations à ses partenaires et collaborateurs de la police d’assurance, la validité de nos licences ainsi que tous renseignements pertinents au dossier. (Ces renseignements demeureront strictement confidentiels et seront utilisés uniquement dans le cadre des activités d’IMMO-SOLUTIONS.)</p>
            <p>Retourner par courriel à : <a href="mailto:entrepreneurs@immonivo.ca">entrepreneurs@immonivo.ca</a></p>
            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
