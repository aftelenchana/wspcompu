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




     $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
     $result_documentos = mysqli_fetch_array($query_doccumentos);
     $regimen = $result_documentos['regimen'];
     $contabilidad             = $result_documentos['contabilidad'];
     $email_empresa_emisor     = $result_documentos['email'];
     $celular_empresa_emisor   = $result_documentos['celular'];
     $telefono_empresa_emisor  = $result_documentos['telefono'];
     $direccion_emisor          = $result_documentos['direccion'];
     $whatsapp                 = $result_documentos['whatsapp'];
     $nombres_user                  = $result_documentos['nombres'];
     $apellidos                = $result_documentos['apellidos'];
     $numero_identificacion_emisor  = $result_documentos['numero_identidad'];
     $contribuyente_especial   = $result_documentos['contribuyente_especial'];
     $estableciminento_f      = $result_documentos['estableciminento_f'];
     $contabilidad            = $result_documentos['contabilidad'];
     $punto_emision_f         = $result_documentos['punto_emision_f'];
     $img_facturacion         = $result_documentos['img_facturacion'];
     $contabilidad         = $result_documentos['contabilidad'];
     $regimen         = $result_documentos['regimen'];
     $url_img_upload                     = $result_documentos['url_img_upload'];

     $nombre_empresa_user_in               = $result_documentos['nombre_empresa'];

     $host_envio               = $result_documentos['host_envio'];
     $puerto_email_envio       = $result_documentos['puerto_email_envio'];
     $email_user_name_envio    = $result_documentos['email_user_name_envio'];
     $password_envio_email     = $result_documentos['password_envio_email'];
     $descripcion_envio_email  = $result_documentos['descripcion_envio_email'];
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




 if ($_POST['action'] == 'consultar_datos') {

   if ($user_in == '279') {

        $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios
        ORDER BY `usuarios`.`id` DESC ");
   }else {
     $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios
        WHERE usuarios.user_in ='$iduser'
     ORDER BY `usuarios`.`id` DESC ");
   }



   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }



 if ($_POST['action'] == 'info_plan') {
      $plan       = $_POST['plan'];

   $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios
      WHERE usuarios.id ='$plan'  ");
   $data_plan = mysqli_fetch_array($query_consulta);
   echo json_encode($data_plan,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_plan') {
    $id_plan       = $_POST['id_plan'];
   $cantid_docuent       = $_POST['cantid_docuent'];
   $fecha_max_doc    = $_POST['fecha_max_doc'];


  $query_update =mysqli_query($conection,"UPDATE usuarios SET documentos_electronicos= '$cantid_docuent',fecha_maxima_documentos= '$fecha_max_doc'  WHERE id='$id_plan' ");

   if ($query_update) {


     $query_plan =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$id_plan'");
     $data_plan = mysqli_fetch_array($query_plan);
     $apellidos_plan = $data_plan['apellidos'];
     $nombres_plan   = $data_plan['nombres'];
     $email_plan     = $data_plan['email'];


     try{

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
         $mail -> setFrom ( $email_user_name_envio , 'Sistema de Facturación '.$nombre_empresa_user_in.' ' );
         $mail->addAddress($email_empresa_emisor);
         $mail->addAddress($email_plan);
         $mail->addAddress($email_user_name_envio);

         $mail->CharSet = 'UTF-8';
         $mail->Subject = 'Activación de Cuenta';;
         //Creamos el mensaje
         $message = '
         <html>
         <body style="margin: 20px; padding: 20px; background: #f3f3f3; font-family: Arial, sans-serif;">
             <div style="text-align: center;">
                 <img src="'.$url_img_upload.'/home/img/uploads/'.$img_facturacion.'" alt="Logo" style="width: 200px;">
             </div>
             <div style="margin-top: 20px;">
                 <p style="text-align: justify;">
                     Hola <strong>'.$nombres_plan.' '.$apellidos_plan.'</strong>,
                     <br>
                     Se ha generado un plan en nuestro sitio con fecha de caducidad <strong>'.$fecha_max_doc.'</strong> y con una cantidad de documentos de <strong>'.$cantid_docuent.'</strong>.
                 </p>
             </div>
             <div style="margin-top: 20px; font-size: 8px;">
                 <p>
                     Este mensaje se ha generado automáticamente. Recuerda que puedes consultar con nuestras líneas directas o a su vez por nuestro correo <a href="mailto:soporte@guibis.com">soporte@guibis.com</a>. Por favor, no respondas a este mensaje.
                 </p>
             </div>
         </body>
         </html>
         ';
         //Agregamos el mensaje al correo
         $mail->msgHTML($message);
         // Enviamos el Mensaje
         if (!$mail->send()) {
           $arrayName = array('noticia'=>'insert_correct','correo'=>'no_enviado');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         } else {
           $arrayName = array('noticia'=>'insert_correct','correo'=>'enviado');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
         }catch(Exception $e){return "Ocurrio un error ".$e;}

     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }






 if ($_POST['action'] == 'agregar_almacen') {

   $nombre_almacen       = $_POST['nombre_almacen'];
   $direccion_almacen    = $_POST['direccion_almacen'];
   $sucursal             = $_POST['sucursal'];
   $descripcion          = $_POST['descripcion'];
   $responsable          = $_POST['responsable'];


   $query_insert=mysqli_query($conection,"INSERT INTO almecenes(iduser,nombre_almacen,direccion_almacen,sucursal,descripcion,responsable)
                                 VALUES('$iduser','$nombre_almacen','$direccion_almacen','$sucursal','$descripcion','$responsable') ");
   if ($query_insert) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }



 if ($_POST['action'] == 'eliminar_almacen') {
   $almacen             = $_POST['almacen'];

   $query_delete=mysqli_query($conection,"UPDATE almecenes SET estatus= 0  WHERE id='$almacen' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','almacen'=> $almacen);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
