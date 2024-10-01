<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure FPDF
require('fpdf/fpdf.php');

// Fonction pour générer le CV en PDF
function generatePDF($candidate) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    $pdf->Cell(0, 10, 'Curriculum Vitae', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informations personnelles', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nom: ' . ($candidate['nom'] ?? 'Non spécifié'), 0, 1);
    $pdf->Cell(0, 10, 'Prénom: ' . ($candidate['prenom'] ?? 'Non spécifié'), 0, 1);
    $pdf->Cell(0, 10, 'Profession: ' . ($candidate['prof'] ?? 'Non spécifiée'), 0, 1);
    
    $pdfPath = 'cv_' . ($candidate['nom'] ?? 'inconnu') . '_' . ($candidate['prenom'] ?? 'inconnu') . '.pdf';
    $pdf->Output('F', $pdfPath);
    return $pdfPath;
}

// Récupérer les données envoyées
$recipients = isset($_POST['recipients']) ? $_POST['recipients'] : [];
$candidates = isset($_POST['candidates']) ? $_POST['candidates'] : [];

// Afficher le formulaire HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi d'emails</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        h1 { color: #333; }
        form { margin-top: 20px; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 8px; margin-top: 5px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; margin-top: 10px; }
        input[type="submit"]:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <h1>Envoi d'emails</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($recipients) && !empty($candidates)) {
        $mail = new PHPMailer(true);

        try {
            // Configuration de PHPMailer
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@uricanada.com';
            $mail->Password   = 'Succe$$2024';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SSL;
            $mail->Port       = 465;

            $mail->setFrom('info@uricanada.com', 'URI Canada');

            foreach ($recipients as $recipient) {
                $mail->addBCC($recipient);
            }

            $mail->isHTML(true);
            $mail->Subject = 'Informations sur les candidats';
            
            $body = 'Bonjour,<br><br>Voici les détails des profils candidats potentiels :<br><br>';
            
            foreach ($candidates as $candidate) {
                $body .= "Nom: {$candidate['nom']}<br>";
                $body .= "Prénom: {$candidate['prenom']}<br>";
                $body .= "Profession: {$candidate['prof']}<br>";
                $body .= "<br>----------------------------------------<br>";

                $pdfPath = generatePDF($candidate);
                $mail->addAttachment($pdfPath);
            }

            $body .= "<br>Laurent  Conseiller | Équipe satisfaction client.<br><br>";
            $body .= "1565, boul. de l'Avenir | Laval (Québec) H7S2N5,<br>";
            $body .= "C 514 584 0440 x 101 ou 514 677-7760 T  450-437-7444";

            $mail->Body = $body;

            $mail->send();
            echo '<p style="color: green;">Les emails ont été envoyés avec succès.</p>';

            // Supprimer les fichiers PDF temporaires
            foreach ($candidates as $candidate) {
                $pdfPath = 'cv_' . ($candidate['nom'] ?? 'inconnu') . '_' . ($candidate['prenom'] ?? 'inconnu') . '.pdf';
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            }
        } catch (Exception $e) {
            echo '<p style="color: red;">Une erreur est survenue lors de l\'envoi des emails : ' . $mail->ErrorInfo . '</p>';
        }
    }
    ?>

    <form method="post" action="">
        <label for="recipients">Adresses e-mail des destinataires (séparées par des virgules) :</label>
        <input type="text" id="recipients" name="recipients" required>

        <label for="candidate_name">Nom du candidat :</label>
        <input type="text" id="candidate_name" name="candidates[0][nom]" required>

        <label for="candidate_firstname">Prénom du candidat :</label>
        <input type="text" id="candidate_firstname" name="candidates[0][prenom]" required>

        <label for="candidate_profession">Profession du candidat :</label>
        <input type="text" id="candidate_profession" name="candidates[0][prof]" required>

        <input type="submit" value="Envoyer les emails">
    </form>
</body>
</html>