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
    $contenido_nota = $_POST['nota'];
    $nivel_nota = $_POST['nivel_nota'];
    $codigo_nota = $_POST['codigo_nota'];


    if ($nivel_nota == 'nota_1') {
      $query_insert=mysqli_query($conection,"UPDATE comprobantes SET detalle_extra= '$contenido_nota'
        WHERE id = '$codigo_nota'");
        if ($query_insert) {
          $arrayName = array('noticia' =>'insert_correct','contenido_nota'=>$contenido_nota,'nivel_nota'=>$nivel_nota,'codigo_nota'=>$codigo_nota);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


        }else {
          $arrayName = array('noticia' =>'error_servidor');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      // code...
    }

    if ($nivel_nota == 'nota_2') {
      $query_insert=mysqli_query($conection,"UPDATE comprobantes SET detalle_extra2= '$contenido_nota'
        WHERE id = '$codigo_nota'");
        if ($query_insert) {
          $arrayName = array('noticia' =>'insert_correct','contenido_nota'=>$contenido_nota,'nivel_nota'=>$nivel_nota,'codigo_nota'=>$codigo_nota);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


        }else {
          $arrayName = array('noticia' =>'error_servidor');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      // code...
    }









 }


 ?>
