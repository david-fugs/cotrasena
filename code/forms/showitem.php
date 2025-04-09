<?php
    
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SOFT</title>
        <script src="js/64d58efce2.js" ></script>
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
		<link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
		<link href="../../fontawesome/css/all.css" rel="stylesheet">
		<script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    </head>
    <body>
    	
    	<center>
	    	<img src='../../img/logo.png' width="300" height="212" class="responsive">
		</center>

		<h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-people-roof"></i> PRODUCTOS REGISTRADOS </b>
		</h1>

		<div class="flex">
			<div class="box">
				<form action="showitem.php" method="get" class="form">
					<input name="cod_pro" type="text" placeholder="Código">
					<input name="nom_pro" type="text" placeholder="Descripción">
					<input value="Realizar Busqueda" type="submit">
				</form>
			</div>
		</div>

		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

	@$cod_pro 	= ($_GET['cod_pro']);
	@$nom_pro 	= ($_GET['nom_pro']);
	
	$query = "SELECT * FROM productos WHERE (cod_pro LIKE '%".$cod_pro."%') AND (nom_pro LIKE '%".$nom_pro."%') ORDER BY nom_pro ASC";
	$res = $mysqli->query($query);
	$num_registros = mysqli_num_rows($res);
	$resul_x_pagina = 15;

	echo "<div class='flex'>
			<div class='box'>
	        	<table class='table'>
	            	<thead>
						<tr>
							<th>No.</th>
							<th>COD</th>
							<th>DESCRIPCIONS</th>
							<th>PRECIO</th>
			        		<th>CATEGORIA</th>
			        		<th>PDF</th>
							<th>EDIT</th>
			    		</tr>
			  		</thead>
	            	<tbody>";

	$paginacion = new Zebra_Pagination();
	$paginacion->records($num_registros);
	$paginacion->records_per_page($resul_x_pagina);

	$consulta = "SELECT * FROM productos WHERE (cod_pro LIKE '%".$cod_pro."%') AND (nom_pro LIKE '%".$nom_pro."%') ORDER BY nom_pro ASC LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). "," .$resul_x_pagina;
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
	    
		echo '
					<tr>
						<td data-label="No.">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
						<td data-label="COD">'.$row['cod_pro'].'</td>
						<td data-label="DESCRIPCION">'.$row['nom_pro'].'</td>
						<td data-label="PRECIO">'.$row['precio_prod'].'</td>
						<td data-label="CATEGORIA">'.$row['catg_pro'].'</td>
						<td data-label="PDF"><a href="pdfitem.php?cod_pro='.$row['cod_pro'].'"><img src="../../img/pdf.png" width=20 heigth=20></td>
						<td data-label="EDIT"><a href="edititem.php?cod_pro='.$row['cod_pro'].'"><img src="../../img/editar.png" width=20 heigth=20></td>
					</tr>';
		$i++;
	}
 
	echo '		</table>
			</div>		';

	$paginacion->render();

?>
		
		</div>
		<center>
			<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

	</body>
</html>