<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

session_start();

// Verificar que el usuario está autenticado
if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');

$fechaInicial = $_GET['fechaInicial'] ?? '';
$fechaFinal = $_GET['fechaFinal'] ?? '';

if (empty($fechaInicial) || empty($fechaFinal)) {
    die('Fechas inicial y final son requeridas');
}

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar estilos profesionales
$titleStyle = [
    'font' => [
        'bold' => true,
        'size' => 16,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '1F4E79'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THICK,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

$sectionHeaderStyle = [
    'font' => [
        'bold' => true,
        'size' => 12,
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
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

$columnHeaderStyle = [
    'font' => [
        'bold' => true,
        'size' => 10,
        'color' => ['rgb' => '1F4E79'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D9E1F2'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '4472C4'],
        ],
    ],
];

$dataStyle = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC'],
        ],
    ],
];

$currencyStyle = [
    'numberFormat' => [
        'formatCode' => '"$"#,##0',
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_RIGHT,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC'],
        ],
    ],
];

// Función para formatear números como moneda
function formatCurrency($value) {
    if (empty($value) || $value == 0) {
        return '';
    }
    return '$' . number_format($value, 0, ',', '.');
}

function estadoSolicitud($estado) {
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

// Consulta SQL organizada por secciones
$sql = "SELECT 
-- INFORMACIÓN GENERAL DE LA SOLICITUD
s.id_solicitud AS 'ID Solicitud',
s.fecha_sol AS 'Fecha Solicitud',
s.fecha_alta_solicitud AS 'Fecha Alta',
s.fecha_edit_solicitud AS 'Fecha Edición',
s.estado_solicitud AS 'Estado',
s.observacion_solicitud AS 'Observación',
s.fecha_observacion AS 'Fecha Observación',
s.fecha_devolucion AS 'Fecha Devolución',
s.fecha_devolucion_gerencia AS 'Fecha Devolución Gerencia',

-- DATOS PERSONALES DEL ASOCIADO
s.tipo_doc_aso AS 'Tipo Documento',
s.cedula_aso AS 'Cédula',
s.nombre_aso AS 'Nombre Completo',
s.fecha_exp_doc_aso AS 'Fecha Expedición Doc',
s.pais_exp_cedula_aso AS 'País Expedición',
s.dpto_exp_cedula_aso AS 'Depto Expedición',
s.ciudad_exp_cedula_aso AS 'Ciudad Expedición',
s.fecha_nacimiento_aso AS 'Fecha Nacimiento',
s.pais_naci_aso AS 'País Nacimiento',
s.dpto_naci_aso AS 'Depto Nacimiento',
s.ciudad_naci_aso AS 'Ciudad Nacimiento',
s.edad_aso AS 'Edad',
s.sexo_aso AS 'Sexo',
s.nacionalidad_aso AS 'Nacionalidad',
s.estado_civil_aso AS 'Estado Civil',
s.per_cargo_aso AS 'Personas a Cargo',

-- DATOS DE RESIDENCIA
s.direccion_aso AS 'Dirección',
s.tip_vivienda_aso AS 'Tipo Vivienda',
s.barrio_aso AS 'Barrio',
s.ciudad_aso AS 'Ciudad',
s.departamente_aso AS 'Departamento',
s.estrato_aso AS 'Estrato',

-- DATOS DE CONTACTO
s.email_aso AS 'Email',
s.tel_aso AS 'Teléfono',
s.cel_aso AS 'Celular',

-- INFORMACIÓN EDUCATIVA
s.nivel_educa_aso AS 'Nivel Educativo',
s.titulo_obte_aso AS 'Título Obtenido',
s.titulo_pos_aso AS 'Título Posgrado',

-- INFORMACIÓN CREDITICIA
s.tipo_deudor_aso AS 'Tipo Deudor',
s.monto_sol AS 'Monto Solicitado',
s.plazo_sol AS 'Plazo Solicitado',
s.otro_plazo_sol AS 'Otro Plazo',
s.linea_cred_aso AS 'Línea Crédito',

-- INFORMACIÓN LABORAL
s.ocupacion_sol AS 'Ocupación',
s.func_estad_sol AS 'Funcionario Estado',
s.emp_labo_sol AS 'Empresa Laboral',
s.nit_emp_labo_sol AS 'NIT Empresa',
s.act_emp_labo_sol AS 'Actividad Empresa',
s.dir_emp_sol AS 'Dirección Empresa',
s.ciudad_emp_sol AS 'Ciudad Empresa',
s.depar_emp_sol AS 'Departamento Empresa',
s.tel_emp_sol AS 'Teléfono Empresa',
s.fecha_ing_emp_sol AS 'Fecha Ingreso Empresa',
s.anti_emp_sol AS 'Antigüedad Años',
s.anti_emp_mes_sol AS 'Antigüedad Meses',
s.cargo_actual_emp_sol AS 'Cargo Actual',
s.area_trabajo_sol AS 'Área Trabajo',
s.acti_inde_sol AS 'Actividad Independiente',
s.num_emple_emp_sol AS 'Número Empleados',
s.salario_sol AS 'Salario',

-- INFORMACIÓN DE INGRESOS
s.ing_arri_sol AS 'Ingresos Arriendos',
s.honorarios_sol AS 'Honorarios',
s.pension_sol AS 'Pensión',
s.otros_ing_sol AS 'Otros Ingresos',

-- INFORMACIÓN DE GASTOS
s.cuota_pres_sol AS 'Cuota Préstamo',
s.cuota_tar_cred_sol AS 'Cuota Tarjeta Crédito',
s.arrendo_sol AS 'Arriendo',
s.gastos_fam_sol AS 'Gastos Familiares',
s.otros_gastos_sol AS 'Otros Gastos',

-- ACTIVOS
s.ahorro_banco_sol AS 'Ahorro Banco',
s.vehiculo_sol AS 'Vehículo',
s.bienes_raices_sol AS 'Bienes Raíces',
s.otros_activos_sol AS 'Otros Activos',
s.ahorros_sol AS 'Ahorros',
s.otro_ahorros_sol AS 'Otros Ahorros',
s.valor_ahor_sol AS 'Valor Ahorros',
s.enseres_sol AS 'Enseres',
s.valor_enser_sol AS 'Valor Enseres',

-- PASIVOS
s.presta_total_sol AS 'Total Préstamos',
s.hipotecas_sol AS 'Hipotecas',
s.tar_cred_total_sol AS 'Total Tarjetas Crédito',
s.otros_pasivos_sol AS 'Otros Pasivos',

-- INFORMACIÓN DEL CÓNYUGE
s.conyu_nombre_sol AS 'Cónyuge Nombre',
s.conyu_cedula_sol AS 'Cónyuge Cédula',
s.conyu_naci_sol AS 'Cónyuge F. Nacimiento',
s.conyu_exp_sol AS 'Cónyuge F. Expedición',
s.conyu_ciudadn_sol AS 'Cónyuge Ciudad Nac',
s.conyu_dpton_sol AS 'Cónyuge Depto Nac',
s.conyu_paism_sol AS 'Cónyuge País Nac',
s.conyu_correo_sol AS 'Cónyuge Correo',
s.conyu_ocupacion_sol AS 'Cónyuge Ocupación',
s.conyu_func_sol AS 'Cónyuge Funcionario',
s.conyu_emp_lab_sol AS 'Cónyuge Empresa',
s.conyu_cargo_sol AS 'Cónyuge Cargo',
s.conyu_salario_sol AS 'Cónyuge Salario',
s.conyu_dir_lab_sol AS 'Cónyuge Dir Laboral',
s.conyu_tel_lab_sol AS 'Cónyuge Tel Laboral',
s.conyu_ciudad_lab_sol AS 'Cónyuge Ciudad Lab',
s.conyu_dpto_lab_sol AS 'Cónyuge Depto Lab',

-- REFERENCIAS FAMILIARES
s.fami_nombre_1_sol AS 'Familiar 1 Nombre',
s.fami_cel_1_sol AS 'Familiar 1 Celular',
s.fami_tel_1_sol AS 'Familiar 1 Teléfono',
s.fami_parent_1_sol AS 'Familiar 1 Parentesco',
s.fami_nombre_2_sol AS 'Familiar 2 Nombre',
s.fami_cel_2_sol AS 'Familiar 2 Celular',
s.fami_tel_2_sol AS 'Familiar 2 Teléfono',
s.fami_parent_2_sol AS 'Familiar 2 Parentesco',

-- REFERENCIAS COMERCIALES
s.refer_nombre_1_sol AS 'Referencia 1 Nombre',
s.refer_cel_1_sol AS 'Referencia 1 Celular',
s.refer_tel_1_sol AS 'Referencia 1 Teléfono',
s.refer_nombre_2_sol AS 'Referencia 2 Nombre',
s.refer_cel_2_sol AS 'Referencia 2 Celular',
s.refer_tel_2_sol AS 'Referencia 2 Teléfono',

-- INFORMACIÓN DE VEHÍCULOS (CONCATENADA)
GROUP_CONCAT(DISTINCT CONCAT_WS(' | ', 
    CONCAT('Tipo: ', COALESCE(v.tipo, '')),
    CONCAT('Marca: ', COALESCE(v.marca, '')),
    CONCAT('Modelo: ', COALESCE(v.modelo, '')),
    CONCAT('Placa: ', COALESCE(v.placa, '')),
    CONCAT('Valor: $', FORMAT(COALESCE(v.valor_comercial, 0), 0))
) SEPARATOR ' || ') AS 'Vehículos Información',

-- INFORMACIÓN DE INMUEBLES (CONCATENADA)
GROUP_CONCAT(DISTINCT CONCAT_WS(' | ',
    CONCAT('Tipo: ', COALESCE(i.tipo, '')),
    CONCAT('Dirección: ', COALESCE(i.direccion, '')),
    CONCAT('Valor: $', FORMAT(COALESCE(i.valor_comercial, 0), 0))
) SEPARATOR ' || ') AS 'Inmuebles Información'

FROM solicitudes as s
LEFT JOIN atenciones as a ON s.id_solicitud = a.id_solicitud
LEFT JOIN aprobaciones as ap ON s.id_solicitud = ap.id_solicitud
LEFT JOIN gerencia as g ON s.id_solicitud = g.id_solicitud
LEFT JOIN vehiculos as v ON s.id_solicitud = v.id_solicitud
LEFT JOIN inmuebles as i ON i.id_solicitud = s.id_solicitud
WHERE s.fecha_alta_solicitud BETWEEN '$fechaInicial' AND '$fechaFinal'
GROUP BY s.id_solicitud
ORDER BY s.fecha_alta_solicitud DESC";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);

// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}

// Configurar título principal
$fechaFormateada = date('d/m/Y', strtotime($fechaInicial)) . ' - ' . date('d/m/Y', strtotime($fechaFinal));
$titulo = "REPORTE DE SOLICITUDES - PERÍODO: " . $fechaFormateada;

$sheet->setCellValue('A1', $titulo);
$sheet->mergeCells('A1:N1'); // Merge cells para el título
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->getRowDimension(1)->setRowHeight(30);

// Definir grupos de columnas con sus rangos
$columnGroups = [
    ['start' => 'A', 'end' => 'I', 'title' => 'INFORMACIÓN GENERAL'],
    ['start' => 'J', 'end' => 'W', 'title' => 'DATOS PERSONALES'],
    ['start' => 'X', 'end' => 'AD', 'title' => 'RESIDENCIA Y CONTACTO'],
    ['start' => 'AE', 'end' => 'AG', 'title' => 'EDUCACIÓN'],
    ['start' => 'AH', 'end' => 'AM', 'title' => 'INFORMACIÓN CREDITICIA'],
    ['start' => 'AN', 'end' => 'AZ', 'title' => 'INFORMACIÓN LABORAL'],
    ['start' => 'BA', 'end' => 'BE', 'title' => 'INGRESOS'],
    ['start' => 'BF', 'end' => 'BJ', 'title' => 'GASTOS'],
    ['start' => 'BK', 'end' => 'BS', 'title' => 'ACTIVOS'],
    ['start' => 'BT', 'end' => 'BW', 'title' => 'PASIVOS'],
    ['start' => 'BX', 'end' => 'CM', 'title' => 'INFORMACIÓN CÓNYUGE'],
    ['start' => 'CN', 'end' => 'CU', 'title' => 'REFERENCIAS FAMILIARES'],
    ['start' => 'CV', 'end' => 'DA', 'title' => 'REFERENCIAS COMERCIALES'],
    ['start' => 'DB', 'end' => 'DC', 'title' => 'VEHÍCULOS E INMUEBLES']
];

// Aplicar headers de grupo en la fila 2
$currentRow = 2;
foreach ($columnGroups as $group) {
    $range = $group['start'] . $currentRow . ':' . $group['end'] . $currentRow;
    $sheet->mergeCells($range);
    $sheet->setCellValue($group['start'] . $currentRow, $group['title']);
    $sheet->getStyle($range)->applyFromArray($sectionHeaderStyle);
}

// Ajustar altura de fila para headers de grupo
$sheet->getRowDimension($currentRow)->setRowHeight(25);

// Obtener datos
$dataRows = [];
if (mysqli_num_rows($res) > 0) {
    $firstRow = mysqli_fetch_assoc($res);
    $columnNames = array_keys($firstRow);
    
    // Escribir encabezados de columna en la fila 3
    $currentRow = 3;
    $colIndex = 1;
    foreach ($columnNames as $colName) {
        $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($columnLetter . $currentRow, $colName);
        $colIndex++;
    }
    
    // Aplicar estilo a los encabezados de columna
    $lastColumn = Coordinate::stringFromColumnIndex(count($columnNames));
    $headerRange = 'A' . $currentRow . ':' . $lastColumn . $currentRow;
    $sheet->getStyle($headerRange)->applyFromArray($columnHeaderStyle);
    $sheet->getRowDimension($currentRow)->setRowHeight(40);
    
    // Procesar datos
    $dataRows = [$firstRow];
    while ($row = mysqli_fetch_assoc($res)) {
        $dataRows[] = $row;
    }
    
    // Escribir datos a partir de la fila 4
    $currentRow = 4;
    foreach ($dataRows as $rowData) {
        $colIndex = 1;
        foreach ($rowData as $columnName => $value) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
            
            // Formatear valores especiales
            if (strpos($columnName, 'Estado') !== false && $columnName === 'Estado') {
                $value = estadoSolicitud($value);
            }
            
            // Detectar campos monetarios y formatear
            $monetaryFields = ['Monto Solicitado', 'Salario', 'Ingresos Arriendos', 'Honorarios', 
                              'Pensión', 'Otros Ingresos', 'Cuota Préstamo', 'Cuota Tarjeta Crédito',
                              'Arriendo', 'Gastos Familiares', 'Otros Gastos', 'Ahorro Banco',
                              'Bienes Raíces', 'Otros Activos', 'Valor Ahorros', 'Valor Enseres',
                              'Total Préstamos', 'Hipotecas', 'Total Tarjetas Crédito', 'Otros Pasivos',
                              'Cónyuge Salario'];
            
            if (in_array($columnName, $monetaryFields) && !empty($value) && is_numeric($value)) {
                $sheet->setCellValue($columnLetter . $currentRow, $value);
                $sheet->getStyle($columnLetter . $currentRow)->applyFromArray($currencyStyle);
            } else {
                $sheet->setCellValue($columnLetter . $currentRow, $value);
                $sheet->getStyle($columnLetter . $currentRow)->applyFromArray($dataStyle);
            }
            
            $colIndex++;
        }
        $currentRow++;
    }
}

