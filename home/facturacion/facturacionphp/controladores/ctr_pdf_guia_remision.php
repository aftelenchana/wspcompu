<?php
include ('../lib/FPDF/fpdf.php');
include ('../lib/codigo_barras/barcode.inc.php');


class pdf extends FPDF{

	public function pdfFactura($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado,$clave_acc_guardar){

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
			$whatsapp        = $result_documentos['whatsapp'];
			$contribuyente_especial        = $result_documentos['contribuyente_especial'];

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
		    														$pdf->Image('../../../img/uploads/'.$img_logo.'',35,1,34);

																		$pdf->SetXY(107, 0);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
																		//CODIGO DE LA BARRA SUPERIOR GRIS DERECHA
																		$pdf->Cell(98, 6, '', 0, 1,'L', 'true');
																		$pdf->SetFont('Arial', 'B', 9);$pdf->SetXY(100, 3);$pdf->Cell(93, 3, '', 0 , 1, 'C');




																		$pdf->SetXY(80, 5);
																		$pdf->Cell(80, 5, '', 0, 1);
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(78, 5);$pdf->Cell(93, 10, utf8_decode('GUIA DE REMISIÓN: '), 0 , 1, 'C');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(115, 5);$pdf->Cell(93, 10, utf8_decode('No '.$estableciminento_f.'-'.$punto_emision_f.'-'.$numeroConCeros.''), 0 , 1, 'C');


	                               	//codigo de la parte superior DERECHA donde sta el codigo de barras
		    														$pdf->SetXY(107, 15);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
		    														$pdf->Cell(98, 80, '', 0, 1,'L', 'true');


                                        //CODIGO BAJO DEL LOGOTIPO
		    														$pdf->SetXY(7, 35);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
		    														$pdf->Cell(96, 65, '', 0, 1,'L', 'true');


		    														$pdf->Cell(190, 173, '', 0, 1);
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(2, 38);$pdf->MultiCell(35, 4, utf8_decode('Emisor:'), 0 , 'C');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(26, 38);$pdf->MultiCell(78, 4, utf8_decode(''.$nombre_empresa.''), 0 , 'L');
		    														$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(1, 44);$pdf->MultiCell(35, 4, utf8_decode('Matriz:'), 0 , 'C');
		    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(26, 44);$pdf->MultiCell(78, 4, utf8_decode(''.$direccion_emisor.''), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(0, 52.3);$pdf->MultiCell(35, 4, utf8_decode('RUC:'), 0 , 'C');
		    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(26, 52);$pdf->MultiCell(78, 4, utf8_decode(''.$numero_identidad_emisor.''), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(1.7, 58);$pdf->MultiCell(35, 4, utf8_decode('Correo:'), 0 , 'C');
		    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(26, 58);$pdf->MultiCell(78, 4, utf8_decode(''.$email_empresa_uwu.''), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(4, 64);$pdf->MultiCell(35, 4, utf8_decode('Telefonos:'), 0 , 'C');
		    														$pdf->SetFont('Arial', '', 10);$pdf->SetXY(33, 64);$pdf->MultiCell(78, 4, utf8_decode(''.$celular_receptor_uwu.''), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(3.6, 70);$pdf->MultiCell(70, 4, utf8_decode('Obligado a llevar contabilidad:'), 0 , 'C');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(66, 70);$pdf->MultiCell(78, 4, utf8_decode(''.$contabilidad.''), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10.7, 76);$pdf->MultiCell(35, 4, utf8_decode('CONTRIBUYENTE'), 0 , 'C');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(44, 76);$pdf->MultiCell(78, 4, utf8_decode(''.$regimen.''), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(7, 82);$pdf->MultiCell(60, 4, utf8_decode('CONTRIBUYENTE ESPECIAL'), 0 , 'C');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(65, 82);$pdf->MultiCell(78, 4, utf8_decode(''.$contribuyente_especial.''), 0 , 'L');
																		if ($contribuyente_especial == 'SI') {
																			$pdf->SetXY(10, 87);
																			$pdf->SetTextColor(0,0,0);
																			$pdf->SetFillColor(  227, 227, 227 );
																			//codigo de la parte superior DERECHA
																			$pdf->Cell(90, 12, '', 0, 1,'L', 'true');
																			$pdf->SetFont('Arial', '', 11);$pdf->SetXY(11, 87);$pdf->MultiCell(78, 4, utf8_decode('RESOLUCION:No. NAC-GTRRIOC21-00000203-E.'), 0 , 'L');
																		}


		                                $fecha_actual = date("d-m-Y");
		    							   						$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(107, 15);$pdf->Cell(93, 8, utf8_decode('Número de Autorización:'), 0 , 1);
		    														$pdf->SetFont('Arial', '', 8);$pdf->SetXY(107, 19);$pdf->Cell(40, 8, $clave_acc_guardar, 0 , 1);
		    														$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(107, 28);$pdf->Cell(40, 10, utf8_decode('Fecha de Autorización:'), 0 , 1);
		    														$pdf->SetFont('Arial', '', 8);$pdf->SetXY(107, 33);$pdf->Cell(40, 10, utf8_decode(''.$fecha_emision.''), 0 , 1);
		    														$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(98, 42);$pdf->Cell(40, 8, utf8_decode('Ambiente:'), 0 , 1, 'C');
		    														$pdf->SetFont('Arial', '', 12);$pdf->SetXY(123, 42);$pdf->Cell(40, 8, utf8_decode('PRODUCCIÓN'), 0 , 1, 'C');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(96.6, 48);$pdf->Cell(40, 8, utf8_decode('Emisión:'), 0 , 1, 'C');
																		$pdf->SetFont('Arial', '', 12);$pdf->SetXY(115, 48);$pdf->Cell(40, 8, utf8_decode('NORMAL'), 0 , 1, 'C');
		    														$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(107.9, 59);$pdf->Cell(40, 4, 'CLAVE DE ACCESO', 0 , 1, 'C');
		    														new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);
		    														$pdf->Image('barra.gif', 109, 70, 95, 20);
		    														$pdf->SetFont('Arial', 'B', 7);
																		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(133, 90);$pdf->Cell(40, 4, $clave_acc_guardar, 0 , 1, 'C');


																		$pdf->SetXY(7, 99);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
																		$pdf->Cell(198, 32, '', 0, 1,'L', 'true');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 106);$pdf->MultiCell(78, 4, utf8_decode('Transportista:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(40, 106);$pdf->MultiCell(78, 4, utf8_decode($razon_social_transportista), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 106);$pdf->MultiCell(78, 4, utf8_decode('Ruc/Cl:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(155, 106);$pdf->MultiCell(78, 4, utf8_decode($ruc_transportista), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 112);$pdf->MultiCell(78, 4, utf8_decode('Dirección Partida:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(47, 112);$pdf->MultiCell(78, 4, utf8_decode($direccion_partida), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(139, 112);$pdf->MultiCell(78, 4, utf8_decode('Teléfono:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(159, 112);$pdf->MultiCell(78, 4, utf8_decode('000000000'), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 118);$pdf->MultiCell(78, 4, utf8_decode('Fecha Inicio:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(37, 118);$pdf->MultiCell(78, 4, utf8_decode($fecha_inicio_transporte), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(58, 118);$pdf->MultiCell(78, 4, utf8_decode('Fecha Final:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(83, 118);$pdf->MultiCell(78, 4, utf8_decode($fecha_final_transporte), 0 , 'L');


																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 118);$pdf->MultiCell(78, 4, utf8_decode('Placa:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(154, 118);$pdf->MultiCell(78, 4, utf8_decode($placa_transportista), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 124);$pdf->MultiCell(78, 4, utf8_decode('Fecha Emisión:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(42, 124);$pdf->MultiCell(78, 4, utf8_decode($fecha_emision), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 124);$pdf->MultiCell(78, 4, utf8_decode('Correo:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(156, 124);$pdf->MultiCell(78, 4, utf8_decode('soporte@gmail.com'), 0 , 'L');


																  	//informacion del comprador

																	  	$identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
																	  	$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
																	  	$razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
																	  	$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
																	  	$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
																	  	$totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
																	  	$totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
																	  		$totalDescuento                = $acceso_factura->infoFactura->totalDescuento;


																		$pdf->SetXY(7, 135);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
																		$pdf->Cell(198, 44, '', 0, 1,'L', 'true');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 138);$pdf->MultiCell(78, 4, utf8_decode('Destinatario:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(37, 138);$pdf->MultiCell(78, 4, utf8_decode($razon_social_comprador), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 138);$pdf->MultiCell(78, 4, utf8_decode('Ruc/Cl:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(155, 138);$pdf->MultiCell(78, 4, utf8_decode($identificacion_comprador), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 144);$pdf->MultiCell(78, 4, utf8_decode('Dirección:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(32, 144);$pdf->MultiCell(78, 4, utf8_decode($direccion_llegada), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 144);$pdf->MultiCell(78, 4, utf8_decode('Motivo:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(155, 144);$pdf->MultiCell(78, 4, utf8_decode($motivo_traslado), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 150);$pdf->MultiCell(78, 4, utf8_decode('Teléfonos:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(32, 150);$pdf->MultiCell(78, 4, utf8_decode('000000000'), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 150);$pdf->MultiCell(78, 4, utf8_decode('Ruta:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(155, 150);$pdf->MultiCell(40, 4, utf8_decode('EMPRESA-CLIENTE'), 0 , 'L');


																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 156);$pdf->MultiCell(78, 4, utf8_decode('Doc. Sustento:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(40, 156);$pdf->MultiCell(78, 4, utf8_decode($numDocModificado), 0 , 'L');
																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(140, 156);$pdf->MultiCell(78, 4, utf8_decode('Código Destino:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(160, 156);$pdf->MultiCell(78, 4, '', 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 162);$pdf->MultiCell(78, 4, utf8_decode('Autorización:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(40, 162);$pdf->MultiCell(100, 4, utf8_decode($clave_acc_guardar), 0 , 'L');

																		$pdf->SetFont('Arial', 'B', 12);$pdf->SetXY(10, 168);$pdf->MultiCell(78, 4, utf8_decode('Descripción:'), 0 , 'L');
																		$pdf->SetFont('Arial', '', 10);$pdf->SetXY(40, 167);$pdf->MultiCell(200, 6, utf8_decode($motivo_traslado), 0 , 'L');



																		$pdf->SetXY(7, 185);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor( 227, 227, 227);
																		$pdf->Cell(198, 6, '', 0, 1,'L', 'true');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10, 187);$pdf->MultiCell(20, 4, utf8_decode('Código'), 0 , 'C');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(20, 187);$pdf->MultiCell(60, 4, utf8_decode('Descripción'), 0 , 'C');

																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(80, 187);$pdf->MultiCell(20, 4, utf8_decode('Cantidad:'), 0 , 'C');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(110, 187);$pdf->MultiCell(20, 4, utf8_decode('Unidad'), 0 , 'C');
																		$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(140, 187);$pdf->MultiCell(50, 4, utf8_decode('Detalle Adicional'), 0 , 'C');


																		$contador_detalles = $acceso_factura->detalles->detalle;
																		$base_tdll = 0;
																		$base_array_detalle = 0;
																		foreach($contador_detalles as $Item){
																			 $base_array_detalle =$base_array_detalle +1;
																		}
																		$cantidad_produyo =$base_array_detalle ;
																		$ancho_productos = $cantidad_produyo*5;




																		$pdf->SetXY(7, 192);
																		$pdf->SetTextColor(0,0,0);
																		$pdf->SetFillColor(245, 245, 245);
																		$pdf->Cell(198,$ancho_productos, '', 0, 1,'L', 'true');


																		$contador_detalles = $acceso_factura->detalles->detalle;
																		$base_tdll = 0;
																		$base_array_detalle = 1;
																		$intervalo_ancho_celda = 0;
																		$base_tdll = 0;
																		foreach($contador_detalles as $Item){
																			$descripcion_producto= $acceso_factura->detalles->detalle[$base_tdll]->descripcion;
																			$codigoPrincipal= $acceso_factura->detalles->detalle[$base_tdll]->codigoPrincipal;
																			$cantidad= $acceso_factura->detalles->detalle[$base_tdll]->cantidad;
																			$precioUnitario= $acceso_factura->detalles->detalle[$base_tdll]->precioUnitario;
																			$descuento= $acceso_factura->detalles->detalle[$base_tdll]->descuento;
																			$precioTotalSinImpuesto= $acceso_factura->detalles->detalle[$base_tdll]->precioTotalSinImpuesto;
																			 $impuestos= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto;
																			$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(10, 193+$intervalo_ancho_celda);$pdf->MultiCell(20, 4, utf8_decode($codigoPrincipal), 0 , 'C');
																			$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(20, 193+$intervalo_ancho_celda);$pdf->MultiCell(60, 4, utf8_decode($descripcion_producto), 0 , 'C');
																			$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(80, 193+$intervalo_ancho_celda);$pdf->MultiCell(20, 4, utf8_decode($cantidad), 0 , 'C');
																			$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(110, 193+$intervalo_ancho_celda);$pdf->MultiCell(20, 4, utf8_decode('UND'), 0 , 'C');
																			$pdf->SetFont('Arial', 'B', 10);$pdf->SetXY(140, 193+$intervalo_ancho_celda);$pdf->MultiCell(50, 4, utf8_decode('NN'), 0 , 'C');
																			 $base_array_detalle =$base_array_detalle +1;
																			 $intervalo_ancho_celda = $intervalo_ancho_celda+5;
																		}

																			$pdf->SetFont('Arial', '', 9);$pdf->SetXY(75, 195+$ancho_productos);$pdf->MultiCell(50, 4, utf8_decode('Cantidad de Productos:'.$cantidad_produyo.''), 0 , 'C');

																			$pdf->SetXY(7, 200+$ancho_productos);
																			$pdf->SetTextColor(0,0,0);
																			$pdf->SetFillColor( 227, 227, 227);
																			$pdf->Cell(198, 50, '', 0, 1,'L', 'true');

																			$espacio_lienas = 6;


																		  $pdf->SetFont('Arial', 'B', 9);$pdf->SetXY(100, 201+$ancho_productos);$pdf->MultiCell(20, 4, utf8_decode('Contactos'), 0 , 'C');
																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(1, 201+$ancho_productos+$espacio_lienas);$pdf->MultiCell(50, 4, utf8_decode('Teléfonos:'.$celular_receptor_uwu.''), 0 , 'C');
																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(6, 213+$ancho_productos);$pdf->MultiCell(25, 4, utf8_decode('Dirección:'), 0 , 'C');
																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(11, 213+$ancho_productos);$pdf->MultiCell(40, 4, utf8_decode($direccion_llegada), 0 , 'C');

																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(4, 219+$ancho_productos);$pdf->MultiCell(25, 4, utf8_decode('Correo:'), 0 , 'C');
																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(19, 219+$ancho_productos);$pdf->MultiCell(40, 4, utf8_decode($email_empresa_uwu), 0 , 'C');

																			$pdf->SetFont('Arial', '',8);$pdf->SetXY(4, 225+$ancho_productos);$pdf->MultiCell(130, 4, utf8_decode('**Nota: una vez salida la mercadería no se aceptan ni cambios, ni devoluciones'), 0 , 'C');

																									$pdf->Output('../comprobantes/guia-remision/pdf/'.$clave_acc_guardar.'.pdf','F');
		
	}
}
/*$pdf = new pdf();
$pdf->pdfFacTura('555');*/
?>
