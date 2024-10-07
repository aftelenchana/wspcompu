<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
 include '../facturacion/facturacionphp/lib/PHPMailer/PHPMailerAutoload.php';
  require '../QR/phpqrcode/qrlib.php';


 if ($_POST['action'] == 'editar_productosf') {

   $nombre             = $_POST['nombre'];
   $cantidad           = $_POST['cantidad'];
   $precio             = $_POST['precio'];
   $marca              = $_POST['marca'];
   $idproducto         = $_POST['idproducto'];
   $descripcion        = $_POST['descripcion'];

   $query_insert = mysqli_query($conection,"UPDATE producto_venta SET nombre='$nombre',cantidad='$cantidad',precio='$precio',
     marca='$marca',descripcion='$descripcion' WHERE idproducto = '$idproducto'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','idproducto'=> $idproducto);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'eliminar_cliente') {
   $cliente             = $_POST['cliente'];
   $query_insert = mysqli_query($conection,"UPDATE clientes SET estatus='0'
     WHERE id = '$cliente'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'editar_clientes') {

   $nombres             = $_POST['nombres'];
   $mail                = $_POST['mail_user'];
   $direccion_cliente           = $_POST['direccion'];
   $identificacion      = $_POST['identificacion'];
   $celular             = $_POST['celular'];
   $tipo_cliente        = $_POST['tipo_cliente'];
   $id_cliente        = $_POST['id_cliente'];
   $query_insert = mysqli_query($conection,"UPDATE clientes SET nombres='$nombres',mail='$mail',direccion='$direccion',
     identificacion='$identificacion', celular='$celular',tipo_cliente='$tipo_cliente'
     WHERE id = '$id_cliente'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $id_cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

    if ($_POST['action'] == 'agregar_clientes') {

        $identificacion      = $_POST['identificacion'];


      $query_cliente = mysqli_query($conection,"SELECT clientes.id,DATE_FORMAT(clientes.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',clientes.foto,clientes.nombres,clientes.identificacion,
      clientes.celular
  FROM `clientes`
  WHERE clientes.iduser = '$iduser' AND clientes.estatus = '1' AND clientes.identificacion = '$identificacion' ");

$result_cliente= mysqli_num_rows($query_cliente);

if ($result_cliente>0) {

  $data_cliente =mysqli_fetch_array($query_cliente);
  $arrayName = array('noticia' =>'usuario_existente','identificacion'=>$identificacion,'cliente'=>$data_cliente['id']);
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
        $destino = '../img/clientes/';
        $img_nombre = 'cliente'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
          move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'avatar.png';
        // code...
      }
      $nombres             = mb_strtoupper($_POST['nombres']);
      $mail                = mb_strtoupper($_POST['mail_user']);
      $tipo_identificacion = $_POST['tipo_identificacion'];
      $direccion_cliente   = $_POST['direccion'];
      $celular             = $_POST['celular'];
      $tipo_cliente        = $_POST['tipo_cliente'];

      $actividad_economica        = $_POST['actividad_economica'];
      $parroquia                  = $_POST['parroquia'];
      $ciudad                     = $_POST['ciudad'];
      $provincia                  = $_POST['provincia'];



      $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
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



      $query_insert=mysqli_query($conection,"INSERT INTO clientes(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,sistema,qr,qr_contenido,
      actividad_economica,parroquia,ciudad,provincia,url_img_upload,url_upload_qr)
                                    VALUES('$nombres','$mail','$tipo_identificacion','$direccion_cliente','$identificacion','$celular','$imgProducto','$iduser','$tipo_cliente','facturacion','$qr_img','$contenido',
                                    '$actividad_economica','parroquia','$ciudad','$provincia','$url','$url') ");




      if ($query_insert) {

        $query_cliente = mysqli_query($conection,"SELECT clientes.id,DATE_FORMAT(clientes.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',clientes.foto,clientes.nombres,clientes.identificacion,
        clientes.celular
    FROM `clientes`
    WHERE clientes.iduser = '$iduser' ORDER BY clientes.id DESC");

  $data_cliente =mysqli_fetch_array($query_cliente);
          $arrayName = array('img' =>$imgProducto,'noticia'=>'insert_correct','cliente'=>$data_cliente['id']);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

  if ($_POST['action'] == 'enviar_email') {
      $clave_acceso = $_POST['clave_acceso'];
      $query_factura = mysqli_query($conection,"SELECT * FROM `comprobante_factura_final`
      WHERE comprobante_factura_final.clave_acceso  = '$clave_acceso' ");
      $data_factura=mysqli_fetch_array($query_factura);
      $email_receptor = $data_factura['email_receptor'];
      $nombres_receptor = $data_factura['nombres_receptor'];


      $query_user = mysqli_query($conection,"SELECT * FROM `usuarios`
      WHERE usuarios.id  = '$iduser' ");
      $data_user =mysqli_fetch_array($query_user);
      $email_user = $data_user['email'];
      $celular_user = $data_user['celular'];
      $img_logo = $data_user['img_facturacion'];


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
        $mail->setFrom('facturacion@facturacion.guibis.com', 'COMPROBANTE SRI');
        $mail->addAddress($email_receptor);
        $mail->addAddress($email_user);
        $mail->addAddress('facturacion@facturacion.guibis.com');

        $mail->AddAttachment($filep, ''.$clave_acceso.'.pdf');
        $mail->AddAttachment($filex, ''.$clave_acceso.'.xml');
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'REENVIO COMPROBANTE ELECTRONICO';;
        //Creamos el mensaje
        $message = '
        <body style="margin: 20px;padding: 20px;background: #f3f3f3;">
        <div class="">
          <div class="img_logo" style="text-align: center;">
                  <img src="https://facturacion.guibis.com/home/img/uploads/'.$img_logo.'" alt="" style="width: 200px;">
          </div>
          <div class="">
            <p style="text-align: justify;">Hola <span style="font-weight: bold;">'.$nombres_receptor.'</span>, se ha generado un comprobante electronico en nuestro sistema a continuacion estan
            los archivos para que puedas descargar.</p>
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
          <p style="font-size: 8px;">Este mensaje se ha generado automaticamente por niestro sistema de facturacion, no respondas a este mensaje</p>
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
          $arrayName = array('noticia'=>'insert_correct','clave_acceso'=>$clave_acceso);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
        }catch(Exception $e){return "Ocurrio un error ".$e;}

      // code...
    }

 ?>
