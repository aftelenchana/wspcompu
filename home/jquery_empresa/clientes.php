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


 if ($_POST['action'] == 'eliminar_cliente_elejido') {

   $cliente = $_POST['cliente'];
  $query_delete=mysqli_query($conection,"UPDATE clientes SET estatus= 0  WHERE id='$cliente' ");

  if ($query_delete) {
    $arrayName = array('respuesta' =>'elimado_correctamnete','cliente'=>$cliente);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      $arrayName = array('respuesta' =>'error_insertar','cliente'=>$cliente);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
    exit;


   // code...
 }
