<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
  include "../../coneccion.php";
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');
  }else {
  }
   $iduser= $_SESSION['id'];

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


  if ($codigp_password == $contrasena_actual) {


    $new_contrasena = md5($_POST['new_contrasena']);
    $new_contrasena_dos = md5($_POST['new_contrasena_dos']);
    if ($new_contrasena!=$new_contrasena_dos ) {
      $arrayName = array('noticia' =>'contra_diferentes' );
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;

    }



        $apellidos  = $result['apellidos'];
        $nombres    = $result['nombres'];
        $iduser     = $result['id'];
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET  password='$new_contrasena' WHERE id='$iduser' ");
        if ($query_insert) {

                 $filep = '../archivos/accioncomprar/plan_guibis.pdf';
                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'cwpjava.hostingsupremo.org' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'soporte-cuenta@guibis.com' ;                    // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'cwpjava.hostingsupremo.org' , 'SOPORTE' );
                      $mail -> addAddress ( $email);     // Agrega un destinatario
                      $mail -> addAddress ('cwpjava.hostingsupremo.org');


                      $mail->AddAttachment($filep, 'plan_guibis.pdf');


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                      $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cambio de contraseña Exitoso' ;
                      $mail -> Body     = '


<body style="background: #f5f5f5;padding: 6px;margin: 25px;">
  <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
    <div class="logo-empresa" style="text-align: center;">
      <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
    </div>
    <div class="contenedor-informacion" style="text-align: justify;">
      <div class="">
        <div class="">
        <div class="">
          <h2>CAMBIO DE CONTRASEÑA EXITOSO</h2>
          <p>'.$nombres.' cambio de contraseña correcto, se lo realizo en un dispositivo con dirección IP  '.$direccion_ip.' en '.$pais.' - '.$ciudad.' - '.$provincia.',
          si no fuiste cominucate con nuestras lineas directas  </p>

        </div>
        <div class="">
        <p>Nuestro motor antifraude es un sistema automatizado que permite  a todos los usuarios registrados, mitigar posibles escenarios fraudulentos que se pueden presentar, asi como tambien comportamientos inusuales, el sistema de guibis.com
        no funiona con tarjeta de crédito ni débito, funciona con recargas por lo que tu información bancaria con nosotros esta protegida, para los pagos de la plataforma  se requiere solamente el número de cuenta para realizar la transferencia y asi  para poder realizar las transacciones sin limites las 24 horas del dia los
      365 dias del año.   </p>
          <dt style="font-weight: bold;padding: 6px;color: #263238;font-size: 16px;">Comercio Electrónico</dt>
          <dd style="padding: 7px;margin: 5px;font-size: 14px;">Con guibis.com puedes subir tus productos em general. servicios de suscripción, boleteria digital y servicios de suscripción totalmente gratis, prepara la información necesaria para que puedas subir desde imagenes, mapas, videos y caracteristicas dependiendo
          su categoria y subcategoria, forma un perfil con tus redes sociales y recibe los pagos directos en tus cuenta digital para que puedas retirar dinero directo
           a tus cuentas bancarias, realiza marketing con los recursos con el código Qr generado en tu perfil y en cada producto.</dd>
        </div>

         <div class="">
           <dt style="font-weight: bold;padding: 6px;color: #263238;font-size: 16px;">Facturación Electrónica y control de tu empresa o emprendimiento.</dt>
           <dd style="padding: 7px;margin: 5px;font-size: 14px;">Guibis da el servicio a las empresas y emprendimientos el controlar sus finazas con la tecnología de <a style="text-decoration: none;font-weight: bold;padding: 5px;margin: 3px;" href="#">facturacion.guibis.com</a> se puede abrir cajas, manejar inventario, notas de ventas en PDF y el envio al correo electrónico del cliente, reenvio de notas de venta y
           de la facturación electrónica en Ecuador totalmente gratis ! </dd>
         </div>
         <div class="">
           <dt style="font-weight: bold;padding: 6px;color: #263238;font-size: 16px;">Transporte Guibis</dt>
           <dd style="padding: 7px;margin: 5px;font-size: 14px;">La inseguridad en el mundo en el que vivimos nos preocupo y hemos lanzado la plataforma de <a style="text-decoration: none;font-weight: bold;padding: 5px;margin: 3px;" href="#">Transporte Guibis</a> que maneja la logistica del comercio electrónico realizado en <a style="text-decoration: none;font-weight: bold;padding: 5px;margin: 3px;" href="#">guibis.com</a> y el traslado de los productos hacia los clientes, para ello
           si deseas trabajar o ocupar el servicio sigue los siguientes enlaces</dd>
         </div>
         <div class="">
           <dt style="font-weight: bold;padding: 6px;color: #263238;font-size: 16px;">Servicio de Transporte Guibis</dt>
           <dd style="padding: 7px;margin: 5px;font-size: 14px;">Guibis.com tiene una rigurosa aceptación de los conductores para ello no aceptamos conductores que tengan relación directa con la inseguridad, dando la confianza a nuestra comunidad</dd>
         </div>
         <div class="">
           <dt style="font-weight: bold;padding: 6px;color: #263238;font-size: 16px;">Servidores Hosting y Dominios</dt>
           <dd style="padding: 7px;margin: 5px;font-size: 14px;">Nuestros servidores tiene la capacidad y parametros necesarios para poder brindar un servicio de calidad, tenemos planes desde un dolar mensual y dominios desde 2,60 anuales , para elllo puede ver los precios en el siguiente enlace o entrar directamente. </dd>
         </div>
        </div>
      </div>

      <div class="redes-sociales">
        <div class="redes_email" style="text-align: center;">
          <a style="text-align: center; margin:3px; padding:4px;" href="https://www.facebook.com/guibisEcuador"><img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
          <a style="text-align: center; margin:3px; padding:4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"><img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
          <a style="text-align: center; margin:3px; padding:4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"><img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
        </div>
    </div>
    <div class="footer" style="font-size: 10px;">
      <p style="color: #c1c1c1;">Este es un mensaje enviado en automatico no responsas a este mensaje, guibis.com es una empresa que tiene tecnología en la cual evita las estafas al comprar y vender por intenet, tienes su propia pasarela de pagos y con ello controla las estafas o posibles escenarios fraudulentos,
        toda la información que se registra en nuestro sitio nos brinda la potestad de activar cuentas de acuerdo a nuestros criterios y con ello salvaguardar la cominudad de guibis.com si deseas soporte directo contacta con nuestras lineas soporte@guibis.com, o al teléfono 0998855160, nosotros como empresa respaldamos los datos sin estar ligados con terceras
      empresas por lo que la seguridad externa del usuariio es netamente del usuario.</p>
    </div>

  </div>
  </div>

</body>



                         ' ;
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
