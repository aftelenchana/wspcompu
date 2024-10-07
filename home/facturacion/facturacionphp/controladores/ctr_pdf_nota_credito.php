<?php
include ('../lib/FPDF/fpdf.php');
include ('../lib/codigo_barras/barcode.inc.php');


class pdf extends FPDF{

	public function pdfFactura($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar){

  include "../../../../coneccion.php";
	$iduser= $_SESSION['id'];
	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];

	$codigo_formas_pago= 20;

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
	$email_empresa_uwu     = $result_documentos['email'];
  $nombre_empresa        = $result_documentos['nombre_empresa'];
  $direccion_emisor      = $result_documentos['direccion'];
  $contabilidad          = $result_documentos['contabilidad'];
  $regimen               = $result_documentos['regimen'];
  $numero_identidad_emisor = $result_documentos['numero_identidad'];
  $img_logo          = $result_documentos['img_facturacion'];
  $direccion_receptor_uwu       = $result_documentos['direccion'];
    $celular_receptor_uwu        = $result_documentos['celular'];
		    $telefono_receptor_uwu        = $result_documentos['telefono'];

  $estableciminento_f      = $result_documentos['estableciminento_f'];
  $punto_emision_f         = $result_documentos['punto_emision_f'];
  $porcentaje_iva_f        = $result_documentos['porcentaje_iva_f'];

