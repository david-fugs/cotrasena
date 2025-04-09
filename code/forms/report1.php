<?php
    header("Content-Type: text/html;charset=utf-8");
    header("Content-Type:application/vnd.ms-excel; charset=utf-8");
    //header('Content-type:application/xls'; charset=utf-8");
    header('Content-Disposition: attachment; filename=informe_general_productos.xls');
    date_default_timezone_set('America/Bogota');

    include("../../conexion.php");    
   
    $query = "SELECT *
            FROM productos  
            ORDER BY cod_pro ASC";

    $result = mysqli_query($mysqli, $query);
?>

    <table border="1">
        <tr>
            <th style="background-color:#706E6E;">CODIGO PRODUCTO</th>
            <th style="background-color:#706E6E;">DESCRIPCION</th>
            <th style="background-color:#706E6E;">PRECIO</th>
            <th style="background-color:#706E6E;">CATEGORIA</th>
            <th style="background-color:#706E6E;">FECHA</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $row['cod_pro']; ?></td>
                <td style="text-align: center;"><?php echo utf8_decode($row['nom_pro']); ?></td>
                <td style="text-align: center;"><?php echo $row['precio_prod']; ?></td>
                <td style="text-align: center;"><?php echo utf8_decode($row['catg_pro']); ?></td>
                <td style="text-align: center;"><?php echo $row['fecha_pro']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>