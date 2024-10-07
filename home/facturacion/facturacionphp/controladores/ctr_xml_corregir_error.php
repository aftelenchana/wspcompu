<?php
include 'digito_verificador.php';
class xml{
	public function xmlFactura($iduser,$clave_acceso_factura){

		   include "../../../../coneccion.php";

        mysqli_set_charset($conection, 'utf8'); //linea a colocar

				//INFORMACION DE LA CONFIGURACION
				$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
				$result_configuracion = mysqli_fetch_array($query_configuracioin);
				$ambito_area          =  $result_configuracion['ambito'];


				//de qui empezamos a sacar la informacion
				if ($ambito_area == 'prueba') {
					$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

				}else {

					$query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$clave_acceso_factura' ");
					$data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
					$ininterno = $data_existencia['id'];
					$url_file_upload = $data_existencia['url_file_upload'];

				}
				$query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$clave_acceso_factura' ");
				$data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
				$ininterno = $data_existencia['id'];
				$url_file_upload = $data_existencia['url_file_upload'];
				$ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';


							$acceso_factura = simplexml_load_file($ruta_factura);

							// Obtener la clave de acceso y la fecha de emisión actuales
							$claveAccesoActual = (string)$acceso_factura->infoTributaria->claveAcceso;
							$fechaEmisionActual = (string)$acceso_factura->infoFactura->fechaEmision;


								 $ruta_factura_modificada = '../comprobantes/no_firmados/'.$iduser.'.xml';


							// Guardar los cambios en el archivo XML
							if ($acceso_factura->asXML($ruta_factura_modificada) === false) {

								}





			}
			}



			?>
