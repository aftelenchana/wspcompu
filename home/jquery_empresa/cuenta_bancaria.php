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




    if ($_POST['action'] == 'agregar_cuenta_bancaria') {

      $nombre_cuenta                  = $_POST['nombre_cuenta'];
      $numero_cuenty                  = $_POST['numero_cuenty'];
      $tipo_cuenta_banaria            = $_POST['tipo_cuenta_banaria'];
      $titular_cuenta                 = $_POST['titular_cuenta'];

      $query_insert=mysqli_query($conection,"INSERT INTO cuentas_bancarias_factu (iduser,nombre_cuenta,tipo_cuenta,numero_cuenta,titular_cuenta)
                                    VALUES('$iduser','$nombre_cuenta','$tipo_cuenta_banaria','$numero_cuenty','$titular_cuenta') ");

      if ($query_insert) {
          $arrayName = array('noticia'=>'insert_correct');
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
