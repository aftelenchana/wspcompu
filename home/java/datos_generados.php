<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
session_start();
  include "../../coneccion.php";
    mysqli_set_charset($conection, 'utf8'); //linea a colocar
  $query_config = mysqli_query($conection, "SELECT * FROM `configuraciones` ");
  $result_config = mysqli_fetch_array($query_config);
  $nombre_empresa_ttt = $result_config['nombre_empresa'];
  $foto_representativa = $result_config['foto_representativa'];
    $web = $result_config['web'];
    $servidor_email = $result_config['servidor_email'];
        $email_empresa = $result_config['email_empresa'];

  $iduser= $_SESSION['id'];
  require '../QR/phpqrcode/qrlib.php';
  $id_encriptado = strtoupper(md5($iduser.date('d-m-Y H:m:s')));
  $query_insert=mysqli_query($conection,"UPDATE usuarios SET token='',contenido_qr='',estado_token='Inactivo'  WHERE id='$iduser' ");

    $query = mysqli_query($conection, "SELECT* FROM usuarios  WHERE id = $iduser ");
    $result = mysqli_fetch_array($query);

    $img_qr = $result['img_qr'];
    $nombres = $result['nombres'];
    $apellidos = $result['apellidos'];
    $email = $result['email'];
    $id_e = $result['id_e'];
    if ($id_e=='') {
      $query_insert=mysqli_query($conection,"UPDATE usuarios SET id_e= '$id_encriptado'  WHERE id='$iduser' ");

    }
    $bienvenida_email = $result['bienvenida_email'];


    if ($img_qr == '') {
   $nombre_qr = 'qr'.md5($iduser.date('d-m-Y H:m:s')).'.png';
    $dir = '../img/qr/';
    $filename = $dir.$nombre_qr;
    $tamanio = 7;
    $level = 'H';
    $frameSize = 5;
    $contenido = "https://guibis.com/perfil?id=$iduser";
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET img_qr='$nombre_qr',contenido_qr='$contenido'  WHERE id='$iduser' ");
    QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
    }
    if ($bienvenida_email == '') {
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET bienvenida_email='si'  WHERE id='$iduser' ");

      try {


  // Configuración del servidor
 $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
 $mail -> isSMTP ();                                          // Enviar usando SMTP
 $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
 $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
 $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
 $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
 $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
 $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

    // Destinatarios
    $mail -> setFrom ('guibis-ecuador@guibis.com','Guibis-Ecuador');
    $mail -> addAddress ($email);
    $mail -> addAddress ('subgerencia@guibis.com');
    $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario


    // Contenido
    $mail -> isHTML ( true );
    $mail->CharSet = 'UTF-8';                         // Establecer el formato de correo electrónico en HTML
    $mail -> Subject = 'Bienvenido a Guibis.com' ;
    $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
      <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

    </div>
    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
       <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.' !!</h3>
       <p style="font-weight: bold; font-style: italic;" >Bienvenido a Guibis.com</p>
       <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">
        Bienvenido a Guibis.com, ahora puedes subir tus productos en nuestro sitio  gratuitamente, crear eventos y servicios, dentro de nuestro sitio tiene una pasarela de pagos que funciona con recargas mediante nuestras cuentas bancarias,
        sube tus redes sociales, tu logo y reactivémonos económicamente de una forma segura y responsable.  </p>
       <br>
       <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
       <p><img src="https://guibis/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
       <p> <img src="https://guibis/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
       <p><img src="https://guibis/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
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

       </div>' ;
    $mail -> send ();
} catch ( Exception  $e ) {
}
    }



    $query_existencia_cantidad = mysqli_query($conection, "SELECT * FROM `saldo_total_leben` WHERE idusuario = $iduser");
   $result_existencia_cantidad = mysqli_num_rows($query_existencia_cantidad);

   if ($result_existencia_cantidad > 0) {
     $existencia_cantidad_pf = mysqli_fetch_array($query_existencia_cantidad);
     $saldo_usuariopf = $existencia_cantidad_pf['cantidad'];

   }else {
             $query_insert_tabla_cantidad=mysqli_query($conection,"INSERT INTO saldo_total_leben(idusuario,cantidad)
                                           VALUES('$iduser','0') ");
                                           $query = mysqli_query($conection, "SELECT * FROM `saldo_total_leben`
                                            INNER JOIN usuarios ON saldo_total_leben.idusuario = usuarios.id
                                            WHERE usuarios.id = $iduser ");
                                            $result = mysqli_fetch_array($query);
                                            $qr_bancario =  $result['qr_bancario'];
                                            $password =  $result['password'];
                                            $fecha_creacion =  $result['fecha_creacion'];
                                            if ($qr_bancario == '') {
                                              $codigo = $iduser.md5(date('d-m-Y H:m:s').$fecha_creacion.$password.$iduser);
                                              $img_nombre = $iduser.md5(date('d-m-Y H:m:s').$fecha_creacion.$iduser);
                                              $imgProducto2 = $img_nombre.'.png';
                                              $dirboletos = '../img/qr_bancario/';
                                              $filename = $dirboletos.$imgProducto2;
                                              $tamanio = 7;
                                              $level = 'H';
                                              $frameSize = 5;
                                              $contenido = $codigo;
                                              QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
                                              $query_insert=mysqli_query($conection,"UPDATE usuarios SET qr_bancario='$imgProducto2',codigo_qr_unico='$codigo'  WHERE id='$iduser' ");
                                            }
   }
 ?>
