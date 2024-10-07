<?php
//require_once 'ruth_esmeralda_sanchez_herrera.p12';
//if (isset($_POST['submit'])) {
class generar_nota_factura {
	public function generate_pdf($clave_acc_guardar) {
		include "../../../../coneccion.php";


 	$iduser= $_SESSION['id'];
$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
WHERE id_emisor= '$iduser'");
$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
  $celular_receptor_uwu        = $data__emmisor['celular_receptor'];
  $direccion_receptor_uwu      = $data__emmisor['direccion_reeptor'];
  $email_receptor          = $data__emmisor['email_reeptor'];
  $codigo_formas_pago          = $data__emmisor['formas_pago'];
  $nombre_producto             = $data__emmisor['nombre_producto'];
	$nombres_receptor             = $data__emmisor['nombres_receptor'];

  if ($codigo_formas_pago == 01) {
    $nombre_formas_pago = 'SIN UTILIZACION DEL SISTEMA FINANCIERO';
  }

  if ($codigo_formas_pago == 15) {
    $nombre_formas_pago = 'COMPESACION DE DE DEUDAS';
  }

  if ($codigo_formas_pago == 16) {
    $nombre_formas_pago = 'TARJETA DE DEBITO';
  }

  if ($codigo_formas_pago == 17) {
    $nombre_formas_pago = 'DINERO ELECTRONICO';
  }

  if ($codigo_formas_pago == 18) {
    $nombre_formas_pago = 'TARJETA PREPAGO';
  }

  if ($codigo_formas_pago == 19) {
    $nombre_formas_pago = 'TARJETA DE CREDITO';
  }

  if ($codigo_formas_pago == 20) {
    $nombre_formas_pago = 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO';
  }

  if ($codigo_formas_pago == 21) {
    $nombre_formas_pago = 'ENDOSO DE TITULOS';
  }



$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_documentos = mysqli_fetch_array($query_doccumentos);
$regimen = $result_documentos['regimen'];
$contabilidad             = $result_documentos['contabilidad'];
$email_empresa_emisor     = $result_documentos['email'];
$celular_empresa_emisor   = $result_documentos['celular'];
$telefono_empresa_emisor  = $result_documentos['telefono'];
$direccion_emisor          = $result_documentos['direccion'];
$whatsapp                 = $result_documentos['whatsapp'];
$nombres                  = $result_documentos['nombres'];
$apellidos                = $result_documentos['apellidos'];
$numero_identificacion_emisor  = $result_documentos['numero_identidad'];
$contribuyente_especial   = $result_documentos['contribuyente_especial'];
$estableciminento_f      = $result_documentos['estableciminento_f'];
$contabilidad            = $result_documentos['contabilidad'];
$punto_emision_f         = $result_documentos['punto_emision_f'];
$img_facturacion         = $result_documentos['img_facturacion'];

$estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
$punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);

$nombre_empresa      = $result_documentos['nombre_empresa'];
if ($nombre_empresa == '' || $nombre_empresa== '0') {
  $nombre_empresa = ''.$nombres.' '.$apellidos.'';
  // code...
}else {
  $nombre_empresa      = $result_documentos['nombre_empresa'];
}

//fechas
$fecha_actual = date("d-m-Y");
$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

$fecha_actual = date("d-m-Y h:m:s");
$fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));


$query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(((comprobantes.cantidad_producto))) AS 'productos_totales'
FROM `comprobantes`
WHERE comprobantes.id_emisor = '$iduser'");
$data_lista_t=mysqli_fetch_array($query_lista_t);
$precio_12_iva = round(($data_lista_t['iva_general']),2);
$precio_88_iva = round(($data_lista_t['compra_total']),2);
$precio_total  = round( $precio_12_iva+$precio_88_iva,2);
$productos_totales = $data_lista_t['productos_totales'];


//INFORMACION COMERCIAL DE LOS PUNTOS DE EMISON
$query_secuencial = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = $iduser ORDER BY fecha DESC LIMIT 1");
$result_secuencial = mysqli_fetch_array($query_secuencial);

