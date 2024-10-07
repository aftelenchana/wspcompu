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
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";
    }


    if ($_POST['action'] == 'consultar_datos') {

      $query_consulta = mysqli_query($conection, "SELECT * FROM farmacias_guibis
         WHERE farmacias_guibis.iduser ='$iduser'  AND farmacias_guibis.estatus = '1'
      ORDER BY `farmacias_guibis`.`fecha` DESC ");

      $data = array();
   while ($row = mysqli_fetch_assoc($query_consulta)) {
       $data[] = $row;
   }

   echo json_encode(array("data" => $data));
      // code...
    }




 if ($_POST['action'] == 'agregar_farmacias') {

   $nombre_farmacia        = mysqli_real_escape_string($conection,$_POST['nombre_farmacia']);
   $email          = mysqli_real_escape_string($conection,$_POST['email']);
   $password        = mysqli_real_escape_string($conection,$_POST['password']);



   if (!empty($_FILES['foto']['name'])) {
     $foto           =    $_FILES['foto'];
     $nombre_foto    =    $foto['name'];
     $type 					 =    $foto['type'];
     $url_temp       =    $foto['tmp_name'];
     $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
     $destino = '../img/uploads/';
     $img_nombre = 'empresarial_guibis'.md5(date('d-m-Y H:m:s').$iduser);
     $imgProducto = $img_nombre.'.'.$extension;
     $src = $destino.$imgProducto;
       move_uploaded_file($url_temp,$src);
   }else {
     $imgProducto = 'farmacia.png';
     // code...
   }


   $query=mysqli_query($conection,"SELECT *FROM  farmacias_guibis WHERE email='$email' AND farmacias_guibis.estatus = '1'
     AND  farmacias_guibis.iduser = '$iduser'");
   $result = mysqli_fetch_array($query);

   if ($result > 0) {
     $arrayName = array('noticia' =>'cuenta_existente');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    exit;
   }

  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
   $query_insert=mysqli_query($conection,"INSERT INTO  farmacias_guibis  (iduser,nombre_farmacia,email,password ,imagen,url_img)
                                                                VALUES('$iduser','$nombre_farmacia','$email','$password','$imgProducto','$url') ");

              if ($query_insert) {
                  $arrayName = array('noticia'=>'insert_correct');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }else {
                  $arrayName = array('noticia' =>'error_insertar');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }



  // code...
}


 if ($_POST['action'] == 'info_parametro') {
      $parametro       = $_POST['parametro'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM farmacias_guibis
         WHERE farmacias_guibis.iduser ='$iduser'  AND farmacias_guibis.estatus = '1' AND farmacias_guibis.id = '$parametro' ");
   $data_consulta = mysqli_fetch_array($query_consulta);
   echo json_encode($data_consulta,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_farmacia') {

   $id_farmacia      = mysqli_real_escape_string($conection,$_POST['id_farmacia']);

   $nombre_farmacia = mysqli_real_escape_string($conection,$_POST['nombre_farmacia']);
   $email           = mysqli_real_escape_string($conection,$_POST['email']);
   $password        = mysqli_real_escape_string($conection,$_POST['password']);


   if (!empty($_FILES['foto']['name'])) {
     $foto           =    $_FILES['foto'];
     $nombre_foto    =    $foto['name'];
     $type 					 =    $foto['type'];
     $url_temp       =    $foto['tmp_name'];
     $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
     $destino = '../img/uploads/';
     $img_nombre = 'empresarial_guibis'.md5(date('d-m-Y H:m:s').$iduser);
     $imagen = $img_nombre.'.'.$extension;
     $src = $destino.$imagen;
     move_uploaded_file($url_temp,$src);
     $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url_img_upload = $protocol . $domain;
     }else {
       $query_consulta = mysqli_query($conection, "SELECT * FROM farmacias_guibis
          WHERE farmacias_guibis.estatus = '1' AND farmacias_guibis.id = '$id_farmacia'  ");
    $data_consulta = mysqli_fetch_array($query_consulta);
       $imagen         = $data_consulta['imagen'];
       $url_img_upload = $data_consulta['url_img'];

     }

   //DE QUI SACAMOS LA INFORMACION PARA SABER QUE NIVEL EDITAMOS
   $query_insert = mysqli_query($conection, "UPDATE farmacias_guibis SET nombre_farmacia='$nombre_farmacia',email ='$email',password='$password',
       imagen='$imagen', url_img='$url_img_upload' WHERE id = '$id_farmacia'");

       if ($query_insert) {
           $arrayName = array('noticia'=>'insert_correct','code_password'=> $id_farmacia);
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }else {
           $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
    //ANTES DE EDITAR TENEMOS QUE VALIDAR SI ES QUE EL DIGITO YA ESTA SIENDO OCUPADO POR OTRO


  }

 if ($_POST['action'] == 'eliminar_parametro') {
   $parametro             = $_POST['parametro'];
   $query_delete=mysqli_query($conection,"UPDATE farmacias_guibis SET estatus= 0  WHERE id='$parametro' ");
   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','parametro'=> $parametro);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }


 if ($_POST['action'] == 'buscar_productos_farmacias') {

   $palabra_ingresada = $_POST['palabra_ingresada'];

   $query_consulta = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.marca,producto_venta.descripcion,
     producto_venta.descripcion_tienda,producto_venta.via_administracion
      FROM producto_venta
                 WHERE  (producto_venta.nombre like '%$palabra_ingresada%' OR producto_venta.descripcion like '%$palabra_ingresada%' OR producto_venta.precio like '%$palabra_ingresada%'
                 OR producto_venta.marca like '%$palabra_ingresada%' OR producto_venta.descripcion_tienda like '%$palabra_ingresada%' OR producto_venta.via_administracion like '%$palabra_ingresada%')
                 AND producto_venta.estatus = '1' AND producto_venta.id_usuario = '$iduser'
                 ORDER BY producto_venta.fecha_producto");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }







 ?>
