<?php
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accessCode'])) {
    $accessCode = $_POST['accessCode'];

    $sql = "SELECT help2 FROM userss WHERE help2 = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $accessCode);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = "success";
        } else {
            $response = "failure";
        }

        $stmt->close();
    } else {
        $response = "error: " . $conn->error;
    }

    $conn->close();

    if ($response === "success" && isset($_POST['currentLink'])) {
        header('Location: ' . $_POST['currentLink']);
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Immigration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-candidat: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
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
        .error {
            color: red;
            margin-top: 10px;
            display: <?php echo ($response === 'failure') ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
<!-- start topbar -->
<!-- dashboard inner -->
<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>Immigration</h2>
            </div>
         </div>
      </div>
      <div class="row column1">
                 <div class="col-md-6 col-lg-3">
            <a href="candidat.php?page=<?php echo base64_encode('pages/immig/ajout');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-male yellow_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Candidat</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>
                  <div class="col-md-6 col-lg-3">
            <a href="candidat.php?page=<?php echo base64_encode('pages/immig/ajout9');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-university" style="color: black;"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Entreprise</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout2">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-book blue1_color"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Education</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout3">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-plane green_color"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Motif</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout4">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-home" style="color: cyan;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Logement</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout5">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-file-pdf-o" style="color: silver;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Fichiers</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="paiement">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-money" style="color: purple;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Paiement</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
             <div class="col-md-6 col-lg-3">
            <a href="pages/bord/message.php">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-comments-o red_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Messages</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
         </a>
         </div>
      </div>
   </div>

<!-- Modal pour le code d'accès -->
<div id="accessCodeModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Veuillez entrer votre code d'accès :</p>
    <form method="POST" action="">
      <input type="password" id="accessCode" name="accessCode" placeholder="Code d'accès" required>
      <input type="hidden" id="currentLink" name="currentLink" value="">
      <button type="submit">Soumettre</button>
      <p class="error" id="errorMsg">Code d'accès incorrect. Veuillez réessayer.</p>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById("accessCodeModal");
    var span = document.getElementsByClassName("close")[0];
    var currentLinkInput = document.getElementById("currentLink");

    var secureLinks = {
        "ajout2": "candidat.php?page=<?php echo base64_encode('pages/immig/ajout2');?>",
        "ajout3": "candidat.php?page=<?php echo base64_encode('pages/immig/ajout3');?>",
        "ajout4": "candidat.php?page=<?php echo base64_encode('pages/immig/ajout4');?>",
        "ajout5": "candidat.php?page=<?php echo base64_encode('pages/immig/ajout5');?>",
        "paiement": "#"
    };

    function openModal(event, link) {
        event.preventDefault();
        currentLinkInput.value = link;
        modal.style.display = "block";
    }

    document.querySelectorAll("a[data-target]").forEach(link => {
        link.onclick = function(event) {
            var target = link.getAttribute("data-target");
            openModal(event, secureLinks[target]);
        };
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>

<div class="container-fluid">
  <div class="footer">
    <p>Copyright © 2018 Designed by MBA. All rights reserved.<br><br>
       Distributed By: <a href="http://achile.universbinaire.com/">MBA</a>
    </p>
  </div>
</div>
</div>
</body>
</html>
