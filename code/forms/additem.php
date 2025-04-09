<?php
    
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];
    header("Content-Type: text/html;charset=utf-8");
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SOFT</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/popper.min.js"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <link href="../../fontawesome/css/all.css" rel="stylesheet">
		<script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
    	<!--SCRIPT PARA VALIDAR SI EL REGISTRO YA ESTÁ EN LA BD-->
    	<script type="text/javascript">
    		$(document).ready(function()
    		{  
        		$('#cod_pro').on('blur', function()
        		{
            		$('#result-cod_pro').html('<img src="../../img/loader.gif" />').fadeOut(1000);
             		var cod_pro = $(this).val();   
            		var dataString = 'cod_pro='+cod_pro;

            		$.ajax(
            		{
		                type: "POST",
		                url: "chkitem.php",
		                data: dataString,
		                success: function(data)
		                {
		                	$('#result-cod_pro').fadeIn(1000).html(data);
            			}
            		});
        		});
        	});    
  		</script>
    <head>
    <body>
  
		<center>
	    	<img src='../../img/logo.png' width="50" height="50" class="responsive">
		</center>
		<br />
<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fa-regular fa-id-badge"></i> REGISTRO DE PRODUCTOS</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='additem1.php' enctype="multipart/form-data" method="POST">
				<div class="row">
					<div class="col">
						<div id="result-cod_pro"></div>
					</div>  
				</div>
				<div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-3">
                        	<label for="cod_pro">* COD. PRODUCTO:</label>
                        	<input type='number' name='cod_pro' class='form-control' id="cod_pro" required />
                   		</div>
                   		<div class="col-12 col-sm-6">
	                        <label for="nom_pro">* DESCRIPCIÓN:</label>
	                        <input type='text' name='nom_pro' id="nom_pro" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-3">
	                        <label for="precio_prod">* PRECIO:</label>
	                        <input type='number' name='precio_prod' id="precio_prod" class='form-control' />
	                    </div>
               		</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                	<div class="col-12 col-sm-3">
	                        <label for="catg_pro">* CATEGORÍA:</label>
	                        <select class="form-control" name="catg_pro" required/>
	                            <option value=""></option>   
	                            <option value="ELECTRODOMESTICOS">ELECTRODOMESTICOS</option>
	                            <option value="ASEO">ASEO</option>
	                            <option value="MAQUINARIA">MAQUINARIA</option>
	                        </select>
	                    </div>
	                    <div class="col-12 col-sm-2">
	                        <label for="fecha_pro">FECHA PROD.</label>
	                        <input type='date' name='fecha_pro' class='form-control' required />
	                    </div>
	                </div>
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
</html>