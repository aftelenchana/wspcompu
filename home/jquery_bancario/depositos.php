<?php
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
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
$queryu = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
$resultu = mysqli_fetch_array($queryu);
$email = $resultu['email'];
$nombres = $resultu['nombres'];
 $apellidos = $resultu['apellidos'];
 $mi_leben = $resultu['mi_leben'];

      if ($_POST['action'] == 'deposito_comprobante') {
        $cantidad      = $_POST['cantidad'];
        $tipo_banco    = $_POST['tipo_banco'];
        $numero_unico  = $_POST['numero_unico'];;
        if (empty($_POST['tipo_banco'])) {
          $arrayName = array('noticia' =>'entidad_bancaria_vacia');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;
        }
        if ($mi_leben != 'Activa') {
          $arrayName = array('noticia' =>'cuenta_bancaria_inactiva');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;
        }

        $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
        $result = mysqli_fetch_array($query);
        $password_bd =  $result['password'];
        /*consulta del numero nunico , iya existe en la base de datos no se hace del deposito*/

        $query_comprobante = mysqli_query($conection, "SELECT * FROM saldo_leben_1804843900 WHERE numero_unico = $numero_unico AND tipo_banco='$tipo_banco'");
        $result_comporbante = mysqli_fetch_array($query_comprobante);
        if ($result_comporbante) {
          $numero_unico_bd =  $result_comporbante['numero_unico'];
          if ($numero_unico_bd == $numero_unico ) {
            $arrayName = array('noticia' =>'comprobante_igual');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            exit;
            // code...
          }
          /**/
        }

        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];

        $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
        if ($nombre_foto != '') {
         $destino = '../img/depositos_comprobante/';
         $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
         $imgProducto = $img_nombre.'.jpg';
         $imgProducto2 = $img_nombre.'.png';
         $src = $destino.$imgProducto;
        }

        $query_insert=mysqli_query($conection,"INSERT INTO saldo_leben_1804843900(id_usuario,img_deposito,cantidad,numero_unico,metodo,tipo_banco)
                                      VALUES('$iduser','$imgProducto','$cantidad','$numero_unico','Deposito','$tipo_banco') ");
                                      if ($query_insert) {
                                        if ($nombre_foto != '') {
                                          move_uploaded_file($url_temp,$src);
                                        }
                                        try {
                                             // Configuración del servidor
                                            $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                            $mail -> isSMTP ();                                          // Enviar usando SMTP
                                            $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                            $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                            $mail ->Username = 'depositos@guibis.com' ;                       // Nombrede usuario SMTP
                                            $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                            $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                            $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                            // Destinatarios
                                            $mail -> setFrom ( 'depositos@guibis.com' , 'Departamento Financiero' );  // Agrega un destinatario
                                            $mail -> addAddress ( $email);     // Agrega un destinatario
                                            $mail -> addAddress ('depositos@guibis.com');
                                            // Contenido
                                            $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                            $mail->CharSet = 'UTF-8';
                                            $mail -> Subject = 'Déposito Bancario';
                                            $mail -> Body     = '
                                              <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
                                                <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                                                  <div class="logo-empresa" style="text-align: center;">
                                                    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
                                                  </div>
                                                  <div class="contenedor-informacion" style="text-align: justify;">
                                                    <div class="">
                                                      <div class="">
                                                        <p>Hola <span>'.$nombres.' '.$apellidos.'</span>. se ha enviado un solicitud de un Depósito Bancario a nuestras cuentas para tener disponible dinero Electrónicos
                                                        y puedas realizar compras a las tiendas o apoyar a las instituciones que estan en nuestro sitio, el monto que enviaste a verificacíon es de <span>$'.$cantidad.' mediante cuenta '.$tipo_banco.'
                                                      nuestro equipo esta verificando tu transacción en unos minutos recibiras un email de confirmación. </p>
                                                      </div>
                                                    </div>
                                                    <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
                                                      <p>Si tienes alguna duda comunicate con nuestro equipo</p>
                                                      <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a>
                                                      <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:depositos@guibis.com">depositos@guibis.com</a>
                                                    </div>
                                                    <div class="redes-sociales">
                                                      <div class="redes_email" style="text-align: center;">
                                                        <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                                        <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                                        <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
                                                      </div>
                                                  </div>
                                                  <div class="footer" style="font-size: 10px;">
                                                    <p>Este mensaje fue enviado en automático no responsas a este mensaje, te recordamos que esta transacción no tiene costo ninguno y tampoco tarifa de cobro, el total cantidad a verificación es el total que una vez verificado el total que se va importar dentro de guibis.com , en caso de que no se verifique el deposito de forma correcta o hay sido con la intención de estafar se desactivara la cuenta y se procederá de manera inmediata apegada a la ley, se recuerda que para realizar transacciones se activa con la cedula de ciudadanía es decir se puede activar una sola vez. </p>

                                                  </div>

                                                </div>
                                                </div>

                                              </body>


                                              ' ;
                                            $mail -> send ();
                                        } catch ( Exception  $e ) {
                                        }
                                        // code..





                                          $arrayName = array('noticia' =>'pago_agregado');
                                          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



                                        }else {
                                          $arrayName = array('noticia' =>'error');
                                         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                        }



      }












        if ($_POST['action'] == 'retiro_bancario') {
          $mifecha = new DateTime();
          $mifecha->modify('-24 hour');
          $fecha_menos_24_horas =  $mifecha->format('Y-m-d H:i:s');
            $query_ventas_24 = mysqli_query($conection, "SELECT SUM(ventas.precio_compra) as 'ventas_24' FROM `ventas`
             WHERE ventas.id_comprador = $iduser AND ventas.fecha >= '$fecha_menos_24_horas'");
            $result_ventas_24 = mysqli_fetch_array($query_ventas_24);
            $ventas_24 =  $result_ventas_24['ventas_24'];
            if (empty($ventas_24)) {
              $verificacion_venta = 0;
            }else {
              $verificacion_venta = 1;
            }

            $query_depositos_24 = mysqli_query($conection, "SELECT SUM(saldo_leben_1804843900.cantidad) as 'depositos_24' FROM saldo_leben_1804843900
             WHERE saldo_leben_1804843900.id_usuario = $iduser AND saldo_leben_1804843900.fecha_deposito >= '$fecha_menos_24_horas' AND saldo_leben_1804843900.estado = 'Finalizado';");
            $result_depositos_24 = mysqli_fetch_array($query_depositos_24);
            $depositos_24 =  $result_depositos_24['depositos_24'];
            if (empty($depositos_24)) {
              $verificacion_depositos = 0;
            }else {
              $verificacion_depositos = 1;
            }
            $query_ultimo_deposito = mysqli_query($conection, "SELECT * FROM `saldo_leben_1804843900`
               WHERE saldo_leben_1804843900.id_usuario = $iduser AND saldo_leben_1804843900.estado='Finalizado' ORDER BY saldo_leben_1804843900.fecha_deposito DESC LIMIT 1;");
            $result_ultimo_deposito = mysqli_fetch_array($query_ultimo_deposito);
            $fecha_deposito =  $result_ultimo_deposito['fecha_deposito'];
            if ($fecha_menos_24_horas > $fecha_deposito) {
              //Se puede hacer la transferencia normalmente
            }else {
              if ($verificacion_venta == 0) {
                $arrayName = array('noticia' =>'menos_24_horas_sin_compra');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               exit;
              }else {
                  //Se hace la transferencia con condicion de compra
              }
            }
          $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
          $result = mysqli_fetch_array($query);
          $banco_tipo_retiro = $_POST['banco_tipo_retiro'];
          $password_bd       =  $result['password'];
          $cantidad          = $_POST['cantidad'];
          $password          = md5($_POST['password']);

          if ($mi_leben != 'Activa') {
            $arrayName = array('noticia' =>'cuenta_bancaria_inactiva');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            exit;
          }

          $query_financiero = mysqli_query($conection, "SELECT * FROM `saldo_total_leben`
           INNER JOIN usuarios ON saldo_total_leben.idusuario = usuarios.id
           WHERE usuarios.id = $iduser");
           $result_financiero = mysqli_fetch_array($query_financiero);
           $cantidad_existente =  $result_financiero['cantidad'];

           if ($cantidad_existente >= $cantidad) {

          if ($password == $password_bd) {

           $cantidad_actualizada = (int)$cantidad_existente-(int)$cantidad;
          $query_edit_saldo=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$cantidad_actualizada'  WHERE idusuario='$iduser' ");

          $query_insert=mysqli_query($conection,"INSERT INTO retiros_leben1804843900(id_usuario,cantidad,metodo)
                                        VALUES('$iduser','$cantidad','$banco_tipo_retiro') ");
                                        if ($query_insert && $query_edit_saldo ) {
                                          try {
                                               // Configuración del servidor
                                              $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                              $mail -> isSMTP ();                                          // Enviar usando SMTP
                                              $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                              $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                              $mail ->Username = 'retiros@guibis.com' ;                      // Nombrede usuario SMTP
                                              $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                              $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                              $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                              // Destinatarios
                                              $mail -> setFrom ( 'retiros@guibis.com' , 'Financiero Guibis' );  // Agrega un destinatario
                                              $mail -> addAddress ( $email);     // Agrega un destinatario
                                              $mail -> addAddress ( 'retiros@guibis.com');
                                              // Contenido
                                              $mail -> isHTML ( true );
                                              $mail->CharSet = 'UTF-8';                            // Establecer el formato de correo electrónico en HTML
                                              $mail -> Subject = 'RETIRO '.$banco_tipo_retiro.' EN PROCESO';
                                              $mail -> Body     = '

                                                 <body style="background: #f5f5f5;padding: 10px;margin: 25px;">
                                                   <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                                                     <div class="logo-empresa" style="text-align: center;">
                                                       <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
                                                     </div>
                                                     <div class="contenedor-informacion" style="text-align: justify;">
                                                       <div class="">
                                                         <div class="">
                                                           <p>Hola '.$nombres.' '.$apellidos.' haz hecho un retiro desde tu cuenta principal hacia la cuenta '.$banco_tipo_retiro.' por un valor
                                                             de  $'.number_format($cantidad,2).' dólares Americanos, en unos minutos se realizara efectivo la transacción la misma puedes mirar en historial y la verificación con una imagen de respaldo</p>
                                                         </div>
                                                       </div>
                                                       <div class="soporte" style="text-align: center;padding: 10px;margin: 5px;">
                                                         <p>Si tienes alguna duda comunicate con nuestro equipo</p>
                                                         <a style="display: block;text-decoration: none;padding: 10px;" href="tel:+593998855160">+593998855160</a>
                                                         <a style="display: block;text-decoration: none;padding: 10px;" href="mailto:depositos@guibis.com">depositos@guibis.com</a>
                                                       </div>
                                                       <div class="redes-sociales">
                                                         <div class="redes_email" style="text-align: center;">
                                                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                                           <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
                                                         </div>
                                                     </div>
                                                     <div class="footer" style="font-size: 10px;">
                                                       <p>Este mensaje fue enviado en automático no responsas a este mensaje, te recordamos que esta transacción no tiene costo ninguno y tampoco tarifa de cobro, el total cantidad a verificación es el total que una vez verificado el total que se va importar dentro de guibis.com , en caso de que no se verifique el deposito de forma correcta o hay sido con la intención de estafar se desactivara la cuenta y se procederá de manera inmediata apegada a la ley, se recuerda que para realizar transacciones se activa con la cedula de ciudadanía es decir se puede activar una sola vez, para reaizar retiros la cuenta vinculada a la plataforma tiene que ser del mimso titular caso contrario se declina la transferencia de manera inmediata.</p>

                                                     </div>

                                                   </div>
                                                   </div>

                                                 </body>





                                                 ' ;
                                              $mail -> send ();
                                          } catch ( Exception  $e ) {
                                          }
                                          // code..


                                            $arrayName = array('noticia' =>'retiro_agregado','cantidad' =>number_format($cantidad_actualizada,2));
                                            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                          }else {
                                            $arrayName = array('noticia' =>'error');
                                           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                          }

             }else {
               $arrayName = array('noticia' =>'contrasena_incorrecta');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }


          }else {
            $arrayName = array('noticia' =>'saldo_insuficiente');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }

    }




 ?>
