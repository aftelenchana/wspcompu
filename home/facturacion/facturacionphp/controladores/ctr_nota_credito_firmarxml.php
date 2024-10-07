<?php
set_time_limit(300);
require_once './ctr_funcionesnotacredito.php';
require_once '../lib/nusoap.php';
//if (isset($_POST['submit'])) {
class autorizar {
	public function autorizar_xml($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$sucursal_facturacion) {
		include "../../../../coneccion.php";
			include "pdf_nota_credito.php";
		//SACAMOS INFORMACION DEL AMBITO
		$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
		$result_configuracion = mysqli_fetch_array($query_configuracioin);
		$ambito_area          =  $result_configuracion['ambito'];
		//SACAMOS INFORMACION DEL USUARIO
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
			if ($ambito_area == 'prueba') {
				$ruta_no_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\nota-credito\\no_firmados\\notacredito'.$iduser.'.xml';
				$ruta_si_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\nota-credito\\si_firmados\\';
				$ruta_autorizados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\nota-credito\\autorizados\\';
				$pathPdf = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\nota-credito\\pdf\\';
			}else {
				$ruta_no_firmados = '../comprobantes/nota-credito/no_firmados/notacredito'.$iduser.'.xml';
				$ruta_si_firmados = '../comprobantes/nota-credito/si_firmados/';
				$ruta_autorizados = '../comprobantes/nota-credito/autorizados/';
				$pathPdf = '../comprobantes/nota-credito/pdf/';
			}

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
				if ($ambito_area == 'prueba') {
					$comando = ('java -jar ../../firmaComprobanteElectronico/dist/firmaComprobanteElectronico.jar ' . $argumentos);
		   }else {
           	$comando = ('java -jar ../../firmaComprobanteElectronico/dist/firmaComprobanteElectronico.jar ' . $argumentos);
				}
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

					//	var_dump($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado']);


					//	echo "estamos intentando";

					//	echo var_dump($response).'<br>';
						//PONER UN MENSAJE IMPORTANTE

						$controlError = true;

						switch ($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado']) {
						case 'AUTORIZADO':
							$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
							$estado = $autorizacion['estado'];
							$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
							$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
							$comprobanteAutorizacion = $autorizacion['comprobante'];

							//echo '<script>alert("COMPROBANTE AUTORIZADO Y ENVIADO AL CORREO");</script>';

							//echo '<script>alert(Comprobante AUTORIZADO y enviado con exito con autoricacion N° '.$numeroAutorizacion.');</script>';
							$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
							//echo 'Xml ' .
							$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
									 $func->compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado);
		        	 $crecion = crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion);
					   	$func->correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado);
						  rename ('../comprobantes/nota-credito/no_firmados/notacredito'.$iduser.'.xml','../comprobantes/nota-credito/no_firmados/'.$clave_acc_guardar.'.xml');
							//unlink($ruta_si_firmados . $nuevo_xml);
							//require_once './funciones/factura_pdf.php';
							//var_dump($func);
							break;
						case 'EN PROCESO':
						$autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
						$estado = $autorizacion['estado'];
						$numeroAutorizacion = $autorizacion['numeroAutorizacion'];
						$fechaAutorizacion = $autorizacion['fechaAutorizacion'];
						$comprobanteAutorizacion = $autorizacion['comprobante'];


						//echo '<script>alert(Comprobante AUTORIZADO y enviado con exito con autoricacion N° '.$numeroAutorizacion.');</script>';
						$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
						//echo 'Xml ' .
						$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
							 $func->compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado);
						$crecion = crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion);
						$func->correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado);
						 rename ('../comprobantes/nota-credito/no_firmados/notacredito'.$iduser.'.xml','../comprobantes/nota-credito/no_firmados/'.$clave_acc_guardar.'.xml');

							break;
							case 'NO AUTORIZADO':

							if (isset($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional'])) {
								$mensajeError = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional'];
								//echo '<script>alert("'.$respuesta.' ");</script>';
								$arrayName = array('noticia'=>'error_no_autorizado','mensaje'=>$mensajeError);
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

								$query_insert=mysqli_query($conection,"INSERT INTO comprobante_nota_credito(secuencia,id_emisor,punto_emision,establecimiento,sucursal_facturacion)
								VALUES('$secuencial','$iduser','$punto_emision_sinceros','$establecimiento_sinceros','$sucursal_facturacion') ");
									//echo '<script>alert("CLAVE DE ACCESO YA GENERADA, SE INSERTO UN REGISTRO EN NUESTRA BASE DE DATOS. GENERE DE NUEVO ESTA FACTURA '.$clave_acc_guardar.' ");</script>';

									if ($query_insert) {
										$arrayName = array('noticia'=>'clave_duplicada_insertada','clave'=>$clave_acc_guardar);
										echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
										// code...
									}else {
										$arrayName = array('noticia'=>'clave_duplicada_no_insertada','clave'=>$clave_acc_guardar);
										echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
										// code...
									}



							}
							if ($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"]=='ERROR SECUENCIAL REGISTRADO') {


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

								$query_insert=mysqli_query($conection,"INSERT INTO comprobante_nota_credito(secuencia,id_emisor,punto_emision,establecimiento,sucursal_facturacion)
								VALUES('$secuencial','$iduser','$punto_emision_sinceros','$establecimiento_sinceros','$sucursal_facturacion') ");
									//echo '<script>alert("CLAVE DE ACCESO YA GENERADA, SE INSERTO UN REGISTRO EN NUESTRA BASE DE DATOS. GENERE DE NUEVO ESTA FACTURA '.$clave_acc_guardar.' ");</script>';

									if ($query_insert) {
										$arrayName = array('noticia'=>'secuencial_insertada','secuencial'=>$numDocModificado);
										echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
										// code...
									}else {
										$arrayName = array('noticia'=>'secuencial_no_insertada','secuencial'=>$numDocModificado);
										echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
										// code...
									}
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
