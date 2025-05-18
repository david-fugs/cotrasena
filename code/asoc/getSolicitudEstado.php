<?php
include("../../conexion.php");
require_once("../../zebra.php");

$where = "WHERE 1 = 1";


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
       s.observacion_solicitud, d.observacion_devolucion, s.estado_solicitud
FROM solicitudes AS s
LEFT JOIN devoluciones AS d ON s.id_solicitud = d.id_solicitud
$where
ORDER BY 
    CASE WHEN s.fecha_observacion IS NOT NULL THEN 0 ELSE 1 END,
    s.estado_solicitud DESC,
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
    } elseif ($dias > 7 && $dias <= 15) {
        return "#fff3cd"; // amarillo suave
    } else {
        return "#f8d7da"; // rojo suave
    }
}
function nombreEstado($estado)
{
    switch ($estado) {
        case '1':
            return "Ingresada";
        case '2':
            return "Aprobada";
        case '3':
            return "En Gerencia";
        case '4':
            return "Aprobada Gerencia";
    }
}

if ($result->num_rows > 0) {
    $color = "";
    while ($row = $result->fetch_assoc()) {



        echo "<tr>";

        echo '<td class="fila"  style="background-color:' . $color . ';">' . $row['cedula_aso'] . '</td>';
        echo '<td  class="fila" style="background-color:' . $color . ';">' . $row['nombre_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['monto_sol'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['linea_cred_aso'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . $row['observacion_solicitud'] . '</td>';
        echo '<td  class="fila"style="background-color:' . $color . ';">' . $row['fecha_alta_solicitud'] . '</td>';
        echo '<td class="fila" style="background-color:' . $color . ';">' . nombreEstado($row['estado_solicitud']) . '</td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
}
$paginacion->render();

$mysqli->close();
