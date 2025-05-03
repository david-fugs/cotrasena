<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COTRASENA</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
    <link rel="stylesheet" href="styleSell.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/vistas.css">

</head>
<?php
include("../../conexion.php");
session_start();
if (isset($_GET['delete'])) {
    $id_usu = $_GET['delete'];
    deleteMember($id_usu);
}

function deleteMember($id_usu)
{
    global $mysqli; // Asegurar acceso a la conexión global

    $query = "DELETE FROM usuarios WHERE id_usu  = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $id_usu);

    if ($stmt->execute()) {
        echo "<script>alert('Solicitud borrada corecctamente');
        window.location = 'seeSolicitud.php';</script>";
    } else {
        echo "<script>alert('Error borrando la Solicitud');
        window.location = 'seeSolicitud.php';</script>";
    }

    $stmt->close();
}
?>

<body>
    <style>

    </style>
    <header class="header">
        <div class="logo-container">
            <img src='../../img/img3.png' class="logo" alt="Logo">
        </div>
        <h1 class="title">USUARIOS</h1>
    </header>

    <div class="container">
        <div class="box">
            <form action="showusers.php" method="get" class="form">
                <input name="nombres" type="text" placeholder="Nombres"
                    value="<?= isset($_GET['nombres']) ? htmlspecialchars($_GET['nombres']) : '' ?>" class="search-input">
                <input name="usuario" type="text" placeholder="Usuario"
                    value="<?= isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : '' ?>" class="search-input">
                <select name="tipo_usu" class="search-input form-select">
                    <option value="">Tipo Usuario</option>
                    <option value="1" <?= (isset($_GET['tipo_usu']) && $_GET['tipo_usu'] == 1) ? 'selected' : '' ?>>Gerencia</option>
                    <option value="2" <?= (isset($_GET['tipo_usu']) && $_GET['tipo_usu'] == 2) ? 'selected' : '' ?>>Encuestador</option>
                    <option value="3" <?= (isset($_GET['tipo_usu']) && $_GET['tipo_usu'] == 3) ? 'selected' : '' ?>>Aprobaciones</option>
                </select>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <div class="position-relative mb-3">
            <h2 class="text-center titulo">Control de Usuarios</h2>
            <button type="button" class="btn btn-success position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#modalCrear">
            Agregar Usuario
            </button>

        </div>

        <div class="table-responsive">
            <table class="data-table" id="salesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Tipo Usuario</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include "getUsers.php"; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDICION -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalEditarLabel">Edicion Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="updateUser.php" method="POST">
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombre">
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario">
                        </div>
                        <div class="mb-3">
                            <label for="tipo_usu" class="form-label">Tipo Usuario</label>
                            <select name="tipo_usu" id="tipo_usu" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="1">Gerente</option>
                                <option value="2">Encuestador</option>
                                <option value="3">Aprobaciones</option>
                            </select>
                        </div>
                        <input type="hidden" name="id_usu" id="id_usu" value="">
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="guardarCambios">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL CREAR USUARIO -->
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalCrearLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="createUser.php" method="POST">
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="nuevo_nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nuevo_nombres" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="nuevo_contrasena" name="contrasena" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_tipo_usu" class="form-label">Tipo Usuario</label>
                            <select name="tipo_usu" id="nuevo_tipo_usu" class="form-select" required>
                                <option value="">Seleccione</option>
                                <option value="1">Gerente</option>
                                <option value="2">Encuestador</option>
                                <option value="3">Aprobaciones</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="back" /></a><br>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalEditar = document.getElementById("modalEditar");
        modalEditar.addEventListener("shown.bs.modal", function(event) {
            const button = event.relatedTarget;

            const id_usu = button.getAttribute("data-id_usu");
            const nombres = button.getAttribute("data-nombres");
            const usuario = button.getAttribute("data-usuario");
            const tipo_usu = button.getAttribute("data-tipo_usu");
            document.getElementById("id_usu").value = id_usu;
            document.getElementById("nombres").value = nombres;
            document.getElementById("usuario").value = usuario;
            document.getElementById("tipo_usu").value = tipo_usu;
        });
    });
</script>


</html>