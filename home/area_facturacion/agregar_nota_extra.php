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


if ($_POST['action'] == 'agregar_nota_extra') {
   $codigo_factura = $_POST['codigo_factura'];
    $nota_extra = $_POST['nota_extra'];

    $query_nota = mysqli_query($conection, "SELECT * FROM notas_extras_facturacion   WHERE iduser = '$iduser'
    AND codigo_factura = '$codigo_factura' AND codigo_factura = '$codigo_factura'");
    $data_nota = mysqli_fetch_array($query_nota);

    if ($data_nota) {
      $query_insert=mysqli_query($conection,"UPDATE notas_extras_facturacion SET texto= '$nota_extra'
        WHERE iduser = '$iduser' AND codigo_factura = '$codigo_factura'  ");

    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO notas_extras_facturacion (iduser, codigo_factura , texto)
     VALUES('$iduser','$codigo_factura', '$nota_extra') ");
    }


  if ($query_insert) {
    $arrayName = array('noticia' =>'insert_correct','nota_extra'=>$nota_extra);
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


  }else {
    $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

 }


 ?>
