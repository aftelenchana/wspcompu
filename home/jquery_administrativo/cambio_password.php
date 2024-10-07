<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

$mail = new  PHPMailer ( true );

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }


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


      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

      if ($url =='http://localhost') {
        $direccion_ip =  '186.42.10.32';
      }else {
        $direccion_ip = (getRealIP());
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


        $nombres    = $result['nombres'];
        $iduser     = $result['id'];
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET  password='$new_contrasena' WHERE id='$iduser' ");


        if ($query_insert) {

          $query_correo_registro= mysqli_query($conection, "SELECT * FROM credenciales_correos  WHERE area = 'registro'");
          $data_correo_registro = mysqli_fetch_array($query_correo_registro);

          $Host_registro        = $data_correo_registro['Host'];
          $Username_registro    = $data_correo_registro['Username'];
          $Password_registro    = $data_correo_registro['Password'];
          $Port_registro        = $data_correo_registro['Port'];
          $SMTPSecure_registro  = $data_correo_registro['SMTPSecure'];


                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = "$Host_registro" ;                // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail->Username = "$Username_registro";                   // Nombrede usuario SMTP
                      $mail->Password = "$Password_registro";                               // Contraseña SMTP
                      $mail -> SMTPSecure = "$SMTPSecure_registro";          // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail->Port = "$Port_registro";                                        // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( $Username_registro , 'Sistema de Soporte de Contraseña' );
                      $mail -> addAddress ( $email_user);     // Agrega un destinatario
                      $mail -> addAddress ($Username_registro);


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
                         if (!$mail->send()) {
                             // Manejo del caso de fallo en el envío
                             $response = array('noticia_email' => 'error_envio','noticia' =>'positiva');
                             echo json_encode($response, JSON_UNESCAPED_UNICODE);
                         } else {
                             // Manejo del caso de éxito en el envío
                             $response = array('noticia_email' => 'envio_exitoso','noticia' =>'positiva');
                             echo json_encode($response, JSON_UNESCAPED_UNICODE);
                         }
                     } catch (Exception $e) {
                         // Manejo de una excepción durante la configuración o el envío
                         $response = array('noticia_email' => 'error_excepcion','noticia' =>'positiva','detalle' => 'Ocurrió un error al intentar enviar el correo','error' => $e->getMessage());
                         echo json_encode($response, JSON_UNESCAPED_UNICODE);
                     }




        }else {
          $arrayName = array('noticia' =>'error_servidor' );
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }

  }else {
    $arrayName = array('noticia' =>'contrasena_invalida' );
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }



 ?>
