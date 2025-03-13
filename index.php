<?php
include('php/includes/Seguridad.php');
include('php/includes/MobileDetect.php');
$detect = new Mobile_Detect;
$isMobile = $detect->isMobile();
$seguridad = new Seguridad();
$seguridad->language = "es";
$seguridad->login_reader();
if (isset($_POST['Submit'])) {
    $seguridad->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; 
    $seguridad->login_user($_POST['login'], $_POST['password']); // call the login method
}
$error = $seguridad->the_msg;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>SG - Vigilancia Normativa</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/main.css" />
      <style>
      .p-viewer, .p-viewer2{
          float: right;
          margin-top: -30px;
          position: relative;
          z-index: 1;
          padding-right: 5px;
          cursor:pointer;
      }  
      <?php if ($isMobile): ?>
      .auth-cover-wrapper { display: none; }
      .signin-wrapper { padding: 20px; }
      .footer { display: none; }
      .form-wrapper { max-width: 100%; }
      .main-wrapper { padding: 0; }
      .signin-section { min-height: 100vh; display: flex; align-items: center; }
      <?php endif; ?>
      </style>
  </head>
  <body>
   
    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">

      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">

          <div class="row g-0 auth-row">
            <?php if (!$isMobile): ?>
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">¡Bienvenido!</h1>
                    
                  </div>
                  <div class="cover-image">
                    <img src="assets/images/auth/signin-image.svg" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="assets/images/auth/shape.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            <!-- end col -->
            <div class="<?php echo $isMobile ? 'col-12' : 'col-lg-6'; ?>">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Acceder</h6>
                  <p class="text-sm mb-25">
                    Inicie sesión con su usuario y contraseña proporcionados
                  </p>
                    <p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
                  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Email</label>
                          <input type="email"id="email" placeholder="Usuario" name="login" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $seguridad->user; ?>" required>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Contraseña</label>
                          <input type="password" placeholder="Contraseña" id="password"  name="password" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : $seguridad->user_pw; ?>" required>
                            <span class="p-viewer2">
                            <i class="fas fa-eye-slash" aria-hidden="true" id="togglePassword"></i>
                            </span>
                        </div>
                      </div>
                      <!-- end col -->
                     
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button class="main-btn primary-btn btn-hover w-100 text-center" name="Submit" type="submit">
                            Iniciar Sesión
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                 
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->

      <!-- ========== footer start =========== -->
      <?php if (!$isMobile): ?>
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by IENE
                  
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
      <?php endif; ?>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    
   <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            const clase = this.className === "fas fa-eye-slash" ? "fas fa-eye" : "fas fa-eye-slash";
            this.className = clase;
        });

    </script>
  </body>
</html>
