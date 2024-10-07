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


    if ($_POST['action'] == 'crear_asiento_contable') {
      $nombre_asiento                  = $_POST['nombre_asiento'];
      $cuentas_capital                  = $_POST['cuentas_capital'];
      $descripcion_asiento            = $_POST['descripcion_asiento'];
      $fecha_asiento            = $_POST['fecha_asiento'];

      $query = mysqli_query($conection, "SELECT * FROM  asientos_contables  WHERE  asientos_contables.iduser  = '$iduser' ORDER BY id DESC");
        $result = mysqli_fetch_array($query);
        if ($result) {
          $secuencial = $result['secuencial'];
          $secuencial = $secuencial +1;
        }else {
          $secuencial =1;
        }

      $query_insert=mysqli_query($conection,"INSERT INTO asientos_contables (secuencial,iduser,fecha_asiento,descripcion_concepto,cuentas_capital_contable,nombre_asiento)
                                                                   VALUES('$secuencial','$iduser','$fecha_asiento','$descripcion_asiento','$cuentas_capital','$nombre_asiento') ");

      if ($query_insert) {
          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'agregar_item_asiento') {
      $asiento = $_POST['asiento'];
      $query_asiento = mysqli_query($conection,"SELECT * FROM asientos_contables WHERE asientos_contables.secuencial ='$asiento' AND iduser = '$iduser'");
      $data_asiento = mysqli_fetch_array($query_asiento);
      echo json_encode($data_asiento,JSON_UNESCAPED_UNICODE);

    }

    if ($_POST['action'] == 'agregar_item_asiento_perfomance') {
        $asiento              = $_POST['asiento'];
        $descripcion_concepto = $_POST['descripcion_concepto'];
        $debe                 = $_POST['debe'];
        $haber                = $_POST['haber'];
              $query_insert=mysqli_query($conection,"INSERT INTO asientos_contables (debe,haber,descripcion_concepto,secuencial,iduser)
                                                                           VALUES('$debe', '$haber','$descripcion_concepto','$asiento','$iduser') ");
        if ($query_insert) {
           $arrayName = array('noticia'=>'insert_correct');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
           $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }



    }




 ?>
