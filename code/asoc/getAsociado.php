<?php
include("../../conexion.php");

if (isset($_GET['cedula_aso']) && !empty($_GET['cedula_aso'])) {
    $cedula_aso = $_GET['cedula_aso']; // Obtener la cédula desde el parámetro GET

    // Consulta SQL para verificar si existe la cédula
    $query = "SELECT nombre_aso, edad_aso, direccion_aso, tipo_doc_aso, sexo_aso, nacionalidad_aso, 
                     estado_civil_aso, per_cargo_aso, tip_vivienda_aso, barrio_aso, ciudad_aso, departamente_aso, 
                     nivel_educa_aso, titulo_obte_aso, titulo_pos_aso, tel_aso, email_aso, cel_aso, 
                     fecha_nacimiento_aso, ciudad_naci_aso, dpto_naci_aso, pais_naci_aso, estrato_aso, 
                     dpto_exp_cedula_aso, pais_exp_cedula_aso 
              FROM asociados WHERE cedula_aso = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $cedula_aso); // 's' para cadena de texto
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si existe el asociado, obtener los datos
            $stmt->bind_result($nombre_aso, $edad_aso, $direccion_aso, $tipo_doc_aso, $sexo_aso, $nacionalidad_aso, 
                               $estado_civil_aso, $per_cargo_aso, $tip_vivienda_aso, $barrio_aso, $ciudad_aso, 
                               $departamente_aso, $nivel_educa_aso, $titulo_obte_aso, $titulo_pos_aso, $tel_aso, 
                               $email_aso, $cel_aso, $fecha_nacimiento_aso, $ciudad_naci_aso, $dpto_naci_aso, 
                               $pais_naci_aso, $estrato_aso, $dpto_exp_cedula_aso, $pais_exp_cedula_aso);
            $stmt->fetch();

            // Enviar los datos como respuesta JSON
            echo json_encode([
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
                'pais_exp_cedula_aso' => $pais_exp_cedula_aso
            ]);
        } else {
            // Si no se encuentra el asociado
            echo json_encode([
                'error' => 'Asociado no encontrado'
            ]);
        }
        $stmt->close();
    } else {
        // Error en la consulta
        echo json_encode([
            'error' => 'Error en la consulta.'
        ]);
    }
} else {
    // Si no hay cédula proporcionada
    echo json_encode([
        'error' => 'Cédula no proporcionada.'
    ]);
}

$mysqli->close();
?>
