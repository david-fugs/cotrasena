<?php
include("../../conexion.php");

$where = "WHERE estado_solicitud = 3";


// Filtro por cédula
if (!empty($_GET['cedula_persona'])) {
    $cedula = $mysqli->real_escape_string($_GET['cedula_persona']);
    $where .= " AND s.cedula_aso = '$cedula'";
}

// Filtro por nombre
if (!empty($_GET['nombre'])) {
    $nombre = $mysqli->real_escape_string($_GET['nombre']);
    $where .= " AND s.nombres_aso LIKE '%$nombre%'";
}

// Filtro por programa
if (!empty($_GET['credito'])) {
    $credito = $mysqli->real_escape_string($_GET['credito']);
    $where .= " AND s.linea_cred_aso = '$credito'";
}

// Consulta SQL para obtener los datos
$query = " SELECT g.id_gerencia,g.observacion_gerencia,
s.cedula_aso,s.nombre_aso,s.id_solicitud,s.fecha_devolucion,s.fecha_alta_solicitud,s.monto_sol,s.linea_cred_aso,s.observacion_solicitud,s.fecha_devolucion,g.fecha_gerencia FROM solicitudes as s 
LEFT JOIN gerencia as g ON s.id_solicitud = g.id_solicitud
$where
ORDER BY 
    CASE WHEN g.fecha_observacion_gerencia IS NOT NULL THEN 0 ELSE 1 END,
    g.fecha_gerencia DESC 
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
        //dependiendo del estado de la solicitud se asigna la fecha


        //dependiendo de la fecha de solicitud, se asigna un color
        $color = getColor(getDiasDesdeSolicitud($row['fecha_gerencia']));

        echo "<tr>";
        echo '<td class="fila"  style="background-color:' . $color . ';">' . $row['cedula_aso'] . '</td>';
        echo '<td  class="fila" style="background-color:' . $color . ';">' . $row['nombre_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['monto_sol'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['linea_cred_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['observacion_gerencia'] . '</td>';
        echo '<td  class="fila"style="background-color:' . $color . ';">' . $row['fecha_gerencia'] . '</td>';
        echo '
        <td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
            <button type="button" class="btn-edit" 
                data-bs-toggle="modal" data-bs-target="#modalObservacion"
                 data-id_gerencia="' .  $row['id_gerencia']  . '"
                 data-id_solicitud="' .  $row['id_solicitud']  . '"
                style="background-color:transparent;  border:none;">
                <i class="fa-solid fa-note-sticky fa-lg"></i>
            </button>     
        </td> ';
        echo '<td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
                <button type="button" class="btn-edit" 
                        data-bs-toggle="modal" data-bs-target="#modalDevolverSolicitud"
                        data-id_gerencia="' .  $row['id_gerencia']  . '"
                        data-id_solicitud="' .  $row['id_solicitud']  . '"
                        style="background-color:transparent; margin-top:3px; border:none;">
                        <i class="fas fa-rotate-left fa-lg"></i>
                    </button>     
                </td> ';
        echo '<td class="fila" style="background-color:' . $color . ';" data-label="Estado" ">
                        <a href="../asoc/updateEstadoSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '&estado_solicitud=4" class="btn " " onclick="return confirm(\'¿Estás seguro de aprobar esta Solicitud?\')">
                                <i class="fa-solid fa-up-long"></i>
                        </a>
                </td>';
        echo '<td class="fila" style="background-color:' . $color . ';" data-label="Editar">
        <a href="../asoc/editSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '" class="btn btn-sm">
            <i class="fa-sharp fa-solid fa-pen-to-square fa-lg"></i>
        </a>
      </td>';
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
}


$mysqli->close();
