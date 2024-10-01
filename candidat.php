<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si la session n'est pas active
    header("Location: acceuil.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['id'];

// Connexion à la base de données
$servername = "4w0vau.myd.infomaniak.com";
$username = "4w0vau_dreamize";
$password = "Pidou2016";
$dbname = "4w0vau_dreamize";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparer la requête SQL pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM userss WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $profile_pic = $row['profile_pic'];
    $prenom = $row['prenom'];
    $type = $row['compte']; // Assurez-vous que 'type' est le nom correct du champ dans votre base de données
    $statut = $row['statut'];

    // Vérifier le type et le statut de l'utilisateur
    if (
        $type !== "Prenium" &&
        $type !== "Client" &&
        $type !== "Candidat" &&
        $type !== "Prestataire" ||
        $statut != 1 // comparaison non stricte si $statut peut être une chaîne
    ) {
        // Rediriger vers la page de connexion si le type n'est pas parmi ceux spécifiés ou le statut n'est pas 1
        header("Location: acceuil.php");
        exit();
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas trouvé dans la base de données
    header("Location: acceuil.php");
    exit();
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>InternationalStation</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="images/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <style type="text/css">
.user_img {
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 10px; /* Ajustez la marge au besoin */
}

.user_info h6,
.user_info p {
    margin: 0; /* Supprime les marges par défaut */
}


        </style>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
          <nav id="sidebar">
   <div class="sidebar_blog_1">
      <div class="sidebar-header">
         <div class="logo_section">
            <a href="#"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
         </div>
      </div>
      <div class="sidebar_user_info">
         <div class="icon_setting"></div>
         <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive" src="uploads/<?php echo $row['profile_pic']; ?>" alt="#" /></div>
            <div class="user_info">
               <h6><?php echo $nom . " " . $prenom; ?></h6>
               <p><span class="online_animation"></span> Online</p>
            </div>
         </div>
      </div>
      <div class="sidebar_blog_2">
         <h4>Compte Candidat</h4>
         <ul class="list-unstyled components">
            <li class="active">
               <!-- Tableau -->
               <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-dashboard yellow_color"></i> <span>Tableau</span></a>
               <ul class="collapse list-unstyled" id="dashboard">
                  <li>
                     <a href="candidat.php?page=<?php echo base64_encode('pages/bord/lister');?>">> <span>Tableau</span></a>
                  </li>
               </ul>
            </li>
            <li><a href="#"><i class="fa fa-group blue1_color"></i> <span>Prestataires</span></a></li>
            <!-- Compétences -->
            <li><a href="candidat.php?page=<?php echo base64_encode('pages/immig/ajout22');?>"><i class="fa fa-graduation-cap orange_color"></i> <span>Complétez votre dossier</span></a></li>
            <!-- Emplois -->
           

            
           
            <li>
               <!-- Messages -->
              <a href="pages/bord/message.php" class="dropdown-toggle" target="_black">
               <i class="fa fa-comments-o red_color"></i> <span>Messages</span>
              </a>

             
            </li>
 <li><a href="candidat.php?page=<?php echo base64_encode('pages/bord/lister_offre');?>"><i class="fa fa-briefcase green_color"></i> <span>Emplois</span></a></li>

 <li><a href="candidat.php?page=<?php echo base64_encode('pages/bord/etape_candidat');?>"><i class="fa fa-briefcase green_color"></i> <span>Evolution du dossier</span></a></li>
         </ul>

      </div>
   </div>
</nav>

<!-- Modal pour le code d'accès -->
<div id="accessModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Code d'accès requis</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <p>Veuillez entrer le code d'accès pour accéder à cette page :</p>
            <input type="password" id="accessCode" class="form-control" placeholder="Entrez le code d'accès">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="checkAccess()">Valider</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
         </div>
      </div>
   </div>
</div>

<!-- Script JavaScript pour vérifier le code d'accès -->
<script>
   // Vérifier le code d'accès
   function checkAccess() {
      var accessCode = document.getElementById("accessCode").value;
      // Comparer le code d'accès saisi avec le code autorisé
      // Ici, vous devez mettre votre logique de vérification du code d'accès

      // Par exemple, si le code est correct, rediriger vers la page
      var correctCode = "votre_code_d'accès";
      if (accessCode === correctCode) {
         var page = document.getElementById("accessModal").getAttribute("data-page");
         window.location.href = page;
      } else {
         alert("Code d'access incorrect. Veuillez réessayer.");
      }
   }
</script>










            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href="#"><img class="img-responsive" src="images/logo/logo.png" alt="#" /></a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                                 <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                 <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a></li>
                              </ul>
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><span class="name_user"><?php echo $nom . " " . $prenom; ?></span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="candidat.php?page=<?php echo base64_encode('pages/bord/profil');?>">Mon Profil</a>
                                       <a class="dropdown-item" href="candidat.php?page=<?php echo base64_encode('pages/bord/profil');?>">Paramètres</a>
                                       <a class="dropdown-item" href="acceuil.php"><span>Déconnexion</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>


















               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">


<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                
            




                        <div class="alert alert-block alert-success alertaddregionok" style="display:none">
                            bravo enregistrement effectué avec success !
                        </div>
                        <div class="alert alert-block alert-danger alertaddregionko" style="display:none">
                            redondence veuillez vérifier vos informations !
                        </div>
                        <div class="alert alert-block alert-success alertaddbon" style="display:none">
                            Enregistrement ok !
                        </div>
                        <div class="alert alert-block alert-danger alertaddprdtmauv" style="display:none">
                            Cette d&eacute;signation existe d&eacute;j&agrave; !
                        </div>
                        <div class="alert alert-block alert-success alerteditbon" style="display:none">
                            Mise a jour OK !
                        </div>
                        <div class="alert alert-block alert-danger alertaddcatmauv" style="display:none">
                            Ce code ou ce libelle existe d&eacute;j&agrave; !
                        </div>
                        <div class="alert alert-block alert-warning alertidentinco" style="display:none">
                            Identifiants Incorrectes !
                        </div>
                        <div class="alert alert-block alert-danger alertpageintrouv" style="display:none">
                            Pages Introuvable !
                        </div>
                        <div class="alert alert-block alert-danger alertdejacon" style="display:none">
                            Connecte !
                        </div>
                        <div class="alert alert-block alert-danger alertaddregion" style="display:none">
                            Objet non existant en session !
                        </div>
                        <div class="alert alert-block alert-success alertmodifbon" style="display:none">
                            Mise a jour OK !
                        </div>
                        <div class="alert alert-block alert-danger alertaddnull" style="display:none">
                            Le formulaire est vide !
                        </div>
                        <div class="alert alert-block alert-success alerttranfbon" style="display:none">
                            Actions transfn&eacute;r&eacute;es avec succes !
                        </div>
                        <div class="alert alert-block alert-danger alertformvide" style="display:none">
                            Le formulaire est vide !
                        </div>
                      




           <?php 
            if (isset($_REQUEST["page"]))
            {
    
            $page= base64_decode($_REQUEST["page"]). ".php";
            if(file_exists($page))
            {
            include($page);
            }
            else
            {
                echo"page pas disponible sur le serveur";
            }
            } 
            else
            {
            include('pages/bord/message_acceuil.php');
            }
              ?>
            <!-- Invoice Example -->










         </div>
        </div>
    </section>





               </div>
               <!-- end dashboard inner -->
















            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <script src="js/chart_custom_style1.js"></script>
   </body>
</html>