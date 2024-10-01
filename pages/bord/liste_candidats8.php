<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

$userId = $_SESSION['id'];

$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.nom, c.prenom, c.email, c.sexe, c.pays, c.code, c.id, c.prof,
        d.diplome, d.passeport, d.certificat_naissance, d.certificat_scolarite, d.mandat_representation
        FROM candidats c
        LEFT JOIN documentss d ON c.code = d.code left join utilisateurs_destinataires as rr on rr.id_utilisateur= c.id where rr.id_destinataire = $userId AND c.code IS NOT NULL";
$result = $conn->query($sql);

$typesComptes = ['client', 'prestataire', 'candidat', 'Entreprise', 'Agence', 'Agent'];

$sqlDestinataires = "SELECT id, nom, prenom FROM userss WHERE compte IN ('télévendeur', 'Employé', 'Entreprise', 'prestataire', 'Agence', 'Agent')";
$resultDestinataires = $conn->query($sqlDestinataires);
$destinataires = [];
if ($resultDestinataires->num_rows > 0) {
    while ($row = $resultDestinataires->fetch_assoc()) {
        $destinataires[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['destinataire']) && isset($_POST['utilisateursSelectionnes'])) {
        $destinataire = $_POST['destinataire'];
        $utilisateurs = json_decode($_POST['utilisateursSelectionnes'], true);

        if (!empty($utilisateurs)) {
            $stmt = $conn->prepare("INSERT INTO utilisateurs_destinataires (id_utilisateur, id_destinataire) VALUES (?, ?)");

            foreach ($utilisateurs as $user) {
                // Vérifiez si l'utilisateur existe dans la table candidats
                $checkUserStmt = $conn->prepare("SELECT COUNT(*) FROM candidats WHERE id = ?");
                $checkUserStmt->bind_param("i", $user);
                $checkUserStmt->execute();
                $checkUserStmt->bind_result($userExists);
                $checkUserStmt->fetch();
                $checkUserStmt->close();

                if ($userExists > 0) {
                    // L'utilisateur existe dans la table candidats, on peut l'insérer dans utilisateurs_destinataires
                    $stmt->bind_param("ii", $user, $destinataire);
                    $stmt->execute();
                } else {
                    echo "Erreur : Candidat ID $user n'existe pas.";
                }
            }
            $stmt->close();

            echo "Insertion réussie !";
        } else {
            echo "Erreur : Aucun utilisateur sélectionné.";
        }
    } else {
        echo "Erreur : Données manquantes.";
    }
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>

        .container {
            margin-top: 50px;
            width: 150%;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .alert {
            color: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            text-align: center;
        }
        .alert-orange {
            background-color: orange;
        }
        .alert-red {
            background-color: red;
        }
        .alert-blue {
            background-color: blue;
        }
        .header, .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body style="border-style: double; background-image: url(fonff.jpg);">
    <div style="width: 150%; background-color: white;" class="container">
        <h1>Dossiers des candidat</h1>
        <form id="mainForm">
            <table style="width: 150%; margin-left: -25%; background-color: white;" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sélectionner</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Sexe</th>
                        <th>Pays</th>
                        <th>Alertes</th>
                        <th>Détails</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $missingDocuments = [];
                            if (!$row['diplome']) {
                                $missingDocuments[] = "Diplôme";
                            }
                            if (!$row['passeport']) {
                                $missingDocuments[] = "Passeport";
                            }
                            if (!$row['certificat_naissance']) {
                                $missingDocuments[] = "Certificat de naissance";
                            }
                            if (!$row['certificat_scolarite']) {
                                $missingDocuments[] = "Certificat de scolarité";
                            }
                            if (!$row['mandat_representation']) {
                                $missingDocuments[] = "Mandat de représentation";
                            }
$userCode = htmlspecialchars($row['code'] ?? '');
echo "<tr>";
echo "<td class='confier-cell'>";
echo "<input type='checkbox' class='confier-checkbox' data-user-id='" . $row['id'] . "' name='confier[]'>";
echo "</td>";
echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['prenom'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['prof'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['sexe'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['pays'] ?? '') . "</td>";
echo "<td class='" . (!empty($missingDocuments) ? "red-alert" : "") . "'>";
if (!empty($missingDocuments)) {
    echo "Documents manquants: " . implode(", ", $missingDocuments);
} else {
    echo "Tous les documents sont présents";
}
echo "</td>";
echo "<td><button class='btn btn-info' data-user-code='" . htmlspecialchars($userCode) . "' onclick='voirPlus(\"" . htmlspecialchars($userCode) . "\")'>Détails</button></td>";


echo "<td><button style='background-color : red;' class='btn btn-info' data-user-code='" . htmlspecialchars($userCode) . "' onclick='voirPlus4(\"" . htmlspecialchars($userCode) . "\")'>Modifier</button></td>";
echo "</tr>";

                        }
                    } else {
                        echo "<tr><td colspan='8'>Aucun candidat trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Modal pour confier l'utilisateur -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <h2>Assigner à:</h2>
                <form id="confierForm" method="post">
                    <input type="hidden" id="utilisateursSelectionnes" name="utilisateursSelectionnes">
                    <select name="destinataire" class="form-control">
                        <?php foreach ($destinataires as $destinataire): ?>
                            <option value="<?php echo htmlspecialchars($destinataire['id']); ?>"><?php echo htmlspecialchars($destinataire['nom'] . " " . $destinataire['prenom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" id="submitConfier" class="btn btn-primary">Confier</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true
            });

            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];

            function showModal() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            $('#submitConfier').click(function() {
                var selectedUsers = [];
                $('.confier-checkbox:checked').each(function() {
                    selectedUsers.push($(this).data('user-id'));
                });

                if (selectedUsers.length > 0) {
                    $('#utilisateursSelectionnes').val(JSON.stringify(selectedUsers));
                    $('#confierForm').submit();
                } else {
                    alert("Veuillez sélectionner au moins un utilisateur à confier.");
                }
            });

            $('.confier-checkbox').change(function() {
                if ($('.confier-checkbox:checked').length > 0) {
                    showModal();
                }
            });
        });

            // Fonction pour voir plus de détails
            window.voirPlus = function(code) {
                var url = 'voir_voir_plus.php?code=' + encodeURIComponent(code);
                var newWindow = window.open(url, '_blank', 'width=800,height=600');
                newWindow.focus();
            };

window.voirPlus4 = function(code) {
    var url = 'modifier.php?code=' + encodeURIComponent(code);
    var newWindow = window.open(url, '_blank', 'width=800,height=600');
    newWindow.focus();
};

    </script>
</body>
</html>
