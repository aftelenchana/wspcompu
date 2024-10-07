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


 if ($_POST['action'] == 'agregar_nota') {

   $nota             = $_POST['nota'];
   $query_insert=mysqli_query($conection,"INSERT INTO notas(iduser,nota)
                                 VALUES('$iduser','$nota') ");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'realiar_nota') {
   $nota             = $_POST['nota'];

   $fecha_actual = date("Y-m-d h:i:s");



   $query_insert = mysqli_query($conection,"UPDATE notas SET estatus='0', fecha_finalizacion='$fecha_actual'
     WHERE id = '$nota'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','nota'=> $nota,'fecha'=>$fecha_actual);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }


 if ($_POST['action'] == 'eliminar_nota') {
   $nota             = $_POST['nota'];

   $query_insert = mysqli_query($conection,"DELETE FROM notas
     WHERE id = '$nota'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','nota'=> $nota);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
