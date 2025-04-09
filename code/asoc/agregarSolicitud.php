<?php
    // Muestra todos los errores de PHP
    /*error_reporting(E_ALL);
    ini_set('display_errors', '1');*/

    include("../../conexion.php");
    session_start();

    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
        exit();
    }
 
    	$tipo_doc_aso 			   = $_POST['tipo_doc_aso'];
    	$cedula_aso 		       = $_POST['cedula_aso'];
    	$nombre_aso 		       = $_POST['nombre_aso'];
    	$direccion_aso 	           = $_POST['direccion_aso'];
    	$fecha_exp_doc_aso 		   = ('0000-00-00 00:00:00');
        $pais_exp_cedula_aso       = $_POST['pais_exp_cedula_aso'];
        $dpto_exp_cedula_aso 	   = $_POST['dpto_exp_cedula_aso'];
    	$ciudad_exp_cedula_aso     = $_POST['ciudad_exp_cedula_aso'];
    	$fecha_nacimiento_aso      = ('0000-00-00 00:00:00');
    	$pais_naci_aso 		       = $_POST['pais_naci_aso'];
        $dpto_naci_aso             = $_POST['dpto_naci_aso'];
        $ciudad_naci_aso           = $_POST['ciudad_naci_aso'];
        $edad_aso                  = $_POST['edad_aso'];
        $sexo_aso                  = $_POST['sexo_aso'];
        $nacionalidad_aso          = $_POST['nacionalidad_aso'];
    	$estado_civil_aso 	       = $_POST['estado_civil_aso'];
        $per_cargo_aso             = $_POST['per_cargo_aso'];
        $tip_vivienda_aso          = $_POST['tip_vivienda_aso'];
        $barrio_aso                = $_POST['barrio_aso'];
        $ciudad_aso                = $_POST['ciudad_aso'];
        $departamente_aso          = $_POST['departamente_aso'];
        $estrato_aso               = $_POST['estrato_aso'];
        $email_aso                 = $_POST['email_aso'];
        $tel_aso                   = $_POST['tel_aso'];
        $cel_aso                   = $_POST['cel_aso'];
        $nivel_educa_aso           = $_POST['nivel_educa_aso'];
        $titulo_obte_aso           = $_POST['titulo_obte_aso'];
        $titulo_pos_aso            = $_POST['titulo_pos_aso'];
        $fecha_sol                 = date('Y-m-d h:i:s');
        $tipo_deudor_aso           = $_POST['tipo_deudor_aso'];
        $monto_sol                 = $_POST['monto_sol'];
        $plazo_sol                 = $_POST['plazo_sol'];
        $linea_cred_aso            = $_POST['linea_cred_aso'];
        $ocupacion_sol             = $_POST['ocupacion_sol'];
        $func_estad_sol            = $_POST['func_estad_sol'];
        $emp_labo_sol              = $_POST['emp_labo_sol'];
        $nit_emp_labo_sol          = $_POST['nit_emp_labo_sol'];
        $act_emp_labo_sol          = $_POST['act_emp_labo_sol'];
        $dir_emp_sol               = $_POST['dir_emp_sol'];
        $ciudad_emp_sol            = $_POST['ciudad_emp_sol'];
        $depar_emp_sol             = $_POST['depar_emp_sol'];
        $tel_emp_sol               = $_POST['tel_emp_sol'];
        $fecha_ing_emp_sol         = ('0000-00-00 00:00:00');
        $anti_emp_sol              = $_POST['anti_emp_sol'];
        $cargo_actual_emp_sol      = $_POST['cargo_actual_emp_sol'];
        $area_trabajo_sol          = $_POST['area_trabajo_sol'];
        $acti_inde_sol             = $_POST['acti_inde_sol'];
        $num_emple_emp_sol         = $_POST['num_emple_emp_sol'];
        $salario_sol               = $_POST['salario_sol'];
        $ing_arri_sol              = $_POST['ing_arri_sol'];
        $honorarios_sol            = $_POST['honorarios_sol'];
        $pension_sol               = $_POST['pension_sol'];
        $otros_ing_sol             = $_POST['otros_ing_sol'];
        $cuota_pres_sol            = $_POST['cuota_pres_sol'];
        $cuota_tar_cred_sol        = $_POST['cuota_tar_cred_sol'];
        $arrendo_sol               = $_POST['arrendo_sol'];
        $gastos_fam_sol            = $_POST['gastos_fam_sol'];
        $otros_gastos_sol          = $_POST['otros_gastos_sol'];
        $ahorro_banco_sol          = $_POST['ahorro_banco_sol'];
        $vehiculo_sol              = $_POST['vehiculo_sol'];
        $bienes_raices_sol         = $_POST['bienes_raices_sol'];
        $otros_activos_sol         = $_POST['otros_activos_sol'];
        $presta_total_sol          = $_POST['presta_total_sol'];
        $hipotecas_sol             = $_POST['hipotecas_sol'];
        $tar_cred_total_sol        = $_POST['tar_cred_total_sol'];
        $otros_pasivos_sol         = $_POST['otros_pasivos_sol'];
        $tipo_inmu_1_sol           = $_POST['tipo_inmu_1_sol'];
        $direccion_1_sol           = $_POST['direccion_1_sol'];
        $valor_comer_1_sol         = $_POST['valor_comer_1_sol'];
        $tipo_inmu_2_sol           = $_POST['tipo_inmu_2_sol'];
        $direccion_2_sol           = $_POST['direccion_2_sol'];
        $valor_comer_2_sol         = $_POST['valor_comer_2_sol'];
        $tipo_vehi_1_sol           = $_POST['tipo_vehi_1_sol'];
        $modelo_1_sol              = $_POST['modelo_1_sol'];
        $marca_1_sol               = $_POST['marca_1_sol'];
        $placa_1_sol               = $_POST['placa_1_sol'];
        $valor_1_sol               = $_POST['valor_1_sol'];
        $tipo_vehi_2_sol           = $_POST['tipo_vehi_2_sol'];
        $modelo_2_sol              = $_POST['modelo_2_sol'];
        $marca_2_sol               = $_POST['marca_2_sol'];
        $placa_2_sol               = $_POST['placa_2_sol'];
        $valor_2_sol               = $_POST['valor_2_sol'];
        $ahorros_sol               = $_POST['ahorros_sol'];
        $valor_ahor_sol            = $_POST['valor_ahor_sol'];
        $enseres_sol               = $_POST['enseres_sol'];
        $valor_enser_sol           = $_POST['valor_enser_sol'];
        $conyu_nombre_sol          = $_POST['conyu_nombre_sol'];
        $conyu_cedula_sol          = $_POST['conyu_cedula_sol'];
        $conyu_naci_sol            = ('0000-00-00 00:00:00');
        $conyu_exp_sol             = $_POST['conyu_exp_sol'];
        $conyu_ciudadn_sol         = $_POST['conyu_ciudadn_sol'];
        $conyu_dpton_sol           = $_POST['conyu_dpton_sol'];
        $conyu_paism_sol           = $_POST['conyu_paism_sol'];
        $conyu_correo_sol          = $_POST['conyu_correo_sol'];
        $conyu_ocupacion_sol       = $_POST['conyu_ocupacion_sol'];
        $conyu_func_sol            = $_POST['conyu_func_sol'];
        $conyu_emp_lab_sol         = $_POST['conyu_emp_lab_sol'];
        $conyu_cargo_sol           = $_POST['conyu_cargo_sol'];
        $conyu_salario_sol         = $_POST['conyu_salario_sol'];
        $conyu_dir_lab_sol         = $_POST['conyu_dir_lab_sol'];
        $conyu_tel_lab_sol         = $_POST['conyu_tel_lab_sol'];
        $conyu_ciudad_lab_sol      = $_POST['conyu_ciudad_lab_sol'];
        $conyu_dpto_lab_sol        = $_POST['conyu_dpto_lab_sol'];
        $fami_nombre_1_sol         = $_POST['fami_nombre_1_sol'];
        $fami_cel_1_sol            = $_POST['fami_cel_1_sol'];
        $fami_tel_1_sol            = $_POST['fami_tel_1_sol'];
        $fami_parent_1_sol         = $_POST['fami_parent_1_sol'];
        $fami_nombre_2_sol         = $_POST['fami_nombre_2_sol'];
        $fami_cel_2_sol            = $_POST['fami_cel_2_sol'];
        $fami_tel_2_sol            = $_POST['fami_tel_2_sol'];
        $fami_parent_2_sol         = $_POST['fami_parent_2_sol'];
        $refer_nombre_1_sol        = $_POST['refer_nombre_1_sol'];
        $refer_cel_1_sol           = $_POST['refer_cel_1_sol'];
        $refer_tel_1_sol           = $_POST['refer_tel_1_sol'];
        $refer_nombre_2_sol        = $_POST['refer_nombre_2_sol'];
        $refer_cel_2_sol           = $_POST['refer_cel_2_sol'];
        $refer_tel_2_sol           = $_POST['refer_tel_2_sol'];

        // Insertar en la tabla CONTRATOS
    $query_contratos = "INSERT INTO capta_comercial (
    tipo_doc_aso, cedula_aso, nombre_aso, direccion_aso, fecha_exp_doc_aso, pais_exp_cedula_aso, dpto_exp_cedula_aso, ciudad_exp_cedula_aso,
    fecha_nacimiento_aso, pais_naci_aso, dpto_naci_aso, ciudad_naci_aso, edad_aso, sexo_aso, nacionalidad_aso,
    estado_civil_aso, per_cargo_aso, tip_vivienda_aso, barrio_aso, ciudad_aso, departamente_aso,
    estrato_aso, email_aso, tel_aso, cel_aso, nivel_educa_aso, titulo_obte_aso, titulo_pos_aso,
    fecha_sol, tipo_deudor_aso, monto_sol, plazo_sol, linea_cred_aso, ocupacion_sol, func_estad_sol,
    emp_labo_sol, nit_emp_labo_sol, act_emp_labo_sol, dir_emp_sol, ciudad_emp_sol, depar_emp_sol, tel_emp_sol, fecha_ing_emp_sol,
    anti_emp_sol, cargo_actual_emp_sol, area_trabajo_sol, acti_inde_sol, num_emple_emp_sol,
    salario_sol, ing_arri_sol, honorarios_sol, pension_sol, otros_ing_sol, cuota_pres_sol,
    cuota_tar_cred_sol, arrendo_sol, gastos_fam_sol, otros_gastos_sol, ahorro_banco_sol, vehiculo_sol, bienes_raices_sol, otros_activos_sol,
    presta_total_sol, hipotecas_sol, tar_cred_total_sol, otros_pasivos_sol, tipo_inmu_1_sol, direccion_1_sol,
    valor_comer_1_sol, tipo_inmu_2_sol, direccion_2_sol, valor_comer_2_sol, tipo_vehi_1_sol, modelo_1_sol,
    marca_1_sol, placa_1_sol, valor_1_sol, tipo_vehi_2_sol, modelo_2_sol, internet_telefonia_cap,
    marca_2_sol, placa_2_sol, valor_2_sol, ahorros_sol, valor_ahor_sol, enseres_sol, valor_enser_sol,
    conyu_nombre_sol, conyu_cedula_sol, conyu_naci_sol, conyu_exp_sol, conyu_ciudadn_sol, conyu_dpton_sol,
    conyu_paism_sol, conyu_correo_sol, conyu_ocupacion_sol, conyu_func_sol, conyu_emp_lab_sol, conyu_cargo_sol, conyu_salario_sol, conyu_dir_lab_sol,
    conyu_tel_lab_sol, conyu_ciudad_lab_sol, conyu_dpto_lab_sol, fami_nombre_1_sol, fami_cel_1_sol, fami_tel_1_sol,
    fami_parent_1_sol, fami_nombre_2_sol, fami_cel_2_sol, fami_tel_2_sol, fami_parent_2_sol, refer_nombre_1_sol,
    refer_cel_1_sol, refer_tel_1_sol, refer_nombre_2_sol, refer_cel_2_sol, refer_tel_2_sol)
