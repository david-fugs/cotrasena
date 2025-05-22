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
    <style>

    </style>
    <header class="header">
        <div class="logo-container">
            <img src='../../img/img3.png' class="logo" alt="Logo">
        </div>
        <h1 class="title">SOLICITUDES</h1>
    </header>

    <div class="container">
        <div class="box">
            <form action="seeSolicitud.php" method="get" class="form">
                <input name="cedula_persona" type="number" placeholder="Cédula"
                    value="<?= isset($_GET['cedula_persona']) ? htmlspecialchars($_GET['cedula_persona']) : '' ?>" class="search-input">
                <input name="nombre" type="text" placeholder="Nombre"
                    value="<?= isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '' ?>" class="search-input">
                <select name="credito" class="search-input form-select">
                    <option value="">Buscar línea crédito</option>
                    <option value="LIBRE INVERSION" <?= (isset($_GET['credito']) && $_GET['credito'] == 'LIBRE INVERSION') ? 'selected' : '' ?>>Libre inversión</option>
                    <option value="CREDIAPORTES" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDIAPORTES') ? 'selected' : '' ?>>Crediaportes</option>
                    <option value="CREDITO EDUCATIVO" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO EDUCATIVO') ? 'selected' : '' ?>>Crédito educativo</option>
                    <option value="CREDITO ROTATIVO" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO ROTATIVO') ? 'selected' : '' ?>>Crédito rotativo</option>
                    <option value="CREDITO PRIMA" <?= (isset($_GET['credito']) && $_GET['credito'] == 'CREDITO PRIMA') ? 'selected' : '' ?>>Crédito prima</option>
                </select>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <div class="position-relative mb-3">
            <h2 class="text-center titulo me-5">Solicitudes Registradas</h2>

            <!-- Contenedor de los botones alineado a la derecha -->
            <div class="position-absolute top-0 end-0 d-flex gap-2 m">
                <button type="button" class="btn btn-success" onclick="window.location.href='estadoSolicitud.php'">
                    Estado Solicitud
                </button>
                <button type="button" class="btn btn-success" onclick="window.location.href='solicitar.php'">
                    <i class="fas fa-plus"></i> Agregar Solicitud
                </button>
            </div>
        </div>
        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-success" onclick="window.location.href='excelSolicitud.php'">
                <i class="fa-solid fa-file"></i> Imprimir Excel
            </button>
        </div>

        <div class="d-flex flex-wrap justify-content-center ">
            <div class="table-responsive1" style="border: 2px solid #13603e;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;">
                <table class="data-table" id="salesTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Cedula</th>
                            <th>Nombres</th>
                            <th>Monto Solicitado</th>
                            <th>Linea Credito</th>
                            <th>Observacion</th>
                            <th>Fecha Solicitud</th>
                            <th>Atendido Por</th>
                            <th>Aprobar Solicitud</th>
                            <th>Agregar Observacion</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "getSolicitud.php"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- MODAL OBSERVACION -->
    <div class="modal fade" id="modalObservacion" tabindex="-1" aria-labelledby="modalObservacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalObservacionLabel">Agregar una Observacion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="observationSolicitud.php" method="POST">
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="observacion_solicitud" class="form-label">Observacion</label>
                            <input type="text" class="form-control" id="observacion_solicitud" name="observacion_solicitud">
                        </div>
                        <input type="hidden" name="id_solicitud" id="id_solicitud" value="">

                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="guardarCambios">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL DEVOLUCION -->
    <div class="modal fade" id="modalDevolucion" tabindex="-1" aria-labelledby="modalDevolucionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalDevolucionLabel">Observacion de la devolucion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label for="observacion_devolucion" class="form-label">Observacion Devolucion</label>
                        <input type="text" class="form-control" id="observacion_devolucion" name="observacion_devolucion" readonly>
                    </div>
                    <input type="hidden" name="id_solicitud" id="id_solicitud" value="">
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="back" /></a><br>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalObservacion = document.getElementById("modalObservacion");

        modalObservacion.addEventListener("shown.bs.modal", function(event) {
            const button = event.relatedTarget;

            // Datos generales
            document.getElementById("id_solicitud").value = button.getAttribute("data-id_solicitud");
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const modalObservacion = document.getElementById("modalObservacion");
        modalObservacion.addEventListener("shown.bs.modal", function(event) {
            const button = event.relatedTarget;
            // Datos generales
            document.getElementById("id_solicitud").value = button.getAttribute("data-id_solicitud");
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const modalDevolucion = document.getElementById("modalDevolucion");

        modalDevolucion.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const id_solicitud = button.getAttribute('data-id_solicitud');
            const observacion_devolucion = button.getAttribute('data-observacion_devolucion');
            console.log(id_solicitud, observacion_devolucion)
            document.getElementById('id_solicitud').value = id_solicitud;
            document.getElementById('observacion_devolucion').value = observacion_devolucion;
        });
    });
</script>


</html>