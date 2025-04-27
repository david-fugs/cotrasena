<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Capturar datos del formulario
    $id_solicitud = $_GET['id_solicitud'];
    $estado_solicitud = $_GET['estado_solicitud'];

    // Ejecutar consulta
    $sql_update_solicitud = "UPDATE solicitudes SET estado_solicitud = '$estado_solicitud' WHERE id_solicitud = '$id_solicitud'";
    if ($mysqli->query($sql_update_solicitud)) {
        //si la consulta fueexitosa, crear en la tabla aprobaciones el el id_solicitud , y la fecha de aprobacion
        $sql_insert_aprobacion = "INSERT INTO aprobaciones (id_solicitud, fecha_aprobacion) VALUES ('$id_solicitud', NOW())";
        $mysqli->query($sql_insert_aprobacion);
        echo "<script>
            alert('Actualizado correctamente');
            window.location.href = 'seeSolicitud.php';
          </script>";
    } else {
        echo "<script>
            alert('Error  " . $mysqli->error . "');
            window.location.href = 'seeSolicitud.php';
          </script>";
    }
}
