<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Capturar datos del formulario
    $id_solicitud = $_GET['id_solicitud'] ?? null;
    $estado_solicitud = $_GET['estado_solicitud'] ?? null;

    if ($id_solicitud && $estado_solicitud) {
        // Ejecutar consulta
        $sql_update_solicitud = "UPDATE solicitudes SET estado_solicitud = '$estado_solicitud' WHERE id_solicitud = '$id_solicitud'";

        if ($mysqli->query($sql_update_solicitud)) {
            if ($estado_solicitud == 2) {
                // Si la actualización fue exitosa, crear en la tabla aprobaciones
                $sql_insert_aprobacion = "INSERT INTO aprobaciones (id_solicitud, fecha_aprobacion) VALUES ('$id_solicitud', NOW())";
                if ($mysqli->query($sql_insert_aprobacion)) {
                    echo "<script>
                        alert('Solicitud actualizada y aprobación registrada correctamente.');
                        if($estado_solicitud == 1) {
                            window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                        } 
                            if($estado_solicitud == 2) {
                            window.location.href = 'seeSolicitud.php';
                        } 
                            if($estado_solicitud == 3) {
                            window.location.href = '../aprovedRequest/seeRequest.php';
                        } 
                    
                    </script>";
                } else {
                    echo "<script>
                        alert('Solicitud actualizada, pero error al registrar la aprobación: " . $mysqli->error . "');
                         if($estado_solicitud == 1) {
                            window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                        } 
                            if($estado_solicitud == 2) {
                            window.location.href = 'seeSolicitud.php';
                        } 
                            if($estado_solicitud == 3) {
                            window.location.href = '../aprovedRequest/seeRequest.php';
                        } 
                    </script>";
                }
            }
            if ($estado_solicitud == 3) {
                $sql_gerencia = "INSERT INTO gerencia (id_solicitud, fecha_gerencia) VALUES ('$id_solicitud', NOW())";
                if ($mysqli->query($sql_gerencia)) {
                    echo "<script>
                        alert('Solicitud actualizada y gerencia registrada correctamente.');
                        if($estado_solicitud == 1) {
                            window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                        } 
                            if($estado_solicitud == 2) {
                            window.location.href = 'seeSolicitud.php';
                        } 
                            if($estado_solicitud == 3) {
                            window.location.href = '../aprovedRequest/seeRequest.php';
                        } 
                    
                    </script>";
                } else {
                    echo "<script>
                        alert('Solicitud actualizada, pero error al registrar la gerencia: " . $mysqli->error . "');
                         if($estado_solicitud == 1) {
                            window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                        } 
                            if($estado_solicitud == 2) {
                            window.location.href = 'seeSolicitud.php';
                        } 
                            if($estado_solicitud == 3) {
                            window.location.href = '../aprovedRequest/seeRequest.php';
                        } 
                    </script>";
                }
            }
        } else {
            echo "<script>
                alert('Error al actualizar la solicitud: " . $mysqli->error . "');
                 if($estado_solicitud == 1) {
                        window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                    } 
                        if($estado_solicitud == 2) {
                        window.location.href = 'seeSolicitud.php';
                    } 
                        if($estado_solicitud == 3) {
                        window.location.href = '../aprovedRequest/seeRequest.php';
                    } 
            </script>";
        }
    } else {
        echo "<script>
            alert('Datos incompletos para actualizar la solicitud.');
             if($estado_solicitud == 1) {
                        window.location.href = '../aprovedRequest/seeRequest.phpseeSolicitud.php';
                    } 
                        if($estado_solicitud == 2) {
                        window.location.href = 'seeSolicitud.php';
                    } 
                        if($estado_solicitud == 3) {
                        window.location.href = '../aprovedRequest/seeRequest.phpseeRequest.php';
                    } 
        </script>";
    }
}
