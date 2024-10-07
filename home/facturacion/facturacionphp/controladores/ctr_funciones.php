<?php
include "../../../../coneccion.php";
include '../lib/PHPMailer/PHPMailerAutoload.php';



class fac_ele{

	  private $URL_RECE_SRI_1 = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
    private $URL_RECE_SRI_2 = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
    private $URL_AUTO_SRI_1 = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
    private $URL_AUTO_SRI_2 = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';



    function comprobantes($directorio) {
        // Array en el que obtendremos los resultados
        $res = array();
        // Agregamos la barra invertida al final en caso de que no exista
        if (substr($directorio, -1) != "/"){$directorio .= "/";}
        // Creamos un puntero al directorio y obtenemos el listado de archivos
        $dir = @dir($directorio) or die("getFileList: Error abriendo el directorio $directorio para leerlo");
        while (($archivo = $dir->read()) !== false) {
            // Obviamos los archivos ocultos
            if ($archivo[0] == "."){continue;}
            if (is_dir($directorio . $archivo)) {
                $res[] = $archivo;
            } else if (is_readable($directorio . $archivo)) {
                $res[] = $archivo;
            }
        }
        $dir->close();
        return $res;
    }

    function wsdl($ambiente){
        $wsdl_rece_aut = Array('recepcion'=>'',
                               'autorizacion'=>'');
        if($ambiente == 1){
            $wsdl_rece_aut['recepcion'] = $this->URL_RECE_SRI_1;
            $wsdl_rece_aut['autorizacion'] = $this->URL_AUTO_SRI_1;
        }else{
            $wsdl_rece_aut['recepcion'] = $this->URL_RECE_SRI_2;
            $wsdl_rece_aut['autorizacion'] = $this->URL_AUTO_SRI_2;
        }
        return $wsdl_rece_aut;
    }

    function crearXmlAutorizado($estado,$numeroAutorizacion,$fechaAutorizacion,$comprobanteAutorizacion,$ruta_autorizados,$nuevo_xml){
        $xml = new DOMDocument();
        $xml_autor = $xml->createElement('autorizacion');
        $xml_estad = $xml->createElement('estado', $estado);
        $xml_nauto = $xml->createElement('numeroAutorizacion', $numeroAutorizacion);
        $xml_fauto = $xml->createElement('fechaAutorizacion', $fechaAutorizacion);
        $xml_compr = $xml->createElement('comprobante');
        $xml_autor->appendChild($xml_estad);
        $xml_autor->appendChild($xml_nauto);
        $xml_autor->appendChild($xml_fauto);
        $xml_compr->appendChild($xml->createCDATASection($comprobanteAutorizacion));
        $xml_autor->appendChild($xml_compr);
        $xml->appendChild($xml_autor);
        $ms = $xml->save($ruta_autorizados . $nuevo_xml);
        chmod($ruta_autorizados.$nuevo_xml, 0755);
        return $ms;
    }

    function recepcion($xmlname){
        $srtxmlfirmado = file_get_contents($this->PATH_XML_FIRMADO.$xmlname);
        $data['xml'] = base64_encode($srtxmlfirmado);
        try{
            $client = new nusoap_client(wsdl('S'), true);
            $client->soap_defencoding = 'utf-8';
            $client->xml_encoding = 'utf-8';
            $client->decode_utf8 = false;
            $response = $client->call('validarComprobante', $data);
        }catch(Exception $e){
            $response = "Error!<br>";
            $response .= $e->getMessage().'<br>';
            $response .= 'Last response: ' . $client->response . '<br>';
        }
        return $response;
    }




