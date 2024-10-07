<?php
require '../../../QR/phpqrcode/qrlib.php';
 include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

 session_start();
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




include '../lib/PHPMailer/PHPMailerAutoload.php';


 include ('../lib/codigo_barras/barcode.inc.php');
 require_once '../lib/dompdf/autoload.inc.php';
 	 use Dompdf\Dompdf;
   use Dompdf\Options;

   $codigoFactura = $_POST['codigo_factura'];


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
   $numero_identidad_emisor               = $result_documentos['numero_identidad'];


   $facebook                = $result_documentos['facebook'];
   $instagram           = $result_documentos['instagram'];
   $whatsapp             = $result_documentos['whatsapp'];


   //codigo para saber como va el emisor
   if (empty($nombre_empresa) || $nombre_empresa == '0') {
     $nombre_salida = $razon_social;
   }else {
     $nombre_salida = $nombre_empresa;
   }




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
   $estableciminento_f      = $result_documentos['estableciminento_f'];
   $punto_emision_f         = $result_documentos['punto_emision_f'];


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
    $fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));

      $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
      $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);


      $query = mysqli_query($conection, "SELECT * FROM  proformas   WHERE  proformas.id_emisor  = '$iduser'  ORDER BY fecha DESC");
      $result = mysqli_fetch_array($query);
      if ($result) {
        $secuencial_proforma = $result['secuencial'];
        $secuencial_proforma = $secuencial_proforma+1;
        // code...
      }else {
        $secuencial_proforma =1;
      }
           $numeroConCeros = str_pad($secuencial_proforma, 9, "0", STR_PAD_LEFT);


           $fecha_actual = date("d-m-Y");
           $fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));


           $numDocModificado = $estableciminento_f.'-'.$punto_emision_f .'-'.$numeroConCeros;
           $clave_acc_guardar= ''.$fechasf.'55'.$numero_identidad_emisor.'2'.$estableciminento_f.''.$punto_emision_f .''.$numeroConCeros.'1234567810';


 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
	 // Introducimos HTML de prueba


	  $html=file_get_contents("$url/home/pdf/proforma.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&codigoFactura=$codigoFactura&rol_user=$rol_user&id_generacion=$id_generacion");

    $options = new Options();
    $options  -> set('isRemoteEnabled', TRUE);
    // Instanciamos un objeto de la clase DOMPDF.
    $pdf = new DOMPDF($options);
    // Definimos el tamaño y orientación del papel que queremos.
    $pdf->set_paper("letter", "portrait");
    //$pdf->set_paper(array(0,0,104,250));

    $pdf->load_html($html,'UTF-8');
    $pdf->setPaper('A4', 'portrait');
    // Renderizamos el documento PDF.
	 $pdf->render();

	 $archivo = '../comprobantes/proformas/pdf/'.$clave_acc_guardar.'.pdf';
	 file_put_contents($archivo, $pdf->output());


   $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
   'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
   SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
   FROM `comprobantes`
   WHERE comprobantes.id_emisor = '$iduser' AND comprobantes.secuencial = '$codigoFactura'");
   $data_lista_t=mysqli_fetch_array($query_lista_t) ;
   $compra_total = $data_lista_t['compra_total'];
   $iva_general = $data_lista_t['iva_general'];
   $iva_general = $data_lista_t['iva_general'];
   $descuento_total = $data_lista_t['descuento_total'];
   $valor_total = $data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'];


   $query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
     WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigoFactura'  ORDER BY id DESC  ");
       $data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
       $email_receptor = $data__emmisor['email_reeptor'];

       $nombres_receptor = $data__emmisor['nombres_receptor'];
       $id_receptor = $data__emmisor['id_receptor'];


   try{

   $filep = '../comprobantes/proformas/pdf/'.$clave_acc_guardar.'.pdf';

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




   $mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
   	$mail->CharSet = 'UTF-8';
   $mail->Subject = 'PROFORMA';
   $message =
   //Creamos el mensaje
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
  									<p style="margin: 5px 0;font-size: 12px;">Has recibido una Proforma de:</p>
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
   //Agregamos el mensaje al correo
   $mail->msgHTML($message);
   // Enviamos el Mensaje
   if (!$mail->send()) {
   echo "Mailer Error: " . $mail->ErrorInfo;
   } else {
     $arrayName = array('noticia'=>'insert_correct','clave_acc_guardar'=>$clave_acc_guardar,'url'=>$url);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
   }catch(Exception $e){return "Ocurrio un error ".$e;}





?>
