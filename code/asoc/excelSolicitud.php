<?php
require '../../vendor/autoload.php';

$fechaInicial = $_GET['fechaInicial'] ?? '';
$fechaFinal = $_GET['fechaFinal'] ?? '';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

session_start();
include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sql = "SELECT 
s.tipo_doc_aso AS tipo_documento_asociado,
s.cedula_aso AS cedula_asociado,
s.nombre_aso AS nombre_asociado,
s.direccion_aso AS direccion_asociado,
s.fecha_exp_doc_aso AS fecha_expedicion_documento,
s.pais_exp_cedula_aso AS pais_expedicion_cedula,
s.dpto_exp_cedula_aso AS departamento_expedicion_cedula,
s.ciudad_exp_cedula_aso AS ciudad_expedicion_cedula,
s.fecha_nacimiento_aso AS fecha_nacimiento_asociado,
s.pais_naci_aso AS pais_nacimiento,
s.dpto_naci_aso AS departamento_nacimiento,
s.ciudad_naci_aso AS ciudad_nacimiento,
s.edad_aso AS edad_asociado,
s.sexo_aso AS sexo_asociado,
s.nacionalidad_aso AS nacionalidad_asociado,
s.estado_civil_aso AS estado_civil_asociado,
s.per_cargo_aso AS personas_a_cargo,
s.tip_vivienda_aso AS tipo_vivienda,
s.barrio_aso AS barrio_asociado,
s.ciudad_aso AS ciudad_asociado,
s.departamente_aso AS departamento_asociado,
s.estrato_aso AS estrato_asociado,
s.email_aso AS email_asociado,
s.tel_aso AS telefono_asociado,
s.cel_aso AS celular_asociado,
s.nivel_educa_aso AS nivel_educativo,
s.titulo_obte_aso AS titulo_obtenido,
s.titulo_pos_aso AS titulo_posgrado,
s.fecha_sol AS fecha_solicitud,
s.tipo_deudor_aso AS tipo_deudor,
s.monto_sol AS monto_solicitado,
s.plazo_sol AS plazo_solicitado,
s.otro_plazo_sol AS otro_plazo_solicitado,
s.linea_cred_aso AS linea_credito,
s.ocupacion_sol AS ocupacion,
s.func_estad_sol AS funcionario_estado,
s.emp_labo_sol AS empresa_laboral,
s.nit_emp_labo_sol AS nit_empresa_laboral,
s.act_emp_labo_sol AS actividad_empresa_laboral,
s.dir_emp_sol AS direccion_empresa,
s.ciudad_emp_sol AS ciudad_empresa,
s.depar_emp_sol AS departamento_empresa,
s.tel_emp_sol AS telefono_empresa,
s.fecha_ing_emp_sol AS fecha_ingreso_empresa,
s.anti_emp_sol AS antiguedad_empresa_anios,
s.anti_emp_mes_sol AS antiguedad_empresa_meses,
s.cargo_actual_emp_sol AS cargo_actual,
s.area_trabajo_sol AS area_trabajo,
s.acti_inde_sol AS actividad_independiente,
s.num_emple_emp_sol AS numero_empleados_empresa,
s.salario_sol AS salario,
GROUP_CONCAT(CONCAT_WS(' - ', v.tipo, v.modelo, v.marca, v.placa, v.valor_comercial) SEPARATOR ' | ') AS vehiculos_info,
s.ing_arri_sol AS ingresos_arriendos,
s.honorarios_sol AS honorarios,
s.pension_sol AS pension,
s.otros_ing_sol AS otros_ingresos,
s.cuota_pres_sol AS cuota_prestamo,
s.cuota_tar_cred_sol AS cuota_tarjeta_credito,
s.arrendo_sol AS arriendo,
s.gastos_fam_sol AS gastos_familiares,
s.otros_gastos_sol AS otros_gastos,
s.ahorro_banco_sol AS ahorro_banco,
s.vehiculo_sol AS vehiculo,
s.bienes_raices_sol AS bienes_raices,
s.otros_activos_sol AS otros_activos,
s.presta_total_sol AS total_prestamos,
s.hipotecas_sol AS hipotecas,
s.tar_cred_total_sol AS total_tarjetas_credito,
s.otros_pasivos_sol AS otros_pasivos,
s.ahorros_sol AS ahorros,
s.otro_ahorros_sol AS otros_ahorros,
s.valor_ahor_sol AS valor_ahorros,
s.enseres_sol AS enseres,
s.valor_enser_sol AS valor_enseres,
s.conyu_nombre_sol AS conyuge_nombre,
s.conyu_cedula_sol AS conyuge_cedula,
s.conyu_naci_sol AS conyuge_fecha_nacimiento,
s.conyu_exp_sol AS conyuge_fecha_expedicion,
s.conyu_ciudadn_sol AS conyuge_ciudad_nacimiento,
s.conyu_dpton_sol AS conyuge_departamento_nacimiento,
s.conyu_paism_sol AS conyuge_pais_nacimiento,
s.conyu_correo_sol AS conyuge_correo,
s.conyu_ocupacion_sol AS conyuge_ocupacion,
s.conyu_func_sol AS conyuge_funcionario,
s.conyu_emp_lab_sol AS conyuge_empresa,
s.conyu_cargo_sol AS conyuge_cargo,
s.conyu_salario_sol AS conyuge_salario,
s.conyu_dir_lab_sol AS conyuge_direccion_laboral,
s.conyu_tel_lab_sol AS conyuge_telefono_laboral,
s.conyu_ciudad_lab_sol AS conyuge_ciudad_laboral,
s.conyu_dpto_lab_sol AS conyuge_departamento_laboral,
s.fami_nombre_1_sol AS familiar_1_nombre,
s.fami_cel_1_sol AS familiar_1_celular,
s.fami_tel_1_sol AS familiar_1_telefono,
s.fami_parent_1_sol AS familiar_1_parentesco,
s.fami_nombre_2_sol AS familiar_2_nombre,
s.fami_cel_2_sol AS familiar_2_celular,
s.fami_tel_2_sol AS familiar_2_telefono,
s.fami_parent_2_sol AS familiar_2_parentesco,
s.refer_nombre_1_sol AS referencia_1_nombre,
s.refer_cel_1_sol AS referencia_1_celular,
s.refer_tel_1_sol AS referencia_1_telefono,
s.refer_nombre_2_sol AS referencia_2_nombre,
s.refer_cel_2_sol AS referencia_2_celular,
s.refer_tel_2_sol AS referencia_2_telefono,
s.fecha_alta_solicitud AS fecha_alta,
s.fecha_edit_solicitud AS fecha_edicion,
s.estado_solicitud AS estado,
s.observacion_solicitud AS observacion,
s.fecha_observacion AS fecha_observacion,
s.fecha_devolucion AS fecha_devolucion,
s.fecha_devolucion_gerencia AS fecha_devolucion_gerencia
  FROM solicitudes as s
