<?php

include '../facturacion/facturacionphp/lib/PHPMailer/PHPMailerAutoload.php';
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


   $query_user = mysqli_query($conection,"SELECT * FROM `usuarios`
   WHERE usuarios.id  = '$iduser' ");
   $data_user =mysqli_fetch_array($query_user);
   $email_user = $data_user['email'];
   $celular_user = $data_user['celular'];
   $img_logo = $data_user['img_facturacion'];

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
       $mail->Host = 'mail.guibis.com';
       // Puerto SMTP
       $mail->Port = 465;
       // Tipo de encriptacion SSL ya no se utiliza se recomienda TSL
       $mail->SMTPSecure = 'ssl';
       // Si necesitamos autentificarnos
       $mail->SMTPAuth = true;
       // Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com)
       $mail->Username = 'factura@facturacion.guibis.com';
       // Contraseña
       $mail->Password = 'MACAra666_';
       //Añadimos la direccion de quien envia el corre, en este caso
       //YARR Blog, primero el correo, luego el nombre de quien lo envia.
       $mail->setFrom('factura@facturacion.guibis.com', 'COMPROBANTE SRI');
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
       $mail->Subject = 'REENVIO COMPROBANTE ELECTRONICO';;
       //Creamos el mensaje
       $message = '
       <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
       <div class="">
         <div class="img_logo" style="text-align: center;">
                 <img src="'.$url.'/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
         </div>
         <div class="">
           <p style="text-align: justify;">Hola <span style="font-weight: bold;">'.$nombres_receptor.'</span>, se ha generado un comprobante electronico en nuestro sistema a continuacion estan
           los archivos para que puedas descargar.</p>
         </div>
         <div class="">
           <p style="text-align: justify;">Se ha generado una factura electrónica en el sistema de Guibis.com, adjuntamos los archivos de validación del comprobante Electrónico, también puedes consultar con tu número de cédula
          o ruc los comprobantes emitidos por nuestro sistema en <a target="_blank" href="https://guibis.com/mis_facturas">Mis Facturas</a> </p>
         </div>
         <div class="" style="text-align: center;">
           <a href="tel:+34678567876"> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" style="width: 50px;"> </a>
           <a href="mailto:'.$email_user.'"> <img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" style="width: 50px;"> </a>
             <a href="tel:'.$celular_user.'"> <img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" style="width: 50px;"> </a>
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
         <p style="font-size: 8px;">Este Mensaje se ha generado automáticamente , recuerda que puedes consultar con nuestras líneas directas o a su vez por nuestro correo soporte@guibis.com . no respondas a este mensaje.</p>
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
