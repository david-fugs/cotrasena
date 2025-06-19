<?php
// Configuración de codificación UTF-8
header('Content-Type: application/json; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include("../../conexion.php");

if (isset($_GET['cedula_aso']) && !empty($_GET['cedula_aso'])) {
    $cedula_aso = $_GET['cedula_aso'];

    // Primero buscamos en la tabla solicitudes
    $query_solicitud = "SELECT * FROM solicitudes WHERE cedula_aso = ?  ORDER BY fecha_alta_solicitud DESC
    LIMIT 1 ";
    if ($stmt1 = $mysqli->prepare($query_solicitud)) {
        $stmt1->bind_param("s", $cedula_aso);
        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            $solicitudes = [];
            while ($row = $result->fetch_assoc()) {
                $solicitudes[] = $row;
            }            echo json_encode([
                'from' => 'solicitudes',
                'data' => $solicitudes
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $stmt1->close();
            $mysqli->close();
            exit; // Salimos aquí si ya encontramos datos en solicitudes
        }
        $stmt1->close();
    }

    // Si no se encontró en solicitudes, buscar en asociados
    $query = "SELECT nombre_aso, edad_aso, direccion_aso, tipo_doc_aso, sexo_aso, nacionalidad_aso, 
                     estado_civil_aso, per_cargo_aso, tip_vivienda_aso, barrio_aso, ciudad_aso, departamente_aso, 
                     nivel_educa_aso, titulo_obte_aso, titulo_pos_aso, tel_aso, email_aso, cel_aso, 
                     fecha_nacimiento_aso, ciudad_naci_aso, dpto_naci_aso, pais_naci_aso, estrato_aso, 
                     dpto_exp_cedula_aso, pais_exp_cedula_aso ,fecha_exp_cedula_aso,ciudad_exp_cedula_aso
              FROM asociados WHERE cedula_aso = ?";

    if ($stmt2 = $mysqli->prepare($query)) {
        $stmt2->bind_param("s", $cedula_aso);
        $stmt2->execute();
        $stmt2->store_result();

        if ($stmt2->num_rows > 0) {
            $stmt2->bind_result(
                $nombre_aso,
                $edad_aso,
                $direccion_aso,
                $tipo_doc_aso,
                $sexo_aso,
                $nacionalidad_aso,
                $estado_civil_aso,
                $per_cargo_aso,
                $tip_vivienda_aso,
                $barrio_aso,
                $ciudad_aso,
                $departamente_aso,
                $nivel_educa_aso,
                $titulo_obte_aso,
                $titulo_pos_aso,
                $tel_aso,
                $email_aso,
                $cel_aso,
                $fecha_nacimiento_aso,
                $ciudad_naci_aso,
                $dpto_naci_aso,
                $pais_naci_aso,
                $estrato_aso,
                $dpto_exp_cedula_aso,
                $pais_exp_cedula_aso,
                $fecha_exp_cedula_aso,
                $ciudad_exp_cedula_aso
            );
            $stmt2->fetch();

            echo json_encode([
                'from' => 'asociados',
                'nombre_aso' => $nombre_aso,
                'edad_aso' => $edad_aso,
                'direccion_aso' => $direccion_aso,
                'tipo_doc_aso' => $tipo_doc_aso,
                'sexo_aso' => $sexo_aso,
                'nacionalidad_aso' => $nacionalidad_aso,
                'estado_civil_aso' => $estado_civil_aso,
                'per_cargo_aso' => $per_cargo_aso,
                'tip_vivienda_aso' => $tip_vivienda_aso,
                'barrio_aso' => $barrio_aso,
                'ciudad_aso' => $ciudad_aso,
                'departamente_aso' => $departamente_aso,
                'nivel_educa_aso' => $nivel_educa_aso,
                'titulo_obte_aso' => $titulo_obte_aso,
                'titulo_pos_aso' => $titulo_pos_aso,
                'tel_aso' => $tel_aso,
                'email_aso' => $email_aso,
                'cel_aso' => $cel_aso,
                'fecha_nacimiento_aso' => $fecha_nacimiento_aso,
                'ciudad_naci_aso' => $ciudad_naci_aso,
                'dpto_naci_aso' => $dpto_naci_aso,
                'pais_naci_aso' => $pais_naci_aso,
                'estrato_aso' => $estrato_aso,
                'dpto_exp_cedula_aso' => $dpto_exp_cedula_aso,
                'pais_exp_cedula_aso' => $pais_exp_cedula_aso,
                'fecha_exp_cedula_aso' => $fecha_exp_cedula_aso,
                'ciudad_exp_cedula_aso' => $ciudad_exp_cedula_aso            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(['error' => 'Asociado no encontrado'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $stmt2->close();
    } else {
        echo json_encode(['error' => 'Error en la consulta a asociados.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
} else {
    echo json_encode(['error' => 'Cédula no proporcionada.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$mysqli->close();
