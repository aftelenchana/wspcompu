<?php
require("../home/mail/PHPMailer-master/src/PHPMailer.php");
require("../home/mail/PHPMailer-master/src/Exception.php");
require("../home/mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;

function envio_email($iduser, $accion) {
  include "../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

 // La instanciación y el paso de `true` habilita excepciones
  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;


 function getRealIP2(){
           if (isset($_SERVER["HTTP_CLIENT_IP"])){
               return $_SERVER["HTTP_CLIENT_IP"];
           }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
               return $_SERVER["HTTP_X_FORWARDED_FOR"];
           }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
           {
               return $_SERVER["HTTP_X_FORWARDED"];
           }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
           {
               return $_SERVER["HTTP_FORWARDED_FOR"];
           }elseif (isset($_SERVER["HTTP_FORWARDED"]))
           {
               return $_SERVER["HTTP_FORWARDED"];
           }
           else{
               return $_SERVER["REMOTE_ADDR"];
           }

       }
       if ($url =='http://localhost') {
         $direccion_ip =  '186.47.139.49';
       }else {
         $direccion_ip = (getRealIP2());
       }

       $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));



 $pais            = $datos['country'];
 $ciudad            = $datos['city'];
 $provincia         = $datos['regionName'];


 function getDeviceDetails() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $osPlatform = "Unknown OS Platform";
    $osArray = array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($osArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $osPlatform = $value;
        }
    }

    $browser = "Unknown Browser";
    $browserArray = array(
        '/msie/i'       => 'Internet Explorer',
        '/firefox/i'    => 'Firefox',
        '/safari/i'     => 'Safari',
        '/chrome/i'     => 'Chrome',
        '/edge/i'       => 'Edge',
        '/opera/i'      => 'Opera',
        '/netscape/i'   => 'Netscape',
        '/maxthon/i'    => 'Maxthon',
        '/konqueror/i'  => 'Konqueror',
        '/mobile/i'     => 'Handheld Browser'
    );

    foreach ($browserArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $browser = $value;
        }
    }

    return array(
        'os' => $osPlatform,
        'browser' => $browser
    );
}

