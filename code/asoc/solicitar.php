<?php
session_start();

// Variables de sesión
$id_usu = $_SESSION['id_usu'];
$tipo_usu = $_SESSION['tipo_usu'];

include("../../conexion.php");

// Inicializar variable para almacenar datos
$datos_usuario = [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOLICITUD</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Using Select2 from a CDN-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../css/formulario.css" rel="stylesheet">

</head>


<body>
    <header class="header">
        <div class="logo-container">
            <img src='../../img/img2.jpg' class="logo" alt="Logo COTRASENA">
        </div>
        <h1 class="title">SOLICITUD DE CRÉDITO</h1>
    </header>
    <div class="container">
        <h2 class="titulo-principal"><i class="fas fa-credit-card me-2"></i>FORMULARIO DE SOLICITUD</h2>
        <p class="obligatorio mb-4"><i class="fas fa-asterisk me-1"></i> Campos obligatorios</p>

        <form action="agregarSolicitud.php" method="POST" enctype="multipart/form-data">
            <div class="seccion">
                <h3 class="subtitulo">DATOS PERSONALES</h3>

                <div class="row">
                    <div class="col-md-2">
                        <label for="tipo_doc_aso" class="form-label">Tipo documento</label>
                        <select name="tipo_doc_aso" class="form-select" id="tipo_doc_aso" required>
                            <option value="C.C.">C.C.</option>
                            <option value="C.E.">C.E.</option>
                            <option value="PASAPORTE">Pasaporte</option>
                            <option value="OTRO">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cedula_aso" class="form-label">Cédula No.</label>
                        <input type='text' name='cedula_aso' class='form-control' id="cedula_aso"
                            value='' required>
                    </div>
                    <div class="col-md-4">
                        <label for="nombre_aso" class="form-label">Nombre asociado</label>
                        <input type='text' name='nombre_aso' id="nombre_aso" class='form-control'
                            value=''>
                    </div>
                    <div class="col-md-4">
                        <label for="direccion_aso" class="form-label">Dirección</label>
                        <input type='text' name='direccion_aso' class='form-control form-control-dark-focus' id="direccion_aso"
                            value=''>
                    </div>
                </div>

                <!-- Más campos de datos personales -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="fecha_exp_doc_aso" class="form-label">Fecha expedición</label>
                        <input type="date" name="fecha_exp_doc_aso" id="fecha_exp_doc_aso" class="form-control" required
                            value=''>
                    </div>
                    <div class="col-md-3">
                        <label for="pais_exp_cedula_aso" class="form-label">País expedición</label>
                        <input type="text" name="pais_exp_cedula_aso" id="pais_exp_cedula_aso" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="dpto_exp_cedula_aso" class="form-label">Departamento expedición</label>
                        <input type="text" name="dpto_exp_cedula_aso" id="dpto_exp_cedula_aso" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="ciudad_exp_cedula_aso" class="form-label">Ciudad expedición</label>
                        <input type="text" name="ciudad_exp_cedula_aso" id="ciudad_exp_cedula_aso" class="form-control" required>
                    </div>
                </div>

                <!-- Continúa con el resto de campos... -->
                <!-- Se organizan de manera similar -->

                <div class="form-group">
                    <div class="row mt-3">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_nacimiento_aso">* Fecha Nacimiento</label>
                            <input type="date" name="fecha_nacimiento_aso" class="form-control" id="fecha_nacimiento_aso" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="pais_naci_aso">* Pais Nacimiento</label>
                            <input type="text" name="pais_naci_aso" class="form-control" id="pais_naci_aso" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="dpto_naci_aso">* Departamento nacimiento</label>
                            <input type="text" name="dpto_naci_aso" class="form-control" id="dpto_naci_aso" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_naci_aso">* Ciudad nacimiento</label>
                            <input type="text" name="ciudad_naci_aso" class="form-control" id="ciudad_naci_aso" required />
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="edad_aso">* Edad</label>
                            <input type='number' name='edad_aso' class='form-control' id="edad_aso" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sexo_aso">* Sexo</label>
                            <select name="sexo_aso" class="form-control" id="sexo_aso" required>
                                <option value=""></option>
                                <option value="Femenino">FEMENINO</option>
                                <option value="Masculino">MASCULINO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="nacionalidad_aso">* Nacionalidad</label>
                            <input type='text' name='nacionalidad_aso' class='form-control' id="nacionalidad_aso" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estado_civil_aso">* Estado Civil</label>
                            <select name="estado_civil_aso" class="form-control form-control-dark-focus" id="estado_civil_aso" required>
                                <option value="SOLTERO">SOLTERO (A)</option>
                                <option value="CASADO">CASADO (A)</option>
                                <option value="UNION LIBRE">UNION LIBRE</option>
                                <option value="DIVORCIADO">DIVORCIADO (A)</option>
                                <option value="VIUDO">VIUDO (A)</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="per_cargo_aso">* Personas a Cargo</label>
                            <input type='number' name='per_cargo_aso' id="per_cargo_aso" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tip_vivienda_aso">* Tipo Vivienda</label>
                            <select name="tip_vivienda_aso" class="form-control" id="tip_vivienda_aso" required>
                                <option value="Arriendo">ARRIENDO</option>
                                <option value="Propia">PROPIA</option>
                                <option value="Familiar">FAMILIAR</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="barrio_aso">* Barrio</label>
                            <input type='text' name='barrio_aso' id="barrio_aso" class='form-control form-control-dark-focus' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_aso">* Ciudad</label>
                            <input type='text' name='ciudad_aso' id="ciudad_aso" class='form-control form-control-dark-focus' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="departamente_aso">* Departamento</label>
                            <input type='text' name='departamente_aso' id="departamente_aso" class='form-control form-control-dark-focus' required>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estrato_aso">* Estrato</label>
                            <input type='number' name='estrato_aso' id="estrato_aso" class='form-control form-control-dark-focus' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="email_aso">* Email</label>
                            <input type='email' name='email_aso' id="email_aso" class='form-control form-control-dark-focus' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel_aso">* Telefono</label>
                            <input type='text' name='tel_aso' id="tel_aso" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="cel_aso">* Celular</label>
                            <input type='text' name='cel_aso' id="cel_aso" class='form-control form-control-dark-focus' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="nivel_educa_aso">* Nivel Educativo</label>
                            <select name="nivel_educa_aso" class="form-control form-control-dark-focus" id="nivel_educa_aso" required>
                                <option value="PRIMARIA">PRIMARIA</option>
                                <option value="BACHILLER">BACHILLER</option>
                                <option value="TECNICO">TECNICO (A)</option>
                                <option value="TECNOLOGO">TECNOLOGO (A)</option>
                                <option value="UNIVERSITARIO">UNIVERSITARIO (A)</option>
                                <option value="ESPECIALIZACION">ESPECIALIZACION</option>
                                <option value="MAESTRIA">MAESTRIA</option>
                                <option value="DOCTORADO">DOCTORADO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="titulo_obte_aso">Titulo Obtenido</label>
                            <input type='text' name='titulo_obte_aso' id="titulo_obte_aso" class='form-control form-control-dark-focus' />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="titulo_pos_aso">Titulo en Postgrado</label>
                            <input type='text' name='titulo_pos_aso' id="titulo_pos_aso" class='form-control form-control-dark-focus' />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Solicitud de Crédito -->
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">DATOS DEL CREDITO</h3>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="fecha_sol">* Fecha</label>
                            <input type="text" name="fecha_sol" class="form-control" id="fecha_sol"
                                value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="tipo_deudor_aso">* Tipo Deudor</label>
                            <select name="tipo_deudor_aso" class="form-control" id="tipo_deudor_aso" required>
                                <option value="DEUDOR PRINCIPAL">DEUDOR PRINCIPAL</option>
                                <option value="DEUDOR SOLIDARIO">DEUDOR SOLIDARIO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="monto_sol">* Monto Solicitado</label>
                            <input type="number" name="monto_sol" class="form-control" id="monto_sol" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="plazo_sol">* Plazo</label>
                            <select name="plazo_sol" class="form-control" id="plazo_sol" required>
                                <option value="12 MESES">12 MESES</option>
                                <option value="24 MESES">24 MESES</option>
                                <option value="36 MESES">36 MESES</option>
                                <option value="48 MESES">48 MESES</option>
                                <option value="60 MESES">60 MESES</option>
                                <option value="72 MESES">72 MESES</option>
                                <option value="84 MESES">84 MESES</option>
                                <option value="96 MESES">96 MESES</option>
                                <option value="108 MESES">108 MESES</option>
                                <option value="120 MESES">120 MESES</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2 d-none" id="otro_plazo_div">
                            <label for="otro_plazo_sol">* Cuanto Plazo</label>
                            <input type="text" name="otro_plazo_sol" class="form-control" id="otro_plazo_sol" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="linea_cred_aso">* Linea Credito</label>
                            <select name="linea_cred_aso" class="form-control" id="linea_cred_aso" required>
                                <option value="LIBRE INVERSION">LIBRE INVERSION</option>
                                <option value="CREDIAPORTES">CREDIAPORTES</option>
                                <option value="CREDITO EDUCATIVO">CREDITO EDUCATIVO</option>
                                <option value="CREDITO ROTATIVO">CREDITO ROTATIVO</option>
                                <option value="CREDITO PRIMA">CREDITO PRIMA</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos financieros -->
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">DATOS LABORALES</h3>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="ocupacion_sol">* Ocupacion</label>
                            <select name="ocupacion_sol" class="form-control" id="ocupacion_sol" required>
                                <option value="EMPLEADO">EMPLEADO (A)</option>
                                <option value="INDEPENDIENTE">INDEPENDIENTE</option>
                                <option value="COMERCIANTE">COMERCIANTE</option>
                                <option value="PENSIONADO">PENSIONADO (A)</option>
                                <option value="RENTISTA CAPITAL">RENTISTA CAPITAL</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="func_estad_sol">* Funcionario Estado</label>
                            <select name="func_estad_sol" id="func_estad_sol" class="form-control" required>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="emp_labo_sol">* Empresa donde Labora</label>
                            <input type='text' name='emp_labo_sol' id="emp_labo_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="nit_emp_labo_sol">* NIT Empresa</label>
                            <input type='text' name='nit_emp_labo_sol' id="nit_emp_labo_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="act_emp_labo_sol">* Actividad Empresa</label>
                            <input type='text' name='act_emp_labo_sol' id="act_emp_labo_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="dir_emp_sol">* Direccion Empresa</label>
                            <input name="dir_emp_sol" class="form-control" id="dir_emp_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ciudad_emp_sol">* Ciudad</label>
                            <input name="ciudad_emp_sol" id="ciudad_emp_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="depar_emp_sol">* Departamento</label>
                            <input type='text' name='depar_emp_sol' id="depar_emp_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="tel_emp_sol">* Telefono Empresa</label>
                            <input type='number' name='tel_emp_sol' id="tel_emp_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fecha_ing_emp_sol">* Fecha Ingreso</label>
                            <input type="date" name="fecha_ing_emp_sol" class="form-control" id="fecha_ing_emp_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="anti_emp_sol">* Antigüedad en años</label>
                            <input type="number" name="anti_emp_sol" id="anti_emp_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="anti_emp_sol">* Antigüedad en Meses</label>
                            <input type="number" name="anti_emp_mes_sol" id="anti_emp_emp_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="cargo_actual_emp_sol">* Cargo Actual</label>
                            <input type='text' name='cargo_actual_emp_sol' id="cargo_actual_emp_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="area_trabajo_sol">* Área Trabajo</label>
                            <input type='text' name='area_trabajo_sol' id="area_trabajo_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="acti_inde_sol">* Actividad como Independiente</label>
                            <input type="text" name="acti_inde_sol" class="form-control" id="acti_inde_sol" required />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="num_emple_emp_sol">* Numero Empleados de su Empresa </label>
                            <input type="number" name="num_emple_emp_sol" id="num_emple_emp_sol" class="form-control" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">DATOS FINANCIEROS</h3>
                    <h5>INGRESOS</h5>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="salario_sol">* Salario</label>
                            <input type="number" name="salario_sol" class="form-control" id="salario_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="ing_arri_sol">* Ingreso por Arriendo</label>
                            <input type="number" name="ing_arri_sol" id="ing_arri_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="honorarios_sol">* Honorarios</label>
                            <input type='number' name='honorarios_sol' id="honorarios_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="pension_sol">* Pensión</label>
                            <input type='number' name='pension_sol' id="pension_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="otros_ing_sol">* Otros Ingresos</label>
                            <input type='number' name='otros_ing_sol' id="otros_ing_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <h5>EGRESOS</h5>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cuota_pres_sol">* Cuota Prestamos</label>
                            <input type="number" name="cuota_pres_sol" class="form-control" id="cuota_pres_sol" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cuota_tar_cred_sol">* Cuota Tarjeta Credito</label>
                            <input type="number" name="cuota_tar_cred_sol" id="cuota_tar_cred_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="arrendo_sol">* Arrendamiento</label>
                            <input type='number' name='arrendo_sol' id="arrendo_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="gastos_fam_sol">* Gastos Familiares</label>
                            <input type='number' name='gastos_fam_sol' id="gastos_fam_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="otros_gastos_sol">* Otros Gastos</label>
                            <input type='number' name='otros_gastos_sol' id="otros_gastos_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="ahorro_banco_sol">* Bancos (Ahorros, Inversiones , CDTS) </label>
                            <input type="number" name="ahorro_banco_sol" class="form-control" id="ahorro_banco_sol" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="vehiculo_sol">* Vehiculos (Valor Comercial)</label>
                            <input type="number" name="vehiculo_sol" id="vehiculo_sol" class="form-control" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="bienes_raices_sol">* Bienes Raices (Valor Comercial)</label>
                            <input type='number' name='bienes_raices_sol' id="bienes_raices_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="otros_activos_sol">* Otros Activos</label>
                            <input type='number' name='otros_activos_sol' id="otros_activos_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="presta_total_sol">* Prestamos (Deuda Total)</label>
                            <input type='number' name='presta_total_sol' id="presta_total_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="hipotecas_sol">* Hipotecas</label>
                            <input type='number' name='hipotecas_sol' id="hipotecas_sol" class='form-control' required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="tar_cred_total_sol">* Tarjeta de Credito(Deuda Total) </label>
                            <input type='number' name='tar_cred_total_sol' id="tar_cred_total_sol" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="otros_pasivos_sol">* Otros Pasivos</label>
                            <input type='number' name='otros_pasivos_sol' id="otros_pasivos_sol" class='form-control' required />
                        </div>
                    </div>
                </div>
            </div>
            <!--Relacion de inmuebles-->
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">RELACION INMUEBLES</h3>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="tipo_inmu_1_sol">Tipo de Inmueble 1</label>
                            <select name="tipo_inmu_1_sol" class="form-control form-control-dark-focus" id="tipo_inmu_1_sol">
                                <option value="LOTE">LOTE</option>
                                <option value="CASA">CASA</option>
                                <option value="FINCA">FINCA</option>
                                <option value="APARTAMENTO">APARTAMENTO</option>
                                <option value="LOCAL">LOCAL</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="direccion_1_sol">Direccion 1</label>
                            <input type='text' name='direccion_1_sol' id="direccion_1_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="valor_comer_1_sol">Valor Comercial 1</label>
                            <input type='number' name='valor_comer_1_sol' id="valor_comer_1_sol" class='form-control' />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="tipo_inmu_2_sol">TIPO DE INMUEBLE 2</label>
                            <select name="tipo_inmu_2_sol" class="form-control form-control-dark-focus" id="tipo_inmu_2_sol">
                                <option value="LOTE">LOTE</option>
                                <option value="CASA">CASA</option>
                                <option value="FINCA">FINCA</option>
                                <option value="APARTAMENTO">APARTAMENTO</option>
                                <option value="LOCAL">LOCAL</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="direccion_2_sol">DIRECCION 2</label>
                            <input type='text' name='direccion_2_sol' id="direccion_2_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="valor_comer_2_sol">Valor Comercial 2</label>
                            <input type='number' name='valor_comer_2_sol' id="valor_comer_2_sol" class='form-control' />
                        </div>
                    </div>
                </div>
            </div>
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">RELACION VEHICULOS</h3>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tipo_vehi_1_sol">Tipo de Vehiculo 1</label>
                            <select name="tipo_vehi_1_sol" class="form-control" id="tipo_vehi_1_sol">
                                <option value="MOTO">MOTO</option>
                                <option value="CARRO">CARRO</option>
                                <option value="CAMIONETA">CAMIONETA</option>
                                <option value="BUS">BUS</option>
                                <option value="BUSETA">BUSETA</option>
                                <option value="MICROBUS">MICROBUS</option>
                                <option value="TAXI">TAXI</option>
                                <option value="CAMION">CAMION</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="modelo_1_sol">Modelo 1</label>
                            <input type='number' name='modelo_1_sol' id="modelo_1_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="marca_1_sol">Marca 1</label>
                            <input type='text' name='marca_1_sol' id="marca_1_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="placa_1_sol">Placa 1</label>
                            <input type='text' name='placa_1_sol' id="placa_1_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="valor_1_sol">Valor Comercial 1</label>
                            <input type='number' name='valor_1_sol' id="valor_1_sol" class='form-control' />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tipo_vehi_2_sol">Tipo de Vehiculo 2</label>
                            <select name="tipo_vehi_2_sol" class="form-control" id="tipo_vehi_2_sol">
                                <option value="MOTO">MOTO</option>
                                <option value="CARRO">CARRO</option>
                                <option value="CAMIONETA">CAMIONETA</option>
                                <option value="BUS">BUS</option>
                                <option value="BUSETA">BUSETA</option>
                                <option value="MICROBUS">MICROBUS</option>
                                <option value="TAXI">TAXI</option>
                                <option value="CAMION">CAMION</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="modelo_2_sol">Modelo 2</label>
                            <input type='number' name='modelo_2_sol' id="modelo_2_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="marca_2_sol">Marca 2</label>
                            <input type='text' name='marca_2_sol' id="marca_2_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="placa_2_sol">Placa 2</label>
                            <input type='text' name='placa_2_sol' id="placa_2_sol" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="valor_2_sol">Valor Comercial 2</label>
                            <input type='number' name='valor_2_sol' id="valor_2_sol" class='form-control' />
                        </div>
                    </div>
                </div>
            </div>
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">OTROS ACTIVOS</h3>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="ahorros_sol">* (CDT, Cartera, Inversiones, Cuentas, Aportes, Otros)</label>
                            <select name="ahorros_sol" class="form-control" id="ahorros_sol" required>
                                <option value="AHORROS">AHORROS</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="valor_ahor_sol">* Valor General</label>
                            <input type='number' name='valor_ahor_sol' id="valor_ahor_sol" class='form-control' required />
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="enseres_sol">* (Muebles, Enseres, Equipos)</label>
                            <select name="enseres_sol" class="form-control" id="enseres_sol" required>
                                <option value="MUEBLES Y OTROS">MUEBLES Y OTROS</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="valor_enser_sol">* Valor General</label>
                            <input type='number' name='valor_enser_sol' id="valor_enser_sol" class='form-control' required />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Datos del conyugue -->
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">DATOS DEL CONYUGUE</h3>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="conyu_nombre_sol">Nombre Completo</label>
                            <input type="text" name="conyu_nombre_sol" class="form-control" id="conyu_nombre_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_cedula_sol">Cedula No.</label>
                            <input type="text" name="conyu_cedula_sol" class="form-control" id="conyu_cedula_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_naci_sol">Fecha Nacimiento</label>
                            <input type="date" name="conyu_naci_sol" class="form-control" id="conyu_naci_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_exp_sol">Ciudad Expedicion</label>
                            <input type="text" name="conyu_exp_sol" class="form-control" id="conyu_exp_sol" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="conyu_ciudadn_sol">Ciudad Nacimiento</label>
                            <input type="text" name="conyu_ciudadn_sol" class="form-control" id="conyu_ciudadn_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dpton_sol">Departamento Nacimiento</label>
                            <input type="text" name="conyu_dpton_sol" class="form-control" id="conyu_dpton_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_paism_sol">Pais Nacimiento</label>
                            <input type="text" name="conyu_paism_sol" class="form-control" id="conyu_paism_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_correo_sol">Email</label>
                            <input type="email" name="conyu_correo_sol" class="form-control" id="conyu_correo_sol" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <h3 class="subtitulo">DATOS LABORALES DEL CONYUGUE</h3>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="conyu_ocupacion_sol">Ocupacion</label>
                            <select name="conyu_ocupacion_sol" class="form-control" id="conyu_ocupacion_sol">
                                <option value="EMPLEADO">EMPLEADO (A)</option>
                                <option value="INDEPENDIENTE">INDEPENDIENTE</option>
                                <option value="COMERCIANTE">COMERCIANTE</option>
                                <option value="PENSIONADO">PENSIONADO (A)</option>
                                <option value="RENTISTA CAPITAL">RENTISTA CAPITAL</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_func_sol">Funcionario del Estado</label>
                            <select name="conyu_func_sol" class="form-control" id="conyu_func_sol">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_emp_lab_sol">Nombre Empresa</label>
                            <input type="text" name="conyu_emp_lab_sol" class="form-control" id="conyu_emp_lab_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_cargo_sol">Cargo</label>
                            <input type="text" name="conyu_cargo_sol" class="form-control" id="conyu_cargo_sol" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="conyu_salario_sol">Salario</label>
                            <input type="number" name="conyu_salario_sol" class="form-control" id="conyu_salario_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dir_lab_sol">Direccion</label>
                            <input type="text" name="conyu_dir_lab_sol" class="form-control" id="conyu_dir_lab_sol" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_tel_lab_sol">Telefono</label>
                            <input type="number" name="conyu_tel_lab_sol" class="form-control" id="conyu_tel_lab_sol" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conyu_ciudad_lab_sol">Ciudad</label>
                            <input type="text" name="conyu_ciudad_lab_sol" class="form-control" id="conyu_ciudad_lab_sol" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="conyu_dpto_lab_sol">Departamento</label>
                            <input type="text" name="conyu_dpto_lab_sol" class="form-control" id="conyu_dpto_lab_sol" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="seccion">
                <div class="form-group">
                    <h3 class="subtitulo">REFERENCIAS FAMILIARES</h3>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fami_nombre_1_sol">* Nombre Completo 1</label>
                            <input type="text" name="fami_nombre_1_sol" class="form-control" id="fami_nombre_1_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_cel_1_sol">* Celular 1</label>
                            <input type="number" name="fami_cel_1_sol" class="form-control" id="fami_cel_1_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_tel_1_sol">* Telefono Fijo 1</label>
                            <input type="number" name="fami_tel_1_sol" class="form-control" id="fami_tel_1_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_parent_1_sol">* Parentesco 1</label>
                            <select name="fami_parent_1_sol" class="form-control" id="fami_parent_1_sol" required>
                                <option value="MADRE">MADRE</option>
                                <option value="PADRE">PADRE</option>
                                <option value="HERMANO">HERMANO (A)</option>
                                <option value="HIJO">HIJO (A)</option>
                                <option value="ESPOSO">ESPOSO (A)</option>
                                <option value="ABUELO">ABUELO (A)</option>
                                <option value="TIO">TIO (A)</option>
                                <option value="SOBRINO">SOBRINO (A)</option>
                                <option value="PRIMO">PRIMO (A)</option>
                                <option value="SUEGRO">SUEGRO (A)</option>
                                <option value="CUÑADO">CUÑADO (A)</option>
                                <option value="YERNO">YERNO</option>
                                <option value="NUERA">NUERA</option>
                                <option value="NIETO">NIETO (A)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="fami_nombre_2_sol">* Nombre Completo 2</label>
                            <input type="text" name="fami_nombre_2_sol" class="form-control" id="fami_nombre_2_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_cel_2_sol">* Celular 2</label>
                            <input type="number" name="fami_cel_2_sol" class="form-control" id="fami_cel_2_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_tel_2_sol">* Telefono Fijo 2</label>
                            <input type="number" name="fami_tel_2_sol" class="form-control" id="fami_tel_2_sol" required />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="fami_parent_2_sol">* Parentesco 2</label>
                            <select name="fami_parent_2_sol" class="form-control" id="fami_parent_2_sol" required>
                                <option value="MADRE">MADRE</option>
                                <option value="PADRE">PADRE</option>
                                <option value="HERMANO">HERMANO (A)</option>
                                <option value="HIJO">HIJO (A)</option>
                                <option value="ESPOSO">ESPOSO (A)</option>
                                <option value="ABUELO">ABUELO (A)</option>
                                <option value="TIO">TIO (A)</option>
                                <option value="SOBRINO">SOBRINO (A)</option>
                                <option value="PRIMO">PRIMO (A)</option>
                                <option value="SUEGRO">SUEGRO (A)</option>
                                <option value="CUÑADO">CUÑADO (A)</option>
                                <option value="YERNO">YERNO</option>
                                <option value="NUERA">NUERA</option>
                                <option value="NIETO">NIETO (A)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <h3 class="subtitulo">REFERENCIAS PERSONALES</h3>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="refer_nombre_1_sol">* Nombre Completo 1</label>
                            <input type="text" name="refer_nombre_1_sol" class="form-control" id="refer_nombre_1_sol" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_cel_1_sol">* Celular 1</label>
                            <input type="number" name="refer_cel_1_sol" class="form-control" id="refer_cel_1_sol" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_tel_1_sol">* Telefono Fijo 1</label>
                            <input type="number" name="refer_tel_1_sol" class="form-control" id="refer_tel_1_sol" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="refer_nombre_2_sol">* Nombre Completo 2</label>
                            <input type="text" name="refer_nombre_2_sol" class="form-control" id="refer_nombre_2_sol" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_cel_2_sol">* Celular 2</label>
                            <input type="number" name="refer_cel_2_sol" class="form-control" id="refer_cel_2_sol" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="refer_tel_2_sol">* Telefono Fijo 2</label>
                            <input type="number" name="refer_tel_2_sol" class="form-control" id="refer_tel_2_sol" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h3 class="subtitulo">SUBIR ARCHIVOS</h3>
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="fileInput" class="form-label fw-bold">* Subir Archivos</label>
                            <input type="file" name="archivos[]" id="fileInput" class="form-control mb-2" multiple accept=".jpg,.jpeg,.png,.pdf" />
                            <div id="fileList" class="mb-3"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Enviar Solicitud</button>
        </form>
    </div>
</body>
<script>
    //campo de plazo Meses
    document.addEventListener('DOMContentLoaded', function() {
        const selectPlazo = document.getElementById('plazo_sol');
        const otroPlazoDiv = document.getElementById('otro_plazo_div');

        selectPlazo.addEventListener('change', function() {
            if (selectPlazo.value === 'otro') {
                otroPlazoDiv.classList.remove('d-none');
                document.getElementById('otro_plazo').setAttribute('required', true);
            } else {
                otroPlazoDiv.classList.add('d-none');
                document.getElementById('otro_plazo').removeAttribute('required');
            }
        });
    });

    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    fileInput.addEventListener('change', (event) => {
        const selectedFiles = Array.from(event.target.files);

        // Mostrar solo los primeros 3 archivos seleccionados
        if (selectedFiles.length > 3) {
            alert("Solo puedes subir hasta 3 archivos.");
            fileInput.value = ''; // Borra la selección si son más de 3
            fileList.innerHTML = '';
            return;
        }

        renderFileList(selectedFiles);
    });

    function renderFileList(files) {
        fileList.innerHTML = '';
        files.forEach((file) => {
            const fileDiv = document.createElement('div');
            fileDiv.className = 'alert alert-secondary d-flex justify-content-between align-items-center py-2 px-3 mb-2';
            fileDiv.innerHTML = `
            <span><i class="bi bi-file-earmark-text me-2"></i> ${file.name}</span>
        `;
            fileList.appendChild(fileDiv);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const cedulaInput = document.getElementById('cedula_aso');
        const nombreInput = document.getElementById('nombre_aso');
        const edadInput = document.getElementById('edad_aso');
        const direccionInput = document.getElementById('direccion_aso');

        const tipo_doc_aso = document.getElementById('tipo_doc_aso');
        const edad_aso = document.getElementById('edad_aso');
        const sexo_aso = document.getElementById('sexo_aso');
        const nacionalidad_aso = document.getElementById('nacionalidad_aso');
        const estado_civil_aso = document.getElementById('estado_civil_aso');
        const per_cargo_aso = document.getElementById('per_cargo_aso');
        const tip_vivienda_aso = document.getElementById('tip_vivienda_aso');
        const barrio_aso = document.getElementById('barrio_aso');
        const ciudad_aso = document.getElementById('ciudad_aso');
        const departamente_aso = document.getElementById('departamente_aso');
        const nivel_educa_aso = document.getElementById('nivel_educa_aso');
        const titulo_obte_aso = document.getElementById('titulo_obte_aso');
        const titulo_pos_aso = document.getElementById('titulo_pos_aso');
        const tel_aso = document.getElementById('tel_aso');
        const email_aso = document.getElementById('email_aso');
        const cel_aso = document.getElementById('cel_aso');
        const fecha_nacimiento_aso = document.getElementById('fecha_nacimiento_aso');
        const ciudad_naci_aso = document.getElementById('ciudad_naci_aso');
        const dpto_naci_aso = document.getElementById('dpto_naci_aso');
        const pais_naci_aso = document.getElementById('pais_naci_aso');
        const estrato_aso = document.getElementById('estrato_aso');
        const dpto_exp_cedula_aso = document.getElementById('dpto_exp_cedula_aso');
        const pais_exp_cedula_aso = document.getElementById('pais_exp_cedula_aso');
        const fecha_exp_doc_aso = document.getElementById('fecha_exp_doc_aso');
        const ciudad_exp_cedula_aso = document.getElementById('ciudad_exp_cedula_aso');
        // Escuchar el evento 'blur' cuando el campo pierde el foco
        cedulaInput.addEventListener('blur', function() {
            const cedula_aso = cedulaInput.value.trim(); // Obtener la cédula que el usuario está escribiendo

            // Puedes poner un mínimo de caracteres si lo prefieres
            // Crear una solicitud AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'getAsociado.php?cedula_aso=' + encodeURIComponent(cedula_aso), true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Procesar la respuesta JSON
                    const data = JSON.parse(xhr.responseText);

                    if (data.error) {
                        // Si hubo un error, puedes mostrar un mensaje o dejar los campos vacíos
                        nombreInput.value = '';
                        edadInput.value = '';
                        direccionInput.value = '';
                        tipo_doc_aso.value = '';
                        edad_aso.value = '';
                        sexo_aso.value = '';
                        nacionalidad_aso.value = '';
                        estado_civil_aso.value = '';
                        per_cargo_aso.value = '';
                        tip_vivienda_aso.value = '';
                        barrio_aso.value = '';
                        ciudad_aso.value = '';
                        departamente_aso.value = '';
                        nivel_educa_aso.value = '';
                        titulo_obte_aso.value = '';
                        titulo_pos_aso.value = '';
                        tel_aso.value = '';
                        email_aso.value = '';
                        cel_aso.value = '';
                        fecha_nacimiento_aso.value = '';
                        ciudad_naci_aso.value = '';
                        dpto_naci_aso.value = '';
                        pais_naci_aso.value = '';
                        estrato_aso.value = '';
                        dpto_exp_cedula_aso.value = '';
                        pais_exp_cedula_aso.value = '';
                        fecha_exp_doc_aso.value = '';
                        ciudad_exp_cedula_aso.value = '';

                    } else {
                        console.log(data);
                        // Si la consulta fue exitosa, mostrar los datos en los campos
                        nombreInput.value = data.nombre_aso;
                        edadInput.value = data.edad_aso;
                        direccionInput.value = data.direccion_aso;
                        if (data.tipo_doc_aso) {
                            tipo_doc_aso.value = data.tipo_doc_aso.trim();
                        }
                        edad_aso.value = data.edad_aso;

                        // Verifica el valor de data.sexo_aso y asigna el valor adecuado al select
                        if (data.sexo_aso === 'M') {
                            sexo_aso.value = 'Masculino'; // Asigna "Masculino" si el valor es "M"
                        } else if (data.sexo_aso === 'F') {
                            sexo_aso.value = 'Femenino'; // Asigna "Femenino" si el valor es "F"
                        }
                        nacionalidad_aso.value = data.nacionalidad_aso;
                        estado_civil_aso.value = data.estado_civil_aso;
                        per_cargo_aso.value = data.per_cargo_aso;
                        tip_vivienda_aso.value = data.tip_vivienda_aso;
                        barrio_aso.value = data.barrio_aso;
                        ciudad_aso.value = data.ciudad_aso;
                        departamente_aso.value = data.departamente_aso;
                        nivel_educa_aso.value = data.nivel_educa_aso;
                        titulo_obte_aso.value = data.titulo_obte_aso;
                        titulo_pos_aso.value = data.titulo_pos_aso;
                        tel_aso.value = data.tel_aso;
                        email_aso.value = data.email_aso;
                        cel_aso.value = data.cel_aso;
                        fecha_nacimiento_aso.value = data.fecha_nacimiento_aso;
                        ciudad_naci_aso.value = data.ciudad_naci_aso;
                        dpto_naci_aso.value = data.dpto_naci_aso;
                        pais_naci_aso.value = data.pais_naci_aso;
                        estrato_aso.value = data.estrato_aso;
                        dpto_exp_cedula_aso.value = data.dpto_exp_cedula_aso;
                        pais_exp_cedula_aso.value = data.pais_exp_cedula_aso;
                        fecha_exp_doc_aso.value = data.fecha_exp_cedula_aso;
                        ciudad_exp_cedula_aso.value = data.ciudad_exp_cedula_aso;

                    }
                } else {
                    alert('Error en la solicitud. Intenta de nuevo.');
                }
            };

            xhr.onerror = function() {
                alert('Hubo un problema con la solicitud AJAX.');
            };

            xhr.send();
        });
    });
</script>


</html>