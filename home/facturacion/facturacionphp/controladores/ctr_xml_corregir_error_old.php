<?php
include 'digito_verificador.php';
class xml{
	public function xmlFactura($iduser,$clave_acceso_factura){

		   include "../../../../coneccion.php";

        mysqli_set_charset($conection, 'utf8'); //linea a colocar


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
				$ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';


						$acceso_factura = simplexml_load_file($ruta_factura);
					  $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

					   //para crear el numero dl documento necesito de 4 partes
						 $razonSocial                       = $acceso_factura->infoTributaria->razonSocial;
						 $nombreComercial                      = $acceso_factura->infoTributaria->nombreComercial;
						 $ruc                       = $acceso_factura->infoTributaria->ruc;
						 $dirMatriz                      = $acceso_factura->infoTributaria->dirMatriz;
					    $estab                       = $acceso_factura->infoTributaria->estab;
					    $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
					    $secuencial                  = $acceso_factura->infoTributaria->secuencial;
					  $numDocModificado              = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';

					  //informacion del comprador

						$obligadoContabilidad             = $acceso_factura->infoFactura->obligadoContabilidad;
						$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;



					    $identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
					    $tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
					    $razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
							$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
							$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
							$totalSinImpuestos                = $acceso_factura->infoFactura->totalSinImpuestos;
							$totalDescuento                = $acceso_factura->infoFactura->totalDescuento;

							$importeTotal                = $acceso_factura->infoFactura->importeTotal;




			//PRIMERA PARTE
			$xml = new DOMDocument('1.0', 'utf-8');
			$xml->formatOutput = true;


			$xml_fac = $xml->createElement('factura');
			$cabecera = $xml->createAttribute('id');
			$cabecera->value = 'comprobante';
			$cabecerav = $xml->createAttribute('version');
			$cabecerav->value = '2.0.0';
			$xml_inf = $xml->createElement('infoTributaria');
			$xml_amb = $xml->createElement('ambiente','2');
			$xml_tip = $xml->createElement('tipoEmision','1');
			$xml_raz = $xml->createElement('razonSocial',$razonSocial);

			if (!empty($nombreComercial)) {
			$xml_nom = $xml->createElement('nombreComercial',$nombreComercial);
			}


			$xml_ruc = $xml->createElement('ruc',$ruc);
			$fecha_actual = date("d-m-Y");
			$fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));
			$dig = new modulo();
			$clave_acceso= $fechasf.'01'.$ruc.'2'.$estab.$ptoEmi.$secuencial.'123456781';
			$clave_acceso =  str_replace(" ","",$clave_acceso);
			$xml_cla = $xml->createElement('claveAcceso',$clave_acceso.$dig->getMod11Dv($clave_acceso));
			$xml_doc = $xml->createElement('codDoc','01');
			$xml_est = $xml->createElement('estab', $estab);
			$xml_emi = $xml->createElement('ptoEmi', $ptoEmi);
			$xml_sec = $xml->createElement('secuencial',$secuencial);
			$xml_dir = $xml->createElement('dirMatriz',$dirMatriz);

			//SEGUNDA PARTE
			$xml_def = $xml->createElement('infoFactura');
			$xml_fec = $xml->createElement('fechaEmision',$fecha);
			$xml_des = $xml->createElement('dirEstablecimiento',$dirMatriz);

			$xml_obl = $xml->createElement('obligadoContabilidad',$obligadoContabilidad);
			$xml_ide = $xml->createElement('tipoIdentificacionComprador',$tipo_identificacion_comprador);


				//hacer si es que si es contribuyente especial aparezca
			//$xml_contribuyenteEspecial = $xml->createElement('contribuyenteEspecial', 'NO');


			$nombres_receptor = str_replace("&", "&amp;", $nombres_receptor);


			$xml_rco = $xml->createElement('razonSocialComprador',($razon_social_comprador));
			$xml_idc = $xml->createElement('identificacionComprador',$identificacion_comprador);
			$xml_tsi = $xml->createElement('totalSinImpuestos', $totalSinImpuestos);

			$xml_tds = $xml->createElement('totalDescuento',$totalDescuento);

			$xml_imp = $xml->createElement('totalConImpuestos');


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
				$xml_tco[$base_if] = $xml->createElement('codigo',$codigo);
				$xml_cpr[$base_if] = $xml->createElement('codigoPorcentaje',$codigoPorcentaje);
				$xml_bas[$base_if] = $xml->createElement('baseImponible',$baseImponible);
				$xml_val[$base_if] = $xml->createElement('valor',$valor);
				$base_if =$base_if+1;
				}

			//PARTE 2.3
			$xml_pro = $xml->createElement('propina','0.00');
			$xml_imt = $xml->createElement('importeTotal', $importeTotal);

			$xml_mon = $xml->createElement('moneda','DOLAR');


			//PARTE PAGOS
			$xml_pgs = $xml->createElement('pagos');

			//de aqui tiene que ser el qhile de pagos
			$bt = 1;
			mysqli_query($conection,"SET lc_time_names = 'es_ES'");
			$query_lista = mysqli_query($conection,"SELECT * FROM formas_pago_facturacion
				WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigo_factura_SC'
			ORDER BY `formas_pago_facturacion`.`fecha` DESC ");
				 $result_lista= mysqli_num_rows($query_lista);
			 if ($result_lista > 0) {
						 while ($data_lista=mysqli_fetch_array($query_lista)) {
							 $codigo_formas_pago = $data_lista['formaPago'];
								$cantidad_metodo_pago = $data_lista['cantidad_metodo_pago'];

								$xml_pag[$bt] = $xml->createElement('pago');
								$xml_fpa[$bt]  = $xml->createElement('formaPago',$codigo_formas_pago);
								$xml_tot[$bt] = $xml->createElement('total', round($cantidad_metodo_pago, 2));

								$xml_pla[$bt]  = $xml->createElement('plazo','1');
								$xml_uti[$bt]  = $xml->createElement('unidadTiempo','dias');
									$bt = $bt+1;

							}
						}




			$xml_dts = $xml->createElement('detalles');
			$query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
			WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_SC'");
			$a = 1;
					while ($resultados = mysqli_fetch_array($query_resultados)) {
							$xml_det[$a] = $xml->createElement('detalle');


							$xml_cop[$a] = $xml->createElement('codigoPrincipal',$resultados['id_producto']);
							$xml_dcr[$a] = $xml->createElement('descripcion',($resultados['descripcion_producto']));
							$xml_can[$a] = $xml->createElement('cantidad',$resultados['cantidad_producto']);
							$xml_pru[$a] = $xml->createElement('precioUnitario', round($resultados['valor_unidad'], 2));
							$xml_dsc[$a] = $xml->createElement('descuento',($resultados['descuento']));
							$xml_tsm[$a] = $xml->createElement('precioTotalSinImpuesto', round((($resultados['cantidad_producto'] * $resultados['valor_unidad']) - $resultados['descuento']), 2));

							$xml_ips[$a] = $xml->createElement('impuestos');
							$xml_ipt[$a] = $xml->createElement('impuesto');
							$xml_cdg[$a] = $xml->createElement('codigo',$resultados['codigos_impuestos']);
							$xml_cpt[$a] = $xml->createElement('codigoPorcentaje',$resultados['tipo_ambiente']);
							if ($resultados['tipo_ambiente'] == 2) {
								$tarifa = 12;
							}else {
								$tarifa= 0;
							}

							$xml_trf[$a] = $xml->createElement('tarifa',$tarifa);
							$xml_bsi[$a] = $xml->createElement('baseImponible', round((($resultados['cantidad_producto'] * $resultados['valor_unidad']) - $resultados['descuento']), 2));

							$xml_vlr[$a] = $xml->createElement('valor',round((($resultados['cantidad_producto'] * $resultados['valor_unidad']) * $tarifa / 100), 2));

							$a = $a +1;
					}




			//INFO ADICIONAL
			$xml_ifa = $xml->createElement('infoAdicional');
			$xml_cp1 = $xml->createElement('campoAdicional',$email_reeptor);
			$atributo = $xml->createAttribute('nombre');
			$atributo->value = 'email';

			//PRIMERA PARTE
			$xml_inf->appendChild($xml_amb);
			$xml_inf->appendChild($xml_tip);
			$xml_inf->appendChild($xml_raz);

			if (!empty($nombre_empresa)) {
			$xml_inf->appendChild($xml_nom);
			}
			$xml_inf->appendChild($xml_ruc);
			$xml_inf->appendChild($xml_cla);
			$xml_inf->appendChild($xml_doc);
			$xml_inf->appendChild($xml_est);
			$xml_inf->appendChild($xml_emi);
			$xml_inf->appendChild($xml_sec);
			$xml_inf->appendChild($xml_dir);
			$xml_fac->appendChild($xml_inf);

			//SEGUNDA PARTE
			$xml_def->appendChild($xml_fec);
			$xml_def->appendChild($xml_des);
			//$xml_def->appendChild($xml_con);
			$xml_def->appendChild($xml_obl);
			$xml_def->appendChild($xml_ide);

			//hacer si es que si es contribuyente especial aparezca
			//$xml_def->appendChild($xml_contribuyenteEspecial);
			$xml_def->appendChild($xml_rco);
			$xml_def->appendChild($xml_idc);
			$xml_def->appendChild($xml_tsi);
			$xml_def->appendChild($xml_tds);
			$xml_def->appendChild($xml_imp);


			$contador_tipo_impuestos = $acceso_factura->infoFactura->totalConImpuestos;
	 $uig_kd = 1;
			foreach($contador_tipo_impuestos as $Item){
						$xml_imp->appendChild($xml_tim[$uig_kd]);
						$xml_tim[$uig_kd]->appendChild($xml_tco[$uig_kd]);
						$xml_tim[$uig_kd]->appendChild($xml_cpr[$uig_kd]);
						$xml_tim[$uig_kd]->appendChild($xml_bas[$uig_kd]);
						$xml_tim[$uig_kd]->appendChild($xml_val[$uig_kd]);
				$uig_kd =$uig_kd +1;

					}




			$xml_fac->appendChild($xml_def);



			//SEGUNDA PARTE 2.3

			$xml_def->appendChild($xml_pro);
			$xml_def->appendChild($xml_imt);
			$xml_def->appendChild($xml_mon);



			$xml_def->appendChild($xml_pgs);

			$bt2 = 1;
			mysqli_query($conection,"SET lc_time_names = 'es_ES'");
			$query_lista = mysqli_query($conection,"SELECT * FROM formas_pago_facturacion WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigo_factura_SC'
			ORDER BY `formas_pago_facturacion`.`fecha` DESC ");
				 $result_lista= mysqli_num_rows($query_lista);
			 if ($result_lista > 0) {
						 while ($data_lista=mysqli_fetch_array($query_lista)) {
								$xml_pgs->appendChild($xml_pag[$bt2]);
								$xml_pag[$bt2]->appendChild($xml_fpa[$bt2]);
								$xml_pag[$bt2]->appendChild($xml_tot[$bt2]);
								$xml_pag[$bt2]->appendChild($xml_pla[$bt2]);
								$xml_pag[$bt2]->appendChild($xml_uti[$bt2]);
									$bt2 = $bt2+1;
							}
						}


			$xml_fac->appendChild($xml_dts);
			$query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
			WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_SC'  ");
							 $a = 1;
					$result_lista= mysqli_num_rows($query_resultados);
					 if ($result_lista > 0) {
					while ($resultados = mysqli_fetch_array($query_resultados)) {
						$xml_dts->appendChild($xml_det[$a]);
						$xml_det[$a]->appendChild($xml_cop[$a]);
						$xml_det[$a]->appendChild($xml_dcr[$a]);
						$xml_det[$a]->appendChild($xml_can[$a]);
						$xml_det[$a]->appendChild($xml_pru[$a]);
						$xml_det[$a]->appendChild($xml_dsc[$a]);
						$xml_det[$a]->appendChild($xml_tsm[$a]);
						$xml_det[$a]->appendChild($xml_ips[$a]);
						$xml_ips[$a]->appendChild($xml_ipt[$a]);
						$xml_ipt[$a]->appendChild($xml_cdg[$a]);
						$xml_ipt[$a]->appendChild($xml_cpt[$a]);
						$xml_ipt[$a]->appendChild($xml_trf[$a]);
						$xml_ipt[$a]->appendChild($xml_bsi[$a]);
						$xml_ipt[$a]->appendChild($xml_vlr[$a]);
							$a = $a+1;
					}
					}



			$xml_fac->appendChild($xml_ifa);
			$xml_ifa->appendChild($xml_cp1);
			$xml_cp1->appendChild($atributo);





			$xml_fac->appendChild($cabecera);
			$xml_fac->appendChild($cabecerav);
			$xml->appendChild($xml_fac);



			//$xml->save("file.xml");
			//print_r ($xml->saveXML());
			$xml->save('../comprobantes/no_firmados/'.$iduser.'.xml');

			exit;



			}
			}



			?>
