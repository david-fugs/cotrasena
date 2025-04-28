<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $id_aprobacion = $_POST['id_aprobacion'];
    $observacion_aprobacion = $_POST['observacion_aprobacion'];

    //traer el id de la solicitud
    $sql = "SELECT id_solicitud FROM aprobaciones WHERE id_aprobacion = '$id_aprobacion'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_solicitud = $row['id_solicitud'];
    } else {
        echo "<script>
            alert('Error al obtener la solicitud');
            window.location.href = 'seeRequest.php';
          </script>";
        exit;
    }

    //borrar la aprobacion
    $sql_delete_aprobacion = "DELETE FROM aprobaciones WHERE id_aprobacion = '$id_aprobacion'";
    if ($mysqli->query($sql_delete_aprobacion)) {
        // Actualizar el estado de la solicitud a 1 (pendiente)
        $sql_update_solicitud = "UPDATE solicitudes SET estado_solicitud = 1 ,fecha_devolucion = NOW() WHERE id_solicitud = '$id_solicitud'";
        if ($mysqli->query($sql_update_solicitud)) {
            //si se actualiza correctamente, se crea la observacion
            $sql_devoluciones = "INSERT INTO devoluciones (id_solicitud,observacion_devolucion) VALUES ('$id_solicitud', '$observacion_aprobacion')";
            if ($mysqli->query($sql_devoluciones)) {
                echo "<script>
                    alert('Devolucion creada correctamente');
                    window.location.href = 'seeRequest.php';
                  </script>";
            } else {
                echo "<script>
                    alert('Error al crear la devolucion: " . $mysqli->error . "');
                    window.location.href = 'seeRequest.php';
                  </script>";
            }
        } else {
            echo "<script>
                alert('Error al actualizar la solicitud: " . $mysqli->error . "');
                window.location.href = 'seeRequest.php';
              </script>";
        }
    } else {
        echo "<script>
            alert('Error al borrar la aprobacion: " . $mysqli->error . "');
            window.location.href = 'seeRequest.php';
            </script>";
    }
}
