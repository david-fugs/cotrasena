<?php
// Script de prueba para verificar el formato de nombres con fecha
$cedula_aso = "1234567890";
$fileName = "documento_prueba.pdf";

// Simular el proceso de generación de nombre
$originalName = basename($fileName);
$originalName = preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $originalName);

// Obtener la fecha actual en formato YYYY-MM-DD
$fechaActual = date('Y-m-d');

// Separar nombre y extensión
$pathInfo = pathinfo($originalName);
$nombreSinExt = $pathInfo['filename'];
$extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

// Crear nombre con cédula, fecha y nombre original
$newFileName = $cedula_aso . '_' . $fechaActual . '_' . $nombreSinExt . $extension;

echo "Archivo original: $fileName\n";
echo "Archivo procesado: $originalName\n";
echo "Fecha actual: $fechaActual\n";
echo "Nombre sin extensión: $nombreSinExt\n";
echo "Extensión: $extension\n";
echo "Nuevo nombre: $newFileName\n";

// Probar extracción del nombre para mostrar
$partesNombre = explode('_', $newFileName, 3);
$nombreMostrar = count($partesNombre) >= 3 ? $partesNombre[2] : $newFileName;
echo "Nombre para mostrar: $nombreMostrar\n";
?>
