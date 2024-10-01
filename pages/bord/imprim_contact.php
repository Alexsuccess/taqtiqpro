<?php
// Configuration de la connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Crée une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Traitement des demandes AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Assurez-vous que l'ID est un entier

    $sql = "SELECT * FROM contrats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun contrat trouvé']);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Récupération des contrats pour l'affichage dans le tableau
$sql = "SELECT * FROM contrats";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contrats</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        .contract-header {
            background-color: white;
            color: rgb(0, 0, 64);
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .section-title {
            color: #007bff;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .contract-body {
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 2px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            max-width: 100px;
        }

        .header .company-info {
            text-align: right;
        }

        .header .company-info h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }

        .header .company-info p {
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="contract-header">
            <img style="width: 10%; height: 10%;" src="logooo.jpg" alt="Company Logo">
            <h1>Liste des Contrats de recrutement de travailleurs internationaux</h1>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom de l'Entreprise</th>

                    <th>SERVICES DE L’AGENCE (compte de l’entreprise)</th>
                    <th>SERVICES DE L’AGENCE (contrats de travail au nom de)</th>




                    <th>Nom et prénom</th>
                  

                    <th>Titre</th>
                    <th>Adresse</th>
                    <th>Numéro de téléphone</th>
                    <th>Numéro de cellulaire</th>
                    <th>Eamil</th>
                    <th>Date de Signature</th>
                    <th>Entreprise</th>
                    <th>Imprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['entreprise_nom'] . "</td>";
                        echo "<td>" . $row['entree1'] . "</td>";
                        echo "<td>" . $row['entree2'] . "</td>";
                        echo "<td>" . $row['noms1'] . "</td>";
                        echo "<td>" . $row['noms2'] . "</td>";
                        echo "<td>" . $row['noms3'] . "</td>";
                        echo "<td>" . $row['noms4'] . "</td>";
                        echo "<td>" . $row['noms5'] . "</td>";
                        echo "<td>" . $row['noms6'] . "</td>";
                        echo "<td>" . $row['date_signature'] . "</td>";
                        echo "<td>" . $row['date_debut'] . "</td>";
                        echo "<td><button class='btn btn-primary print-btn' data-id='" . $row['id'] . "'>Imprimer</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucun contrat trouvé</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Imprimer le Contrat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contrat content will be dynamically inserted here -->
                    <div id="contractContent">
                        <div class="contract-header">
                            <img style="width: 10%; height: 10%;" src="logooo.jpg" alt="Company Logo">
                            <h1>Contrat de recrutement de travailleurs internationaux</h1>
                        </div>
                        <div class="contract-body">
                            <h2 class="section-title">Entreprise</h2>
                            <div class="form-group">
                                <label for="entreprise_nom">Nom de l'Entreprise / Adresse de l'Entreprise / Numéro de Téléphone / Adresse Courriel</label>
                                <input type="text" class="form-control" id="entreprise_nom" name="entreprise_nom" disabled>
                            </div>
                            <div class="form-group">
                                <label for="noms1">Nom et prénom</label>
                                <input type="text" class="form-control" id="noms1" name="noms1" disabled>
                            </div>

                            <div class="form-group">
                                <label for="entree1">SERVICES DE L’AGENCE (compte de l’entreprise)</label>
                                <input type="text" class="form-control" id="entree1" name="entree1" disabled>
                            </div>


                            <div class="form-group">
                                <label for="entree2">SERVICES DE L’AGENCE (contrats de travail au nom de)</label>
                                <input type="text" class="form-control" id="entree2" name="entree2" disabled>
                            </div>




                            <div class="form-group">
                                <label for="noms2">Titre</label>
                                <input type="text" class="form-control" id="noms2" name="noms2" disabled>
                            </div>
                            <div class="form-group">
                                <label for="noms3">Adresse</label>
                                <input type="text" class="form-control" id="noms3" name="noms3" disabled>
                            </div>
                            <div class="form-group">
                                <label for="noms4">Numéro de téléphone</label>
                                <input type="text" class="form-control" id="noms4" name="noms4" disabled>
                            </div>
                            <div class="form-group">
                                <label for="noms5">Numéro de cellulaire</label>
                                <input type="text" class="form-control" id="noms5" name="noms5" disabled>
                            </div>
                            <div class="form-group">
                                <label for="noms6">Email</label>
                                <input type="text" class="form-control" id="noms6" name="noms6" disabled>
                            </div>
                            <div class="form-group">
                                <label for="date_signature">Date de Signature</label>
                                <input type="text" class="form-control" id="date_signature" name="date_signature" disabled>
                            </div>
                            <div class="form-group">
                                <label for="date_debut">Date de Début</label>
                                <input type="text" class="form-control" id="date_debut" name="date_debut" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="generatePDF()">Télécharger le PDF</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.print-btn').on('click', function() {
                var contractId = $(this).data('id');
                $.ajax({
                    url: '', // Laissez vide pour faire appel au même script
                    type: 'POST',
                    dataType: 'json',
                    data: { id: contractId },
                    success: function(response) {
                        if (response.success) {
                            var data = response.data;
                            $('#entreprise_nom').val(data.entreprise_nom);
                            $('#noms1').val(data.noms1);

                            $('#entree1').val(data.entree1);
                            $('#entree2').val(data.entree2);


                            $('#noms2').val(data.noms2);
                            $('#noms3').val(data.noms3);
                            $('#noms4').val(data.noms4);
                            $('#noms5').val(data.noms5);
                            $('#noms6').val(data.noms6);
                            $('#date_signature').val(data.date_signature);
                            $('#date_debut').val(data.date_debut);
                            $('#printModal').modal('show');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Erreur lors de la récupération des détails du contrat.');
                    }
                });
            });
        });



        function generatePDF() {
    console.log('Génération du PDF en cours...');
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Rest of the code...
            // Add the header
            doc.setFontSize(16);
            doc.text('Contrat de recrutement de travailleurs internationaux', 10, 10);

            // Add the content from the modal
            doc.setFontSize(12);
            doc.text('Nom de l\'Entreprise: ' + $('#entreprise_nom').val(), 10, 20);
            doc.text('Noms1: ' + $('#noms1').val(), 10, 30);
            doc.text('Entree1: ' + $('#entree1').val(), 10, 40);
            doc.text('Entree2: ' + $('#entree2').val(), 10, 50);
            doc.text('Noms2: ' + $('#noms2').val(), 10, 60);
            doc.text('Noms3: ' + $('#noms3').val(), 10, 70);
            doc.text('Noms4: ' + $('#noms4').val(), 10, 80);
            doc.text('Noms5: ' + $('#noms5').val(), 10, 90);
            doc.text('Noms6: ' + $('#noms6').val(), 10, 100);
            doc.text('Date de Signature: ' + $('#date_signature').val(), 10, 110);
            doc.text('Entreprise: ' + $('#date_debut').val(), 10, 120);

            // Save the PDF
            doc.save('contrat.pdf');
}

    </script>
</body>
</html>
