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

$sql = "SELECT *
        FROM candidats where type_candidat = 'Ustaff' ";
$resulti = $conn->query($sql);

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
                $checkUserStmt = $conn->prepare("SELECT COUNT(*) FROM candidats WHERE  type_candidat = 'Ustaff' and id = ?");
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

body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    margin-top: 50px;
    width: 90%;
    max-width: 1200px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #e0e0e0;
}

.table th, .table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
}

.table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 3px solid #0056b3;
}

.table td {
    background-color: #fff;
    border-bottom: 1px solid #e0e0e0;
}

.table-hover tbody tr:hover {
    background-color: #f1f1f1;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.table td button.btn-info {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.table td button.btn-info:hover {
    background-color: #0056b3;
    cursor: pointer;
}

.alert {
    margin-top: 20px;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-size: 18px;
}

.alert-orange {
    background-color: #ff9800;
    color: white;
}

.alert-red {
    background-color: #f44336;
    color: white;
}

.alert-blue {
    background-color: #2196f3;
    color: white;
}

.header, .footer {
    background-color: #343a40;
    color: white;
    padding: 20px 0;
    text-align: center;
    text-transform: uppercase;
    font-size: 16px;
    letter-spacing: 1px;
}

.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    box-shadow: 0px -4px 8px rgba(0, 0, 0, 0.1);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #ffffff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 60%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

select.form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 8px;
    width: 100%;
    box-sizing: border-box;
}

button.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    width: 100%;
}

button.btn-primary:hover {
    background-color: #0056b3;
    cursor: pointer;
}

        }
    </style>
</head>
<body style="border-style: double; background-image: url(titi.png);">
    <div style="width: 150%; background-color: white;" class="container">
        <h1>Dossiers des candidats de Ustaff</h1>
        <form id="mainForm">
            <table style="width: 150%; margin-left: -47%; background-color: white;" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>ID</th>
                        <th>Catégories</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Sexe</th>
                        <th>Pays</th>
                        <th>Code régional</th>
                        <th>Ville</th>
                        <th>Expérience</th>
                        <th>Spécialité</th>
                        <th>Langue écrite</th>
                        <th>Langue parlée</th>
                        <th>Permi de conduire</th>
                        <th>Enfants</th>
                        




                       
                        <th>Détails</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resulti->num_rows > 0) {
                        while ($rowi = $resulti->fetch_assoc()) {
$userCode = htmlspecialchars($rowi['code'] ?? '');
echo "<tr>";
echo "<td class='confier-cell'>";
echo "<input type='checkbox' class='confier-checkbox' data-user-id='" . $rowi['id'] . "' name='confier[]'>";
echo "</td>";
echo "<td>" . htmlspecialchars($rowi['id'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['categorie'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['nom'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['prenom'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['email'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['prof'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['sexe'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['pays'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['region'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['city'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['exp'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['specail'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['ecrit'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['parle'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['permi'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($rowi['enfant'] ?? '') . "</td>";
echo "<td><button class='btn btn-info' data-user-code='" . htmlspecialchars($userCode) . "' onclick='voirPlus(\"" . htmlspecialchars($userCode) . "\")'>Détails</button>


<button style='background-color : red;' class='btn btn-info' data-user-code='" . htmlspecialchars($userCode) . "' onclick='voirPlus4(\"" . htmlspecialchars($userCode) . "\")'>Modifier</button></td>";
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
