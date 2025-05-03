<?php
include("../../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usu = $_POST['id_usu'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $usuario = $_POST['usuario'] ?? null;
    $tipo_usu = $_POST['tipo_usu'] ?? null;

    //crear update de usuarios

    $query = "UPDATE usuarios SET nombre = ?, usuario = ?, tipo_usu = ? WHERE id_usu = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssii", $nombre, $usuario, $tipo_usu, $id_usu);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado correctamente'); window.location = 'showusers.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario'); window.location = 'showusers.php';</script>";
    }

    $stmt->close();
}
