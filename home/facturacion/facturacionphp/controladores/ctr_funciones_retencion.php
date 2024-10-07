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


    function correos($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar){
try{
	include "../../../../coneccion.php";
	mysqli_set_charset($conection, 'utf8'); //linea a colocar

	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];

	$iduser= $_SESSION['id'];

			$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
			$result_documentos = mysqli_fetch_array($query_doccumentos);
			$img_logo                = $result_documentos['img_facturacion'];
			$url_img_upload           = $result_documentos['url_img_upload'];
			$email                = $result_documentos['email'];

			$host_envio                 = $result_documentos['host_envio'];
			$puerto_email_envio         = $result_documentos['puerto_email_envio'];
			$email_user_name_envio      = $result_documentos['email_user_name_envio'];
			$password_envio_email       = $result_documentos['password_envio_email'];
			$descripcion_envio_email    = $result_documentos['descripcion_envio_email'];
			if ($ambito_area == 'prueba') {
				$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

			}else {
				$ruta_factura = '../facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
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

    $filep = '../comprobantes/nota-credito/pdf/'.$clave_acc_guardar.'.pdf';
		$filex = '../comprobantes/nota-credito/autorizados/.'.$clave_acc_guardar.'.xml';

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
    $mail->setFrom($email_user_name_envio, 'Comprobante Autorizado SRI');
    $mail->addAddress('factura@facturacion.guibis.com');
		$mail->addAddress($email_receptor_uwu);
		$mail->addAddress($email);
    $mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
		$mail->AddAttachment($filex, ''.$clave_acc_guardar.'.xml');
		$mail->Subject = 'Nota de Crédito';
		$mail->CharSet = 'UTF-8';
		// Creamos el mensaje
		$message = '
		    <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
		        <div class="">
		            <div class="img_logo" style="text-align: center;">
		                <img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
		            </div>
		            <div class="">
		                <p style="text-align: justify;">Hola, se ha generado un comprobante electrónico en nuestro sistema. A continuación, están los archivos para que puedas descargarlos.</p>
		            </div>
		            <div class="">
		                <p style="text-align: justify;">'.$descripcion_envio_email.'.</p>
		            </div>
		        </div>
		        <div class="">
		            <div class="redes_email" style="text-align: center;">
		                <a style="text-align: center; margin:3px; padding:4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
		                <a style="text-align: center; margin:3px; padding:4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
		                <a style="text-align: center; margin:3px; padding:4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
		            </div>
		        </div>
		        <div class="">
		            <p style="font-size: 8px; color: grey;">Este mensaje se ha generado automáticamente por nuestro sistema de facturación, no respondas a este mensaje.</p>
		        </div>
		    </body>
		';

    //Agregamos el mensaje al correo
    $mail->msgHTML($message);
    // Enviamos el Mensaje
    if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
		$arrayName = array('noticia'=>'envio_exitoso','correo'=>'no_enviado');
		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    } else {
			$arrayName = array('noticia'=>'envio_exitoso','correo'=>'enviado_correctamente');
			echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }
    }catch(Exception $e){return "Ocurrio un error ".$e;}
}

function compr_final($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar){
  include "../../../../coneccion.php";
	$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
	$result_configuracion = mysqli_fetch_array($query_configuracioin);
	$ambito_area          =  $result_configuracion['ambito'];

	//CODIGO PARA INSERTA secuencial
	$nuevo_xml = ''.$clave_acc_guardar.'.xml';
	$iduser= $_SESSION['id'];
	$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY fecha DESC");
	$result = mysqli_fetch_array($query);
	if ($result) {
		$secuencial = $result['codigo_factura'];
		$secuencial = $secuencial+1;
		// code...
	}else {
		$secuencial =1;
	}

	//CODIGO PARA SACAR LA INFORMACION

	if ($ambito_area == 'prueba') {
		$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

	}else {
		$ruta_factura = '../comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
	}
  $iduser= $_SESSION['id'];

	$acceso_factura = simplexml_load_file($ruta_factura);
	$codDocModificado                = $acceso_factura->infoTributaria->codDoc;

	 //para crear el numero dl documento necesito de 4 partes
		$estab                       = $acceso_factura->infoTributaria->estab;
		$ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
		$secuencial_factura                  = $acceso_factura->infoTributaria->secuencial;
	$numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial_factura.'';


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

	 $query_consulta_ultimo_cliente = mysqli_query($conection,"SELECT * FROM clientes   WHERE identificacion= '$identificacion_comprador'");
	 $data_cliente    = mysqli_fetch_array($query_consulta_ultimo_cliente);
	 if ($data_cliente) {
	 		 $idcliente = $data_cliente['id'];
	 }else {
	 	$idcliente = '';
	 }


  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;



	$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor,id_receptor,xml_autorizado,nombres_receptor,cedula_receptor,email_receptor,
		precio_neto,descripcion,direccion_receptor,celular_receptor,clave_acceso,tipo_identificacion,subtotal,iva,total,comprobante,nomnto_modificacion,razon_modficiacion,numDocModificado,identificacion_nc,codigo_factura_credito,url_file_upload)
	VALUES('$secuencial','','$iduser','$idcliente','$nuevo_xml','$razon_social_comprador','$identificacion_comprador','$email_receptor',
		'','','','','$clave_acc_guardar','','','','','nota_credito','$nomnto_modificacion','$razon_modficiacion','$numDocModificado','$identificacion_comprador','$clave_acceso_factura','$url') ");

		$query_delete=mysqli_query($conection,"UPDATE comprobante_factura_final SET codigo_factura_credito= '$clave_acc_guardar',estado= 'ANULADO'  WHERE clave_acceso='$clave_acceso_factura'  ");


		//if ($query_insert) {
		//	echo "se inserto";
			// code...
		//}else {
		//	echo "no se inserto";
		//}


}

}
