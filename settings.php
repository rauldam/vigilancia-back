<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/************* SEGURIDAD PDO **************/
include('php/includes/Seguridad.php');
include('php/includes/MobileDetect.php');
$seguridad = new Seguridad();
$seguridad->access_page();
$isMobile = MobileDetect::isMobile();
//$red = $_SESSION['red'];
$red = "1";
$idcliente = $seguridad->get_id_cliente();
$iduser = $seguridad->get_id_user();
$cif = $_SESSION['cif'];
$username = $_SESSION['name'];
$email = $_SESSION['email'];

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    //Destruimos la cookie creada;  
	$seguridad->log_out(); // the method to log off
}

require('php/includes/Cliente.php');
$cliente = new Cliente();

$dataCliente = $cliente->get_all_data($idcliente);
$dataUser = array("user" => $seguridad->user, "pw" => $seguridad->user_pw);

if (isset($_POST['data'])) {
    $param = array("razon" => $_POST['razon'],"email" => $_POST['email'],"tlf" => $_POST['tlf'],"movil" => $_POST['movil'],"direccion" => $_POST['direccion'],"poblacion" => $_POST['ciudad'],"cp" => $_POST['cp'],"provincia" => $_POST['provincia'], "idclientes" => $idcliente);
    $resp = $cliente->update_cliente($param); // call the login method
    if($resp[0]){
        header("Refresh:0");
    }else{
        $msj = $resp[1];
    }
}

