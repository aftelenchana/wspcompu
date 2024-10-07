<?php
session_start();

 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Mesero') {
    include "../sessiones/session_cuenta_mesero.php";

    }

    if ($_SESSION['rol'] == 'Cocina') {
    include "../sessiones/session_cuenta_cocina.php";
    }


 include '../facturacion/facturacionphp/lib/PHPMailer/PHPMailerAutoload.php';


 if ($_POST['action'] == 'reenviar_factura') {
   $factura = $_POST['factura'];

    $destinatario1 = $_POST['destinatario1'];
    $destinatario2 = $_POST['destinatario2'];
    $destinatario3 = $_POST['destinatario3'];
    $destinatario4 = $_POST['destinatario4'];
    $destinatario5 = $_POST['destinatario5'];
    $destinatario6 = $_POST['destinatario6'];



   $query_factura = mysqli_query($conection,"SELECT * FROM `comprobante_factura_final`
   WHERE comprobante_factura_final.id  = '$factura' ");
   $data_factura=mysqli_fetch_array($query_factura);
   $email_receptor = $data_factura['email_receptor'];
   $nombres_receptor = $data_factura['nombres_receptor'];
   $clave_acceso = $data_factura['clave_acceso'];
   $valor_total = $data_factura['total'];
   $secuencia = $data_factura['secuencia'];
  $fecha_factura = $data_factura['fecha'];


  $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
  $result_documentos = mysqli_fetch_array($query_doccumentos);
  $img_logo                = $result_documentos['img_facturacion'];
  $url_img_upload           = $result_documentos['url_img_upload'];
  $email_user                = $result_documentos['email'];
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




    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


   try{

       $filep = '../facturacion/facturacionphp/comprobantes/pdf/'.$clave_acceso.'.pdf';

       $filex = '../facturacion/facturacionphp/comprobantes/autorizados/'.$clave_acceso.'.xml';
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
       $mail->addAddress($email_receptor);
       $mail->addAddress($email_user);
       $mail->addAddress($destinatario1);
       $mail->addAddress($destinatario2);
       $mail->addAddress($destinatario3);
       $mail->addAddress($destinatario4);
       $mail->addAddress($destinatario5);
       $mail->addAddress($destinatario6);
       $mail->AddAttachment($filep, ''.$clave_acceso.'.pdf');
       $mail->AddAttachment($filex, ''.$clave_acceso.'.xml');
       $mail->CharSet = 'UTF-8';
       $mail->Subject = 'Reenvio Comprobante Electrónico';;
       //Creamos el mensaje
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
   							<td> '.$secuencia.' </td>
   						</tr>
   						<tr>
   							<td> <strong>FECHA EMISION:</strong> </td>
   							<td>'.$fecha_factura.'</td>
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

       '
;
       //Agregamos el mensaje al correo
       $mail->msgHTML($message);
       // Enviamos el Mensaje
       if (!$mail->send()) {
       echo "Mailer Error: " . $mail->ErrorInfo;
       } else {
         $arrayName = array('noticia'=>'insert_correct');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
       }catch(Exception $e){return "Ocurrio un error ".$e;}
    // code...
  }
 ?>
