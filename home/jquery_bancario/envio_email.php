<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;

function envio_email($email_comprador, $email_vendedor, $accion,$producto,$cantidad) {
  include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

 // La instanciación y el paso de `true` habilita excepciones

    $iduser= $_SESSION['id'];
  $queryu = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
  $resultu = mysqli_fetch_array($queryu);
  $apellidos_comprador = $resultu['apellidos'];
  $nombres_comprador   = $resultu['nombres'];
  $email_comprador     = $resultu['email'];
  $password_base_datos = $resultu['password'];
  if ($accion == 'intentos_maximos') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Soporte' );
      $mail -> addAddress ($email_comprador);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'INTENTO DE COMPRA FALLIDO' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombres_comprador.' INTENTO DE COMPRA FALLIDOS.</h5>
              <div class="">
                <p>'.$nombres_comprador.' se ha intentado realizar una compra  desde tu cuenta digital de Guibis.com, pero se ha declinado el pago debido a que tu cuenta esta suspendida debido a que has introducido tu contraseña varias veces, si no fuiste tu contáctanos de manera urgente.  </p>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
    return ('esto es un aviso de intentos maximos');
    // code...
  }
  if ($accion == 'password_incorrecta') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Soporte' );
      $mail -> addAddress ($email_comprador);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'INTENTO DE COMPRA FALLIDO CONTRASEÑA INCORRECTA' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombres_comprador.' INTENTO DE COMPRA FALLIDO CONTRASEÑA INCORRECTA.</h5>
              <div class="">
                <p>'.$nombres_comprador.' se ha intentado realizar una compra  desde tu cuenta digital de Guibis.com, pero se ha declinado el pago a contraseña incorrecta, tu cuenta sera suspendida por motivos de seguridad si tu contraseña sigue siendo incorrecta, si no fuiste tu contáctanos de manera urgente.  </p>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
    return ('esto es un aviso por contraseña incorrecta');
    // code...
  }

  if ($accion == 'saldo_insuficiente') {
     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Soporte' );
      $mail -> addAddress ($email_comprador);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail -> Subject = 'INTENTO DE COMPRA FALLIDO SALDO INSUFICIENTE' ;
      $mail -> Body     = '
      <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
        <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
          <div class="logo-empresa" style="text-align: center;">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
          </div>
          <div class="contenedor-informacion" style="text-align: justify;">
            <div class="">
              <h5>'.$nombres_comprador.' INTENTO DE COMPRA FALLIDO SALDO INSUFICIENTE.</h5>
              <div class="">
                <p>'.$nombres_comprador.' se ha intentado realizar una compra  desde tu cuenta digital de Guibis.com, pero se ha declinado el pago debido a que no tienes fondos suficientes , si no fuiste tu contáctanos de manera urgente.  </p>
              </div>
            </div>
            <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
              <p>Si tienes alguna duda comunicate con nuestro equipo</p>
              <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a> <br>
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Equipo de Compras' );
      $mail -> addAddress ($email_vendedor);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario
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
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Equipo Ventas' );
      $mail -> addAddress ($email_comprador);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario
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
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
      $mail ->Username = 'ventas@guibis.com' ;                    // Nombrede usuario SMTP
      $mail ->Password = 'alex2023_1996_telenchana' ;                               // Contraseña SMTP
      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ( 'ventas@guibis.com' , 'Equipo Ventas' );
      $mail -> addAddress ($email_comprador);     // Agrega un destinatario
      $mail -> addAddress ('ventas@guibis.com');     // Agrega un destinatario
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
              <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:ventas@guibis.com">ventas@guibis.com</a>
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
