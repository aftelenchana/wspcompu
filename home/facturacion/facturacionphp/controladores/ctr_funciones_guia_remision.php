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


    function correos($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado,$clave_acc_guardar){
try{


	include "../../../../coneccion.php";
	mysqli_set_charset($conection, 'utf8'); //linea a colocar
	$iduser= $_SESSION['id'];

			$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
			$result_documentos = mysqli_fetch_array($query_doccumentos);
			$img_logo                = $result_documentos['img_facturacion'];
			$email                = $result_documentos['email'];

			$ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';
			$acceso_factura = simplexml_load_file($ruta_factura);
			$rrr= ($acceso_factura->infoAdicional->campoAdicional);
		 foreach($rrr as $Item){
			 $atrinuto = (string)$acceso_factura->infoAdicional->campoAdicional[0];
			 $posicion_coincidencia = strpos($atrinuto, '@');
			 if ($posicion_coincidencia === false) {
				 $email_receptor = 'vacio';

			 } else {
			 $email_receptor_uwu   =$atrinuto;
			 }
			 }

			//INFORMACION DEL DOCUMENTO
			$codDocModificado                = $acceso_factura->infoTributaria->codDoc;

    $filep = '../comprobantes/guia-remision/pdf/'.$clave_acc_guardar.'.pdf';
    $filex = '../comprobantes/guia-remision/autorizados/'.$clave_acc_guardar.'.xml';

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
    $mail->Host = 'priva170.spindns.com';
    // Puerto SMTP
    $mail->Port = 465;
    // Tipo de encriptacion SSL ya no se utiliza se recomienda TSL
    $mail->SMTPSecure = 'ssl';
    // Si necesitamos autentificarnos
    $mail->SMTPAuth = true;
    // Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com)
    $mail->Username = 'facturacion@facturacion.guibis.com';
    // Contraseña
    $mail->Password = 'MACAra666_';
    //Añadimos la direccion de quien envia el corre, en este caso
    //YARR Blog, primero el correo, luego el nombre de quien lo envia.
    $mail->setFrom('facturacion@facturacion.guibis.com', 'COMPROBANTE AUTORIZADO SRI');
    $mail->addAddress('facturacion@facturacion.guibis.com');
		$mail->addAddress($email_receptor_uwu);
		$mail->addAddress($email);
    $mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
    $mail->AddAttachment($filex, ''.$clave_acc_guardar.'.xml');
		$mail->CharSet = 'UTF-8';
    $mail->Subject = 'GUIA DE REMISIÓN';;
    //Creamos el mensaje
    $message =
 '
        <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
        <div class="">
          <div class="img_logo" style="text-align: center;">
                  <img src="https://facturacion.guibis.com/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
          </div>
          <div class="">
            <p style="text-align: justify;">Hola , se ha generado una guia de remisión.</p>
          </div>
        </div>
        <div class="">
          <div class="redes_email" style="text-align: center;">
      <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
      <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
      <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

    </div>
        </div>

        <div  class="">
          <p style="font-size: 8px;">Este mensaje se ha generado automaticamente por niestro sistema de facturacion, no respondas a este mensaje</p>
        </div>

    </body>

        ';
    //Agregamos el mensaje al correo
    $mail->msgHTML($message);
    // Enviamos el Mensaje
    if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;

		$arrayName = array('noticia'=>'error_envio_email');
		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    } else {


     }
    }catch(Exception $e){return "Ocurrio un error ".$e;}


}

function compr_final($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado,$clave_acc_guardar){
  include "../../../../coneccion.php";
  $iduser= $_SESSION['id'];
  $nuevo_xml = ''.$clave_acc_guardar.'.xml';
	$query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY fecha DESC");
	$result = mysqli_fetch_array($query);
	if ($result) {
		$secuencial = $result['codigo_factura'];
		$secuencial = $secuencial+1;
		// code...
	}else {
		$secuencial =1;
	}


	  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

	$query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(id_emisor,codigo_factura,clave_acceso_guia,clave_acceso_factura,direccion_partida,razon_social_transportista,tipoIdentificacionTransportista,fecha_inicio_transporte,fecha_final_transporte,
		placa_transportista,ruc_transportista,direccion_llegada,motivo_traslado,comprobante,url_file_upload)
	VALUES('$iduser','$secuencial','$clave_acc_guardar','$clave_acceso_factura','$direccion_partida','$razon_social_transportista','$tipoIdentificacionTransportista','$fecha_inicio_transporte','$fecha_final_transporte',
	'$placa_transportista','$ruc_transportista','$direccion_llegada','$motivo_traslado','guia_remision','$url') ");

}





}
