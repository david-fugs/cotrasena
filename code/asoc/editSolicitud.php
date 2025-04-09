<?php

    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_SESSION['id_usu'])) {
        header("Location: ../../index.php");
        exit();  // Asegurarse de que el script se detiene después de redireccionar
    }

    // Usar $_SESSION['nombre'] en lugar de $_SESSION['nombre_usu']
    $nombre_usu = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
    $nit_cc_ase = isset($_SESSION['nit_cc_ase']) ? $_SESSION['nit_cc_ase'] : '';

    $nombre_usu_safe = htmlspecialchars($nombre_usu, ENT_QUOTES, 'UTF-8');
    $nit_cc_ase_safe = htmlspecialchars($nit_cc_ase, ENT_QUOTES, 'UTF-8');
   
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Bogota");
    
    // Si el campo 'internet_telefonia_cap' está vacío, inicializamos el array vacío
    $internet_telefonia_seleccionados = [];
    if (!empty($row['internet_telefonia_cap'])) {
        // Solo explota si no está vacío
        $internet_telefonia_seleccionados = explode(',', $row['internet_telefonia_cap']);
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VISION | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/popper.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
        /* Reducir el tamaño de la fuente en los labels y añadir color gris claro */
        label {
            font-size: 10px; /* Ajuste entre 9 y 10px */
            font-weight: bold;
            color: #000000; /* Color gris muy claro */
            transition: color 0.3s ease; /* Transición suave para el cambio de color */
        }
        /* Ajustar tamaño de las cajas de texto y select para que sean iguales */
        input.form-control, select.form-control {
            font-size: 10px; /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem; /* Ajusta el relleno para hacer las cajas más compactas */
            color: black; /* Texto en negro */
            box-sizing: border-box; /* Asegura que el padding se incluya dentro de la altura */
            height: 32px; /* Fija la altura de input y select para que sean iguales */
        }

        textarea.form-control {
            font-size: 10px; /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem; /* Ajusta el relleno para hacer las cajas más compactas */
            color: black; /* Texto en negro */
            box-sizing: border-box; /* Asegura que el padding se incluya dentro de la altura */
        }
        /* Aplicar fondo pastel cuando el input o select está en foco */
        input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
            background-color: #f0e68c; /* Fondo color pastel */
            outline: none; /* Eliminar borde azul de enfoque en navegadores */
        }
        /* Resaltar el label cuando el input o select está en foco */
        .form-group:focus-within label {
            color: #c68615; /* Cambia el color del label cuando el input o select está en foco */
        }
    .form-container {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        legend {
            font-weight: bold;
            font-size: 0.9em;
            color: #4a4a4a;
            padding: 0 10px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* Efecto de enfoque para el fieldset */
        fieldset:focus-within {
            background-color: #e6f7ff; /* Azul muy claro */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3); /* Sombreado azul claro */
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.select2').select2(); // Inicializar Select2 en todos los selectores con clase 'select2'
        });
    </script>
    <script>
        function ordenarSelect(id_componente) {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function (a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }

        $(document).ready(function () {
            ordenarSelect('cod_dane_dep');
            ordenarSelect('id_mun');
        });
    </script>
</head>
<body >
    <?php
        include("../../conexion.php");
        $id_cap  = $_GET['id_cap'];
        if (isset($_GET['id_cap'])) {
            $sql = mysqli_query($mysqli, "SELECT * FROM capta_comercial WHERE id_cap = '$id_cap'");
            $row = mysqli_fetch_array($sql);
            
            // Convertir los valores almacenados en un array
            $internet_telefonia_seleccionados = explode(',', $row['internet_telefonia_cap']);
        }
    ?>


   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-building-circle-check"></i> COMPLETAR REGISTRO CAPTACIÓN COMERCIAL</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='editcap1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <fieldset>
                    <legend>DATOS PERSONALES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tipo_doc_aso">* TIPO DOCUMENTO</label>
                            <select class="form-control" name="tipo_doc_aso">
                                <option value=""></option>   
                                <option value="1" <?php if($row['tipo_doc_aso']=='1'){echo 'selected';} ?>>C.C.</option>
                                <option value="0" <?php if($row['tipo_doc_aso']=='0'){echo 'selected';} ?>>C.E.</option>
                                <option value="2" <?php if($row['tipo_doc_aso']=='2'){echo 'selected';} ?>>PASAPORTE</option>
                                <option value="3" <?php if($row['tipo_doc_aso']=='3'){echo 'selected';} ?>>OTRO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cedula_aso">* CÉDULA No.</label>
                            <input type='number' name='cedula_aso' class='form-control' id="cedula_aso" autofocus value='<?php echo $row['cedula_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="nombre_aso">NOMBRE ASOCIADO</label>
                            <input type="text" name="nombre_aso" class="form-control" value='<?php echo $row['nombre_aso']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="direccion_aso">DIRECCIÓN</label>
                            <input type='text' name='direccion_aso' class='form-control' id="direccion_aso" value='<?php echo $row['direccion_aso']; ?>' />
                        </div>
                    </div>
           
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_exp_doc_aso">* FECHA EXPEDICION</label>
                            <input type='date' name='fecha_exp_doc_aso' class='form-control' id="fecha_exp_doc_aso" value='<?php echo $row['fecha_exp_doc_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="pais_exp_cedula_aso">* PAIS EXPEDICION</label>
                            <input type='text' name='pais_exp_cedula_aso' class='form-control' id="pais_exp_cedula_aso" value='<?php echo $row['pais_exp_cedula_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="dpto_exp_cedula_aso">* DEPARTAMENTO EXPEDICION</label>
                            <input type='text' name='dpto_exp_cedula_aso' class='form-control' id="dpto_exp_cedula_aso"  value='<?php echo $row['dpto_exp_cedula_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_exp_cedula_aso">* CIUDAD EXPEDICION</label>
                            <input type='text' name='ciudad_exp_cedula_aso' class='form-control' id="ciudad_exp_cedula_aso" value='<?php echo $row['ciudad_exp_cedula_aso']; ?>' />
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_nacimiento_aso">* FECHA NACIMIENTO</label>
                            <input type='date' name='fecha_nacimiento_aso' class='form-control' id="fecha_nacimiento_aso" value='<?php echo $row['fecha_nacimiento_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="pais_naci_aso">* PAIS NACIMIENTO</label>
                            <input type='text' name='pais_naci_aso' class='form-control' id="pais_naci_aso" value='<?php echo $row['pais_naci_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="dpto_naci_aso">* DEPARTAMENTO NACIMIENTO</label>
                            <input type='text' name='dpto_naci_aso' class='form-control' id="dpto_naci_aso" value='<?php echo $row['dpto_naci_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_naci_aso">* CIUDAD NACIMIENTO</label>
                            <input type='text' name='ciudad_naci_aso' class='form-control' id="ciudad_naci_aso" value='<?php echo $row['ciudad_naci_aso']; ?>' />
                        </div>
                    </div>
         
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="edad_aso">* EDAD</label>
                            <input type='number' name='edad_aso' class='form-control' id="edad_aso" value='<?php echo $row['edad_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sexo_aso">* SEXO</label>
                            <select class="form-control" name="sexo_aso" >
                                <option value=""></option>   
                                <option value="FEMENINO" <?php if($row['sexo_aso']=='FEMENINO'){echo 'selected';} ?>>FEMENINO</option>
                                <option value="MASCULINO" <?php if($row['sexo_aso']=='MASCULINO'){echo 'selected';} ?>>MASCULINO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="nacionalidad_aso">* NACIONALIDAD</label>
                            <input type='text' name='nacionalidad_aso' class='form-control' id="nacionalidad_aso"  value='<?php echo $row['nacionalidad_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estado_civil_aso">* ESTADO CIVIL</label>
                            <select class="form-control" name="estado_civil_aso" >
                                <option value=""></option>   
                                <option value="SOLTERO (A)" <?php if($row['estado_civil_aso']=='SOLTERO (A)'){echo 'selected';} ?>>SOLTERO (A)</option>
                                <option value="CASADO (A)" <?php if($row['estado_civil_aso']=='CASADO (A)'){echo 'selected';} ?>>CASADO (A)</option>
                                <option value="UNION LIBRE" <?php if($row['estado_civil_aso']=='UNION LIBRE'){echo 'selected';} ?>>UNION LIBRE</option>
                                <option value="DIVORCIADO (A)" <?php if($row['estado_civil_aso']=='DIVORCIADO (A)'){echo 'selected';} ?>>DIVORCIADO (A)</option>
                                <option value="VIUDO (A)" <?php if($row['estado_civil_aso']=='VIUDO (A)'){echo 'selected';} ?>>VIUDO (A)</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="per_cargo_aso">* PERSONAS A CARGO</label>
                            <input type='number' name='per_cargo_aso' class='form-control' id="per_cargo_aso" value='<?php echo $row['per_cargo_aso']; ?>' />
                        </div>
                    </div>
         
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tip_vivienda_aso">* TIPO DE VIVIENDA</label>
                            <select class="form-control" name="tip_vivienda_aso" >
                                <option value=""></option>   
                                <option value="ARRIENDO" <?php if($row['tip_vivienda_aso']=='ARRIENDO'){echo 'selected';} ?>>ARRIENDO</option>
                                <option value="PROPIA" <?php if($row['tip_vivienda_aso']=='PROPIA'){echo 'selected';} ?>>PROPIA</option>
                                <option value="FAMILIAR" <?php if($row['tip_vivienda_aso']=='FAMILIAR'){echo 'selected';} ?>>FAMILIAR</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="barrio_aso">* BARRIO</label>
                            <input type='text' name='barrio_aso' class='form-control' id="barrio_aso" value='<?php echo $row['barrio_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_aso">* CIUDAD</label>
                            <input type='text' name='ciudad_aso' class='form-control' id="ciudad_aso" value='<?php echo $row['ciudad_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="departamente_aso">* DEPARTAMENTO</label>
                            <input type='text' name='departamente_aso' class='form-control' id="departamente_aso" value='<?php echo $row['departamente_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estrato_aso">* ESTRATO</label>
                            <input type='number' name='estrato_aso' class='form-control' id="estrato_aso" value='<?php echo $row['estrato_aso']; ?>' />
                        </div>
                    </div>
           
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="email_aso">* EMAIL</label>
                            <input type='email' name='email_aso' class='form-control' id="email_aso" value='<?php echo $row['email_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel_aso">* TELEFONO FIJO</label>
                            <input type='number' name='tel_aso' class='form-control' id="tel_aso" value='<?php echo $row['tel_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="cel_aso">* CELULAR</label>
                            <input type='number' name='cel_aso' class='form-control' id="cel_aso" value='<?php echo $row['cel_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="nivel_educa_aso">* NIVEL EDUCATIVO</label>
                            <select class="form-control" name="nivel_educa_aso" >
                                <option value=""></option>   
                                <option value="PRIMARIA" <?php if($row['nivel_educa_aso']=='PRIMARIA'){echo 'selected';} ?>>PRIMARIA</option>
                                <option value="BACHILLER" <?php if($row['nivel_educa_aso']=='BACHILLER'){echo 'selected';} ?>>BACHILLER</option>
                                <option value="TECNICO (A)" <?php if($row['nivel_educa_aso']=='TECNICO (A)'){echo 'selected';} ?>>TECNICO (A)</option>
                                <option value="TECNOLOGO (A)" <?php if($row['nivel_educa_aso']=='TECNOLOGO (A)'){echo 'selected';} ?>>TECNOLOGO (A)</option>
                                <option value="UNIVERSITARIO (A)" <?php if($row['nivel_educa_aso']=='UNIVERSITARIO (A)'){echo 'selected';} ?>>UNIVERSITARIO (A)</option>
                                <option value="ESPECIALIZACION" <?php if($row['nivel_educa_aso']=='ESPECIALIZACION'){echo 'selected';} ?>>ESPECIALIZACION</option>
                                <option value="MAESTRIA" <?php if($row['nivel_educa_aso']=='MAESTRIA'){echo 'selected';} ?>>MAESTRIA</option>
                                <option value="DOCTORADO" <?php if($row['nivel_educa_aso']=='DOCTORADO'){echo 'selected';} ?>>DOCTORADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="titulo_obte_aso">* TITULO OBTENIDO</label>
                            <input type='text' name='titulo_obte_aso' class='form-control' id="titulo_obte_aso" value='<?php echo $row['titulo_obte_aso']; ?>' />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="titulo_pos_aso">* TITULO EN POSGRADO</label>
                            <input type='text' name='titulo_pos_aso' class='form-control' id="titulo_pos_aso" value='<?php echo $row['titulo_pos_aso']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS DEL CREDITO</legend>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_sol">* FECHA</label>
                            <input type="text" name="fecha_sol" class="form-control" id="fecha_sol" 
                            value="<?php echo date('Y-m-d H:i:s'); ?>" readonly />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_deudor_aso">* TIPO DEUDOR</label>
                            <select class="form-control" name="tipo_deudor_aso">
                                <option value=""></option>   
                                <option value="DEUDOR PRINCIPAL" <?php if($row['tipo_deudor_aso']=='DEUDOR PRINCIPAL'){echo 'selected';} ?>>DEUDOR PRINCIPAL</option>
                                <option value="DEUDOR SOLIDARIO" <?php if($row['tipo_deudor_aso']=='DEUDOR SOLIDARIO'){echo 'selected';} ?>>DEUDOR SOLIDARIO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="monto_sol">* MONTO SOLICITADO</label>
                            <input type='number' name='monto_sol' class='form-control' id="monto_sol" value='<?php echo $row['monto_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="plazo_sol">* PLAZO</label>
                            <select class="form-control" name="plazo_sol">
                                <option value=""></option>   
                                <option value="12 MESES" <?php if($row['plazo_sol']=='12 MESES'){echo 'selected';} ?>>12 MESES</option>
                                <option value="24 MESES" <?php if($row['plazo_sol']=='24 MESES'){echo 'selected';} ?>>24 MESES</option>
                                <option value="36 MESES" <?php if($row['plazo_sol']=='36 MESES'){echo 'selected';} ?>>36 MESES</option>
                                <option value="48 MESES" <?php if($row['plazo_sol']=='48 MESES'){echo 'selected';} ?>>48 MESES</option>
                                <option value="60 MESES" <?php if($row['plazo_sol']=='60 MESES'){echo 'selected';} ?>>60 MESES</option>
                                <option value="72 MESES" <?php if($row['plazo_sol']=='72 MESES'){echo 'selected';} ?>>72 MESES</option>
                                <option value="84 MESES" <?php if($row['plazo_sol']=='84 MESES'){echo 'selected';} ?>>84 MESES</option>
                                <option value="96 MESES" <?php if($row['plazo_sol']=='96 MESES'){echo 'selected';} ?>>96 MESES</option>
                                <option value="108 MESES" <?php if($row['plazo_sol']=='108 MESES'){echo 'selected';} ?>>108 MESES</option>
                                <option value="120 MESES" <?php if($row['plazo_sol']=='120 MESES'){echo 'selected';} ?>>120 MESES</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="linea_cred_aso">* LÍNEA DE CRÉDITO</label>
                            <select class="form-control" name="linea_cred_aso" >
                                <option value=""></option>   
                                <option value="LIBRE INVERSION" <?php if($row['linea_cred_aso']=='LIBRE INVERSION'){echo 'selected';} ?>>LIBRE INVERSION</option>
                                <option value="CREDIAPORTES" <?php if($row['linea_cred_aso']=='CREDIAPORTES'){echo 'selected';} ?>>CREDIAPORTES</option>
                                <option value="CREDITO EDUCATIVO" <?php if($row['linea_cred_aso']=='CREDITO EDUCATIVO'){echo 'selected';} ?>>CREDITO EDUCATIVO</option>
                                <option value="CREDITO ROTATIVO" <?php if($row['linea_cred_aso']=='CREDITO ROTATIVO'){echo 'selected';} ?>>CREDITO ROTATIVO</option>
                                <option value="CREDITO PRIMA" <?php if($row['linea_cred_aso']=='CREDITO PRIMA'){echo 'selected';} ?>>CREDITO PRIMA</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS LABORALES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="ocupacion_sol">* OCUPACION</label>
                            <select class="form-control" name="ocupacion_sol">
                                <option value=""></option>   
                                <option value="EMPLEADO (A)" <?php if($row['ocupacion_sol']=='EMPLEADO (A)'){echo 'selected';} ?>>EMPLEADO (A)</option>
                                <option value="INDEPENDIENTE" <?php if($row['ocupacion_sol']=='INDEPENDIENTE'){echo 'selected';} ?>>INDEPENDIENTE</option>
                                <option value="COMERCIANTE" <?php if($row['ocupacion_sol']=='COMERCIANTE'){echo 'selected';} ?>>COMERCIANTE</option>
                                <option value="PENSIONADO (A)" <?php if($row['ocupacion_sol']=='PENSIONADO (A)'){echo 'selected';} ?>>PENSIONADO (A)</option>
                                <option value="RENTISTA CAPITAL" <?php if($row['ocupacion_sol']=='RENTISTA CAPITAL'){echo 'selected';} ?>>RENTISTA CAPITAL</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="func_estad_sol">* FUNCIONARIO DEL ESTADO</label>
                            <select class="form-control" name="func_estad_sol">
                                <option value=""></option>   
                                <option value="SI" <?php if($row['func_estad_sol']=='SI'){echo 'selected';} ?>>SI</option>
                                <option value="NO" <?php if($row['func_estad_sol']=='NO'){echo 'selected';} ?>>NO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="emp_labo_sol">* EMPRESA DONDE LABORA</label>
                            <input type="text" name="emp_labo_sol" class="form-control" value='<?php echo $row['emp_labo_sol']; ?>' readonly/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="nit_emp_labo_sol">* NIT EMPRESA</label>
                            <input type="number" name="nit_emp_labo_sol" class="form-control" value='<?php echo $row['nit_emp_labo_sol']; ?>' readonly/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="act_emp_labo_sol">* ACTIVIDAD EMPRESA</label>
                            <input type="number" name="act_emp_labo_sol" class="form-control" value='<?php echo $row['act_emp_labo_sol']; ?>' readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="dir_emp_sol">* DIRECCION EMPRESA</label>
                            <input type='text' name='dir_emp_sol' class='form-control' id="dir_emp_sol" value='<?php echo $row['dir_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_emp_sol">* CIUDAD</label>
                            <input type='text' name='ciudad_emp_sol' class='form-control' id="ciudad_emp_sol" value='<?php echo $row['ciudad_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="depar_emp_sol">* DEPARTAMENTO</label>
                            <input type='text' name='depar_emp_sol' class='form-control' id="depar_emp_sol" value='<?php echo $row['depar_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="tel_emp_sol">* TELEFONO EMPRESA</label>
                            <input type='number' name='tel_emp_sol' class='form-control' id="tel_emp_sol" value='<?php echo $row['tel_emp_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_ing_emp_sol">* FECHA DE INGRESO</label>
                            <input type='date' name='fecha_ing_emp_sol' class='form-control' id="fecha_ing_emp_sol" value='<?php echo $row['fecha_ing_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="anti_emp_sol">* ANTIGÜEDAD EN AÑOS</label>
                            <input type='number' name='anti_emp_sol' class='form-control' id="anti_emp_sol" value='<?php echo $row['anti_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="cargo_actual_emp_sol">* CARGO ACTUAL</label>
                            <input type='text' name='cargo_actual_emp_sol' class='form-control' id="cargo_actual_emp_sol" value='<?php echo $row['cargo_actual_emp_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="area_trabajo_sol">* ÁREA DE TRABAJO</label>
                            <input type='text' name='area_trabajo_sol' class='form-control' id="area_trabajo_sol" value='<?php echo $row['area_trabajo_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="acti_inde_sol">* ACTIVIDAD COMO INDEPENDIENTE</label>
                            <input type='text' name='acti_inde_sol' class='form-control' id="acti_inde_sol" value='<?php echo $row['acti_inde_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="num_emple_emp_sol">* NÚMERO DE EMPLEADOS DE SU EMPRESA</label>
                            <input type='number' name='num_emple_emp_sol' class='form-control' id="num_emple_emp_sol" value='<?php echo $row['num_emple_emp_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS FINANCIEROS</legend>
                    <h5>INGRESOS</h5>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="salario_sol">* SALARIO</label>
                            <input type='number' name='salario_sol' class='form-control' id="salario_sol" value='<?php echo $row['salario_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ing_arri_sol">* INGRESO POR ARRIENDO</label>
                            <input type='number' name='ing_arri_sol' class='form-control' id="ing_arri_sol" value='<?php echo $row['ing_arri_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="honorarios_sol">* HONORARIOS</label>
                            <input type='number' name='honorarios_sol' class='form-control' id="honorarios_sol" min='1.0' max='25000' step='0.1' value='<?php echo $row['honorarios_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="pension_sol">* PENSIÓN</label>
                            <input type='number' name='pension_sol' class='form-control' id="pension_sol" min='1.0' max='100' step='0.1' value='<?php echo $row['pension_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="otros_ing_sol">* OTROS INGRESOS</label>
                            <input type='number' name='otros_ing_sol' class='form-control' id="otros_ing_sol" min='1.0' max='100' step='0.1' value='<?php echo $row['otros_ing_sol']; ?>' />
                        </div>
                    </div>

                    <h5>EGRESOS</h5>
                    <div class="row">                        
                        <div class="col-12 col-sm-2">
                            <label for="cuota_pres_sol">* CUOTA PRESTAMOS</label>
                            <input type='number' name='cuota_pres_sol' class='form-control' id="cuota_pres_sol" value='<?php echo $row['cuota_pres_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="cuota_tar_cred_sol">* CUOTA TARJETA DE CREDITO</label>
                            <input type='number' name='cuota_tar_cred_sol' class='form-control' id="cuota_tar_cred_sol" min='0' step='0.1' value='<?php echo $row['cuota_tar_cred_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="arrendo_sol">* ARRENDAMIENTO</label>
                            <input type='number' name='arrendo_sol' class='form-control' id="arrendo_sol" min='0' step='0.1' value='<?php echo $row['arrendo_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="gastos_fam_sol">* GASTOS FAMILIARES</label>
                            <input type='number' name='gastos_fam_sol' class='form-control' id="gastos_fam_sol" min='0' step='0.1' value='<?php echo $row['gastos_fam_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="otros_gastos_sol">* OTROS GASTOS</label>
                            <input type='number' name='otros_gastos_sol' class='form-control' id="otros_gastos_sol" min='0' step='0.1' value='<?php echo $row['otros_gastos_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="ahorro_banco_sol">* BANCOS (AHORROS, INVERSIONES, CDTS)</label>
                            <input type='number' name='ahorro_banco_sol' class='form-control' id="ahorro_banco_sol" min='0' step='0.1' value='<?php echo $row['ahorro_banco_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="vehiculo_sol">* VEHICULOS (VALOR COMERCIAL)</label>
                            <input type='number' name='vehiculo_sol' class='form-control' id="vehiculo_sol" min='0' step='0.1' value='<?php echo $row['vehiculo_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="bienes_raices_sol">* BIENES RAICES (VALOR COMERCIAL)</label>
                            <input type='number' name='bienes_raices_sol' class='form-control' id="bienes_raices_sol" min='0' step='0.1' value='<?php echo $row['bienes_raices_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="otros_activos_sol">* OTROS ACTIVOS</label>
                            <input type='number' name='otros_activos_sol' class='form-control' id="otros_activos_sol" min='0' step='0.1' value='<?php echo $row['otros_activos_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="presta_total_sol">* PRESTAMOS (DEUDA TOTAL)</label>
                            <input type='number' name='presta_total_sol' class='form-control' id="presta_total_sol" min='0' step='0.1' value='<?php echo $row['presta_total_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="hipotecas_sol">* HIPOTECAS</label>
                            <input type='number' name='hipotecas_sol' class='form-control' id="hipotecas_sol" min='0' step='0.1' value='<?php echo $row['hipotecas_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="tar_cred_total_sol">* TARJETA DE CREDITO (DEUDA TOTAL)</label>
                            <input type='number' name='tar_cred_total_sol' class='form-control' id="tar_cred_total_sol" min='0' step='0.1' value='<?php echo $row['tar_cred_total_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="otros_pasivos_sol">* OTROS PASIVOS</label>
                            <input type='number' name='otros_pasivos_sol' class='form-control' id="otros_pasivos_sol" min='0' step='0.1' value='<?php echo $row['otros_pasivos_sol']; ?>' />
                        </div>
                    </div>
                    
            <div class="form-group">
                <fieldset>
                    <legend>RELACION INMUEBLES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="tipo_inmu_1_sol">TIPO DE INMUEBLE 1</label>
                            <select class="form-control" name="tipo_inmu_1_sol" >
                                <option value=""></option>   
                                <option value="LOTE" <?php if($row['tipo_inmu_1_sol']=='LOTE'){echo 'selected';} ?>>LOTE</option>
                                <option value="CASA" <?php if($row['tipo_inmu_1_sol']=='CASA'){echo 'selected';} ?>>CASA</option>
                                <option value="FINCA" <?php if($row['tipo_inmu_1_sol']=='FINCA'){echo 'selected';} ?>>FINCA</option>
                                <option value="APARTAMENTO" <?php if($row['tipo_inmu_1_sol']=='APARTAMENTO'){echo 'selected';} ?>>APARTAMENTO</option>
                                <option value="LOCAL" <?php if($row['tipo_inmu_1_sol']=='LOCAL'){echo 'selected';} ?>>LOCAL</option>
                                <option value="N/A" <?php if($row['tipo_inmu_1_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="direccion_1_sol">DIRECCION 1</label>
                            <input type="text" name="direccion_1_sol" class="form-control" value='<?php echo $row['direccion_1_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="valor_comer_1_sol">VALOR COMERCIAL 1</label>
                            <input type="number" name="valor_comer_1_sol" class="form-control" value='<?php echo $row['valor_comer_1_sol']; ?>' readonly />
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="tipo_inmu_2_sol">TIPO DE INMUEBLE 2</label>
                            <select class="form-control" name="tipo_inmu_2_sol">
                                <option value=""></option>   
                                <option value="LOTE" <?php if($row['tipo_inmu_2_sol']=='LOTE'){echo 'selected';} ?>>LOTE</option>
                                <option value="CASA" <?php if($row['tipo_inmu_2_sol']=='CASA'){echo 'selected';} ?>>CASA</option>
                                <option value="FINCA" <?php if($row['tipo_inmu_2_sol']=='FINCA'){echo 'selected';} ?>>FINCA</option>
                                <option value="APARTAMENTO" <?php if($row['tipo_inmu_2_sol']=='APARTAMENTO'){echo 'selected';} ?>>APARTAMENTO</option>
                                <option value="LOCAL" <?php if($row['tipo_inmu_2_sol']=='LOCAL'){echo 'selected';} ?>>LOCAL</option>
                                <option value="N/A" <?php if($row['tipo_inmu_2_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="direccion_2_sol">DIRECCION 2</label>
                            <input type="text" name="direccion_2_sol" class="form-control" value='<?php echo $row['direccion_2_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="valor_comer_2_sol">VALOR COMERCIAL 2</label>
                            <input type="number" name="valor_comer_2_sol" class="form-control" value='<?php echo $row['valor_comer_2_sol']; ?>' readonly />
                        </div>                        
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>RELACION VEHICULOS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tipo_vehi_1_sol">IPO DE VEHICULO 1</label>
                            <select class="form-control" name="tipo_vehi_1_sol" >
                                <option value=""></option>   
                                <option value="MOTO" <?php if($row['tipo_vehi_1_sol']=='MOTO'){echo 'selected';} ?>>MOTO</option>
                                <option value="CARRO" <?php if($row['tipo_vehi_1_sol']=='CARRO'){echo 'selected';} ?>>CARRO</option>
                                <option value="CAMIONETA" <?php if($row['tipo_vehi_1_sol']=='CAMIONETA'){echo 'selected';} ?>>CAMIONETA</option>
                                <option value="BUS" <?php if($row['tipo_vehi_1_sol']=='BUS'){echo 'selected';} ?>>BUS</option>
                                <option value="BUSETA" <?php if($row['tipo_vehi_1_sol']=='BUSETA'){echo 'selected';} ?>>BUSETA</option>
                                <option value="MICROBUS" <?php if($row['tipo_vehi_1_sol']=='MICROBUS'){echo 'selected';} ?>>MICROBUS</option>
                                <option value="TAXI" <?php if($row['tipo_vehi_1_sol']=='TAXI'){echo 'selected';} ?>>TAXI</option>
                                <option value="CAMION" <?php if($row['tipo_vehi_1_sol']=='CAMION'){echo 'selected';} ?>>CAMION</option>
                                <option value="N/A" <?php if($row['tipo_vehi_1_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="modelo_1_sol">MODELO 1</label>
                            <input type='number' name='modelo_1_sol' class='form-control' id="modelo_1_sol" value='<?php echo $row['modelo_1_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="marca_1_sol">MARCA 1</label>
                            <input type='text' name='marca_1_sol' class='form-control' id="marca_1_sol" value='<?php echo $row['marca_1_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="placa_1_sol">PLACA 1</label>
                            <input type='text' name='placa_1_sol' class='form-control' id="placa_1_sol" value='<?php echo $row['placa_1_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="valor_1_sol">VALOR COMERCIAL 1</label>
                            <input type='number' name='valor_1_sol' class='form-control' id="valor_1_sol" value='<?php echo $row['valor_1_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-12 col-sm-2">
                            <label for="tipo_vehi_2_sol">IPO DE VEHICULO 2</label>
                            <select class="form-control" name="tipo_vehi_2_sol" >
                                <option value=""></option>   
                                <option value="MOTO" <?php if($row['tipo_vehi_2_sol']=='MOTO'){echo 'selected';} ?>>MOTO</option>
                                <option value="CARRO" <?php if($row['tipo_vehi_2_sol']=='CARRO'){echo 'selected';} ?>>CARRO</option>
                                <option value="CAMIONETA" <?php if($row['tipo_vehi_2_sol']=='CAMIONETA'){echo 'selected';} ?>>CAMIONETA</option>
                                <option value="BUS" <?php if($row['tipo_vehi_2_sol']=='BUS'){echo 'selected';} ?>>BUS</option>
                                <option value="BUSETA" <?php if($row['tipo_vehi_2_sol']=='BUSETA'){echo 'selected';} ?>>BUSETA</option>
                                <option value="MICROBUS" <?php if($row['tipo_vehi_2_sol']=='MICROBUS'){echo 'selected';} ?>>MICROBUS</option>
                                <option value="TAXI" <?php if($row['tipo_vehi_2_sol']=='TAXI'){echo 'selected';} ?>>TAXI</option>
                                <option value="CAMION" <?php if($row['tipo_vehi_2_sol']=='CAMION'){echo 'selected';} ?>>CAMION</option>
                                <option value="N/A" <?php if($row['tipo_vehi_2_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="modelo_2_sol">MODELO 2</label>
                            <input type='number' name='modelo_2_sol' class='form-control' id="modelo_2_sol" value='<?php echo $row['modelo_2_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="marca_2_sol">MARCA 2</label>
                            <input type='text' name='marca_2_sol' class='form-control' id="marca_2_sol" value='<?php echo $row['marca_2_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="placa_2_sol">PLACA 2</label>
                            <input type='text' name='placa_2_sol' class='form-control' id="placa_2_sol" value='<?php echo $row['placa_2_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="valor_2_sol">VALOR COMERCIAL 2</label>
                            <input type='number' name='valor_2_sol' class='form-control' id="valor_2_sol" value='<?php echo $row['valor_2_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>OTROS ACTIVOS</legend>
                    <div class="row">          
                        <div class="col-12 col-sm-6">
                            <label for="ahorros_sol">* (CDT, CARTERA, INVERSIONES, CUENTAS, APORTES, OTROS)</label>
                            <select class="form-control" name="ahorros_sol" >
                                <option value=""></option>   
                                <option value="AHORROS" <?php if($row['ahorros_sol']=='AHORROS'){echo 'selected';} ?>>AHORROS</option>
                                <option value="N/A" <?php if($row['ahorros_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="valor_ahor_sol">* VALOR GENERAL</label>
                            <input type='number' name='valor_ahor_sol' class='form-control' id="valor_ahor_sol" value='<?php echo $row['valor_ahor_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">          
                        <div class="col-12 col-sm-6">
                            <label for="enseres_sol">* (MUEBLES, ENSERES, EQUIPOS)</label>
                            <select class="form-control" name="enseres_sol" >
                                <option value=""></option>   
                                <option value="MUEBLES Y OTROS" <?php if($row['enseres_sol']=='MUEBLES Y OTROS'){echo 'selected';} ?>>MUEBLES Y OTROS</option>
                                <option value="N/A" <?php if($row['enseres_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="valor_enser_sol">* VALOR GENERAL</label>
                            <input type='number' name='valor_enser_sol' class='form-control' id="valor_enser_sol" value='<?php echo $row['valor_enser_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS DEL CONYUGUE</legend>
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <label for="conyu_nombre_sol">NOMBRE COMPLETO</label>
                            <input type='text' name='conyu_nombre_sol' class='form-control' id="conyu_nombre_sol" style="text-transform:uppercase;" value='<?php echo $row['conyu_nombre_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                                <label for="conyu_cedula_sol">CEDULA No.</label>
                                <input type='number' name='conyu_cedula_sol' class='form-control' id="conyu_cedula_sol" value='<?php echo $row['conyu_cedula_sol']; ?>' />
                            </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_naci_sol">FECHA NACIMIENTO</label>
                            <input type='date' name='conyu_naci_sol' id="conyu_naci_sol" class='form-control' value='<?php echo $row['conyu_naci_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_exp_sol">CIUDAD DE EXPEDICION</label>
                            <input type='text' name='conyu_exp_sol' id="conyu_exp_sol" class='form-control' value='<?php echo $row['conyu_exp_sol']; ?>' />
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="conyu_ciudadn_sol">CIUDAD NACIMIENTO</label>
                            <input type='text' name='conyu_ciudadn_sol' id="conyu_ciudadn_sol" class='form-control' value='<?php echo $row['conyu_ciudadn_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dpton_sol">DEPARTAMENTO NACIMIENTO</label>
                            <input type="text" name="conyu_dpton_sol" class="form-control" value='<?php echo $row['conyu_dpton_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_paism_sol">PAIS NACIMIENTO</label>
                            <input type='text' name='conyu_paism_sol' class='form-control' id="conyu_paism_sol" style="text-transform:uppercase;" value='<?php echo $row['conyu_paism_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_correo_sol">EMAIL</label>
                            <input type='email' name='conyu_correo_sol' class='form-control' id="conyu_correo_sol" value='<?php echo $row['conyu_correo_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS LABORALES DEL CONYUGUE</legend>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="conyu_ocupacion_sol">OCUPACION</label>
                            <select class="form-control" name="conyu_ocupacion_sol">
                                <option value=""></option>   
                                <option value="EMPLEADO (A)" <?php if($row['conyu_ocupacion_sol']=='EMPLEADO (A)'){echo 'selected';} ?>>EMPLEADO (A)</option>
                                <option value="INDEPENDIENTE" <?php if($row['conyu_ocupacion_sol']=='INDEPENDIENTE'){echo 'selected';} ?>>INDEPENDIENTE</option>
                                <option value="COMERCIANTE" <?php if($row['conyu_ocupacion_sol']=='COMERCIANTE'){echo 'selected';} ?>>COMERCIANTE</option>
                                <option value="PENSIONADO (A)" <?php if($row['conyu_ocupacion_sol']=='PENSIONADO (A)'){echo 'selected';} ?>>PENSIONADO (A)</option>
                                <option value="RENTISTA CAPITAL" <?php if($row['conyu_ocupacion_sol']=='RENTISTA CAPITAL'){echo 'selected';} ?>>RENTISTA CAPITAL</option>
                                <option value="N/A" <?php if($row['conyu_ocupacion_sol']=='N/A'){echo 'selected';} ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_func_sol">FUNCIONARIO DEL ESTADO</label>
                            <select class="form-control" name="conyu_func_sol">
                                <option value=""></option>   
                                <option value="SI" <?php if($row['conyu_func_sol']=='SI'){echo 'selected';} ?>>SI</option>
                                <option value="NO" <?php if($row['conyu_func_sol']=='NO'){echo 'selected';} ?>>NO</option>
                            </select>
                        </div>                    
                        <div class="col-12 col-sm-3">
                            <label for="conyu_emp_lab_sol">NOMBRE EMPRESA</label>
                            <input type="text" name="conyu_emp_lab_sol" class="form-control" value='<?php echo $row['conyu_emp_lab_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_cargo_sol">CARGO</label>
                            <input type="text" name="conyu_cargo_sol" class="form-control" value='<?php echo $row['conyu_cargo_sol']; ?>' readonly />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="conyu_salario_sol">SALARIO</label>
                            <input type="text" name="conyu_salario_sol" class="form-control" value='<?php echo $row['conyu_salario_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dir_lab_sol">DIRECCION</label>
                            <input type="text" name="conyu_dir_lab_sol" class="form-control" value='<?php echo $row['conyu_dir_lab_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_tel_lab_sol">TELEFONO</label>
                            <input type='email' name='conyu_tel_lab_sol' class='form-control' id="conyu_tel_lab_sol" value='<?php echo $row['conyu_tel_lab_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_ciudad_lab_sol">CIUDAD</label>
                            <input type='text' name='conyu_ciudad_lab_sol' class='form-control' id="conyu_ciudad_lab_sol" style="text-transform:uppercase;" value='<?php echo $row['conyu_ciudad_lab_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dpto_lab_sol">DEPARTAMENTO</label>
                            <input type='text' name='conyu_dpto_lab_sol' class='form-control' id="conyu_dpto_lab_sol" style="text-transform:uppercase;" value='<?php echo $row['conyu_dpto_lab_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>  
            
            <div class="form-group">
                <fieldset>
                    <legend>REFERENCIAS FAMILIARES</legend>
                    <div class="row">                   
                        <div class="col-12 col-sm-3">
                            <label for="fami_nombre_1_sol">* NOMBRE COMPLETO 1</label>
                            <input type="text" name="fami_nombre_1_sol" class="form-control" value='<?php echo $row['fami_nombre_1_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_cel_1_sol">* CELULAR 1</label>
                            <input type="text" name="fami_cel_1_sol" class="form-control" value='<?php echo $row['fami_cel_1_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_tel_1_sol">* TELEFONO FIJO 1</label>
                            <input type="text" name="fami_tel_1_sol" class="form-control" value='<?php echo $row['fami_tel_1_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_parent_1_sol">* PARENTESCO 1</label>
                            <select class="form-control" name="fami_parent_1_sol">
                                <option value=""></option>   
                                <option value="MADRE" <?php if($row['fami_parent_1_sol']=='MADRE'){echo 'selected';} ?>>MADRE</option>
                                <option value="PADRE" <?php if($row['fami_parent_1_sol']=='PADRE'){echo 'selected';} ?>>PADRE</option>
                                <option value="HERMANO (A)" <?php if($row['fami_parent_1_sol']=='HERMANO (A)'){echo 'selected';} ?>>HERMANO (A)</option>
                                <option value="HIJO (A)" <?php if($row['fami_parent_1_sol']=='HIJO (A)'){echo 'selected';} ?>>HIJO (A)</option>
                                <option value="ESPOSO (A)" <?php if($row['fami_parent_1_sol']=='ESPOSO (A)'){echo 'selected';} ?>>ESPOSO (A)</option>
                                <option value="ABUELO (A)" <?php if($row['fami_parent_1_sol']=='ABUELO (A)'){echo 'selected';} ?>>ABUELO (A)</option>
                                <option value="TIO (A)" <?php if($row['fami_parent_1_sol']=='TIO (A)'){echo 'selected';} ?>>TIO (A)</option>
                                <option value="SOBRINO (A)" <?php if($row['fami_parent_1_sol']=='SOBRINO (A)'){echo 'selected';} ?>>SOBRINO (A)</option>
                                <option value="PRIMO (A)" <?php if($row['fami_parent_1_sol']=='PRIMO (A)'){echo 'selected';} ?>>PRIMO (A)</option>
                                <option value="SUEGRO (A)" <?php if($row['fami_parent_1_sol']=='SUEGRO (A)'){echo 'selected';} ?>>SUEGRO (A)</option>
                                <option value="CUÑADO (A)" <?php if($row['fami_parent_1_sol']=='CUÑADO (A)'){echo 'selected';} ?>>CUÑADO (A)</option>
                                <option value="YERNO" <?php if($row['fami_parent_1_sol']=='YERNO'){echo 'selected';} ?>>YERNO</option>
                                <option value="NUERA" <?php if($row['fami_parent_1_sol']=='NUERA'){echo 'selected';} ?>>NUERA</option>
                                <option value="NIETO (A)" <?php if($row['fami_parent_1_sol']=='NIETO (A)'){echo 'selected';} ?>>NIETO (A)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">                   
                        <div class="col-12 col-sm-3">
                            <label for="fami_nombre_2_sol">* NOMBRE COMPLETO 2</label>
                            <input type="text" name="fami_nombre_2_sol" class="form-control" value='<?php echo $row['fami_nombre_2_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_cel_2_sol">* CELULAR 2</label>
                            <input type="text" name="fami_cel_2_sol" class="form-control" value='<?php echo $row['fami_cel_2_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_tel_2_sol">* TELEFONO FIJO 2</label>
                            <input type="text" name="fami_tel_2_sol" class="form-control" value='<?php echo $row['fami_tel_2_sol']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_parent_2_sol">* PARENTESCO 2</label>
                            <select class="form-control" name="fami_parent_2_sol">
                                <option value=""></option>   
                                <option value="MADRE" <?php if($row['fami_parent_2_sol']=='MADRE'){echo 'selected';} ?>>MADRE</option>
                                <option value="PADRE" <?php if($row['fami_parent_2_sol']=='PADRE'){echo 'selected';} ?>>PADRE</option>
                                <option value="HERMANO (A)" <?php if($row['fami_parent_2_sol']=='HERMANO (A)'){echo 'selected';} ?>>HERMANO (A)</option>
                                <option value="HIJO (A)" <?php if($row['fami_parent_2_sol']=='HIJO (A)'){echo 'selected';} ?>>HIJO (A)</option>
                                <option value="ESPOSO (A)" <?php if($row['fami_parent_2_sol']=='ESPOSO (A)'){echo 'selected';} ?>>ESPOSO (A)</option>
                                <option value="ABUELO (A)" <?php if($row['fami_parent_2_sol']=='ABUELO (A)'){echo 'selected';} ?>>ABUELO (A)</option>
                                <option value="TIO (A)" <?php if($row['fami_parent_2_sol']=='TIO (A)'){echo 'selected';} ?>>TIO (A)</option>
                                <option value="SOBRINO (A)" <?php if($row['fami_parent_2_sol']=='SOBRINO (A)'){echo 'selected';} ?>>SOBRINO (A)</option>
                                <option value="PRIMO (A)" <?php if($row['fami_parent_2_sol']=='PRIMO (A)'){echo 'selected';} ?>>PRIMO (A)</option>
                                <option value="SUEGRO (A)" <?php if($row['fami_parent_2_sol']=='SUEGRO (A)'){echo 'selected';} ?>>SUEGRO (A)</option>
                                <option value="CUÑADO (A)" <?php if($row['fami_parent_2_sol']=='CUÑADO (A)'){echo 'selected';} ?>>CUÑADO (A)</option>
                                <option value="YERNO" <?php if($row['fami_parent_2_sol']=='YERNO'){echo 'selected';} ?>>YERNO</option>
                                <option value="NUERA" <?php if($row['fami_parent_2_sol']=='NUERA'){echo 'selected';} ?>>NUERA</option>
                                <option value="NIETO (A)" <?php if($row['fami_parent_2_sol']=='NIETO (A)'){echo 'selected';} ?>>NIETO (A)</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div> 

            <div class="form-group">
                <fieldset>
                    <legend>REFERENCIAS PERSONALES</legend>
                    <div class="row">          
                        <div class="col-12 col-sm-4">
                            <label for="refer_nombre_1_sol">* NOMBRE COMPLETO 1</label>
                            <input type='number' name='refer_nombre_1_sol' class='form-control' id="refer_nombre_1_sol" value='<?php echo $row['refer_nombre_1_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_cel_1_sol">* CELULAR 1</label>
                            <input type='number' name='refer_cel_1_sol' class='form-control' id="refer_cel_1_sol" value='<?php echo $row['refer_cel_1_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_tel_1_sol">* TELEFONO FIJO 1</label>
                            <input type='number' name='refer_tel_1_sol' class='form-control' id="refer_tel_1_sol" value='<?php echo $row['refer_tel_1_sol']; ?>' />
                        </div>
                    </div>

                    <div class="row">          
                        <div class="col-12 col-sm-4">
                            <label for="refer_nombre_2_sol">* NOMBRE COMPLETO 2</label>
                            <input type='number' name='refer_nombre_2_sol' class='form-control' id="refer_nombre_2_sol" value='<?php echo $row['refer_nombre_2_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_cel_2_sol">* CELULAR 2</label>
                            <input type='number' name='refer_cel_2_sol' class='form-control' id="refer_cel_2_sol" value='<?php echo $row['refer_cel_2_sol']; ?>' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_tel_2_sol">* TELEFONO FIJO 2</label>
                            <input type='number' name='refer_tel_2_sol' class='form-control' id="refer_tel_2_sol" value='<?php echo $row['refer_tel_2_sol']; ?>' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
            <fieldset>
                <legend>ARCHIVOS ADJUNTOAS</legend>
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><strong><i class="fa-regular fa-image"></i> ADJUNTAR EVIDENCIAS:</strong></label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="image/jpeg,image/gif,image/png,image/jpg,image/bmp,image/webp,application/pdf,image/x-eps">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
                    </div>
                </div>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-outline-warning">
                <span class="spinner-border spinner-border-sm"></span>
                INGRESAR REGISTRO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
    <script src = "../../js/jquery-3.1.1.js"></script>
    <script type = "text/javascript">
        $(document).ready(function(){
            $('#cod_dane_dep').on('change', function(){
                    if($('#cod_dane_dep').val() == ""){
                        $('#id_mun').empty();
                        $('<option value = "">Seleccione un municipio</option>').appendTo('#id_mun');
                        $('#id_mun').attr('disabled', 'disabled');
                    }else{
                        $('#id_mun').removeAttr('disabled', 'disabled');
                        $('#id_mun').load('modules_get.php?cod_dane_dep=' + $('#cod_dane_dep').val());
                    }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function formatCOP(value) {
                return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
            }

            function calcularValores() {
                var canon_neto = parseFloat($('#canon_neto_cap').val()) || 0;
                var porcentaje_iva = parseFloat($('#porcentaje_iva_cap').val()) || 0;
                var admon = parseFloat($('#admon_cap').val()) || 0;

                var valor_iva = canon_neto * (porcentaje_iva / 100);
                var renta_total = canon_neto + valor_iva + admon;

                $('#valor_iva_cap').val(formatCOP(valor_iva));
                $('#renta_total_cap').val(formatCOP(renta_total));

                // Actualizar los campos ocultos con los valores numéricos para enviar al servidor
                $('#valor_iva_cap_hidden').val(valor_iva);
                $('#renta_total_cap_hidden').val(renta_total);
            }

            $('#canon_neto_cap, #porcentaje_iva_cap, #admon_cap').on('input', function() {
                calcularValores();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctdMuelleGraduable = document.getElementById('ctd_muelle_graduable_cap');
            const ctdMuelleTractomula = document.getElementById('ctd_muelle_tractomula_cap');
            const dynamicFieldsContainer = document.getElementById('dynamic_fields');

            // Generar campos dinámicos para muelles graduables
            function generateFieldsForGraduable() {
                // Limpiar campos existentes
                dynamicFieldsContainer.innerHTML = '';
                const numGraduable = parseInt(ctdMuelleGraduable.value) || 0;

                for (let i = 0; i < numGraduable; i++) {
                    const fieldGroup = document.createElement('div');
                    fieldGroup.className = 'col-12 col-sm-2';

                    // Campo de altura de muelle graduable
                    const alturaInput = document.createElement('input');
                    alturaInput.type = 'number';
                    alturaInput.name = 'altura_muelle_graduable_cap[]'; // Nombre de array
                    alturaInput.className = 'form-control';
                    alturaInput.placeholder = `Altura Muelle Graduable #${i + 1}`;
                    alturaInput.step = '0.1';

                    fieldGroup.appendChild(alturaInput);
                    dynamicFieldsContainer.appendChild(fieldGroup);
                }

                // Agrega el console.log aquí para verificar la generación de campos
                console.log('Campos generados para muelles graduables:', document.querySelectorAll('input[name="altura_muelle_graduable_cap[]"]'));
            }

            // Generar campos dinámicos para muelles de tractomula
            function generateFieldsForTractomula() {
                // Limpiar campos existentes
                const existingFields = document.querySelectorAll('[name^="tipo_muelle_tractomula_cap"], [name^="altura_muelle_tractomula_cap"]');
                existingFields.forEach(field => field.parentElement.remove());

                const numTractomula = parseInt(ctdMuelleTractomula.value) || 0;

                for (let i = 0; i < numTractomula; i++) {
                    const fieldGroup = document.createElement('div');
                    fieldGroup.className = 'col-12 col-sm-2';

                    // Campo de tipo de muelle
                    const tipoMuelleSelect = document.createElement('select');
                    tipoMuelleSelect.name = 'tipo_muelle_tractomula_cap[]'; // Nombre de array
                    tipoMuelleSelect.className = 'form-control';
                    tipoMuelleSelect.innerHTML = `
                        <option value="">Tipo Muelle #${i + 1}</option>
                        <option value="fijo">Fijo</option>
                        <option value="graduable">Graduable</option>
                    `;

                    // Campo de altura de muelle tractomula
                    const alturaInput = document.createElement('input');
                    alturaInput.type = 'number';
                    alturaInput.name = 'altura_muelle_tractomula_cap[]'; // Nombre de array
                    alturaInput.className = 'form-control';
                    alturaInput.placeholder = `Altura Muelle Tractomula #${i + 1}`;
                    alturaInput.step = '0.1';

                    fieldGroup.appendChild(tipoMuelleSelect);
                    fieldGroup.appendChild(alturaInput);
                    dynamicFieldsContainer.appendChild(fieldGroup);
                }
                // Agrega el console.log aquí para verificar la generación de campos
                console.log('Campos generados para muelles tractomula:', document.querySelectorAll('input[name="altura_muelle_tractomula_cap[]"]'));
            }
            // Eventos de cambio para los campos de entrada
            ctdMuelleGraduable.addEventListener('input', function() {
                generateFieldsForGraduable();
            });

            ctdMuelleTractomula.addEventListener('input', function() {
                generateFieldsForTractomula();
            });
        });
    </script>
</html>