	$fecha_actual = date("d-m-Y");
$fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));

  $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
  $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
  $porcentaje_iva_f     = ($result_documentos['porcentaje_iva_f'])/100;

	$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY fecha DESC");
	$result = mysqli_fetch_array($query);
	if ($result) {
		$secuencial = $result['codigo_factura'];
		$secuencial = $secuencial+1;
		// code...
	}else {
		$secuencial =1;
	}
	     $numeroConCeros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);


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
	    														$pdf->Image('../../../img/uploads/'.$img_logo.'',35,15,34);
	    														$pdf->SetXY(107, 10);
	    														$pdf->Cell(93, 84, '', 1, 1);
	    														$pdf->SetXY(10, 54);
	    														$pdf->Cell(93, 40, '', 1, 1);
	    														$pdf->SetXY(10, 98);
	    														$pdf->Cell(190, 12, '', 1, 1);
	    														$pdf->SetXY(10, 114);
	    														$pdf->Cell(190, 173, '', 0, 1);
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10, 54);$pdf->Cell(93, 10, utf8_decode(''.$nombre_empresa.''), 0 , 1, 'C');
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(2, 64);$pdf->MultiCell(35, 4, utf8_decode('Dirección:'), 0 , 'C');
	    														$pdf->SetFont('Arial', '', 8);$pdf->SetXY(28, 64);$pdf->MultiCell(78, 4, utf8_decode(''.$direccion_emisor.''), 0 , 'L');



	          														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(9, 69);$pdf->MultiCell(15, 4, utf8_decode('Email:'), 0 , 'C');
	      															$pdf->SetFont('Arial', '', 10);$pdf->SetXY(22, 69);$pdf->MultiCell(78, 4, utf8_decode(''.$email_empresa_uwu.''), 0, 'L');
	          														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(2.5, 74);$pdf->MultiCell(35, 4, utf8_decode('Teléfonos:'), 0 , 'C');
	      															$pdf->SetFont('Arial', '', 10);$pdf->SetXY(29, 74);$pdf->MultiCell(78, 4, ''.$telefono_receptor_uwu.' - '.$celular_receptor_uwu.'', 0, 'L');
																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10.3, 79);$pdf->MultiCell(78, 4, 'Obligado a LLevar Contabilidad: ', 0 , 'L');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(65, 79);$pdf->MultiCell(78, 4, ''.$contabilidad.'', 0 , 'L');
																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10.2, 84);$pdf->MultiCell(50, 4, utf8_decode('CONTRIBUYENTE:'), 0 , 'L');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(43, 84);$pdf->MultiCell(78, 4, ''.$regimen.'', 0 , 'L');
	      															$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(4.2, 89);$pdf->MultiCell(35, 4, 'AMBIENTE: ', 0 , 'C');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(31, 89);$pdf->MultiCell(78, 4, utf8_decode('Producción'), 0 , 'L');
	                                $fecha_actual = date("d-m-Y");
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(107, 11);$pdf->Cell(40, 8, 'RUC: '.$numero_identidad_emisor.'', 0 , 1);
	    							   							$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(107, 21);$pdf->Cell(93, 8, 'FACTURA:', 0 , 1);
	    														$pdf->SetFont('Arial', '', 12);$pdf->SetXY(130, 21);$pdf->Cell(40, 8, ''.$estableciminento_f.'-'.$punto_emision_f.'-'.$numeroConCeros.'', 0 , 1);
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(107, 28);$pdf->Cell(40, 10, utf8_decode('Fecha de Autorización:'), 0 , 1);
	    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(107, 33);$pdf->Cell(40, 10, utf8_decode(''.$fecha_emision.''), 0 , 1);
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(109, 42);$pdf->Cell(40, 8, utf8_decode('Número de Autorización:'), 0 , 1, 'C');
	    														$pdf->SetFont('Arial', '', 8);$pdf->SetXY(135, 47);$pdf->Cell(40, 8, ''.$clave_acc_guardar.'', 0 , 1, 'C');
	    														$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(107, 66);$pdf->Cell(93, 4, 'CLAVE DE ACCESO', 0 , 1, 'C');
	    														new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);
	    														$pdf->Image('barra.gif', 108, 70, 90, 10);
	    														$pdf->SetFont('Arial', 'B', 7);
																	$pdf->SetXY(107, 80);
	    														$pdf->Cell(93, 5, ''.$clave_acc_guardar.'', 0 , 1, 'C');


																	//de qui empezamos a sacar la informacion
																	if ($ambito_area == 'prueba') {
																		$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

																	}else {
																		$ruta_factura = '../comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
																	}
																	$acceso_factura = simplexml_load_file($ruta_factura);
																	$codDocModificado                = $acceso_factura->infoTributaria->codDoc;

																	 //para crear el numero dl documento necesito de 4 partes
																		$estab                       = $acceso_factura->infoTributaria->estab;
																		$ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
																		$secuencial                  = $acceso_factura->infoTributaria->secuencial;
																	$numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';

																	//informacion del comprador



																		$identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
																		$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
																		$razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
																		$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
																		$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
																		$totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
																		$totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
																		$totalDescuento                = $acceso_factura->infoFactura->totalDescuento;




																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(8, 100);$pdf->Cell(30, 3, utf8_decode ('Razón Social:'), 0 , 1, 'C');
	    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(35, 100);$pdf->MultiCell(160, 3, utf8_decode(''.$razon_social_comprador .''),0,'L');

																$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10.5, 104);$pdf->Cell(30, 6, utf8_decode('Dirección:'), 0 , 1);
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(29, 104);$pdf->Cell(30, 6, 'NN', 0 , 1);
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(134, 98);$pdf->Cell(30, 6, utf8_decode('Fecha de Emisión:'), 0 , 1, 'C');

																	$fecha_actual = date("d-m-Y");
																	$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

	    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(165, 98);$pdf->Cell(100, 6, ''.$fecha.'', 0 , 1);
	    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(158.5, 104);$pdf->Cell(30, 6, utf8_decode('RUC/CI:'), 0 , 1);
	    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(172, 104);$pdf->Cell(30, 6, ''.$identificacion_comprador .'', 0 , 1);
	    														$pdf->SetFont('Arial', 'B', 7);


																		$detcre= 14;
																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(23, 98+$detcre);$pdf->Cell(30, 3, utf8_decode ('Comprobante que se modifica: '), 0 , 1, 'C');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(65, 98+$detcre);$pdf->MultiCell(160, 3, $numDocModificado ,0,'L');

																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(35, 103+$detcre);$pdf->Cell(30, 3, utf8_decode ('Fecha emisión comprobante que se modifica: '), 0 , 1, 'C');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(89, 103+$detcre);$pdf->MultiCell(160, 3, $fechaEmision ,0,'L');

																	$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(16, 108+$detcre);$pdf->Cell(30, 3, utf8_decode ('Razón de modificación:'), 0 , 1, 'C');
																	$pdf->SetFont('Arial', '', 10);$pdf->SetXY(53, 108+$detcre);$pdf->MultiCell(160, 3, $razon_modficiacion ,0,'L');





																              	$pdf->SetXY(10, 114+$detcre);$pdf->Cell(13, 6, false, 1 , 1);
								    														$pdf->SetXY(10, 114+$detcre);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
								    														$pdf->SetXY(10, 117+$detcre);$pdf->Cell(13, 3, 'Principal', 0 , 1, 'C');
								    														$pdf->SetXY(23, 114+$detcre);$pdf->Cell(13, 6, false, 1 , 1);
								    														$pdf->SetXY(23, 114+$detcre);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
								    														$pdf->SetXY(23, 117+$detcre);$pdf->Cell(13, 3, 'Sec.', 0 , 1, 'C');
								    														$pdf->SetXY(36, 114+$detcre);$pdf->Cell(13, 6, 'Cant', 1 , 1, 'C');
								    														$pdf->SetXY(49, 114+$detcre);$pdf->Cell(100, 6, utf8_decode('Descripción'), 1 , 1, 'C');
								    														$pdf->SetXY(149, 114+$detcre);$pdf->Cell(0, 6, false, 1 , 1);
								    														$pdf->SetXY(149, 114+$detcre);$pdf->Cell(17, 3, 'Precio', 0 , 1, 'C');
								    														$pdf->SetXY(149, 117+$detcre);$pdf->Cell(17, 3, 'Unitario', 0 , 1, 'C');
								    														$pdf->SetXY(166, 114+$detcre);$pdf->Cell(17, 6, 'Descuento', 1 , 1, 'C');
								    														$pdf->SetXY(183, 114+$detcre);$pdf->Cell(17, 6, false, 1 , 1);
								    														$pdf->SetXY(183, 114+$detcre);$pdf->Cell(17, 3, 'Precio sin', 0 , 1, 'C');
								    														$pdf->SetXY(183, 117+$detcre);$pdf->Cell(17, 3, 'Impuestos', 0 , 1, 'C');


																				   $facto =  110;												//CABECERA KARDEX TOTALES

																					$contador_detalles = $acceso_factura->detalles->detalle;
																					$base_tdll = 0;
																					$base_array_detalle = 1;
																			   	foreach($contador_detalles as $Item){
																						$descripcion_producto= $acceso_factura->detalles->detalle[$base_tdll]->descripcion;
																						$codigoPrincipal= $acceso_factura->detalles->detalle[$base_tdll]->codigoPrincipal;
																						$cantidad= $acceso_factura->detalles->detalle[$base_tdll]->cantidad;
																						$precioUnitario= $acceso_factura->detalles->detalle[$base_tdll]->precioUnitario;
																						$descuento= $acceso_factura->detalles->detalle[$base_tdll]->descuento;
																						$precioTotalSinImpuesto= $acceso_factura->detalles->detalle[$base_tdll]->precioTotalSinImpuesto;
																						 $impuestos= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto;
																						//CODIGO PARA DETALLES
																						$codigo= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigo;
																						$codigoPorcentaje= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigoPorcentaje;
																						$tarifa= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->tarifa;
																						$baseImponible= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->baseImponible;
																						$valor= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->valor;
																						 $base_tdll =$base_tdll +1;



																					  $contador_caracteres  =	strlen($descripcion_producto);
																						if ($contador_caracteres <=  140) {
																							$columna = 10;
																							$rdt = 10;
																						}

																						if ($contador_caracteres >= 140) {
																							$columna = 32;
																							$rdt = 30;
																						}
																						$facto = $facto +10;
																						$ejey = $facto+$detcre;
																						$pdf->SetXY(10, $ejey);$pdf->Cell(13, $columna,''.$codigoPrincipal.'', 1 , 1, 'C');
																						$pdf->SetXY(23, $ejey);$pdf->Cell(13, $columna, 'GBS', 1 , 1, 'C');
																						$pdf->SetXY(36, $ejey);$pdf->Cell(13, $columna, ''.$cantidad.'', 1 , 1, 'C');$pdf->SetFont('Arial', '', 8);
																						$pdf->SetXY(49, $ejey);$pdf->Cell(100, $columna, '', 1 , 0);
																						$pdf->SetXY(49, $ejey);$pdf->MultiCell(100, 5, utf8_decode(''.$descripcion_producto.''),'C');$pdf->SetFont('Arial', '', 8);
																						$pdf->SetXY(149, $ejey);$pdf->Cell(17, $columna, '$'.($precioUnitario).'', 1 , 1, 'C');
																						$pdf->SetXY(166, $ejey);$pdf->Cell(17, $columna, '$'.($descuento).'', 1 , 1, 'C');
																						$pdf->SetXY(183, $ejey);$pdf->Cell(17, $columna, '$'.($precioTotalSinImpuesto).'', 1 , 1, 'C');
																						$ejey += $rdt;
																						$ejey += 5;

																			    }

																					$rrr= ($acceso_factura->infoAdicional->campoAdicional);
																				 foreach($rrr as $Item){
																					 $atrinuto = (string)$acceso_factura->infoAdicional->campoAdicional[0];
																					 $posicion_coincidencia = strpos($atrinuto, '@');
																					 if ($posicion_coincidencia === false) {
																						 $email_receptor = 'vacio';

																					 } else {
																					 $email_receptor =$atrinuto;
																					 }
																					 }



	    														//KARDEX TOTALES

	    														$pdf->SetFont('Arial', 'B', 10);
	    														$pdf->SetXY(120, $ejey);$pdf->Cell(50, 4, 'SUBTOTAL', 1 , 1, 'L');
	    														$pdf->SetXY(120, $ejey+4);$pdf->Cell(50, 4, 'IVA 0%', 1 , 1, 'L');
	    														$pdf->SetXY(120, $ejey+8);$pdf->Cell(50, 4, 'IVA 12%', 1 , 1, 'L');
	    														$pdf->SetXY(120, $ejey+12);$pdf->Cell(50, 4, 'DESCUENTO ', 1 , 1, 'L');
	    														$pdf->SetXY(120, $ejey+16);$pdf->Cell(50, 4, 'VALOR TOTAL', 1 , 1, 'L');
	    														$pdf->SetXY(170, $ejey);$pdf->Cell(30, 4, '$'.number_format($nomnto_modificacion,2).'', 1 , 1, 'R');//SUBTOTAL
	    														$pdf->SetXY(170, $ejey+4);$pdf->Cell(30, 4, '$0.00', 1 , 1, 'R');//IVA 0
	    														$pdf->SetXY(170, $ejey+8);$pdf->Cell(30, 4, '$'.number_format($nomnto_modificacion*0.12,2).'', 1 , 1, 'R');//VALOR IVA
	    														$pdf->SetXY(170, $ejey+12);$pdf->Cell(30, 4, '$0.00', 1 , 1, 'R');//VALOR DESCUENTO
	    														$pdf->SetXY(170, $ejey+16);$pdf->Cell(30, 4, '$'.number_format($nomnto_modificacion,2).'', 1 , 1, 'R');//VALOR CON IVA


	    														//INFO ADICIONAL
	    														$pdf->SetFont('Arial', 'B', 8);
	    														$pdf->SetXY(10, $ejey);$pdf->Cell(105, 6, utf8_decode('Información Adicional'), 1 , 1, 'C');
	    														$pdf->SetFont('Arial', '', 7);
	    														$pdf->SetXY(10, $ejey+6);$pdf->Cell(20, 6, 'Email empresa:', 'L' , 1, 'L');
	    														$pdf->SetXY(10, $ejey+12);$pdf->Cell(20, 6, 'Email cliente:', 'L' , 1, 'L');
	    														$pdf->SetXY(10, $ejey+18);$pdf->Cell(20, 6, utf8_decode('Teléfono cliente:'), 'L' , 1, 'L');
	    														$pdf->SetXY(30, $ejey+6);$pdf->Cell(85, 6, ''.$email_empresa_uwu.'', 'R' , 1, 'L');

                                  $pdf->SetXY(30, $ejey+12);$pdf->Cell(85, 6, 'NN', 'R' , 1, 'L');
																	$pdf->SetXY(30, $ejey+18);$pdf->Cell(85, 6, 'NN', 'R' , 1, 'L');
																	$pdf->SetXY(10, $ejey+24);$pdf->MultiCell(105, 10,utf8_decode('Dirección cliente:NN'), 'LRB', 'L');
																	$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, $ejey+39);$pdf->Cell(75, 6, 'Forma de pago', 1 , 1, 'C');
																	$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(85, $ejey+39);$pdf->Cell(30, 6, 'Valor', 1 , 1, 'C');


																  $pdf->SetFont('Arial', '', 7);$pdf->SetXY(10, $ejey+45);$pdf->Cell(75, 6, $nombre_formas_pago, 'LRB' , 1, 'L');
																  $pdf->SetFont('Arial', '', 7);$pdf->SetXY(85, $ejey+45);$pdf->Cell(30, 6,'$'.number_format($nomnto_modificacion,2).'', 'RB' , 1, 'L');

																$pdf->Output('../comprobantes/nota-credito/pdf/'.$clave_acc_guardar.'.pdf','F');





	}
}
/*$pdf = new pdf();
$pdf->pdfFacTura('555');*/
?>
