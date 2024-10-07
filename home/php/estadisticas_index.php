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





if ($_POST['action']  == 'estadisticas') {
  $iduser= $_SESSION['id'];
  $producto = $_POST['producto'];
     mysqli_query($conection,"SET lc_time_names = 'es_ES'");
  $query_visitas = mysqli_query($conection,"SELECT comprobante_factura_final.fecha,comprobante_factura_final.total FROM `comprobante_factura_final` WHERE comprobante_factura_final.id_emisor = $iduser
    AND comprobante_factura_final.codigo_interno_factura != '00000000'
    AND comprobante ='factura' AND comprobante_factura_final.total IS NOT NULL  ");
  while ($resultados = mysqli_fetch_array($query_visitas)) {
    $visitas[] = $resultados ;
  }

  if (empty($visitas)) {
    $visitas[0] = array(0,0,'Ninguna');
  }

  $arrayName = array('visitas' =>$visitas);
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
if ($_POST['action']  == 'estadisticas_notas_venta') {
  $iduser= $_SESSION['id'];
  $producto = $_POST['producto'];
     mysqli_query($conection,"SET lc_time_names = 'es_ES'");
  $query_visitas = mysqli_query($conection,"SELECT  tikets.fecha,tikets.total FROM `tikets` WHERE tikets.id_emisor = $iduser
    AND tikets.codigo_interno_factura != '00000000' AND tikets.total IS NOT NULL  ");
  while ($resultados = mysqli_fetch_array($query_visitas)) {
    $visitas[] = $resultados ;
  }

  if (empty($visitas)) {
    $visitas[0] = array(0,0,'Ninguna');
  }

  $arrayName = array('visitas' =>$visitas);
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}


 ?>