    function correos($clave_acc_guardar,$codigo_factura_SC,$numDocModificado){



			$codigo_factura = $codigo_factura_SC;
try{
	include "../../../../coneccion.php";
	mysqli_set_charset($conection, 'utf8'); //linea a colocar
	$iduser= $_SESSION['id'];
	$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
		WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura'  ORDER BY id DESC  ");
		  $data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
		  $email_receptor = $data__emmisor['email_reeptor'];

			$nombres_receptor = $data__emmisor['nombres_receptor'];
			$celular_receptor = $data__emmisor['celular_receptor'];

			$id_receptor = $data__emmisor['id_receptor'];


			$query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
			'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
			SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
			FROM `comprobantes`
			WHERE comprobantes.id_emisor = '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'");
			$data_lista_t=mysqli_fetch_array($query_lista_t) ;
			$compra_total = $data_lista_t['compra_total'];
			$iva_general = $data_lista_t['iva_general'];
			$iva_general = $data_lista_t['iva_general'];
			$descuento_total = $data_lista_t['descuento_total'];
			$valor_total = $data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'];
			$valor_total = round($valor_total, 2);




			$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
			$result_documentos = mysqli_fetch_array($query_doccumentos);
			$img_logo                = $result_documentos['img_facturacion'];
			$url_img_upload           = $result_documentos['url_img_upload'];
			$email                    = $result_documentos['email'];
			$celular                  = $result_documentos['celular'];
			$telefono                 = $result_documentos['telefono'];
			$direccion                = $result_documentos['direccion'];
			$nombre_empresa           = $result_documentos['nombre_empresa'];
			$razon_social             = $result_documentos['razon_social'];

			//codigo para saber como va el emisor
			if (empty($nombre_empresa) || $nombre_empresa == '0') {
				$nombre_salida = $razon_social;
			}else {
				$nombre_salida = $nombre_empresa;
			}

			//redes

			$facebook                = $result_documentos['facebook'];
			$instagram           = $result_documentos['instagram'];
			$whatsapp             = $result_documentos['whatsapp'];



			if (!empty($facebook)) {
				$facebook = '<a style="text-align: center; margin:3px; padding4px;" href="'.$facebook.'"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="30px;"></a>';
			}else {
				$facebook = '';
			}

			if (!empty($instagram)) {
				$instagram = '<a style="text-align: center; margin:3px; padding4px;" href="'.$instagram.'"> <img src="https://guibis.com/home/img/reacciones/instagram.png" alt="" width="30px;"></a>';
			}else {
				$instagram = '';
			}

			if (!empty($whatsapp)) {
				$whatsapp = '<a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;'.$nombre_salida.'&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="30px;"></a>';
			}else {
				$whatsapp = '';
			}


			$host_envio                 = $result_documentos['host_envio'];
			$puerto_email_envio         = $result_documentos['puerto_email_envio'];
			$email_user_name_envio      = $result_documentos['email_user_name_envio'];
			$password_envio_email       = $result_documentos['password_envio_email'];
			$descripcion_envio_email    = $result_documentos['descripcion_envio_email'];


			if (empty($host_envio)) {
				$host_envio = 'mail.guibis.com';
			}
			if (empty($puerto_email_envio)) {
				$puerto_email_envio = '465';
			}
			if (empty($password_envio_email)) {
				$password_envio_email = 'MACAra666_';
			}
			if (empty($email_user_name_envio)) {
				$email_user_name_envio = 'prueba_registro@guibis.com';
			}
			if (empty($descripcion_envio_email)) {
				$descripcion_envio_email = '';
			}

			//fechas
			$fecha_actual = date("d-m-Y");
			$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

    $filep = '../comprobantes/pdf/'.$clave_acc_guardar.'.pdf';

    $filex = '../comprobantes/autorizados/'.$clave_acc_guardar.'.xml';
    // Creamos una nueva instancia
		$mail = new PHPMailer();
    // Activamos el servicio SMTP
    $mail->isSMTP();
    // Activamos / Desactivamos el "debug" de SMTP (Lo activo para ver en el HTML el resultado)
    // 0 = Apagado, 1 = Mensaje de Cliente, 2 = Mensaje de Cliente y Servidor
    $mail->SMTPDebug = 0;
    // Log del debug SMTP en formato HTML
    $mail->Debugoutput = 'html';
		// Servidor SMTP (para este ejemplo utilizamos gmail)
    $mail->Host = $host_envio;
    // Puerto SMTP
    $mail->Port = $puerto_email_envio ;
    // Tipo de encriptacion SSL ya no se utiliza se recomienda TSL
    $mail->SMTPSecure = 'ssl';
    // Si necesitamos autentificarnos
    $mail->SMTPAuth = true;
    // Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com)
    $mail->Username = $email_user_name_envio;
    // Contraseña
    $mail->Password = $password_envio_email;

		$mail -> setFrom ( $email_user_name_envio , 'Sistema de Facturación' );
    $mail->addAddress('factura@facturacion.guibis.com');

		$query_lista = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email
			 WHERE lista_correos_envios_email.iduser ='$iduser'  AND lista_correos_envios_email.estatus = '1'
		ORDER BY `lista_correos_envios_email`.`fecha` DESC ");
     $result_lista= mysqli_num_rows($query_lista);
		if ($result_lista > 0) {
					while ($data_lista=mysqli_fetch_array($query_lista)) {
						$mail->addAddress($data_lista['correo']);
					}
			}

      //CODIGO PARA SACAR LOS EMAIL DEL CLIENTE
			$query__correos_email = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email_cliente
				 WHERE lista_correos_envios_email_cliente.iduser ='$iduser'  AND lista_correos_envios_email_cliente.estatus = '1' AND lista_correos_envios_email_cliente.cliente = '$id_receptor'
			ORDER BY `lista_correos_envios_email_cliente`.`fecha` DESC ");
			 $result__email= mysqli_num_rows($query__correos_email);
			if ($result__email > 0) {
						while ($data_email=mysqli_fetch_array($query__correos_email)) {
							$mail->addAddress($data_email['correo']);
						}
					}


		$mail->addAddress($email_receptor);
		$mail->addAddress($email);
    $mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
    $mail->AddAttachment($filex, ''.$clave_acc_guardar.'.xml');
		$mail->CharSet = 'UTF-8';
    $mail->Subject = 'Factura Electrónica';
    //Creamos el mensaje
    $message =
 '
		<body>


			<div class="conte_general" style="text-align: center;background: #f5f5f5;border-radius: 10px;">
				<div class="contenedor_image">
					<img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" width="150px;" alt="">
				</div>
				<div class="redes_email" style="text-align: center;">
				'.$facebook.'
				'.$instagram.'
				'.$whatsapp.'

		</div>
		<div style="margin: 0; padding: 0;">
				<p style="margin: 5px 0;">'.$direccion.'</p>
		</div>
		<div style="margin: 0; padding: 0;">
			<strong><p style="margin: 5px 0;">'.$celular.' '.$telefono.'</p></strong>

		</div>

				<div class="contenedor_informacion_factura">
					<table style="margin: 0 auto;width: 80%;">
						<tr>
							<td></td>
							<td><hr></td>
						</tr>
						<tr>
							<td> <strong>DESTINATARIO:</strong> </td>
							<td>
								<div style="margin: 0; padding: 0;">
							<strong style="display: block; margin: 5px 0;background: #d8d6d5;">'.$nombres_receptor.'</strong>
								</div>
							<div style="margin: 0; padding: 0;">
									<p style="margin: 5px 0;font-size: 12px;">Has recibido una Factura de:</p>
							</div>
							</td>
						</tr>
						<tr>
							<td> <strong>EMISOR</strong> </td>
							<td style="background: #d8d6d5;"> <strong>'.$nombre_salida.'</strong> </td>
						</tr>
						<tr>
							<td>  </td>
							<td> <hr>  </td>
						</tr>
						<tr>
							<td> <strong>FACTURA:</strong> </td>
							<td> '.$numDocModificado.' </td>
						</tr>
						<tr>
							<td> <strong>FECHA EMISION:</strong> </td>
							<td>'.$fecha_actual.'</td>
						</tr>

						<tr>
							<td> <strong>VALOR:</strong> </td>
							<td>Por el Valor de</td>
						</tr>
						<tr>
							<td></td>
							<td style="font-size: 25px;background: #d8d6d5;"> <strong>$'.$valor_total.'</strong> </td>
						</tr>
						<tr>
							<td>  </td>
							<td> <hr>  </td>
						</tr>
						<tr>
							<td> </td>
							<td style="font-size: 10px;">'.$descripcion_envio_email.'</td>
						</tr>
						<tr>
							<td> </td>
							<td style="font-size: 10px;">Descarga tus documentos electrónicos en el siguiente  <a href="https://guibis.com/mis_facturas">Enlace</a> </td>
						</tr>
					</table>
				</div>
			</div>
		</body>

        ';


				if (substr($celular_receptor, 0, 4) === '+593') {
						$celular_receptor = substr($celular_receptor, 1);
				}

				// Verifica si el número ya tiene el prefijo '593'
				if (substr($celular_receptor, 0, 3) !== '593') {
						// Verifica si comienza con '09' o tiene 9 dígitos y agrega '593'
						if (substr($celular_receptor, 0, 2) === '09' || strlen($celular_receptor) === 9) {
								$celular_receptor = '593' . substr($celular_receptor, (strlen($celular_receptor) == 9 ? 0 : 1));
						}
				}

				 if (strlen($celular_receptor) > 11) {

					 $query_producto = "SELECT ventas.fecha_inicio_venta,ventas.fecha_limite_suscripcion,ventas.estado,producto_venta.meses_suscripcion,ventas.cantidad_producto as 'cantidad' FROM ventas
					 INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
					 INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
						WHERE ventas.idp ='5136' AND ventas.id_comprador = '$iduser' ";
					 $result_producto = mysqli_query($conection, $query_producto);
						 $existencia_venta = mysqli_num_rows($result_producto);
						 if ($existencia_venta>0) {
							 $data_producto = mysqli_fetch_array($result_producto);
							 $cantidad =  $data_producto['cantidad'];
							 $sql_cantidad_mensajes = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_mensajes  FROM
							 envio_mensajes WHERE envio_mensajes.iduser =  '$iduser' AND envio_mensajes.producto ='5136'");
							 $data_cantidad_mensajes = mysqli_fetch_array($sql_cantidad_mensajes);
							 $cantidad_mensajes      = $data_cantidad_mensajes['cantidad_mensajes'];

								 $mensajes_existentes = $cantidad - $cantidad_mensajes;

							 if ($cantidad > $cantidad_mensajes ) {


								 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;

								 $mensaje = "*FACTURA*\n\n";

								 $mensaje .= "*DESTINATARIO:* " . $nombres_receptor . "\n";
								 $mensaje .= "Has recibido una Factura de:\n";

								 $mensaje .= "*EMISOR:* " . $nombre_salida . "\n";
								 $mensaje .= "*FACTURA:* " . $numDocModificado . "\n";
								 $mensaje .= "*FECHA EMISION:* " . $fecha_actual . "\n";
								 $mensaje .= "*VALOR:* Por el Valor de $" . $valor_total . "\n\n";


								 $mensaje .= "PDF: ".$url2."/home/facturacion/facturacionphp/comprobantes/pdf/".$clave_acc_guardar.".pdf \n";
								 $mensaje .= "XML: ".$url2."/home/facturacion/facturacionphp/comprobantes/autorizados/".$clave_acc_guardar.".xml \n";

								 $mensaje .= "Mira tus facturas en : https://usuario.guibis.com\n";

								 // URL de la API a la que te quieres conectar
									 $url = 'http://whatsapp.guibis.com:3001/send-message';

									 // Los datos que quieres enviar en formato JSON
									 $data = array(
											 'number' => $celular_receptor,
											 'message' => $mensaje
									 );
									 $data_json = json_encode($data);

									 // Inicializa cURL
									 $ch = curl_init($url);

									 // Configura las opciones de cURL para POST
									 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									 curl_setopt($ch, CURLOPT_POST, true);
									 curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
									 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
											 'Content-Type: application/json',
											 'Content-Length: ' . strlen($data_json)
									 ));

									 // Ejecuta la sesión cURL
									 $response = curl_exec($ch);


									 // Verifica si hubo un error en la solicitud
									 if(curl_errno($ch)){
											 throw new Exception(curl_error($ch));
									 }

									 // Cierra la sesión cURL
									 curl_close($ch);



								 // Decodifica la respuesta JSON y la imprime
								 $responseData = json_decode($response, true);
								 if (isset($responseData['success']) && $responseData['success'] === true) {
									 $query_insert_historial=mysqli_query($conection,"INSERT INTO envio_mensajes(iduser,producto,mensaje,numero_wsp)
																						 VALUES('$iduser','5136','$mensaje','$celular_receptor') ");

									 $estado_wsp = 'Mensaje por WhatsApp Enviado restantes '.$mensajes_existentes.'';
								 }else {
									 $estado_wsp = 'Mensaje por WhatsApp no Enviado '.$response.' ';
								 }

							 }else {
								 $estado_wsp = 'Te has quedado sin mensajes en tu paquete';
								 // code...
							 }

						 }else {
							 $estado_wsp = 'No tienes Contratado el paquete de WhatsApp para el envio';
						 }

					// code...
				}else {
					$estado_wsp = 'Agregar número de WhatsApp del Cliente para envio de mensaje';
					// code...
				}







    //Agregamos el mensaje al correo
    $mail->msgHTML($message);
    // Enviamos el Mensaje
    if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
		$arrayName = array('noticia'=>'factura_exitosa','factura'=>$clave_acc_guardar,'correo'=>'no_enviado','codigo_factura_SC'=>$codigo_factura_SC,'numDocModificado'=>$numDocModificado,'msg_wsp'=>$estado_wsp);
		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    } else {
			$arrayName = array('noticia'=>'factura_exitosa','factura'=>$clave_acc_guardar,'correo'=>'enviado_correctamente','codigo_factura_SC'=>$codigo_factura_SC,'numDocModificado'=>$numDocModificado,'msg_wsp'=>$estado_wsp);
			echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
    }catch(Exception $e){return "Ocurrio un error ".$e;}
}

