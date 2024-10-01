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
            z-employe: 1;
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
               <h2>Employer</h2>
            </div>
         </div>
      </div>
      <div class="row column1">
                 <div class="col-md-6 col-lg-3">
            <a href="employe.php?page=<?php echo base64_encode('pages/immig/ajout');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-male yellow_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Enroulement</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>
                  <div class="col-md-6 col-lg-3">
          
            <a href="#" data-target="ajout200">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-users" style="color: black;"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">G. Candidats</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout20">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-bullhorn blue1_color"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Prospections</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout30">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-phone green_color"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Ap Candidats</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout40">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-bell" style="color: cyan;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">RDV</p>
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
                        <i class="fa fa-folder-open" style="color: black;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Doss Candit</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout50">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-folder-open" style="color: purple;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Dos Perso</p>
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
             <div class="col-md-6 col-lg-3">
              <a href="#" data-target="ajout501">
            
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-eye" style="color: yellow;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Lister</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>
          <div class="col-md-6 col-lg-3">
            <a href="#" data-target="ajout502">
           
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-gift" style="color: green;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Candidats Assignés</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>

                   <div class="col-md-6 col-lg-3">
                    <a href="#" data-target="ajout503">
            
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-database" style="color: red;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Données</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>

                     <div class="col-md-6 col-lg-3">
                      <a href="#" data-target="ajout504">
           
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-file-pdf-o" style="color: purple;"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Fichers2</p>
                     </div>
                  </div>
               </div>
            </a>
         </div>

           <div class="col-md-6 col-lg-3">
         <a href="employe.php?page=<?php echo base64_encode('pages/bord/client');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-hdd-o blue1_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Vos clients</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
         </a>
         </div>

                 <div class="col-md-6 col-lg-3">
                  <a href="#" data-target="ajout50411">
            
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-male yellow_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Enrouler une Entreprise</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>


         <div class="col-md-6 col-lg-3">
          <a href="#" data-target="ajout5041">
              <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-university" style="color: black;"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Compétences Candidats</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
            </a>
         </div>



                  <div class="col-md-6 col-lg-3">
            <a href="employe.php?page=<?php echo base64_encode('pages/immig/lister61');?>">
               <div class="full counter_section margin_bottom_30">
                  <div class="couter_icon">
                     <div>
                        <i class="fa fa-male green_color"></i>
                     </div>
                  </div>
                  <div class="counter_no">
                     <div>
                        <p class="total_no">Vos Candidats</p>
                        <p class="head_couter"></p>
                     </div>
                  </div>
               </div>
            </a>
         </div>

          </div>

  <div class="row column1">
         <div class="col-md-6 col-lg-3">
         <a href="employe.php?page=<?php echo base64_encode('pages/immig/ajout2');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-book blue1_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">CV Candidats</p>
                     <p class="head_couter"></p>
                  </div>
               </div>
            </div>
         </a>
         </div>


         <div class="col-md-6 col-lg-3">
         <a href="employe.php?page=<?php echo base64_encode('pages/bord/campagne');?>">
            <div class="full counter_section margin_bottom_30">
               <div class="couter_icon">
                  <div>
                     <i class="fa fa-file-word-o blue1_color"></i>
                  </div>
               </div>
               <div class="counter_no">
                  <div>
                     <p class="total_no">Fiche employé</p>
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
     "ajout50411": "employe.php?page=<?php echo base64_encode('pages/immig/ajout9');?>",
     "ajout5041": "employe.php?page=<?php echo base64_encode('pages/immig/lister_imm333');?>",
      "ajout504": "employe.php?page=<?php echo base64_encode('pages/bord/lister_reponsesx');?>",
      "ajout200": "employe.php?page=<?php echo base64_encode('pages/bord/tele');?>",
      "ajout503": "employe.php?page=<?php echo base64_encode('pages/bord/lister_reponses');?>",
        "ajout20": "employe.php?page=<?php echo base64_encode('pages/immig/ajout20');?>",
        "ajout30": "employe.php?page=<?php echo base64_encode('pages/immig/ajout30');?>",
        "ajout40": "employe.php?page=<?php echo base64_encode('pages/immig/ajout40');?>",
        "ajout50": "employe.php?page=<?php echo base64_encode('pages/immig/ajout50');?>",
        "ajout5": "employe.php?page=<?php echo base64_encode('pages/bord/listertt');?>",
        "ajout501": "employe.php?page=<?php echo base64_encode('pages/immig/ajoutappel');?>",
        "ajout502": "employe.php?page=<?php echo base64_encode('pages/bord/listerx22');?>",
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
