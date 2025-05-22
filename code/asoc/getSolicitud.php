<?php
include("../../conexion.php");
require_once("../../zebra.php");

function getUserName($id_usuario)
{
    global $mysqli;
    $query = "SELECT nombre FROM usuarios WHERE id_usu = '$id_usuario'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc()['nombre'];
    }
    return null;
}
$where = "WHERE s.estado_solicitud = 1";


// Filtro por cédula
if (!empty($_GET['cedula_persona'])) {
    $cedula = $mysqli->real_escape_string($_GET['cedula_persona']);
    $where .= " AND s.cedula_aso = '$cedula'";
}

// Filtro por nombre
if (!empty($_GET['nombre'])) {
    $nombre = $mysqli->real_escape_string($_GET['nombre']);
    $where .= " AND s.nombre_aso LIKE '%$nombre%'";
}

// Filtro por programa
if (!empty($_GET['credito'])) {
    $credito = $mysqli->real_escape_string($_GET['credito']);
    $where .= " AND s.linea_cred_aso = '$credito'";
}
// --- CONSULTA PARA CONTAR REGISTROS ---
$countQuery = "
    SELECT COUNT(DISTINCT s.id_solicitud) AS total
    FROM solicitudes AS s
    LEFT JOIN devoluciones AS d ON s.id_solicitud = d.id_solicitud
    
    $where
";
$countResult = $mysqli->query($countQuery);
if (!$countResult) die("Error al contar registros: " . $mysqli->error);
$totalRegistros = $countResult->fetch_assoc()['total'];

// --- CONFIGURAR PAGINACIÓN ---
$resul_x_pagina = 25;
$paginacion = new Zebra_Pagination();
$paginacion->records($totalRegistros);
$paginacion->records_per_page($resul_x_pagina);
$page = $paginacion->get_page();
$offset = ($page - 1) * $resul_x_pagina;

// Consulta SQL para obtener los datos
$query = "
SELECT s.cedula_aso, s.nombre_aso, s.id_solicitud, s.fecha_devolucion,
       s.fecha_alta_solicitud, s.monto_sol, s.linea_cred_aso,
       s.observacion_solicitud, d.observacion_devolucion, a.id_usu as atendido_por, a.fecha_solicitud
FROM solicitudes AS s
LEFT JOIN devoluciones AS d ON s.id_solicitud = d.id_solicitud
LEFT JOIN atenciones as a ON s.id_solicitud = a.id_solicitud
$where
ORDER BY 
    CASE WHEN s.fecha_observacion IS NOT NULL THEN 0 ELSE 1 END,
    s.fecha_alta_solicitud DESC
LIMIT $offset, $resul_x_pagina
";
$result = $mysqli->query($query);
$data = [];
function getDiasDesdeSolicitud($fecha_solicitud)
{
    $fecha_actual = new DateTime();
    $fecha_solicitud = new DateTime($fecha_solicitud);
    $diferencia = $fecha_actual->diff($fecha_solicitud);
    return $diferencia->days;
}
function getColor($dias)
{
    if ($dias >= 0 && $dias <= 7) {
        return "#d4edda"; // verde suave
    } elseif ($dias > 7 && $dias <= 14) {
        return "#fff3cd"; // amarillo suave
    } else {
        return "#f8d7da"; // rojo suave
    }
}

if ($result->num_rows > 0) {
    $color = "green";
    while ($row = $result->fetch_assoc()) {


        if ($row['fecha_devolucion'] != null) {
            $color = getColor(getDiasDesdeSolicitud($row['fecha_devolucion']));
        } else {
            $color = getColor(getDiasDesdeSolicitud($row['fecha_alta_solicitud']));
        }
        echo "<tr>";
        if ($row['fecha_devolucion'] != null) {
            echo '
            <td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
                <button type="button" class="btn-edit" 
                    data-bs-toggle="modal" data-bs-target="#modalDevolucion"
                    data-id_solicitud="' .  $row['id_solicitud']  . '"
                     data-observacion_devolucion="' . htmlspecialchars($row['observacion_devolucion']) . '"
                    style="background-color:transparent; border:none;">
                    <i class="fa-solid fa-triangle-exclamation fa-lg"></i>            
                </button>     
            </td> ';
        } else {
            echo '<td class="fila" style="background-color:' . $color . ';">' .  '</td>';
        }
        echo '<td class="fila"  style="background-color:' . $color . ';">' . $row['cedula_aso'] . '</td>';
        echo '<td  class="fila" style="background-color:' . $color . ';">' . $row['nombre_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['monto_sol'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['linea_cred_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['observacion_solicitud'] . '</td>';
        echo '<td  class="fila"style="background-color:' . $color . ';">' . $row['fecha_alta_solicitud'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . getUserName($row['atendido_por']) . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';" data-label="Estado" ">
                <a href="updateEstadoSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '&estado_solicitud=2" class="btn " " onclick="return confirm(\'¿Estás seguro de aprobar esta Solicitud?\')">
                        <i class="fas fa-rotate-right fa-lg"></i> 
                    </a>
                  </td>';
        echo '
            <td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
                <button type="button" class="btn-edit" 
                    data-bs-toggle="modal" data-bs-target="#modalObservacion"
                     data-id_solicitud="' .  $row['id_solicitud']  . '"
                    style="background-color:transparent; border:none;">
                    <i class="fa-solid fa-note-sticky fa-lg"></i>
                </button>     
            </td> ';

        echo '<td class="fila" style="background-color:' . $color . ';" data-label="Editar">
        <a href="editSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '" class="btn btn-sm">
            <i class="fa-sharp fa-solid fa-pen-to-square fa-lg"></i>
        </a>
      </td>';
        echo '<td class="fila" style="background-color:' . $color . ';">
                <a href="?delete=' . $row['id_solicitud'] . '" class="btn btn-sm " onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta persona?\')">
                    <i class="fa-solid fa-trash fa-lg"></i>
                </a>
              </td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
}
$paginacion->render();

$mysqli->close();
