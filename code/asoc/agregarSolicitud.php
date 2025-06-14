<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include("../../conexion.php");
// Desactivar la visualización de errores en pantalla
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Escapar TODOS los inputs
  $tipo_doc_aso = $mysqli->real_escape_string($_POST['tipo_doc_aso']);
  $cedula_aso = $mysqli->real_escape_string($_POST['cedula_aso']);
  $nombre_aso = $mysqli->real_escape_string($_POST['nombre_aso']);
  $direccion_aso = $mysqli->real_escape_string($_POST['direccion_aso']);
  $fecha_exp_doc_aso = $mysqli->real_escape_string($_POST['fecha_exp_doc_aso']);
  $pais_exp_cedula_aso = $mysqli->real_escape_string($_POST['pais_exp_cedula_aso']);
  $dpto_exp_cedula_aso = $mysqli->real_escape_string($_POST['dpto_exp_cedula_aso']);
  $ciudad_exp_cedula_aso = $mysqli->real_escape_string($_POST['ciudad_exp_cedula_aso']);
  $fecha_nacimiento_aso = $mysqli->real_escape_string($_POST['fecha_nacimiento_aso']);
  $pais_naci_aso = $mysqli->real_escape_string($_POST['pais_naci_aso']);
  $dpto_naci_aso = $mysqli->real_escape_string($_POST['dpto_naci_aso']);
  $ciudad_naci_aso = $mysqli->real_escape_string($_POST['ciudad_naci_aso']);
  $edad_aso = $mysqli->real_escape_string($_POST['edad_aso']);
  $sexo_aso = $mysqli->real_escape_string($_POST['sexo_aso']);
  $nacionalidad_aso = $mysqli->real_escape_string($_POST['nacionalidad_aso']);
  $estado_civil_aso = $mysqli->real_escape_string($_POST['estado_civil_aso']);
  $per_cargo_aso = $mysqli->real_escape_string($_POST['per_cargo_aso']);
  $tip_vivienda_aso = $mysqli->real_escape_string($_POST['tip_vivienda_aso']);
  $barrio_aso = $mysqli->real_escape_string($_POST['barrio_aso']);
  $ciudad_aso = $mysqli->real_escape_string($_POST['ciudad_aso']);
  $departamente_aso = $mysqli->real_escape_string($_POST['departamente_aso']);
  $estrato_aso = $mysqli->real_escape_string($_POST['estrato_aso']);
  $email_aso = $mysqli->real_escape_string($_POST['email_aso']);
  $tel_aso = $mysqli->real_escape_string($_POST['tel_aso']);
  $cel_aso = $mysqli->real_escape_string($_POST['cel_aso']);
  $nivel_educa_aso = $mysqli->real_escape_string($_POST['nivel_educa_aso']);
  $titulo_obte_aso = $mysqli->real_escape_string($_POST['titulo_obte_aso']);
  $titulo_pos_aso = $mysqli->real_escape_string($_POST['titulo_pos_aso']);
  $fecha_sol = $mysqli->real_escape_string($_POST['fecha_sol']);
  $tipo_deudor_aso = $mysqli->real_escape_string($_POST['tipo_deudor_aso']);
  $monto_sol = $mysqli->real_escape_string($_POST['monto_sol']);
  $plazo_sol = $mysqli->real_escape_string($_POST['plazo_sol']);
  $otro_plazo_sol = $mysqli->real_escape_string($_POST['otro_plazo_sol']) ?? '';
  $linea_cred_aso = $mysqli->real_escape_string($_POST['linea_cred_aso']);
  $ocupacion_sol = $mysqli->real_escape_string($_POST['ocupacion_sol']);
  $func_estad_sol = $mysqli->real_escape_string($_POST['func_estad_sol']);
  $emp_labo_sol = $mysqli->real_escape_string($_POST['emp_labo_sol']);
  $nit_emp_labo_sol = $mysqli->real_escape_string($_POST['nit_emp_labo_sol']);
  $act_emp_labo_sol = $mysqli->real_escape_string($_POST['act_emp_labo_sol']);
  $dir_emp_sol = $mysqli->real_escape_string($_POST['dir_emp_sol']);
  $ciudad_emp_sol = $mysqli->real_escape_string($_POST['ciudad_emp_sol']);
  $depar_emp_sol = $mysqli->real_escape_string($_POST['depar_emp_sol']);
  $tel_emp_sol = $mysqli->real_escape_string($_POST['tel_emp_sol']);
  $fecha_ing_emp_sol = $mysqli->real_escape_string($_POST['fecha_ing_emp_sol']);
  $anti_emp_sol = $mysqli->real_escape_string($_POST['anti_emp_sol']);
  $anti_emp_mes_sol = $mysqli->real_escape_string($_POST['anti_emp_mes_sol']);
  $cargo_actual_emp_sol = $mysqli->real_escape_string($_POST['cargo_actual_emp_sol']);
  $area_trabajo_sol = $mysqli->real_escape_string($_POST['area_trabajo_sol']);
  $acti_inde_sol = $mysqli->real_escape_string($_POST['acti_inde_sol']);
  $num_emple_emp_sol = $mysqli->real_escape_string($_POST['num_emple_emp_sol']);
  $salario_sol = $mysqli->real_escape_string($_POST['salario_sol']);
  $ing_arri_sol = $mysqli->real_escape_string($_POST['ing_arri_sol']);
  $honorarios_sol = $mysqli->real_escape_string($_POST['honorarios_sol']);
  $pension_sol = $mysqli->real_escape_string($_POST['pension_sol']);
  $otros_ing_sol = $mysqli->real_escape_string($_POST['otros_ing_sol']);
  $cuota_pres_sol = $mysqli->real_escape_string($_POST['cuota_pres_sol']);
  $cuota_tar_cred_sol = $mysqli->real_escape_string($_POST['cuota_tar_cred_sol']);
  $arrendo_sol = $mysqli->real_escape_string($_POST['arrendo_sol']);
  $gastos_fam_sol = $mysqli->real_escape_string($_POST['gastos_fam_sol']);
  $otros_gastos_sol = $mysqli->real_escape_string($_POST['otros_gastos_sol']);
  $ahorro_banco_sol = $mysqli->real_escape_string($_POST['ahorro_banco_sol']);
  $otro_ahorros_sol = $mysqli->real_escape_string($_POST['otro_ahorros_sol']);
  $vehiculo_sol = $mysqli->real_escape_string($_POST['vehiculo_sol']);
  $bienes_raices_sol = $mysqli->real_escape_string($_POST['bienes_raices_sol']);
  $otros_activos_sol = $mysqli->real_escape_string($_POST['otros_activos_sol']);
  $presta_total_sol = $mysqli->real_escape_string($_POST['presta_total_sol']);
  $hipotecas_sol = $mysqli->real_escape_string($_POST['hipotecas_sol']);
  $tar_cred_total_sol = $mysqli->real_escape_string($_POST['tar_cred_total_sol']);
  $otros_pasivos_sol = $mysqli->real_escape_string($_POST['otros_pasivos_sol']);
  // $tipo_inmu_1_sol = $_POST['tipo_inmu_1_sol'];
  // $direccion_1_sol = $_POST['direccion_1_sol'];
  // $valor_comer_1_sol = $_POST['valor_comer_1_sol'];
  // $tipo_inmu_2_sol = $_POST['tipo_inmu_2_sol'];
  // $direccion_2_sol = $_POST['direccion_2_sol'];
  // $valor_comer_2_sol = $_POST['valor_comer_2_sol'];
  // $tipo_vehi_1_sol = $_POST['tipo_vehi_1_sol'];
  // $modelo_1_sol = $_POST['modelo_1_sol'];
  // $marca_1_sol = $_POST['marca_1_sol'];
  // $placa_1_sol = $_POST['placa_1_sol'];
  // $valor_1_sol = $_POST['valor_1_sol'];
  // $tipo_vehi_2_sol = $_POST['tipo_vehi_2_sol'];
  // $modelo_2_sol = $_POST['modelo_2_sol'];
  // $marca_2_sol = $_POST['marca_2_sol'];
  // $placa_2_sol = $_POST['placa_2_sol'];
  // $valor_2_sol = $_POST['valor_2_sol'];
  $ahorros_sol = $_POST['ahorros_sol'];
  $valor_ahor_sol = $_POST['valor_ahor_sol'];
  $enseres_sol = $_POST['enseres_sol'];
  $valor_enser_sol = $_POST['valor_enser_sol'];
  $conyu_nombre_sol = $_POST['conyu_nombre_sol'];
  $conyu_cedula_sol = $_POST['conyu_cedula_sol'];
  $conyu_naci_sol = $_POST['conyu_naci_sol'];
  $conyu_exp_sol = $_POST['conyu_exp_sol'];
  $conyu_ciudadn_sol = $_POST['conyu_ciudadn_sol'];
  $conyu_dpton_sol = $_POST['conyu_dpton_sol'];
  $conyu_paism_sol = $_POST['conyu_paism_sol'];
  $conyu_correo_sol = $_POST['conyu_correo_sol'];
  $conyu_ocupacion_sol = $_POST['conyu_ocupacion_sol'];
  $conyu_func_sol = $_POST['conyu_func_sol'];
  $conyu_emp_lab_sol = $_POST['conyu_emp_lab_sol'];
  $conyu_cargo_sol = $_POST['conyu_cargo_sol'];
  $conyu_salario_sol = $_POST['conyu_salario_sol'];
  $conyu_dir_lab_sol = $_POST['conyu_dir_lab_sol'];
  $conyu_tel_lab_sol = $_POST['conyu_tel_lab_sol'];
  $conyu_ciudad_lab_sol = $_POST['conyu_ciudad_lab_sol'];
  $conyu_dpto_lab_sol = $_POST['conyu_dpto_lab_sol'];
  $fami_nombre_1_sol = $_POST['fami_nombre_1_sol'];
  $fami_cel_1_sol = $_POST['fami_cel_1_sol'];
  $fami_tel_1_sol = $_POST['fami_tel_1_sol'];
  $fami_parent_1_sol = $_POST['fami_parent_1_sol'];
  $fami_nombre_2_sol = $_POST['fami_nombre_2_sol'];
  $fami_cel_2_sol = $_POST['fami_cel_2_sol'];
  $fami_tel_2_sol = $_POST['fami_tel_2_sol'];
  $fami_parent_2_sol = $_POST['fami_parent_2_sol'];
  $refer_nombre_1_sol = $_POST['refer_nombre_1_sol'];
  $refer_cel_1_sol = $_POST['refer_cel_1_sol'];
  $refer_tel_1_sol = $_POST['refer_tel_1_sol'];
  $refer_nombre_2_sol = $_POST['refer_nombre_2_sol'];
  $refer_cel_2_sol = $_POST['refer_cel_2_sol'];
  $refer_tel_2_sol = $_POST['refer_tel_2_sol'];

  // Construir query
  $query = "INSERT INTO solicitudes (tipo_doc_aso, cedula_aso, nombre_aso, direccion_aso, fecha_exp_doc_aso, pais_exp_cedula_aso, dpto_exp_cedula_aso, ciudad_exp_cedula_aso, fecha_nacimiento_aso, pais_naci_aso, dpto_naci_aso, ciudad_naci_aso, edad_aso, sexo_aso, nacionalidad_aso, estado_civil_aso, per_cargo_aso, tip_vivienda_aso, barrio_aso, ciudad_aso, departamente_aso, estrato_aso, email_aso, tel_aso, cel_aso, nivel_educa_aso, titulo_obte_aso, titulo_pos_aso,
    fecha_sol, tipo_deudor_aso, monto_sol, plazo_sol, otro_plazo_sol, linea_cred_aso, ocupacion_sol, func_estad_sol, emp_labo_sol, nit_emp_labo_sol, act_emp_labo_sol, dir_emp_sol, ciudad_emp_sol, depar_emp_sol, tel_emp_sol, fecha_ing_emp_sol, anti_emp_sol,anti_emp_mes_sol, cargo_actual_emp_sol, area_trabajo_sol, acti_inde_sol, num_emple_emp_sol, salario_sol, ing_arri_sol, honorarios_sol, pension_sol, otros_ing_sol, cuota_pres_sol, cuota_tar_cred_sol, arrendo_sol, gastos_fam_sol, otros_gastos_sol, ahorro_banco_sol,otro_ahorros_sol, vehiculo_sol, bienes_raices_sol, otros_activos_sol, presta_total_sol, hipotecas_sol, tar_cred_total_sol, otros_pasivos_sol,
    ahorros_sol, valor_ahor_sol, enseres_sol, valor_enser_sol,
    conyu_nombre_sol, conyu_cedula_sol, conyu_naci_sol, conyu_exp_sol, conyu_ciudadn_sol, conyu_dpton_sol, conyu_paism_sol, conyu_correo_sol, conyu_ocupacion_sol, conyu_func_sol, conyu_emp_lab_sol, conyu_cargo_sol, conyu_salario_sol, conyu_dir_lab_sol, conyu_tel_lab_sol, conyu_ciudad_lab_sol, conyu_dpto_lab_sol,
    fami_nombre_1_sol, fami_cel_1_sol, fami_tel_1_sol, fami_parent_1_sol, fami_nombre_2_sol, fami_cel_2_sol, fami_tel_2_sol, fami_parent_2_sol,
    refer_nombre_1_sol, refer_cel_1_sol, refer_tel_1_sol, refer_nombre_2_sol, refer_cel_2_sol, refer_tel_2_sol)
    VALUES ('$tipo_doc_aso', '$cedula_aso', '$nombre_aso', '$direccion_aso', '$fecha_exp_doc_aso', '$pais_exp_cedula_aso', '$dpto_exp_cedula_aso', '$ciudad_exp_cedula_aso', '$fecha_nacimiento_aso', '$pais_naci_aso', '$dpto_naci_aso', '$ciudad_naci_aso', '$edad_aso', '$sexo_aso', '$nacionalidad_aso', '$estado_civil_aso', '$per_cargo_aso', '$tip_vivienda_aso', '$barrio_aso', '$ciudad_aso', '$departamente_aso', '$estrato_aso', '$email_aso', '$tel_aso', '$cel_aso', '$nivel_educa_aso', '$titulo_obte_aso', '$titulo_pos_aso',
    '$fecha_sol', '$tipo_deudor_aso', '$monto_sol', '$plazo_sol', '$otro_plazo_sol', '$linea_cred_aso', '$ocupacion_sol', '$func_estad_sol', '$emp_labo_sol', '$nit_emp_labo_sol', '$act_emp_labo_sol', '$dir_emp_sol', '$ciudad_emp_sol', '$depar_emp_sol', '$tel_emp_sol', '$fecha_ing_emp_sol', '$anti_emp_sol', '$anti_emp_mes_sol', '$cargo_actual_emp_sol', '$area_trabajo_sol', '$acti_inde_sol', '$num_emple_emp_sol', '$salario_sol', '$ing_arri_sol', '$honorarios_sol', '$pension_sol', '$otros_ing_sol', '$cuota_pres_sol', '$cuota_tar_cred_sol', '$arrendo_sol', '$gastos_fam_sol', '$otros_gastos_sol', '$ahorro_banco_sol','$otro_ahorros_sol', '$vehiculo_sol', '$bienes_raices_sol', '$otros_activos_sol', '$presta_total_sol', '$hipotecas_sol', '$tar_cred_total_sol', '$otros_pasivos_sol',
    '$ahorros_sol', '$valor_ahor_sol', '$enseres_sol', '$valor_enser_sol',
    '$conyu_nombre_sol', '$conyu_cedula_sol', '$conyu_naci_sol', '$conyu_exp_sol', '$conyu_ciudadn_sol', '$conyu_dpton_sol', '$conyu_paism_sol', '$conyu_correo_sol', '$conyu_ocupacion_sol', '$conyu_func_sol', '$conyu_emp_lab_sol', '$conyu_cargo_sol', '$conyu_salario_sol', '$conyu_dir_lab_sol', '$conyu_tel_lab_sol', '$conyu_ciudad_lab_sol', '$conyu_dpto_lab_sol',
    '$fami_nombre_1_sol', '$fami_cel_1_sol', '$fami_tel_1_sol', '$fami_parent_1_sol', '$fami_nombre_2_sol', '$fami_cel_2_sol', '$fami_tel_2_sol', '$fami_parent_2_sol',
    '$refer_nombre_1_sol', '$refer_cel_1_sol', '$refer_tel_1_sol', '$refer_nombre_2_sol', '$refer_cel_2_sol', '$refer_tel_2_sol')";

  if ($mysqli->query($query)) {
    $id_solicitud = $mysqli->insert_id;

    // Inmuebles
    $tiposInmu = $_POST['tipo_inmu'];
    $direcciones = $_POST['direccion'];
    $valoresInmu = $_POST['valor_comer'];

    for ($i = 0; $i < count($tiposInmu); $i++) {
        $tipo = $tiposInmu[$i];
        $direccion = $direcciones[$i];
        $valor = $valoresInmu[$i];
        $sql = "INSERT INTO inmuebles (id_solicitud, tipo, direccion, valor_comercial)
                VALUES ($id_solicitud, '$tipo', '$direccion', $valor)";
        if (!$mysqli->query($sql)) {
            // Guardar error en log, no mostrar en pantalla
            error_log("Error inmueble: " . $mysqli->error);
        }
    }

    // Vehículos
    $tiposVehi = $_POST['tipo_vehi'];
    $modelos = $_POST['modelo'];
    $marcas = $_POST['marca'];
    $placas = $_POST['placa'];
    $valoresVehi = $_POST['valor'];

    for ($j = 0; $j < count($tiposVehi); $j++) {
        $tipo = $mysqli->real_escape_string($tiposVehi[$j]);
        $modelo = (int)$modelos[$j];
        $marca = $mysqli->real_escape_string($marcas[$j]);
        $placa = $mysqli->real_escape_string($placas[$j]);
        $valor = (float)$valoresVehi[$j];
        $sql = "INSERT INTO vehiculos (id_solicitud, tipo, modelo, marca, placa, valor_comercial)
                VALUES ($id_solicitud, '$tipo', '$modelo', '$marca', '$placa', $valor)";
        if (!$mysqli->query($sql)) {
            // Guardar error en log, no mostrar en pantalla
            error_log("Error vehiculo: " . $mysqli->error);
        }
    }


    // Directorio donde se guardarán los archivos
    $uploadDir = __DIR__ . '/documentos/';

    // Validar si hay al menos un archivo subido correctamente
    $hayArchivos = false;
    foreach ($_FILES['archivos']['error'] as $error) {
      if ($error === UPLOAD_ERR_OK) {
        $hayArchivos = true;
        break;
      }
    }

    if ($hayArchivos) {
      foreach ($_FILES['archivos']['name'] as $index => $fileName) {
        if ($_FILES['archivos']['error'][$index] === UPLOAD_ERR_OK) {
          $tmpName = $_FILES['archivos']['tmp_name'][$index];
          $originalName = basename($fileName);
          $originalName = preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $originalName);
          $newFileName = $cedula_aso . '_' . $originalName;
          $destination = $uploadDir . $newFileName;

          if (!move_uploaded_file($tmpName, $destination)) {
            // Guardar error en log, no mostrar en pantalla
            error_log("Error al mover: $originalName");
          }
        } else {
          // Guardar error en log, no mostrar en pantalla
          error_log("Error al subir archivo: $fileName");
        }
      }
    }

    echo "<!DOCTYPE html>
  <html>
  <head>
    <meta charset='UTF-8'>
    <title>Exito</title>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  </head>
  <body>
    <script>
      Swal.fire({
        title: 'Solicitud Enviada',
        text: 'Creada Correctamente',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'solicitar.php';
      });
    </script>
  </body>
  </html>";
  } else {
    // Guardar error en log, no mostrar en pantalla
    error_log("Error SQL: " . $mysqli->error);
    echo "<!DOCTYPE html>
  <html>
  <head>
    <meta charset='UTF-8'>
    <title>Error</title>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  </head>
  <body>
    <script>
      Swal.fire({
        title: 'Error',
        text: 'Ocurrió un error al guardar la solicitud.',
        icon: 'error',
        confirmButtonText: 'Volver'
      }).then(() => {
      window.location.href = 'solicitar.php';
      });
    </script>
  </body>
  </html>";
  }
  $mysqli->close();
} else {
  echo "Método no permitido.";
}

//lote finca , moto buseta