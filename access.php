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
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>PANEL - SOLICITUDES | COTRASENA</title>
  <style>
    :root {
      --color-primario: #13603e;
      --color-secundario: #94b465;
      --color-terciario: #3a7a5d;
      --color-naranja: #F3840D;
      --color-fondo: #f8faf8;
      --color-texto: #333333;
      --color-texto-claro: #ffffff;
      --color-borde: #e0e6e0;
      --color-sombra: rgba(0, 0, 0, 0.1);
      --transicion: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--color-fondo);
      color: var(--color-texto);
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(135deg, var(--color-primario), var(--color-terciario));
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 25px;
      height: 70px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }

    .logo_item {
      display: flex;
      align-items: center;
      gap: 15px;
      font-weight: 600;
      font-size: 1.2rem;
    }

    .logo_item img {
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    #sidebarOpen {
      font-size: 1.5rem;
      cursor: pointer;
      transition: var(--transicion);
      color: white;
    }

    #sidebarOpen:hover {
      transform: scale(1.1);
      color: var(--color-secundario);
    }

    .navbar_content {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .navbar_content i {
      font-size: 1.2rem;
      cursor: pointer;
      transition: var(--transicion);
      color: white;
    }

    .navbar_content i:hover {
      transform: scale(1.1);
      color: var(--color-secundario);
    }

    .profile {
      height: 40px;
      width: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--color-secundario);
      cursor: pointer;
      transition: var(--transicion);
    }

    .profile:hover {
      transform: scale(1.1);
      border-color: white;
    }

    /* Sidebar */
    .sidebar {
      background: white;
      width: 280px;
      height: 100vh;
      position: fixed;
      top: 70px;
      left: -280px;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
      transition: var(--transicion);
      z-index: 999;
      overflow-y: auto;
    }

    .sidebar.active {
      left: 0;
    }

    .menu_content {
      height: calc(100% - 60px);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .menu_items {
    list-style: none; /* Esto elimina los puntos de la lista */
    padding-left: 0; /* Elimina el padding izquierdo por defecto */
}

.submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    display: none; /* Ocultamos completamente el submenú inicialmente */
    list-style: none; /* Aseguramos que los submenús tampoco muestren puntos */
    padding-left: 0; /* Elimina el padding izquierdo en submenús */
}

.submenu.active {
    max-height: 500px;
    display: block; /* Mostramos el submenú cuando está activo */
}

