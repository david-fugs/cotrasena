<?php
include("../../conexion.php");
session_start();

function redirigir($mensaje, $estado)
{
    $rutas = [
        1 => '../aprovedRequest/seeRequest.php',
        2 => 'seeSolicitud.php',
        3 => '../aprovedRequest/seeRequest.php',
        4 => '../gerencia/seeGerencia.php',
    ];

    $ruta = $rutas[$estado] ?? 'index.php';

    echo "<script>
        alert('$mensaje');
        window.location.href = '$ruta';
    </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id_solicitud = $_GET['id_solicitud'] ?? null;
    $estado_solicitud = $_GET['estado_solicitud'] ?? null;

    if (!$id_solicitud || !$estado_solicitud) {
        redirigir("Datos incompletos para actualizar la solicitud.", $estado_solicitud);
    }

    // Actualizar estado de solicitud
    $sql_update = "UPDATE solicitudes SET estado_solicitud = '$estado_solicitud' WHERE id_solicitud = '$id_solicitud'";
    if (!$mysqli->query($sql_update)) {
        redirigir("Error al actualizar la solicitud: " . $mysqli->error, $estado_solicitud);
    }

    // Acciones según el estado
    if ($estado_solicitud == 2) {
        $mysqli->query("DELETE FROM devoluciones WHERE id_solicitud = '$id_solicitud'");
        $sql_insert = "INSERT INTO aprobaciones (id_solicitud, fecha_aprobacion) VALUES ('$id_solicitud', NOW())";
        if ($mysqli->query($sql_insert)) {
            redirigir("Solicitud actualizada y aprobacion registrada correctamente.", $estado_solicitud);
        } else {
            redirigir("Error al registrar la aprobación: " . $mysqli->error, $estado_solicitud);
        }
    }

    if ($estado_solicitud == 3) {
        $mysqli->query("DELETE FROM devolucion_gerencia WHERE id_solicitud = '$id_solicitud'");
        $sql_gerencia = "INSERT INTO gerencia (id_solicitud, fecha_gerencia) VALUES ('$id_solicitud', NOW())";
        if ($mysqli->query($sql_gerencia)) {
            redirigir("Solicitud actualizada y gerencia registrada correctamente.", $estado_solicitud);
        } else {
            redirigir("Error al registrar la gerencia: " . $mysqli->error, $estado_solicitud);
        }
    }

    // Para otros estados sin acciones específicas
    redirigir("Solicitud actualizada correctamente.", $estado_solicitud);
}
