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


 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT * FROM sucursales
      WHERE sucursales.iduser ='$iduser'  AND sucursales.estatus = '1'
      GROUP BY sucursales.establecimiento
   ORDER BY `sucursales`.`fecha` ASC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_sucursal') {
   $direccion_sucursal        = mysqli_real_escape_string($conection,$_POST['direccion_sucursal']);
   $direccion_sucursal = str_replace("\r\n", " ", $direccion_sucursal); // Para saltos de línea de Windows
   $direccion_sucursal = str_replace("\n", " ", $direccion_sucursal);   // Para saltos de línea de Unix/Linux
   $direccion_sucursal = str_replace("\r", " ", $direccion_sucursal);   // Para saltos de línea de Mac


   $punto_emision             = mysqli_real_escape_string($conection,$_POST['punto_emision']);
   $establecimiento           = mysqli_real_escape_string($conection,$_POST['establecimiento']);

   $query_insert=mysqli_query($conection,"INSERT INTO sucursales(iduser,direccion_sucursal,punto_emision,establecimiento)
                                 VALUES('$iduser','$direccion_sucursal','$punto_emision','$establecimiento') ");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_sucursal') {
      $sucursal       = $_POST['sucursal'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM sucursales
         WHERE sucursales.iduser ='$iduser'  AND sucursales.estatus = '1' AND sucursales.id = '$sucursal' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_sucursal') {
    $id_sucursal       = $_POST['id_sucursal'];

   $direccion_sucursal = mysqli_real_escape_string($conection, $_POST['direccion_sucursal']);

   $direccion_sucursal = str_replace("\r\n", " ", $direccion_sucursal); // Para saltos de línea de Windows
   $direccion_sucursal = str_replace("\n", " ", $direccion_sucursal);   // Para saltos de línea de Unix/Linux
   $direccion_sucursal = str_replace("\r", " ", $direccion_sucursal);   // Para saltos de línea de Mac



   $punto_emision      = mysqli_real_escape_string($conection, $_POST['punto_emision']);
   $establecimiento    = mysqli_real_escape_string($conection, $_POST['establecimiento']);

  $query_update =mysqli_query($conection,"UPDATE sucursales SET direccion_sucursal= '$direccion_sucursal' ,punto_emision= '$punto_emision' ,establecimiento= '$establecimiento'  WHERE id='$id_sucursal' ");

  $query_update_secundario =mysqli_query($conection,"UPDATE sucursales SET direccion_sucursal= '$direccion_sucursal'  WHERE establecimiento='$establecimiento' AND iduser = '$iduser'");

   if ($query_update && $query_update_secundario) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_sucursal') {
   $sucursal             = $_POST['sucursal'];

   $query_delete=mysqli_query($conection,"UPDATE sucursales SET estatus= 0  WHERE id='$sucursal' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','sucursal'=> $sucursal);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
