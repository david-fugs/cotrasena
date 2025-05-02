<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica que el usuario está autenticado
if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

// Variables de sesión
$id_usu = $_SESSION['id_usu'];
$tipo_usu = $_SESSION['tipo_usu'];

include("../../conexion.php");


$id_solicitud = intval($_GET['id_solicitud']);

// Consulta para obtener los datos de la solicitud
$query = "SELECT * FROM solicitudes WHERE id_solicitud = $id_solicitud";
$result = $mysqli->query($query);


if ($result->num_rows > 0) {
    $datos_solicitud = $result->fetch_assoc();
} else {
    echo "<p class='text-danger'>No se encontraron datos para esta solicitud.</p>";
    header("Location: editSolicitud.php");
}
$archivosExistentes = [];
$directorio = __DIR__ . '/documentos/';

if ($datos_solicitud['cedula_aso'] && is_dir($directorio)) {
    foreach (scandir($directorio) as $archivo) {
        if (strpos($archivo, $datos_solicitud['cedula_aso'] . '_') === 0) {
            $archivosExistentes[] = $archivo;
        }
    }
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDITAR SOLICITUD</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="../../css/formulario.css" rel="stylesheet">

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo-container">
            <img src='../../img/img2.jpg' class="logo" alt="Logo COTRASENA">
        </div>
        <h1 class="title">EDITAR SOLICITUD DE CRÉDITO</h1>
    </header>
    <div class="container">
        <form action='updateSolicitud.php' method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para enviar el id_solicitud -->
            <input type="hidden" name="id_solicitud" value="<?php echo $datos_solicitud['id_solicitud']; ?>">

            <!-- Información del asociado -->
            <div class="seccion">

                <h3 class="subtitulo">DATOS PERSONALES</h3>
                <div class="row">
                    <div class="col-md-2">
                        <label for="tipo_doc_aso">* TIPO DOCUMENTO</label>
                        <select name="tipo_doc_aso" class="form-control" id="tipo_doc_aso" required>
                            <option value="C.C." <?php echo ($datos_solicitud['tipo_doc_aso'] == 'C.C.') ? 'selected' : ''; ?>>C.C.</option>
                            <option value="C.E." <?php echo ($datos_solicitud['tipo_doc_aso'] == 'C.E.') ? 'selected' : ''; ?>>C.E.</option>
                            <option value="PASAPORTE" <?php echo ($datos_solicitud['tipo_doc_aso'] == 'PASAPORTE') ? 'selected' : ''; ?>>PASAPORTE</option>
                            <option value="OTRO" <?php echo ($datos_solicitud['tipo_doc_aso'] == 'OTRO') ? 'selected' : ''; ?>>OTRO</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cedula_aso">* CÉDULA No.</label>
                        <input type='text' name='cedula_aso' class='form-control' id="cedula_aso"
                            value='<?php echo $datos_solicitud['cedula_aso']; ?>' required />
                    </div>
                    <div class="col-md-4">
                        <label for="nombre_aso">NOMBRE ASOCIADO</label>
                        <input type='text' name='nombre_aso' id="nombre_aso" class='form-control'
                            value='<?php echo $datos_solicitud['nombre_aso']; ?>' required />
                    </div>
                    <div class="col-md-4">
                        <label for="direccion_aso">DIRECCIÓN</label>
                        <input type='text' name='direccion_aso' class='form-control'
                            value='<?php echo $datos_solicitud['direccion_aso']; ?>' required />
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-3">
                        <label for="fecha_exp_doc_aso">* FECHA EXPEDICIÓN</label>
                        <input type="date" name="fecha_exp_doc_aso" class="form-control" id="fecha_exp_doc_aso"
                            value='<?php echo $datos_solicitud['fecha_exp_doc_aso']; ?>' required />
                    </div>
                    <div class="col-md-3">
                        <label for="pais_exp_cedula_aso">* PAÍS EXPEDICIÓN</label>
                        <input type="text" name="pais_exp_cedula_aso" class="form-control" id="pais_exp_cedula_aso"
                            value='<?php echo $datos_solicitud['pais_exp_cedula_aso']; ?>' required />
                    </div>
                    <div class="col-md-3">
                        <label for="dpto_exp_cedula_aso">* DEPARTAMENTO EXPEDICIÓN</label>
                        <input type="text" name="dpto_exp_cedula_aso" class="form-control" id="dpto_exp_cedula_aso"
                            value='<?php echo $datos_solicitud['dpto_exp_cedula_aso']; ?>' required />
                    </div>
                    <div class="col-md-3">
                        <label for="ciudad_exp_cedula_aso">* CIUDAD EXPEDICIÓN</label>
                        <input type="text" name="ciudad_exp_cedula_aso" class="form-control" id="ciudad_exp_cedula_aso"
                            value='<?php echo $datos_solicitud['ciudad_exp_cedula_aso']; ?>' required />
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fecha_nacimiento_aso">* FECHA NACIMIENTO</label>
                        <input type="date" name="fecha_nacimiento_aso" class="form-control" id="fecha_nacimiento_aso" required
                            value='<?= $datos_solicitud['fecha_nacimiento_aso'] ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="pais_naci_aso">* PAIS NACIMIENTO</label>
                        <input type="text" name="pais_naci_aso" class="form-control" id="pais_naci_aso" value='<?php echo $datos_solicitud['pais_naci_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="dpto_naci_aso">* DEPARTAMENTO NACIMIENTO</label>
                        <input type="text" name="dpto_naci_aso" class="form-control" id="dpto_naci_aso" value='<?= $datos_solicitud['dpto_naci_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="ciudad_naci_aso">* CIUDAD NACIMIENTO</label>
                        <input type="text" name="ciudad_naci_aso" class="form-control" id="ciudad_naci_aso" value='<?= $datos_solicitud['ciudad_naci_aso'] ?? ''; ?>' />
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="edad_aso">* EDAD</label>
                        <input type='number' name='edad_aso' class='form-control' id="edad_aso" value='<?= $datos_solicitud['edad_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="sexo_aso">* SEXO</label>
                        <select name="sexo_aso" class="form-control" id="sexo_aso">
                            <option value="Femenino" <?php echo ($datos_solicitud['sexo_aso'] == 'Femenino') ? 'selected' : ''; ?>>FEMENINO</option>
                            <option value="Masculino" <?php echo ($datos_solicitud['sexo_aso'] == 'Masculino') ? 'selected' : ''; ?>>MASCULINO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="nacionalidad_aso">* NACIONALIDAD</label>
                        <input type='text' name='nacionalidad_aso' class='form-control' value='<?= $datos_solicitud['sexo_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="estado_civil_aso">* ESTADO CIVIL</label>
                        <select name="estado_civil_aso" class="form-control" id="estado_civil_aso">
                            <option value="soltero" <?php echo ($datos_solicitud['estado_civil_aso'] == 'soltero') ? 'selected' : ''; ?>>SOLTERO (A)</option>
                            <option value="casado" <?php echo ($datos_solicitud['estado_civil_aso'] == 'casado') ? 'selected' : ''; ?>>CASADO (A)</option>
                            <option value="union libre" <?php echo ($datos_solicitud['estado_civil_aso'] == 'union libre') ? 'selected' : ''; ?>>UNION LIBRE</option>
                            <option value="divorciado" <?php echo ($datos_solicitud['estado_civil_aso'] == 'divorciado') ? 'selected' : ''; ?>>DIVORCIADO (A)</option>
                            <option value="viudo" <?php echo ($datos_solicitud['estado_civil_aso'] == 'viudo') ? 'selected' : ''; ?>>VIUDO (A)</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="per_cargo_aso">* PERSONAS A CARGO</label>
                        <input type='number' name='per_cargo_aso' id="per_cargo_aso" class='form-control' value='<?= $datos_solicitud['ciudad_naci_aso'] ?? ''; ?>' />
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="tip_vivienda_aso">* TIPO DE VIVIENDA</label>
                        <select name="tip_vivienda_aso" class="form-control" id="tip_vivienda_aso">

                            <option value="Arriendo" <?php echo ($datos_solicitud['tip_vivienda_aso'] == 'Arriendo') ? 'selected' : ''; ?>>ARRIENDO</option>
                            <option value="Propia" <?php echo ($datos_solicitud['tip_vivienda_aso'] == 'Propia') ? 'selected' : ''; ?>>PROPIA</option>
                            <option value="Familiar" <?php echo ($datos_solicitud['tip_vivienda_aso'] == 'Familiar') ? 'selected' : ''; ?>>FAMILIAR</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="barrio_aso">* BARRIO</label>
                        <input type='text' name='barrio_aso' id="barrio_aso" class='form-control' value='<?= $datos_solicitud['barrio_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="ciudad_aso">* CIUDAD</label>
                        <input type='text' name='ciudad_aso' class='form-control' value='<?= $datos_solicitud['ciudad_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="departamente_aso">* DEPARTAMENTO</label>
                        <input type='text' name='departamente_aso' class='form-control' value='<?= $datos_solicitud['departamente_aso'] ?? ''; ?>'>
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="estrato_aso">* ESTRATO</label>
                        <input type='number' name='estrato_aso' id="estrato_aso" class='form-control' value='<?= $datos_solicitud['estrato_aso'] ?? ''; ?>' />
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="email_aso">* EMAIL</label>
                        <input type='email' name='email_aso' id="email_aso" class='form-control' value='<?= $datos_solicitud['email_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="tel_aso">* TELEFONO FIJO</label>
                        <input type='number' name='tel_aso' id="tel_aso" class='form-control' value='<?= $datos_solicitud['tel_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="cel_aso">* CELULAR</label>
                        <input type='number' name='cel_aso' class='form-control' value='<?= $datos_solicitud['cel_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="nivel_educa_aso">* NIVEL EDUCATIVO</label>
                        <select name="nivel_educa_aso" class="form-control" id="nivel_educa_aso">
                            <option value="primaria" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'primaria') ? 'selected' : ''; ?>>PRIMARIA</option>
                            <option value="bachiller" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'bachiller') ? 'selected' : ''; ?>>BACHILLER</option>
                            <option value="tecnico" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'tecnico') ? 'selected' : ''; ?>>TECNICO (A)</option>
                            <option value="tecnologo" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'tecnologo') ? 'selected' : ''; ?>>TECNOLOGO (A)</option>
                            <option value="universitario" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'universitario') ? 'selected' : ''; ?>>UNIVERSITARIO (A)</option>
                            <option value="especializacion" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'especializacion') ? 'selected' : ''; ?>>ESPECIALIZACION</option>
                            <option value="maestria" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'maestria') ? 'selected' : ''; ?>>MAESTRIA</option>
                            <option value="doctorado" <?php echo ($datos_solicitud['nivel_educa_aso'] == 'doctorado') ? 'selected' : ''; ?>>DOCTORADO</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="titulo_obte_aso">TITULO OBTENIDO</label>
                        <input type='text' name='titulo_obte_aso' class='form-control' value='<?= $datos_solicitud['titulo_obte_aso'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="titulo_pos_aso">TITULO EN POSGRADO</label>
                        <input type='text' name='titulo_pos_aso' class='form-control' value='<?= $datos_solicitud['titulo_pos_aso'] ?? ''; ?>' />
                    </div>
                </div>
            </div>

            <!-- Solicitud de Crédito -->
            <div class="seccion">
                <h3 class="subtitulo"> DATOS DEL CREDITO</h3>
                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="fecha_sol">* FECHA</label>
                        <input type="text" name="fecha_sol" class="form-control" id="fecha_sol"
                            value='<?= $datos_solicitud['fecha_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-lg-3 mt-2">
                        <label for="tipo_deudor_aso">* TIPO DEUDOR</label>
                        <select name="tipo_deudor_aso" class="form-control" id="tipo_deudor_aso">
                            <!-- <option value="DEUDOR PRINCIPAL">DEUDOR PRINCIPAL</option>
                            <option value="DEUDOR SOLIDARIO">DEUDOR SOLIDARIO</option> -->
                            <option value="DEUDOR PRINCIPAL" <?php echo ($datos_solicitud['tipo_deudor_aso'] == 'DEUDOR PRINCIPAL') ? 'selected' : ''; ?>>DEUDOR PRINCIPAL</option>
                            <option value="DEUDOR SOLIDARIO" <?php echo ($datos_solicitud['tipo_deudor_aso'] == 'DEUDOR SOLIDARIO') ? 'selected' : ''; ?>>DEUDOR SOLIDARIO</option>

                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="monto_sol">* MONTO SOLICITADO</label>
                        <input type="number" name="monto_sol" class="form-control" id="monto_sol" value='<?= $datos_solicitud['monto_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="plazo_sol">* PLAZO</label>
                        <select name="plazo_sol" class="form-control" id="plazo_sol">
                            <option value="12 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '12 MESES') ? 'selected' : ''; ?>>12 MESES</option>
                            <option value="24 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '24 MESES') ? 'selected' : ''; ?>>24 MESES</option>
                            <option value="36 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '36 MESES') ? 'selected' : ''; ?>>36 MESES</option>
                            <option value="48 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '48 MESES') ? 'selected' : ''; ?>>48 MESES</option>
                            <option value="60 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '60 MESES') ? 'selected' : ''; ?>>60 MESES</option>
                            <option value="72 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '72 MESES') ? 'selected' : ''; ?>>72 MESES</option>
                            <option value="84 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '84 MESES') ? 'selected' : ''; ?>>84 MESES</option>
                            <option value="96 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '96 MESES') ? 'selected' : ''; ?>>96 MESES</option>
                            <option value="108 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '108 MESES') ? 'selected' : ''; ?>>108 MESES</option>
                            <option value="120 MESES" <?php echo ($datos_solicitud['plazo_sol'] == '120 MESES') ? 'selected' : ''; ?>>120 MESES</option>

                        </select>
                    </div>
                    <div class="col-12 col-lg-2 mt-2">
                        <label for="linea_cred_aso">* LÍNEA DE CRÉDITO</label>
                        <select name="linea_cred_aso" class="form-control" id="linea_cred_aso">
                            <option value="LIBRE INVERSION" <?php echo ($datos_solicitud['linea_cred_aso'] == 'LIBRE INVERSION') ? 'selected' : ''; ?>>LIBRE INVERSION</option>
                            <option value="CREDIAPORTES" <?php echo ($datos_solicitud['linea_cred_aso'] == 'CREDIAPORTES') ? 'selected' : ''; ?>>CREDIAPORTES</option>
                            <option value="CREDITO EDUCATIVO" <?php echo ($datos_solicitud['linea_cred_aso'] == 'CREDITO EDUCATIVO') ? 'selected' : ''; ?>>CREDITO EDUCATIVO</option>
                            <option value="CREDITO ROTATIVO" <?php echo ($datos_solicitud['linea_cred_aso'] == 'CREDITO ROTATIVO') ? 'selected' : ''; ?>>CREDITO ROTATIVO</option>
                            <option value="CREDITO PRIMA" <?php echo ($datos_solicitud['linea_cred_aso'] == 'CREDITO PRIMA') ? 'selected' : ''; ?>>CREDITO PRIMA</option>
                            <option value="CREDITO VEHICULOS" <?php echo ($datos_solicitud['linea_cred_aso'] == 'CREDITO VEHICULOS') ? 'selected' : ''; ?>>CREDITO VEHICULOS</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Datos financieros -->
            <div class="seccion">
                <h3 class="subtitulo">DATOS LABORALES</h3>
                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="ocupacion_sol">* OCUPACION</label>
                        <select name="ocupacion_sol" class="form-control" id="ocupacion_sol">
                            <option value="EMPLEADO" <?php echo ($datos_solicitud['ocupacion_sol'] == 'EMPLEADO') ? 'selected' : ''; ?>>EMPLEADO (A)</option>
                            <option value="INDEPENDIENTE" <?php echo ($datos_solicitud['ocupacion_sol'] == 'INDEPENDIENTE') ? 'selected' : ''; ?>>INDEPENDIENTE</option>
                            <option value="COMERCIANTE" <?php echo ($datos_solicitud['ocupacion_sol'] == 'COMERCIANTE') ? 'selected' : ''; ?>>COMERCIANTE</option>
                            <option value="PENSIONADO" <?php echo ($datos_solicitud['ocupacion_sol'] == 'PENSIONADO') ? 'selected' : ''; ?>>PENSIONADO (A)</option>
                            <option value="RENTISTA CAPITAL" <?php echo ($datos_solicitud['ocupacion_sol'] == 'RENTISTA CAPITAL') ? 'selected' : ''; ?>>RENTISTA CAPITAL</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="func_estad_sol">* FUNCIONARIO DEL ESTADO</label>
                        <select name="func_estad_sol" id="func_estad_sol" class="form-control">
                            <option value="SI" <?php echo ($datos_solicitud['func_estad_sol'] == 'SI') ? 'selected' : ''; ?>>SI</option>
                            <option value="NO" <?php echo ($datos_solicitud['func_estad_sol'] == 'NO') ? 'selected' : ''; ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="emp_labo_sol">* EMPRESA DONDE LABORA</label>
                        <input type='text' name='emp_labo_sol' id="emp_labo_sol" class='form-control' value='<?= $datos_solicitud['emp_labo_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="nit_emp_labo_sol">* NIT EMPRESA</label>
                        <input type='text' name='nit_emp_labo_sol' id="nit_emp_labo_sol" class='form-control' value='<?= $datos_solicitud['nit_emp_labo_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="act_emp_labo_sol">* ACTIVIDAD EMPRESA</label>
                        <input type='text' name='act_emp_labo_sol' id="act_emp_labo_sol" class='form-control' value='<?= $datos_solicitud['act_emp_labo_sol'] ?? ''; ?>' />
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="dir_emp_sol">* DIRECCION EMPRESA</label>
                        <input name="dir_emp_sol" class="form-control" id="dir_emp_sol" value='<?= $datos_solicitud['dir_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="ciudad_emp_sol">* CIUDAD</label>
                        <input name="ciudad_emp_sol" id="ciudad_emp_sol" class="form-control" value='<?= $datos_solicitud['ciudad_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="depar_emp_sol">* DEPARTAMENTO</label>
                        <input type='text' name='depar_emp_sol' id="depar_emp_sol" class='form-control' value='<?= $datos_solicitud['depar_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="tel_emp_sol">* TELEFONO EMPRESA</label>
                        <input type='number' name='tel_emp_sol' id="tel_emp_sol" class='form-control' value='<?= $datos_solicitud['tel_emp_sol'] ?? ''; ?>' />
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fecha_ing_emp_sol">* FECHA DE INGRESO</label>
                        <input type="date" name="fecha_ing_emp_sol" class="form-control" id="fecha_ing_emp_sol" value='<?= $datos_solicitud['fecha_ing_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="anti_emp_sol">* ANTIGÜEDAD EN AÑOS</label>
                        <input type="number" name="anti_emp_sol" id="anti_emp_sol" class="form-control" value='<?= $datos_solicitud['anti_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="cargo_actual_emp_sol">* CARGO ACTUAL</label>
                        <input type='text' name='cargo_actual_emp_sol' id="cargo_actual_emp_sol" class='form-control' value='<?= $datos_solicitud['cargo_actual_emp_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="area_trabajo_sol">* ÁREA DE TRABAJO</label>
                        <input type='text' name='area_trabajo_sol' id="area_trabajo_sol" class='form-control' value='<?= $datos_solicitud['area_trabajo_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="acti_inde_sol">* ACTIVIDAD COMO INDEPENDIENTE</label>
                        <input type="text" name="acti_inde_sol" class="form-control" id="acti_inde_sol" value='<?= $datos_solicitud['acti_inde_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="num_emple_emp_sol">* NÚMERO DE EMPLEADOS DE SU EMPRESA</label>
                        <input type="number" name="num_emple_emp_sol" id="num_emple_emp_sol" class="form-control" value='<?= $datos_solicitud['num_emple_emp_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>

            <div class="seccion">
                <h3 class="subtitulo">DATOS FINANCIEROS</h3>
                <h5>INGRESOS</h5>
                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="salario_sol">* SALARIO</label>
                        <input type="number" name="salario_sol" class="form-control" id="salario_sol" value='<?= $datos_solicitud['salario_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="ing_arri_sol">* INGRESO POR ARRIENDO</label>
                        <input type="number" name="ing_arri_sol" id="ing_arri_sol" class="form-control" value='<?= $datos_solicitud['ing_arri_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="honorarios_sol">* HONORARIOS</label>
                        <input type='number' name='honorarios_sol' id="honorarios_sol" class='form-control' value='<?= $datos_solicitud['honorarios_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="pension_sol">* PENSIÓN</label>
                        <input type='number' name='pension_sol' id="pension_sol" class='form-control' value='<?= $datos_solicitud['pension_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="otros_ing_sol">* OTROS INGRESOS</label>
                        <input type='number' name='otros_ing_sol' id="otros_ing_sol" class='form-control' value='<?= $datos_solicitud['otros_ing_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <div class="seccion">
                <h5 class="subtitulo">EGRESOS</h5>
                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="cuota_pres_sol">* CUOTA PRESTAMOS</label>
                        <input type="number" name="cuota_pres_sol" class="form-control" id="cuota_pres_sol" value='<?= $datos_solicitud['cuota_pres_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="cuota_tar_cred_sol">* CUOTA TARJETA DE CREDITO</label>
                        <input type="number" name="cuota_tar_cred_sol" id="cuota_tar_cred_sol" class="form-control" value='<?= $datos_solicitud['cuota_tar_cred_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="arrendo_sol">* ARRENDAMIENTO</label>
                        <input type='number' name='arrendo_sol' id="arrendo_sol" class='form-control' value='<?= $datos_solicitud['arrendo_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="gastos_fam_sol">* GASTOS FAMILIARES</label>
                        <input type='number' name='gastos_fam_sol' id="gastos_fam_sol" class='form-control' value='<?= $datos_solicitud['gastos_fam_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="otros_gastos_sol">* OTROS GASTOS</label>
                        <input type='number' name='otros_gastos_sol' id="otros_gastos_sol" class='form-control' value='<?= $datos_solicitud['otros_gastos_sol'] ?? ''; ?>' />
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="ahorro_banco_sol">* BANCOS (AHORROS, INVERSIONES, CDTS)</label>
                        <input type="number" name="ahorro_banco_sol" class="form-control" id="ahorro_banco_sol" value='<?= $datos_solicitud['ahorro_banco_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="vehiculo_sol">* VEHICULOS (VALOR COMERCIAL)</label>
                        <input type="number" name="vehiculo_sol" id="vehiculo_sol" class="form-control" value='<?= $datos_solicitud['vehiculo_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="bienes_raices_sol">* BIENES RAICES (VALOR COMERCIAL)</label>
                        <input type='number' name='bienes_raices_sol' id="bienes_raices_sol" class='form-control' value='<?= $datos_solicitud['bienes_raices_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="otros_activos_sol">* OTROS ACTIVOS</label>
                        <input type='number' name='otros_activos_sol' id="otros_activos_sol" class='form-control' value='<?= $datos_solicitud['otros_activos_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="presta_total_sol">* PRESTAMOS (DEUDA TOTAL)</label>
                        <input type='number' name='presta_total_sol' id="presta_total_sol" class='form-control' value='<?= $datos_solicitud['presta_total_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="hipotecas_sol">* HIPOTECAS</label>
                        <input type='number' name='hipotecas_sol' id="hipotecas_sol" class='form-control' value='<?= $datos_solicitud['hipotecas_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="tar_cred_total_sol">* TARJETA DE CREDITO (DEUDA TOTAL)</label>
                        <input type='number' name='tar_cred_total_sol' id="tar_cred_total_sol" class='form-control' value='<?= $datos_solicitud['tar_cred_total_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="otros_pasivos_sol">* OTROS PASIVOS</label>
                        <input type='number' name='otros_pasivos_sol' id="otros_pasivos_sol" class='form-control' value='<?= $datos_solicitud['otros_pasivos_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <!--Relacion de inmuebles-->
            <div class="seccion">
                <h3 class="subtitulo">RELACION INMUEBLES</h3>
                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="tipo_inmu_1_sol">TIPO DE INMUEBLE 1</label>
                        <select name="tipo_inmu_1_sol" class="form-control" id="tipo_inmu_1_sol">

                            <option value="LOTE" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'LOTE') ? 'selected' : ''; ?>>LOTE</option>
                            <option value="CASA" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'CASA') ? 'selected' : ''; ?>>CASA</option>
                            <option value="FINCA" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'FINCA') ? 'selected' : ''; ?>>FINCA</option>
                            <option value="APARTAMENTO" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'APARTAMENTO') ? 'selected' : ''; ?>>APARTAMENTO</option>
                            <option value="LOCAL" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'LOCAL') ? 'selected' : ''; ?>>LOCAL</option>
                            <option value="N/A" <?php echo ($datos_solicitud['tipo_inmu_1_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="direccion_1_sol">DIRECCION 1</label>
                        <input type='text' name='direccion_1_sol' id="direccion_1_sol" class='form-control' value='<?= $datos_solicitud['direccion_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="valor_comer_1_sol">VALOR COMERCIAL 1</label>
                        <input type='number' name='valor_comer_1_sol' id="valor_comer_1_sol" class='form-control' value='<?= $datos_solicitud['valor_comer_1_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <div class="seccion">
                <h3 class="subtitulo">RELACION VEHICULOS</h3>
                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="tipo_vehi_1_sol">TIPO DE VEHICULO 1</label>
                        <select name="tipo_vehi_1_sol" class="form-control" id="tipo_vehi_1_sol">
                            <option value="MOTO" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'MOTO') ? 'selected' : ''; ?>>MOTO</option>
                            <option value="CARRO" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'CARRO') ? 'selected' : ''; ?>>CARRO</option>
                            <option value="CAMIONETA" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'CAMIONETA') ? 'selected' : ''; ?>>CAMIONETA</option>
                            <option value="BUS" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'BUS') ? 'selected' : ''; ?>>BUS</option>
                            <option value="BUSETA" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'BUSETA') ? 'selected' : ''; ?>>BUSETA</option>
                            <option value="MICROBUS" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'MICROBUS') ? 'selected' : ''; ?>>MICROBUS</option>
                            <option value="TAXI" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'TAXI') ? 'selected' : ''; ?>>TAXI</option>
                            <option value="CAMION" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'CAMION') ? 'selected' : ''; ?>>CAMION</option>
                            <option value="N/A" <?php echo ($datos_solicitud['tipo_vehi_1_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="modelo_1_sol">MODELO 1</label>
                        <input type='number' name='modelo_1_sol' id="modelo_1_sol" class='form-control' value='<?= $datos_solicitud['modelo_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="marca_1_sol">MARCA 1</label>
                        <input type='text' name='marca_1_sol' id="marca_1_sol" class='form-control' value='<?= $datos_solicitud['marca_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="placa_1_sol">PLACA 1</label>
                        <input type='text' name='placa_1_sol' id="placa_1_sol" class='form-control' value='<?= $datos_solicitud['placa_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="valor_1_sol">VALOR COMERCIAL 1</label>
                        <input type='number' name='valor_1_sol' id="valor_1_sol" class='form-control' value='<?= $datos_solicitud['valor_1_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="tipo_vehi_2_sol">TIPO DE VEHICULO 2</label>
                        <select name="tipo_vehi_2_sol" class="form-control" id="tipo_vehi_2_sol">
                            <option value="MOTO" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'MOTO') ? 'selected' : ''; ?>>MOTO</option>
                            <option value="CARRO" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'CARRO') ? 'selected' : ''; ?>>CARRO</option>
                            <option value="CAMIONETA" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'CAMIONETA') ? 'selected' : ''; ?>>CAMIONETA</option>
                            <option value="BUS" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'BUS') ? 'selected' : ''; ?>>BUS</option>
                            <option value="BUSETA" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'BUSETA') ? 'selected' : ''; ?>>BUSETA</option>
                            <option value="MICROBUS" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'MICROBUS') ? 'selected' : ''; ?>>MICROBUS</option>
                            <option value="TAXI" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'TAXI') ? 'selected' : ''; ?>>TAXI</option>
                            <option value="CAMION" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'CAMION') ? 'selected' : ''; ?>>CAMION</option>
                            <option value="N/A" <?php echo ($datos_solicitud['tipo_vehi_2_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="modelo_2_sol">MODELO 2</label>
                        <input type='number' name='modelo_2_sol' id="modelo_2_sol" class='form-control' value='<?= $datos_solicitud['modelo_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="marca_2_sol">MARCA 2</label>
                        <input type='text' name='marca_2_sol' id="marca_2_sol" class='form-control' value='<?= $datos_solicitud['marca_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="placa_2_sol">PLACA 2</label>
                        <input type='text' name='placa_2_sol' id="placa_2_sol" class='form-control' value='<?= $datos_solicitud['placa_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="valor_2_sol">VALOR COMERCIAL 2</label>
                        <input type='number' name='valor_2_sol' id="valor_2_sol" class='form-control' value='<?= $datos_solicitud['valor_2_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <div class="seccion">
                <h3 class="subtitulo">OTROS ACTIVOS</h3>
                <div class="row">
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="ahorros_sol">* (CDT, CARTERA, INVERSIONES, CUENTAS, APORTES, OTROS)</label>
                        <select name="ahorros_sol" class="form-control" id="ahorros_sol">
                            <!-- <option value="AHORROS">AHORROS</option>
                            <option value="N/A">N/A</option> -->
                            <option value="AHORROS" <?php echo ($datos_solicitud['ahorros_sol'] == 'AHORROS') ? 'selected' : ''; ?>>AHORROS</option>
                            <option value="N/A" <?php echo ($datos_solicitud['ahorros_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="valor_ahor_sol">* VALOR GENERAL</label>
                        <input type='number' name='valor_ahor_sol' id="valor_ahor_sol" class='form-control' value='<?= $datos_solicitud['valor_ahor_sol'] ?? ''; ?>' />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="enseres_sol">* (MUEBLES, ENSERES, EQUIPOS)</label>
                        <select name="enseres_sol" class="form-control" id="enseres_sol">
                            <!-- <option value="MUEBLES Y OTROS">MUEBLES Y OTROS</option>
                            <option value="N/A">N/A</option> -->
                            <option value="MUEBLES Y OTROS" <?php echo ($datos_solicitud['enseres_sol'] == 'MUEBLES Y OTROS') ? 'selected' : ''; ?>>MUEBLES Y OTROS</option>
                            <option value="N/A" <?php echo ($datos_solicitud['enseres_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-2">
                        <label for="valor_enser_sol">* VALOR GENERAL</label>
                        <input type='number' name='valor_enser_sol' id="valor_enser_sol" class='form-control' value='<?= $datos_solicitud['valor_enser_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>

            <!-- Datos del conyugue -->
            <div class="seccion">
                <h3 class="subtitulo">DATOS DEL CONYUGUE</h3>
                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_nombre_sol">NOMBRE COMPLETO</label>
                        <input type="text" name="conyu_nombre_sol" class="form-control" id="conyu_nombre_sol" value='<?= $datos_solicitud['conyu_nombre_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_cedula_sol">CEDULA No.</label>
                        <input type="text" name="conyu_cedula_sol" class="form-control" id="conyu_cedula_sol" value='<?= $datos_solicitud['conyu_cedula_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_naci_sol">FECHA NACIMIENTO</label>
                        <input type="date" name="conyu_naci_sol" class="form-control" id="conyu_naci_sol" value='<?= $datos_solicitud['conyu_naci_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_exp_sol">CIUDAD DE EXPEDICION</label>
                        <input type="text" name="conyu_exp_sol" class="form-control" id="conyu_exp_sol" value='<?= $datos_solicitud['conyu_exp_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_ciudadn_sol">CIUDAD NACIMIENTO</label>
                        <input type="text" name="conyu_ciudadn_sol" class="form-control" id="conyu_ciudadn_sol" value='<?= $datos_solicitud['conyu_ciudadn_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_dpton_sol">DEPARTAMENTO NACIMIENTO</label>
                        <input type="text" name="conyu_dpton_sol" class="form-control" id="conyu_dpton_sol" value='<?= $datos_solicitud['conyu_dpton_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_paism_sol">PAIS NACIMIENTO</label>
                        <input type="text" name="conyu_paism_sol" class="form-control" id="conyu_paism_sol" value='<?= $datos_solicitud['conyu_paism_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_correo_sol">EMAIL</label>
                        <input type="email" name="conyu_correo_sol" class="form-control" id="conyu_correo_sol" value='<?= $datos_solicitud['conyu_correo_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>

            <div class="seccion">
                <h3 class="subtitulo">DATOS LABORALES DEL CONYUGUE</h3>
                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_ocupacion_sol">OCUPACION</label>
                        <select name="conyu_ocupacion_sol" class="form-control" id="conyu_ocupacion_sol">
                            <option value="EMPLEADO" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'EMPLEADO') ? 'selected' : ''; ?>>EMPLEADO (A)</option>
                            <option value="INDEPENDIENTE" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'INDEPENDIENTE') ? 'selected' : ''; ?>>INDEPENDIENTE</option>
                            <option value="COMERCIANTE" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'COMERCIANTE') ? 'selected' : ''; ?>>COMERCIANTE</option>
                            <option value="PENSIONADO" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'PENSIONADO') ? 'selected' : ''; ?>>PENSIONADO (A)</option>
                            <option value="RENTISTA CAPITAL" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'RENTISTA CAPITAL') ? 'selected' : ''; ?>>RENTISTA CAPITAL</option>
                            <option value="N/A" <?php echo ($datos_solicitud['conyu_ocupacion_sol'] == 'N/A') ? 'selected' : ''; ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_func_sol">FUNCIONARIO DEL ESTADO</label>
                        <select name="conyu_func_sol" class="form-control" id="conyu_func_sol">
                            <option value="SI" <?php echo ($datos_solicitud['conyu_func_sol'] == 'SI') ? 'selected' : ''; ?>>SI</option>
                            <option value="NO" <?php echo ($datos_solicitud['conyu_func_sol'] == 'NO') ? 'selected' : ''; ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_emp_lab_sol">NOMBRE EMPRESA</label>
                        <input type="text" name="conyu_emp_lab_sol" class="form-control" id="conyu_emp_lab_sol" value='<?= $datos_solicitud['conyu_emp_lab_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_cargo_sol">CARGO</label>
                        <input type="text" name="conyu_cargo_sol" class="form-control" id="conyu_cargo_sol" value='<?= $datos_solicitud['conyu_cargo_sol'] ?? ''; ?>' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="conyu_salario_sol">SALARIO</label>
                        <input type="number" name="conyu_salario_sol" class="form-control" id="conyu_salario_sol" value='<?= $datos_solicitud['conyu_salario_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_dir_lab_sol">DIRECCION</label>
                        <input type="text" name="conyu_dir_lab_sol" class="form-control" id="conyu_dir_lab_sol" value='<?= $datos_solicitud['conyu_dir_lab_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="conyu_tel_lab_sol">TELEFONO</label>
                        <input type="number" name="conyu_tel_lab_sol" class="form-control" id="conyu_tel_lab_sol" value='<?= $datos_solicitud['conyu_tel_lab_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <label for="conyu_ciudad_lab_sol">CIUDAD</label>
                        <input type="text" name="conyu_ciudad_lab_sol" class="form-control" id="conyu_ciudad_lab_sol" value='<?= $datos_solicitud['conyu_ciudad_lab_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="conyu_dpto_lab_sol">DEPARTAMENTO</label>
                        <input type="text" name="conyu_dpto_lab_sol" class="form-control" id="conyu_dpto_lab_sol" value='<?= $datos_solicitud['conyu_dpto_lab_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <div class="seccion">
                <h3 class="subtitulo">REFERENCIAS FAMILIARES</h3>
                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_nombre_1_sol">* NOMBRE COMPLETO 1</label>
                        <input type="text" name="fami_nombre_1_sol" class="form-control" id="fami_nombre_1_sol" value='<?= $datos_solicitud['fami_nombre_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_cel_1_sol">* CELULAR 1</label>
                        <input type="number" name="fami_cel_1_sol" class="form-control" id="fami_cel_1_sol" value='<?= $datos_solicitud['fami_cel_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_tel_1_sol">* TELEFONO FIJO 1</label>
                        <input type="number" name="fami_tel_1_sol" class="form-control" id="fami_tel_1_sol" value='<?= $datos_solicitud['fami_tel_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_parent_1_sol">* PARENTESCO 1</label>
                        <select name="fami_parent_1_sol" class="form-control" id="fami_parent_1_sol">
                            <option value="MADRE" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'MADRE') ? 'selected' : ''; ?>>MADRE</option>
                            <option value="PADRE" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'PADRE') ? 'selected' : ''; ?>>PADRE</option>
                            <option value="HERMANO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'HERMANO') ? 'selected' : ''; ?>>HERMANO (A)</option>
                            <option value="HIJO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'HIJO') ? 'selected' : ''; ?>>HIJO (A)</option>
                            <option value="ESPOSO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'ESPOSO') ? 'selected' : ''; ?>>ESPOSO (A)</option>
                            <option value="ABUELO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'ABUELO') ? 'selected' : ''; ?>>ABUELO (A)</option>
                            <option value="TIO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'TIO') ? 'selected' : ''; ?>>TIO (A)</option>
                            <option value="SOBRINO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'SOBRINO') ? 'selected' : ''; ?>>SOBRINO (A)</option>
                            <option value="PRIMO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'PRIMO') ? 'selected' : ''; ?>>PRIMO (A)</option>
                            <option value="SUEGRO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'SUEGRO') ? 'selected' : ''; ?>>SUEGRO (A)</option>
                            <option value="CUÑADO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'CUÑADO') ? 'selected' : ''; ?>>CUÑADO (A)</option>
                            <option value="YERNO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'YERNO') ? 'selected' : ''; ?>>YERNO</option>
                            <option value="NUERA" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'NUERA') ? 'selected' : ''; ?>>NUERA</option>
                            <option value="NIETO" <?php echo ($datos_solicitud['fami_parent_1_sol'] == 'NIETO') ? 'selected' : ''; ?>>NIETO (A)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_nombre_2_sol">* NOMBRE COMPLETO 2</label>
                        <input type="text" name="fami_nombre_2_sol" class="form-control" id="fami_nombre_2_sol" value='<?= $datos_solicitud['fami_nombre_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_cel_2_sol">* CELULAR 2</label>
                        <input type="number" name="fami_cel_2_sol" class="form-control" id="fami_cel_2_sol" value='<?= $datos_solicitud['fami_cel_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_tel_2_sol">* TELEFONO FIJO 2</label>
                        <input type="number" name="fami_tel_2_sol" class="form-control" id="fami_tel_2_sol" value='<?= $datos_solicitud['fami_tel_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-3 mt-2">
                        <label for="fami_parent_2_sol">* PARENTESCO 2</label>
                        <select name="fami_parent_2_sol" class="form-control" id="fami_parent_2_sol">
                            <option value="MADRE" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'MADRE') ? 'selected' : ''; ?>>MADRE</option>
                            <option value="PADRE" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'PADRE') ? 'selected' : ''; ?>>PADRE</option>
                            <option value="HERMANO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'HERMANO') ? 'selected' : ''; ?>>HERMANO (A)</option>
                            <option value="HIJO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'HIJO') ? 'selected' : ''; ?>>HIJO (A)</option>
                            <option value="ESPOSO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'ESPOSO') ? 'selected' : ''; ?>>ESPOSO (A)</option>
                            <option value="ABUELO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'ABUELO') ? 'selected' : ''; ?>>ABUELO (A)</option>
                            <option value="TIO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'TIO') ? 'selected' : ''; ?>>TIO (A)</option>
                            <option value="SOBRINO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'SOBRINO') ? 'selected' : ''; ?>>SOBRINO (A)</option>
                            <option value="PRIMO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'PRIMO') ? 'selected' : ''; ?>>PRIMO (A)</option>
                            <option value="SUEGRO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'SUEGRO') ? 'selected' : ''; ?>>SUEGRO (A)</option>
                            <option value="CUÑADO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'CUÑADO') ? 'selected' : ''; ?>>CUÑADO (A)</option>
                            <option value="YERNO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'YERNO') ? 'selected' : ''; ?>>YERNO</option>
                            <option value="NUERA" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'NUERA') ? 'selected' : ''; ?>>NUERA</option>
                            <option value="NIETO" <?php echo ($datos_solicitud['fami_parent_2_sol'] == 'NIETO') ? 'selected' : ''; ?>>NIETO (A)</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="seccion">
                <h3 class="subtitulo">REFERENCIAS PERSONALES</h3>
                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_nombre_1_sol">* NOMBRE COMPLETO 1</label>
                        <input type="text" name="refer_nombre_1_sol" class="form-control" id="refer_nombre_1_sol" value='<?= $datos_solicitud['refer_nombre_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_cel_1_sol">* CELULAR 1</label>
                        <input type="number" name="refer_cel_1_sol" class="form-control" id="refer_cel_1_sol" value='<?= $datos_solicitud['refer_cel_1_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_tel_1_sol">* TELEFONO FIJO 1</label>
                        <input type="number" name="refer_tel_1_sol" class="form-control" id="refer_tel_1_sol" value='<?= $datos_solicitud['refer_tel_1_sol'] ?? ''; ?>' />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_nombre_2_sol">* NOMBRE COMPLETO 2</label>
                        <input type="text" name="refer_nombre_2_sol" class="form-control" id="refer_nombre_2_sol" value='<?= $datos_solicitud['refer_nombre_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_cel_2_sol">* CELULAR 2</label>
                        <input type="number" name="refer_cel_2_sol" class="form-control" id="refer_cel_2_sol" value='<?= $datos_solicitud['refer_cel_2_sol'] ?? ''; ?>' />
                    </div>
                    <div class="col-12 col-sm-4 mt-2">
                        <label for="refer_tel_2_sol">* TELEFONO FIJO 2</label>
                        <input type="number" name="refer_tel_2_sol" class="form-control" id="refer_tel_2_sol" value='<?= $datos_solicitud['refer_tel_2_sol'] ?? ''; ?>' />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <h3 class="subtitulo">SUBIR ARCHIVOS</h3>
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="fileInput" class="form-label fw-bold">* Subir Archivos</label>
                        <input type="file" name="archivos[]" id="fileInput" class="form-control mb-2" multiple accept=".jpg,.jpeg,.png,.pdf" />
                        <div id="fileList" class="mb-3">
                            <?php foreach ($archivosExistentes as $archivo): ?>
                                <div class="alert alert-secondary d-flex justify-content-between align-items-center py-2 px-3 mb-2">
                                    <span><i class="bi bi-file-earmark-text me-2"></i> <?= $archivo ?></span>
                                    <a href="documentos/<?= $archivo ?>" class="btn btn-sm btn-outline-primary" target="_blank">Ver Documento</a>
                                    <a href="eliminar_documento.php?archivo=<?= urlencode($archivo) ?>&id_solicitud=<?= urlencode($id_solicitud) ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este documento?');">
                                        Eliminar
                                    </a>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_solicitud" value="<?= $datos_solicitud['id_solicitud'] ?? ''; ?>" />
            <a href="seeSolicitud.php"><img src='../../img/atras.png' width="72" height="72" title="back" style="margin-right: 80px;" /></a>
            <button type="submit" class="btn btn-primary">Actualizar Solicitud</button>

        </form>
    </div>
</body>
<script>
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    fileInput.addEventListener('change', (event) => {
        const selectedFiles = Array.from(event.target.files);

        // Mostrar solo los primeros 3 archivos seleccionados
        if (selectedFiles.length > 3) {
            alert("Solo puedes subir hasta 3 archivos.");
            fileInput.value = ''; // Borra la selección si son más de 3
            return;
        }

        renderFileList(selectedFiles);
    });

    function renderFileList(files) {
        // Agregar solo los archivos nuevos a la lista sin borrar los anteriores
        files.forEach((file) => {
            const fileDiv = document.createElement('div');
            fileDiv.className = 'alert alert-secondary d-flex justify-content-between align-items-center py-2 px-3 mb-2';
            fileDiv.innerHTML = `
            <span><i class="bi bi-file-earmark-text me-2"></i> ${file.name}</span>
        `;
            fileList.appendChild(fileDiv);
        });
    }
</script>

</html>