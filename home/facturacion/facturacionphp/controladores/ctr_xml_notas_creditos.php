<?php

include 'digito_verificador.php';
class xml{
	public function xmlFactura($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$sucursal_facturacion){
  include "../../../../coneccion.php";
    $iduser= $_SESSION['id'];
    //INFORMACION DE LA CONFIGURACION
		$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
		$result_configuracion = mysqli_fetch_array($query_configuracioin);
		$ambito_area          =  $result_configuracion['ambito'];



		$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
		$result_documentos = mysqli_fetch_array($query_doccumentos);
		$nombre_empresa          = $result_documentos['nombre_empresa'];
		$email_emisor            = $result_documentos['email'];
		$contabilidad            = $result_documentos['contabilidad'];
		$numero_identidad_emisor = $result_documentos['numero_identidad'];
		$direccion_emisor        = $result_documentos['direccion'];
		$nombre_empresa        = $result_documentos['nombre_empresa'];
		$razon_social          = $result_documentos['razon_social'];
		$nombre_empresa          = $result_documentos['nombre_empresa'];

		$query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
		$data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

		$direccion_sucursal        = $data_sucursal['direccion_sucursal'];

		$estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
		$punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);

		$fecha_actual = date("d-m-Y");
		$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));


		//codigo para sacar la secuencia del usuario

		$establecimiento_sinceros        = $data_sucursal['establecimiento'];
		$punto_emision_sinceros        = $data_sucursal['punto_emision'];

		$query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_nota_credito  WHERE  comprobante_nota_credito.id_emisor  = '$iduser' AND comprobante_nota_credito.punto_emision ='$punto_emision_sinceros'
			AND comprobante_nota_credito.establecimiento ='$establecimiento_sinceros' ORDER BY id DESC");
		 $result_secuencia = mysqli_fetch_array($query_secuencia);
		 if ($result_secuencia) {
			 $secuencial = $result_secuencia['secuencia'];
			 $secuencial = $secuencial +1;
			 // code...
		 }else {
			 $secuencial =1;
		 }

		 $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);








		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->formatOutput = true;
		$xml_fac = $xml->createElement('notaCredito');
		$cabecera = $xml->createAttribute('id');
		$cabecera->value = 'comprobante';
		$cabecerav = $xml->createAttribute('version');
		$cabecerav->value = '1.0.0';
		//INFORMACION TRIBUTARIA

		 $direccion_emisor = str_replace("&", "&amp;", $direccion_emisor);
		 $razon_social = str_replace("&", "&amp;", $razon_social);


		$xml_inf = $xml->createElement('infoTributaria');
		$xml_amb = $xml->createElement('ambiente','2');
		$xml_tip = $xml->createElement('tipoEmision','1');
		$xml_raz = $xml->createElement('razonSocial',$razon_social);


		$xml_ruc = $xml->createElement('ruc',$numero_identidad_emisor);
		$fecha_actual = date("d-m-Y");
		$fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));
		$dig = new modulo();
		$clave_acceso= $fechasf.'04'.$numero_identidad_emisor.'2'.$estableciminento_f.$punto_emision_f.$secuencial.'123456781';
		$clave_acceso =  str_replace(" ","",$clave_acceso);
		$xml_cla = $xml->createElement('claveAcceso',$clave_acceso.$dig->getMod11Dv($clave_acceso));
		$xml_doc = $xml->createElement('codDoc','04');
		$xml_est = $xml->createElement('estab',$estableciminento_f);
		$xml_emi = $xml->createElement('ptoEmi',$punto_emision_f);
		$xml_sec = $xml->createElement('secuencial',$secuencial);
		$xml_dir = $xml->createElement('dirMatriz',$direccion_emisor);

		$fecha_actual = date("d-m-Y");
		$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

		$xml_inc = $xml->createElement('infoNotaCredito');
		$xml_fee = $xml->createElement('fechaEmision',$fecha);
		$xml_deo = $xml->createElement('dirEstablecimiento',$direccion_emisor);

		//de qui empezamos a sacar la informacion
		if ($ambito_area == 'prueba') {
			$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

		}else {

			$query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$clave_acceso_factura' ");
			$data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
			$ininterno = $data_existencia['id'];
			$url_file_upload = $data_existencia['url_file_upload'];

			 $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
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


	  $razon_social_comprador = str_replace("&", "&amp;", $razon_social_comprador);


		$xml_tic = $xml->createElement('tipoIdentificacionComprador', $tipo_identificacion_comprador);
		$xml_zrc = $xml->createElement('razonSocialComprador',$razon_social_comprador);
		$xml_ico = $xml->createElement('identificacionComprador',$identificacion_comprador );
		$xml_obc = $xml->createElement('obligadoContabilidad',$obligadoContabilidad);
		$xml_cdido = $xml->createElement('codDocModificado',$codDocModificado);
		$xml_nmo = $xml->createElement('numDocModificado',$numDocModificado);
		$xml_fss = $xml->createElement('fechaEmisionDocSustento',$fechaEmision);
		$xml_tis = $xml->createElement('totalSinImpuestos',$totalSinImpuestos_general);
		$xml_vuc = $xml->createElement('valorModificacion',$nomnto_modificacion);
		$xml_mda = $xml->createElement('moneda','DOLAR');



		$xml_tci = $xml->createElement('totalConImpuestos');
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
			$xml_tim[$base_if] = $xml->createElement('totalImpuesto');
			$xml_cdo[$base_if] = $xml->createElement('codigo',$codigo);
			$xml_cdp[$base_if] = $xml->createElement('codigoPorcentaje',$codigoPorcentaje);
			$xml_bim[$base_if] = $xml->createElement('baseImponible',$baseImponible);
			$xml_lor[$base_if] = $xml->createElement('valor',$valor);
			$base_if =$base_if+1;
			}

		$xml_mtv = $xml->createElement('motivo',$razon_modficiacion);
		//DETALLES DE PRODUCTOS
		$base_tdll = 0;
		$base_array_detalle = 1;
		$xml_dts = $xml->createElement('detalles');
		$contador_detalles = $acceso_factura->detalles->detalle;
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
			 //echo "contador de la parte de arriba $base_array_detalle";
			 $xml_dte[$base_array_detalle] = $xml->createElement('detalle');
			 $xml_dcp[$base_array_detalle] = $xml->createElement('descripcion',$descripcion_producto);
			 $xml_ctd[$base_array_detalle] = $xml->createElement('cantidad',$cantidad);
			 $xml_puo[$base_array_detalle] = $xml->createElement('precioUnitario',$precioUnitario);
			 $xml_dto[$base_array_detalle] = $xml->createElement('descuento',$descuento);
			 $xml_pts[$base_array_detalle] = $xml->createElement('precioTotalSinImpuesto',$precioTotalSinImpuesto);

			 $xml_ims[$base_array_detalle] = $xml->createElement('impuestos');
			 $xml_imp[$base_array_detalle] = $xml->createElement('impuesto');
			 $xml_cgo[$base_array_detalle] = $xml->createElement('codigo',$codigo);

			 $xml_cpt[$base_array_detalle] = $xml->createElement('codigoPorcentaje',$codigoPorcentaje);
			 $xml_trf[$base_array_detalle] = $xml->createElement('tarifa',$tarifa);
			 $xml_cle[$base_array_detalle] = $xml->createElement('baseImponible',$baseImponible);
			 $xml_vor[$base_array_detalle] = $xml->createElement('valor',$valor);
			 $base_array_detalle =$base_array_detalle +1;


			//echo "$descripcion_producto";
			//echo "$codigoPrincipal";
			//echo "cantidad $cantidad";


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


		$xml_iad = $xml->createElement('infoAdicional');
		$xml_cad = $xml->createElement('campoAdicional',$email_receptor);
		$atributo3 = $xml->createAttribute('nombre');
		$atributo3->value = 'EMAIL';


		$xml_inf->appendChild($xml_amb);
		$xml_inf->appendChild($xml_tip);
		$xml_inf->appendChild($xml_raz);

		$xml_inf->appendChild($xml_ruc);
		$xml_inf->appendChild($xml_cla);
		$xml_inf->appendChild($xml_doc);
		$xml_inf->appendChild($xml_est);
		$xml_inf->appendChild($xml_emi);
		$xml_inf->appendChild($xml_sec);
		$xml_inf->appendChild($xml_dir);
		$xml_fac->appendChild($xml_inf);//CERRAR LA CAJA DE INFOMACION

		$xml_inc->appendChild($xml_fee);
		$xml_inc->appendChild($xml_deo);
		$xml_inc->appendChild($xml_tic);
		$xml_inc->appendChild($xml_zrc);
		$xml_inc->appendChild($xml_ico);
		$xml_inc->appendChild($xml_obc);
		$xml_inc->appendChild($xml_cdido);
		$xml_inc->appendChild($xml_nmo);
		$xml_inc->appendChild($xml_fss);
		$xml_inc->appendChild($xml_tis);
		$xml_inc->appendChild($xml_vuc);
		$xml_inc->appendChild($xml_mda);


		$xml_inc->appendChild($xml_tci);

		$contador_tipo_impuestos = $acceso_factura->infoFactura->totalConImpuestos;
 $uig_kd = 1;
		foreach($contador_tipo_impuestos as $Item){
					$xml_tci->appendChild($xml_tim[$uig_kd]);
					$xml_tim[$uig_kd]->appendChild($xml_cdo[$uig_kd]);
					$xml_tim[$uig_kd]->appendChild($xml_cdp[$uig_kd]);
					$xml_tim[$uig_kd]->appendChild($xml_bim[$uig_kd]);
					$xml_tim[$uig_kd]->appendChild($xml_lor[$uig_kd]);
			$uig_kd =$uig_kd +1;

				}





		$xml_fac->appendChild($xml_inc);
		$xml_inc->appendChild($xml_mtv);

		$arry_oc_dtls = 1;
		$contador_detalles = $acceso_factura->detalles->detalle;
		foreach($contador_detalles as $Item){
			//echo "contador abajo $arry_oc_dtls";
			$xml_dts->appendChild($xml_dte[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_dcp[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_ctd[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_puo[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_dto[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_pts[$arry_oc_dtls]);
			$xml_dte[$arry_oc_dtls]->appendChild($xml_ims[$arry_oc_dtls]);
			$xml_ims[$arry_oc_dtls]->appendChild($xml_imp[$arry_oc_dtls]);
			$xml_imp[$arry_oc_dtls]->appendChild($xml_cgo[$arry_oc_dtls]);
			$xml_imp[$arry_oc_dtls]->appendChild($xml_cpt[$arry_oc_dtls]);
			$xml_imp[$arry_oc_dtls]->appendChild($xml_trf[$arry_oc_dtls]);
			$xml_imp[$arry_oc_dtls]->appendChild($xml_cle[$arry_oc_dtls]);
			$xml_imp[$arry_oc_dtls]->appendChild($xml_vor[$arry_oc_dtls]);
			$arry_oc_dtls =$arry_oc_dtls +1;

			}


			$xml_fac->appendChild($xml_dts);

		$xml_fac->appendChild($xml_iad);
		$xml_iad->appendChild($xml_cad);
		$xml_cad->appendChild($atributo3);

		$xml_fac->appendChild($cabecera);
		$xml_fac->appendChild($cabecerav);
		$xml->appendChild($xml_fac);

			 $xml->save('../comprobantes/nota-credito/no_firmados/notacredito'.$iduser.'.xml');

	}
}

?>
