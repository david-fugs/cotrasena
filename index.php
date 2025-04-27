<?php

  require "conexion.php";
 
  session_start();

  if($_POST)
  {

    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = $mysqli->query($sql);
    $num = $resultado->num_rows;

    if (!empty($usuario) && !empty($password)) {
      if($num > 0) {
        $row = $resultado->fetch_assoc();
        $password_bd = $row['password'];
        $pass_c = sha1($password);

        if($password_bd == $pass_c) {
          $_SESSION['id_usu'] = $row['id_usu'];
          $_SESSION['nombre'] = $row['nombre'];
          $_SESSION['usuario'] = $usuario;
          $_SESSION['tipo_usu'] = $row['tipo_usu'];

          if (in_array($row['tipo_usu'], [1, 2, 3, 4, 5, 6])) {
            header("Location: access.php");
            exit();
          } else {
            header("Location: index.php");
            exit();
          }
        } else {
          echo "La contraseña no coincide";
        }
      } else {
        echo "El usuario no existe";
      }
    } else {
      echo "Usuario y contraseña son requeridos";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>SOLICITUDES</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="img/wave.png" style="width: 750px;" >
	<div class="container">
		<div class="img">
			<img src="img/img3.png">
		</div>
		<div class="login-content">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <img src="img/avatar.svg">
				<h2 class="title">Bienvenid@</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Usuario</h5>
           		   		<input type="text" class="input" name="usuario">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password">
            	   </div>
            	</div>
            	<a href="register.php">Crear Cuenta</a>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
