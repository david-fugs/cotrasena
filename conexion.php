<?php
	 
	$mysqli = new mysqli('localhost', 'softepuc_cotrasena', 'uBQ;*zdC-5bG', 'softepuc_cotrasena');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>