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


$uploadDir = '../img/uploads/'; // Asegúrate de que esta carpeta tenga permisos de escritura

// Comprueba si se ha subido un archivo
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Genera un nombre de archivo único
    $filename = md5(uniqid() . time()) . '-' . date('Y-m-d') . '.png';
    $path = $uploadDir . $filename;

    // Mueve el archivo subido a la carpeta de destino
    if (move_uploaded_file($file['tmp_name'], $path)) {

      $query_usuarios = mysqli_query($conection, "SELECT  * FROM usuarios  WHERE usuarios.id = '$iduser'");
      $data_usuarios  =mysqli_fetch_array($query_usuarios);

       $img_facturacion = $data_usuarios['img_facturacion'];
       $url_img_upload  = $data_usuarios['url_img_upload'];
       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

          $query_insert=mysqli_query($conection,"INSERT INTO imagen_temporal(id_user,imagen_anterior,imagen_subida,url_anterior,url_seo)
                                        VALUES('$iduser','$img_facturacion','$filename','$url_img_upload','$url') ");

          $query_insert_imagen=mysqli_query($conection,"UPDATE usuarios SET img_facturacion ='$filename',url_img_upload='$url'  WHERE id='$iduser' ");


            if ($query_insert && $query_insert_imagen) {
              $arrayName = array('noticia' =>'insertado_correctamente_guardado');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }else {
             $arrayName = array('noticia' =>'guardado_no_insertado');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             // code...
           }

    } else {
      $arrayName = array('noticia' =>'error_guardar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
} else {
  $arrayName = array('noticia' =>'no_se_resivio_archivo');
 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
?>
