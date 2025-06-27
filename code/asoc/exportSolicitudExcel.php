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

// Consultar inmuebles relacionados (usando columnas que existen en la tabla)
$query_inmuebles = "SELECT tipo, direccion, valor_comercial 
                    FROM inmuebles WHERE id_solicitud = $id_solicitud";
$result_inmuebles = $mysqli->query($query_inmuebles);

// Consultar vehículos relacionados (usando columnas que existen en la tabla)
$query_vehiculos = "SELECT tipo, marca, modelo, placa, valor_comercial 
                    FROM vehiculos WHERE id_solicitud = $id_solicitud";
$result_vehiculos = $mysqli->query($query_vehiculos);

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

// Verificar si hay inmuebles en tablas separadas O en campos de solicitud
$hay_inmuebles_tabla = ($result_inmuebles && $result_inmuebles->num_rows > 0);
$hay_inmuebles_solicitud = !empty($datos_solicitud['tipo_inmu_1_sol']) || !empty($datos_solicitud['tipo_inmu_2_sol']);

if ($hay_inmuebles_tabla || $hay_inmuebles_solicitud) {
    // Encabezados de inmuebles
    $sheet->setCellValue("A{$row}", 'Tipo');
    $sheet->setCellValue("B{$row}", 'Dirección');
    $sheet->setCellValue("C{$row}", 'Valor Comercial');
    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray($labelStyle);
    $row++;
    
    // Mostrar inmuebles de tabla separada
    if ($hay_inmuebles_tabla) {
        while ($inmueble = $result_inmuebles->fetch_assoc()) {
            $sheet->setCellValue("A{$row}", $inmueble['tipo'] ?? '');
            $sheet->setCellValue("B{$row}", $inmueble['direccion'] ?? '');
            $sheet->setCellValue("C{$row}", formatCurrency($inmueble['valor_comercial'] ?? ''));
            $row++;
        }
    }
    
    // Mostrar inmuebles de campos de solicitud
    if ($hay_inmuebles_solicitud) {
        if (!empty($datos_solicitud['tipo_inmu_1_sol'])) {
            $sheet->setCellValue("A{$row}", $datos_solicitud['tipo_inmu_1_sol']);
            $sheet->setCellValue("B{$row}", $datos_solicitud['direccion_1_sol'] ?? '');
            $sheet->setCellValue("C{$row}", formatCurrency($datos_solicitud['valor_comer_1_sol'] ?? ''));
            $row++;
        }
        if (!empty($datos_solicitud['tipo_inmu_2_sol'])) {
            $sheet->setCellValue("A{$row}", $datos_solicitud['tipo_inmu_2_sol']);
            $sheet->setCellValue("B{$row}", $datos_solicitud['direccion_2_sol'] ?? '');
            $sheet->setCellValue("C{$row}", formatCurrency($datos_solicitud['valor_comer_2_sol'] ?? ''));
            $row++;
        }
    }
    $row += 2;
} else {
    $sheet->setCellValue("A{$row}", 'No se registraron inmuebles');
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $row += 3;
}

// RELACIÓN VEHÍCULOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'RELACIÓN VEHÍCULOS');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

// Verificar si hay vehículos en tablas separadas O en campos de solicitud
$hay_vehiculos_tabla = ($result_vehiculos && $result_vehiculos->num_rows > 0);
$hay_vehiculos_solicitud = !empty($datos_solicitud['tipo_vehi_1_sol']) || !empty($datos_solicitud['tipo_vehi_2_sol']);

