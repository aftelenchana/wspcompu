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




    if ($_POST['action'] == 'agregar_plan_parqueo') {
      if (!empty($_FILES['foto'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/transporte/';
        $img_nombre = 'guibis_plan_parquo'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
        move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'transporte.png';
        // code...
      }
      $nombre_medio_transporte    = $_POST['nombre_medio_transporte'];
      $precio_hora_transporte         = $_POST['precio_hora_transporte'];



      //QR DEL TRANSPORTISTA

      $img_nombre = 'guibis_parqueo'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $query_insert=mysqli_query($conection,"INSERT INTO planes_parqueo(iduser,nombre_plan,precio_hora,imagen,qr,qr_contenido)
                                    VALUES('$iduser','$nombre_medio_transporte','$precio_hora_transporte','$imgProducto','$qr_img','$contenido') ");

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
