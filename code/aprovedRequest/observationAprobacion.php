<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $id_aprobacion = $_POST['id_aprobacion'];
    $observacion_aprobacion = $_POST['observacion_aprobacion'];
    //ejecutar consulta
    $sql_update_aprobacion = "UPDATE aprobaciones SET observacion_aprobacion = '$observacion_aprobacion', fecha_observacion_aprobacion = NOW() WHERE id_aprobacion = '$id_aprobacion'";
    if ($mysqli->query($sql_update_aprobacion)) {
        echo "<script>
            alert('Creada correctamente');
           window.location.href = 'seeRequest.php';
          </script>";
    } else {
        echo "<script>
            alert('Error  " . $mysqli->error . "');
            window.location.href = 'seeRequest.php';
          </script>";
    }
}
