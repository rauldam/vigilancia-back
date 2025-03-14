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
$red = "1";
$redName = "test";
$idcliente = $seguridad->get_id_cliente();
$cif = $_SESSION['cif'];
$username = $_SESSION['name'];
$email = $_SESSION['email'];

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    //Destruimos la cookie creada;  
	$seguridad->log_out(); // the method to log off
}

require('php/includes/Cliente.php');
$cliente = new Cliente();

$param = array("idcliente" => $idcliente, "red" => $red, "cif" => $cif);
$archivos = $cliente->get_archivos_privados($param);

?><!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>SG - Archivos Privados</title>
    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                <a href="home.php"> Home </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
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
            <a href="archivos.php">
              <span class="icon">
                <i class="lni lni-folder"></i>
              </span>
              <span class="text">Archivos Privados</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings.php">
              <span class="icon">
                <i class="lni lni-cog"></i>
              </span>
              <span class="text">Perfil</span>
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
                          <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#" style="font-size: 10px;"><?php echo $email ?></a>
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
                  <h2>Archivos Privados</h2>
                </div>
              </div>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row">
            <div class="col-lg-12">
              <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-30">
                  <div class="left">
                    <h6 class="text-medium mb-20">Subir Archivos</h6>
                  </div>
                </div>
                <form action="php/v1/upload.php" class="dropzone" id="fileUpload">
                  <div class="dz-message">
                    <h3>Arrastra archivos aquí o haz clic para subir</h3>
                    <p>Solo se permiten archivos PDF, DOCX y XLSX (máx. 10MB)</p>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                  <div class="left">
                    <h6 class="text-medium mb-30">Mis Archivos</h6>
                  </div>
                </div>
                <div class="row" id="files">
                  <?php
                  if ($archivos[0]) {
                    foreach ($archivos[1] as $archivo) {
                      echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="card-style-2 mb-30">
                          <div class="card-image d-flex justify-content-center align-items-center bg-light" style="height: 350px;width:auto;">
                            <iframe src="https://docs.google.com/viewer?url=vigilancianormativa.es/'.{$archivo['ruta']}.'" style="width:300px; height:350px;" frameborder="0"></iframe>
                          </div>
                          <div class="card-content">
                            <h6 class="mb-3">' . htmlspecialchars($archivo['nombre']) . '</h6>
                            <p class="text-sm text-medium">
                              <i class="lni lni-calendar mr-1"></i> ' . date('d/m/Y H:i', strtotime($archivo['fecha_subida'])) . '
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                              <a href="' . $archivo['ruta'] . '" class="btn btn-primary btn-sm" target="_blank">
                               Descargar
                              </a>
                              <button class="btn btn-danger btn-sm" onclick="deleteFile(' . $archivo['id'] . ')">
                                Eliminar
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>';
                    }
                  } else {
                    echo '<div class="col-12">
                      <div class="alert alert-info" role="alert">
                        No hay archivos disponibles.
                      </div>
                    </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start ========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  &copy; 2024 IENE. Todos los derechos reservados
                </p>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- ========== footer end ========== -->
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
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
      // Delete file function
      function deleteFile(fileId) {
        if (confirm('¿Estás seguro de que deseas eliminar este archivo?')) {
          fetch('php/v1/delete_file.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: fileId })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              window.location.reload();
            } else {
              alert('Error al eliminar el archivo: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el archivo');
          });
        }
      }

      // Dropzone configuration
      Dropzone.options.fileUpload = {
        url: 'php/v1/upload.php',
        acceptedFiles: ".pdf,.docx,.xlsx",
        maxFilesize: 10,
        addRemoveLinks: true,
        dictDefaultMessage: "<h3>Arrastra archivos aquí o haz clic para subir</h3><p>Solo se permiten archivos PDF, DOCX y XLSX (máx. 10MB)</p>",
        init: function() {
          this.on("success", function(file, response) {
            if (response.success) {
              // Update the file list dynamically
              const fileContainer = document.createElement('div');
              fileContainer.className = 'col-xl-3 col-lg-4 col-md-6 col-sm-6';
              fileContainer.innerHTML = `
                <div class="card-style-2 mb-30">
                  <div class="card-image d-flex justify-content-center align-items-center bg-light"  style="height: 350px;width:auto">
                   <iframe src="https://docs.google.com/viewer?url=vigilancianormativa.es/back/${response.filePath}" style="width:300px; height:350px;" frameborder="0"></iframe>
                  </div>
                  <div class="card-content">
                    <h6 class="mb-3">${response.fileName}</h6>
                    <p class="text-sm text-medium">
                      <i class="lni lni-calendar mr-1"></i> ${new Date().toLocaleString('es-ES')}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <a href="back/${response.filePath}" class="btn btn-primary btn-sm" target="_blank">
                        Descargar
                      </a>
                      <button class="btn btn-danger btn-sm" onclick="deleteFile(${response.fileId})">
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              `;
              //document.querySelector('.row').insertBefore(fileContainer, document.querySelector('.row').firstChild);
              document.getElementById('files').appendChild(fileContainer);
              this.removeFile(file);
            } else {
              alert('Error al subir el archivo: ' + response.message);
            }
          });
          
          this.on("error", function(file, message) {
            alert('Error al subir el archivo: ' + message);
            this.removeFile(file);
          });

          this.on("addedfile", function(file) {
            // Add custom progress bar
            const progressElement = document.createElement('div');
            progressElement.className = 'progress';
            progressElement.innerHTML = '<div class="progress-bar" role="progressbar" style="width: 0%"></div>';
            file.previewElement.appendChild(progressElement);
          });

          this.on("uploadprogress", function(file, progress) {
            const progressBar = file.previewElement.querySelector('.progress-bar');
            progressBar.style.width = progress + '%';
          });
        }
      };
    </script>
  </body>
</html>