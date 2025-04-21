<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SDSYP</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
    <link rel="stylesheet" href="styleSell.css">
    <!-- Bootstrap CSS -->
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Librerías de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</head>
<?php
include("../../conexion.php");

if (isset($_GET['delete'])) {
    $id_solicitud = $_GET['delete'];
    deleteMember($id_solicitud);
}

function deleteMember($id_solicitud)
{
    global $mysqli; // Asegurar acceso a la conexión global

    $query = "DELETE FROM solicitudes WHERE id_solicitud  = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $id_solicitud);

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
    <center style="margin-top: 20px;">
        <img src='../../img/img1.jpg' width="360" height="170" class="responsive">
    </center>
    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i
                class="fa-solid fa-file-signature"></i> SOLICITUDES </b></h1>
    <div class="flex">
        <div class="box">
            <form action="seeSolicitud.php" method="get" class="form">
                <input name="cedula_persona" type="number" placeholder="Cédula"
                    value="<?= isset($_GET['cedula_persona']) ? htmlspecialchars($_GET['cedula_persona']) : '' ?>">

                <input name="nombre" type="text" placeholder="Nombre"
                    value="<?= isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '' ?>">
                <select name="credito">
                    <option value="">Linea Credito</option>
                    <option value="LIBRE INVERSION" <?= (isset($_GET['credito']) && $_GET['credito'] == 'LIBRE INVERSION') ? 'selected' : '' ?>>LIBRE INVERSION</option>
                    <option value="CREDIAPORTES" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDIAPORTES') ? 'selected' : '' ?>>CREDIAPORTES</option>
                    <option value="CREDITO EDUCATIVO " <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO EDUCATIVO ') ? 'selected' : '' ?>>CREDITO EDUCATIVO</option>
                    <option value="CREDITO ROTATIVO" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO ROTATIVO') ? 'selected' : '' ?>>CREDITO ROTATIVO</option>
                    <option value="CREDITO PRIMA" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO PRIMA') ? 'selected' : '' ?>>CREDITO PRIMA</option>
                </select>
                <input value="Buscar" type="submit">
            </form>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="container mt-5">
        <div class="position-relative mb-3">
            <h2 class="text-center">Personas Registradas</h2>
            <button type="button" class="btn btn-success position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#modalNewPerson">
                Agregar Persona
            </button>

        </div>
        <table class="table table-striped" id="salesTable">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombres</th>
                    <th>Monto Solicitado</th>
                    <th>Linea Credito</th>
                    <th>Fecha Solicitud</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php include "getSolicitud.php"; ?>
            </tbody>
        </table>
    </div>


    <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="back" /></a><br>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalEdicion = document.getElementById("modalEdicion");

        modalEdicion.addEventListener("shown.bs.modal", function(event) {
            const button = event.relatedTarget;

            // Datos generales
            document.getElementById("edit-cedula").value = button.getAttribute("data-cedula");
            document.getElementById("edit-nombre").value = button.getAttribute("data-nombre");
            document.getElementById("edit-apellido").value = button.getAttribute("data-apellidos");
            document.getElementById("edit-telefono").value = button.getAttribute("data-telefono");
            document.getElementById("edit-referencia").value = button.getAttribute("data-referencia");
            document.getElementById("cedula_original").value = button.getAttribute("data-cedula");
            document.getElementById("edit-genero").value = button.getAttribute("data-genero");
            // Programas
            const idsProgramas = button.getAttribute("data-ids-programas");
            const idsArray = idsProgramas.split(",").map(id => id.trim());
            const checkboxes = modalEdicion.querySelectorAll('input[name="programa[]"]');
            checkboxes.forEach(cb => {
                cb.checked = idsArray.includes(cb.value);
            });
        });
    });
</script>


</html>