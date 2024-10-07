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





 if ($_POST['action'] == 'consultar_datos') {
   $cliente = $_POST['cliente'];

   $query_consulta = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email_cliente
      WHERE lista_correos_envios_email_cliente.iduser ='$iduser'  AND lista_correos_envios_email_cliente.estatus = '1' AND lista_correos_envios_email_cliente.cliente = '$cliente'
   ORDER BY `lista_correos_envios_email_cliente`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }






 if ($_POST['action'] == 'agregar_email_envio') {

   $cliente       = $_POST['cliente'];

   $email_envio       = mb_strtoupper($_POST['email_envio']);
   $query_user = mysqli_query($conection,"SELECT * FROM `usuarios` WHERE usuarios.id  = '$iduser' ");
   $data_user = mysqli_fetch_array($query_user);
   $email_user = $data_user['email'];
   $nombres = $data_user['nombres'];
   $celular_user = $data_user['celular'];
   $img_logo = $data_user['img_facturacion'];
   $url_img_upload = $data_user['url_img_upload'];
   $host_envio               = $data_user['host_envio'];
   $puerto_email_envio       = $data_user['puerto_email_envio'];
   $email_user_name_envio    = $data_user['email_user_name_envio'];
   $password_envio_email     = $data_user['password_envio_email'];
   $descripcion_envio_email  = $data_user['descripcion_envio_email'];
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
     $email_user_name_envio = 'guibis-ecuador@guibis.com';
   }






   try {
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';
      $mail->Host = "$host_envio";
      $mail->Port = "$puerto_email_envio";
      $mail->SMTPSecure = 'ssl';
      $mail->SMTPAuth = true;
      $mail->Username = "$email_user_name_envio";
      $mail->Password = "$password_envio_email";
      $mail->setFrom($email_user_name_envio, 'Email Prueba');
      $mail->addAddress($email_user_name_envio);
      $mail->addAddress($email_envio);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'Comprobación de Agregación de  Envio de Correo';

      $message = '
      <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
      <div class="">
         <div class="img_logo" style="text-align: center;">
            <img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
         </div>
         <div class="">
            <p style="text-align: justify;">Hola <span style="font-weight: bold;">'.$nombres.'</span>, este es un mensaje de comprobación para integrar tu correo para el envio de comprobantes.</p>
         </div>
      </div>
      <div class="">
         <p style="font-size: 8px;">Este Mensaje se ha generado automáticamente, recuerda que puedes consultar con nuestras líneas directas o a su vez por nuestro correo soporte@guibis.com. No respondas a este mensaje.</p>
      </div>
      </body>';

      $mail->msgHTML($message);

      if (!$mail->send()) {
         $signi_error = $mail->ErrorInfo;
         $arrayName = array('noticia'=>'error_envio','contenido_error'=>$signi_error);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      } else {

         $query_insert=mysqli_query($conection,"INSERT INTO lista_correos_envios_email_cliente(iduser,correo,cliente)
                                       VALUES('$iduser','$email_envio','$cliente') ");
         if ($query_insert) {
           $arrayName = array('noticia' =>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



           }else {
             $arrayName = array('noticia' =>'error_insertar_servidor');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }


      }
   } catch (Exception $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
   }

 }



 if ($_POST['action'] == 'eliminar_cuenta_email') {
   $cuenta_email             = $_POST['cuenta_email'];
   $query_delete=mysqli_query($conection,"UPDATE lista_correos_envios_email_cliente SET estatus= 0  WHERE id='$cuenta_email' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cuenta_email'=> $cuenta_email);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