$deviceDetails = getDeviceDetails();
$fecha_actual =  date("Y-m-d H:i:s");


  $queryu = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
  $resultu = mysqli_fetch_array($queryu);
  $apellidos_usuario = $resultu['apellidos'];
  $nombres_usuario   = $resultu['nombres'];
  $email_usuario     = $resultu['email'];

  if ($accion == 'password_incorrecta') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Soporte Cuenta' );
      $mail -> addAddress ($email_usuario);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'Intento de Acceso a tu cuenta ' ;
      $mail->Body = '
          <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
          <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
          <img src="'.$url.'/img/guibis.png"  style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
          <div class="">
          <div class="">
              <p>¡<span>'.$apellidos_usuario.' '.$apellidos_usuario.'</span> se ha detectado un inicio de sesión no exitoso en nuestro sitio!</p>
              <!-- Tabla de Información del Usuario -->
              <table style="width: 99%;border-collapse: collapse;margin-top: 20px; margin-left: auto; margin-right: auto;">
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dispositivo:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['os'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Navegador:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['browser'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Fecha:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$fecha_actual.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">País:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$pais.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Provincia:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$provincia.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Ciudad:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$ciudad.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dirección IP:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$direccion_ip.'</td>
                  </tr>
              </table>
              <div class="" style="color: #c1c1c1;padding: 10px;margin: 10px;">
                <p>Este mensaje se envio en automático, no respondas a este mensaje, para cualquier duda te presentamos nuestras lineas directas correo:
                   soporte@guibis.com Teléfono: +593998855160 </p>
              </div>
          </div>
          </div>
          </div>
          </div>
          </body>
      ';
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
    return ('esto es un aviso de intentos maximos');
    // code...
  }
  if ($accion == 'intentos_maximos') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Soporte de Cuentas' );
      $mail -> addAddress ($email_usuario);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'Protección de Cuentas Activado' ;
      $mail->Body = '
          <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
          <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
          <img src="'.$url.'/img/guibis.png"  style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
          <div class="">
          <div class="">
              <p>¡<span>'.$apellidos_usuario.' '.$apellidos_usuario.'</span> se ha detectado un inicio de sesión no exitoso y limitado en nuestro sitio, desde este momento debes comunicarte con soporte paran poder recuperar tu cuenta!</p>
              <!-- Tabla de Información del Usuario -->
              <table style="width: 99%;border-collapse: collapse;margin-top: 20px; margin-left: auto; margin-right: auto;">
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dispositivo:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['os'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Navegador:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['browser'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Fecha:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$fecha_actual.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">País:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$pais.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Provincia:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$provincia.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Ciudad:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$ciudad.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dirección IP:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$direccion_ip.'</td>
                  </tr>
              </table>
              <div class="" style="color: #c1c1c1;padding: 10px;margin: 10px;">
                <p>Este mensaje se envio en automático, no respondas a este mensaje, para cualquier duda te presentamos nuestras lineas directas correo:
                   soporte@guibis.com Teléfono: +593998855160 </p>
              </div>
          </div>
          </div>
          </div>
          </div>
          </body>
      ';
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
    return ('esto es un aviso por contraseña incorrecta');
    // code...
  }

  if ($accion == 'ingreso_exitoso') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Soporte de Cuentas' );
      $mail -> addAddress ($email_usuario);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'Ingreso exitoso a tu cuenta' ;
      $mail->Body = '
          <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
          <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
          <img src="'.$url.'/img/guibis.png"  style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
          <div class="">
          <div class="">
              <p>¡<span>'.$apellidos_usuario.' '.$apellidos_usuario.'</span> se ha detectado un inicio de sesión no exitoso y limitado en nuestro sitio, desde este momento debes comunicarte con soporte paran poder recuperar tu cuenta!</p>
              <!-- Tabla de Información del Usuario -->
              <table style="width: 99%;border-collapse: collapse;margin-top: 20px; margin-left: auto; margin-right: auto;">
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dispositivo:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['os'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Navegador:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$deviceDetails['browser'].'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Fecha:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$fecha_actual.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">País:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$pais.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Provincia:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$provincia.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Ciudad:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$ciudad.'</td>
                  </tr>
                  <tr>
                      <th style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">Dirección IP:</th>
                      <td style="text-align: left;padding: 8px;border-bottom: 1px solid #ddd;">'.$direccion_ip.'</td>
                  </tr>
              </table>
              <div class="" style="color: #c1c1c1;padding: 10px;margin: 10px;">
                <p>Este mensaje se envio en automático, no respondas a este mensaje, para cualquier duda te presentamos nuestras lineas directas correo:
                   soporte@guibis.com Teléfono: +593998855160 </p>
              </div>
          </div>
          </div>
          </div>
          </div>
          </body>
      ';
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
    return ('esto es un aviso por contraseña incorrecta');
    // code...
  }


  if ($accion == 'envio_comprador') {
    $producto = $producto;
    $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,producto_venta.ciudad as 'ciudad', producto_venta.provincia as 'provincia',producto_venta.fecha_evento,
    producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,
    producto_venta.id_usuario,producto_venta.peso,usuarios.posicion,usuarios.email as 'email_vendedor',usuarios.nombres as 'nombre_vendedor',producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion,producto_venta.meses_suscripcion FROM producto_venta
    INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
    WHERE idproducto = $producto");
    $result_producto = mysqli_fetch_array($query_producto);
    $precio_producto      =  $result_producto['precio'];
    $nombre_vendedor      =  $result_producto['nombre_vendedor'];
    $nombre_producto      =  $result_producto['nombre'];
    $dueno_producto       =  $result_producto['id_usuario'];
    $email_vendedor       =  $result_producto['email_vendedor'];
    $precio_total = $cantidad*$precio_producto;
     $filep = '../archivos/accioncomprar/guia_compra.pdf';
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Equipo de Compras' );
      $mail -> addAddress ($email_vendedor);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario
      $mail->AddAttachment($filep, 'guia_compra.pdf');
      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'COMPRA EXITOSA DEL PRODUCTO '.$nombre_producto.' ' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombres_comprador.' COMPRA EXITOSA DEL PRODUCTO '.$nombre_producto.' .</h5>
              <div class="">
                <p>Hola '.$nombres_comprador.', haz hecho una compra del producto  ID #'.$producto.' de  cantidad '.$cantidad.' unidades, por el
                precio total de $'.$precio_total.' dólares Americanos, se ha generado un código QR para que puedas ver el estado de tu compra,
                esta compra tiene la condición de 24 horas laborables después de que te entreguen el producto, es decir entrega físicamente y
                también en nuestra plataforma en ventas, te adjuntamos una guía en formato pdf para más información.  </p>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:soporte@guibis.com">soporte@guibis.com</a>
            </div>
            <div class="redes-sociales">
              <div class="redes_email" style="text-align: center;">
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
              </div>
          </div>
          <div class="footer" style="font-size: 10px;">
            <p>Este mensaje fue enviado en automático no responsas a este mensaje, te recordamos que una transacción no tiene costo ninguno y tampoco tarifa de cobro, el total cantidad a verificación es el total que una vez verificado el total que se va importar dentro de guibis.com , en caso de que no se verifique el deposito de forma correcta o hay sido con la intención de estafar se desactivara la cuenta y se procederá de manera inmediata apegada a la ley, se recuerda que para realizar transacciones se activa con la cedula de ciudadanía es decir se puede activar una sola vez, para reaizar retiros la cuenta vinculada a la plataforma tiene que ser del mimso titular caso contrario se declina la transferencia de manera inmediata, al ver una actividad sospechosa se suspendera la cuenta del titular.</p>

          </div>

        </div>
        </div>

      </body>


      ' ;
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
    // code...
  }

  if ($accion == 'envio_vendedor') {
    $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,producto_venta.ciudad as 'ciudad', producto_venta.provincia as 'provincia',producto_venta.fecha_evento,
    producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,
    producto_venta.id_usuario,producto_venta.peso,usuarios.posicion,usuarios.email as 'email_vendedor',usuarios.nombres as 'nombre_vendedor',producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion,producto_venta.meses_suscripcion FROM producto_venta
    INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
    WHERE idproducto = $producto");
    $result_producto = mysqli_fetch_array($query_producto);
    $precio_producto      =  $result_producto['precio'];
    $nombre_vendedor      =  $result_producto['nombre_vendedor'];
    $nombre_producto      =  $result_producto['nombre'];
    $dueno_producto       =  $result_producto['id_usuario'];
    $email_vendedor       =  $result_producto['email_vendedor'];
    $precio_total = $cantidad*$precio_producto;
    $filep = '../archivos/accioncomprar/guia_venta.pdf';
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Equipo Ventas' );
      $mail -> addAddress ($email_usuario);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario
      $mail->AddAttachment($filep, 'guia_venta.pdf');

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'VENTA EXITOSA DEL PRODUCTO '.$nombre_producto.'' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombre_vendedor.' VENTA EXITOSA DEL PRODUCTO '.$nombre_producto.'.</h5>
              <div class="">
                <p>Hola '.$nombre_vendedor.', haz hecho una venta del producto  ID #'.$producto.' de  cantidad '.$cantidad.' unidades,
                por el precio total de $'.$precio_total.' dólares Americanos, se ha generado un código QR para que puedas ver el
                 estado de tu venta, esta venta tiene la condición de 24 horas laborables después de que entregues el
                 producto, es decir entrega físicamente
                y también en nuestra plataforma en ventas, te adjuntamos una guía en formato pdf para mas información.  </p>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:soporte@guibis.com">soporte@guibis.com</a>
            </div>
            <div class="redes-sociales">
              <div class="redes_email" style="text-align: center;">
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
              </div>
          </div>
          <div class="footer" style="font-size: 10px;">
            <p>Este mensaje fue enviado en automático no responsas a este mensaje, te recordamos que una transacción no tiene costo ninguno y tampoco tarifa de cobro, el total cantidad a verificación es el total que una vez verificado el total que se va importar dentro de guibis.com , en caso de que no se verifique el deposito de forma correcta o hay sido con la intención de estafar se desactivara la cuenta y se procederá de manera inmediata apegada a la ley, se recuerda que para realizar transacciones se activa con la cedula de ciudadanía es decir se puede activar una sola vez, para reaizar retiros la cuenta vinculada a la plataforma tiene que ser del mimso titular caso contrario se declina la transferencia de manera inmediata, al ver una actividad sospechosa se suspendera la cuenta del titular.</p>

          </div>

        </div>
        </div>

      </body>


      ' ;
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
  }



  if ($accion == 'emvio_archivo_descargable') {
    $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,producto_venta.ciudad as 'ciudad', producto_venta.provincia as 'provincia',producto_venta.fecha_evento,
    producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,producto_venta.cat1sub44_enlace_descarga,
    producto_venta.id_usuario,producto_venta.peso,usuarios.posicion,usuarios.email as 'email_vendedor',usuarios.nombres as 'nombre_vendedor',producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion,producto_venta.meses_suscripcion FROM producto_venta
    INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
    WHERE idproducto = $producto");
    $result_producto = mysqli_fetch_array($query_producto);
    $precio_producto      =  $result_producto['precio'];
    $nombre_vendedor      =  $result_producto['nombre_vendedor'];
    $nombre_producto      =  $result_producto['nombre'];
    $dueno_producto       =  $result_producto['id_usuario'];
    $email_vendedor       =  $result_producto['email_vendedor'];
    $archivo_descarga     =  $result_producto['cat1sub44_enlace_descarga'];
    $precio_total = $cantidad*$precio_producto;
    $filep = '../archivos/accioncomprar/guia_venta.pdf';
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'soporte@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'NK6)&HY}V9B^Q)So;k2a' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'soporte@guibis.com' , 'Equipo Ventas' );
      $mail -> addAddress ($email_usuario);     // Agrega un destinatario
      $mail -> addAddress ('soporte@guibis.com');     // Agrega un destinatario
      $mail->AddAttachment($filep, 'guia_venta.pdf');

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'ARHIVO DE  '.$nombre_producto.'' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombre_vendedor.' VENTA EXITOSA DEL PRODUCTO '.$nombre_producto.'.</h5>
              <div class="">
                <p>Hola '.$nombre_vendedor.', haz hecho una compra del producto  ID #'.$producto.' de  cantidad '.$cantidad.' unidades,
                por el precio total de $'.$precio_total.' dólares Americanos, a continuacion esta el enlace de descarga que viene por esta compra </p>
                      <a target="_blanck" style="display: block;text-decoration: none;padding: 10px;" href="'.$archivo_descarga.'">'.$archivo_descarga.'</a> <br>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:soporte@guibis.com">soporte@guibis.com</a>
            </div>
            <div class="redes-sociales">
              <div class="redes_email" style="text-align: center;">
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
              </div>
          </div>
          <div class="footer" style="font-size: 10px;">
            <p>Este mensaje fue enviado en automático no responsas a este mensaje, te recordamos que una transacción a no se que sea una venta no tiene costo ninguno y tampoco tarifa de cobro, el total cantidad a verificación es el total que una vez verificado el total que se va importar dentro de guibis.com , en caso de que no se verifique el deposito de forma correcta o hay sido con la intención de estafar se desactivara la cuenta y se procederá de manera inmediata apegada a la ley, se recuerda que para realizar transacciones se activa con la cedula de ciudadanía es decir se puede activar una sola vez, para reaizar retiros la cuenta vinculada a la plataforma tiene que ser del mimso titular caso contrario se declina la transferencia de manera inmediata, al ver una actividad sospechosa se suspendera la cuenta del titular.</p>

          </div>

        </div>
        </div>

      </body>


      ' ;
      $mail -> send ();
    } catch ( Exception  $e ) {
    }
  }




}


 ?>
