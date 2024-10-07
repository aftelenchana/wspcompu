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



if ($_POST['action'] == 'agregar_cuentas_cobrar') {
   $host = $_POST['host'];
   $puerto = $_POST['puerto'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $descripcion = $_POST['descripcion'];
   $correo_prueba = $_POST['correo_prueba'];

   $query_user = mysqli_query($conection,"SELECT * FROM `usuarios` WHERE usuarios.id  = '$iduser' ");
   $data_user = mysqli_fetch_array($query_user);
   $email_user = $data_user['email'];
   $nombres = $data_user['nombres'];
   $celular_user = $data_user['celular'];
   $img_logo = $data_user['img_facturacion'];
   $url_img_upload = $data_user['url_img_upload'];

   try {
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';
      $mail->Host = "$host";
      $mail->Port = "$puerto";
      $mail->SMTPSecure = 'ssl';
      $mail->SMTPAuth = true;
      $mail->Username = "$email";
      $mail->Password = "$password";
      $mail->setFrom($email, 'Email Prueba');
      $mail->addAddress($email);
      $mail->addAddress($correo_prueba);
      $mail->addAddress($email_user);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'Comprobación de Envio de Correo';

      $message = '
      <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
      <div class="">
         <div class="img_logo" style="text-align: center;">
            <img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
         </div>
         <div class="">
            <p>'.$descripcion.'</p>
         </div>
         <div class="">
            <p style="text-align: justify;">Hola <span style="font-weight: bold;">'.$nombres.'</span>, este es un mensaje de comprobación para integrar tu correo como servidor de envio de correos de los comprobantes.</p>
         </div>
      </div>
      <div class="">
         <p style="font-size: 8px;">Este Mensaje se ha generado automáticamente, recuerda que puedes consultar con nuestras líneas directas o a su vez por nuestro correo soporte@guibis.com. No respondas a este mensaje.</p>
      </div>
      </body>';

      $mail->msgHTML($message);

      if (!$mail->send()) {
         $signi_error = $mail->ErrorInfo;
         $arrayName = array('noticia'=>'error','contenido_error'=>$signi_error);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      } else {
         $arrayName = array('noticia'=>'insert_correct');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
   } catch (Exception $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
   }
}
?>
