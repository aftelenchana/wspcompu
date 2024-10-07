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



 if ($_POST['action'] == 'agregar_varias_imagenes') {

   $idproducto = $_POST['producto'];

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
   $cont = 1;
  foreach ($_FILES["lista"]["name"] as $key => $value) {
    //Obtenemos la extensión del archivo
    $ext = explode('.', $_FILES["lista"]["name"][$key]);
    //Generamos un nuevo nombre del archivo, esto para no duplicar el nombre del archivo y que se sobreescriba.
    $renombrar = 'guibis_img'.$cont.md5(date('d-m-Y H:m:s').$iduser.$idproducto);
    $nombre_final = $renombrar.".".$ext[1];
    $query_insert=mysqli_query($conection,"INSERT INTO img_producto(id_user,idp,img,url)
                                  VALUES('$iduser','$idproducto','$nombre_final','$url') ");
    //Se copian los archivos de la carpeta temporal del servidor a su ubicación final
    move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../img/uploads/".$nombre_final);

          $cont++;

  }

  if ($query_insert) {
    $arrayName = array('noticia' =>'productos_agregados_correctamente','cantidad'=>($cont-1));
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    // code...
  }else {
    $arrayName = array('noticia' =>'error_servidor');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    // code...
  }



   // code...
 }

 if ($_POST['action'] == 'eliminar_imagen') {
   $imagen = $_POST['imagen'];

           $query_img_productos = mysqli_query($conection,"SELECT * FROM `img_producto` WHERE img_producto.id  = '$imagen'");
           $data_lista_img_productos=mysqli_fetch_array($query_img_productos);
           $nombre_imagen = $data_lista_img_productos['img'];
           $url = $data_lista_img_productos['url'];


        $src = $_SERVER['DOCUMENT_ROOT'] . '/home/img/uploads/' . $nombre_imagen;

        if (file_exists($src)) {
            unlink($src);

                  $query_delete=mysqli_query($conection,"DELETE FROM img_producto WHERE id='$imagen' ");

                  if ($query_delete) {
                    $arrayName = array('noticia'=>'elimado_correctamnete','imagen'=>$imagen);
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                  }else {
                    $arrayName = array('noticia' =>'error_insertar');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }
        } else {
          $arrayName = array('noticia' =>'sin_url_real','url' =>$url);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
 }




  if ($_POST['action'] == 'agregar_factores') {

      $producto = $_POST['producto'];
            $categorias = $_POST['categorias'];
            $subcategorias = $_POST['subcategorias'];
            $provincia = $_POST['provincia'];
            $ciudad = $_POST['ciudad'];

                  $query_insert=mysqli_query($conection,"UPDATE producto_venta SET categorias='$categorias',subcategorias='$subcategorias',provincia='$provincia'
                    ,ciudad='$ciudad'  WHERE idproducto='$producto' ");

                   if ($query_insert) {
                     $arrayName = array('noticia'=>'editador_correctamente');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                   }else {
                     $arrayName = array('noticia' =>'error_editar');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                   }

  }

 ?>
