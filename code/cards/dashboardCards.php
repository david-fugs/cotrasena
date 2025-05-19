<?php
include(__DIR__ . '/../../conexion.php');

$cantidadSolicitudes = '
  SELECT count(*) from solicitudes 
  ';
$result = $mysqli->query($cantidadSolicitudes);
$row = $result->fetch_row();
$solicitudes = $row[0];

//contar las solicitudes por estado
$query = "
  SELECT estado_solicitud, COUNT(*) AS cantidad
  FROM solicitudes
  WHERE estado_solicitud IN (1, 2, 3, 4)
  GROUP BY estado_solicitud
";

$cantidad_estado = $mysqli->query($query);


//revision por estado de solicitud a las fechas dependiendo si es de 0 a 7 dias, de 8 a 15 dias o mayor a 15 dias
$sql_fechas_solicitudes = "
SELECT 
  'solicitudes' AS tipo,
  CASE 
    WHEN DATEDIFF(CURDATE(), s.fecha_alta_solicitud) <= 7 THEN '0-7 días'
    WHEN DATEDIFF(CURDATE(), s.fecha_alta_solicitud) <= 15 THEN '8-15 días'
    ELSE '16+ días'
  END AS rango,
  COUNT(*) AS cantidad
FROM solicitudes s
WHERE s.fecha_alta_solicitud IS NOT NULL AND s.estado_solicitud = 1
GROUP BY rango

UNION ALL

-- Agrupar fechas de la tabla aprobaciones
SELECT 
  'aprobaciones' AS tipo,
  CASE 
    WHEN DATEDIFF(CURDATE(), a.fecha_aprobacion) <= 7 THEN '0-7 días'
    WHEN DATEDIFF(CURDATE(), a.fecha_aprobacion) <= 15 THEN '8-15 días'
    ELSE '16+ días'
  END AS rango,
  COUNT(*) AS cantidad
FROM aprobaciones a
LEFT JOIN solicitudes as s ON s.id_solicitud=a.id_solicitud
WHERE a.fecha_aprobacion IS NOT NULL AND s.estado_solicitud = 2
GROUP BY rango

UNION ALL

-- Agrupar fechas de la tabla gerencia
SELECT 
  'gerencia' AS tipo,
  CASE 
    WHEN DATEDIFF(CURDATE(), g.fecha_gerencia) <= 7 THEN '0-7 días'
    WHEN DATEDIFF(CURDATE(), g.fecha_gerencia) <= 15 THEN '8-15 días'
    ELSE '16+ días'
  END AS rango,
  COUNT(*) AS cantidad
FROM gerencia g
LEFT JOIN solicitudes as s ON s.id_solicitud = g.id_solicitud
WHERE g.fecha_gerencia IS NOT NULL AND s.estado_solicitud = 3
GROUP BY rango";
$result = $mysqli->query($sql_fechas_solicitudes);




echo "<br><br><br><br><br><br><br>";


?>


<!-- Main Content -->
<div class="main-content" id="mainContent">
  <!-- Dashboard Cards -->
  <div class="dashboard-cards">
    <div class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Solicitudes Totales</div>
          <div class="card-value"><?= $solicitudes; ?></div>
        </div>
        <div class="card-icon">
          <i class="fa-regular fa-id-badge"></i>
        </div>
      </div>
    </div>
    <?php foreach ($cantidad_estado as $estado_solicitud) {

      if ($estado_solicitud['estado_solicitud'] == 1) {
        $palabra_soliciutud = "Solicitudes en Aprobacion";
        $cantidad = $estado_solicitud['cantidad'];
      }
      if ($estado_solicitud['estado_solicitud'] == 2) {
        $palabra_soliciutud = "Solicitudes Aprobadas";
        $cantidad = $estado_solicitud['cantidad'];
      }
      if ($estado_solicitud['estado_solicitud'] == 3) {
        $palabra_soliciutud = "Solicitudes en Gerencia";
        $cantidad = $estado_solicitud['cantidad'];
      }
      if ($estado_solicitud['estado_solicitud'] == 4) {
        $palabra_soliciutud = "Solicitudes Aprobadas Gerencia";
        $cantidad = $estado_solicitud['cantidad'];
      }
    ?>
      <div class="card">
        <div class="card-header">
          <div>
            <div class="card-title"><?= $palabra_soliciutud; ?></div>
            <div class="card-value"><?= $cantidad; ?></div>
          </div>
          <div class="card-icon">
            <?php if ($estado_solicitud['estado_solicitud'] == 1) { ?>
              <i class="fa-solid fa-thumbs-up"></i>
            <?php } elseif ($estado_solicitud['estado_solicitud'] == 2) { ?>
              <i class="fa-solid fa-clock"></i>
            <?php } elseif ($estado_solicitud['estado_solicitud'] == 3) { ?>
              <i class="fa-solid fa-users"></i>
            <?php } ?>
            <?php if ($estado_solicitud['estado_solicitud'] == 4) { ?>
              <i class="fa-solid fa-pager"></i>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>


  </div>

  <!-- Recent Activity -->
  <?php
  // Paso 1: Inicializar todos los tipos con cantidad 0
  $actividades = [
    'solicitudes' => ['titulo' => 'Nueva solicitud ingresada', 'icono' => 'fa-file-circle-plus', 'rangos' => []],
    'aprobaciones' => ['titulo' => 'Solicitud aprobada', 'icono' => 'fa-thumbs-up', 'rangos' => []],
    'gerencia' => ['titulo' => 'Solicitud enviada a gerencia', 'icono' => 'fa-arrow-trend-up', 'rangos' => []],
  ];


  // Paso 2: Rellenar con los datos reales
  while ($row = $result->fetch_assoc()) {
    $tipo = $row['tipo'];
    $rango = $row['rango'];
    $cantidad = (int) $row['cantidad'];

    if (isset($actividades[$tipo])) {
      $actividades[$tipo]['rangos'][$rango] = $cantidad;
    }
  }
  ?>

  <div class="recent-activity">
    <h3 class="section-title">Informacion Solicitudes</h3>
    <ul class="activity-list">
      <?php foreach ($actividades as $tipo => $info): ?>
        <li class="activity-item">
          <div class="activity-icon">
            <i class="fa-solid <?= $info['icono'] ?>"></i>
          </div>
          <div class="activity-content">
            <div class="activity-title"><?= $info['titulo'] ?></div>
            <?php if (!empty($info['rangos'])): ?>
              <?php foreach ($info['rangos'] as $rango => $cantidad): ?>
                <div class="activity-time">Hace <?= $rango ?> — <?= $cantidad ?> solicitud(es)</div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="activity-time">Sin datos recientes</div>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</div>