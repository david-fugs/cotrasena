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
    <header class="header">
        <div class="logo-container">
            <img src='../../img/img3.png' class="logo" alt="Logo">
        </div>
        <h1 class="title">SOLICITUDES GERENCIA</h1>
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
            <h2 class="text-center titulo me-5">Solicitudes Gerencia Registradas</h2>

            <!-- Contenedor de los botones alineado a la derecha -->
            <div class="position-absolute top-0 end-0 d-flex gap-2 m">
                <button type="button" class="btn btn-success" onclick="window.location.href='../asoc/estadoSolicitud.php'">
                 Estado  Solicitud
                </button>
               
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="salesTable">
                <thead>
                    <tr>
                    <th class="fila" >Cedula</th>
                    <th class="fila">Nombres</th>
                    <th class="fila">Monto Solicitado</th>
                    <th class="fila">Linea Credito</th>
                    <th class="fila">Observacion</th>
                    <th class="fila" >Fecha Gerencia</th>
                    <th class="fila">Agregar Observacion</th>
                    <th class="fila">Devolver Solicitud</th>
                    <th class="fila">Aprobar desde Gerencia</th>
                    <th class="fila">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include "getGerencia.php"; ?>
                </tbody>
            </table>
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
                <form action="observationGerencia.php" method="POST">
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="observacion_gerencia" class="form-label">Observacion</label>
                            <input type="text" class="form-control" id="observacion_gerencia" name="observacion_gerencia">
                        </div>
                        <input type="hidden" name="id_gerencia" id="id_gerencia" value="">

                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="guardarCambios">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL DEVOLVER SOLICITUD-->
    <div class="modal fade" id="modalDevolverSolicitud" tabindex="-1" aria-labelledby="modalDevolverSolicitudLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalDevolverSolicitudLabel">Agrega una Observacion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="devolverGerencia.php" method="POST">
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="observacion_gerencia" class="form-label">Observacion</label>
                            <input type="text" class="form-control" id="observacion_gerencia" name="observacion_gerencia">
                        </div>
                        <input type="hidden" name="id_gerencia" id="id_gerencia2" value="">
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="guardarCambios">Guardar</button>
                    </div>
                </form>
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
            document.getElementById("id_gerencia").value = button.getAttribute("data-id_gerencia");
        });


    });

    document.addEventListener("DOMContentLoaded", function() {
        const modalDevolverSolicitud = document.getElementById("modalDevolverSolicitud");

        modalDevolverSolicitud.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id_gerencia = button.getAttribute('data-id_gerencia');
            console.log("id_gerenciaaaa", id_gerencia);
            document.getElementById('id_gerencia2').value = id_gerencia;
        });

    });
</script>


</html>