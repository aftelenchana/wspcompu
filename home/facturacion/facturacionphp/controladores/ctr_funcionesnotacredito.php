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


    function correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado){
try{
	include "../../../../coneccion.php";
	mysqli_set_charset($conection, 'utf8'); //linea a colocar

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

	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];

	//codigo para sacar la infoamcion de la factura
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
	$numDocModificado_factura_hecha_nota_credito  = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';

	//informacion del comprador



	  $identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
	  $tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
	  $razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
	  $obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
	  $fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
	  $totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
	  $totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
	  $totalDescuento                = $acceso_factura->infoFactura->totalDescuento;

	  $dirEstablecimiento                = $acceso_factura->infoFactura->dirEstablecimiento;

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


	//Codigo para sacar informacion de la sucursal
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
	 $secuencial_bota_credito = str_pad($secuencial, 9, "0", STR_PAD_LEFT);




	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];

	$iduser= $_SESSION['id'];

	$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
	$result_documentos = mysqli_fetch_array($query_doccumentos);
	$img_logo                = $result_documentos['img_facturacion'];
	$url_img_upload           = $result_documentos['url_img_upload'];
	$email                = $result_documentos['email'];
	$celular                = $result_documentos['celular'];
	$telefono                = $result_documentos['telefono'];
	$direccion                = $result_documentos['direccion'];
	$nombre_empresa                = $result_documentos['nombre_empresa'];
	$razon_social                = $result_documentos['razon_social'];

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
			$rrr= ($acceso_factura->infoAdicional->campoAdicional);
		 foreach($rrr as $Item){
			 $atrinuto = (string)$acceso_factura->infoAdicional->campoAdicional[0];
			 $posicion_coincidencia = strpos($atrinuto, '@');
			 if ($posicion_coincidencia === false) {
				 $email_receptor = 'guibis-ecuador@guibis.com';

			 } else {
			 $email_receptor_uwu   =$atrinuto;
			 }
			 }

			//INFORMACION DEL DOCUMENTO
		$codDocModificado                = $acceso_factura->infoTributaria->codDoc;


    $file_pdf_nota_credito = '../comprobantes/nota-credito/pdf/'.$clave_acc_guardar.'.pdf';
		$filex_xml_nota_credito = '../comprobantes/nota-credito/autorizados/'.$clave_acc_guardar.'.xml';
		$file_pdf_factura = '../comprobantes/nota-credito/pdf/'.$clave_acc_guardar.'.pdf';
		$filex_xml_factura = '../comprobantes/nota-credito/autorizados/'.$clave_acc_guardar.'.xml';

    //$filex = '../comprobantes/autorizadosnotacredito/'.$clave_acc_guardar.'.xml';
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
    //Añadimos la direccion de quien envia el corre, en este caso
    //YARR Blog, primero el correo, luego el nombre de quien lo envia.
    $mail->setFrom($email_user_name_envio, 'Sistema de Facturación ');
    $mail->addAddress('factura@facturacion.guibis.com');
		$mail->addAddress($email_receptor_uwu);
		$mail->addAddress($email);

		$query_lista = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email
			 WHERE lista_correos_envios_email.iduser ='$iduser'  AND lista_correos_envios_email.estatus = '1'
		ORDER BY `lista_correos_envios_email`.`fecha` DESC ");
		 $result_lista= mysqli_num_rows($query_lista);
		if ($result_lista > 0) {
					while ($data_lista=mysqli_fetch_array($query_lista)) {
						$mail->addAddress($data_lista['correo']);
					}
			}

    $mail->AddAttachment($file_pdf_nota_credito, ''.$clave_acc_guardar.'.pdf');
		$mail->AddAttachment($filex_xml_nota_credito, ''.$clave_acc_guardar.'.xml');
		$mail->AddAttachment($file_pdf_factura, ''.$clave_acceso_factura.'.pdf');
		$mail->AddAttachment($filex_xml_factura, ''.$clave_acceso_factura.'.xml');
		$mail->Subject = 'Nota de Crédito';
		$mail->CharSet = 'UTF-8';
		// Creamos el mensaje
		$message = '
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
							<strong style="display: block; margin: 5px 0;background: #d8d6d5;">'.$razon_social_comprador.'</strong>
								</div>
							<div style="margin: 0; padding: 0;">
									<p style="margin: 5px 0;font-size: 12px;">Has recibido una Nota de Crédito de:</p>
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
							<td> <strong>NOTA DE CRÉDITO:</strong> </td>
							<td> '.$numDocModificado.' </td>
						</tr>
						<tr>
							<td> <strong>MOTIVO:</strong> </td>
							<td> '.$razon_modficiacion.' </td>
						</tr>
						<tr>
							<td> <strong>FECHA EMISION:</strong> </td>
							<td>'.$fecha_actual.'</td>
						</tr>

						<tr>
							<td> <strong>VALOR:</strong> </td>
							<td>Valor de Nota de Crédito</td>
						</tr>
						<tr>
							<td></td>
							<td style="font-size: 25px;background: #d8d6d5;"> <strong>$'.$nomnto_modificacion.'</strong> </td>
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

    //Agregamos el mensaje al correo
    $mail->msgHTML($message);
    // Enviamos el Mensaje
    if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
		$arrayName = array('noticia'=>'envio_exitoso','correo'=>'no_enviado','clave_acceso'=>$clave_acc_guardar);
		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    } else {
			$arrayName = array('noticia'=>'envio_exitoso','correo'=>'enviado_correctamente','clave_acceso'=>$clave_acc_guardar);
			echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }
    }catch(Exception $e){return "Ocurrio un error ".$e;}
}

function compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion,$numDocModificado){
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



	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];


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
	 $secuencial_bota_credito = str_pad($secuencial, 9, "0", STR_PAD_LEFT);


	//CODIGO PARA SACAR LA INFORMACION

	if ($ambito_area == 'prueba') {
		$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

	}else {
		$query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$clave_acceso_factura' ");
		$data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
		$ininterno = $data_existencia['id'];
		$url_file_upload = $data_existencia['url_file_upload'];

		 $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
	}
  $iduser= $_SESSION['id'];

	$acceso_factura = simplexml_load_file($ruta_factura);
	$codDocModificado                = $acceso_factura->infoTributaria->codDoc;

	 //para crear el numero dl documento necesito de 4 partes
		$estab                       = $acceso_factura->infoTributaria->estab;
		$ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
		$secuencial_factura                  = $acceso_factura->infoTributaria->secuencial;
	$numDocModificado_factura                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial_factura.'';


	$identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
	$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
	$razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
	$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
	$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;


	$identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
	$tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
	$razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
	$obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
	$fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
	$totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
	$totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
	$totalDescuento                = $acceso_factura->infoFactura->totalDescuento;

	$dirEstablecimiento                = $acceso_factura->infoFactura->dirEstablecimiento;

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

	 $query_veri_ruc = mysqli_query($conection, "SELECT * FROM clientes WHERE identificacion= '$identificacion_comprador' ORDER BY id DESC");
   $result_lista_ruc = mysqli_num_rows($query_veri_ruc);

   if ($result_lista_ruc > 0) {
       // Cliente encontrado en la base de datos
       $data_cliente = mysqli_fetch_array($query_veri_ruc);
       $direccion_comprador = $data_cliente['direccion'];
       $celular_comprador = $data_cliente['celular'];
       $email_comprador = $data_cliente['mail'];
       $id_comprador = $data_cliente['id'];
   } else {
       // Cliente no encontrado en la base de datos, buscar información externa
       $query_user_in = mysqli_query($conection, "SELECT * FROM usuarios WHERE id = '$user_in'");
       $data_user_in = mysqli_fetch_array($query_user_in);
       $key_user_in = $data_user_in['id_e'];
       $datos_ruc = json_decode(file_get_contents('https://www.guibis.com/dev/ruc?key='.$key_user_in.'&callback=all&CIRUC='.$identificacion_comprador), true);

       if ($datos_ruc['noticia'] == 'consulta_exitosa') {
           // Datos obtenidos de la consulta externa
           $direccion_comprador = $datos_ruc['DIRECCION'];
           $celular_comprador = $datos_ruc['CELULAR'];
           $email_comprador = $datos_ruc['EMAIL'];
					 $id_comprador = '';
       } else {
           // No se encontraron datos ni en la base de datos ni en la consulta externa
           $direccion_comprador = '';
           $celular_comprador = '';
           $email_comprador = '';
					 $id_comprador = '';
       }
   }


 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

 $query_cambiar_estado=mysqli_query($conection,"UPDATE comprobante_factura_final SET codigo_factura_credito= '$clave_acc_guardar',estado= 'ANULADO'  WHERE clave_acceso='$clave_acceso_factura'  ");



	$query_insert=mysqli_query($conection,"INSERT INTO comprobante_nota_credito(id_emisor,secuencia,secuencial_sri,id_receptor,clave_acceso,clave_acceso_factura,monto_modificacion,razon_social_cliente,email_receptor,identificacion_receptor,direccion_receptor,celular_receptor,tipo_identificacion,razon_modificacion,IDROLPUNTOVENTA,rol,
																																			url_file_upload,sucursal_facturacion,establecimiento,punto_emision)
	                                                                    VALUES('$iduser','$secuencial','$numDocModificado','$id_comprador','$clave_acc_guardar','$clave_acceso_factura','$nomnto_modificacion','$razon_social_comprador','$email_comprador','$identificacion_comprador','$direccion_comprador','$celular_comprador','$tipo_identificacion_comprador','$razon_modficiacion','$user_in','$rol_user',
																																			'$url','$sucursal_facturacion','$establecimiento_sinceros','$punto_emision_sinceros') ");









}

}
