<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
require '../QR/phpqrcode/qrlib.php';


$query_config = mysqli_query($conection, "SELECT * FROM `configuraciones` ");
$result_config = mysqli_fetch_array($query_config);
$nombre_empresa_ttt = $result_config['nombre_empresa'];
$foto_representativa = $result_config['foto_representativa'];


if  ($_POST['action'] == 'registrarme') {
  $nombres    =  strtoupper($_POST['nombre']);
  $apellidos  =  strtoupper($_POST['apellidos']);
  $email      =  strtolower($_POST['email']);
  $codigo_registro = strtoupper(md5($email.date('d-m-Y H:m:s')));



  $fecha      =  $_POST['fecha_nacimiento'];
  $password1  =  md5($_POST['password1']);
  $password2  =  md5($_POST['password2']);
  $celular    =  $_POST['celular2'];



  $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE email='$email'");
  $result = mysqli_fetch_array($query);
  if ($result > 0) {
    $arrayName = array('correo_existe' =>'el_correo_ya_existe');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

  }else {
    if ($password1 == $password2) {

      $query_insert=mysqli_query($conection,"INSERT INTO usuarios(nombres,apellidos,email,password,celular2,fecha,codigo_registro) VALUES('$nombres','$apellidos','$email','$password1','$celular','$fecha','$codigo_registro') ");
      if ($query_insert) {
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
          $mail -> Subject = 'Código de Registro' ;
          $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
            <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

          </div>
          <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
             <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.' !!</h3>
             <p style="font-weight: bold; font-style: italic;" >Bienvenido a Guibis.com</p>
             <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">
              Bienvenido a Guibis.com, sigue este enlace para completar tu registro <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com/login?codigo_registro='.$codigo_registro.'">Comprar o Vender en Guibis.com</a>  </p>
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



        $arrayName = array('registro' =>'correcto');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


      }else {
        $arrayName = array('notsesion' =>'error_iniciar_sesion');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


      }
   }else {
     $arrayName = array('contrasena' =>'contrasena_no_coinciden');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
  }
}





 if ($_POST['action'] == 'login_usuario') {
   $email = $_POST['mail_user'];
  $clave= md5($_POST['password_user']);

   $query = mysqli_query($conection,"SELECT * FROM usuarios WHERE email='$email' and password='$clave'");
   $result= mysqli_num_rows($query);
   if ($result>0) {
     $data= mysqli_fetch_array($query);
     $_SESSION['active']=true;
     $_SESSION['id']=$data['id'];
     $_SESSION['email']=$data['email'];
     if (!empty($_SESSION['active'])) {
       header('location:../../home/index.php');
     }

   }else {
     $alert='EL USUARIO O LA CLAVE SON INCORRECTOS';
     session_destroy();
   }
 }

 ?>