VALUES (
    '$tipo_doc_aso', '$cedula_aso', '$nombre_aso', '$direccion_aso', '$fecha_exp_doc_aso', '$pais_exp_cedula_aso', '$dpto_exp_cedula_aso',
    '$ciudad_exp_cedula_aso', '$fecha_nacimiento_aso', '$pais_naci_aso', '$dpto_naci_aso', '$ciudad_naci_aso', '$edad_aso',
    '$sexo_aso', '$nacionalidad_aso', '$estado_civil_aso', '$per_cargo_aso', '$tip_vivienda_aso', '$barrio_aso',
    '$ciudad_aso', '$departamente_aso', '$estrato_aso', '$email_aso', '$tel_aso', '$cel_aso',
    '$nivel_educa_aso', '$titulo_obte_aso', '$titulo_pos_aso', '$fecha_sol', '$tipo_deudor_aso', '$monto_sol',
    '$plazo_sol', '$linea_cred_aso', '$ocupacion_sol', '$func_estad_sol', '$emp_labo_sol', '$nit_emp_labo_sol', '$act_emp_labo_sol',
    '$dir_emp_sol', '$ciudad_emp_sol', '$depar_emp_sol', '$tel_emp_sol', '$fecha_ing_emp_sol', '$anti_emp_sol',
    '$cargo_actual_emp_sol', '$area_trabajo_sol', '$acti_inde_sol', '$num_emple_emp_sol', '$salario_sol',
    '$ing_arri_sol', '$honorarios_sol', '$pension_sol', '$otros_ing_sol', '$cuota_pres_sol', '$cuota_tar_cred_sol',
    '$arrendo_sol', '$gastos_fam_sol', '$otros_gastos_sol', '$ahorro_banco_sol', '$vehiculo_sol', '$bienes_raices_sol', '$otros_activos_sol',
    '$presta_total_sol', '$hipotecas_sol', '$tar_cred_total_sol', '$otros_pasivos_sol', '$tipo_inmu_1_sol',
    '$direccion_1_sol', '$valor_comer_1_sol', '$tipo_inmu_2_sol', '$direccion_2_sol', '$valor_comer_2_sol', '$tipo_vehi_1_sol',
    '$modelo_1_sol', '$marca_1_sol', '$placa_1_sol', '$valor_1_sol', '$tipo_vehi_2_sol',
    '$modelo_2_sol', '$internet_telefonia_cap', '$marca_2_sol', '$placa_2_sol', '$valor_2_sol', '$ahorros_sol', '$valor_ahor_sol', '$enseres_sol', '$valor_enser_sol', '$conyu_nombre_sol', '$conyu_cedula_sol', '$conyu_naci_sol',
    '$conyu_exp_sol', '$conyu_ciudadn_sol', '$conyu_dpton_sol', '$conyu_paism_sol', '$conyu_correo_sol',
    '$conyu_ocupacion_sol', '$conyu_func_sol', '$conyu_emp_lab_sol', '$conyu_cargo_sol', '$conyu_salario_sol', '$conyu_dir_lab_sol', '$conyu_tel_lab_sol',
    '$conyu_ciudad_lab_sol', '$conyu_dpto_lab_sol', '$fami_nombre_1_sol', '$fami_cel_1_sol', '$fami_tel_1_sol',
    '$fami_parent_1_sol', '$fami_nombre_2_sol', '$fami_cel_2_sol', '$fami_tel_2_sol', '$fami_parent_2_sol',
    '$refer_nombre_1_sol', '$refer_cel_1_sol', '$refer_tel_1_sol', '$refer_nombre_2_sol', '$refer_cel_2_sol', '$refer_tel_2_sol')";

    mysqli_query($mysqli, $query_contratos);

    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    echo "
            <!DOCTYPE html>
                <html lang='es'>
                    <head>
                        <meta charset='utf-8' />
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                        <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                        <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                        <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                        <script src='https://kit.fontawesome.com/fed2435e21.js' crossorigin='anonymous'></script>
                        <title>VISION | SOFT</title>
                        <style>
                            .responsive {
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                    </head>
                    <body>
                        <center>
                           <img src='../../img/logo.png' width=300 height=212 class='responsive'>
                        <div class='container'>
                            <br />
                            <h3><b><i class='fa-solid fa-building-circle-check'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                            <p align='center'><a href='showprecap.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                        </div>
                        </center>
                    </body>
                </html>
            ";
?>
