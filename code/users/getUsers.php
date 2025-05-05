<?php
include("../../conexion.php");
include("../../zebra.php"); // Asegúrate de que Zebra está correctamente configurado

$nombres = isset($_GET['nombres']) ? trim($_GET['nombres']) : '';
$usuario = isset($_GET['usuario']) ? trim($_GET['usuario']) : '';
$tipo_usu = isset($_GET['tipo_usu']) ? intval($_GET['tipo_usu']) : '';

// Inicializar variables de filtros
$where = "WHERE estado_usu = 1";
$params = [];

// Si hay filtros en GET, agregarlos
if (!empty($_GET['nombres'])) {
    $where .= " AND nombre LIKE ?";
    $params[] = "%" . $_GET['nombres'] . "%";
}
if (!empty($_GET['usuario'])) {
    $where .= " AND usuario LIKE ?";
    $params[] = "%" . $_GET['usuario'] . "%";
}
if (!empty($_GET['tipo_usu'])) {
    $where .= " AND tipo_usu = ?";
    $params[] = $_GET['tipo_usu'];
}

// Consulta total para paginación
$countSql = "SELECT COUNT(*) as total FROM usuarios $where";
$stmt = $mysqli->prepare($countSql);
if (!empty($params)) {
    $types = str_repeat("s", count($params)); // todos como string
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultCount = $stmt->get_result();
$totalRows = $resultCount->fetch_assoc()['total'];

// Configurar Zebra Pagination
$records_per_page = 10;
$pagination = new Zebra_Pagination();
$pagination->records($totalRows);
$pagination->records_per_page($records_per_page);

// Calcular offset
$offset = ($pagination->get_page() - 1) * $records_per_page;

// Consulta paginada
$query = "SELECT * FROM usuarios $where LIMIT ?, ?";
$params[] = $offset;
$params[] = $records_per_page;

$stmt = $mysqli->prepare($query);
$types = str_repeat("s", count($params) - 2) . "ii"; // últimos dos son int para LIMIT
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Opciones de tipo usuario
$opciones = [
    1 => 'Gerente',
    2 => 'Asesor',
    3 => 'Aprobaciones',
    4 => 'Cliente',
];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo '<td class="fila">' . $row['id_usu'] . '</td>';
        echo '<td class="fila">' . $row['nombre'] . '</td>';
        echo '<td class="fila">' . $row['usuario'] . '</td>';

        // Select con opción seleccionada
        echo '<td class="fila"><select disabled name="tipo_usu[]" class="form-select">';
        foreach ($opciones as $valor => $texto) {
            $selected = ($row['tipo_usu'] == $valor) ? 'selected' : '';
            echo "<option value=\"$valor\" $selected>$texto</option>";
        }
        echo '</select></td>';

        echo '<td class="fila">
                <button type="button" class="btn-edit" 
                    data-bs-toggle="modal" data-bs-target="#modalEditar"
                    data-id_usu="' . $row['id_usu'] . '"
                    data-nombres="' . htmlspecialchars($row['nombre']) . '"
                    data-usuario="' . htmlspecialchars($row['usuario']) . '"
                    data-tipo_usu="' . $row['tipo_usu'] . '"
                    style="background-color:transparent; border:none;">
                    <i class="fa-sharp fa-solid fa-pen-to-square fa-lg"></i>
                </button>     
              </td>';

        echo '<td class="fila">
                <a href="?delete=' . $row['id_usu'] . '" class="btn btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta persona?\')">
                    <i class="fa-solid fa-trash fa-lg"></i>
                </a>
              </td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No se encontraron registros.</td></tr>";
}

// Mostrar paginación
$pagination->render();

$mysqli->close();
