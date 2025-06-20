<?php
	 
	$mysqli = new mysqli('localhost', 'cotrasena_creditosuser', 'Cr3dito/2025.', 'cotrasena_creditos');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>