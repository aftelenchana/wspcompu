<?php
include ('../lib/FPDF/fpdf.php');
include ('../lib/codigo_barras/barcode.inc.php');


class pdf extends FPDF{

	public function pdfFactura($correo,$clave_acc_guardar,$nombre_empresa,$img_logo,$direccion_emisor,$numero_identidad_emisor,$estableciminento_f,$punto_emision_f,$fecha_emision,$nombres_receptor,$numero_cedula_receptor,$precio_88_iva,$precio_12_iva,$porcentaje_iva_f,$precio_total,$direccion_receptor,$celular_receptor,$email_receptor,$email_emisor,$secuencial,$numeroConCeros,$iduser,$formas_pago,$regimen,$contabilidad,$descuento){

		include "../../../../coneccion.php";

		$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
		WHERE id_emisor= '$iduser'");
		$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
			$celular_receptor_uwu          = $data__emmisor['celular_receptor'];
			$direccion_receptor_uwu          = $data__emmisor['direccion_reeptor'];
			$email_receptor_uwu          = $data__emmisor['email_reeptor'];
			$codigo_formas_pago          = $data__emmisor['formas_pago'];
			$nombre_producto          = $data__emmisor['nombre_producto'];


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
		$contabilidad          = $result_documentos['contabilidad'];
		$email_empresa_uwu          = $result_documentos['email'];
		$img_logo2          = $result_documentos['img_facturacion'];



    														$pdf = new FPDF();
    														$pdf->SetCreator($nombre_empresa);
    														$pdf->SetAuthor($nombre_empresa);
    														$pdf->SetTitle('Factura');
    														$pdf->SetSubject('PDF');
    														$pdf->SetKeywords('FPDF, PDF, cheque, impresion, guia');
    														$pdf->SetMargins('10', '10', '10');
    														$pdf->SetAutoPageBreak(TRUE);
    														$pdf->SetFont('Arial', '', 7);
    														$pdf->AddPage();
    														$pdf->Image('../../../img/uploads/'.$img_logo2.'',35,15,34);
    														$pdf->SetXY(107, 10);
    														$pdf->Cell(93, 84, '', 1, 1);
    														$pdf->SetXY(10, 54);
    														$pdf->Cell(93, 40, '', 1, 1);
    														$pdf->SetXY(10, 98);
    														$pdf->Cell(190, 12, '', 1, 1);
    														$pdf->SetXY(10, 114);
    														$pdf->Cell(190, 173, '', 0, 1);
    														$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(10, 54);$pdf->Cell(93, 10, utf8_decode($nombre_empresa), 0 , 1, 'C');
    														$pdf->SetFont('Arial', '', 6);$pdf->SetXY(10, 59);$pdf->Cell(93, 10, 'ECUADOR', 0 , 1, 'L');
    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, 68);$pdf->MultiCell(15, 4, utf8_decode('Dirección'), 0 , 'C');
    														$pdf->SetFont('Arial', '', 6);$pdf->SetXY(25, 68);$pdf->MultiCell(78, 4, ''.$direccion_emisor.'', 0 , 'L');
																$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, 73);$pdf->MultiCell(15, 4, 'Ambiente: ', 0 , 'C');
																$pdf->SetFont('Arial', '', 6);$pdf->SetXY(25, 73);$pdf->MultiCell(78, 4, utf8_decode('Producción'), 0 , 'L');
																$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, 78);$pdf->MultiCell(50, 4, 'OBLIGADO A LLEVAR CONTABILIDAD: ', 0 , 'C');
																$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(65, 78);$pdf->MultiCell(78, 4, ''.$contabilidad.'', 0 , 'L');
																$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, 83);$pdf->MultiCell(50, 4, 'REGIMEN ', 0 , 'L');
																$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(65, 83);$pdf->MultiCell(78, 4, ''.$regimen.'', 0 , 'L');
    														$pdf->SetFont('Arial', 'B', 9);$pdf->SetXY(107, 10);$pdf->Cell(40, 8, 'RUC: '.$numero_identidad_emisor.'', 0 , 1);
    														$pdf->SetFont('Arial', '', 9);$pdf->SetXY(107, 18);$pdf->Cell(93, 8, 'FACTURA', 0 , 1);

    														$pdf->SetFont('Arial', '', 9);$pdf->SetXY(107, 26);$pdf->Cell(40, 8, 'No: '.$estableciminento_f.'-'.$punto_emision_f.'-'.$numeroConCeros.'', 0 , 1);
    														$pdf->SetFont('Arial', '', 9);$pdf->SetXY(107, 32);$pdf->Cell(40, 10, 'FECHA AUTORIZACION: '.$fecha_emision.'', 0 , 1);

    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(107, 42);$pdf->Cell(93, 8, utf8_decode('Número de Autorización'), 0 , 1, 'C');
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(107, 50);$pdf->Cell(93, 10, ''.$clave_acc_guardar.'', 0 , 1, 'C');
    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(107, 66);$pdf->Cell(93, 4, 'Clave Acceso', 0 , 1, 'C');
    														new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);
    														$pdf->Image('barra.gif', 108, 70, 90, 20);
    														$pdf->SetFont('Arial', 'B', 7);
																$pdf->SetXY(107, 80);
    														$pdf->Cell(93, 24, ''.$clave_acc_guardar.'', 0 , 1, 'C');
																$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(10, 98);$pdf->Cell(30, 3, 'RAZON SOCIAL', 0 , 1, 'C');
    														$pdf->SetXY(10, 101);$pdf->Cell(30, 3, 'NOMBRES Y APELLIDOS', 0 , 0, 'C');
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(40, 98);$pdf->MultiCell(160, 3, utf8_decode($nombres_receptor),0,'L');
    														$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(10, 104);$pdf->Cell(30, 6, utf8_decode('Fecha Emisión'), 0 , 1, 'C');
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(40, 104);$pdf->Cell(100, 6, ''.$fecha_emision.'', 0 , 1);
    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(140, 104);$pdf->Cell(30, 6, utf8_decode('Identificación'), 0 , 1);
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(170, 104);$pdf->Cell(30, 6, ''.$numero_cedula_receptor.'', 0 , 1);
    														$pdf->SetFont('Arial', 'B', 7);
															$pdf->SetXY(10, 114);$pdf->Cell(13, 6, false, 1 , 1);
    														$pdf->SetXY(10, 114);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
    														$pdf->SetXY(10, 117);$pdf->Cell(13, 3, 'Principal', 0 , 1, 'C');
    														$pdf->SetXY(23, 114);$pdf->Cell(13, 6, false, 1 , 1);
    														$pdf->SetXY(23, 114);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
    														$pdf->SetXY(23, 117);$pdf->Cell(13, 3, 'Auxiliar', 0 , 1, 'C');
    														$pdf->SetXY(36, 114);$pdf->Cell(13, 6, 'Cant', 1 , 1, 'C');
    														$pdf->SetXY(49, 114);$pdf->Cell(110, 6, 'DESCRIPCION', 1 , 1, 'C');
    														$pdf->SetXY(159, 114);$pdf->Cell(13, 6, false, 1 , 1);
    														$pdf->SetXY(159, 114);$pdf->Cell(13, 3, 'Precio', 0 , 1, 'C');
    														$pdf->SetXY(159, 117);$pdf->Cell(13, 3, 'Unitario', 0 , 1, 'C');
    														$pdf->SetXY(172, 114);$pdf->Cell(15, 6, 'Descuento', 1 , 1, 'C');
    														$pdf->SetXY(187, 114);$pdf->Cell(13, 6, false, 1 , 1);
    														$pdf->SetXY(187, 114);$pdf->Cell(13, 3, 'Precio', 0 , 1, 'C');
    														$pdf->SetXY(187, 117);$pdf->Cell(13, 3, 'Total', 0 , 1, 'C');


																			   $facto =  110;												//CABECERA KARDEX TOTALES


																				 $query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
																				   WHERE id_emisor= '$iduser'");
																		    while ($resultados = mysqli_fetch_array($query_resultados)) {
																				  $contador_caracteres  =	strlen($resultados['descripcion_producto']);
																					if ($contador_caracteres <=  120) {
																						$columna = 10;
																						$rdt = 10;
																					}
																					if ($contador_caracteres >= 120) {
																						$columna = 20;
																						$rdt = 22;
																					}

																					$facto = $facto +10;
																					$ejey = $facto;
																					$pdf->SetXY(10, $ejey);$pdf->Cell(13, 10, 'GBS', 1 , 1, 'C');
																					$pdf->SetXY(23, $ejey);$pdf->Cell(13, 10, '', 1 , 1, 'C');
																					$pdf->SetXY(36, $ejey);$pdf->Cell(13, 10, ''.$resultados['cantidad_producto'].'', 1 , 1, 'C');$pdf->SetFont('Arial', 'B', 5);
																					$pdf->SetXY(49, $ejey);$pdf->Cell(110, 10, '', 1 , 0);
																					$pdf->SetXY(49, $ejey);$pdf->MultiCell(110, 5,''.$resultados['descripcion_producto'].'','L');$pdf->SetFont('Arial', 'B', 7);
																					$pdf->SetXY(159, $ejey);$pdf->Cell(13, 10, '$'.number_format($resultados['valor_unidad'],2).'', 1 , 1, 'C');
																					$pdf->SetXY(172, $ejey);$pdf->Cell(15, 10,'$'.number_format($resultados['descuento'],2).'', 1 , 1, 'C');
																					$pdf->SetXY(187, $ejey);$pdf->Cell(13, 10,  '$'.number_format(($resultados['precio_p_incluido_iva']-$resultados['descuento']),2).'', 1 , 1, 'C');
																					$ejey += $rdt;
																					$ejey += 5;
																		    }
    														//KARDEX TOTALES
    														$pdf->SetFont('Arial', 'B', 7);
    														$pdf->SetXY(120, $ejey);$pdf->Cell(50, 4, 'SUBTOTAL', 1 , 1, 'L');
    														$pdf->SetXY(120, $ejey+4);$pdf->Cell(50, 4, 'IVA 0%', 1 , 1, 'L');
    														$pdf->SetXY(120, $ejey+8);$pdf->Cell(50, 4, 'IVA '.$porcentaje_iva_f.'%', 1 , 1, 'L');
    														$pdf->SetXY(120, $ejey+12);$pdf->Cell(50, 4, 'DESCUENTO', 1 , 1, 'L');
    														$pdf->SetXY(120, $ejey+16);$pdf->Cell(50, 4, 'VALOR TOTAL', 1 , 1, 'L');
    														$pdf->SetXY(170, $ejey);$pdf->Cell(30, 4, '$'.number_format($precio_88_iva,2).'', 1 , 1, 'R');//SUBTOTAL
    														$pdf->SetXY(170, $ejey+4);$pdf->Cell(30, 4, '$0.00', 1 , 1, 'R');//IVA 0
    														$pdf->SetXY(170, $ejey+8);$pdf->Cell(30, 4, '$'.number_format($precio_12_iva,2).'', 1 , 1, 'R');//VALOR IVA
    														$pdf->SetXY(170, $ejey+12);$pdf->Cell(30, 4, '$'.number_format($descuento,2).'', 1 , 1, 'R');//VALOR DESCUENTO
    														$pdf->SetXY(170, $ejey+16);$pdf->Cell(30, 4, '$'.number_format($precio_total,2).'', 1 , 1, 'R');//VALOR CON IVA
    														//INFO ADICIONAL
    														$pdf->SetFont('Arial', 'B', 8);
    														$pdf->SetXY(10, $ejey);$pdf->Cell(105, 6, 'INFORMACION ADICIONAL', 1 , 1, 'C');
    														$pdf->SetFont('Arial', '', 7);
    														$pdf->SetXY(10, $ejey+6);$pdf->Cell(20, 6, 'Email empresa:', 'L' , 1, 'L');
    														$pdf->SetXY(10, $ejey+12);$pdf->Cell(20, 6, 'Email cliente:', 'L' , 1, 'L');
    														$pdf->SetXY(10, $ejey+18);$pdf->Cell(20, 6, 'Telefono cliente:', 'L' , 1, 'L');
    														$pdf->SetXY(30, $ejey+6);$pdf->Cell(85, 6, ''.$email_empresa_uwu.'', 'R' , 1, 'L');
    														$pdf->SetXY(30, $ejey+12);$pdf->Cell(85, 6, ''.$email_receptor.'', 'R' , 1, 'L');
																$pdf->SetXY(30, $ejey+18);$pdf->Cell(85, 6, ''.$celular_receptor.'', 'R' , 1, 'L');
																$pdf->SetXY(10, $ejey+24);$pdf->MultiCell(105, 10, 'Direccion cliente: '.utf8_decode($direccion_receptor).'', 'LRB', 'L');
    														//FORMA DE PAGO

    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, $ejey+39);$pdf->Cell(75, 6, 'Forma de pago', 1 , 1, 'C');
    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(85, $ejey+39);$pdf->Cell(30, 6, 'Valor', 1 , 1, 'C');
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(10, $ejey+45);$pdf->Cell(75, 6, ''.$nombre_formas_pago.'', 'LRB' , 1, 'L');
    														$pdf->SetFont('Arial', '', 7);$pdf->SetXY(85, $ejey+45);$pdf->Cell(30, 6, '$'.number_format($precio_total,2).'', 'RB' , 1, 'L');
    																//SAVE
    														$pdf->Output('../comprobantes/pdf/'.$clave_acc_guardar.'.pdf','F');




	}
}
/*$pdf = new pdf();
$pdf->pdfFacTura('555');*/
?>
