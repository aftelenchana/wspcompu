<?php
set_time_limit(300);
require_once './ctr_funciones.php';
require_once '../lib/nusoap.php';
//require_once 'ruth_esmeralda_sanchez_herrera.p12';
//if (isset($_POST['submit'])) {
class autorizar {
	public function autorizar_xml($codigo_factura_SC,$iduser,$contenido_colateral_rt) {
		include "../../../../coneccion.php";
			include "ctr_pdf_new.php";
	 $iduser= $_SESSION['id'];
			$queryemisor = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
			$resulemisor = mysqli_fetch_array($queryemisor);
			$clave        = $resulemisor['codigo_sri'];
			$firma_electronica = $resulemisor['firma_electronica'];
			$url_firma_electronica = $resulemisor['url_firma_electronica'];


	 	 $firma = ''.$url_firma_electronica.'/home/facturacion/facturacionphp/controladores/firmas_electronicas/'.$firma_electronica.'';
		if (!$almacen_cert = file_get_contents($firma)) {
			//echo "Error: No se puede leer el fichero del certificado\n";
			$arrayName = array('noticia'=>'son_leer_firma');
			echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
					exit;
		}

		if (openssl_pkcs12_read($almacen_cert, $info_cert, $clave)) {
			$func = new fac_ele();
			$vtipoambiente = 2;
			$wsdls = $func->wsdl($vtipoambiente);
			$recepcion = $wsdls['recepcion'];
			$autorizacionws = $wsdls['autorizacion'];
			//RUTAS PARA LOS ARCHIVOS XML
			$ruta_no_firmados = '../comprobantes/no_firmados/'.$iduser.'.xml';
			$ruta_si_firmados = '../comprobantes/si_firmados/';
			$ruta_autorizados = '../comprobantes/autorizados/';
			$pathPdf = '../comprobantes/pdf/';
			$tipo = 'FV';
			date_default_timezone_set("America/Lima");
			$fecha_actual = date('d-m-Y H:m:s', time());
			$codigo_factura = $iduser.md5(date('d-m-Y H:m:s')).$iduser;

			$acceso_no_firmados = simplexml_load_file($ruta_no_firmados);
			$claveAcceso_no_firmado['claveAccesoComprobante'] = substr($acceso_no_firmados->infoTributaria[0]->claveAcceso, 0, 49);
			$clave_acc_guardar = implode($claveAcceso_no_firmado);

			$estab                       = $acceso_no_firmados->infoTributaria->estab;
			$ptoEmi                      = $acceso_no_firmados->infoTributaria->ptoEmi;
			$secuencial                  = $acceso_no_firmados->infoTributaria->secuencial;
			$numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
			$nuevo_xml = ''.$clave_acc_guardar.'.xml';



			$controlError = false;
			$m = '';
			$show = '';
			//VERIFICAMOS SI EXISTE EL XML NO FIRMADO CREADO
			if (file_exists($ruta_no_firmados)) {
				$firma = 'firmas_electronicas/'.$firma_electronica;
					// Verificar si el archivo ya existe localmente
					if (!file_exists($firma)) {
					    // El archivo no existe, descargarlo del servidor remoto
					    $urlFirmaRemota = $url_firma_electronica . '/home/facturacion/facturacionphp/controladores/firmas_electronicas/' . $firma_electronica;
					    $contenidoFirma = file_get_contents($urlFirmaRemota);
					    if ($contenidoFirma === false) {
								$arrayName = array('noticia'=>'error_descargar_firma');
								echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
					        exit;
					    }
					    // Guardar el archivo de firma localmente
					    file_put_contents($firma, $contenidoFirma);
					}



				$argumentos = $ruta_no_firmados . ' ' . $ruta_si_firmados . ' ' . $nuevo_xml . ' ' . $firma . ' ' . $clave;
				//FIRMA EL XML
				$comando = ('java -jar ../../firmaComprobanteElectronico/dist/firmaComprobanteElectronico.jar ' . $argumentos);
				$resp = shell_exec($comando);
				$claveAcces = simplexml_load_file($ruta_si_firmados . $nuevo_xml);
				$claveAcceso['claveAccesoComprobante'] = substr($claveAcces->infoTributaria[0]->claveAcceso, 0, 49);




				switch (substr($resp, 0, 7)) {
				case 'FIRMADO':
					$xml_firmado = file_get_contents($ruta_si_firmados . $nuevo_xml);
					$data['xml'] = base64_encode($xml_firmado);
					try {
						$client = new nusoap_client($recepcion, true);
						$client->soap_defencoding = 'utf-8';
						$client->xml_encoding = 'utf-8';
						$client->decode_utf8 = false;
						$response = $client->call('validarComprobante', $data);
						//echo 'COMPROBANTE FIRMADO<br>';
					} catch (Exception $e) {
						echo "Error!<br />";
						echo $e->getMessage();
						echo 'Last response: ' . $client->response . '<br />';


					}

					if (is_array($response)) {
						switch ($response["RespuestaRecepcionComprobante"]["estado"]) {
						case 'RECIBIDA':
							$client = new nusoap_client($autorizacionws, true);
							$client->soap_defencoding = 'utf-8';
							$client->xml_encoding = 'utf-8';
							$client->decode_utf8 = false;
							try {
								$responseAut = $client->call('autorizacionComprobante', $claveAcceso);
							} catch (Exception $e) {
								echo "Error!<br>";
								echo $e->getMessage();
								echo 'Last response: ' . $client->response . '<br />';
							}

							if (is_array($responseAut)) {

								switch ($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado']) {

									case 'NO AUTORIZADO':

										//var_dump($responseAut);

										if (isset($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional'])) {
											$mensajeError = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional'];
											//echo '<script>alert("'.$respuesta.' ");</script>';
											$arrayName = array('noticia'=>'error_no_autorizado','mensaje'=>$mensajeError);
											echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

										}
										break;



								case 'AUTORIZADO':
									$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
									$estado = $autorizacion['estado'];
									$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
									$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
									$comprobanteAutorizacion = $autorizacion['comprobante'];


									$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
									//echo 'Xml ' .
									$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
									if ($contenido_colateral_rt == 'genear_factura_y_nota_credito') {
											$crecion = crecion($clave_acc_guardar);
											include "ctr_pdffacturacionnota.php";
											$xmla=new generar_nota_factura();
											$xmla->generate_pdf($clave_acc_guardar);

									}else {
												$crecion = crecion($clave_acc_guardar,$codigo_factura_SC,$fechaAutorizacion);
									}

									$func->correos($clave_acc_guardar,$codigo_factura_SC,$numDocModificado);
									$func->compr_final($clave_acc_guardar,$codigo_factura_SC,$numDocModificado,$fechaAutorizacion);
									rename ('../comprobantes/no_firmados/'.$iduser.'.xml','../comprobantes/no_firmados/'.$clave_acc_guardar.'.xml');

									//unlink($ruta_si_firmados . $nuevo_xml);
									//require_once './funciones/factura_pdf.php';
									//var_dump($func);
									break;
								case 'EN PROCESO':

								$autorizacion = $clave_acc_guardar;
								$estado = 'AUTORIZADO';
								$fechaAutorizacion = date('Y-m-d\TH:i:sP');

								// Nombre del archivo XML
									$nombreArchivoXML = $clave_acc_guardar . '.xml'; // Asegúrate de agregar la extensión .xml

									// Ruta completa al archivo XML
									$rutaCompletaArchivoXML = $ruta_si_firmados . $nombreArchivoXML;


								$comprobanteAutorizacion = file_get_contents($rutaCompletaArchivoXML);


								$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
								//echo 'Xml ' .
								$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
								if ($contenido_colateral_rt == 'genear_factura_y_nota_credito') {
										$crecion = crecion($clave_acc_guardar);
										include "ctr_pdffacturacionnota.php";
										$xmla=new generar_nota_factura();
										$xmla->generate_pdf($clave_acc_guardar);

								}else {
											$crecion = crecion($clave_acc_guardar,$codigo_factura_SC,$fechaAutorizacion);
								}

								$func->correos($clave_acc_guardar,$codigo_factura_SC,$numDocModificado);
								$func->compr_final($clave_acc_guardar,$codigo_factura_SC,$numDocModificado,$fechaAutorizacion);
								rename ('../comprobantes/no_firmados/'.$iduser.'.xml','../comprobantes/no_firmados/'.$clave_acc_guardar.'.xml');

									break;
								}

											// ...
									}else {


									//codigo enmendado si el codigo no tiene la extructura necesaria para ingresar simplemente son dos casos uno es NO AUTORIZADO  INGRESA  Y LE TOMA COMO AUTORIZADO
									$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
									$estado = $autorizacion['estado'];
									$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
									$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
									$comprobanteAutorizacion = $autorizacion['comprobante'];


									$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
									//echo 'Xml ' .
									$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
									if ($contenido_colateral_rt == 'genear_factura_y_nota_credito') {
											$crecion = crecion($clave_acc_guardar);
											include "ctr_pdffacturacionnota.php";
											$xmla=new generar_nota_factura();
											$xmla->generate_pdf($clave_acc_guardar);

									}else {
												$crecion = crecion($clave_acc_guardar,$codigo_factura_SC,$fechaAutorizacion);
									}

									$func->correos($clave_acc_guardar,$codigo_factura_SC,$numDocModificado);
									$func->compr_final($clave_acc_guardar,$codigo_factura_SC,$numDocModificado,$fechaAutorizacion);
									rename ('../comprobantes/no_firmados/'.$iduser.'.xml','../comprobantes/no_firmados/'.$clave_acc_guardar.'.xml');

									//unlink($ruta_si_firmados . $nuevo_xml);
									//require_once './funciones/factura_pdf.php';
									//var_dump($func);
							}

							break;
							case 'DEVUELTA':
								$m .= $response["RespuestaRecepcionComprobante"]["estado"] . '<br>';
								if (isset($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"])) {
									$m .= $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"] . '<br>';
									$ms = $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"] . ' => ' . $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"];
								} else {

								}
								if (isset($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"])) {
									if ($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"]=='CLAVE ACCESO REGISTRADA') {

										$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
										WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'");
										$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
											$sucursal_facturacion        = $data__emmisor['sucursal_facturacion'];

										$query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
										$data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);
										$establecimiento_sinceros        = $data_sucursal['establecimiento'];
										$punto_emision_sinceros        = $data_sucursal['punto_emision'];


										$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.punto_emision ='$punto_emision_sinceros'
			AND comprobante_factura_final.establecimiento ='$establecimiento_sinceros' ORDER BY fecha DESC");
										$result = mysqli_fetch_array($query);
										if ($result) {
											$secuencial = $result['codigo_factura'];
											$secuencial = $secuencial+1;
										}else {
											$secuencial =1;
										}

										$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor,establecimiento,punto_emision,sucursal_facturacion)
										VALUES('$secuencial','00000000','$iduser','$establecimiento_sinceros','$punto_emision_sinceros','$sucursal_facturacion') ");
											//echo '<script>alert("CLAVE DE ACCESO YA GENERADA, SE INSERTO UN REGISTRO EN NUESTRA BASE DE DATOS. GENERE DE NUEVO ESTA FACTURA '.$clave_acc_guardar.' ");</script>';

											$arrayName = array('noticia'=>'clave_duplicada','clave'=>$clave_acc_guardar);
											echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

									}
									if ($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"]=='ERROR SECUENCIAL REGISTRADO') {
										$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
										WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'");
										$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
											$sucursal_facturacion        = $data__emmisor['sucursal_facturacion'];

										$query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
										$data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);
										$establecimiento_sinceros        = $data_sucursal['establecimiento'];
										$punto_emision_sinceros        = $data_sucursal['punto_emision'];

										$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.punto_emision ='$punto_emision_sinceros'
			AND comprobante_factura_final.establecimiento ='$establecimiento_sinceros' ORDER BY fecha DESC");
										$result = mysqli_fetch_array($query);
										if ($result) {
											$secuencial = $result['codigo_factura'];
											$secuencial = $secuencial+1;
										}else {
											$secuencial =1;
										}


										$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor,establecimiento,punto_emision,sucursal_facturacion)
										VALUES('$secuencial','00000000','$iduser','$establecimiento_sinceros','$punto_emision_sinceros','$sucursal_facturacion') ");
											//echo '<script>alert("SECUENCIAL YA REGISTRADO,SE INSERTO UN REGISTRO EN NUESTRA BASE DE DATOS. GENERE DE NUEVO ESTA FACTURA ");</script>';
											$arrayName = array('noticia'=>'clave_duplicada','clave'=>$clave_acc_guardar);
											echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

									}
								}

								if (isset($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"])) {
									$respuesta =  $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"];
									//echo '<script>alert("'.$respuesta.' ");</script>';
									$arrayName = array('noticia'=>'error_devuelta','mensaje'=>$respuesta);
									echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

								}
								break;
							case false:
								//echo 'nose';
								break;
							default:
							//echo '<script>alert("ERROR INTENTA MAS TARDE");</script>';
							$arrayName = array('noticia'=>'sri_fuera');
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


								//echo var_dump($response).'<br>';
								//PONER UN MENSAJE IMPORTANTE

								//$controlError = true;   HABILITAR ESTA LINEA PARA QUE SE PUEDA VER EL ERROR
								break;
							}
						// code...
					}else {

						//codigo enmendado si el codigo no tiene la extructura necesaria para ingresar simplemente son dos casos uno es NO AUTORIZADO  INGRESA  Y LE TOMA COMO AUTORIZADO
						$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
						$estado = $autorizacion['estado'];
						$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
						$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
						$comprobanteAutorizacion = $autorizacion['comprobante'];


						$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
						//echo 'Xml ' .
						$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
						if ($contenido_colateral_rt == 'genear_factura_y_nota_credito') {
								$crecion = crecion($clave_acc_guardar);
								include "ctr_pdffacturacionnota.php";
								$xmla=new generar_nota_factura();
								$xmla->generate_pdf($clave_acc_guardar);

						}else {
									$crecion = crecion($clave_acc_guardar,$codigo_factura_SC,$fechaAutorizacion);
						}

						$func->correos($clave_acc_guardar,$codigo_factura_SC,$numDocModificado);
						$func->compr_final($clave_acc_guardar,$codigo_factura_SC,$numDocModificado,$fechaAutorizacion);
						rename ('../comprobantes/no_firmados/'.$iduser.'.xml','../comprobantes/no_firmados/'.$clave_acc_guardar.'.xml');

						//unlink($ruta_si_firmados . $nuevo_xml);
						//require_once './funciones/factura_pdf.php';
						//var_dump($func);
					}





						break;
					default:
						//echo 'no se puede firmar el doc';
						$arrayName = array('noticia'=>'no_se_puede_firmar');
						echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
						break;
					}
					// echo 'veamos';
				} else {
					//echo "Error: No se puede leer el almacén de certificados o clave del cert p12 es incorrecta.\n";
					$arrayName = array('noticia'=>'error_path');
					echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
					exit;
				}
			} else {
				$arrayName = array('noticia'=>'error_clave_firma');
				echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
				exit;
			}
		}
	}

	?>
