<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
session_start();
include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sql = "SELECT s.*,a.fecha_solicitud as fecha_atencion , a.id_usu as atendido_por FROM solicitudes as s
JOIN atenciones as a ON s.id_solicitud = a.id_solicitud
WHERE a.id_usu = ".$_SESSION['id_usu']." ";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);
// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}
function estadoSolcitiud($estado)
{
    switch ($estado) {
        case 1:
            return 'Registrada';
        case 2:
            return 'Aprobada';
        case 3:
            return 'Gerencia';
        case 4:
            return 'Aprobada Gerencia';
        default:
            return 'Desconocido';
    }
}

// Aplicar color de fondo a las celdas A1 a AL1
$sheet->getStyle('A1:K1')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'ffd880', // Cambia 'CCE5FF' al color deseado en formato RGB
        ],
    ],
]);

// Aplicar formato en negrita a las celdas con títulos
$boldFontStyle = [
    'bold' => true,
];
$sheet->getStyle('A2:K2')->applyFromArray(['font' => $boldFontStyle]);

// Establecer estilos para los encabezados
$styleHeader = [
    'font' => [
        'bold' => true,
        'size' => 20,
        'color' => ['rgb' => '333333'], // Color de texto (negro)
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F2F2F2'], // Color de fondo (gris claro)
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
];

// Aplicar el estilo a las celdas de encabezado
$sheet->getStyle('A1:K1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

// // Definir los encabezados de columna

$sheet->setCellValue('A1', 'TIPO DOCUMENTO');
$sheet->setCellValue('B1', 'CEDULA');
$sheet->setCellValue('C1', 'NOMBRE ASOCIADO');
$sheet->setCellValue('D1', 'DIRECCION');
$sheet->setCellValue('E1', 'FECHA EXPEDICION');
$sheet->setCellValue('F1', 'PAIS EXPEDICION');
$sheet->setCellValue('G1', 'FECHA SOLICITUD');
$sheet->setCellValue('H1', 'FECHA ATENCION');
$sheet->setCellValue('I1', 'LINEA CREDITO');
$sheet->setCellValue('J1', 'MONTO SOLICITADO');
$sheet->setCellValue('K1', 'ESTADO SOLICITUD');

// Ajustar el ancho de las columna

$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(25);
$sheet->getColumnDimension('G')->setWidth(25);
$sheet->getColumnDimension('H')->setWidth(25);
$sheet->getColumnDimension('I')->setWidth(25);
$sheet->getColumnDimension('J')->setWidth(25);
$sheet->getColumnDimension('K')->setWidth(25);   

$sheet->getDefaultRowDimension()->setRowHeight(25);
$nombreEst = '';
$rowIndex = 2;
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $sheet->setCellValue('A'. $rowIndex, $row['tipo_doc_aso']);
    $sheet->setCellValue('B'. $rowIndex, $row['cedula_aso']);
    $sheet->setCellValue('C'. $rowIndex, $row['nombre_aso']);
    $sheet->setCellValue('D'. $rowIndex, $row['direccion_aso']);
    $sheet->setCellValue('E'. $rowIndex, $row['fecha_exp_doc_aso']);
    $sheet->setCellValue('F'. $rowIndex, $row['pais_exp_cedula_aso']);
    $sheet->setCellValue('G'. $rowIndex, $row['fecha_alta_solicitud']);
    $sheet->setCellValue('H'. $rowIndex, $row['fecha_atencion']);
    $sheet->setCellValue('I'. $rowIndex, $row['linea_cred_aso']);
    $sheet->setCellValue('J'. $rowIndex, $row['monto_sol']);
    $sheet->setCellValue('K'. $rowIndex, estadoSolcitiud($row['estado_solicitud']));

     $sheet->getStyle('A' .$rowIndex. ':L'.$rowIndex.'')->applyFromArray(['font' => $boldFontStyle]);
     $rowIndex++;
}
//AÑO y mes actual para el filename
$anio = date('Y');
$mes = date('m');
// Nombre del archivo con la fecha actual
$fechaActual = date('d-m-Y');
$nombreArchivo = 'Solicitudes_' . $fechaActual . '.xlsx';
$writer = new Xlsx($spreadsheet);

//Set the headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');

// Output the generated Excel file to the browser
$writer->save('php://output');
exit;
