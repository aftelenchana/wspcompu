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


 if ($_POST['action'] == 'eliminar_item') {
   $itemId = $_POST['itemId'];
   $query_eliminar_producto = mysqli_query($conection,"DELETE FROM comprobantes WHERE comprobantes.id ='$itemId'");
   if ($query_eliminar_producto) {
     $arrayName = array('respuesta' =>'eliminado_correctamente','itemId' =>$itemId);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }else {
   $arrayName = array('respuesta' =>'error_eliminar_producto');
 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }

 }



 ?>
