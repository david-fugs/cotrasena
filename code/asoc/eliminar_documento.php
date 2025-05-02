<?php
if (isset($_GET['archivo']) && isset($_GET['id_solicitud'])) {
    $archivo = basename($_GET['archivo']); // Evita rutas maliciosas
    $id_solicitud = $_GET['id_solicitud']; // Obtén el id_solicitud
    $ruta = __DIR__ . "/documentos/" . $archivo;

    if (file_exists($ruta)) {
        unlink($ruta);
        // Redirige a editSolicitud.php pasando el id_solicitud y el mensaje
        header("Location: editSolicitud.php?id_solicitud=" . urlencode($id_solicitud) . "&mensaje=Archivo eliminado");
    } else {
        // Redirige a editSolicitud.php pasando el id_solicitud y el error
        header("Location: editSolicitud.php?id_solicitud=" . urlencode($id_solicitud) . "&error=Archivo no encontrado");
    }
} else {
    // Redirige a editSolicitud.php pasando el id_solicitud y el error
    header("Location: editSolicitud.php?id_solicitud=" . urlencode($_GET['id_solicitud']) . "&error=Archivo no especificado");
}
exit;
