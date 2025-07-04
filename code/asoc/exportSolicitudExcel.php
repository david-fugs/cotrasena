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

// Obtener datos de inmuebles
$query_inmuebles = "SELECT * FROM inmuebles WHERE id_solicitud = $id_solicitud ORDER BY id";
$result_inmuebles = $mysqli->query($query_inmuebles);
$inmuebles = [];
while ($row = $result_inmuebles->fetch_assoc()) {
    $inmuebles[] = $row;
}

// Obtener datos de vehículos
$query_vehiculos = "SELECT * FROM vehiculos WHERE id_solicitud = $id_solicitud ORDER BY id";
$result_vehiculos = $mysqli->query($query_vehiculos);
$vehiculos = [];
while ($row = $result_vehiculos->fetch_assoc()) {
    $vehiculos[] = $row;
}

// Determinar la cantidad máxima de inmuebles y vehículos para las columnas
$max_inmuebles = max(count($inmuebles), 2); // Mínimo 2 para mantener compatibilidad
$max_vehiculos = max(count($vehiculos), 2); // Mínimo 2 para mantener compatibilidad

// Función para limpiar valores numéricos (solo números)
function cleanNumericValue($value) {
    if (empty($value) || $value == 0) {
        return '0';
    }
    // Remover caracteres no numéricos excepto punto decimal
    $cleaned = preg_replace('/[^0-9.]/', '', $value);
    // Convertir a número y devolver como string sin formato
    return (string)floatval($cleaned);
}

// Función para limpiar el campo plazo (remover MESES o meses)
function cleanPlazoValue($value) {
    if (empty($value)) {
        return '';
    }
    // Extraer solo los números (esto eliminará MESES, meses, espacios, etc.)
    $cleaned = preg_replace('/[^0-9]/', '', $value);
    return $cleaned;
}

// Función para formatear moneda
function formatCurrency($value) {
    if (empty($value) || $value == 0) {
        return '0';
    }
    // Devolver solo el número sin formato (sin comas ni puntos separadores)
    return (string)floatval($value);
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
    'Tipo de vivienda',
    'Dirección',
    'Barrio',
    'Ciudad',
    'Departamento',
    'Estrato',
    'Email',
    'Teléfono',
    'Celular',
    'Nivel educativo',
    'Titulo obtenido',
    'Titulo en posgrado',
    'Ocupación',
    '¿Funcionario del Estado?',
    'Empresa donde labora',
    'Nit empresa',
    'Actividad de la empresa',
    'Dirección de la empresa',
    'Ciudad',
    'Departamento',
    'Teléfono de la empresa',
    'Fecha de ingreso',
    'Antigüedad',
    'Cargo actual',
    'Área o dependencia de trabajo',
    'Describa brevemente su actividad como INDEPENDIENTE',
    'Número de empleados de su empresa',
    'Salario',
    'Ingresos por arrendamiento',
    'Honorarios',
    'Pensión',
    'Otros Ingresos',
    'Cuota Préstamos',
    'Cuota Tarjetas de Crédito',
    'Egreso por Arrendamiento',
    'Gastos familiares',
    'Otros gastos',
    'Bancos (Ahorros, Aportes, Inversiones)',
    'Vehículos (Valor comercial)',
    'Bienes raíces (Valor comercial)',
    'Otros activos (Ejemplo: Muebles, enseres, equipos)',
    'Capital de prestamos',
    'Hipotecas',
    'Tarjetas de crédito (Deuda total)',
    'Otros pasivos',
    'Tipo de Inmueble 1',
    'Dirección 1',
    'Valor comercial 1',
    'Tipo de inmueble 2',
    'Dirección 2',
    'Valor Comercial 2',
    'Tipo de vehículo 1',
    'Modelo 1',
    'Marca 1',
    'Placa 1',
    'Valor comercial 1',
    'Tipo de vehículo 2',
    'Modelo 2',
    'Marca 2',
    'Placa 2',
    'Valor comercial 2',
    'Tipo 1 (CDT, CARTERA, INVERSIONES, CUENTAS, APORTES, OTROS)',
    'Valor comercial Tipo 1',
    'Tipo 2 (MUEBLES, ENSERES, EQUIPOS)',
    'Valor comercial Tipo 2',
    'Nombre completo del cónyuge',
    'Documento identificación (ID) del cónyuge',
    'Ciudad de expedición ID del cónyuge',
    'Fecha nacimiento del cónyuge',
    'País, Departamento, Ciudad de nacimiento del cónyuge',
    'Correo electrónico del cónyuge',
    'Ocupación del cónyuge',
    '¿Su cónyuge es funcionario del estado?',
    'Nombre de la empresa donde labora el cónyuge',
    'Cargo del cónyuge',
    'Salario del cónyuge',
    'Dirección empresa donde labora el cónyuge',
    'Teléfono fijo empresa donde labora el cónyuge',
    'Ciudad donde labora el cónyuge',
    'Departamento donde labora el cónyuge',
    'Nombre Completo',
    'Celular',
    'Teléfono Fijo',
    'Parentesco',
    'Nombre Completo',
    'Celular',
    'Teléfono Fijo',
    'Parentesco',
    'Nombre Completo',
    'Celular',
    'Teléfono Fijo',
    'Nombre Completo',
    'Celular',
    'Teléfono fijo',
    'Términos de uso',
    'BANCOS (ahorros, aportes, Inversiones)',
    'BANCOS (AHORROS, APORTES, CDT)'
];

