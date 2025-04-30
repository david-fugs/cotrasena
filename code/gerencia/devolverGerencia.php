<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    print_r($_POST);  
    // Capturar datos del formulario
    $id_gerencia = $_POST['id_gerencia'];
    $observacion_gerencia = $_POST['observacion_gerencia'];

    //traer el id de la solicitud
    $sql = "SELECT id_solicitud FROM gerencia WHERE id_gerencia = '$id_gerencia'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_solicitud = $row['id_solicitud'];
    } else {
        echo "<script>
            alert('Error al obtener la solicitud');
           // window.location.href = 'seeGerencia.php';
          </script>";
        exit;
    }

    //borrar la aprobacion
    $sql_delete_gerencia = "DELETE FROM gerencia WHERE id_gerencia = '$id_gerencia'";
    if ($mysqli->query($sql_delete_gerencia)) {
        // Actualizar el estado de la solicitud a 1 (pendiente)
        $sql_update_solicitud = "UPDATE solicitudes SET estado_solicitud = 2,fecha_devolucion_gerencia = NOW() WHERE id_solicitud = '$id_solicitud'";
        if ($mysqli->query($sql_update_solicitud)) {
            //si se actualiza correctamente, se crea la observacion
            $sql_devoluciones = "INSERT INTO devolucion_gerencia (id_solicitud,observacion_devolucion_gerencia) VALUES ('$id_solicitud', '$observacion_gerencia')";
            if ($mysqli->query($sql_devoluciones)) {
                echo "<script>
                    alert('Devolucion creada correctamente');
                    window.location.href = 'seeGerencia.php';
                  </script>";
            } else {
                echo "<script>
                    alert('Error al crear la devolucion: " . $mysqli->error . "');
                    window.location.href = 'seeGerencia.php';
                  </script>";
            }
        } else {
            echo "<script>
                alert('Error al actualizar la solicitud: " . $mysqli->error . "');
                window.location.href = 'seeGerencia.php';
              </script>";
        }
    } else {
        echo "<script>
            alert('Error al borrar la aprobacion: " . $mysqli->error . "');
            window.location.href = 'seeGerencia.php';
            </script>";
    }
}
