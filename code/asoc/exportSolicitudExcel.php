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

// Función para formatear números como moneda
function formatCurrency($value) {
    if (empty($value) || $value == 0) {
        return '';
    }
    return '$' . number_format($value, 0, ',', '.');
}

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar estilos
$headerStyle = [
    'font' => [
        'bold' => true,
        'size' => 14,
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

$sectionStyle = [
    'font' => [
        'bold' => true,
        'size' => 12,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];

$labelStyle = [
    'font' => [
        'bold' => true,
        'size' => 10,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F2F2F2'],
    ],
];

// Título principal
$sheet->mergeCells('A1:H1');
$sheet->setCellValue('A1', 'SOLICITUD DE CRÉDITO - COTRASENA');
$sheet->getStyle('A1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

// Información básica de la solicitud
$sheet->setCellValue('A2', 'ID Solicitud:');
$sheet->setCellValue('B2', $datos_solicitud['id_solicitud']);
$sheet->setCellValue('E2', 'Fecha Solicitud:');
$sheet->setCellValue('F2', $datos_solicitud['fecha_alta_solicitud'] ?? '');
$sheet->getStyle('A2')->applyFromArray($labelStyle);
$sheet->getStyle('E2')->applyFromArray($labelStyle);

$row = 4;

// DATOS PERSONALES
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS PERSONALES');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

// Campos de datos personales
$campos_personales = [
    ['Tipo documento:', $datos_solicitud['tipo_doc_aso'] ?? '', 'Cédula No.:', $datos_solicitud['cedula_aso'] ?? ''],
    ['Nombre asociado:', $datos_solicitud['nombre_aso'] ?? '', 'Dirección:', $datos_solicitud['direccion_aso'] ?? ''],
    ['Fecha expedición:', $datos_solicitud['fecha_exp_doc_aso'] ?? '', 'País expedición:', $datos_solicitud['pais_exp_cedula_aso'] ?? ''],
    ['Departamento expedición:', $datos_solicitud['dpto_exp_cedula_aso'] ?? '', 'Ciudad expedición:', $datos_solicitud['ciudad_exp_cedula_aso'] ?? ''],
    ['Fecha nacimiento:', $datos_solicitud['fecha_nacimiento_aso'] ?? '', 'País nacimiento:', $datos_solicitud['pais_naci_aso'] ?? ''],
    ['Departamento nacimiento:', $datos_solicitud['dpto_naci_aso'] ?? '', 'Ciudad nacimiento:', $datos_solicitud['ciudad_naci_aso'] ?? ''],
    ['Edad:', $datos_solicitud['edad_aso'] ?? '', 'Sexo:', $datos_solicitud['sexo_aso'] ?? ''],
    ['Nacionalidad:', $datos_solicitud['nacionalidad_aso'] ?? '', 'Estado civil:', $datos_solicitud['estado_civil_aso'] ?? ''],
    ['Personas a cargo:', $datos_solicitud['per_cargo_aso'] ?? '', 'Tipo vivienda:', $datos_solicitud['tip_vivienda_aso'] ?? ''],
    ['Barrio:', $datos_solicitud['barrio_aso'] ?? '', 'Ciudad:', $datos_solicitud['ciudad_aso'] ?? ''],
    ['Departamento:', $datos_solicitud['departamente_aso'] ?? '', 'Estrato:', $datos_solicitud['estrato_aso'] ?? ''],
    ['Email:', $datos_solicitud['email_aso'] ?? '', 'Teléfono:', $datos_solicitud['tel_aso'] ?? ''],
    ['Celular:', $datos_solicitud['cel_aso'] ?? '', 'Nivel educativo:', $datos_solicitud['nivel_educa_aso'] ?? ''],
    ['Título obtenido:', $datos_solicitud['titulo_obte_aso'] ?? '', 'Título postgrado:', $datos_solicitud['titulo_pos_aso'] ?? ''],
];

foreach ($campos_personales as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// DATOS DEL CRÉDITO
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS DEL CRÉDITO');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_credito = [
    ['Fecha:', $datos_solicitud['fecha_sol'] ?? '', 'Tipo deudor:', $datos_solicitud['tipo_deudor_aso'] ?? ''],
    ['Monto solicitado:', formatCurrency($datos_solicitud['monto_sol'] ?? ''), 'Plazo:', $datos_solicitud['plazo_sol'] ?? ''],
    ['Otro plazo:', $datos_solicitud['otro_plazo_sol'] ?? '', 'Línea crédito:', $datos_solicitud['linea_cred_aso'] ?? ''],
];

foreach ($campos_credito as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// DATOS LABORALES
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS LABORALES');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_laborales = [
    ['Ocupación:', $datos_solicitud['ocupacion_sol'] ?? '', 'Funcionario estado:', $datos_solicitud['func_estad_sol'] ?? ''],
    ['Empresa donde labora:', $datos_solicitud['emp_labo_sol'] ?? '', 'NIT empresa:', $datos_solicitud['nit_emp_labo_sol'] ?? ''],
    ['Actividad empresa:', $datos_solicitud['act_emp_labo_sol'] ?? '', 'Dirección empresa:', $datos_solicitud['dir_emp_sol'] ?? ''],
    ['Ciudad empresa:', $datos_solicitud['ciudad_emp_sol'] ?? '', 'Departamento empresa:', $datos_solicitud['depar_emp_sol'] ?? ''],
    ['Teléfono empresa:', $datos_solicitud['tel_emp_sol'] ?? '', 'Fecha ingreso:', $datos_solicitud['fecha_ing_emp_sol'] ?? ''],
    ['Antigüedad años:', $datos_solicitud['anti_emp_sol'] ?? '', 'Antigüedad meses:', $datos_solicitud['anti_emp_mes_sol'] ?? ''],
    ['Cargo actual:', $datos_solicitud['cargo_actual_emp_sol'] ?? '', 'Área trabajo:', $datos_solicitud['area_trabajo_sol'] ?? ''],
    ['Actividad independiente:', $datos_solicitud['acti_inde_sol'] ?? '', 'Número empleados:', $datos_solicitud['num_emple_emp_sol'] ?? ''],
];

foreach ($campos_laborales as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// DATOS FINANCIEROS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'DATOS FINANCIEROS');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

// INGRESOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'INGRESOS');
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

$campos_ingresos = [
    ['Salario:', formatCurrency($datos_solicitud['salario_sol'] ?? ''), 'Ingreso arriendo:', formatCurrency($datos_solicitud['ing_arri_sol'] ?? '')],
    ['Honorarios:', formatCurrency($datos_solicitud['honorarios_sol'] ?? ''), 'Pensión:', formatCurrency($datos_solicitud['pension_sol'] ?? '')],
    ['Otros ingresos:', formatCurrency($datos_solicitud['otros_ing_sol'] ?? ''), '', ''],
];

foreach ($campos_ingresos as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row++;

// EGRESOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'EGRESOS');
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

$campos_egresos = [
    ['Cuota préstamos:', formatCurrency($datos_solicitud['cuota_pres_sol'] ?? ''), 'Cuota tarjeta crédito:', formatCurrency($datos_solicitud['cuota_tar_cred_sol'] ?? '')],
    ['Arrendamiento:', formatCurrency($datos_solicitud['arrendo_sol'] ?? ''), 'Gastos familiares:', formatCurrency($datos_solicitud['gastos_fam_sol'] ?? '')],
    ['Otros gastos:', formatCurrency($datos_solicitud['otros_gastos_sol'] ?? ''), '', ''],
];

foreach ($campos_egresos as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row++;

// ACTIVOS Y PASIVOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'ACTIVOS Y PASIVOS');
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

$campos_activos = [
    ['Bancos (ahorros, inversiones, CDTs):', formatCurrency($datos_solicitud['ahorro_banco_sol'] ?? ''), 'Vehículos (valor comercial):', formatCurrency($datos_solicitud['vehiculo_sol'] ?? '')],
    ['Bienes raíces (valor comercial):', formatCurrency($datos_solicitud['bienes_raices_sol'] ?? ''), 'Otros activos:', formatCurrency($datos_solicitud['otros_activos_sol'] ?? '')],
    ['Préstamos (deuda total):', formatCurrency($datos_solicitud['presta_total_sol'] ?? ''), 'Hipotecas:', formatCurrency($datos_solicitud['hipotecas_sol'] ?? '')],
    ['Tarjeta crédito (deuda total):', formatCurrency($datos_solicitud['tar_cred_total_sol'] ?? ''), 'Otros pasivos:', formatCurrency($datos_solicitud['otros_pasivos_sol'] ?? '')],
];

foreach ($campos_activos as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row += 2;

// RELACIÓN INMUEBLES
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'RELACIÓN INMUEBLES');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

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

$row += 2;

// INFORMACIÓN ADICIONAL DE ACTIVOS
$sheet->mergeCells("A{$row}:H{$row}");
$sheet->setCellValue("A{$row}", 'INFORMACIÓN ADICIONAL DE ACTIVOS');
$sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
$row++;

$campos_activos_adicionales = [
    ['Valor de ahorros:', formatCurrency($datos_solicitud['valor_ahor_sol'] ?? ''), 'Enseres:', $datos_solicitud['enseres_sol'] ?? ''],
    ['Valor de enseres:', formatCurrency($datos_solicitud['valor_enser_sol'] ?? ''), '', ''],
];

foreach ($campos_activos_adicionales as $campo) {
    $sheet->setCellValue("A{$row}", $campo[0]);
    $sheet->setCellValue("B{$row}", $campo[1]);
    $sheet->setCellValue("E{$row}", $campo[2]);
    $sheet->setCellValue("F{$row}", $campo[3]);
    
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    if (!empty($campo[2])) {
        $sheet->getStyle("E{$row}")->applyFromArray($labelStyle);
    }
    $row++;
}

$row += 2;

// Ajustar ancho de columnas automáticamente
foreach (range('A', 'H') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Configurar bordes para toda la hoja
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

$sheet->getStyle("A1:H{$row}")->applyFromArray($styleArray);

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
