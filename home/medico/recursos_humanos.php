<?php

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }




    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp          =  $result_configuracion['envio_wsp'];


 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT recursos_humanos.id,recursos_humanos.foto,recursos_humanos.nombres,
    recursos_humanos.identificacion,recursos_humanos.celular,recursos_humanos.telefono,recursos_humanos.mail,
    recursos_humanos.documento,categoria_recursos_humanos.nombre as 'cargo',categoria_recursos_humanos.salario,
    recursos_humanos.cargas_familiares,recursos_humanos.qr
      FROM recursos_humanos
     INNER JOIN categoria_recursos_humanos ON categoria_recursos_humanos.id = recursos_humanos.categoria_recursos_humanos
      WHERE recursos_humanos.iduser ='$iduser'  AND recursos_humanos.estatus = '1'
   ORDER BY `recursos_humanos`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_recursos_humanos') {

        $identificacion      = $_POST['identificacion'];
           $query_cliente = mysqli_query($conection,"SELECT recursos_humanos.id,DATE_FORMAT(recursos_humanos.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',recursos_humanos.foto,recursos_humanos.nombres,recursos_humanos.identificacion,
           recursos_humanos.celular
        FROM `recursos_humanos`
        WHERE recursos_humanos.iduser = '$iduser' AND recursos_humanos.estatus = '1' AND recursos_humanos.identificacion = '$identificacion' ");

        $result_cliente= mysqli_num_rows($query_cliente);

        if ($result_cliente>0) {

        $data_cliente =mysqli_fetch_array($query_cliente);
        $arrayName = array('noticia' =>'usuario_existente','identificacion'=>$identificacion,'id'=>$data_cliente['id']);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;


        // code...
        }
         $largo_cadena = strlen($identificacion);

        if ($largo_cadena < 10 || $largo_cadena > 13 ) {
        $arrayName = array('noticia'=>'identificacion_invalida');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
        }


           if (!empty($_FILES['foto']['name'])) {
             $foto           =    $_FILES['foto'];
             $nombre_foto    =    $foto['name'];
             $type 					 =    $foto['type'];
             $url_temp       =    $foto['tmp_name'];
             $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
             $destino = '../img/uploads/';
             $img_nombre = 'cliente'.md5(date('d-m-Y H:m:s').$iduser);
             $imgProducto = $img_nombre.'.'.$extension;
             $src = $destino.$imgProducto;
               move_uploaded_file($url_temp,$src);
           }else {
             $imgProducto = 'avatar.png';
             // code...
           }


           if (!empty($_FILES['pdf']['name'])) {
             $pdf           =    $_FILES['pdf'];
             $nombre        =    $pdf['name'];
             $type 					 =    $pdf['type'];
             $url_temp_2       =    $pdf['tmp_name'];
             $extension = pathinfo($nombre, PATHINFO_EXTENSION);
             $destino = '../archivos/documentos/';
             $documento = 'documentos_guibis'.md5(date('d-m-Y H:m:s').$iduser);
             $documento = $documento.'.'.$extension;
             $src_2 = $destino.$documento;
             move_uploaded_file($url_temp_2,$src_2);
           }else {
             $documento ='';
           }

           $lineas_distribucion           = (isset($_REQUEST['lineas_distribucion'])) ? $_REQUEST['lineas_distribucion'] : '';


           $nombres             = mb_strtoupper($_POST['nombres']);
           $mail_user                = mb_strtoupper($_POST['mail_user']);
           $tipo_identificacion = $_POST['tipo_identificacion'];
           $direccion_cliente   = $_POST['direccion'];
           $celular             = $_POST['celular'];
           $tipo_cliente        = $_POST['tipo_cliente'];

           $actividad_economica        = $_POST['actividad_economica'];
           $parroquia                  = $_POST['parroquia'];
           $ciudad                     = $_POST['ciudad'];
           $provincia                  = $_POST['provincia'];
           $telefono                   = $_POST['telefono'];
           $cargas_familiares          = $_POST['cargas_familiares'];
           $categoria_recursos_humanos = $_POST['categoria_recursos_humanos'];

           $password_guardar = md5($identificacion);



     $img_nombre = 'guibis_cliente'.md5(date('d-m-Y H:m:s'));
     $qr_img = $img_nombre.'.png';
     $contenido = md5(date('d-m-Y H:m:s').$iduser);

     $direccion = '../img/qr/';
     $filename = $direccion.$qr_img;
     $tamanio = 7;
     $level = 'H';
     $frameSize = 5;
     $contenido = $contenido;
     QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);

       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

       $fecha_inicio = $_POST['fecha_inicio'];

       $fecha_corte = $_POST['fecha_corte'];
       $fecha_final = $_POST['fecha_final'];

   $query_insert=mysqli_query($conection,"INSERT INTO recursos_humanos(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,sistema,qr,qr_contenido,
   actividad_economica,parroquia,ciudad,provincia,url_img_upload,url_upload_qr,telefono,password,documento,cargas_familiares,categoria_recursos_humanos,fecha_corte,fecha_inicio,fecha_final,lineas_distribucion)
                                 VALUES('$nombres','$mail_user','$tipo_identificacion','$direccion_cliente','$identificacion','$celular','$imgProducto','$iduser','$tipo_cliente','facturacion','$qr_img','$contenido',
                                 '$actividad_economica','parroquia','$ciudad','$provincia','$url','$url','$telefono','$password_guardar','$documento','$cargas_familiares','$categoria_recursos_humanos'
                               ,'$fecha_corte','$fecha_inicio','$fecha_final','$lineas_distribucion') ");

   if ($query_insert) {

     // INSERTAMOS LOS REGISTROS PARA EL PAGO DE SALARIOS

     $query_ultimo_registro= mysqli_query($conection, "SELECT * FROM recursos_humanos  WHERE iduser = '$iduser'
     ORDER BY fecha DESC");
     $data_ultimo_registro = mysqli_fetch_array($query_ultimo_registro);
     $id_ultimo_recurso_humnao = $data_ultimo_registro['id'];

     // Crear objeto DateTime para la fecha de corte
     $fechaCorteObj = new DateTime($fecha_corte);
     // Crear objeto DateTime para la fecha final
     $fechaFinalObj = new DateTime($fecha_final);

     // Bucle while para sumar un mes a la fecha de corte hasta que la fecha exceda la fecha final
     while ($fechaCorteObj <= $fechaFinalObj) {
         // Convertir la fecha actual del objeto DateTime a string para la inserción
         $fecha_para_insertar = $fechaCorteObj->format('Y-m-d');

         // Insertar la fecha en la base de datos
         $query_insert = mysqli_query($conection, "INSERT INTO pago_salarios_recurso_humano (iduser, id_usuario_recurso_humano, fecha_corte, estado)
                                            VALUES ('$iduser', '$id_ultimo_recurso_humnao', '$fecha_para_insertar', 'PENDIENTE')");

        // Sumar un mes para la próxima iteración
        $fechaCorteObj->modify('+1 month');

     }

         $query_correo_registro= mysqli_query($conection, "SELECT * FROM credenciales_correos  WHERE area = 'registro'");
         $data_correo_registro = mysqli_fetch_array($query_correo_registro);

         $Host_registro        = $data_correo_registro['Host'];
         $Username_registro    = $data_correo_registro['Username'];
         $Password_registro    = $data_correo_registro['Password'];
         $Port_registro        = $data_correo_registro['Port'];
         $SMTPSecure_registro  = $data_correo_registro['SMTPSecure'];

         $mail = new  PHPMailer ( true );
         try {

         $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
         $mail -> isSMTP ();                                          // Enviar usando SMTP
         $mail -> Host        = "$Host_registro" ;                  // Configure el servidor SMTP para enviar a través de
         $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
         $mail->Username = "$Username_registro";
         $mail->Password = "$Password_registro";                              // Contraseña SMTP
         $mail -> SMTPSecure = "$SMTPSecure_registro";         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
        $mail->Port = "$Port_registro";                             // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba
         // Destinatarios
         $mail -> setFrom ( $Username_registro , 'Sistema de Recursos Humanos' );
         $mail -> addAddress($Username_registro);
         $mail -> addAddress ($mail_user);

            // Contenido
         $mail -> isHTML ( true );
         $mail->CharSet = 'UTF-8';                         // Establecer el formato de correo electrónico en HTML
         $mail->Subject = 'Bienvenido '.$nombres;
         $mail->Body    = '
         <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
           <div style="background: #fff; padding: 20px; margin: 10px; max-width: 600px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
             <div style="text-align: center; margin-bottom: 20px;">
               <img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" alt="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" style="width: 200px;">
             </div>
             <div style="text-align: justify;">
               <p>¡Hola <span>'.$nombres.'</span>, bienvenido a nuestra plataforma!</p>
               <p>Te saluda '.$nombre_empresa.'.</p>
               <p>Estamos emocionados de contar contigo como parte de nuestra comunidad legal y esperamos brindarte todas las herramientas y recursos necesarios para que puedas ejercer tu profesión de manera eficiente y efectiva.</p>
               <p>Tu contraseña temporal es:</p>
               <div style="text-align: center; background-color: #263238; color: #fff; padding: 15px; margin: 20px auto; width: 50%;">
                 '.$identificacion.'
               </div>
               <p>Si tienes preguntas o necesitas asistencia, por favor contacta a nuestro equipo de soporte a través de:</p>
               <p>Email: '.$email_user.'<br>
                  Teléfono: '.$telefono_user.'<br>
                  Celular: '.$celular_user.'</p>
               <div style="width: 50%; margin: 0 auto; text-align: center;">
                 <a href="'.$url.'" style="text-decoration: none; background-color: #263238; color: #fff; padding: 11px; display: inline-block;">Acceder al sistema</a>
               </div>
               <p style="text-align: center;">'.$nombre_empresa.'<br>'.$direccion.'</p>

             </div>
           </div>
         </body>';

           if (!$mail->send()) {
                                                // Manejo del caso de fallo en el envío
                $response = array('noticia_email' => 'error_envio','noticia' =>'insert_correct');
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            } else {
                // Manejo del caso de éxito en el envío
                $response = array('noticia_email' => 'envio_exitoso','noticia' =>'insert_correct');
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }
         } catch (Exception $e) {
            // Manejo de una excepción durante la configuración o el envío
            $response = array('noticia_email' => 'error_excepcion','noticia' =>'insert_correct','detalle' => 'Ocurrió un error al intentar enviar el correo','error' => $e->getMessage());
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        $mensajeWhatsApp = "¡Hola *{$nombres}*! 👋\n\n";
        $mensajeWhatsApp .= "Bienvenido a nuestra plataforma. 🌟\n\n";
        $mensajeWhatsApp .= "Te saluda el equipo de *{$nombre_empresa}*. Estamos emocionados de contar contigo y queremos asegurarnos de que recibas todo el soporte y las herramientas.\n\n";
        $mensajeWhatsApp .= "Tu contraseña temporal es *{$identificacion}*. Recuerda cambiarla por una propia al ingresar por primera vez.\n\n";
        $mensajeWhatsApp .= "Si tienes alguna pregunta o necesitas asistencia, estamos aquí para ayudarte. No dudes en contactarnos. 👩‍💼👨‍💼\n\n";
        $mensajeWhatsApp .= "Puedes acceder a tu cuenta y comenzar a explorar nuestros servicios a través del siguiente enlace: 🔗\n";
        $mensajeWhatsApp .= "{$url}\n\n";
        $mensajeWhatsApp .= "Recuerda, estamos aquí para apoyarte en cada paso del camino.\n\n";
        $mensajeWhatsApp .= "Con aprecio,\n*El Equipo de {$nombre_empresa}* 💼\n\n";
        $mensajeWhatsApp .= "Contacto del abogado:\n";
        $mensajeWhatsApp .= "Email: *{$email_user}*\n";
        $mensajeWhatsApp .= "Teléfono: *{$telefono_user}*\n";
        $mensajeWhatsApp .= "Celular: *{$celular_user}*\n\n";


        if ($envio_wsp == 'SI') {
          include '../mensajes/mensajes.php';
          //$respuesta_registro_cliente    = enviarMensajeWhatsApp_guibis($celular, $mensajeWhatsApp);
          // code...
        }

     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

  }



 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM recursos_humanos
         WHERE recursos_humanos.iduser ='$iduser'  AND recursos_humanos.estatus = '1' AND recursos_humanos.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'info_recursos_humanos_tarjeta') {
      $cliente       = $_POST['cliente'];

      $query_consulta = mysqli_query($conection, "SELECT recursos_humanos.id,recursos_humanos.foto,recursos_humanos.nombres,
       recursos_humanos.identificacion,recursos_humanos.celular,recursos_humanos.telefono,recursos_humanos.mail,
       recursos_humanos.documento,categoria_recursos_humanos.nombre as 'cargo',categoria_recursos_humanos.salario,
       recursos_humanos.cargas_familiares,recursos_humanos.qr
         FROM recursos_humanos
        INNER JOIN categoria_recursos_humanos ON categoria_recursos_humanos.id = recursos_humanos.categoria_recursos_humanos
         WHERE recursos_humanos.iduser ='$iduser'  AND recursos_humanos.estatus = '1' AND recursos_humanos.id = '$cliente'
      ORDER BY `recursos_humanos`.`fecha` DESC ");


   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_recursos_humanos') {

   $nombres             = $_POST['nombres'];
   $mail                = $_POST['mail_user'];
   $direccion   = $_POST['direccion'];
   $identificacion      = $_POST['identificacion'];
   $celular             = $_POST['celular'];
   $tipo_cliente        = $_POST['tipo_cliente'];
   $id_cliente        = $_POST['id_cliente'];
   $telefono        = $_POST['telefono'];
   $tipo_identificacion        = $_POST['tipo_identificacion'];

   $cargas_familiares          = $_POST['cargas_familiares'];
   $categoria_recursos_humanos = $_POST['categoria_recursos_humanos'];

   if (!empty($_FILES['foto']['name'])) {
     $foto           =    $_FILES['foto'];
     $nombre_foto    =    $foto['name'];
     $type 					 =    $foto['type'];
     $url_temp       =    $foto['tmp_name'];
     $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
     $destino = '../img/uploads/';
     $img_nombre = 'guibis_recursos_humanos'.md5(date('d-m-Y H:m:s').$iduser);
     $img_cliente = $img_nombre.'.'.$extension;
     $src = $destino.$img_cliente;
     move_uploaded_file($url_temp,$src);
     $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url_img_upload = $protocol . $domain;
     }else {
       $query_consulta = mysqli_query($conection, "SELECT * FROM recursos_humanos
          WHERE recursos_humanos.estatus = '1' AND recursos_humanos.id = '$id_cliente'  ");
    $data_consulta = mysqli_fetch_array($query_consulta);
       $img_cliente = $data_consulta['foto'];
       $url_img_upload = $data_consulta['url_img_upload'];
     }

   $query_insert = mysqli_query($conection,"UPDATE recursos_humanos SET nombres='$nombres',mail='$mail',direccion='$direccion',
     identificacion='$identificacion', celular='$celular',tipo_cliente='$tipo_cliente',telefono='$telefono',tipo_identificacion='$tipo_identificacion'
     ,foto='$img_cliente',url_img_upload='$url_img_upload',cargas_familiares='$cargas_familiares',categoria_recursos_humanos='$categoria_recursos_humanos'
     WHERE id = '$id_cliente'");

   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $id_cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_cliente') {
   $cliente             = $_POST['cliente'];

   $query_delete=mysqli_query($conection,"UPDATE recursos_humanos SET estatus= 0  WHERE id='$cliente' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cliente'=> $cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
