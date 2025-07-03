<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');

// Verificar que se recibió el ID de solicitud
if (!isset($_GET['id_solicitud'])) {
    die('ID de solicitud no proporcionado');
}

$id_solicitud = intval($_GET['id_solicitud']);

// Consulta para obtener los datos de la solicitud
$query = "SELECT s.*, a.id_usu as atendido_por FROM solicitudes as s
LEFT JOIN atenciones as a ON s.id_solicitud = a.id_solicitud
WHERE s.id_solicitud = $id_solicitud";
$result = $mysqli->query($query);

if ($result->num_rows == 0) {
    die('Solicitud no encontrada');
}

$datos_solicitud = $result->fetch_assoc();

// Función para limpiar valores numéricos (solo números)
function cleanNumericValue($value) {
    if (empty($value) || $value == 0) {
        return '';
    }
    // Remover caracteres no numéricos excepto punto decimal
    $cleaned = preg_replace('/[^0-9.]/', '', $value);
    // Convertir a número y devolver como string sin formato
    return $cleaned;
}

// Función para limpiar el campo plazo (remover MESES o meses)
function cleanPlazoValue($value) {
    if (empty($value)) {
        return '';
    }
    // Remover "MESES", "meses", "Meses" y cualquier variación, con o sin espacios
    $cleaned = preg_replace('/\s*meses\s*/i', '', $value);
    // Remover espacios al inicio y final
    $cleaned = trim($cleaned);
    // Extraer solo los números
    $cleaned = preg_replace('/[^0-9]/', '', $cleaned);
    return $cleaned;
}

// Función para formatear moneda
function formatCurrency($value) {
    if (empty($value) || $value == 0) {
        return '';
    }
    return number_format($value, 0, ',', '.');
}

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar estilos
$headerStyle = [
    'font' => [
        'bold' => true,
        'size' => 10,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '366092'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

$dataStyle = [
    'font' => [
        'size' => 9,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

// Definir las columnas según tu especificación
$columnas = [
    'Fecha Solicitud:',
    'Tipo deudor:',
    'Monto solicitado:',
    'Plazo:',
    'Línea crédito:',
    'Apellido asociado:',
    'Nombre asociado:',
    'Tipo de documento',
    'Cédula No.:',
    'Fecha expedición:',
    'Ciudad expedición:',
    'Ciudad nacimiento:',
    'Fecha nacimiento:',
    'Edad',
    'Sexo',
    'Nacionalidad',
    'Estado Civil',
    'Personas a cargo',
];

// Crear el array de datos correspondiente a las columnas
$datos = [
    $datos_solicitud['fecha_sol'] ?? '',
    $datos_solicitud['tipo_deudor_aso'] ?? '',
    formatCurrency($datos_solicitud['monto_sol'] ?? ''),
    cleanPlazoValue($datos_solicitud['plazo_sol'] ?? ''), // Aplicar limpieza para remover MESES
    $datos_solicitud['linea_cred_aso'] ?? '',
    '', // Apellido asociado (separar del nombre si es necesario)
    $datos_solicitud['nombre_aso'] ?? '',
    $datos_solicitud['tipo_doc_aso'] ?? '',
    $datos_solicitud['cedula_aso'] ?? '',
    $datos_solicitud['fecha_exp_doc_aso'] ?? '',
    $datos_solicitud['ciudad_exp_cedula_aso'] ?? '',
    $datos_solicitud['ciudad_naci_aso'] ?? '',
    $datos_solicitud['fecha_nacimiento_aso'] ?? '',
    $datos_solicitud['edad_aso'] ?? '',
    $datos_solicitud['sexo_aso'] ?? '',
    $datos_solicitud['nacionalidad_aso'] ?? '',
    $datos_solicitud['estado_civil_aso'] ?? '',
    $datos_solicitud['per_cargo_aso'] ?? '',
];

// Escribir encabezados en la primera fila
$col = 1;
foreach ($columnas as $columna) {
    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
    $sheet->setCellValue($columnLetter . '1', $columna);
    $sheet->getStyle($columnLetter . '1')->applyFromArray($headerStyle);
    $col++;
}

// Escribir datos en la segunda fila
$col = 1;
foreach ($datos as $dato) {
    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
    $sheet->setCellValue($columnLetter . '2', $dato);
    $sheet->getStyle($columnLetter . '2')->applyFromArray($dataStyle);
    $col++;
}

// Ajustar ancho de columnas automáticamente
for ($i = 1; $i <= count($columnas); $i++) {
    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
    $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
}

// Configurar bordes para las celdas con datos
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

$lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($columnas));
$sheet->getStyle("A1:{$lastColumn}2")->applyFromArray($styleArray);

// Nombre del archivo
$fechaActual = date('d-m-Y');
$nombreArchivo = 'Solicitud_' . $datos_solicitud['cedula_aso'] . '_' . $fechaActual . '.xlsx';

// Crear el writer
$writer = new Xlsx($spreadsheet);

// Configurar headers para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');

// Generar y enviar el archivo
$writer->save('php://output');

// Cerrar conexión
$mysqli->close();
exit;
?>
