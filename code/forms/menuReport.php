<?php
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: index.php");
    }
    
    $usuario      = $_SESSION['usuario'];
    $nombre       = $_SESSION['nombre'];
    $tipo_usu     = $_SESSION['tipo_usu'];
	
	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CIAF</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
        <script>
		    // Función para ordenar un select
            function ordenarSelect(id_componente) 
            {
                var selectToSort = $('#' + id_componente);
                var optionActual = selectToSort.val();
                selectToSort.html(selectToSort.children('option').sort(function (a, b) {
                    return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
                })).val(optionActual);
            }

            $(document).ready(function () {
                // Llamadas a la función de ordenar para distintos selects
                ordenarSelect('selectDigitador');
            });
  		</script>
        <style>
            .responsive {
                max-width: 100%;
                height: auto;
            }

            .selector-for-some-widget {
                box-sizing: content-box;
            }
            .container-with-border {
	            border: 5px solid #ddd; /* Color del borde */
	            border-radius: 15px; /* Borde redondeado */
	            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
	            padding: 20px; /* Espaciado interno */
	            margin-top: 20px; /* Espaciado superior */
	        }
        </style>
    </head>
    <body>
    	
		<center>
		<img src='../../img/logo.png' width="300" height="212" class="responsive">
            <h1><b><i class="fas fa-edit"></i> INFORMES y/o REPORTES</b></h1>
        </center>
        <BR/>

        <div class="container">
			<form method="POST" action="report1.php">
			    <button type="submit" class="btn btn-dark">
					<span class="spinner-border spinner-border-sm"></span> EXPORTAR PRODUCTOS
				</button>
	  		</form>
	  	</div>

	  	<br><br>

		<div class="container">
			<form method="POST" action="report3.php">
				<div class="form-group">
					<div class="row">
	                	<div class="col-12 col-sm-3">
	                    	<label for="de">FECHA INICIAL</label>
	                    	<i class="fas fa-hand-point-down"></i>
							<input type='date' name='de' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
	                    	<label for="hasta">FECHA FINAL</label>
	                    	<i class="far fa-hand-point-down"></i>
							<input type='date' name='hasta' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
						    <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
						</div>
	           		</div>
	            </div>
			    
			    <button type="submit" class="btn btn-primary ">
					<span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS DE CAMPO POR FECHA
				</button>
	  		</form>
	  	</div>

	  	<br><br>

	  	<div class="container">
			<form method="POST" action="report4.php">
				<div class="form-group">
					<div class="row">
	                	<div class="col-12 col-sm-3">
	                    	<label for="de">FECHA INICIAL</label>
	                    	<i class="fas fa-hand-point-down"></i>
							<input type='date' name='de' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
	                    	<label for="hasta">FECHA FINAL</label>
	                    	<i class="far fa-hand-point-down"></i>
							<input type='date' name='hasta' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-6">
	                        <label for="id_usu">* ENCUESTADOR:</label>
	                        <select name='id_usu' class='form-control' id="selectDigitador" required>
							    <option value=''></option>
							    <?php
							    header('Content-Type: text/html;charset=utf-8');
							    $consulta = 'SELECT * FROM usuarios WHERE tipo_usu=2';
							    $res = mysqli_query($mysqli, $consulta);
							    $num_reg = mysqli_num_rows($res);
							    while ($row = $res->fetch_array()) {
							    ?>
							        <option value='<?php echo $row['id_usu']; ?>'>
							            <?php echo $row['nombre']; ?>
							        </option>
							    <?php
							    }
							    ?>
							</select>
	                    </div>
	           		</div>
	            </div>
			    
			    <button type="submit" class="btn btn-primary ">
					<span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS DE CAMPO POR FECHA Y ENCUESTADOR
				</button>
	  		</form>
	  	</div>

	  	<br><br>

	  	<div class="container">
			<form method="POST" action="report5.php">
				<div class="form-group">
					<div class="row">
	                	<div class="col-12 col-sm-3">
	                    	<label for="de">FECHA INICIAL</label>
	                    	<i class="fas fa-hand-point-down"></i>
							<input type='date' name='de' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
	                    	<label for="hasta">FECHA FINAL</label>
	                    	<i class="far fa-hand-point-down"></i>
							<input type='date' name='hasta' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
						    <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
						</div>
	           		</div>
	            </div>
			    
			    <button type="submit" class="btn btn-success">
					<span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS CAMPO POR FECHA - GRUPO FAMILIAR
				</button>
	  		</form>
	  	</div>

	  	<br><br>

	  	<div class="container">
			<form method="POST" action="report6.php">
				<div class="form-group">
					<div class="row">
	                	<div class="col-12 col-sm-3">
	                    	<label for="de">FECHA INICIAL</label>
	                    	<i class="fas fa-hand-point-down"></i>
							<input type='date' name='de' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-3">
	                    	<label for="hasta">FECHA FINAL</label>
	                    	<i class="far fa-hand-point-down"></i>
							<input type='date' name='hasta' class='form-control' required/>
	               		</div>
	               		<div class="col-12 col-sm-6">
	                        <label for="id_usu">* ENCUESTADOR:</label>
	                        <select name='id_usu' class='form-control' id="selectDigitador" required>
							    <option value=''></option>
							    <?php
							    header('Content-Type: text/html;charset=utf-8');
							    $consulta = 'SELECT * FROM usuarios WHERE tipo_usu=2';
							    $res = mysqli_query($mysqli, $consulta);
							    $num_reg = mysqli_num_rows($res);
							    while ($row = $res->fetch_array()) {
							    ?>
							        <option value='<?php echo $row['id_usu']; ?>'>
							            <?php echo $row['nombre']; ?>
							        </option>
							    <?php
							    }
							    ?>
							</select>
	                    </div>
	           		</div>
	            </div>

			    <button type="submit" class="btn btn-success">
					<span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS CAMPO POR FECHA YENCUESTADOR - GRUPO FAMILIAR
				</button>
	  		</form>
	  	</div>

	  	<div class="container-with-border">

		  	<div class="container">
				<form method="POST" action="rep_esp_1.php">
					<div class="form-group">
						<div class="row">
		                	<div class="col-12 col-sm-3">
		                    	<label for="de">FECHA INICIAL</label>
		                    	<i class="fas fa-hand-point-down"></i>
								<input type='date' name='de' class='form-control' required/>
		               		</div>
		               		<div class="col-12 col-sm-3">
		                    	<label for="hasta">FECHA FINAL</label>
		                    	<i class="far fa-hand-point-down"></i>
								<input type='date' name='hasta' class='form-control' required/>
		               		</div>
		               		<div class="col-12 col-sm-3">
							    <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
							</div>
		           		</div>
		            </div>
				    
				    <button type="submit" class="btn btn-warning">
						<span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS CAMPO POR FECHA - DATOS AGRUPADOS INTEGRANTES
					</button>
		  		</form>
		  	</div>

		</div>

		
			<center>
				<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
			</center>

	</body>
</html>