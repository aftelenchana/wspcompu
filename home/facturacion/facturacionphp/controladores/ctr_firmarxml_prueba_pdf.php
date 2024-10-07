<?php
set_time_limit(300);
require_once './ctr_funciones.php';
require_once './ctr_pdf.php';
require_once '../lib/nusoap.php';
//require_once 'ruth_esmeralda_sanchez_herrera.p12';
//if (isset($_POST['submit'])) {
class autorizar {
	public function autorizar_xml($fecha,$correo,$porcentaje_iva_f,$nombre_empresa,$img_logo,$direccion_emisor,$numero_identidad_emisor,$estableciminento_f,$punto_emision_f,$fecha_emision,$nombres_receptor,$numero_cedula_receptor,$precio_88_iva,$precio_12_iva,$precio_total,$direccion_receptor,$celular_receptor,$email_receptor,$email_emisor,$secuencial,$numeroConCeros,$query_resultados_emmisor) {
		include "../../../../coneccion.php";
	 $iduser= $_SESSION['id'];
			$queryemisor = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
			$resulemisor = mysqli_fetch_array($queryemisor);
			$codigo_sri        = $resulemisor['codigo_sri'];
			$firma_electronica = $resulemisor['firma_electronica'];


			    $clave_acc_guardar = $iduser.md5(date('d-m-Y H:m:s')).$iduser;
					$func              = new fac_ele();
					$pdf               = new pdf();
					$pdf->pdfFactura($correo,$clave_acc_guardar,$nombre_empresa,$img_logo,$direccion_emisor,$numero_identidad_emisor,$estableciminento_f,$punto_emision_f,$fecha_emision,$nombres_receptor,$numero_cedula_receptor,$precio_88_iva,$precio_12_iva,$porcentaje_iva_f,$precio_total,$direccion_receptor,$celular_receptor,$email_receptor,$email_emisor,$secuencial,$numeroConCeros,$query_resultados_emmisor);
					$arrayName = array('noticia'=>'pdf_pegenerado','clave'=>$clave_acc_guardar);
					echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;
	 $firma = ''.$firma_electronica.'';
	 $clave = ''.$codigo_sri.'';
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
			$ruta_no_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$iduser.'.xml';
					$ruta_si_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\si_firmados\\';
					$ruta_autorizados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\autorizados\\';
					$pathPdf = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\pdf\\';
			$tipo = 'FV';
			date_default_timezone_set("America/Lima");
			$fecha_actual = date('d-m-Y H:m:s', time());
			$codigo_factura = $iduser.md5(date('d-m-Y H:m:s')).$iduser;

			$acceso_no_firmados = simplexml_load_file($ruta_no_firmados);
			$claveAcceso_no_firmado['claveAccesoComprobante'] = substr($acceso_no_firmados->infoTributaria[0]->claveAcceso, 0, 49);
			$clave_acc_guardar = implode($claveAcceso_no_firmado);

			$nuevo_xml = ''.$clave_acc_guardar.'.xml';
			$controlError = false;
			$m = '';
			$show = '';
			//VERIFICAMOS SI EXISTE EL XML NO FIRMADO CREADO
			if (file_exists($ruta_no_firmados)) {
				$argumentos = $ruta_no_firmados . ' ' . $ruta_si_firmados . ' ' . $nuevo_xml . ' ' . $firma . ' ' . $clave;
				//FIRMA EL XML
				$comando = ('java -jar C:\\xampp\\htdocs\\home\\facturacion\\firmaComprobanteElectronico\\dist\\firmaComprobanteElectronico.jar ' . $argumentos);
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

					switch ($response["RespuestaRecepcionComprobante"]["estado"]) {
					case 'RECIBIDA':
						//echo $response["RespuestaRecepcionComprobante"]["estado"] . '<br>';
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

						switch ($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado']) {
						case 'AUTORIZADO':
							$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
							$estado = $autorizacion['estado'];
							$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
							$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
							$comprobanteAutorizacion = $autorizacion['comprobante'];

							//echo '<script>alert("COMPROBANTE AUTORIZADO Y ENVIADO AL CORREO");</script>';
							$arrayName = array('noticia'=>'factura_exitosa');
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
							//echo '<script>alert(Comprobante AUTORIZADO y enviado con exito con autoricacion N° '.$numeroAutorizacion.');</script>';
							$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
							//echo 'Xml ' .
							$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
							$pdf = new pdf();
							$pdf->pdfFactura($correo,$clave_acc_guardar,$nombre_empresa,$img_logo,$direccion_emisor,$numero_identidad_emisor,$estableciminento_f,$punto_emision_f,$fecha_emision,$nombres_receptor,$numero_cedula_receptor,$precio_88_iva,$precio_12_iva,$porcentaje_iva_f,$precio_total,$direccion_receptor,$celular_receptor,$email_receptor,$email_emisor,$secuencial,$numeroConCeros,$query_resultados_emmisor);
							$func->correos($correo,$clave_acc_guardar);
							$func->compr_final($clave_acc_guardar);
							//unlink($ruta_si_firmados . $nuevo_xml);
							//require_once './funciones/factura_pdf.php';
							//var_dump($func);
							break;
						case 'EN PROCESO':
							echo "El comprobante se encuentra EN PROCESO:<br>";
							echo $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado'] . '<br>';
							$m .= 'El documento se encuentra en proceso<br>';
							$controlError = true;
							break;
						default:
							if ($responseAut['RespuestaAutorizacionComprobante']['numeroComprobantes'] == "0") {
								echo 'No autorizado</br>';
								echo 'No se encontro informacion del comprobante en el SRI, vuelva an enviarlo.</br>';
							} else if ($responseAut['RespuestaAutorizacionComprobante']['numeroComprobantes'] == "1") {
								//echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["estado"] . '</br>';
								//echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"] . '</br>';
								$arrayName = array('noticia'=>'no_autorizado','mensaje'=>$responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]);
								echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
								if (isset($responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"])) {
									//echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"] . '</br>';
									$arrayName = array('noticia'=>'no_autorizado','mensaje'=>$responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"]);
									echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
									$ms = $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"] . ' => ' .
										$responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"];
								} else {
									$ms = $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"];
								}
							//MANDAR UN MENSAJE IMPORTANTE
							} else {
								//echo 'No autorizado<br/>';
								//echo "Esta es la respuesta de SRI:<br/>";
//MANDAR UN MENSAJE IMPORTANTE
								//echo "<br/>";
								//echo 'INFORME AL ADMINISTRADOR!</br>';
								$arrayName = array('noticia'=>'no_autorizado','mensaje'=>'informe_admin');
								echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

							}
							break;
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
								$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY fecha DESC");
								$result = mysqli_fetch_array($query);
								if ($result) {
									$secuencial = $result['codigo_factura'];
									$secuencial = $secuencial+1;
								}else {
									$secuencial =1;
								}

								$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor)
								VALUES('$secuencial','00000000','$iduser') ");
									//echo '<script>alert("CLAVE DE ACCESO YA GENERADA, SE INSERTO UN REGISTRO EN NUESTRA BASE DE DATOS. GENERE DE NUEVO ESTA FACTURA '.$clave_acc_guardar.' ");</script>';

									$arrayName = array('noticia'=>'clave_duplicada','clave'=>$clave_acc_guardar);
									echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

							}
							if ($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"]=='ERROR SECUENCIAL REGISTRADO') {
								$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY fecha DESC");
								$result = mysqli_fetch_array($query);
								if ($result) {
									$secuencial = $result['codigo_factura'];
									$secuencial = $secuencial+1;
								}else {
									$secuencial =1;
								}


								$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor)
								VALUES('$secuencial','00000000','$iduser') ");
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
			echo 'cargar un comprobante';
		}
	}
}

?>