function compr_final($clave_acc_guardar,$codigo_factura_SC,$numDocModificado,$fechaAutorizacion){

  include "../../../../coneccion.php";

	if ($_SESSION['rol'] == 'cuenta_empresa') {
	include "../../../sessiones/session_cuenta_empresa.php";

	}

	if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
	include "../../../sessiones/session_cuenta_usuario_venta.php";

	}

	if ($_SESSION['rol'] == 'Mesero') {
	include "../../../sessiones/session_cuenta_mesero.php";

	}

	if ($_SESSION['rol'] == 'Cocina') {
	include "../../../sessiones/session_cuenta_cocina.php";
	}

	$rol_user = $_SESSION['rol'];



  $query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
    WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'  ");
    $data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
    $id_receptor        = $data__emmisor['id_receptor'];
    $nombres_receptor   = $data__emmisor['nombres_receptor'];
    $precio_neto        = $data__emmisor['precio_neto'];
    $descripcion        = $data__emmisor['descripcion_producto'];
    $direccion_receptor = $data__emmisor['direccion_reeptor'];
    $celular_receptor   = $data__emmisor['celular_receptor'];
    $email_receptor     = $data__emmisor['email_reeptor'];
    $numero_identidad_receptor = $data__emmisor['numero_identidad_receptor'];
		$tipo_identificacion = $data__emmisor['tipo_identificacion'];
		$cantidad_producto = $data__emmisor['cantidad_producto'];
		$limpiar_consola = $data__emmisor['limpiar_consola'];
		$estado_financiero = $data__emmisor['estado_financiero'];
		$modulo = $data__emmisor['modulo'];
		$sucursal_facturacion   = $data__emmisor['sucursal_facturacion'];


				  $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
					$data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

					$direccion_sucursal        = $data_sucursal['direccion_sucursal'];

					$establecimiento_sinceros        = $data_sucursal['establecimiento'];
				  $punto_emision_sinceros        = $data_sucursal['punto_emision'];


					//codigo para sacar el secuencial

					$query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.punto_emision ='$punto_emision_sinceros'
						AND comprobante_factura_final.establecimiento ='$establecimiento_sinceros' ORDER BY fecha DESC");
					 $result_secuencia = mysqli_fetch_array($query_secuencia);
					 if ($result_secuencia) {
						 $secuencial = $result_secuencia['codigo_factura'];
						 $secuencial = $secuencial +1;
						 // code...
					 }else {
						 $secuencial =1;
					 }

			$CODIGO_INTERNO_PEDIDO = $data__emmisor['CODIGO_INTERNO_PEDIDO'];
 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;
		$query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
		'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
		SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(((comprobantes.descuento))) AS 'descuento_general'
		FROM `comprobantes`
		WHERE comprobantes.id_emisor = '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'  ");
		$data_lista_t=mysqli_fetch_array($query_lista_t);

		$descuento_general = round(($data_lista_t['descuento_general']),2);
		$precio_12_iva = round(($data_lista_t['iva_general']),2);
		$precio_88_iva = round(($data_lista_t['compra_total']),2);
		$precio_total  = round( $precio_12_iva+$precio_88_iva-$descuento_general,2);

    $query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,id_emisor,id_receptor,nombres_receptor,cedula_receptor,email_receptor,
			precio_neto,descripcion,direccion_receptor,celular_receptor,clave_acceso,tipo_identificacion,subtotal,iva,total,comprobante,descuento_general,
			modulo,CODIGO_INTERNO_PEDIDO,url_file_upload,secuencia,codigo_comprobante,sucursal_facturacion,establecimiento,punto_emision,IDROLPUNTOVENTA,rol,fechaAutorizacion)
    VALUES('$secuencial','$iduser','$id_receptor','$nombres_receptor','$numero_identidad_receptor','$email_receptor',
			'$precio_neto','$descripcion','$direccion_receptor','$celular_receptor','$clave_acc_guardar','$tipo_identificacion','$precio_88_iva','$precio_12_iva','$precio_total',
			'factura','$descuento_general','$modulo','$CODIGO_INTERNO_PEDIDO','$url2','$numDocModificado','$codigo_factura_SC','$sucursal_facturacion','$establecimiento_sinceros','$punto_emision_sinceros','$id_generacion','$rol_user','$fechaAutorizacion') ");

			//CAMBIAR A ESTADO DE FINALIZADO

			 $query_cambiar_estado=mysqli_query($conection,"UPDATE comprobantes SET estado= 'FINALIZADO'  WHERE id_emisor = '$iduser'  AND secuencial = '$codigo_factura_SC'  ");

				//CODIGO PARA DISMINUIR LA CANTIDAD DE LOS PRODUCTOS EXISTENTES
				$query_actualizar_cantidad = mysqli_query($conection,"SELECT * FROM comprobantes
					WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura_SC'  ");
			 while ($resultados_actualizar = mysqli_fetch_array($query_actualizar_cantidad)) {
					 if ($resultados_actualizar['id_producto'] != '0') {
						 $id_producto = $resultados_actualizar['id_producto'];
						 $cantidad_vende = $resultados_actualizar['cantidad_producto'];

						 $query_resultados_productos = mysqli_query($conection,"SELECT * FROM producto_venta   WHERE idproducto= '$id_producto'");
						 $resultados_producto = mysqli_fetch_array($query_resultados_productos);
						 $cantidad_existente = $resultados_producto['cantidad'];
						 if ($cantidad_existente == '' || $cantidad_existente == '0') {
							 $cantidad_existente=$cantidad_vende;
						 	// code...
						 }
						 $cantidad_new = $cantidad_existente-$cantidad_vende;
						 $query_edit_cantidad = mysqli_query($conection,"UPDATE producto_venta SET cantidad='$cantidad_new' WHERE idproducto = '$id_producto'");
						 $query_insert_cantidad=mysqli_query($conection,"INSERT INTO inventario(cantidad,motivo,detalles_extras,idproducto,iduser,cantidad_new,accion )
																																				 VALUES('$cantidad_vende','VENTA SISTEMA','FACTURA','$id_producto','$iduser','$cantidad_new','DISMINUIR') ");

					 }
				}






}





}
