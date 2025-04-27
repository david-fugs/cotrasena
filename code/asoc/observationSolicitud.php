<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $id_solicitud = $_POST['id_solicitud'];
    $observacion_solicitud = $_POST['observacion_solicitud'];
    //ejecutar consulta
    $sql_update_solicitud = "UPDATE solicitudes SET observacion_solicitud = '$observacion_solicitud', fecha_observacion = NOW() WHERE id_solicitud = '$id_solicitud'";
    if ($mysqli->query($sql_update_solicitud)) {
        echo "<script>
            alert('Creada correctamente');
           window.location.href = 'seeSolicitud.php';
          </script>";
    } else {
        echo "<script>
            alert('Error  " . $mysqli->error . "');
            window.location.href = 'seeSolicitud.php';
          </script>";
    }
}
