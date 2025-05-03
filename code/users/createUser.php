<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usu = $_POST['id_usu'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $usuario = $_POST['usuario'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;
    $tipo_usu = $_POST['tipo_usu'] ?? null;
    //pasar contrasena a sha1
    $contrasena = sha1($contrasena);
    //crear el inset en usuarios
    $query = "INSERT INTO usuarios (nombre, usuario, password, tipo_usu) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssi", $nombre, $usuario, $contrasena, $tipo_usu);
    if ($stmt->execute()) {
        echo "<script>alert('Usuario creado correctamente'); window.location = 'showusers.php';</script>";
    } else {
        echo "<script>alert('Error al crear el usuario'); window.location = 'showusers.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Error al crear el usuario'); window.location = 'showusers.php';</script>";
}
$mysqli->close();
