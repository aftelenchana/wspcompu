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

    if ($_SESSION['rol'] == 'Recursos Humanos') {
    include "../sessiones/session_recursos_humanos.php";

    }



 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT clientes.id,clientes.secuencial,clientes.nombres,clientes.foto,
     clientes.url_img_upload,clientes.identificacion,clientes.fecha_nacimiento,clientes.genero,
     clientes.celular,clientes.telefono,clientes.mail,clientes.latitud,clientes.longitud FROM clientes
      WHERE clientes.iduser ='$iduser'  AND clientes.estatus = '1'
   ORDER BY `clientes`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {

  $fecha_nacimiento = $row['fecha_nacimiento'];
  $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
  $fecha_actual = new DateTime();
  $diferencia = $fecha_actual->diff($fecha_nacimiento_obj);
  $edad = $diferencia->y;
  $row['edad'] = $edad.' Años';
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_clientes') {

      $identificacion   =  mysqli_real_escape_string($conection,$_POST['identificacion']);

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
             $destino = '../img/uploads/';
             $img_nombre = 'cliente'.md5(date('d-m-Y H:m:s').$iduser);
             $imgProducto = $img_nombre.'.'.$extension;
             $src = $destino.$imgProducto;
               move_uploaded_file($url_temp,$src);
           }else {
             $imgProducto = 'paciente.png';
             // code...
           }
           $nombres             = mb_strtoupper($_POST['nombres']);
           $mail                = mb_strtoupper($_POST['mail_user']);

          $nombres               =  mysqli_real_escape_string($conection,$_POST['nombres']);
          $mail_user             =  mysqli_real_escape_string($conection,$_POST['mail_user']);
          $tipo_identificacion   =  mysqli_real_escape_string($conection,$_POST['tipo_identificacion']);
          $direccion             =  mysqli_real_escape_string($conection,$_POST['direccion']);
          $celular               =  mysqli_real_escape_string($conection,$_POST['celular']);
          $actividad_economica   =  mysqli_real_escape_string($conection,$_POST['actividad_economica']);
          $ciudad                =  mysqli_real_escape_string($conection,$_POST['ciudad']);
          $provincia             =  mysqli_real_escape_string($conection,$_POST['provincia']);
          $telefono              =  mysqli_real_escape_string($conection,$_POST['telefono']);
          $estado_civil          =  mysqli_real_escape_string($conection,$_POST['estado_civil']);

          $direccion_cliente      =  mysqli_real_escape_string($conection,$_POST['direccion']);

          $fecha_nacimiento   =  mysqli_real_escape_string($conection,$_POST['fecha_nacimiento']);
          $historial_medico             =  mysqli_real_escape_string($conection,$_POST['historial_medico']);
          $alergias                =  mysqli_real_escape_string($conection,$_POST['alergias']);
          $genero             =  mysqli_real_escape_string($conection,$_POST['genero']);


          $img_nombre = 'guibis_paciente'.md5(date('d-m-Y H:m:s'));
          $qr_img = $img_nombre.'.png';
          $contenido = md5(date('d-m-Y H:m:s').$iduser);

          $direccion_qr = '../img/qr/';
          $filename = $direccion_qr.$qr_img;
          $tamanio = 7;
          $level = 'H';
          $frameSize = 5;
          $contenido = $contenido;
          QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);

          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


          $query_secuencial = mysqli_query($conection, "SELECT * FROM  clientes   WHERE  clientes.iduser  = '$iduser'  ORDER BY fecha DESC");
          $data_secuencial = mysqli_fetch_array($query_secuencial);
          if ($data_secuencial) {
            $secuencial_cliente = $data_secuencial['secuencial']+1;
          }else {
            $secuencial_cliente =1;
          }

          $secuencial_cliente  = str_pad($secuencial_cliente, 9, "0", STR_PAD_LEFT);








   $query_insert=mysqli_query($conection,"INSERT INTO clientes(secuencial,nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,sistema,qr,qr_contenido,
   actividad_economica,parroquia,ciudad,provincia,url_img_upload,url_upload_qr,telefono,fecha_nacimiento,historial_medico,alergias,genero,estado_civil)
                                 VALUES('$secuencial_cliente','$nombres','$mail','$tipo_identificacion','$direccion_cliente','$identificacion','$celular','$imgProducto','$iduser','facturacion','$qr_img','$contenido',
                                 '$actividad_economica','parroquia','$ciudad','$provincia','$url','$url','$telefono','$fecha_nacimiento','$historial_medico','$alergias','$genero','$estado_civil') ");

   if ($query_insert) {

             $query_correo_registro= mysqli_query($conection, "SELECT * FROM credenciales_correos  WHERE area = 'registro'");
             $data_correo_registro = mysqli_fetch_array($query_correo_registro);

             $Host_registro        = $data_correo_registro['Host'];
             $Username_registro    = $data_correo_registro['Username'];
             $Password_registro    = $data_correo_registro['Password'];
             $Port_registro        = $data_correo_registro['Port'];
             $SMTPSecure_registro  = $data_correo_registro['SMTPSecure'];


     $mail = new  PHPMailer ( true );
    try {
      // Configuración del servidor
      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
      $mail -> isSMTP ();                                          // Enviar usando SMTP
      $mail -> Host        = "$Host_registro" ;                  // Configure el servidor SMTP para enviar a través de
      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
      $mail->Username = "$Username_registro";
      $mail->Password = "$Password_registro";                              // Contraseña SMTP
      $mail -> SMTPSecure = "$SMTPSecure_registro";         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
      $mail->Port = "$Port_registro";                            // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

      // Destinatarios
      $mail -> setFrom ($Username_registro , 'Soporte Cuenta' );
      $mail -> addAddress ($mail_user);     // Agrega un destinatario

      // Contenido
      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'Creación de Historia Clínica';

  $mail->Body = '
      <body style="background: #f5f5f5; padding: 6px; margin: 25px;">
          <div class="contenedor" style="background: #fff; padding: 20px; margin: 10px;">
              <div class="logo-empresa" style="text-align: center;">
                  <img src="' . $url . '/img/guibis.png" style="width: 200px;">
              </div>
              <div class="contenedor-informacion" style="text-align: justify;">
                  <p>Estimado/a ' . $nombres . ',</p>
                  <p>Le informamos que su historia clínica ha sido creada satisfactoriamente en nuestro sistema. Aquí tiene los detalles de su registro:</p>
                  <table style="width: 99%; border-collapse: collapse; margin-top: 20px; margin-left: auto; margin-right: auto;">
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Nombres y Apellidos:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $nombres . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Correo Electrónico:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $mail_user . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Tipo de Identificación:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $tipo_identificacion . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Dirección:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $direccion . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Celular:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $celular . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Actividad Ecnómica:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $actividad_economica . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Ciudad:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $ciudad . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Provincia:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $provincia . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Teléfono:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $telefono . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Fecha de Nacimiento:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $fecha_nacimiento . '</td>
                      </tr>

                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Alergias:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $alergias . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Genero:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">' . $genero . '</td>
                      </tr>
                      <tr>
                          <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Historia Clínica:</th>
                          <td style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">'. $secuencial_cliente.'</td>
                      </tr>
                      <!-- Incluir otros detalles relevantes aquí -->
                  </table>
                  <p>Para cualquier consulta o modificación de sus datos, no dude en contactarnos.</p>
                  <p>Atentamente,</p>
                  <p>El Equipo de Guibis</p>
              </div>
          </div>
      </body>
  ';



  if (!$mail->send()) {
      // Manejo del caso de fallo en el envío
      $response = array('noticia_email' => 'error_envio','noticia' =>'insert_correct');
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
      // Manejo del caso de éxito en el envío
      $response = array('noticia_email' => 'envio_exitoso','noticia' =>'insert_correct');
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
} catch (Exception $e) {
  // Manejo de una excepción durante la configuración o el envío
  $response = array('noticia_email' => 'error_excepcion','noticia' =>'insert_correct','detalle' => 'Ocurrió un error al intentar enviar el correo','error' => $e->getMessage());
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}


     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM clientes
         WHERE clientes.iduser ='$iduser'  AND clientes.estatus = '1' AND clientes.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_clientes') {

   $id_paciente   =  mysqli_real_escape_string($conection,$_POST['id_cliente']);

   if (!empty($_FILES['foto']['name'])) {
     $foto           =    $_FILES['foto'];
     $nombre_foto    =    $foto['name'];
     $type 					 =    $foto['type'];
     $url_temp       =    $foto['tmp_name'];
     $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
     $destino = '../img/uploads/';
     $img_nombre = 'paciente_guibis'.md5(date('d-m-Y H:m:s').$iduser);
     $img_paciente = $img_nombre.'.'.$extension;
     $src = $destino.$img_paciente;
       move_uploaded_file($url_temp,$src);

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
    $url_img_upload = $url;
   }else {
     $query_cliente = mysqli_query($conection, "SELECT * FROM clientes WHERE clientes.id = $id_paciente");
     $data_cliente = mysqli_fetch_array($query_cliente);
     $img_paciente     = $data_cliente['foto'];
     $url_img_upload  = $data_cliente['url_img_upload'];
   }


   $nombres              =  mysqli_real_escape_string($conection,$_POST['nombres']);
   $mail            =  mysqli_real_escape_string($conection,$_POST['mail_user']);
   $direccion            =  mysqli_real_escape_string($conection,$_POST['direccion']);
   $identificacion       =  mysqli_real_escape_string($conection,$_POST['identificacion']);
   $celular              =  mysqli_real_escape_string($conection,$_POST['celular']);
   $telefono             =  mysqli_real_escape_string($conection,$_POST['telefono']);
   $tipo_identificacion  =  mysqli_real_escape_string($conection,$_POST['tipo_identificacion']);
   $fecha_nacimiento     =  mysqli_real_escape_string($conection,$_POST['fecha_nacimiento']);
   $historial_medico     =  mysqli_real_escape_string($conection,$_POST['historial_medico']);
   $alergias             =  mysqli_real_escape_string($conection,$_POST['alergias']);
   $genero               =  mysqli_real_escape_string($conection,$_POST['genero']);
   $estado_civil         =  mysqli_real_escape_string($conection,$_POST['estado_civil']);


   $query_insert = mysqli_query($conection,"UPDATE clientes SET nombres='$nombres',mail='$mail',direccion='$direccion',
     identificacion='$identificacion', celular='$celular',telefono='$telefono',tipo_identificacion='$tipo_identificacion',
     fecha_nacimiento='$fecha_nacimiento',historial_medico='$historial_medico',alergias='$alergias',genero='$genero',url_img_upload='$url_img_upload'
     ,foto='$img_paciente',estado_civil='$estado_civil'
     WHERE id = '$id_paciente'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_paciente'=> $id_paciente,'imagen_cliente'=> $img_paciente,'url_img_upload'=> $url_img_upload);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_cliente') {
   $cliente             = $_POST['cliente'];

   $query_delete=mysqli_query($conection,"UPDATE clientes SET estatus= 0  WHERE id='$cliente' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cliente'=> $cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
