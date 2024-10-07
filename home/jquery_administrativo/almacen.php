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

   $query_consulta = mysqli_query($conection, "SELECT almecenes.id,almecenes.nombre_almacen,almecenes.direccion_almacen,
     almecenes.sucursal,almecenes.descripcion,sucursales.direccion_sucursal,sucursales.id as 'cod_sucursal',almecenes.responsable FROM almecenes
     INNER JOIN sucursales ON sucursales.id = almecenes.sucursal
      WHERE almecenes.iduser ='$iduser'  AND almecenes.estatus = '1'
   ORDER BY `almecenes`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }



 if ($_POST['action'] == 'info_almacen') {
      $almacen       = $_POST['almacen'];

   $query_consulta = mysqli_query($conection, "SELECT almecenes.id,almecenes.nombre_almacen,almecenes.direccion_almacen,
     almecenes.sucursal,almecenes.descripcion,sucursales.direccion_sucursal,sucursales.id as 'cod_sucursal',almecenes.responsable,
     sucursales.id as 'cod_sucursal' FROM almecenes
     INNER JOIN sucursales ON sucursales.id = almecenes.sucursal
      WHERE almecenes.iduser ='$iduser'  AND almecenes.estatus = '1' AND almecenes.id = '$almacen'
   ORDER BY `almecenes`.`fecha` DESC ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_almacen') {
    $id_almacen       = $_POST['id_almacen'];

   $nombre_almacen       = $_POST['nombre_almacen'];
   $direccion_almacen    = $_POST['direccion_almacen'];
   $sucursal             = $_POST['sucursal'];
   $descripcion          = $_POST['descripcion'];
   $responsable          = $_POST['responsable'];

  $query_update =mysqli_query($conection,"UPDATE almecenes SET nombre_almacen= '$nombre_almacen',direccion_almacen= '$direccion_almacen',
    sucursal= '$sucursal',descripcion= '$descripcion',responsable= '$responsable'  WHERE id='$id_almacen' ");

   if ($query_update) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }






 if ($_POST['action'] == 'agregar_almacen') {

   $nombre_almacen       = $_POST['nombre_almacen'];
   $direccion_almacen    = $_POST['direccion_almacen'];
   $sucursal             = $_POST['sucursal'];
   $descripcion          = $_POST['descripcion'];
   $responsable          = $_POST['responsable'];


   $query_insert=mysqli_query($conection,"INSERT INTO almecenes(iduser,nombre_almacen,direccion_almacen,sucursal,descripcion,responsable)
                                 VALUES('$iduser','$nombre_almacen','$direccion_almacen','$sucursal','$descripcion','$responsable') ");
   if ($query_insert) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }



 if ($_POST['action'] == 'eliminar_almacen') {
   $almacen             = $_POST['almacen'];

   $query_delete=mysqli_query($conection,"UPDATE almecenes SET estatus= 0  WHERE id='$almacen' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','almacen'=> $almacen);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