if (isset($_POST['usarioYcontrasenya'])) {
    $param = array("user" => $_POST['user'],"pw" => $_POST['pw'], "idusers" => $iduser);
    $resp = $cliente->update_user($param); // call the login method
    if($resp[0]){
        header("Refresh:0");
        header("Location:index.php");
    }else{
        $msjD = $resp[1];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>SG - Vigilancia Normativa</title>
    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <?php if ($isMobile): ?>
    <style>
      .sidebar-nav-wrapper { width: 100%; transform: translateX(-100%); }
      .sidebar-nav-wrapper.active { transform: translateX(0); }
      .main-wrapper { margin-left: 0; width: 100%; }
      .header-right { justify-content: flex-end; }
      .icon-card { margin-bottom: 15px; }
      .table-wrapper { overflow-x: auto; }
      .footer { display: none; }
      .breadcrumb-wrapper { display: none; }
    </style>
    <?php endif; ?>
  </head>
  <body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
      <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
        <a href="home.php">
          <button class="btn btn-primary">Vigilancia Normativa</button>
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
                class="collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_1"
              aria-controls="ddmenu_1"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M8.74999 18.3333C12.2376 18.3333 15.1364 15.8128 15.7244 12.4941C15.8448 11.8143 15.2737 11.25 14.5833 11.25H9.99999C9.30966 11.25 8.74999 10.6903 8.74999 10V5.41666C8.74999 4.7263 8.18563 4.15512 7.50586 4.27556C4.18711 4.86357 1.66666 7.76243 1.66666 11.25C1.66666 15.162 4.83797 18.3333 8.74999 18.3333Z" />
                  <path
                    d="M17.0833 10C17.7737 10 18.3432 9.43708 18.2408 8.75433C17.7005 5.14918 14.8508 2.29947 11.2457 1.75912C10.5629 1.6568 10 2.2263 10 2.91665V9.16666C10 9.62691 10.3731 10 10.8333 10H17.0833Z" />
                </svg>
              </span>
              <span class="text">Dashboard</span>
            </a>
            <ul id="ddmenu_1" class="collapse dropdown-nav">
              <li>
                <a href="home.php" class=""> Home </a>
              </li>
            </ul>
          </li>
          <li class="nav-item ">
            <a href="productos.php">
              <span class="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.66666 4.16667C1.66666 3.24619 2.41285 2.5 3.33332 2.5H16.6667C17.5872 2.5 18.3333 3.24619 18.3333 4.16667V9.16667C18.3333 10.0872 17.5872 10.8333 16.6667 10.8333H3.33332C2.41285 10.8333 1.66666 10.0872 1.66666 9.16667V4.16667Z" />
                  <path
                    d="M1.875 13.75C1.875 13.4048 2.15483 13.125 2.5 13.125H17.5C17.8452 13.125 18.125 13.4048 18.125 13.75C18.125 14.0952 17.8452 14.375 17.5 14.375H2.5C2.15483 14.375 1.875 14.0952 1.875 13.75Z" />
                  <path
                    d="M2.5 16.875C2.15483 16.875 1.875 17.1548 1.875 17.5C1.875 17.8452 2.15483 18.125 2.5 18.125H17.5C17.8452 18.125 18.125 17.8452 18.125 17.5C18.125 17.1548 17.8452 16.875 17.5 16.875H2.5Z" />
                </svg>
              </span>
              <span class="text">Productos</span>
            </a>
          </li>
            <li class="nav-item active">
            <a href="settings.php">
              <span class="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.66666 4.16667C1.66666 3.24619 2.41285 2.5 3.33332 2.5H16.6667C17.5872 2.5 18.3333 3.24619 18.3333 4.16667V9.16667C18.3333 10.0872 17.5872 10.8333 16.6667 10.8333H3.33332C2.41285 10.8333 1.66666 10.0872 1.66666 9.16667V4.16667Z" />
                  <path
                    d="M1.875 13.75C1.875 13.4048 2.15483 13.125 2.5 13.125H17.5C17.8452 13.125 18.125 13.4048 18.125 13.75C18.125 14.0952 17.8452 14.375 17.5 14.375H2.5C2.15483 14.375 1.875 14.0952 1.875 13.75Z" />
                  <path
                    d="M2.5 16.875C2.15483 16.875 1.875 17.1548 1.875 17.5C1.875 17.8452 2.15483 18.125 2.5 18.125H17.5C17.8452 18.125 18.125 17.8452 18.125 17.5C18.125 17.1548 17.8452 16.875 17.5 16.875H2.5Z" />
                </svg>
              </span>
              <span class="text active">Perfil</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                    <i class="lni lni-chevron-left me-2"></i> Menu
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        
                        <div>
                          <h6 class="fw-500"><?php echo $username ?></h6>
                          <p><?php echo $cif ?></p>
                        </div>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                    <li>
                      <div class="author-info flex items-center !p-1">
                        
                        <div class="content">
                          <h4 class="text-sm"><?php echo $username ?></h4>
                          <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white" style="font-size: 10px;" href="#"><?php echo $email ?></a>
                        </div>
                      </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="settings.php">
                        <i class="lni lni-user"></i> Ver Perfil
                      </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>?action=log_out"> <i class="lni lni-exit"></i> Cerrar Sesión </a>
                    </li>
                  </ul>
                </div>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Perfil de usuario</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-5">
                <div class="breadcrumb-wrapper">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Perfil
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row">
            <div class="col-lg-5">
              <div class="card-style settings-card-1 mb-30">
                <div class="title mb-30">
                  <h6>Cambiar usuario y contraseña</h6>
                    <p class="danger"><?php echo $msjD ?></p>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="profile-info">
                      <div class="input-style-1">
                        <label>Email</label>
                        <input type="email" name="user" placeholder="" value="<?php echo $dataUser['user'] ?>" />
                      </div>
                      <div class="input-style-1">
                        <label>Password</label>
                        <input type="password" name="pw" value="<?php echo md5($dataUser['pw']) ?>" />
                      </div>
                    </div>
                      <div class="col-12" align="center">
                          <button class="main-btn primary-btn btn-hover" name="usarioYcontrasenya" type="submit">
                            Actualizar usuario o contraseña
                          </button>
                        </div>
                    </form>
                  </div>
                
                </div>
              <!-- end card -->
            <!-- end col -->

            <div class="col-lg-7">
              <div class="card-style settings-card-2 mb-30">
                <div class="title mb-30">
                  <h6>Mis datos</h6>
                    <p class="danger"><?php echo $msj ?></p>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="row">
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Razón Social</label>
                        <input type="text" name="razon" placeholder="Razón Social" value="<?php echo $dataCliente[1][0]['razon'] ?>"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" value="<?php echo $dataCliente[1][0]['email'] ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-6">
                      <div class="input-style-1">
                        <label>Teléfono</label>
                        <input type="text" name="tlf" placeholder="Teléfono" value="<?php echo $dataCliente[1][0]['tlf'] ?>"/>
                      </div>
                    </div>
                      <div class="col-xxl-6">
                      <div class="input-style-1">
                        <label>Móvil</label>
                        <input type="text" name="movil" placeholder="Móvil" value="<?php echo $dataCliente[1][0]['movil'] ?>"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Dirección</label>
                        <input type="text" name="direccion" placeholder="Dirección" value="<?php echo $dataCliente[1][0]['direccion'] ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" placeholder="Ciudad" value="<?php echo $dataCliente[1][0]['poblacion'] ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>Código Postal</label>
                        <input type="text" name="cp" placeholder="Código Postal" value="<?php echo $dataCliente[1][0]['cp'] ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>Provincia</label>
                        <div class="select-position">
                           <input type="text" name="provincia" placeholder="Provincia" value="<?php echo $dataCliente[1][0]['provincia'] ?>"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-12" align="center">
                      <button class="main-btn primary-btn btn-hover" name="data" type="submit">
                        Actualizar datos
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end card -->
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  
                    IENE
                  
                </p>
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div class="terms d-flex justify-content-center justify-content-md-end">
                <a href="#0" class="text-sm">Term & Conditions</a>
                <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
