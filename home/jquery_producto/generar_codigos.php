<?php
include "../../coneccion.php";
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
require '../QR/phpqrcode/qrlib.php';

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
session_start();
$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.password FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
if ($_POST['action'] == 'generar_codigo') {

$idp= $_POST['idproducto'];
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $a = 0;
while ($a < 10) {
$necode2 =  md5(substr(str_shuffle($permitted_chars), 0, 9));
$necode =  substr(str_shuffle($permitted_chars), 0, 9);
$query_insert=mysqli_query($conection,"INSERT INTO codigos_producto(idp,id_user,codigo)
VALUES('$idp','$iduser','$necode') ");
$varia[$a] = $necode;
$a = $a+1;
}

try {
   // Configuración del servidor
   $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
   $mail -> isSMTP ();                                          // Enviar usando SMTP
   $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
   $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
   $mail ->Username = 'guibis-ecuador@guibis.com' ;                     // Nombrede usuario SMTP
   $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
   $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
   $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
  $mail -> addAddress ($email_usuario);     // Agrega un destinatario


  // Contenido
  $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
  $mail -> Subject = 'Generador de codigos' ;
  $mail -> Body     = '
  <div class="img_logo" style="text-align: center;  background:">
    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >
  </div>
  <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
     <h3 style="text-align:center; color:#fff;   font-size: 25px; margin:0; padding:0;">'.$nombres.' '.$apellidos.' </h3>
     <p style="font-weight: bold; font-style: italic;" >Gracias por ser parte de esta familia</p>
     <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">
       Los codigos Generados son responsablidad del Usuario:
  </p>
     <br>
     <div class="codigos">
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['0'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['1'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['2'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['3'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['4'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['5'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['6'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['7'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['8'].'</p>
         </div>
       </div>
       <div class="code_general" style="margin: 5px;">
         <div class="code_g" style="width: 10%;background: #000;margin: 0 auto;padding: 6px;border-radius: 10px;">
           <p>'.$varia['9'].'</p>
         </div>
       </div>

     </div>



     <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
     <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
     <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
     <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
     <div style="border-color: #fff;border-width: 1px;
  border-style: solid;
  border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
  <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

     </div>
   <br>
     </div>
     <br>
     <div class="redes_email" style="text-align: center;">
       <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
       <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
       <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

     </div>

    ' ;
  $mail -> send ();
} catch ( Exception  $e ) {
}

$arrayName = array('noticia' =>'insert_ok');
echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


  }


  if ($_POST['action'] == 'validar_codigo_regalo') {
    $idp = $_POST['idp'];
    $codigo = ($_POST['codigo']);

    $query=mysqli_query($conection,"SELECT * FROM `codigos_producto` WHERE  codigo='$codigo' AND estado =0");
     $result_lista= mysqli_num_rows($query);
     if ($result_lista>0) {
       $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,ciudad.nombre as 'ciudad', provincia.nombre as 'provincia',producto_venta.fecha_evento,
   producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,producto_venta.tipo_libro,producto_venta.enlace_mega,producto_venta.encriptacion_mega_libro,
   producto_venta.id_usuario,producto_venta.peso,usuarios.posicion,usuarios.email,producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion FROM producto_venta
       INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
       INNER JOIN provincia ON provincia.id = producto_venta.provincia
       INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
       WHERE idproducto = $idp");
       $result_producto = mysqli_fetch_array($query_producto);
       $peso_uu              =  $result_producto['peso'];
       $precio_producto      =  $result_producto['precio'];
       $posicion_producto    =  $result_producto['posicion'];
       $categorias_imt       =  $result_producto['categorias'];
       $subcategorias_imt    =  $result_producto['subcategorias'];
       $estado_colaboracion    =  $result_producto['estado_colaboracion'];
       $tipo_libro           =  $result_producto['tipo_libro'];
       $enlace_mega          =  $result_producto['enlace_mega'];
       $encriptacion_mega_libro       =  $result_producto['encriptacion_mega_libro'];
       $nombre_producto       =  $result_producto['nombre'];

       try {
         // Configuración del servidor
         $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
         $mail -> isSMTP ();                                          // Enviar usando SMTP
         $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
         $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
         $mail ->Username = 'guibis-ecuador@guibis.com' ;                     // Nombrede usuario SMTP
         $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
         $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
         $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

            // Destinatarios
            $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
         $mail -> addAddress ($email_usuario);     // Agrega un destinatario
         $mail -> addAddress ('subgerencia@guibis.com');



         // Contenido
         $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
         $mail->CharSet = 'UTF-8';
         $mail -> Subject = 'Compra Exitosa de '.$nombre_producto.'' ;
           $mail -> Body     = '
           <div class="img_logo" style="text-align: center;  background:">
             <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >
           </div>
           <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
              <h3 style="text-align:center; color:#fff;   font-size: 25px; margin:0; padding:0;">'.$nombres.' '.$apellidos.' Tu compra del Evento '.$nombre_producto.' ha sido exitosa. </h3>
              <p style="font-weight: bold; font-style: italic;" >Gracias por ser parte de esta familia</p>

              <div class="encriptacion_mega">
                <p style="background: #fff;color: #000;width: 500px;margin: 0 auto;font-size: 20px;border-radius: 20px;">'.$encriptacion_mega_libro.'</p>

              </div>
              <div style="padding: 6px;margin: 10px;" class="contenido_mega">
                <a href="'.$enlace_mega.'"> <img style="width: 90px;" src="https://guibis.com/home/img/reacciones/mega.png" alt=""> </a>
              </div>

              <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
              <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
              <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
              <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
              <div style="border-color: #fff;border-width: 1px;
           border-style: solid;
           border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
           <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

              </div>
            <br>
              </div>
              <br>
              <div class="redes_email" style="text-align: center;">
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

              </div>
           ' ;

         $mail -> send ();
       } catch ( Exception  $e ) {
       }
       $query_insert=mysqli_query($conection,"UPDATE codigos_producto SET estado='0'
          WHERE idp = '$idp' AND codigo='$codigo' ");

       $arrayName = array('noticia' =>'codigo_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       // code...
     }else {
       $arrayName = array('noticia' =>'no_existe');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }


    }




 ?>
