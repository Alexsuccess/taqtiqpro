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
        
      
        

        $type !== "Entreprise" &&
        $type !== "Prestataire" &&
        $type !== "Marketing" ||
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


    <html lang="fr">
    <!--begin::Head-->

    <head>

        <title>Entreprise - IMMONIVO</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:site_name" content="IMMONIVO ENTREPRISE" />
        <link rel="shortcut icon" href="images/fevicon.png" />
        <!--begin::Fonts(mandatory for all pages)-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
        <script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
            if (window.top != window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
    </head>
    <!--end::Head-->
    <!--begin::Body-->

    <body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
        data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
        <!--begin::Theme mode setup on page load-->
        <script>
            var defaultThemeMode = "light";
            var themeMode;
            if (document.documentElement) {
                if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode =
                        document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if (localStorage.getItem("data-bs-theme") !== null) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                        "dark" :
                        "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
        <!--end::Theme mode setup on page load-->
        <!--begin::App-->
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <!--begin::Page-->
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
                <!--begin::Header-->
                <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                    <!--begin::Header container-->
                    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                        <!--begin::Sidebar mobile toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                                <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
                            </div>
                        </div>
                        <!--end::Sidebar mobile toggle-->
                        <!--begin::Mobile logo-->
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="#" class="d-lg-none">
                                <img alt="Logo" src="images/logo/logo.png" class="h-30px" />
                            </a>
                        </div>
                        <!--end::Mobile logo-->
                        <!--begin::Header wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
                            <!--begin::Menu wrapper-->
                            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                                <!--begin::Menu-->
                                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-title"></span>
                                        <span class="menu-arrow d-lg-none"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px"></div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                        <!--begin::Title-->
                                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                            Tableau de Bord
                                        </h1>
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Menu wrapper-->
                            <!--begin::Navbar-->
                            <div class="app-navbar flex-shrink-0">
                                <!--begin::Search-->
                                <div class="app-navbar-item align-items-stretch ms-1 ms-md-4">
                                    <!--begin::Search-->
                                    <div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false"
                                        data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                                        <!--begin::Search toggle-->
                                        <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                                            <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px">
                                                <i class="ki-outline ki-magnifier fs-2"></i>
                                            </div>
                                        </div>
                                        <!--end::Search toggle-->
                                        <!--begin::Menu-->
                                        <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                                            <!--begin::Wrapper-->
                                            <div data-kt-search-element="wrapper">
                                                <!--begin::Form-->
                                                <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Input-->
                                                    <input type="text" class="search-input form-control form-control-flush ps-10" name="search" value placeholder="Rechercher..." data-kt-search-element="input" />
                                                    <!--end::Input-->
                                                    <!--begin::Spinner-->
                                                    <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
														<span
															class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                                                    </span>
                                                    <!--end::Spinner-->
                                                    <!--begin::Reset-->
                                                    <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
														<i
															class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
													</span>
                                                    <!--end::Reset-->
                                                </form>
                                                <!--end::Form-->
                                                <!--begin::Separator-->
                                                <div class="separator border-gray-200 mb-6"></div>
                                                <!--end::Separator-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--end::Search-->
                                <!--begin::Activities-->
                                <div class="app-navbar-item ms-1 ms-md-4">
                                    <!--begin::Drawer toggle-->
                                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" id="kt_activities_toggle">
                                        <i class="ki-outline ki-messages fs-2"></i>
                                    </div>
                                    <!--end::Drawer toggle-->
                                </div>
                                <!--end::Activities-->
                                <!--begin::Notifications-->
                                <div class="app-navbar-item ms-1 ms-md-4">
                                    <!--begin::Menu- wrapper-->
                                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
                                        <i class="ki-outline ki-notification-status fs-2"></i>
                                    </div>

                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Notifications-->

                                <!--begin::Theme mode-->
                                <div class="app-navbar-item ms-1 ms-md-4">
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
                                        <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                                    </a>
                                    <!--begin::Menu toggle-->
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                                <span class="menu-icon" data-kt-element="icon">
													<i class="ki-outline ki-night-day fs-2"></i>
												</span>
                                                <span class="menu-title">Blanc</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
													<i class="ki-outline ki-moon fs-2"></i>
												</span>
                                                <span class="menu-title">Noir</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                                <span class="menu-icon" data-kt-element="icon">
													<i class="ki-outline ki-screen fs-2"></i>
												</span>
                                                <span class="menu-title">Système</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Theme mode-->
                                <!--begin::User menu-->
                                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                                    <!--begin::Menu wrapper-->
                                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <img src="uploads/<?php echo $row['profile_pic']; ?>" class="rounded-3" alt="user" />
                                    </div>
                                    <!--begin::User account menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content d-flex align-items-center px-3">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt="Logo" src="uploads/<?php echo $row['profile_pic']; ?>" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Username-->
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">
                                                        <?php echo $nom . " " . $prenom; ?>
                                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                                    </div>
                                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                                        <?php echo $email; ?>
                                                    </a>
                                                </div>
                                                <!--end::Username-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="entreprise.php?page=<?php echo base64_encode('pages/bord/profil');?>" class="menu-link px-5">Mon Profil</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5 my-1">
                                            <a href="entreprise.php?page=<?php echo base64_encode('pages/bord/profil');?>" class="menu-link px-5">Paramètres</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="acceuil.php" class="menu-link px-5">Déconnexion</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::User account menu-->
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::User menu-->
                                <!--begin::Header menu toggle-->
                                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                                        <i class="ki-outline ki-element-4 fs-1"></i>
                                    </div>
                                </div>
                                <!--end::Header menu toggle-->
                                <!--begin::Aside toggle-->
                                <!--end::Header menu toggle-->
                            </div>
                            <!--end::Navbar-->
                        </div>
                        <!--end::Header wrapper-->
                    </div>
                    <!--end::Header container-->
                </div>
                <!--end::Header-->
                <!--begin::Wrapper-->
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <!--begin::Sidebar-->
                    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                        <!--begin::Logo-->
                        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                            <!--begin::Logo image-->
                            <a href="#">
                                <img alt="Logo" src="images/logo/logo.png" class="h-25px app-sidebar-logo-default theme-light-show" />
                                <img alt="Logo" src="images/logo/logo.png" class="h-25px app-sidebar-logo-default theme-dark-show" />
                                <img alt="Logo" src="images/logo/logo.png" class="h-20px app-sidebar-logo-minimize" />
                            </a>
                            <!--end::Logo image-->
                            <!--begin::Sidebar toggle-->
                            <!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") { 
                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
                            <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active"
                                data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                                <i class="ki-outline ki-black-left-line fs-3 rotate-180"></i>
                            </div>
                            <!--end::Sidebar toggle-->
                        </div>
                        <!--end::Logo-->

                        <!--begin::sidebar menu-->
                        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                            <!--begin::Menu wrapper-->
                            <div class="aside-user d-flex align-items-sm-center justify-content-center py-5 ps-6">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px">
                                    <img src="uploads/<?php echo $row['profile_pic']; ?>" alt />
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Wrapper-->
                                <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                                    <!--begin::Section-->
                                    <div class="d-flex">
                                        <!--begin::Info-->
                                        <div class="flex-grow-1 me-2">
                                            <!--begin::Username-->
                                            <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold">
                                                <?php echo $nom . " " . $prenom; ?>
                                            </a>
                                            <!--end::Username-->

                                            <!--begin::Description-->
                                            <!-- <span class="text-gray-600 fw-semibold d-block fs-8 mb-1">Python
												Dev</span> -->
                                            <!--end::Description-->

                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center text-success fs-9">
                                                <span class="bullet bullet-dot bg-success me-1"></span>online
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::User menu-->

                                        <!--end::User menu-->
                                    </div>

                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>

                            <div class="app-sidebar-footer flex-column-auto pt-3 pb-2 px-6">
                                <span class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
                                <span class="btn-label">COMPTE ENTREPRISE</span>
                                <i class="ki-outline ki-document btn-icon fs-2 m-0"></i>
                                </span>
                            </div>

                            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                                <!--begin::Scroll wrapper-->
                                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                                    data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                                    <!--begin::Menu-->

                                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                                        <!--begin:Menu item-->

                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <!--begin:Menu link-->

                                            <a class="menu-link active" href="entreprise.php?page=<?php echo base64_encode('pages/bord/lister23');?>">
                                                <span class="menu-icon">
													<i class="ki-outline ki-element-11 fs-2"></i>
												</span>
                                                <span class="menu-title">Tableau de bord</span>
                                            </a>

                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item ">
                                            <!--begin:Menu content-->

                                            <!--end:Menu content-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <span class="menu-link ">
												<span class="menu-icon ">
													<i class="ki-outline ki-profile-user fs-2 "></i>
												</span>
                                            <span class="menu-title ">Candidats</span>
                                            <span class="menu-arrow "></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion ">
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/immig/lister_imm');?>">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Prospects</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/bord/cv2227');?>">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Compétences</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="pages/bord/presenter_candidat">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Candidatures</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <span class="menu-link ">
												<span class="menu-icon ">
													<i class="ki-outline ki-briefcase fs-2 "></i>
												</span>
                                            <span class="menu-title ">Emploi</span>
                                            <span class="menu-arrow "></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion ">
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/bord/offre');?>">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Enregistrer</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/bord/listeroffre');?>">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Liste des offres</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item ">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/bord/listercandidat');?>">
                                                        <span class="menu-bullet ">
															<span class="bullet bullet-dot "></span>
                                                        </span>
                                                        <span class="menu-title ">Candidats</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <a class="menu-link " href="#">
                                                <span class="menu-icon ">
													<i class="ki-outline ki-messages fs-2 "></i>
												</span>
                                                <span class="menu-title ">Messages</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <a class="menu-link " href="entreprise.php?page=<?php echo base64_encode('pages/bord/produitss');?>">
                                                <span class="menu-icon ">
													<i class="ki-outline ki-handcart fs-2 "></i>
												</span>
                                                <span class="menu-title ">Marketplace</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'} " data-kt-menu-placement="right-start " class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention ">
                                            <!--begin:Menu link-->
                                            <a class="menu-link " href="#">
                                                <span class="menu-icon ">
													<i class="ki-outline ki-map fs-2 "></i>
												</span>
                                                <span class="menu-title ">Localisation</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <a class="menu-link " href="#">
                                                <span class="menu-icon ">
													<i class="ki-outline ki-abstract-26 fs-2 "></i>
												</span>
                                                <span class="menu-title ">Chartes</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click " class="menu-item menu-accordion ">
                                            <!--begin:Menu link-->
                                            <a class="menu-link " href="#">
                                                <span class="menu-icon ">
													<i class="ki-outline ki-setting-2 fs-2 "></i>
												</span>
                                                <span class="menu-title ">Paramètres</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>

                                        <!--end:Menu item-->
                                    </div>

                                    <!--end::Menu-->
                                </div>
                                <!--end::Scroll wrapper-->
                            </div>

                            <!--end::Menu wrapper-->
                        </div>

                        <!--end::sidebar menu-->
                    </div>
                    <!--end::Sidebar-->

                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid " id="kt_app_main ">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid ">
                            <!--begin::Toolbar-->

                            <!--end::Toolbar-->
                            <!--begin::Content-->
                            <div id="kt_app_content " class="app-content flex-column-fluid ">
                                <!--begin::Content container-->
                                <div id="kt_app_content_container " class="app-container container-fluid ">


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
						include('pages/bord/lister23.php');
						}
						  ?>
                                </div>
                                <!--end::Content container-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->
                        <!--begin::Footer-->
                        <div id="kt_app_footer " class="app-footer ">
                            <!--begin::Footer container-->
                            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 ">
                                <!--begin::Copyright-->
                                <div class="text-gray-900 order-2 order-md-1 ">
                                    <span class="text-muted fw-semibold me-1 ">2024&copy;</span>
                                    <a href="# " target="_blank " class="text-gray-800 text-hover-primary ">IMMONIVO</a>
                                </div>
                                <!--end::Copyright-->
                            </div>
                            <!--end::Footer container-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::App-->

        <!--end::Drawers-->
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop " class="scrolltop " data-kt-scrolltop="true ">
            <i class="ki-outline ki-arrow-up "></i>
        </div>
        <!--end::Scrolltop-->

        <!--begin::Javascript-->
        <script>
            var hostUrl = "assets/ ";
        </script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="assets/plugins/global/plugins.bundle.js "></script>
        <script src="assets/js/scripts.bundle.js "></script>

        <!--end::Vendors Javascript-->

        <!--end::Javascript-->
    </body>
    <!--end::Body-->

    </html>