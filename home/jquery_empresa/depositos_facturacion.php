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

    if ($_POST['action'] == 'agregar_depositos') {
      if (!empty($_FILES['foto'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/uploads/';
        $img_nombre = 'depositos_facturacion'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
      }else {
        $imgProducto = '';
        // code...
      }

      $id_cliente                  = $_POST['id_cliente'];
      $tipos_depositos                  = $_POST['tipos_depositos'];
      $monto_deposito            = $_POST['monto_deposito'];
      $detalles_depostip                 = $_POST['detalles_depostip'];

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


      $query_insert=mysqli_query($conection,"INSERT INTO depositos_facturacion (iduser,idcliente,tipo_deposito,monto_deposito ,detalles_deposito,foto,qr_img,qr_contenido)
                                    VALUES('$iduser','$id_cliente','$tipos_depositos','$monto_deposito','$detalles_depostip','$imgProducto','$qr_img','$contenido') ");

      if ($query_insert) {
        if (!empty($_FILES['foto'])) {
            move_uploaded_file($url_temp,$src);
        }

          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'buscar_cliente_depositos') {
        $cliente_depositos = $_POST['cliente_depositos'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM clientes WHERE clientes.id ='$cliente_depositos'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }




 ?>
