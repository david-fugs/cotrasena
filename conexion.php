<?php
	 
	$mysqli = new mysqli('localhost', 'cotrasena_creditos', 'uBQ;*zdC-5bG', 'cotrasena_creditos');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>