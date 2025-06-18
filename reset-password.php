<?php
session_start();
require_once('conexion.php');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usu'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];
$id_usuario = $_SESSION['id_usu'];

$mensaje = "";
$tipo_mensaje = "";

// Procesar el formulario cuando se envía
if ($_POST) {
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $confirmar_password = $_POST['confirmar_password'];
    
    // Validaciones
    if (empty($password_actual) || empty($password_nueva) || empty($confirmar_password)) {
        $mensaje = "Todos los campos son obligatorios";
        $tipo_mensaje = "error";
    } elseif ($password_nueva !== $confirmar_password) {
        $mensaje = "Las contraseñas nuevas no coinciden";
        $tipo_mensaje = "error";
    } elseif (strlen($password_nueva) < 6) {
        $mensaje = "La nueva contraseña debe tener al menos 6 caracteres";
        $tipo_mensaje = "error";
    } else {
        // Verificar la contraseña actual
        $password_actual_sha1 = sha1($password_actual);
        $query = "SELECT id_usu FROM usuarios WHERE id_usu = ? AND password = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("is", $id_usuario, $password_actual_sha1);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            // La contraseña actual es correcta, actualizar con la nueva
            $password_nueva_sha1 = sha1($password_nueva);
            $query_update = "UPDATE usuarios SET password = ? WHERE id_usu = ?";
            $stmt_update = $mysqli->prepare($query_update);
            $stmt_update->bind_param("si", $password_nueva_sha1, $id_usuario);
            
            if ($stmt_update->execute()) {
                $mensaje = "Contraseña actualizada exitosamente";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al actualizar la contraseña";
                $tipo_mensaje = "error";
            }
            $stmt_update->close();
        } else {
            $mensaje = "La contraseña actual es incorrecta";
            $tipo_mensaje = "error";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Cambiar Contraseña - COTRASENA</title>
    <style>
        :root {
            --color-primario: #13603e;
            --color-secundario: #94b465;
            --color-terciario: #3a7a5d;
            --color-naranja: #F3840D;
            --color-fondo: #f8faf8;
            --color-texto: #333333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--color-primario), var(--color-secundario));
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--color-primario);
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            color: #666;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--color-texto);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--color-primario);
            background: white;
            box-shadow: 0 0 0 3px rgba(19, 96, 62, 0.1);
        }

        .form-group .toggle-password {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            color: #666;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .form-group .toggle-password:hover {
            color: var(--color-primario);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--color-primario), var(--color-terciario));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(19, 96, 62, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--color-primario);
            text-decoration: none;
            font-weight: 500;
            margin-top: 20px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--color-terciario);
        }

        .back-link i {
            margin-right: 8px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 3px solid var(--color-secundario);
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-key"></i> Cambiar Contraseña</h1>
            <p>Actualiza tu contraseña de forma segura</p>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="password_actual">Contraseña Actual</label>
                <input type="password" id="password_actual" name="password_actual" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_actual')"></i>
            </div>

            <div class="form-group">
                <label for="password_nueva">Nueva Contraseña</label>
                <input type="password" id="password_nueva" name="password_nueva" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_nueva')"></i>
                <div class="password-requirements">
                    <i class="fas fa-info-circle"></i> La contraseña debe tener al menos 6 caracteres
                </div>
            </div>

            <div class="form-group">
                <label for="confirmar_password">Confirmar Nueva Contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmar_password')"></i>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-lock"></i> Actualizar Contraseña
            </button>
        </form>

        <a href="access.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Validación en tiempo real
        document.getElementById('confirmar_password').addEventListener('input', function() {
            const password = document.getElementById('password_nueva').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword && confirmPassword !== '') {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#e1e1e1';
            }
        });

        document.getElementById('password_nueva').addEventListener('input', function() {
            const confirmPassword = document.getElementById('confirmar_password');
            if (this.value !== confirmPassword.value && confirmPassword.value !== '') {
                confirmPassword.style.borderColor = '#dc3545';
            } else {
                confirmPassword.style.borderColor = '#e1e1e1';
            }
        });

        // Mostrar mensaje de éxito y redirigir
        <?php if ($tipo_mensaje === 'success'): ?>
            setTimeout(function() {
                window.location.href = 'access.php';
            }, 2000);
        <?php endif; ?>
    </script>
</body>
</html>
