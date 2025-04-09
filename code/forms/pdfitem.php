<?php
	
	ob_start();
	require_once('../../fpdf/fpdf.php');

	$cod_pro = $_GET['cod_pro'];

	include("../../conexion.php");
	
	// Obtiene la fecha actual 
		
	class PDF extends FPDF
	{
		
		// Se heredan todas las funciones para hacer el Encabezado de la página
		function Header()
		{
			// Logo
			$this->Image('../../img/logo.png',10,8,25,25);
			// Arial bold 15
			$this->SetFont('Arial','B',12);
			// Movernos a la derecha (espacio)
			$this->Cell(80);
			// Título (PROPIEDAD DESPUÉS DEL TITULO ES CONTORNO, SALTO DE LÍNEA, ALINEACIÓN)
			$this->Cell(80,5,'CIAF',0,1,'R');
			$this->Cell(151,4,utf8_decode('Tecnología en Desarrollo de Software'),0,1,'R');
			$this->Cell(148,10,utf8_decode('VII SEMESTRE'),0,1,'R');
			$this->Ln(5);
			$this->SetFont('Arial','',9);
			$this->Cell(200,6,utf8_decode('Versión: 01                                                                                                                        Vigencia: 01-2024'),1,0,'L');
			// Salto de línea
			$this->Ln(25);
		}
		
		// Se crea la función FOOTER "Pie de página"
		function Footer()
		{	
			$fecha = date("Y-m-d H:i:s");
			date_default_timezone_set("America/Bogota");
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','B',7);
			// Número de página
			$this->Cell(0,10,'FECHA Y HORA DE IMPRESION: '.$fecha,0,0,'C');
			$this->Ln(3);
			$this->SetFont('Arial','I',7);
			$this->Cell(0,10,'Numero total de paginas '.$this->PageNo().'/{nb}',0,0,'C');	
		}

		function VariasLineas($cadena, $cantidad)
		{
			$this->Cell(100,0,'','B');
				while (!(strlen($cadena)==''))
				{
				    $subcadena = substr($cadena, 0, $cantidad);
				    $this->Ln();
				    $this->Cell(100,5,$subcadena,'LR',0,'P');
				    $cadena= substr($cadena,$cantidad);
				}
			$this->Cell(100,0,'','T');
		}  

	}

	$consulta = "SELECT * FROM productos WHERE cod_pro='$cod_pro'";
	$res = mysqli_query($mysqli,$consulta);
	$num_reg = mysqli_num_rows($res);
	$pdf = new PDF('P','mm','Letter');
	$pdf->AliasNbPages();
	$pdf->Addpage();
	
	if ($num_reg > 0) {
		$pdf->SetAuthor('Ing. Eumir Pulido de la Pava');
		$pdf->SetCreator('Ing. Eumir Pulido de la Pava');
		$pdf->SetTitle('');
	
		$pdf->SetXY(80,45);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(200,6,utf8_decode('CÓDIGO PRODUCTO No. ' . $cod_pro),0,1,'C');
	
		$pdf->SetFillColor(232,232,232);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(6,55);
		$pdf->Cell(25,6,'FECHA',1,0,'C',1);
		$pdf->Cell(181,6,'ESTABLECIMIENTO:',1,0,'C',1);
	
		$pdf->SetXY(6,70);
		$pdf->Cell(165,6,'SEDE:',1,0,'C',1);
		$pdf->Cell(41,6,'MUNICIPIO:',1,0,'C',1);
	
		$pdf->SetXY(6,85);
		$pdf->Cell(206,6,'PROGRAMA o PROYECTO:',1,0,'C',1);
	
		$pdf->SetXY(6,105);
		$pdf->Cell(60,6,'ORDEN DE COMPRA:',1,0,'C',1);
		$pdf->Cell(85,6,'SUPERVISOR:',1,0,'C',1);
		$pdf->Cell(61,6,'CARGO:',1,0,'C',1);
	
		$pdf->SetXY(6,120);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(60,4,utf8_decode('FUENTE DE FINANCIACIÓN:'),1,0,'C',1);
		$pdf->Cell(60,4,'RP:',1,0,'C',1);
		$pdf->Cell(86,4,utf8_decode('SUPER HABIT FONDOS COMUNES'),1,0,'C',1);
	
		while($f = mysqli_fetch_array($res)) {
			$pdf->SetFont('Arial','',9);
			$pdf->SetXY(6,61);
			$pdf->Cell(25,6,$f['nom_pro'],1,0,'C');
			$pdf->SetFillColor(229, 229, 255);
			$pdf->Cell(181,6,$f['precio_prod'],1,0,'C',True);
	
			$pdf->SetXY(6,76);
			$pdf->Cell(165,6,$f['catg_pro'],1,0,'C');
			$pdf->Cell(41,6,$f['fecha_pro'],1,0,'C');
		}
	}
	
	
		// Establecer un interlineado más pequeño
		$interlineado = 3; // Puedes ajustar el valor según sea necesario

	//echo $totalCantidad;
	$pdf->Output();
?>