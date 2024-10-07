<?php

include 'digito_verificador.php';
class xml{
	public function xmlFactura($codigo_retencion,$porcentaje_retencion,$codigo_compra,$clave_acceso_factura){
  include "../../../../coneccion.php";
    $iduser= $_SESSION['id'];
    //INFORMACION DE LA CONFIGURACION
		$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
		$result_configuracion = mysqli_fetch_array($query_configuracioin);
		$ambito_area          =  $result_configuracion['ambito'];


		$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
		$result_documentos = mysqli_fetch_array($query_doccumentos);
		$documentos_electronicos = $result_documentos['documentos_electronicos'];
		$nombre_empresa          = $result_documentos['nombre_empresa'];
		$email_emisor            = $result_documentos['email'];
		$estableciminento_f      = $result_documentos['estableciminento_f'];
		$contabilidad            = $result_documentos['contabilidad'];
		$punto_emision_f         = $result_documentos['punto_emision_f'];
		$numero_identidad_emisor = $result_documentos['numero_identidad'];
		$direccion_emisor        = $result_documentos['direccion'];
		$img_logo                = $result_documentos['img_facturacion'];
		$nombre_empresa        = $result_documentos['nombre_empresa'];
		$img_logo                = $result_documentos['img_facturacion'];

		$estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
		$punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
		$porcentaje_iva_f     = ($result_documentos['porcentaje_iva_f'])/100;

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



		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->formatOutput = true;
		$xml_fac = $xml->createElement('comprobanteRetencion');
		$cabecera = $xml->createAttribute('id');
		$cabecera->value = 'comprobante';
		$cabecerav = $xml->createAttribute('version');
		$cabecerav->value = '2.0.0';
		//INFORMACION TRIBUTARIA
		$xml_inf = $xml->createElement('infoTributaria');
		$xml_amb = $xml->createElement('ambiente','2');
		$xml_tip = $xml->createElement('tipoEmision','1');
		$xml_raz = $xml->createElement('razonSocial',$nombre_empresa);
		$xml_nom = $xml->createElement('nombreComercial',$nombre_empresa);
		$xml_ruc = $xml->createElement('ruc',$numero_identidad_emisor);
		$fecha_actual = date("d-m-Y");
		$fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));
		$dig = new modulo();
		$clave_acceso= $fechasf.'07'.$numero_identidad_emisor.'2'.$estableciminento_f.$punto_emision_f.$secuencial_neto.'123456781';
		$clave_acceso =  str_replace(" ","",$clave_acceso);
		$xml_cla = $xml->createElement('claveAcceso',$clave_acceso.$dig->getMod11Dv($clave_acceso));
		$xml_doc = $xml->createElement('codDoc','07');
		$xml_est = $xml->createElement('estab',$estableciminento_f);
		$xml_emi = $xml->createElement('ptoEmi',$punto_emision_f);
		$xml_sec = $xml->createElement('secuencial',$secuencial_neto);
		$xml_dir = $xml->createElement('dirMatriz',$direccion_emisor);

		$fecha_actual = date("d-m-Y");
		$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

		//INFORMACION DE LA RETENCION
		$xml_iret    = $xml->createElement('infoCompRetencion');
		$xml_fechae  = $xml->createElement('fechaEmision', $fecha);
		$xml_dire  = $xml->createElement('dirEstablecimiento', $direccion_emisor);

		//CODIGO PARA SACAR LA INFORMACION DE LA FACTURA Y REALIZAR LA RETENCION
		$query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM compras_facturacion WHERE compras_facturacion.id ='$codigo_compra' ");
		$data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
		$xml_factura_consulta = $data_existencia['xml'];
		$url = $data_existencia['url'];


		$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
		$result_configuracion = mysqli_fetch_array($query_configuracioin);
		$ambito_area          =  $result_configuracion['ambito'];

		//de qui empezamos a sacar la informacion
		if ($ambito_area == 'prueba') {
			$ruta_factura = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$xml_factura_consulta;

		}else {
			$ruta_factura = ''.$url.'/home/archivos/compras/'.$xml_factura_consulta;
		}
		$acceso_factura = simplexml_load_file($ruta_factura);
		 $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

										//para crear el numero dl documento necesito de 4 partes
										 $estab                       = $acceso_factura->infoTributaria->estab;
										 $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
										 $secuencial                  = $acceso_factura->infoTributaria->secuencial;
										 $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
										 $claveAcceso                  = $acceso_factura->infoTributaria->claveAcceso;

										  $idnetificacion_sujeto_retenido                      = $acceso_factura->infoTributaria->ruc;
											$razonSocial_sujeto_retenido                      = $acceso_factura->infoTributaria->razonSocial;


											$numDocSustento                = $estab.$ptoEmi.$secuencial;
								//informacion del comprador
									$identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
									$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
									$razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
									$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
									$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
									$totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
									$totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
									$dirEstablecimiento                = $acceso_factura->infoFactura->dirEstablecimiento;
									$importeTotal_retencion                = $acceso_factura->infoFactura->importeTotal;
									$fechaEmisionDocSustento                = $acceso_factura->infoFactura->fechaEmision;

									//codigo para verificar si esta correcto la identificacion

										$largo_cadena = strlen($idnetificacion_sujeto_retenido);

											if ($largo_cadena < 10 || $largo_cadena > 13 ) {
												$arrayName = array('noticia'=>'identificacion_invalida');
												echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
												exit;
											}else {
												if ($largo_cadena == '13') {
													if ($idnetificacion_sujeto_retenido == '9999999999999') {
															$tipoSujetoRetenido       = '07';
													}
													if ($idnetificacion_sujeto_retenido != '9999999999999') {
														//echo "Esto es un ruc";
															$tipoSujetoRetenido       = '02';
													}
												}
												if ($largo_cadena == '10') {
														$tipoSujetoRetenido       ='03';
													//echo "Este es cedula";
												}

											}

											// Obtener el mes y año actual
											$mes = date('m'); // Mes en formato numérico, con ceros iniciales (01 a 12)
											$anio = date('Y'); // Año en formato de cuatro dígitos

											// Formatear la fecha en el formato mm/aaaa
											$periodoFiscal = $mes . '/' . $anio;



		$xml_tsjr  = $xml->createElement('tipoSujetoRetenido', $tipoSujetoRetenido);
		$xml_rel  = $xml->createElement('parteRel', 'NO');
		$xml_rzre  = $xml->createElement('razonSocialSujetoRetenido', $razonSocial_sujeto_retenido);
		$xml_isr  = $xml->createElement('identificacionSujetoRetenido', $idnetificacion_sujeto_retenido);
		$xml_pfis  = $xml->createElement('periodoFiscal',$periodoFiscal);


		$codDocSustento = 10;

		//TERCERA PARTE
		$xml_docs    = $xml->createElement('docsSustento');
		$xml_doc     = $xml->createElement('docSustento');
		$xml_cds     = $xml->createElement('codSustento','10');
		$xml_cdocss  = $xml->createElement('codDocSustento','10');
		$xml_ndsu    = $xml->createElement('numDocSustento',$numDocSustento);
		$xml_fedsu    = $xml->createElement('fechaEmisionDocSustento',$fechaEmisionDocSustento);

		$xml_nads    = $xml->createElement('numAutDocSustento',$claveAcceso);
		$xml_plex    = $xml->createElement('pagoLocExt','01');


		if ($codDocSustento == '41') {
			$xml_tcre    = $xml->createElement('totalComprobantesReembolso','138.19');
			$xml_tbir    = $xml->createElement('totalBaseImponibleReembolso','133.13');
			$xml_tire    = $xml->createElement('totalImpuestoReembolso','3.25');
			// code...
		}






		$xml_tsim    = $xml->createElement('totalSinImpuestos',$totalSinImpuestos_general);
		$xml_imto    = $xml->createElement('importeTotal',$importeTotal_retencion);
		//CUARTA PARTE

		$xml_imdsu    = $xml->createElement('impuestosDocSustento');



 //var_dump($acceso_factura->infoFactura->totalConImpuestos);

		$contador_tipo_impuestos = $acceso_factura->infoFactura->totalConImpuestos;
		$uig = 0;
		$base_if = 1;
		foreach($contador_tipo_impuestos as $Item){
			$codigo = $acceso_factura->infoFactura->totalConImpuestos->totalImpuesto->codigo;
			$codigoPorcentaje = $acceso_factura->infoFactura->totalConImpuestos->totalImpuesto->codigoPorcentaje;
			$baseImponible = $acceso_factura->infoFactura->totalConImpuestos->totalImpuesto->baseImponible;
			$valor = $acceso_factura->infoFactura->totalConImpuestos->totalImpuesto->valor;
			//var_dump($codigo);
			$xml_imds_1[$base_if]  = $xml->createElement('impuestoDocSustento');
			$xml_cids[$base_if]    = $xml->createElement('codImpuestoDocSustento','2');
			$xml_cpje[$base_if]    = $xml->createElement('codigoPorcentaje','5');
			$xml_bimo[$base_if]    = $xml->createElement('baseImponible','1000');
			$xml_tafa[$base_if]    = $xml->createElement('tarifa','0');
			$xml_vaim[$base_if]    = $xml->createElement('valorImpuesto','3.25');

			$base_if =$base_if+1;
			}

			$contador_tipo_pagos = $acceso_factura->infoFactura->pagos;
			$xml_pags = $xml->createElement('Pagos');
			$base_pago = 1;

			foreach ($contador_tipo_pagos as $Item) {
			    $xml_pago[$base_pago] = $xml->createElement('Pago');
			    $xml_fpgo[$base_pago] = $xml->createElement('formapago', '01'); // Reemplaza '01' con el valor correspondiente si es necesario
			    $xml_ttal[$base_pago] = $xml->createElement('total', '500'); // Reemplaza '500' con el valor correspondiente si es necesario
			    $base_pago++;
			}





		$xml_iadc    = $xml->createElement('infoAdicional');
		$xml_fpgo    = $xml->createElement('formapago','01');

		$xml_ifa = $xml->createElement('infoAdicional');
		$xml_cp1 = $xml->createElement('campoAdicional','alejiss401997');
		$atributo = $xml->createAttribute('nombre');
		$atributo->value = 'email';




		$xml_inf->appendChild($xml_amb);
		$xml_inf->appendChild($xml_tip);
		$xml_inf->appendChild($xml_raz);
		$xml_inf->appendChild($xml_nom);
		$xml_inf->appendChild($xml_ruc);
		$xml_inf->appendChild($xml_cla);
		$xml_inf->appendChild($xml_doc);
		$xml_inf->appendChild($xml_est);
		$xml_inf->appendChild($xml_emi);
		$xml_inf->appendChild($xml_sec);
		$xml_inf->appendChild($xml_dir);
		$xml_fac->appendChild($xml_inf);//CERRAR LA CAJA DE INFOMACION

		$xml_iret->appendChild($xml_fechae);
		$xml_iret->appendChild($xml_dire);



		$xml_iret->appendChild($xml_tsjr);
		$xml_iret->appendChild($xml_rel);
		$xml_iret->appendChild($xml_rzre);
		$xml_iret->appendChild($xml_isr);
		$xml_iret->appendChild($xml_pfis);
		$xml_fac->appendChild($xml_iret);//cerrar caja de informacion del sujeto retenidp
		$xml_docs->appendChild($xml_doc);

		$xml_docs->appendChild($xml_doc);
		$xml_doc->appendChild($xml_cds);
		$xml_doc->appendChild($xml_cdocss);
		$xml_doc->appendChild($xml_ndsu);
		$xml_doc->appendChild($xml_fedsu);

		$xml_doc->appendChild($xml_nads);
		$xml_doc->appendChild($xml_plex);
		//$xml_doc->appendChild($xml_tireo);
		//$xml_doc->appendChild($xml_papa);
		//$xml_doc->appendChild($xml_aptr);
		//$xml_doc->appendChild($xml_pale);
		//$xml_doc->appendChild($xml_pafi);

		if ($codDocSustento == '41') {
			$xml_doc->appendChild($xml_tcre);
			$xml_doc->appendChild($xml_tbir);
			$xml_doc->appendChild($xml_tire);
		}



		$xml_doc->appendChild($xml_tsim);
		$xml_doc->appendChild($xml_imto);


		$xml_iret->appendChild($xml_imdsu);


		$contador_tipo_impuestos = $acceso_factura->infoFactura->totalConImpuestos;
		$uig_kd = 1;
		foreach ($contador_tipo_impuestos as $Item) {

		    $xml_imdsu->appendChild($xml_imds_1[$uig_kd]);
		    $xml_imds_1[$uig_kd]->appendChild($xml_cids[$uig_kd]);
		    $xml_imds_1[$uig_kd]->appendChild($xml_cpje[$uig_kd]);
		    $xml_imds_1[$uig_kd]->appendChild($xml_bimo[$uig_kd]);
		    $xml_imds_1[$uig_kd]->appendChild($xml_tafa[$uig_kd]);
		    $xml_imds_1[$uig_kd]->appendChild($xml_vaim[$uig_kd]);

		    $uig_kd = $uig_kd + 1;
		}


			$xml_iret->appendChild($xml_pags);


		// Segundo foreach: Añadir los elementos de pago al documento
		$base_pago_2 = 1;
		foreach ($contador_tipo_pagos as $Item) {
		  	$xml_pags->appendChild($xml_pago[$base_pago_2]);
		    $xml_pago[$base_pago_2]->appendChild($xml_fpgo[$base_pago_2]);
		    $xml_pago[$base_pago_2]->appendChild($xml_ttal[$base_pago_2]);
		    $base_pago_2++;
		}




		$xml_fac->appendChild($xml_ifa);

		$xml_ifa->appendChild($xml_cp1);
		$xml_cp1->appendChild($atributo);

		$xml_fac->appendChild($cabecera);
		$xml_fac->appendChild($cabecerav);
		$xml->appendChild($xml_fac);





			 $xml->save('../comprobantes/retencion/no_firmados/retencion'.$iduser.'.xml');

			 exit;

	}
}

?>
