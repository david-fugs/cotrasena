<?php
session_start();
include("../../conexion.php");
$where = "WHERE estado_solicitud = 1";

// Filtro por cédula
if (!empty($_GET['cedula_persona'])) {
    $cedula = $mysqli->real_escape_string($_GET['cedula_persona']);
    $where .= " AND cedula_aso = '$cedula'";
}

// Filtro por nombre
if (!empty($_GET['nombre'])) {
    $nombre = $mysqli->real_escape_string($_GET['nombre']);
    $where .= " AND nombres_aso LIKE '%$nombre%'";
}

// Filtro por programa
if (!empty($_GET['credito'])) {
    $credito = $mysqli->real_escape_string($_GET['credito']);
    $where .= " AND linea_cred_aso = '$credito'";
}

// Consulta SQL para obtener los datos
$query = "
SELECT * FROM solicitudes
$where 


";
$result = $mysqli->query($query);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       
        echo "<tr>";
        echo "<td>" . $row['cedula_aso'] . "</td>";
        echo "<td>" . $row['nombre_aso'] . "</td>";
        echo "<td>" . $row['monto_sol'] . "</td>";
        echo "<td>" . $row['linea_cred_aso'] . "</td>";
        echo "<td>" . $row['fecha_alta_solicitud'] . "</td>";
        //edit
        echo '
            <td data-label="Editar">
                <a href="editSolicitud.php?id_solicitud=' . $row['id_solicitud'] . '" class="btn btn-sm btn-warning">
                    <img src="../../img/editar.png" width="20" height="20" alt="Editar">
                </a>
          
            </td> ';
        //delete
        echo '
        <td>
                <a href="?delete=' . $row['id_solicitud'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta persona?\')">
                    <img src="../../img/delete1.png" width="20" height="20" alt="Eliminar">
                </a>
            </td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
}


$mysqli->close();
