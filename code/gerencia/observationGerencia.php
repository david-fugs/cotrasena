<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $id_gerencia = $_POST['id_gerencia'];
    $observacion_gerencia = $_POST['observacion_gerencia'];
    //ejecutar consulta
    $sql_update_gerencia = "UPDATE gerencia SET observacion_gerencia = '$observacion_gerencia', fecha_observacion_gerencia = NOW() WHERE id_gerencia = '$id_gerencia'";
    if ($mysqli->query($sql_update_gerencia)) {
        echo "<script>
            alert('Creada correctamente');
           window.location.href = 'seeGerencia.php';
          </script>";
    } else {
        echo "<script>
            alert('Error  " . $mysqli->error . "');
            window.location.href = 'seeGerencia.php';
          </script>";
    }
}