if ($hay_vehiculos_tabla || $hay_vehiculos_solicitud) {
    // Encabezados de vehículos
    $sheet->setCellValue("A{$row}", 'Tipo');
    $sheet->setCellValue("B{$row}", 'Marca');
    $sheet->setCellValue("C{$row}", 'Modelo');
    $sheet->setCellValue("D{$row}", 'Placa');
    $sheet->setCellValue("E{$row}", 'Valor Comercial');
    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray($labelStyle);
    $row++;
    
    // Mostrar vehículos de tabla separada
    if ($hay_vehiculos_tabla) {
        while ($vehiculo = $result_vehiculos->fetch_assoc()) {
            $sheet->setCellValue("A{$row}", $vehiculo['tipo'] ?? '');
            $sheet->setCellValue("B{$row}", $vehiculo['marca'] ?? '');
            $sheet->setCellValue("C{$row}", $vehiculo['modelo'] ?? '');
            $sheet->setCellValue("D{$row}", $vehiculo['placa'] ?? '');
            $sheet->setCellValue("E{$row}", formatCurrency($vehiculo['valor_comercial'] ?? ''));
            $row++;
        }
    }
    
    // Mostrar vehículos de campos de solicitud
    if ($hay_vehiculos_solicitud) {
        if (!empty($datos_solicitud['tipo_vehi_1_sol'])) {
            $sheet->setCellValue("A{$row}", $datos_solicitud['tipo_vehi_1_sol']);
            $sheet->setCellValue("B{$row}", $datos_solicitud['marca_1_sol'] ?? '');
            $sheet->setCellValue("C{$row}", $datos_solicitud['modelo_1_sol'] ?? '');
            $sheet->setCellValue("D{$row}", $datos_solicitud['placa_1_sol'] ?? '');
            $sheet->setCellValue("E{$row}", formatCurrency($datos_solicitud['valor_1_sol'] ?? ''));
            $row++;
        }
        if (!empty($datos_solicitud['tipo_vehi_2_sol'])) {
            $sheet->setCellValue("A{$row}", $datos_solicitud['tipo_vehi_2_sol']);
            $sheet->setCellValue("B{$row}", $datos_solicitud['marca_2_sol'] ?? '');
            $sheet->setCellValue("C{$row}", $datos_solicitud['modelo_2_sol'] ?? '');
            $sheet->setCellValue("D{$row}", $datos_solicitud['placa_2_sol'] ?? '');
            $sheet->setCellValue("E{$row}", formatCurrency($datos_solicitud['valor_2_sol'] ?? ''));
            $row++;
        }
    }
    $row += 2;
} else {
    $sheet->setCellValue("A{$row}", 'No se registraron vehículos');
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $row += 3;
}

// OTROS ACTIVOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'OTROS ACTIVOS');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_otros_activos = [
    ['Ahorros:', $datos_solicitud['ahorros_sol'] ?? '', 'Otros ahorros:', $datos_solicitud['otros_ahorros_sol'] ?? ''],
];

foreach ($campos_otros_activos as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// DATOS DEL CÓNYUGE
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS DEL CÓNYUGE');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_conyuge = [
    ['Nombre:', $datos_solicitud['conyu_nombre_sol'] ?? '', 'Cédula:', $datos_solicitud['conyu_cedula_sol'] ?? ''],
    ['Fecha nacimiento:', $datos_solicitud['conyu_naci_sol'] ?? '', 'Expedición:', $datos_solicitud['conyu_exp_sol'] ?? ''],
    ['Ciudad nacimiento:', $datos_solicitud['conyu_ciudadn_sol'] ?? '', 'Departamento nacimiento:', $datos_solicitud['conyu_dpton_sol'] ?? ''],
    ['País nacimiento:', $datos_solicitud['conyu_paism_sol'] ?? '', 'Correo:', $datos_solicitud['conyu_correo_sol'] ?? ''],
];

foreach ($campos_conyuge as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// DATOS LABORALES DEL CÓNYUGE
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS LABORALES DEL CÓNYUGE');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_laborales_conyuge = [
    ['Ocupación:', $datos_solicitud['conyu_ocupacion_sol'] ?? '', 'Funcionario estado:', $datos_solicitud['conyu_func_sol'] ?? ''],
    ['Empresa donde labora:', $datos_solicitud['conyu_emp_lab_sol'] ?? '', 'Cargo:', $datos_solicitud['conyu_cargo_sol'] ?? ''],
    ['Salario:', formatCurrency($datos_solicitud['conyu_salario_sol'] ?? ''), 'Dirección laboral:', $datos_solicitud['conyu_dir_lab_sol'] ?? ''],
    ['Teléfono laboral:', $datos_solicitud['conyu_tel_lab_sol'] ?? '', 'Ciudad laboral:', $datos_solicitud['conyu_ciudad_lab_sol'] ?? ''],
    ['Departamento laboral:', $datos_solicitud['conyu_dpto_lab_sol'] ?? '', '', ''],
];

foreach ($campos_laborales_conyuge as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// REFERENCIAS FAMILIARES
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'REFERENCIAS FAMILIARES');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

