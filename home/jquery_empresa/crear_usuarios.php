<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
 include '../facturacion/facturacionphp/lib/PHPMailer/PHPMailerAutoload.php';
 require '../QR/phpqrcode/qrlib.php';

    if ($_POST['action'] == 'agregar_cuentas_meseros') {
      if (!empty($_FILES['foto']['name'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/uploads/';
        $img_nombre = 'guibis_punto_venta'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
        move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'punto-de-venta.png';
        // code...
      }
      $nombres_apellidos      = $_POST['nombres_apellidos'];
      $tipo_identificacion    = $_POST['tipo_identificacion'];
      $identificacion         = $_POST['identificacion'];
      $direccion_usuario              = $_POST['direccion'];
      $celular                = $_POST['celular'];
      $email                  = $_POST['email'];

      $password = md5($identificacion);

      //QR DEL TRANSPORTISTA

      $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $query_insert=mysqli_query($conection,"INSERT INTO punto_venta_externo(nombres_apellidos,tipo_identificacion,identificacion,direccion,celular,email,foto,iduser,qr_imagen,qr_contenido,password)
                                    VALUES('$nombres_apellidos','$tipo_identificacion','$identificacion','$direccion_usuario','$celular','$email','$imgProducto','$iduser','$qr_img','$contenido','$password') ");

      if ($query_insert) {

          $arrayName = array('img' =>$imgProducto,'noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'agregar_tr') {
        $transportista = $_POST['transportista'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM transportistas WHERE transportistas.id ='$transportista'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }




 ?>