// Crear el array de datos correspondiente a las columnas
$datos = [
    $datos_solicitud['fecha_alta_solicitud'] ?? '',
    $datos_solicitud['tipo_deudor_aso'] ?? '',
    formatCurrency($datos_solicitud['monto_sol'] ?? ''),
    cleanPlazoValue($datos_solicitud['plazo_sol']) ?? '',
    $datos_solicitud['linea_cred_aso'] ?? '',
    '', // Apellido asociado - no existe campo específico
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
    $datos_solicitud['tip_vivienda_aso'] ?? '',
    $datos_solicitud['direccion_aso'] ?? '',
    $datos_solicitud['barrio_aso'] ?? '',
    $datos_solicitud['ciudad_aso'] ?? '',
    $datos_solicitud['departamente_aso'] ?? '',
    $datos_solicitud['estrato_aso'] ?? '',
    $datos_solicitud['email_aso'] ?? '',
    $datos_solicitud['tel_aso'] ?? '',
    $datos_solicitud['cel_aso'] ?? '',
    $datos_solicitud['nivel_educa_aso'] ?? '',
    $datos_solicitud['titulo_obte_aso'] ?? '',
    $datos_solicitud['titulo_pos_aso'] ?? '',
    $datos_solicitud['ocupacion_sol'] ?? '',
    $datos_solicitud['func_estad_sol'] ?? '',
    $datos_solicitud['emp_labo_sol'] ?? '',
    $datos_solicitud['nit_emp_labo_sol'] ?? '',
    $datos_solicitud['act_emp_labo_sol'] ?? '',
    $datos_solicitud['dir_emp_sol'] ?? '',
    $datos_solicitud['ciudad_emp_sol'] ?? '',
    $datos_solicitud['depar_emp_sol'] ?? '',
    $datos_solicitud['tel_emp_sol'] ?? '',
    $datos_solicitud['fecha_ing_emp_sol'] ?? '',
    ($datos_solicitud['anti_emp_sol'] ?? '') . ' años ' . ($datos_solicitud['anti_emp_mes_sol'] ?? '') . ' meses',
    $datos_solicitud['cargo_actual_emp_sol'] ?? '',
    $datos_solicitud['area_trabajo_sol'] ?? '',
    $datos_solicitud['acti_inde_sol'] ?? '',
    $datos_solicitud['num_emple_emp_sol'] ?? '',
    formatCurrency($datos_solicitud['salario_sol'] ?? ''),
    formatCurrency($datos_solicitud['ing_arri_sol'] ?? ''),
    formatCurrency($datos_solicitud['honorarios_sol'] ?? ''),
    formatCurrency($datos_solicitud['pension_sol'] ?? ''),
    formatCurrency($datos_solicitud['otros_ing_sol'] ?? ''),
    formatCurrency($datos_solicitud['cuota_pres_sol'] ?? ''),
    formatCurrency($datos_solicitud['cuota_tar_cred_sol'] ?? ''),
    formatCurrency($datos_solicitud['arrendo_sol'] ?? ''),
    formatCurrency($datos_solicitud['gastos_fam_sol'] ?? ''),
    formatCurrency($datos_solicitud['otros_gastos_sol'] ?? ''),
    formatCurrency($datos_solicitud['ahorro_banco_sol'] ?? ''),
    formatCurrency($datos_solicitud['vehiculo_sol'] ?? ''),
    formatCurrency($datos_solicitud['bienes_raices_sol'] ?? ''),
    formatCurrency($datos_solicitud['otros_activos_sol'] ?? ''),
    formatCurrency($datos_solicitud['presta_total_sol'] ?? ''),
    formatCurrency($datos_solicitud['hipotecas_sol'] ?? ''),
    formatCurrency($datos_solicitud['tar_cred_total_sol'] ?? ''),
    formatCurrency($datos_solicitud['otros_pasivos_sol'] ?? ''),
    // Datos de inmuebles desde tabla inmuebles
    $inmuebles[0]['tipo'] ?? '',
    $inmuebles[0]['direccion'] ?? '',
    formatCurrency($inmuebles[0]['valor_comercial'] ?? ''),
    $inmuebles[1]['tipo'] ?? '',
    $inmuebles[1]['direccion'] ?? '',
    formatCurrency($inmuebles[1]['valor_comercial'] ?? ''),
    // Datos de vehículos desde tabla vehiculos
    $vehiculos[0]['tipo'] ?? '',
    $vehiculos[0]['modelo'] ?? '',
    $vehiculos[0]['marca'] ?? '',
    $vehiculos[0]['placa'] ?? '',
    formatCurrency($vehiculos[0]['valor_comercial'] ?? ''),
    $vehiculos[1]['tipo'] ?? '',
    $vehiculos[1]['modelo'] ?? '',
    $vehiculos[1]['marca'] ?? '',
    $vehiculos[1]['placa'] ?? '',
    formatCurrency($vehiculos[1]['valor_comercial'] ?? ''),
    $datos_solicitud['ahorros_sol'] ?? '',
    formatCurrency($datos_solicitud['valor_ahor_sol'] ?? ''),
    $datos_solicitud['enseres_sol'] ?? '',
    formatCurrency($datos_solicitud['valor_enser_sol'] ?? ''),
    $datos_solicitud['conyu_nombre_sol'] ?? '',
    $datos_solicitud['conyu_cedula_sol'] ?? '',
    $datos_solicitud['conyu_exp_sol'] ?? '',
    $datos_solicitud['conyu_naci_sol'] ?? '',
    ($datos_solicitud['conyu_paism_sol'] ?? '') . ', ' . ($datos_solicitud['conyu_dpton_sol'] ?? '') . ', ' . ($datos_solicitud['conyu_ciudadn_sol'] ?? ''),
    $datos_solicitud['conyu_correo_sol'] ?? '',
    $datos_solicitud['conyu_ocupacion_sol'] ?? '',
    $datos_solicitud['conyu_func_sol'] ?? '',
    $datos_solicitud['conyu_emp_lab_sol'] ?? '',
    $datos_solicitud['conyu_cargo_sol'] ?? '',
    formatCurrency($datos_solicitud['conyu_salario_sol'] ?? ''),
    $datos_solicitud['conyu_dir_lab_sol'] ?? '',
    $datos_solicitud['conyu_tel_lab_sol'] ?? '',
    $datos_solicitud['conyu_ciudad_lab_sol'] ?? '',
    $datos_solicitud['conyu_dpto_lab_sol'] ?? '',
    $datos_solicitud['fami_nombre_1_sol'] ?? '',
    $datos_solicitud['fami_cel_1_sol'] ?? '',
    $datos_solicitud['fami_tel_1_sol'] ?? '',
    $datos_solicitud['fami_parent_1_sol'] ?? '',
    $datos_solicitud['fami_nombre_2_sol'] ?? '',
    $datos_solicitud['fami_cel_2_sol'] ?? '',
    $datos_solicitud['fami_tel_2_sol'] ?? '',
    $datos_solicitud['fami_parent_2_sol'] ?? '',
    $datos_solicitud['refer_nombre_1_sol'] ?? '',
    $datos_solicitud['refer_cel_1_sol'] ?? '',
    $datos_solicitud['refer_tel_1_sol'] ?? '',
    $datos_solicitud['refer_nombre_2_sol'] ?? '',
    $datos_solicitud['refer_cel_2_sol'] ?? '',
    $datos_solicitud['refer_tel_2_sol'] ?? '',
    '', // Términos de uso - no existe campo
    formatCurrency($datos_solicitud['ahorro_banco_sol'] ?? ''),
    formatCurrency($datos_solicitud['ahorro_banco_sol'] ?? '')
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
