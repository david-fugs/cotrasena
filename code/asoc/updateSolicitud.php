<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}
$id_usu = $_SESSION['id_usu'];
include("../../conexion.php");

// Activar errores para depuración de subida de archivos
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // DEBUG: Información sobre archivos recibidos
    error_log("DEBUG UPDATE - POST recibido. Archivos: " . print_r($_FILES, true));
    
    if (isset($_FILES['archivos'])) {
        error_log("DEBUG UPDATE - Número de archivos: " . count($_FILES['archivos']['name']));
        for ($i = 0; $i < count($_FILES['archivos']['name']); $i++) {
            error_log("DEBUG UPDATE - Archivo $i: Nombre='" . $_FILES['archivos']['name'][$i] . "', Tamaño=" . $_FILES['archivos']['size'][$i] . ", Error=" . $_FILES['archivos']['error'][$i] . ", Temp='" . $_FILES['archivos']['tmp_name'][$i] . "'");
        }
    } else {
        error_log("DEBUG UPDATE - No se encontró el campo 'archivos' en FILES");
    }
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
    $otro_plazo_sol = $mysqli->real_escape_string($_POST['otro_plazo_sol']);
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
    $vehiculo_sol = $mysqli->real_escape_string($_POST['vehiculo_sol']);
    $bienes_raices_sol = $mysqli->real_escape_string($_POST['bienes_raices_sol']);
    $otros_activos_sol = $mysqli->real_escape_string($_POST['otros_activos_sol']);
    $presta_total_sol = $mysqli->real_escape_string($_POST['presta_total_sol']);
    $hipotecas_sol = $mysqli->real_escape_string($_POST['hipotecas_sol']);
    $tar_cred_total_sol = $mysqli->real_escape_string($_POST['tar_cred_total_sol']);
    $otros_pasivos_sol = $mysqli->real_escape_string($_POST['otros_pasivos_sol']);
    $ahorros_sol = $_POST['ahorros_sol'] ?? '';
    $otro_ahorros_sol = $_POST['otro_ahorros_sol'] ?? '';
    $valor_ahor_sol = $_POST['valor_ahor_sol'] ?? '';
    $enseres_sol = $_POST['enseres_sol'] ?? '';
    $valor_enser_sol = $_POST['valor_enser_sol'] ?? '';
    $conyu_nombre_sol = $_POST['conyu_nombre_sol'] ?? '';
    $conyu_cedula_sol = $_POST['conyu_cedula_sol'] ?? '';
    $conyu_naci_sol = $_POST['conyu_naci_sol'] ?? '';
    $conyu_exp_sol = $_POST['conyu_exp_sol'] ?? '';
    $conyu_ciudadn_sol = $_POST['conyu_ciudadn_sol'] ?? '';
    $conyu_dpton_sol = $_POST['conyu_dpton_sol'] ?? '';
    $conyu_paism_sol = $_POST['conyu_paism_sol'] ?? '';
    $conyu_correo_sol = $_POST['conyu_correo_sol'] ?? '';
    $conyu_ocupacion_sol = $_POST['conyu_ocupacion_sol'] ?? '';
    $conyu_func_sol = $_POST['conyu_func_sol'] ?? '';
    $conyu_emp_lab_sol = $_POST['conyu_emp_lab_sol'] ?? '';
    $conyu_cargo_sol = $_POST['conyu_cargo_sol'] ?? '';
    $conyu_salario_sol = $_POST['conyu_salario_sol'] ?? '';
    $conyu_dir_lab_sol = $_POST['conyu_dir_lab_sol'] ?? '';
    $conyu_tel_lab_sol = $_POST['conyu_tel_lab_sol'] ?? '';
    $conyu_ciudad_lab_sol = $_POST['conyu_ciudad_lab_sol'] ?? '';
    $conyu_dpto_lab_sol = $_POST['conyu_dpto_lab_sol'] ?? '';
    $fami_nombre_1_sol = $_POST['fami_nombre_1_sol'] ?? '';
    $fami_cel_1_sol = $_POST['fami_cel_1_sol'] ?? '';
    $fami_tel_1_sol = $_POST['fami_tel_1_sol'] ?? '';
    $fami_parent_1_sol = $_POST['fami_parent_1_sol'] ?? '';
    $fami_nombre_2_sol = $_POST['fami_nombre_2_sol'] ?? '';
    $fami_cel_2_sol = $_POST['fami_cel_2_sol'] ?? '';
    $fami_tel_2_sol = $_POST['fami_tel_2_sol'] ?? '';
    $fami_parent_2_sol = $_POST['fami_parent_2_sol'] ?? '';
    $refer_nombre_1_sol = $_POST['refer_nombre_1_sol'] ?? '';
    $refer_cel_1_sol = $_POST['refer_cel_1_sol'] ?? '';
    $refer_tel_1_sol = $_POST['refer_tel_1_sol'] ?? '';
    $refer_nombre_2_sol = $_POST['refer_nombre_2_sol'] ?? '';
    $refer_cel_2_sol = $_POST['refer_cel_2_sol'] ?? '';
    $refer_tel_2_sol = $_POST['refer_tel_2_sol'] ?? '';
    $id_solicitud = $_POST['id_solicitud'] ?? '';
    $fecha_edit_sol = date("Y-m-d H:i:s");

    $atendido_por = $_POST['atendido_por'] ?? '';

    // Construir query
    $query = "UPDATE solicitudes SET 
    tipo_doc_aso = '$tipo_doc_aso',
    cedula_aso = '$cedula_aso',
    nombre_aso = '$nombre_aso',
    direccion_aso = '$direccion_aso',
    fecha_exp_doc_aso = '$fecha_exp_doc_aso',
    pais_exp_cedula_aso = '$pais_exp_cedula_aso',
    dpto_exp_cedula_aso = '$dpto_exp_cedula_aso',
    ciudad_exp_cedula_aso = '$ciudad_exp_cedula_aso',
    fecha_nacimiento_aso = '$fecha_nacimiento_aso',
    pais_naci_aso = '$pais_naci_aso',
    dpto_naci_aso = '$dpto_naci_aso',
    ciudad_naci_aso = '$ciudad_naci_aso',
    edad_aso = '$edad_aso',
    sexo_aso = '$sexo_aso',
    nacionalidad_aso = '$nacionalidad_aso',
    estado_civil_aso = '$estado_civil_aso',
    per_cargo_aso = '$per_cargo_aso',
    tip_vivienda_aso = '$tip_vivienda_aso',
    barrio_aso = '$barrio_aso',
    ciudad_aso = '$ciudad_aso',
    departamente_aso = '$departamente_aso',
    estrato_aso = '$estrato_aso',
    email_aso = '$email_aso',
    tel_aso = '$tel_aso',
    cel_aso = '$cel_aso',
    nivel_educa_aso = '$nivel_educa_aso',
    titulo_obte_aso = '$titulo_obte_aso',
    titulo_pos_aso = '$titulo_pos_aso',
    fecha_sol = '$fecha_sol',
    tipo_deudor_aso = '$tipo_deudor_aso',
    monto_sol = '$monto_sol',
    plazo_sol = '$plazo_sol',
    otro_plazo_sol = '$otro_plazo_sol',
    linea_cred_aso = '$linea_cred_aso',
    ocupacion_sol = '$ocupacion_sol',
    func_estad_sol = '$func_estad_sol',
    emp_labo_sol = '$emp_labo_sol',
    nit_emp_labo_sol = '$nit_emp_labo_sol',
    act_emp_labo_sol = '$act_emp_labo_sol',
    dir_emp_sol = '$dir_emp_sol',
    ciudad_emp_sol = '$ciudad_emp_sol',
    depar_emp_sol = '$depar_emp_sol',
    tel_emp_sol = '$tel_emp_sol',
    fecha_ing_emp_sol = '$fecha_ing_emp_sol',
    anti_emp_sol = '$anti_emp_sol',
    cargo_actual_emp_sol = '$cargo_actual_emp_sol',
    area_trabajo_sol = '$area_trabajo_sol',
    acti_inde_sol = '$acti_inde_sol',
    num_emple_emp_sol = '$num_emple_emp_sol',
    salario_sol = '$salario_sol',
    ing_arri_sol = '$ing_arri_sol',
    honorarios_sol = '$honorarios_sol',
    pension_sol = '$pension_sol',
    otros_ing_sol = '$otros_ing_sol',
    cuota_pres_sol = '$cuota_pres_sol',
    cuota_tar_cred_sol = '$cuota_tar_cred_sol',
    arrendo_sol = '$arrendo_sol',
    gastos_fam_sol = '$gastos_fam_sol',
    otros_gastos_sol = '$otros_gastos_sol',
    ahorro_banco_sol = '$ahorro_banco_sol',
    vehiculo_sol = '$vehiculo_sol',
    bienes_raices_sol = '$bienes_raices_sol',
    otros_activos_sol = '$otros_activos_sol',
    presta_total_sol = '$presta_total_sol',
    hipotecas_sol = '$hipotecas_sol',
    tar_cred_total_sol = '$tar_cred_total_sol',
    otros_pasivos_sol = '$otros_pasivos_sol',
    ahorros_sol = '$ahorros_sol',
    otro_ahorros_sol = '$otro_ahorros_sol',
    valor_ahor_sol = '$valor_ahor_sol',
    enseres_sol = '$enseres_sol',
    valor_enser_sol = '$valor_enser_sol',
    conyu_nombre_sol = '$conyu_nombre_sol',
    conyu_cedula_sol = '$conyu_cedula_sol',
    conyu_naci_sol = '$conyu_naci_sol',
    conyu_exp_sol = '$conyu_exp_sol',
    conyu_ciudadn_sol = '$conyu_ciudadn_sol',
    conyu_dpton_sol = '$conyu_dpton_sol',
    conyu_paism_sol = '$conyu_paism_sol',
    conyu_correo_sol = '$conyu_correo_sol',
    conyu_ocupacion_sol = '$conyu_ocupacion_sol',
    conyu_func_sol = '$conyu_func_sol',
    conyu_emp_lab_sol = '$conyu_emp_lab_sol',
    conyu_cargo_sol = '$conyu_cargo_sol',
    conyu_salario_sol = '$conyu_salario_sol',
    conyu_dir_lab_sol = '$conyu_dir_lab_sol',
    conyu_tel_lab_sol = '$conyu_tel_lab_sol',
    conyu_ciudad_lab_sol = '$conyu_ciudad_lab_sol',
    conyu_dpto_lab_sol = '$conyu_dpto_lab_sol',
    fami_nombre_1_sol = '$fami_nombre_1_sol',
    fami_cel_1_sol = '$fami_cel_1_sol',
    fami_tel_1_sol = '$fami_tel_1_sol',
    fami_parent_1_sol = '$fami_parent_1_sol',
    fami_nombre_2_sol = '$fami_nombre_2_sol',
    fami_cel_2_sol = '$fami_cel_2_sol',
    fami_tel_2_sol = '$fami_tel_2_sol',
    fami_parent_2_sol = '$fami_parent_2_sol',
    refer_nombre_1_sol = '$refer_nombre_1_sol',
    refer_cel_1_sol = '$refer_cel_1_sol',
    refer_tel_1_sol = '$refer_tel_1_sol',
    refer_nombre_2_sol = '$refer_nombre_2_sol',
    refer_cel_2_sol = '$refer_cel_2_sol',
    refer_tel_2_sol = '$refer_tel_2_sol',
    fecha_edit_solicitud = '$fecha_edit_sol'