LEFT JOIN atenciones as a ON s.id_solicitud = a.id_solicitud
LEFT JOIN aprobaciones as ap ON s.id_solicitud = ap.id_solicitud
LEFT JOIN gerencia as g ON s.id_solicitud = g.id_solicitud
LEFT JOIN vehiculos as v on s.id_solicitud = v.id_solicitud
LEFT JOIN inmuebles as i on i.id_solicitud = s.id_solicitud
WHERE s.fecha_alta_solicitud BETWEEN '$fechaInicial' AND '$fechaFinal'
GROUP BY s.id_solicitud
ORDER BY s.fecha_alta_solicitud DESC
 ";
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
$sheet->getStyle('A1:ER1')->applyFromArray([
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
$sheet->getStyle('A2:ER2')->applyFromArray(['font' => $boldFontStyle]);

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
$sheet->getStyle('A1:ER1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

// // Definir los encabezados de columna

// Ajustar el ancho de las columna

for ($col = 1; $col <= 140; $col++) {
    $colLetter = Coordinate::stringFromColumnIndex($col); // Convierte 1 → A, 27 → AA, etc.
    $sheet->getColumnDimension($colLetter)->setWidth(25);
}



$rowIndex = 1;
$colIndex = 1;

// Tomar la primera fila para obtener los encabezados
$firstRow = mysqli_fetch_assoc($res);

// Si hay datos
if ($firstRow) {
    $columns = array_keys($firstRow); // obtenemos los nombres de columnas

    // Escribir encabezados
    foreach ($columns as $colName) {
        $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($columnLetter . $rowIndex, strtoupper($colName));
        $colIndex++;
    }

    // Volver a procesar la primera fila + continuar con el resto
    $dataRows = [$firstRow];
    while ($row = mysqli_fetch_assoc($res)) {
        $dataRows[] = $row;
    }

    $rowIndex = 2; // siguiente fila para datos
    foreach ($dataRows as $rowData) {
        $colIndex = 1;
        foreach ($rowData as $value) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($columnLetter . $rowIndex, $value);
            $colIndex++;
        }
        $rowIndex++;
    }
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
