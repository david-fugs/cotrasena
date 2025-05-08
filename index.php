<?php
require "conexion.php";
session_start();

if($_POST){
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];
    
    if(!empty($usuario) && !empty($password)) {
        $sql = "SELECT id_usu, password, nombre, tipo_usu FROM usuarios WHERE usuario='$usuario'";
        $resultado = $mysqli->query($sql);
        $num = $resultado->num_rows;
        
        if($num > 0) {
            $row = $resultado->fetch_assoc();
            $password_bd = $row['password'];
            $pass_c = sha1($password);
            
            if($password_bd == $pass_c){
                $_SESSION['id_usu'] = $row['id_usu'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['usuario'] = $usuario;
                $_SESSION['tipo_usu'] = $row['tipo_usu'];
                
                if(in_array($row['tipo_usu'], [1, 2, 3, 4, 5, 6])) {
                    header("Location: access.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $error = "La contraseña no coincide";
            }
        } else {
            $error = "No existe usuario";
        }
    } else {
        $error = "Usuario y contraseña son requeridos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COTRASENA | LOGIN</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primario: #13603e;
            --color-secundario: #94b465;
            --color-terciario: #3a7a5d;
            --color-fondo: #f8faf8;
            --color-texto: #333333;
            --color-texto-claro: #ffffff;
            --color-error: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-fondo);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 0 20px;
        }
        
        .login-box {
            background-color: var(--color-texto-claro);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        
        .logo {
            width: 180px;
            margin-bottom: 30px;
        }
        
        .title {
            color: var(--color-primario);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-primario);
        }
        
        .input-field {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .input-field:focus {
            border-color: var(--color-secundario);
            box-shadow: 0 0 0 3px rgba(148, 180, 101, 0.2);
            outline: none;
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, var(--color-primario), var(--color-terciario));
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(19, 96, 62, 0.3);
        }
        
        .error-message {
            color: var(--color-error);
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: block;
        }
        
        @media (max-width: 480px) {
            .login-box {
                padding: 30px 20px;
            }
            
            .logo {
                width: 150px;
                margin-bottom: 20px;
            }
            
            .title {
                font-size: 1.5rem;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="img/img3.png" alt="Logo COTRASENA" class="logo">
            <h1 class="title">Bienvenid@</h1>
            
            <?php if(isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="input-field" name="usuario" placeholder="Usuario" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" name="password" placeholder="Contraseña" required>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Ingresar
                </button>
            </form>
        </div>
    </div>

    <script>
        // Efecto para mostrar notificación de error
        <?php if(isset($error)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const errorDiv = document.createElement('div');
            errorDiv.innerHTML = `
                <div style="position: fixed; top: 20px; right: 20px; background: #fff; padding: 15px; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; z-index: 1000; border-left: 4px solid var(--color-error);">
                    <i class="fas fa-exclamation-circle" style="color: var(--color-error); margin-right: 10px;"></i>
                    <span><?php echo $error; ?></span>
                </div>
            `;
            document.body.appendChild(errorDiv);
            
            setTimeout(() => {
                errorDiv.style.transition = 'opacity 0.5s';
                errorDiv.style.opacity = '0';
                setTimeout(() => errorDiv.remove(), 500);
            }, 5000);
        });
        <?php endif; ?>
        
        // Efecto de enfoque para los inputs
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('i').style.color = 'var(--color-secundario)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('i').style.color = 'var(--color-primario)';
            });
        });
    </script>
</body>
</html>