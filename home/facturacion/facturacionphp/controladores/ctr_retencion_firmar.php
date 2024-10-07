<?php
set_time_limit(300);
require_once './ctr_funciones_retencion.php';
require_once '../lib/nusoap.php';
//if (isset($_POST['submit'])) {
class autorizar {
	public function autorizar_xml($codigo_retencion,$porcentaje_retencion,$codigo_compra,$clave_acceso_factura) {
		include "../../../../coneccion.php";
			include "pdf_retencion.php";
		//SACAMOS INFORMACION DEL AMBITO
		$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
		$result_configuracion = mysqli_fetch_array($query_configuracioin);
		$ambito_area          =  $result_configuracion['ambito'];
		//SACAMOS INFORMACION DEL USUARIO
	 $iduser= $_SESSION['id'];
			$queryemisor = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
			$resulemisor = mysqli_fetch_array($queryemisor);
			$codigo_sri        = $resulemisor['codigo_sri'];
			$firma_electronica = $resulemisor['firma_electronica'];



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
			if ($ambito_area == 'prueba') {
				$ruta_no_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\retencion\\no_firmados\\retencion'.$iduser.'.xml';
				$ruta_si_firmados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\retencion\\si_firmados\\';
				$ruta_autorizados = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\retencion\\autorizados\\';
				$pathPdf = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\retencion\\pdf\\';
			}else {
				$ruta_no_firmados = '../comprobantes/retencion/no_firmados/notacredito'.$iduser.'.xml';
				$ruta_si_firmados = '../comprobantes/retencion/si_firmados/';
				$ruta_autorizados = '../comprobantes/retencion/autorizados/';
				$pathPdf = '../comprobantes/retencion/pdf/';
			}

			$tipo = 'FV';
			date_default_timezone_set("America/Lima");
			$fecha_actual = date('d-m-Y H:m:s', time());
			$codigo_factura = $iduser.md5(date('d-m-Y H:m:s')).$iduser;
			$acceso_no_firmados = simplexml_load_file($ruta_no_firmados);
			$claveAcceso_no_firmado['claveAccesoComprobante'] = substr($acceso_no_firmados->infoTributaria[0]->claveAcceso, 0, 49);
			$clave_acc_guardar = implode($claveAcceso_no_firmado);


			//$func = new fac_ele();
			//$crecion = crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);
			//$arrayName = array('noticia'=>'insert_correct','clave'=>$clave_acc_guardar);
			//echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

		//	exit;




			$nuevo_xml = ''.$clave_acc_guardar.'.xml';
			$controlError = false;
			$m = '';
			$show = '';
			//VERIFICAMOS SI EXISTE EL XML NO FIRMADO CREADO
			if (file_exists($ruta_no_firmados)) {
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

							//echo '<script>alert("COMPROBANTE AUTORIZADO Y ENVIADO AL CORREO");</script>';

							//echo '<script>alert(Comprobante AUTORIZADO y enviado con exito con autoricacion N° '.$numeroAutorizacion.');</script>';
							$vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 5);
							//echo 'Xml ' .
							$func->crearXmlAutorizado($estado, $numeroAutorizacion, $fechaAutorizacion, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
							$func->compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);
		        	$crecion = crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);
							$func->correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);


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
						$func->compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);
						$crecion = crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);
						$func->correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar);

							break;
							case 'NO AUTORIZADO':
							$arrayName = array('noticia'=>'no_autorizado');
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
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