WHERE id_solicitud = '$id_solicitud'";

    if ($mysqli->query($query)) {
        //borrar y crear vehiculos
        $deleteVehiculoQuery = "DELETE FROM vehiculos WHERE id_solicitud = '$id_solicitud'";
        $mysqli->query($deleteVehiculoQuery);
        // 2. Insertar todos los vehículos que vienen del formulario
        $tipos = $_POST['tipo_vehi'] ?? [];
        $modelos = $_POST['modelo'] ?? [];
        $marcas = $_POST['marca'] ?? [];
        $placas = $_POST['placa'] ?? [];
        $valores = $_POST['valor_comer'] ?? [];

        for ($i = 0; $i < count($tipos); $i++) {
            $tipo = $mysqli->real_escape_string($tipos[$i]);
            $modelo = intval($modelos[$i]); // modelo es numérico
            $marca = $mysqli->real_escape_string($marcas[$i]);
            $placa = $mysqli->real_escape_string($placas[$i]);
            $valor = floatval($valores[$i]);

            // Solo insertar si algún campo obligatorio no está vacío (ejemplo placa o tipo)
            if (!empty($tipo) && !empty($placa)) {
                $sql_insert = "INSERT INTO vehiculos (id_solicitud, tipo, modelo, marca, placa, valor_comercial) VALUES 
            ($id_solicitud, '$tipo', $modelo, '$marca', '$placa', $valor)";
                $mysqli->query($sql_insert);
            }
        }

        //borrar y crear inmuebles
        $deleteInmuebleQuery = "DELETE FROM inmuebles WHERE id_solicitud = '$id_solicitud'";
        $mysqli->query($deleteInmuebleQuery);
        // 2. Insertar los inmuebles recibidos del formulario
        $tipos = $_POST['tipo_inmu'] ?? [];
        $direcciones = $_POST['direccion'] ?? [];
        $valores = $_POST['valor_comer'] ?? [];

        for ($i = 0; $i < count($tipos); $i++) {
            $tipo = $mysqli->real_escape_string($tipos[$i]);
            $direccion = $mysqli->real_escape_string($direcciones[$i]);
            $valor = floatval($valores[$i]);

            // Validar que al menos un campo obligatorio no esté vacío (ej. tipo o dirección)
            if (!empty($tipo) && !empty($direccion)) {
                $sql_insert = "INSERT INTO inmuebles (id_solicitud, tipo, direccion, valor_comercial)
                       VALUES ($id_solicitud, '$tipo', '$direccion', $valor)";
                $mysqli->query($sql_insert);
            }
        }



        //insertar en la tabla atenciones y en fecha_solicitud
        // Verificar si ya existe un registro con ese id_solicitud y que tenga fecha_solicitud
        $checkQuery = "SELECT id_atencion FROM atenciones WHERE id_solicitud = '$id_solicitud' AND fecha_solicitud IS NOT NULL";
        $result = $mysqli->query($checkQuery);

        if ($result && $result->num_rows > 0) {
            // Ya existe, entonces actualizamos
            $updateQuery = "UPDATE atenciones SET id_usu = '$atendido_por', fecha_solicitud = '$fecha_edit_sol' WHERE id_solicitud = '$id_solicitud'";
            if ($mysqli->query($updateQuery) === TRUE) {
                //echo "Registro actualizado correctamente.";
            } else {
                error_log("Error al actualizar en la tabla atenciones: " . $mysqli->error);
            }
        } else {
            // No existe o no tiene fecha_solicitud, entonces insertamos
            $insertQuery = "INSERT INTO atenciones (id_solicitud, id_usu, fecha_solicitud) VALUES ('$id_solicitud', '$atendido_por', '$fecha_edit_sol')";
            if ($mysqli->query($insertQuery) === TRUE) {
                //echo "Registro insertado correctamente.";
            } else {
                error_log("Error al insertar en la tabla atenciones: " . $mysqli->error);
            }
        }        //cargar archivos
        $uploadDir = __DIR__ . '/documentos/'; // Carpeta 'documentos' en la misma ubicación del script
        $erroresArchivos = [];
        $archivosSubidos = [];

        // Verificar que el directorio existe y es escribible
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $erroresArchivos[] = "No se pudo crear el directorio: $uploadDir";
            }
        }
        
        if (!is_writable($uploadDir)) {
            $erroresArchivos[] = "El directorio no tiene permisos de escritura: $uploadDir";
        }

        // Información de debug sobre límites de PHP
        $maxFileSize = ini_get('upload_max_filesize');
        $maxPostSize = ini_get('post_max_size');
        $maxInputTime = ini_get('max_input_time');
        $memoryLimit = ini_get('memory_limit');
        
        error_log("DEBUG UPDATE - Límites PHP: upload_max_filesize=$maxFileSize, post_max_size=$maxPostSize, max_input_time=$maxInputTime, memory_limit=$memoryLimit");

        // Validar si hay archivos para procesar
        $hayArchivos = false;
        if (isset($_FILES['archivos']) && is_array($_FILES['archivos']['error'])) {
            foreach ($_FILES['archivos']['error'] as $error) {
                if ($error === UPLOAD_ERR_OK) {
                    $hayArchivos = true;
                    break;
                }
            }
        } else {
            // Caso cuando no se envían archivos o el campo está vacío
            if (isset($_FILES['archivos']) && $_FILES['archivos']['error'][0] === UPLOAD_ERR_NO_FILE) {
                error_log("DEBUG UPDATE - No se seleccionaron archivos para subir");
            } else {
                error_log("DEBUG UPDATE - No se recibieron archivos o la estructura de archivos es incorrecta");
            }
        }

        // Función para convertir códigos de error en mensajes legibles
        function getUploadErrorMessage($errorCode) {
            switch ($errorCode) {
                case UPLOAD_ERR_OK:
                    return 'Sin errores';
                case UPLOAD_ERR_INI_SIZE:
                    return 'El archivo excede upload_max_filesize del php.ini';
                case UPLOAD_ERR_FORM_SIZE:
                    return 'El archivo excede MAX_FILE_SIZE del formulario';
                case UPLOAD_ERR_PARTIAL:
                    return 'El archivo fue subido parcialmente';
                case UPLOAD_ERR_NO_FILE:
                    return 'No se subió ningún archivo';
                case UPLOAD_ERR_NO_TMP_DIR:
                    return 'Falta la carpeta temporal';
                case UPLOAD_ERR_CANT_WRITE:
                    return 'Error al escribir el archivo en disco';
                case UPLOAD_ERR_EXTENSION:
                    return 'Una extensión de PHP detuvo la subida';
                default:
                    return 'Error desconocido: ' . $errorCode;
            }
        }

        if ($hayArchivos) {
            foreach ($_FILES['archivos']['name'] as $index => $fileName) {
                $uploadError = $_FILES['archivos']['error'][$index];
                $fileSize = $_FILES['archivos']['size'][$index];
                $tmpName = $_FILES['archivos']['tmp_name'][$index];
                
                if ($uploadError === UPLOAD_ERR_OK) {
                    $originalName = basename($fileName);
                    $originalName = preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $originalName);
                    $newFileName = $cedula_aso . '_' . $originalName;
                    $destination = $uploadDir . $newFileName;
                    
                    // Verificaciones adicionales
                    if (!is_uploaded_file($tmpName)) {
                        $erroresArchivos[] = "Archivo $fileName: No es un archivo subido válido";
                        continue;
                    }
                    
                    if ($fileSize <= 0) {
                        $erroresArchivos[] = "Archivo $fileName: Tamaño de archivo inválido ($fileSize bytes)";
                        continue;
                    }
                    
                    // Verificar espacio en disco
                    $espacioLibre = disk_free_space($uploadDir);
                    if ($espacioLibre !== false && $fileSize > $espacioLibre) {
                        $erroresArchivos[] = "Archivo $fileName: No hay suficiente espacio en disco";
                        continue;
                    }
                    
                    error_log("DEBUG UPDATE - Intentando mover archivo: $tmpName -> $destination");
                    
                    if (move_uploaded_file($tmpName, $destination)) {
                        $archivosSubidos[] = $fileName;
                        error_log("ÉXITO UPDATE - Archivo movido: $originalName");
                        
                        // Verificar que el archivo realmente existe
                        if (file_exists($destination)) {
                            $tamaño = filesize($destination);
                            error_log("CONFIRMADO UPDATE - Archivo existe: $destination (Tamaño: $tamaño bytes)");
                        } else {
                            $erroresArchivos[] = "Archivo $fileName: Se movió pero no existe en destino";
                        }
                    } else {
                        $error = error_get_last();
                        $erroresArchivos[] = "Archivo $fileName: Error al mover - " . ($error['message'] ?? 'Error desconocido');
                        error_log("ERROR UPDATE - No se pudo mover: $originalName. Error: " . ($error['message'] ?? 'desconocido'));
                    }
                } else {
                    $errorMsg = getUploadErrorMessage($uploadError);
                    $erroresArchivos[] = "Archivo $fileName: $errorMsg";
                    error_log("ERROR UPDATE - Archivo $fileName: $errorMsg");
                }
            }
        } else {
            error_log("INFO UPDATE - Usuario no subió archivos nuevos, continuando sin archivos");
        }

        // Preparar mensaje de resultado
        $mensajeArchivos = "";
        if (!empty($archivosSubidos)) {
            $mensajeArchivos .= "Archivos subidos exitosamente: " . implode(", ", $archivosSubidos);
        }
        if (!empty($erroresArchivos)) {
            $mensajeArchivos .= ($mensajeArchivos ? "\\n\\n" : "") . "Errores de archivos:\\n" . implode("\\n", $erroresArchivos);
        }
        
        if (empty($mensajeArchivos)) {
            $mensajeArchivos = "Actualización exitosa (sin archivos nuevos)";
        }        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Resultado</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: '" . (empty($erroresArchivos) ? 'success' : 'warning') . "',
                    title: 'Actualización Exitosa',
                    html: 'Solicitud actualizada correctamente.<br><br><strong>Estado de archivos:</strong><br>" . str_replace("\n", "<br>", addslashes($mensajeArchivos)) . "',
                    confirmButtonText: 'OK',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'seeSolicitud.php';
                    }
                });
            </script>
        </body>
        </html>";
    } else {
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
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'seeSolicitud.php';
                    }
                });
            </script>
        </body>
        </html>";
    }

    $mysqli->close();
} else {
    echo "Método no permitido.";
}
