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

    if ($_SESSION['rol'] == 'Paciente') {
     include "../sessiones/session_paciente.php";
     // code...
   }





$query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.mi_leben FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$email = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
$mi_leben = $result['mi_leben'];




if ($_POST['action'] == 'agregar_ubicacion') {
  $latitud = $_POST['latitud'];
  $longitud = $_POST['longitud'];
  $query_insert=mysqli_query($conection,"UPDATE clientes SET longitud='$longitud',latitud='$latitud'  WHERE id='$idpaciente' ");
  if ($query_insert) {
    $arrayName = array('noticia' =>'ubicacion_agregada_correctamente','longitud' =>$longitud,'latitud'=>$latitud);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

 }else {
   $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }

}







if ($_POST['action'] == 'add_foto_logo_empresarial') {
  $foto           =    $_FILES['foto'];
  $nombre_foto    =    $foto['name'];
  $type 					 =    $foto['type'];
  $url_temp       =    $foto['tmp_name'];
  $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);

   $destino = '../img/uploads/';
   $img_nombre = 'guibis_logo'.md5(date('d-m-Y H:m:s').$iduser);
   $imgProducto = $img_nombre.'.'.$extension;
   $src = $destino.$imgProducto;

   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;



   $query_insert=mysqli_query($conection,"UPDATE usuarios SET img_facturacion ='$imgProducto',url_img_upload='$url'  WHERE id='$iduser' ");
  if ($query_insert) {
      if ($nombre_foto != '') {
        move_uploaded_file($url_temp,$src);
      }

      $arrayName = array('img' =>$imgProducto,'noticia'=>'insert_correct','extension'=>$extension);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



    }else {
      $arrayName = array('noticia' =>'error_insertar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
}

if ($_POST['action'] == 'agregar_firma_electronica') {
  $firma_electronocia           =    $_FILES['firma_electronocia'];
  $nombre_firma_electronica     =    $firma_electronocia['name'];
  $type 					              =    $firma_electronocia['type'];
  $url_temp                     =    $firma_electronocia['tmp_name'];

  $firma_electronica   =   'firma_electronica.p12';
  if ($nombre_firma_electronica != '') {
   $destino = '../facturacion/facturacionphp/controladores/firmas_electronicas/';
   $img_nombre = 'firma_guibis'.md5(date('d-m-Y H:m:s').$iduser);
   $firma_electronica = $img_nombre.'.p12';
   $src = $destino.$firma_electronica;
   move_uploaded_file($url_temp,$src);
  }
  //hasta aqui esta subida la firma electronica
   $clave = ($_POST['codigo_sri']);

   require_once '../facturacion/facturacionphp/lib/nusoap.php';

   $almacen_cert = file_get_contents($src);

  if (openssl_pkcs12_read($almacen_cert, $info_cert, $clave)) {
    // Asumiendo que $info_cert es tu array que contiene la información del certificado
    $certificado = openssl_x509_read($info_cert["cert"]);
    $detalles = openssl_x509_parse($certificado);
    // Fecha de caducidad del certificado
    $fechaCaducidad = $detalles['validTo_time_t'];
    // Convertir la fecha de caducidad a un formato legible
    $fechaCaducidadLegible = date('Y-m-d H:i:s', $fechaCaducidad);

      // Obtener la fecha y hora actual
      $fechaActual = date('Y-m-d H:i:s');

      // Comparar las fechas
      if (strtotime($fechaCaducidadLegible) > strtotime($fechaActual)) {
         $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

        $query_edit = mysqli_query($conection,"UPDATE usuarios SET firma_electronica='$firma_electronica' ,codigo_sri='$clave',fecha_caducidad_firma='$fechaCaducidadLegible',url_firma_electronica='$url' WHERE id='$iduser' ");
          if ($query_edit) {
              $arrayName = array('noticia'=>'insert_correct','fecha_caducidad'=>$fechaCaducidadLegible);
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

            }else {
              $arrayName = array('noticia' =>'error_insertar');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }

      } else {
        unlink($src);
        $arrayName = array('noticia' => 'firma_caducada');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      }



   }else {
     unlink($src);
     $arrayName = array('noticia' => 'error_credenciales_firma_clave');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }

}

if ($_POST['action'] == 'agregar_codigo_sri') {

   $codigo_sri = ($_POST['codigo_sri']);
   $codigo_sri_2 = ($_POST['codigo_sri_2']);
   if ($codigo_sri==$codigo_sri_2) {
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET codigo_sri='$codigo_sri' WHERE id='$iduser' ");
     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   }else {
     $arrayName = array('noticia' => 'claves_no_iguales');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }

   mysqli_close($conection);
}

if ($_POST['action'] == 'agregar_contribuyente_l') {

    $contribuyente_especial = (isset($_POST['contribuyente_especial'])) ? $_POST['contribuyente_especial'] : '';
    $resolucion_contribuyente = (isset($_POST['resolucion_contribuyente'])) ? $_POST['resolucion_contribuyente'] : '';

    $query_insert=mysqli_query($conection,"UPDATE usuarios SET contribuyente_especial='$contribuyente_especial',resolucion_contribuyente_especial='$resolucion_contribuyente'
       WHERE id='$iduser' ");


     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','contribuyente_especial' => $contribuyente_especial,'resolucion_contribuyente' => $resolucion_contribuyente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'error');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}

if ($_POST['action'] == 'agregar_retencion') {

    $agente_retencion = (isset($_POST['agrente_retencion'])) ? $_POST['agrente_retencion'] : '';
    $resolucion_retencion = (isset($_POST['resolucion_retencion'])) ? $_POST['resolucion_retencion'] : '';

    $query_insert=mysqli_query($conection,"UPDATE usuarios SET agente_retencion='$agente_retencion',resolucion_retencion='$resolucion_retencion'
       WHERE id='$iduser' ");


     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','agente_retencion' => $agente_retencion,'resolucion_retencion' => $resolucion_retencion);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'error');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}



if ($_POST['action'] == 'agregar_secuencial') {
        $nuevo_secuencial1 = ($_POST['nuevo_secuencial']);
        $codigo_sucursal = ($_POST['codigo_sucursal']);

        $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$codigo_sucursal'");
        $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);
        $establecimiento_sinceros        = $data_sucursal['establecimiento'];
        $punto_emision_sinceros        = $data_sucursal['punto_emision'];


        $nuevo_secuencial =$nuevo_secuencial1-1;

        $query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor,establecimiento,punto_emision,sucursal_facturacion)
        VALUES('$nuevo_secuencial','00000000','$iduser','$establecimiento_sinceros','$punto_emision_sinceros','$codigo_sucursal') ");

     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','nuevo_secuencial' => $nuevo_secuencial1);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}


if ($_POST['action'] == 'agregar_secuencial_notas_credito') {
        $nuevo_secuencial1 = ($_POST['nuevo_secuencial']);
        $codigo_sucursal = ($_POST['codigo_sucursal']);

        $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$codigo_sucursal'");
        $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);
        $establecimiento_sinceros        = $data_sucursal['establecimiento'];
        $punto_emision_sinceros        = $data_sucursal['punto_emision'];


        $nuevo_secuencial =$nuevo_secuencial1-1;

        $query_insert=mysqli_query($conection,"INSERT INTO comprobante_nota_credito(secuencia,id_emisor,punto_emision,establecimiento,sucursal_facturacion)
        VALUES('$nuevo_secuencial','$iduser','$punto_emision_sinceros','$establecimiento_sinceros','$codigo_sucursal') ");

     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','nuevo_secuencial' => $nuevo_secuencial1);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}



if ($_POST['action'] == 'agregar_establecimiento') {

   $establecimiento = ($_POST['establecimiento']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET estableciminento_f='$establecimiento' WHERE id='$iduser' ");
     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','estableciminento' => $establecimiento);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}

if ($_POST['action'] == 'agregar_punto_emision') {

   $punto_emision = ($_POST['punto_emision']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET punto_emision_f ='$punto_emision' WHERE id='$iduser' ");
     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','punto_emision' => $punto_emision);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}
if ($_POST['action'] == 'agregar_contabilidad') {
   $contabilidad = ($_POST['contabilidad']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET contabilidad ='$contabilidad' WHERE id='$iduser' ");
     if ($query_insert) {
       $arrayName = array('noticia' => 'insert_correct','contabilidad' => $contabilidad);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   mysqli_close($conection);
}


if ($_POST['action'] == 'agregar_regimen') {
   $regimen = ($_POST['regimen']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET regimen ='$regimen' WHERE id='$iduser' ");
     if ($query_insert) {
       $arrayName = array('noticia' => 'insert_correct','regimen' => $regimen);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   mysqli_close($conection);
}


if ($_POST['action'] == 'agregar_porcetnaje_iva') {

   $porcentaje_iva = ($_POST['porcentaje_iva']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET porcentaje_iva_f ='$porcentaje_iva' WHERE id='$iduser' ");
     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','porcentaje_iva' => $porcentaje_iva);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

   mysqli_close($conection);
}



if ($_POST['action'] == 'agregar_direccion') {

   $direccion_u = mb_strtoupper($_POST['direccion_u']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET direccion='$direccion_u' WHERE id='$iduser' ");
     if ($query_insert) {

       $arrayName = array('noticia' => 'insert_correct','direccion'=>$direccion_u);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }


   mysqli_close($conection);
}


if ($_POST['action'] == 'editt_nombre') {

    $editt_nombre = mb_strtoupper($_POST['name_user']);
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET nombres='$editt_nombre' WHERE id='$iduser' ");
    if ($query_insert) {
      $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                    VALUES('nombres','$editt_nombre','$iduser') ");


      $arrayName = array('noticia' => 'editado_correctamente','nombres' =>$editt_nombre);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

    }else {
      $arrayName = array('noticia' => 'Error al editar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
    mysqli_close($conection);
  }

//Para cambiar el nombre_empresa
if ($_POST['action'] == 'editt_name_empresa') {


   $editt_empresa = ($_POST['name_empresa']);
   $query_insert=mysqli_query($conection,"UPDATE usuarios SET nombre_empresa='$editt_empresa' WHERE id='$iduser' ");
   if ($query_insert) {
     $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                   VALUES('empresa','$editt_empresa','$iduser') ");

     $arrayName = array('noticia' => 'Editado_correctamente','editt_empresa' =>$editt_empresa);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' => 'Error al editar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
   mysqli_close($conection);



}


//Para cambiar la razon social
if ($_POST['action'] == 'editt_razon_social') {


   $razon_social = ($_POST['razon_social']);
   $query_insert=mysqli_query($conection,"UPDATE usuarios SET razon_social='$razon_social' WHERE id='$iduser' ");
   if ($query_insert) {
     $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                   VALUES('empresa','$razon_social','$iduser') ");

     $arrayName = array('noticia' => 'Editado_correctamente','razon_social' =>$razon_social);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' => 'Error al editar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
   mysqli_close($conection);



}


if ($_POST['action'] == 'editt_cedula') {

   $cedula_identidad = mb_strtoupper($_POST['cedula_identidad']);
   $query_insert=mysqli_query($conection,"UPDATE usuarios SET numero_identidad='$cedula_identidad' WHERE id='$iduser' ");
   if ($query_insert) {
     $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                   VALUES('numero_identidad','$cedula_identidad','$iduser') ");

     $arrayName = array('noticia' => 'Editado_correctamente','cedula_identidad' =>$cedula_identidad);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' => 'Error al editar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
   mysqli_close($conection);



}
//Para cambiar el apellido
if ($_POST['action'] == 'editt_Apellido') {


   $editt_apellido = mb_strtoupper($_POST['editt_apellido']);
   $query_insert=mysqli_query($conection,"UPDATE usuarios SET apellidos='$editt_apellido' WHERE id='$iduser' ");
   if ($query_insert) {
     $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                   VALUES('apellidos','$editt_apellido','$iduser') ");

     $arrayName = array('noticia' => 'Editado_correctamente','editt_apellido' =>$editt_apellido);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' => 'Error al editar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
   mysqli_close($conection);



}



if ($_POST['action'] == 'agregar_descripcion') {


   $descripcion = ($_POST['descripcion']);
   $query_insert=mysqli_query($conection,"UPDATE usuarios SET descripcion='$descripcion' WHERE id='$iduser' ");
   if ($query_insert) {
     $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                   VALUES('descripcion','$descripcion','$iduser') ");

     $arrayName = array('noticia' => 'Editado_correctamente','descripcion' =>$descripcion);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' => 'Error al editar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }
   mysqli_close($conection);



}





//Para cambiar el email
if ($_POST['action'] == 'editt_email') {
  $email = mb_strtoupper($_POST['editt_email']);
  $password = md5($_POST['password']);

  $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
  $result_password = mysqli_fetch_array($query_passsword);
  $password_bd =  $result_password['password'];
  if ($password == $password_bd) {
  $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE (email='$email')");
  $result = mysqli_fetch_array($query);

  if ($result > 0) {
    $arrayName = array('Error' =>'email_existente');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

  }else {
       $sql_update= mysqli_query($conection,"UPDATE usuarios SET email='$email' WHERE id='$iduser' ");
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('email','$email','$iduser') ");

     if ($sql_update) {
       $arrayName = array('email' =>$email);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'guibis-ecuador@guibis.com' ;                 // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                      $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                      $mail -> addAddress ( $email);



                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                      $mail -> Subject = 'Cambio de email' ;
                      $mail -> Body     = '    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                          <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Bienvenido a Guibis.com '.$nombres.' '.$apellidos.'</h3>
                          <p style="font-weight: bold; font-style: italic;" >Una experiencia de comprar y vender de una manera segura</p>
                          <p>Estamos comprometidos contigo y te mostramos las lineas directas para cuelquier inquietud</p>
                          <h3>Se ha cambiado tu email con quien inicias sesion en nuestro sitio si tu no fuiste, comunicate a nuestras lineas directas </h3>
                          <p>Celular: 0998855160</p>
                          <p>Telefono: 032436519</p>
                          <p>Correo:soporte@guibis.com </p>
                          <div style="border-color: #fff;border-width: 1px;
                      border-style: solid;
                      border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                      <a style="color:#fff;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                          </div>
                        <br>



                          </div>' ;

                      $mail -> send ();
                  } catch ( Exception  $e ) {
                  }




     }else {
       $arrayName = array('Error' =>'Error al insertar el Correo');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
  }

}else {
  $arrayName = array('Error' =>'password_incorrect');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}

}

if ($_POST['action'] == 'addtelefono') {
  $telefono = $_POST['telefono'];
  $telefono2 = trim($telefono);
 $number = str_split($telefono2);
 $ejemplo = count($number);
 if ($ejemplo > 9) {
   $arrayName = array('noticia' =>'mayor_9');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }
 if ($ejemplo == 9){
   if ($number['0']==0) {
     $sql_update2= mysqli_query($conection,"UPDATE usuarios SET telefono='$telefono' WHERE id='$iduser' ");
     if ($sql_update2) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('telefono','$telefono','$iduser') ");

        $arrayName = array('telefono' =>$telefono,'noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error_server');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   }else {
     $arrayName = array('noticia' =>'primer_digito_cero');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }


 }

 if ($ejemplo <= 8) {
   $arrayName = array('noticia' =>'digitos_9');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }


}

if ($_POST['action'] == 'addcelular') {
  $celular = $_POST['celular'];
  $celular2 = trim($celular);
 $number = str_split($celular2);
 $ejemplo = count($number);
 if ($ejemplo > 10) {
   $arrayName = array('noticia' =>'mayor_10');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }
 if ($ejemplo == 10){
   if ($number['0']==0) {
     $sql_update2= mysqli_query($conection,"UPDATE usuarios SET celular='$celular' WHERE id='$iduser' ");
     if ($sql_update2) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('celular','$celular','$iduser') ");

        $arrayName = array('celular' =>$celular,'noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error_server');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   }else {
     $arrayName = array('noticia' =>'primer_digito_cero');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }


 }

 if ($ejemplo <= 9) {
   $arrayName = array('noticia' =>'digitos_10');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }


}



      if ($_POST['action'] == 'editt_password') {
        $actual_password = md5($_POST['actual_password']);
        $new_password = md5($_POST['new_password']);
        $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
        $result = mysqli_fetch_array($query);
        $password_bd =  $result['password'];

        if ($actual_password == $password_bd ) {
          $query_insert=mysqli_query($conection,"UPDATE usuarios SET password='$new_password' WHERE id='$iduser' ");
          $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                        VALUES('password','$new_password','$iduser') ");


          if ($query_insert) {
             $arrayName = array('resp_password' =>'positiva');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            //Aqui va para enviar el correo de actualizacion de contrasena


            try {
                 // Configuración del servidor
                 $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                 $mail -> isSMTP ();                                          // Enviar usando SMTP
                 $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                 $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                 $mail ->Username = 'guibis-ecuador@guibis.com' ;                         // Nombrede usuario SMTP
                 $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                 $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                 $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                // Destinatarios
                $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                $mail -> addAddress ('gerencia@guibis.com');
                $mail -> addAddress ('subgerencia@guibis.com');
                $mail -> addAddress ($email_usuario);
                    // Agrega un destinatario


                // Contenido
                $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                $mail->CharSet = 'UTF-8';
                $mail -> Subject = 'Cambio de Contraseña' ;
                $mail -> Body     = '    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                    <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Bienvenido a Guibis.com '.$nombres.' '.$apellidos.'</h3>
                    <p style="font-weight: bold; font-style: italic;" >Una experiencia de comprar y vender de una manera segura</p>
                    <p>Estamos comprometidos contigo y te mostramos las lineas directas para cuelquier inquietud</p>
                    <h3>Se ha cambiado tu contraseña en nuestro sitio si tu no fuiste, comunicate a nuestras lineas directas </h3>
                    <p>Celular: 0998855160</p>
                    <p>Telefono: 032436519</p>
                    <p>Correo:soporte@guibis.com </p>
                    <div style="border-color: #fff;border-width: 1px;
                border-style: solid;
                border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                <a style="color:#fff;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                    </div>
                  <br>



                    </div>' ;

                $mail -> send ();
            } catch ( Exception  $e ) {
            }




          }else {
            $arrayName = array('resp_password' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
        }else {
          $arrayName = array('resp_password' =>'contrasena_incorrecta');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

      }
//REDES SOCIALES
if ($_POST['action'] == 'addwhatsapp') {
  $iduser= $_SESSION['id'];
  $whatsapp = $_POST['whatsapp'];
  $whatsapp2 = trim($whatsapp);
 $number = str_split($whatsapp2);
 $ejemplo = count($number);
 if ($ejemplo > 10) {
   $arrayName = array('noticia' =>'numero_major_a_10');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }
 if ($ejemplo == 10){
   if ($number['0']==0) {
     $_number_total= ['5','9','3',$number['1'],$number['2'],$number['3'],$number['4'],$number['5'],$number['6'],$number['7'],$number['8'],$number['9']];
     $numero_guardar = implode('',$_number_total);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET whatsapp='$numero_guardar' WHERE id='$iduser' ");
     if ($query_insert) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('whatsapp','$numero_guardar','$iduser') ");


        $arrayName = array('whatsapp' =>$numero_guardar,'id'=>$iduser,'noticia' =>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error_server');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   }else {
     $arrayName = array('noticia' =>'primer_digito_cero');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }


 }


 if ($ejemplo <= 9) {
   $arrayName = array('noticia' =>'contiene_menos_9');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



}
}


if ($_POST['action'] == 'addtelegram') {
   $telegram = ($_POST['telegram']);
     $query_insert=mysqli_query($conection,"UPDATE usuarios SET telegram ='$telegram' WHERE id='$iduser' ");
     if ($query_insert) {
       $arrayName = array('noticia' => 'insert_correct','telegram' => $telegram);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' => 'Error al editar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
   mysqli_close($conection);
}



if ($_POST['action'] == 'addinstagram') {
  $iduser = $_SESSION['id'];
  $instagram = $_POST['instagram'];


  // Validar si $instagram es una URL de Instagram válida
  if (preg_match('/^https:\/\/(www\.)?instagram\.com(\/[a-zA-Z0-9_.-]+)?(\/|\?.*)?$/', $instagram)) {

      // Asegúrate de limpiar las variables antes de usarlas en una consulta SQL
      $iduser_clean = mysqli_real_escape_string($conection, $iduser);
      $instagram_clean = mysqli_real_escape_string($conection, $instagram);

      $query_insert = mysqli_query($conection, "UPDATE usuarios SET instagram='$instagram_clean' WHERE id='$iduser_clean'");

      if ($query_insert) {
          $query_cambio = mysqli_query($conection, "INSERT INTO historial_cambios(campo, contenido, idusuario) VALUES('instagram', '$instagram_clean', '$iduser_clean')");
          $arrayName = array('instagram' => $instagram, 'noticia' => 'insert_correct');
          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
      } else {
          $arrayName = array('noticia' => 'error_servidor');
          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
      }
  } else {
      $arrayName = array('noticia' => 'direccion_invalida');
      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
  }

  mysqli_close($conection);
}


if ($_POST['action'] == 'add_pagina_web') {
    $iduser = $_SESSION['id'];
    $pagina_web = $_POST['pagina_web'];

    // Validar si $pagina_web es una URL válida y comienza con https
    if (filter_var($pagina_web, FILTER_VALIDATE_URL) && substr($pagina_web, 0, 5) === "https") {

        // Asegúrate de limpiar las variables antes de usarlas en una consulta SQL
        $iduser_clean = mysqli_real_escape_string($conection, $iduser);
        $pagina_web_clean = mysqli_real_escape_string($conection, $pagina_web);

        $query_insert = mysqli_query($conection, "UPDATE usuarios SET pagina_web='$pagina_web_clean' WHERE id='$iduser_clean'");

        if ($query_insert) {
            $query_cambio = mysqli_query($conection, "INSERT INTO historial_cambios(campo, contenido, idusuario) VALUES('pagina_web', '$pagina_web_clean', '$iduser_clean')");
            $arrayName = array('pagina_web' => $pagina_web, 'noticia' => 'insert_correct');
            echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
        } else {
            $arrayName = array('noticia' => 'error_servidor');
            echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
        }
    } else {
        $arrayName = array('noticia' => 'direccion_invalida');
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($conection);
}






      if ($_POST['action'] == 'addFacebook') {
          $iduser = $_SESSION['id'];
          $facebook = $_POST['facebook'];

          // Validar si $facebook es una URL de Facebook válida
          if (preg_match('/^https:\/\/(www\.|web\.)?facebook\.com(\/[a-zA-Z0-9_.-]+)?(\/|\?.*)?$/', $facebook)) {
              $query_insert = mysqli_query($conection, "UPDATE usuarios SET facebook='$facebook' WHERE id='$iduser'");
              if ($query_insert) {
                  $query_cambio = mysqli_query($conection, "INSERT INTO historial_cambios(campo,contenido,idusuario) VALUES('facebook','$facebook','$iduser')");
                  $arrayName = array('facebook' => $facebook, 'noticia' => 'insert_correct');
                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
              } else {
                  $arrayName = array('noticia' => 'error_servidor');
                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
              }
          } else {
              $arrayName = array('noticia' => 'direccion_invalida');
              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
          }

          mysqli_close($conection);
      }

                  if ($_POST['action'] == 'addtiktok') {
                    $tiktok = $_POST['tiktok'];
                    $tiktok_sin_espacios = trim($tiktok);
                    $tiktok_number = str_split($tiktok_sin_espacios);
                    $tiktok_array = count($tiktok_number);
                    if ($tiktok_array > 11) {
                      $A0 = $tiktok_number[0];
                      $A1 = $tiktok_number[1];
                      $A2 = $tiktok_number[2];
                      $A3 = $tiktok_number[3];
                      $A4 = $tiktok_number[4];
                      $A5 = $tiktok_number[5];
                      $A6 = $tiktok_number[6];
                      $A7 = $tiktok_number[7];
                      $A8 = $tiktok_number[8];
                      $A9 = $tiktok_number[9];

              if ($A0== 't' && $A1 == 'i' && $A2 == 'k' && $A3 == 't' && $A4 == 'o' && $A5 == 'k' && $A6 == '.' && $A7 == 'c' && $A8 == 'o' &&  $A9 == 'm') {
                        $query_insert=mysqli_query($conection,"UPDATE usuarios SET tiktok='$tiktok' WHERE id='$iduser' ");
                        if ($query_insert) {
                          $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(tiktok,contenido,idusuario)
                                                        VALUES('tiktok','$tiktok','$iduser') ");


                           $arrayName = array('tiktok' =>$tiktok,'noticia' =>'insert_correct');
                          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                        }else {
                          $arrayName = array('noticia' =>'error_servidor');
                         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        }
                      }else {
                        $arrayName = array('noticia' =>'direccion_invalida');
                       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                      }

                    }else {
                      $arrayName = array('noticia' =>'direccion_invalida');
                     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                    }

                    mysqli_close($conection);


                  }



                  if ($_POST['action'] == 'addbanca_p') {
                    $iduser= $_SESSION['id'];
                    $banca_p = $_POST['banca_p'];
                    $password = md5($_POST['password']);
                    $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
                    $result_password = mysqli_fetch_array($query_passsword);
                    $password_bd =  $result_password['password'];
                    if ($password == $password_bd) {
                      $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_pichincha='$banca_p' WHERE id='$iduser' ");

                       if ($query_insert) {
                         $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                       VALUES('banco_pichincha','$banca_p','$iduser') ");


                                    try {
                                         // Configuración del servidor
                                        $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                        $mail -> isSMTP ();                                          // Enviar usando SMTP
                                        $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                        $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                        $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                        $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                        $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                        $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                        // Destinatarios
                                        $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                        $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                        $mail -> addAddress ( $email);
                                            // Agrega un destinatario


                                        // Contenido
                                        $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                          $mail->CharSet = 'UTF-8';
                                        $mail -> Subject = 'Cuenta Bancaria Pichicha Agregada' ;
                                        $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                          <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                        </div>
                                        <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                           <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                           <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Pichincha) en nuestra plataforma.</p>
                                           <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Pichincha)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
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

                                           </div>' ;

                                        $mail -> send ();
                                    } catch ( Exception  $e ) {
                                    }

                        $arrayName = array('banca_p' =>$banca_p,'noticia' =>'insert_correct');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                       }else {
                         $arrayName = array('noticia' =>'error_servidor');
                         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                       }
                  }else {
                    $arrayName = array('noticia' =>'password_incorrect');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }
              }




                          if ($_POST['action'] == 'add_banco_guayaquil') {
                            $banca_p = $_POST['banca_p'];
                            $password = md5($_POST['password']);
                            $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
                            $result_password = mysqli_fetch_array($query_passsword);
                            $password_bd =  $result_password['password'];
                            if ($password == $password_bd) {
                              $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_guayaquil ='$banca_p' WHERE id='$iduser' ");

                               if ($query_insert) {
                                 $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                               VALUES('banco_guayaquil','$banca_p','$iduser') ");


                                            try {
                                                 // Configuración del servidor
                                                $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                                $mail -> isSMTP ();                                          // Enviar usando SMTP
                                                $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                                $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                                $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                                $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                                $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                                $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                                // Destinatarios
                                                $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                                $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                                $mail -> addAddress ( $email);
                                                    // Agrega un destinatario


                                                // Contenido
                                                $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                                  $mail->CharSet = 'UTF-8';
                                                $mail -> Subject = 'Cuenta Banco Guayaquil Agregada' ;
                                                $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                                  <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                                </div>
                                                <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                                   <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                                   <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Guayaquil) en nuestra plataforma.</p>
                                                   <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Guayaquil)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
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

                                                   </div>' ;

                                                $mail -> send ();
                                            } catch ( Exception  $e ) {
                                            }

                                $arrayName = array('banca_p' =>$banca_p,'noticia' =>'insert_correct');
                                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                               }else {
                                 $arrayName = array('noticia' =>'error_servidor');
                                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                               }
                          }else {
                            $arrayName = array('noticia' =>'password_incorrect');
                            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                          }
                      }





                      /*Banco Produbanco*/
                      if ($_POST['action'] == 'add_banco_produbanco') {
                        $iduser= $_SESSION['id'];
                        $banca_p = $_POST['banca_p'];
                        $password = md5($_POST['password']);
                        $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
                        $result_password = mysqli_fetch_array($query_passsword);
                        $password_bd =  $result_password['password'];
                        if ($password == $password_bd) {
                          $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_produbanco ='$banca_p' WHERE id='$iduser' ");

                           if ($query_insert) {
                             $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                           VALUES('banco_produbanco','$banca_p','$iduser') ");


                                        try {
                                             // Configuración del servidor
                                            $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                            $mail -> isSMTP ();                                          // Enviar usando SMTP
                                            $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                            $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                            $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                            $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                            $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                            $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                            // Destinatarios
                                            $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                            $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                            $mail -> addAddress ( $email);
                                                // Agrega un destinatario


                                            // Contenido
                                            $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                              $mail->CharSet = 'UTF-8';
                                            $mail -> Subject = 'Cuenta Banco Produbanco Agregada' ;
                                            $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                              <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                            </div>
                                            <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                               <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                               <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Produbanco) en nuestra plataforma.</p>
                                               <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Produbanco)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
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

                                               </div>' ;

                                            $mail -> send ();
                                        } catch ( Exception  $e ) {
                                        }

                            $arrayName = array('banca_p' =>$banca_p,'noticia' =>'insert_correct');
                            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                           }else {
                             $arrayName = array('noticia' =>'error_servidor');
                             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                           }
                      }else {
                        $arrayName = array('noticia' =>'password_incorrect');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                      }
                      }








                      /*Banco PACIFICO*/
                      if ($_POST['action'] == 'add_banco_pacifico') {
                        $iduser= $_SESSION['id'];
                        $banca_p = $_POST['banca_p'];
                        $password = md5($_POST['password']);
                        $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
                        $result_password = mysqli_fetch_array($query_passsword);
                        $password_bd =  $result_password['password'];
                        if ($password == $password_bd) {
                          $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_pacifico ='$banca_p' WHERE id='$iduser' ");

                           if ($query_insert) {
                             $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                           VALUES('banco_pacifico','$banca_p','$iduser') ");


                                        try {
                                             // Configuración del servidor
                                            $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                            $mail -> isSMTP ();                                          // Enviar usando SMTP
                                            $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                            $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                            $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                            $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                            $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                            $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                            // Destinatarios
                                            $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                            $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                            $mail -> addAddress ( $email);
                                                // Agrega un destinatario


                                            // Contenido
                                            $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                              $mail->CharSet = 'UTF-8';
                                            $mail -> Subject = 'Cuenta Banco Pacifico Agregada' ;
                                            $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                              <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                            </div>
                                            <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                               <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                               <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Pacifico) en nuestra plataforma.</p>
                                               <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Pacifico)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
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

                                               </div>' ;

                                            $mail -> send ();
                                        } catch ( Exception  $e ) {
                                        }

                            $arrayName = array('banca_p' =>$banca_p,'noticia' =>'insert_correct');
                            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                           }else {
                             $arrayName = array('noticia' =>'error_servidor');
                             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                           }
                      }else {
                        $arrayName = array('noticia' =>'password_incorrect');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                      }
                      }