// Configurar ancho de columnas
$totalColumns = count($columnNames ?? []);
for ($col = 1; $col <= max($totalColumns, 120); $col++) {
    $colLetter = Coordinate::stringFromColumnIndex($col);
    
    // Ajustar ancho específico para diferentes tipos de columnas
    if ($col <= 9) { // Información general
        $sheet->getColumnDimension($colLetter)->setWidth(18);
    } elseif ($col <= 30) { // Datos personales
        $sheet->getColumnDimension($colLetter)->setWidth(15);
    } elseif (in_array($col, [31, 32, 33])) { // Direcciones
        $sheet->getColumnDimension($colLetter)->setWidth(25);
    } else { // Resto de columnas
        $sheet->getColumnDimension($colLetter)->setWidth(16);
    }
}

// Aplicar bordes a toda la tabla
if (!empty($dataRows)) {
    $lastColumn = Coordinate::stringFromColumnIndex(count($columnNames));
    $lastRow = 3 + count($dataRows);
    $tableRange = 'A1:' . $lastColumn . $lastRow;
    
    $sheet->getStyle($tableRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => 'CCCCCC'],
            ],
        ],
    ]);
}

// Configurar nombre de archivo con fecha actual
$fechaActual = date('d-m-Y_H-i');
$nombreArchivo = 'Reporte_Solicitudes_' . $fechaInicial . '_al_' . $fechaFinal . '_' . $fechaActual . '.xlsx';

// Crear el writer y configurar headers de descarga
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');

// Generar y descargar el archivo
$writer->save('php://output');
exit;
