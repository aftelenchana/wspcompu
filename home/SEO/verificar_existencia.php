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

    $query_existencia_foto_seo = mysqli_query($conection, "SELECT  * FROM imagen_temporal  WHERE imagen_temporal.id_user = '$iduser'");
    $result_existencia= mysqli_num_rows($query_existencia_foto_seo);

    if ($result_existencia > 0) {
        $arrayName = array('noticia' =>'existe_registro');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {

      $query_usuarios = mysqli_query($conection, "SELECT  * FROM usuarios  WHERE usuarios.id = '$iduser'");
      $data_usuarios  =mysqli_fetch_array($query_usuarios);

       $img_facturacion = $data_usuarios['img_facturacion'];
       $url_img_upload  = $data_usuarios['url_img_upload'];

      $ruta_imagen = ''.$url_img_upload.'/home/img/uploads/'.$img_facturacion.'';
      function urlExists($url) {
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_NOBODY, true);
       curl_exec($ch);
       $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

       if ($code == 200) {
           $status = true;
       } else {
           $status = false;
       }
       curl_close($ch);
       return $status;
     }

     if (urlExists($ruta_imagen)) {

       $ruta_imagen = '../img/uploads/'.$img_facturacion;
         // Verificar si el archivo ya existe localmente
         if (!file_exists($ruta_imagen)) {
             // El archivo no existe, descargarlo del servidor remoto
             $ruta_imagen_url = ''.$url_img_upload.'/home/img/uploads/'.$img_facturacion.'';
             $contenido_imagen = file_get_contents($ruta_imagen_url);
             if ($contenido_imagen === false) {
               $arrayName = array('noticia'=>'error_descargar_firma');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 exit;
             }
             // Guardar el archivo de firma localmente
             file_put_contents($ruta_imagen, $contenido_imagen);
             $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
             $query_insert=mysqli_query($conection,"UPDATE usuarios SET img_facturacion ='$img_facturacion',url_img_upload='$url'  WHERE id='$iduser' ");

             if ($query_insert) {
               $ruta_imagen = ''.$url.'/home/img/uploads/'.$img_facturacion.'';
               $arrayName = array('noticia' =>'no_existe_registro','imagn_usuarios' =>$ruta_imagen);
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               // code...
             }else {
               $arrayName = array('noticia' =>'error_registro_descarga_imagen');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }


         }else {
           $img_facturacion = $data_usuarios['img_facturacion'];
           $url_img_upload  = $data_usuarios['url_img_upload'];
           $ruta_imagen_url = ''.$url_img_upload.'/home/img/uploads/'.$img_facturacion.'';
           $arrayName = array('noticia' =>'no_existe_registro','imagn_usuarios' =>$ruta_imagen_url);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }



      // code...
     }else {

       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
       $query_insert=mysqli_query($conection,"UPDATE usuarios SET img_facturacion ='avatar.png',url_img_upload='$url'  WHERE id='$iduser' ");
      if ($query_insert) {
        $ruta_imagen = ''.$url.'/home/img/uploads/avatar.png';
        $arrayName = array('noticia' =>'no_existe_registro','imagn_usuarios' =>$ruta_imagen);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      // code...
     }
    }






 ?>
