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

   $query_consulta = mysqli_query($conection, "SELECT * FROM parametros_credenciales
      WHERE parametros_credenciales.iduser ='$iduser'  AND parametros_credenciales.estatus = '1'
   ORDER BY `parametros_credenciales`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_parametros') {

        $nombres_parametro      = $_POST['nombres_parametro'];
        $visibilidad            = $_POST['visibilidad'];
        $descripcion_parametro  = $_POST['descripcion_parametro'];

        if ($visibilidad == 'on') {
          $visibilidad = 1;
          // code...
        }else {
          $visibilidad = 0;
        }



   $query_insert=mysqli_query($conection,"INSERT INTO  parametros_credenciales (iduser,nombre,visibilidad,descipcion)
                                 VALUES('$iduser','$nombres_parametro','$visibilidad','$descripcion_parametro') ");

   if ($query_insert) {


       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_parametro') {
      $parametro       = $_POST['parametro'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM parametros_credenciales
         WHERE parametros_credenciales.iduser ='$iduser'  AND parametros_credenciales.estatus = '1' AND parametros_credenciales.id = '$parametro' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_parametro') {
   $id_parametro      = $_POST['id_parametro'];
   $nombres_parametro      = $_POST['nombres_parametro'];

   $descripcion_parametro  = $_POST['descripcion_parametro'];

   $visibilidad           = (isset($_REQUEST['visibilidad'])) ? $_REQUEST['visibilidad'] : '';

   if ($visibilidad == 'on') {
     $visibilidad = 1;
     // code...
   }else {
     $visibilidad = 0;
   }


   $query_insert = mysqli_query($conection,"UPDATE parametros_credenciales SET nombre='$nombres_parametro',visibilidad='$visibilidad',descipcion='$descripcion_parametro'
     WHERE id = '$id_parametro'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_parametro'=> $id_parametro);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_parametro') {
   $parametro             = $_POST['parametro'];

   $query_delete=mysqli_query($conection,"UPDATE parametros_credenciales SET estatus= 0  WHERE id='$parametro' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','parametro'=> $parametro);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
