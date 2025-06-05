<?php
	 
	$mysqli = new mysqli('localhost', 'root', '', 'cotrasena_creditos');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>