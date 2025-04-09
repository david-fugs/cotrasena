<?php
    
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];
    header("Content-Type: text/html;charset=utf-8");

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Using Select2 from a CDN-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $cod_pro  = $_GET['cod_pro'];
	    if(isset($_GET['cod_pro']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM productos WHERE cod_pro = '$cod_pro'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-people-roof"></i> ACTUALIZAR INFORMACIÓN DEL PRODUCTO</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='edititem1.php' method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="cod_pro">* CODIGO:</label>
                        <input type='text' name='cod_pro' class='form-control' id="cod_pro" value='<?php echo $row['cod_pro']; ?>' readonly />
                    </div>
                    <div class="col-12 col-sm-7">
                        <label for="nom_pro">DESCRIPCION:</label>
                        <input type='text' name='nom_pro' id="nom_pro" class='form-control' value='<?php echo $row['nom_pro']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="precio_prod">PRECIO $</label>
                        <input type='number' name='precio_prod' class='form-control' value='<?php echo $row['precio_prod']; ?>' />
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="catg_pro">CATEGORIA:</label>
                        <select class="form-control" name="catg_pro" required >
                            <option value=""></option>   
                            <option value="Electrónica" <?php if($row['catg_pro']=='Electrónica'){echo 'selected';} ?>>Electrónica</option>
                            <option value="Ropa" <?php if($row['catg_pro']=='Ropa'){echo 'selected';} ?>>Ropa</option>
                            <option value="Alimentos" <?php if($row['catg_pro']=='Alimentos'){echo 'selected';} ?>>Alimentos</option>
                            <option value="Juguetes" <?php if($row['catg_pro']=='Juguetes'){echo 'selected';} ?>>Juguetes</option>
                            <option value="Hogar" <?php if($row['catg_pro']=='Hogar'){echo 'selected';} ?>>Hogar</option>
                            <option value="NN" <?php if($row['catg_pro']=='NN'){echo 'selected';} ?>>NN</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="fecha_pro">FECHA</label>
                        <input type='date' name='fecha_pro' class='form-control' value='<?php echo $row['fecha_pro']; ?>' />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-warning" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR INFORMACIÓN 
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
</html>