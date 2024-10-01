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
    $type = $row['type']; // Assurez-vous que 'type' est le nom correct du champ dans votre base de données
    $statut = $row['statut'];

    // Vérifier le type et le statut de l'utilisateur
    if (
        
      
        
        $type !== "Modérateur" &&
        $type !== "super" &&
        $type !== "autres" ||
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
      <title>CRM</title>
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
               </div>
               <div class="sidebar_blog_2">
                  <h4>Administrateur</h4>
                  <ul class="list-unstyled components">
                     <li class="active">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-dashboard yellow_color"></i> <span>Administration</span></a>
                        <ul class="collapse list-unstyled" id="dashboard">
                           <li>
                              <a href="admin.php?page=<?php echo base64_encode('pages/bord/lister2');?>">> <span>Accueil</span></a>
                           </li>
                          <li>
                              <a href="admin.php?page=<?php echo base64_encode('pages/immig/lister_immnew');?>">> <span>Propects</span></a>
                           </li>
                           <li>
                              <a href="admin.php?page=<?php echo base64_encode('pages/immig/lister_imm1');?>">> <span>Utilisateurs</span></a>
                           </li>
                           <li>
                              <a href="topeclat.php" target="_blank">> <span>Comptes</span></a>
                           </li>

                           <li>
                              <a href="pages/bord/formulaire_inscription.php" target="_blank">> <span>Formulaire inscription</span></a>
                           </li>
                           <li>
                              <a href="pages/bord/listerx2">> <span>Assignation</span></a>
                           </li>
                            
                        </ul>
                     </li>
                     

                
                    
                     <li>
                        <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-home red_color"></i> <span>Agences</span></a>
                        <ul class="collapse list-unstyled" id="element">
                       
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/agence');?>">> <span>Agences Autorisées</span></a></li>
                           
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/colaborateur');?>">> <span>Collaborateurs Autorisés</span></a></li>
                        </ul>
                     </li>


                     <li>
                        <a href="#elemento" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users green_color"></i> <span>Candidats</span></a>
                        <ul class="collapse list-unstyled" id="elemento">
                         
                          <li><a href="admin.php?page=<?php echo base64_encode('pages/immig/ajout2');?>">> <span>Enregistrer</span></a></li>
                          <li><a href="pages/bord/liste_candidats.php" target="_blank">> <span>Dossiers Candidats Uri</span></a></li>
                            <li><a href="pages/bord/liste_candidats_ustaff.php" target="_blank">> <span>Dossiers Candidats Ustaff</span></a></li>
                            <li><a href="pages/bord/envoi_email.php" target="_blank">> <span>Envoyer caldidats par email</span></a></li>

                            <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/voir');?>">> <span>Processus et explications</span></a></li>



                            <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/cv222');?>">> <span>Compétences</span></a></li>
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/info');?>">> <span>Match Candidats</span></a></li>
                           
                        </ul>
                     </li>


                     <li>
                        <a href="#elementp" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-university white_color"></i> <span>Entreprise</span></a>
                        <ul class="collapse list-unstyled" id="elementp">
                       
                           

                           <li><a href="admin.php?page=<?php echo base64_encode('pages/immig/pospect_entreprise');?>">> <span>Embauche des entreprises</span></a></li>

                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/pochette');?>">> <span>Sites</span></a></li>
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/import/import');?>">> <span>Importer les fichiers</span></a></li>
                           
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/lister_new');?>">> <span>Enregistrer Contracts de récrutement</span></a></li>

                           <li><a href="https://admin.izishope.com/pages/bord/imprim_contact.php" target="_blank">> <span>Lister Contracts de récrutement</span></a></li>
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/affiche_reservation');?>">> <span>Réservations des candidats Uri</span></a></li>

                          <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/affiche_reservation2');?>">> <span>Réservations des candidats Ustaff</span></a></li>

                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/voir_comm');?>">> <span>Commandes des candidats</span></a></li>

                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/commande_entreprise');?>">> <span>Entreprise marketing</span></a></li>

                           <li><a href="pages/bord/envoi_email2.php" target="_blank">> <span>Envoyer email publicitaire</span></a></li>

                           <li><a href="#">> <span>Employeurs</span></a></li>
                        </ul>
                     </li>


                     <li>
                        <a href="#elementq" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-child yellow_color"></i> <span>Employé</span></a>
                        <ul class="collapse list-unstyled" id="elementq">

              
                       
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/Employé');?>"> <span>Tous Téléphonistes</span></a></li>
                           <li><a href="#">> <span>Embauche Employé</span></a></li>
                           
                        </ul>
                     </li>

                <li>
                        <a href="#elementqu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-child yellow_color"></i> <span>Téléphonistes</span></a>
                        <ul class="collapse list-unstyled" id="elementqu">

                         
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/immig/lister_imm3');?>">> <span>Embauche Téléphonistes</span></a></li>
                           
                           <li><a href="pages/bord/affiche_appel2" target="_blank"> <span>Appels téléphonistes</span></a></li>
                        </ul>
                     </li>




                <li>
                        <a href="#elementqu22" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-child yellow_color"></i> <span>Courtier immobilier</span></a>
                        <ul class="collapse list-unstyled" id="elementqu22">

                      
                       
                           <li><a href="#">> <span>Embauche Téléphonistes</span></a></li>
                           
                           <li><a href="pages/bord/affiche_appel2"> <span>Appels téléphonistes</span></a></li>
                        </ul>
                     </li>





                     <li>
                        <a href="#elementi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-briefcase green_color"></i> <span>Emplois</span></a>
                        <ul class="collapse list-unstyled" id="elementi">
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/offre');?>">> <span>Enregistrer</span></a></li>
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/listeroffre');?>">> <span>Lister les emplois Confirmés</span></a></li>
                           <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/listercandidat');?>">> <span>Candidats</span></a></li>
                           <li><a href="#">> <span>À vérifier </span></a></li>
                        </ul>
                     </li>


                     <li>
                        <a href="#appps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-usd red_color"></i> <span>Comptabilité</span></a>
                        <ul class="collapse list-unstyled" id="appps">
                           <li><a href="#">> <span>Compte des charges</span></a></li>
                           <li><a href="#">> <span>Compte de produits</span></a></li>
                        </ul>
                     </li>


                     <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/prestation');?>"><i class="fa fa-shopping-cart blue1_color"></i> <span>Maquette site avec promo</span></a></li>
   
      
                  <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/lien');?>"><i class="fa fa-pencil white_color"></i> <span>Enregistrer les liens</span></a></li>
                  

                  <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/liens');?>"><i class="fa fa-share-alt white_color"></i> <span>Partager les liens</span></a></li>


 <li><a href="admin.php?page=<?php echo base64_encode('pages/bord/promotion');?>"><i class="fa fa-share-alt white_color"></i> <span>Promotion</span></a></li>

                  </ul>
               </div>
            </nav>
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
                                       <a class="dropdown-item" href="admin.php?page=<?php echo base64_encode('pages/bord/profil');?>">Mon Profil</a>
                                       <a class="dropdown-item" href="admin.php?page=<?php echo base64_encode('pages/bord/profil');?>">Paramètres</a>
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
            include('pages/bord/lister2.php');
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