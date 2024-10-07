<?php
include 'digito_verificador.php';

		$xml = new DomDocument('1.0', 'UTF-8');
		//$xml->standalone = false;
		$xml->preserveWhiteSpace = false;

		$ruc = '1804843900001';

		$Factura = $xml->createElement('comprobanteRetencion');
		$Factura = $xml->appendChild($Factura);
		$cabecera = $xml->createAttribute('id');
		$cabecera->value = 'comprobante';
		$cabecera = $Factura->appendChild($cabecera);
		$cabecerav = $xml->createAttribute('version');
		$cabecerav->value = '1.0.0';
		$cabecerav = $Factura->appendChild($cabecerav);

		//INFORMACION TRIBUTARIA.
		$infoTributaria = $xml->createElement('infoTributaria');
		$infoTributaria = $Factura->appendChild($infoTributaria);
		$cbc = $xml->createElement('ambiente','1');
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('tipoEmision', '1');
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('razonSocial', 'El Granjero');//nombre de la empresa
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('nombreComercial', 'EL GRANJERO');
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('ruc', ''.$ruc.'');//cambiar a ruc
		$fechasf=date('dmY');
		$establecimiento = '001';
		$punto_emision = '001';
		$secuencial =     '000000001';
		$direccion = 'Quito Pichincha';

		$dig = new modulo();
		$clave_acceso=$fechasf.'07'.$ruc.'2'.$establecimiento.''.$punto_emision.''.$secuencial.'123456781';
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('claveAcceso', $clave_acceso.$dig->getMod11Dv($clave_acceso));
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('codDoc', '07');
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('estab', $establecimiento);
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('ptoEmi', $punto_emision);
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('secuencial', $secuencial);
		$cbc = $infoTributaria->appendChild($cbc);
		$cbc = $xml->createElement('dirMatriz', $direccion);
		$cbc = $infoTributaria->appendChild($cbc);

		//INFORMACION DE FACTURA.
		$fecha=date('d/m/Y');
		$fechaemision=  '01/01/2023'; //aqui va la fecha de emision de la factura
		$fechacompra=    '01/01/2023';          //aqui va la fecha de la ompra
		$periodofiscal=   '01/2023';         //periodo fiscal mes y año
		$infoFactura = $xml->createElement('infoCompRetencion');
		$infoFactura = $Factura->appendChild($infoFactura);
		$cbc = $xml->createElement('fechaEmision', $fecha);
		$cbc = $infoFactura->appendChild($cbc);
		$cbc = $xml->createElement('dirEstablecimiento', 'Ambato Kilometro 7 1/2'); //direccion de quien fue hecho la factura
		$cbc = $infoFactura->appendChild($cbc);
		$cbc = $xml->createElement('obligadoContabilidad', 'SI');
		$cbc = $infoFactura->appendChild($cbc);

		$cbc = $xml->createElement('tipoIdentificacionSujetoRetenido', '05'); //tipo de identificacion del retenido
		$cbc = $infoFactura->appendChild($cbc);
		$cbc = $xml->createElement('razonSocialSujetoRetenido', 'ALVARAD DOLZ ALEXIS STALYN');    //razon social del sujeto retenido
		$cbc = $infoFactura->appendChild($cbc);
		$cbc = $xml->createElement('identificacionSujetoRetenido', '0925003907001');       //identificacion del sujeto retenido
		$cbc = $infoFactura->appendChild($cbc);
		$cbc = $xml->createElement('periodoFiscal', '01/2023');                       //periodo fiscal
		$cbc = $infoFactura->appendChild($cbc);

		//IMPUESTO.
		//$doclocalc = substr($reg->com_serie, 0, 3);
		//$docseriec = substr($reg->com_serie, 4, 3);
		//$docnumeroc = substr($reg->com_serie, 8, 9);
		$impuestos = $xml->createElement('impuestos');
		$impuestos = $Factura->appendChild($impuestos);
				$impuesto = $xml->createElement('impuesto');
		$impuesto = $impuestos->appendChild($impuesto);
		//$valorrenta=($reg->com_subtotal*$dts['par_renta'])/100;
		$cbc = $xml->createElement('codigo', '1');
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('codigoRetencion', '312');
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('baseImponible', '1');   //base imponible de la factura
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('porcentajeRetener', '12');  //porcentaje a retener
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('valorRetenido', '0.12');  //$valorrenta=($reg->com_subtotal*$dts['par_renta'])/100;
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('codDocSustento', '01');
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('numDocSustento', '00111');
		$cbc = $impuesto->appendChild($cbc);
		$cbc = $xml->createElement('fechaEmisionDocSustento', $fechacompra);
		$cbc = $impuesto->appendChild($cbc);
		$lleva_iva ='SI';
		if ($lleva_iva == 'SI'){
			$impuesto = $xml->createElement('impuesto');
			$impuesto = $impuestos->appendChild($impuesto);

			$cbc = $xml->createElement('codigo', '2');
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('codigoRetencion', '1');
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('baseImponible', '1.00'); //base imponible cuando lleva iva
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('porcentajeRetener', '12'); //porcentaje a retener
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('valorRetenido', '0.6');    //valor retenido
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('codDocSustento', '01');
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('numDocSustento', '00111');
			$cbc = $impuesto->appendChild($cbc);
			$cbc = $xml->createElement('fechaEmisionDocSustento', $fechacompra);
			$cbc = $impuesto->appendChild($cbc);
		}
		$correo_receptor = 'alejiss401997@gmail.com';
		$direccion_receptor = 'ambato';
		$telefono = '02436519';


				if ($correo_receptor !="" || $direccion!="" || $telefono!=""){
					$infoAdicional = $xml->createElement('infoAdicional');
			$infoAdicional = $Factura->appendChild($infoAdicional);
			if ($correo_receptor!=""){
				$cbc = $xml->createElement('campoAdicional', $correo_receptor);
				$cbc = $infoAdicional->appendChild($cbc);
				$cbcs = $xml->createAttribute('nombre');
				$cbcs->value = 'MAIL';
				$cbcs = $cbc->appendChild($cbcs);
			}
			if ($direccion_receptor!=""){
				$cbc = $xml->createElement('campoAdicional', $direccion_receptor);
				$cbc = $infoAdicional->appendChild($cbc);
				$cbcs = $xml->createAttribute('nombre');
				$cbcs->value = 'DIRECCION';
				$cbcs = $cbc->appendChild($cbcs);
			}
			if ($telefono!=""){
				$cbc = $xml->createElement('campoAdicional', $telefono);
				$cbc = $infoAdicional->appendChild($cbc);
				$cbcs = $xml->createAttribute('nombre');
				$cbcs->value = 'TELEFONO';
				$cbcs = $cbc->appendChild($cbcs);
			}
				}



	$tipo = 'retencion';
		echo $xml->save('../comprobantes/retencion/retencion.xml');







?>