// Obtener referencias familiares de los campos de la tabla solicitudes
$familiares = [];
if (!empty($datos_solicitud['fami_nombre_1_sol'])) {
    $familiares[] = [
        'nombre' => $datos_solicitud['fami_nombre_1_sol'],
        'parentesco' => $datos_solicitud['fami_parent_1_sol'] ?? '',
        'celular' => $datos_solicitud['fami_cel_1_sol'] ?? '',
        'telefono' => $datos_solicitud['fami_tel_1_sol'] ?? ''
    ];
}
if (!empty($datos_solicitud['fami_nombre_2_sol'])) {
    $familiares[] = [
        'nombre' => $datos_solicitud['fami_nombre_2_sol'],
        'parentesco' => $datos_solicitud['fami_parent_2_sol'] ?? '',
        'celular' => $datos_solicitud['fami_cel_2_sol'] ?? '',
        'telefono' => $datos_solicitud['fami_tel_2_sol'] ?? ''
    ];
}

if (count($familiares) > 0) {
    // Encabezados
    $sheet->setCellValue("A{$row}", 'Nombre Completo');
    $sheet->setCellValue("B{$row}", 'Parentesco');
    $sheet->setCellValue("C{$row}", 'Celular');
    $sheet->setCellValue("D{$row}", 'Teléfono');
    $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($labelStyle);
    $row++;
    
    // Datos de familiares
    for ($i = 0; $i < 2; $i++) {
        if (isset($familiares[$i])) {
            $familiar = $familiares[$i];
            $sheet->setCellValue("A{$row}", $familiar['nombre'] ?? '');
            $sheet->setCellValue("B{$row}", $familiar['parentesco'] ?? '');
            $sheet->setCellValue("C{$row}", $familiar['celular'] ?? '');
            $sheet->setCellValue("D{$row}", $familiar['telefono'] ?? '');
        } else {
            $sheet->setCellValue("A{$row}", '');
            $sheet->setCellValue("B{$row}", '');
            $sheet->setCellValue("C{$row}", '');
            $sheet->setCellValue("D{$row}", '');
        }
        $row++;
    }
} else {
    $sheet->setCellValue("A{$row}", 'No se registraron referencias familiares');
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// REFERENCIAS COMERCIALES/PERSONALES
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'REFERENCIAS COMERCIALES/PERSONALES');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

// Obtener referencias comerciales de los campos de la tabla solicitudes
$comerciales = [];
if (!empty($datos_solicitud['refer_nombre_1_sol'])) {
    $comerciales[] = [
        'nombre' => $datos_solicitud['refer_nombre_1_sol'],
        'celular' => $datos_solicitud['refer_cel_1_sol'] ?? '',
        'telefono' => $datos_solicitud['refer_tel_1_sol'] ?? ''
    ];
}
if (!empty($datos_solicitud['refer_nombre_2_sol'])) {
    $comerciales[] = [
        'nombre' => $datos_solicitud['refer_nombre_2_sol'],
        'celular' => $datos_solicitud['refer_cel_2_sol'] ?? '',
        'telefono' => $datos_solicitud['refer_tel_2_sol'] ?? ''
    ];
}

if (count($comerciales) > 0) {
    // Encabezados
    $sheet->setCellValue("A{$row}", 'Nombre Completo');
    $sheet->setCellValue("B{$row}", 'Celular');
    $sheet->setCellValue("C{$row}", 'Teléfono');
    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray($labelStyle);
    $row++;
    
    // Datos de referencias comerciales
    for ($i = 0; $i < 2; $i++) {
        if (isset($comerciales[$i])) {
            $comercial = $comerciales[$i];
            $sheet->setCellValue("A{$row}", $comercial['nombre'] ?? '');
            $sheet->setCellValue("B{$row}", $comercial['celular'] ?? '');
            $sheet->setCellValue("C{$row}", $comercial['telefono'] ?? '');
        } else {
            $sheet->setCellValue("A{$row}", '');
            $sheet->setCellValue("B{$row}", '');
            $sheet->setCellValue("C{$row}", '');
        }
        $row++;
    }
} else {
    $sheet->setCellValue("A{$row}", 'No se registraron referencias comerciales/personales');
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $row++;
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
