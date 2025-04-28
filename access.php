<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
  header("Location: index.php");
}

$usuario      = $_SESSION['usuario'];
$nombre       = $_SESSION['nombre'];
$tipo_usu     = $_SESSION['tipo_usu'];

?>

<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <title>PANEL - SOLICITUDES</title>
  <link href="fontawesome/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="menu/style.css" />
</head>

<body>
  <!-- navbar -->
  <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="img/img1.jpg" width="100" height="100" alt=""></i>
    </div>

    <!--<div class="search_bar">
        <input type="text" placeholder="Buscar..." />
      </div>-->

    <div class="navbar_content">
      <i class="bi bi-grid"></i>
      <i class="fa-solid fa-sun" id="darkLight"></i><!--<i class='bx bx-sun' id="darkLight"></i>-->
      <a href="logout.php"> <i class="fa-solid fa-door-open"></i></a>
      <img src="img/img1.jpg" width="100" height="100" alt="" class="profile" />
    </div>
  </nav>

  <!--************************MENÚ ADMINISTRADOR************************-->
  <?php if ($tipo_usu == 1) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-regular fa-id-badge"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Solicitud Crédito</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/asoc/solicitar.php" class="nav_link sublink">Ingresar Solicitud</a>
              <a href="code/asoc/seeSolicitud.php" class="nav_link sublink">Ver Solicitudes</a>

            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Informes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/forms/menuReport.php" class="nav_link sublink">Generar Informes</a>
            </ul>
          </li>

          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>
          <!-- Sidebar Open / Close -->
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span> Expand</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span> Collapse</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
      </div>
    </nav>
  <?php } ?>


  <!--************************MENÚ AVALADOR************************-->
  <?php if ($tipo_usu == 2) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-regular fa-id-badge"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Solicitud Crédito</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/asoc/solicitar.php" class="nav_link sublink">Ingresar Solicitud</a>
              <a href="code/asoc/seeSolicitud.php" class="nav_link sublink">Ver Solicitudes</a>

            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Informes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/forms/menuReport.php" class="nav_link sublink">Generar Informes</a>
            </ul>
          </li>

          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>
          <!-- Sidebar Open / Close -->
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span> Expand</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span> Collapse</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
      </div>
    </nav>
  <?php } ?>

  <!-- JavaScript -->

  <!--************************MENÚ USUARIO************************-->
  <?php if ($tipo_usu == 3) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-regular fa-id-badge"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Solicitud Crédito</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/asoc/solicitar.php" class="nav_link sublink">Ingresar Solicitud</a>
              <a href="code/asoc/seeSolicitud.php" class="nav_link sublink">Ver Solicitudes</a>

            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-thumbs-up"></i>
              </span>

              <span class="navlink">Solicitudes Aprobadas</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/aprovedRequest/seeRequest.php" class="nav_link sublink">Ver Solicitudes Aprobadas</a>

            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
              <i class="fa-solid fa-arrow-trend-up"></i>
              </span>

              <span class="navlink">Solicitudes Gerencia</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/gerencia/seeRequest.php" class="nav_link sublink">Ver Solicitudes Gerencia</a>

            </ul>
          </li>



          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>
          <!-- Sidebar Open / Close -->
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span> Expand</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span> Collapse</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
      </div>
    </nav>
  <?php } ?>

  <!-- JavaScript -->
  <script src="menu/script.js"></script>
</body>

</html>