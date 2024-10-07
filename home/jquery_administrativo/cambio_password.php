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




  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];
  function getRealIP(){
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


       if ($ambito_area =='prueba') {
         $direccion_ip =  '186.42.10.78';
       }
       if ($ambito_area =='produccion') {
         $direccion_ip = (getRealIP());
         // code...
       }
       $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));


       $pais            = $datos['country'];
       $ciudad            = $datos['city'];
       $provincia         = $datos['regionName'];




       $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE id='$iduser'");
       $result = mysqli_fetch_array($query);
       $codigp_password = $result['password'];
       $contrasena_actual = md5($_POST['contrasena_actual']);
       $email_user = $result['email'];


  if ($codigp_password == $contrasena_actual) {


    $new_contrasena = md5($_POST['new_contrasena']);
    $new_contrasena_dos = md5($_POST['new_contrasena_dos']);
    if ($new_contrasena!=$new_contrasena_dos ) {
      $arrayName = array('noticia' =>'contra_diferentes' );
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;

    }

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

        $apellidos  = $result['apellidos'];
        $nombres    = $result['nombres'];
        $iduser     = $result['id'];
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET  password='$new_contrasena' WHERE id='$iduser' ");
        if ($query_insert) {
                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'soporte-cuenta@guibis.com' ;                    // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'soporte-cuenta@guibis.com' , 'Sistema de Soporte de Contraseña' );
                      $mail -> addAddress ( $email_user);     // Agrega un destinatario
                      $mail -> addAddress ('soporte-cuenta@guibis.com');


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                      $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cambio de contraseña Exitoso' ;
                      $mail -> Body     =

                         "
                         <body style='background: #f5f5f5;padding: 6px;margin: 25px;'>
                             <div class='contenedor' style='background: #fff;padding: 20px;margin: 10px;'>
                                 <div class='logo-empresa' style='text-align: center;'>
                                  <img src='{$url}/img/guibis.png' alt='Logo de la Empresa' style='width: 200px;'>
                                 </div>
                                 <div class='contenedor-informacion' style='text-align: justify;'>
                                     <p>¡Hola <span>{$nombres}</span>!</p>
                                     <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
                                     <p>Si no has realizado esta solicitud, por favor ignora este correo. Lugar del Cambio de Contraeña</p>
                                     <p style='text-align: center;'>
                                         <strong>{$direccion_ip} en {$pais}-{$ciudad}-{$provincia} </strong>
                                     </p>
                                     <p>Si tienes alguna pregunta o encuentras algún problema, no dudes en responder a este correo. Estamos aquí para ayudarte.</p>
                                     <p>Saludos cordiales,<br>El Equipo de soporte</p>
                                 </div>
                             </div>
                         </body>


                         ";
                         $mail -> send ();
                     } catch ( Exception  $e ) {
                     }


           $arrayName = array('noticia' =>'positiva' );
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_servidor' );
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }

  }else {
    $arrayName = array('noticia' =>'contrasena_invalida' );
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }



 ?>
