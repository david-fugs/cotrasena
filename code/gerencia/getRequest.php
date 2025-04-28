<?php
include("../../conexion.php");

$where = "WHERE estado_solicitud = 2";


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
$query = "
SELECT * FROM solicitudes as s
LEFT JOIN aprobaciones as a ON s.id_solicitud = a.id_solicitud
$where 
ORDER BY fecha_aprobacion DESC
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
    } elseif ($dias > 7 && $dias <= 15) {
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
        $color = getColor(getDiasDesdeSolicitud($row['fecha_aprobacion']));

        echo "<tr>";
        echo '<td class="fila"  style="background-color:' . $color . ';">' . $row['cedula_aso'] . '</td>';
        echo '<td  class="fila" style="background-color:' . $color . ';">' . $row['nombre_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['monto_sol'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['linea_cred_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['observacion_aprobacion'] . '</td>';
        echo '<td  class="fila"style="background-color:' . $color . ';">' . $row['fecha_aprobacion'] . '</td>';
        echo '
        <td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
            <button type="button" class="btn-edit" 
                data-bs-toggle="modal" data-bs-target="#modalObservacion"
                 data-id_aprobacion="' .  $row['id_aprobacion']  . '"
                style="background-color:transparent; margin-left:45px; border:none;">
                <i class="fa-solid fa-note-sticky fa-lg"></i>
            </button>     
        </td> ';

        echo '<td class="fila" style="background-color:' . $color . ';" data-label="Estado" style="">
                <a href="../asoc/updateEstadoSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '&estado_solicitud=3" class="btn " style="" onclick="return confirm(\'¿Estás seguro de Enviar a Gerencia?\')">
                        <i class="fas fa-rotate-right fa-lg"></i> 
                    </a>
                  </td>';

        echo '<td data-label="Editar" style="background-color:' . $color . ';" class="fila" >
                <button type="button" class="btn-edit" 
                        data-bs-toggle="modal" data-bs-target="#modalDevolverSolicitud"
                        data-id_aprobacion="' .  $row['id_aprobacion']  . '"
                        style="background-color:transparent; margin-top:3px; border:none;">
                        <i class="fas fa-rotate-left fa-lg"></i>
                    </button>     
                </td> ';

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