/* Estilo para el ícono de flecha cuando está activo */
.arrow-left.rotate {
    transform: rotate(90deg);
}

    .menu_title {
      color: var(--color-primario);
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 15px 25px;
      margin-bottom: 5px;
      border-bottom: 1px solid var(--color-borde);
    }

    .item {
      margin-bottom: 5px;
    }

    .nav_link {
      display: flex;
      align-items: center;
      padding: 12px 25px;
      color: var(--color-texto);
      text-decoration: none;
      transition: var(--transicion);
      cursor: pointer;
    }

    .nav_link:hover {
      background-color: rgba(148, 180, 101, 0.1);
      color: var(--color-primario);
    }

    .navlink_icon {
      margin-right: 15px;
      font-size: 1.1rem;
      color: var(--color-primario);
      min-width: 25px;
      display: flex;
      justify-content: center;
    }

    .navlink {
      font-size: 0.95rem;
      font-weight: 500;
    }

    .arrow-left {
      margin-left: auto;
      transition: var(--transicion);
      font-size: 1.1rem;
    }

    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .submenu.active {
      max-height: 500px;
    }

    .sublink {
      display: block;
      padding: 10px 25px 10px 65px;
      color: var(--color-texto);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 400;
      transition: var(--transicion);
      border-left: 3px solid transparent;
    }

    .sublink:hover {
      background-color: rgba(148, 180, 101, 0.1);
      border-left: 3px solid var(--color-secundario);
      color: var(--color-primario);
    }

    hr {
      border: 1px solid  #94b465;
      margin: 15px 25px;
      opacity: 0.3;
    }

    .bottom_content {
      padding: 20px;
      border-top: 1px solid var(--color-borde);
    }

    .bottom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: var(--color-primario);
      font-weight: 500;
      cursor: pointer;
      padding: 10px;
      border-radius: 6px;
      transition: var(--transicion);
    }

    .bottom:hover {
      background-color: rgba(148, 180, 101, 0.1);
    }

    .bottom i {
      font-size: 1.1rem;
    }


    /* Main Content */
    .main-content {
      margin-top: 70px;
      margin-left: 0;
      padding: 25px;
      min-height: calc(100vh - 70px);
      transition: var(--transicion);
    }

    .main-content.active {
      margin-left: 280px;
    }

    /* Dashboard Cards */
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: var(--transicion);
      border-left: 4px solid var(--color-primario);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 15px;
    }

    .card-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: rgba(148, 180, 101, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--color-primario);
      font-size: 1.5rem;
    }

    .card-title {
      font-size: 0.9rem;
      color: var(--color-primario);
      font-weight: 600;
    }

    .card-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--color-primario);
      margin-bottom: 5px;
    }

    .card-footer {
      font-size: 0.8rem;
      color: var(--color-terciario);
    }

    /* Recent Activity */
    .recent-activity {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .section-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--color-primario);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--color-borde);
    }

    .activity-list {
      list-style: none;
    }

    .activity-item {
      display: flex;
      padding: 15px 0;
      border-bottom: 1px solid var(--color-borde);
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: rgba(148, 180, 101, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: var(--color-primario);
      font-size: 1rem;
    }

    .activity-content {
      flex: 1;
    }

    .activity-title {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .activity-time {
      font-size: 0.8rem;
      color: var(--color-terciario);
    }

    /* Dark Mode */
    body.dark-mode {
      background-color: #1a1a2e;
      color: #f0f0f0;
    }

    body.dark-mode .sidebar,
    body.dark-mode .card,
    body.dark-mode .recent-activity {
      background-color: #16213e;
      color: #f0f0f0;
    }

    body.dark-mode .nav_link,
    body.dark-mode .sublink {
      color: #f0f0f0;
    }

    body.dark-mode .nav_link:hover,
    body.dark-mode .sublink:hover {
      background-color: rgba(19, 96, 62, 0.3);
    }

    body.dark-mode .section-title,
    body.dark-mode .activity-title {
      color: #f0f0f0;
    }

    body.dark-mode .activity-time {
      color: #94b465;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        left: -100%;
      }
      
      .sidebar.active {
        left: 0;
      }
      
      .main-content.active {
        margin-left: 0;
      }
    }

    /* Rotate arrow */
    .arrow-left.rotate {
      transform: rotate(90deg);
    }
  </style>
</head>

<body>
  <!-- navbar -->
  <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="img/img1.jpg" alt="Logo COTRASENA">
      <span>COTRASENA</span>
    </div>

    <div class="navbar_content">
      <i class="bi bi-grid" id="dashboardView"></i>
      <i class="fa-solid fa-sun" id="darkLight"></i>
      <a href="logout.php" title="Cerrar sesión"> <i class="fa-solid fa-door-open"></i></a>
      <img src="img/img1.jpg" alt="Perfil" class="profile" />
    </div>
  </nav>

  <!--************************MENÚ ADMINISTRADOR************************-->
  <?php if ($tipo_usu == 1) { ?>
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard">Panel Administrador</div>
          
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-user-pen"></i>
              </span>
              <span class="navlink">Usuarios</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/users/showusers.php" class="nav_link sublink">Ver Usuarios</a>
            </ul>
          </li>
          
          <hr>
          
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-regular fa-id-badge"></i>
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
              <a href="code/aprovedRequest/seeRequest.php" class="nav_link sublink">Ver Aprobadas</a>
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
              <a href="code/gerencia/seeGerencia.php" class="nav_link sublink">Ver Gerencia</a>
            </ul>
          </li>

          <hr>
          
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
          
          <div class="bottom_content">
            
            <div class="bottom collapse_sidebar">
              <span>Contraer</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
        </ul>
      </div>
    </nav>
  <?php } ?>

  <!--************************MENÚ ASESOR************************-->
  <?php if ($tipo_usu == 2) { ?>
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard">Panel Asesor</div>
          <hr>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-regular fa-id-badge"></i>
              </span>
              <span class="navlink">Solicitud Crédito</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/asoc/solicitar.php" class="nav_link sublink">Ingresar Solicitud</a>
              <a href="code/asoc/seeSolicitud.php" class="nav_link sublink">Ver Solicitudes</a>
            </ul>
          </li>
          
          <hr>
          
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
          
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span>Expandir</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span>Contraer</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
        </ul>
      </div>
    </nav>
  <?php } ?>

  <!--************************MENÚ APROBADOR************************-->
  <?php if ($tipo_usu == 3) { ?>
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard">Panel Aprobador</div>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-thumbs-up"></i>
              </span>
              <span class="navlink">Solicitudes Aprobadas</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/aprovedRequest/seeRequest.php" class="nav_link sublink">Ver Aprobadas</a>
            </ul>
          </li>
          
          <hr>
          
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
          
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span>Expandir</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span>Contraer</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
        </ul>
      </div>
    </nav>
  <?php }
  include 'code/cards/dashboardCards.php';
   ?>


  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.querySelector('.sidebar');
      const sidebarOpen = document.getElementById('sidebarOpen');
      const mainContent = document.getElementById('mainContent');
      const darkLight = document.getElementById('darkLight');
      const submenuItems = document.querySelectorAll('.submenu_item');
      const expandSidebar = document.querySelector('.expand_sidebar');
      const collapseSidebar = document.querySelector('.collapse_sidebar');
      const body = document.body;

      // Abrir/Cerrar sidebar
      sidebarOpen.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('active');
      });

      // Alternar submenús
      submenuItems.forEach(item => {
        item.addEventListener('click', () => {
          const submenu = item.nextElementSibling;
          const arrow = item.querySelector('.arrow-left');
          
          submenu.classList.toggle('active');
          arrow.classList.toggle('rotate');
        });
      });


      collapseSidebar.addEventListener('click', () => {
        sidebar.classList.remove('active');
        mainContent.classList.remove('active');
        expandSidebar.style.display = 'flex';
        collapseSidebar.style.display = 'none';
      });

      // Dark/Light mode
      darkLight.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
          darkLight.classList.remove('fa-sun');
          darkLight.classList.add('fa-moon');
          localStorage.setItem('darkMode', 'true');
        } else {
          darkLight.classList.remove('fa-moon');
          darkLight.classList.add('fa-sun');
          localStorage.setItem('darkMode', 'false');
        }
      });

      // Cargar preferencia de modo oscuro
      if (localStorage.getItem('darkMode') === 'true') {
        body.classList.add('dark-mode');
        darkLight.classList.remove('fa-sun');
        darkLight.classList.add('fa-moon');
      }
    });
  </script>
</body>
</html>