if ($result_secuencial) {
  $secuencial = $result_secuencial['codigo_factura'];
  $secuencial = $secuencial +1;
  // code...
}else {
  $secuencial =1;
}
$numeroConCeros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
$secuencial_neto = $numeroConCeros;


			require('clasepdf.php');
					$pdf = new TICKET('P','mm',array(76,297));
					$pdf->AddPage();
					$pdf->SetFont('Arial', '', 12);
					$pdf->SetAutoPageBreak(true,1);
					$pdf->setXY(2,1.5);
					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);

					$pdf->setXY(2,10);
					$pdf->SetFont('Arial', '', 6.9);
					$pdf->MultiCell(73, 4.2, utf8_decode(''.$direccion_emisor.''), 0,'C',0 ,1);
					$get_YD = $pdf->GetY();
					$pdf->setXY(2,6);
					$pdf->SetFont('Arial', '', 8);
					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);
					$pdf->setXY(2,$get_YD);
					$pdf->MultiCell(73, 4.2, 'RUC : '.$numero_identificacion_emisor.'', 0,'C',0 ,1);
					$pdf->setXY(2,$get_YD + 4);
			    $pdf->MultiCell(73, 4.2, 'Telefono :'.$celular_empresa_emisor.' ', 0,'C',0 ,1);
			    $pdf->setXY(2,$get_YD + 8);
			    $pdf->MultiCell(73, 4.2, 'Serie : '.$punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial.'', 0,'C',0 ,1);
			    $get_YH = $pdf->GetY();

					$pdf->SetFont('Arial', '', 9.2);
					$pdf->Text(2, $get_YH + 2 , '------------------------------------------------------------------');
					$pdf->SetFont('Arial', 'B', 8.5);
					$pdf->Text(3.8, $get_YH  + 5, 'Factura : '.$secuencial.'');
					$pdf->Text(55, $get_YH + 5, 'Caja No.: 1');
					$pdf->Text(4, $get_YH + 10, 'Fecha : '.$fecha_emision.'');
					$pdf->Text(4, $get_YH + 15, 'Cliente : '.$nombres_receptor.'');
					$pdf->Text(4, $get_YH + 20, 'No. Ticket :'.$secuencial.' ');
					$pdf->Text(38, $get_YH  + 20, 'Cajero : '.substr(1, 0,5));
					$pdf->SetFont('Arial', '', 9.2);
					$pdf->Text(2, $get_YH + 23, '------------------------------------------------------------------');
					$pdf->SetXY(2,$get_YH + 24);

					$pdf->SetFillColor(255,255,255);
					$pdf->SetFont('Arial','B',8.5);
					$pdf->Cell(13,4,'Cantid',0,0,'L',1);
					$pdf->Cell(28,4,'Descripcion',0,0,'L',1);
					$pdf->Cell(16,4,'Precio',0,0,'L',1);
					$pdf->Cell(12,4,'Total',0,0,'L',1);
					$pdf->SetFont('Arial','',8.5);
					$pdf->Text(2, $get_YH + 29, '-----------------------------------------------------------------------');
			$pdf->Ln(6);
			$item = 0;
			$query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
				WHERE id_emisor= '$iduser'");
		 while ($resultados = mysqli_fetch_array($query_resultados)) {
			 $item = $item + 1;
				$pdf->setX(1.1);
				$pdf->Cell(13,4,$resultados['cantidad_producto'],0,0,'L');
				$pdf->Cell(28,4,$resultados['descripcion_producto'],0,0,'L',1);
				$pdf->Cell(16,4,'$'.round($resultados['valor_unidad'],3),0,0,'L',1);
				$pdf->Cell(8,4,'$'.round($resultados['precio_neto'],3),0,0,'L',1);
				$pdf->Ln(4.5);
				$get_Y = $pdf->GetY();

			}

			$pdf->Text(2, $get_Y+1, '-----------------------------------------------------------------------');


			$pdf->SetFont('Arial','B',8.5);
			$pdf->Text(4,$get_Y + 5,'G = GRAVADO');
			$pdf->Text(30,$get_Y + 5,'E = EXENTO');
			$pdf->Text(4,$get_Y + 10,'SUBTOTAL :');
			$pdf->Text(57,$get_Y + 10,'$'.round($precio_88_iva,3));
			$pdf->Text(4,$get_Y + 15,'EXENTO :');
			$pdf->Text(57,$get_Y + 15,'$0.00');
			$pdf->Text(4,$get_Y + 20,'IVA 12% :');
			$pdf->Text(57,$get_Y + 20,'$'.round($precio_12_iva,3));
			$pdf->Text(4,$get_Y + 25,'DESCUENTO :');
			$pdf->Text(56,$get_Y + 25,'$0.00');
			$pdf->Text(4,$get_Y + 30,'TOTAL A PAGAR :');
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Text(57,$get_Y + 30,'$'.round($precio_total,3));
			$pdf->Text(2, $get_Y+33, '-----------------------------------------------------------------------');
			$pdf->Text(4,$get_Y + 36,'Numero de Productos :');
			$pdf->Text(57,$get_Y + 36,'#'.round($productos_totales,3).'');
			$pdf->Text(24,$get_Y + 40,'Efectivo :');
			$pdf->Text(57,$get_Y + 40,'$0.00');
			$pdf->Text(24,$get_Y + 44,'Cambio :');
			$pdf->Text(57,$get_Y + 44,'$0.00');
			$pdf->Text(2, $get_Y+47, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','BI',8.5);
			$pdf->Output('../comprobantes/nota_venta/'.$clave_acc_guardar.'.pdf','F');



	}
}

?>
