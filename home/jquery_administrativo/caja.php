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


if ($_POST['action'] == 'abrir_caja') {
  $entrada_caja = $_POST['inicio_caja'];
  $query_factura3 = mysqli_query($conection,"SELECT * FROM `caja` WHERE caja.id_user   = '$iduser' AND caja.estado = 'ABIERTO' AND caja.IDROLPUNTOVENTA='ADMIN' ORDER BY caja.id  DESC ");
  $result_lista= mysqli_num_rows($query_factura3);
  if ($result_lista>0) {
    $arrayName = array('noticia'=>'caja_abierta');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    // code...
    $query_insert=mysqli_query($conection,"INSERT INTO caja(id_user,entrada_caja,importe_caja)
    VALUES('$iduser','$entrada_caja','$entrada_caja') ");

    if ($query_insert) {
      $arrayName = array('noticia'=>'insert_correct');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
  }
   // code...
 }
if ($_POST['action'] == 'cerrar_caja') {
  $hora_caja_abierta = $_POST['hora_caja_abierta'];
    $id_caja         = $_POST['id_caja'];


    $query_sensor_caja = mysqli_query($conection,"SELECT * FROM `caja` WHERE caja.id_user   = '$iduser' AND caja.id = '$id_caja' AND caja.IDROLPUNTOVENTA='ADMIN'  ORDER BY caja.id DESC LIMIT 1");
      $resultados_sensor_caja  = mysqli_fetch_array($query_sensor_caja);
      $entrada_caja =  $resultados_sensor_caja['entrada_caja'];





  $query_ganancias_factura = mysqli_query($conection,"SELECT SUM(comprobante_factura_final.subtotal) as 'subtotal',SUM(comprobante_factura_final.iva) as 'iva',SUM(comprobante_factura_final.total) as 'total'
  FROM comprobante_factura_final WHERE comprobante_factura_final.id_emisor = '$iduser' AND comprobante_factura_final.fecha >= '$hora_caja_abierta' AND comprobante_factura_final.IDROLPUNTOVENTA='ADMIN'");
  $result_ganancia_factura = mysqli_fetch_array($query_ganancias_factura);
  $subtotal_factura  = $result_ganancia_factura['subtotal'];
  $iva_factura       = $result_ganancia_factura['iva'];
  $total_factura     = $result_ganancia_factura['total'];

  if ($subtotal_factura == '') {
    $subtotal_factura =0.00;

  }
  if ($iva_factura == '') {
    $iva_factura =0.00;

  }
  if ($total_factura == '') {
    $total_factura =0.00;

  }


  $query_ganancias_tiket = mysqli_query($conection,"SELECT SUM(tikets.subtotal) as 'subtotal',SUM(tikets.iva) as 'iva',SUM(tikets.total) as 'total'
  FROM tikets WHERE tikets.id_emisor = '$iduser' AND tikets.fecha >= '$hora_caja_abierta' AND tikets.IDROLPUNTOVENTA='ADMIN' ");
  $result_ganancia_tiket = mysqli_fetch_array($query_ganancias_tiket);
  $subtotal_tiket  = $result_ganancia_tiket['subtotal'];
  $iva_tiket       = $result_ganancia_tiket['iva'];
  $total_tiket     = $result_ganancia_tiket['total'];
  if ($subtotal_tiket == '') {
    $subtotal_tiket =0.00;

  }
  if ($iva_tiket == '') {
    $iva_tiket =0.00;

  }
  if ($total_tiket == '') {
    $total_tiket =0.00;

  }



  $ganancias_caja= $total_tiket+$subtotal_factura ;
  $importe_caja = $total_factura+$total_tiket+$entrada_caja;

 $fecha_actual = date("Y-m-d h:i:s");
  $fecha_emision =  date("Y-m-d h:i:s",strtotime($fecha_actual." +0 hours"));

  $query_insert = mysqli_query($conection,"UPDATE caja SET subtotal_factura='$subtotal_factura',iva_factura='$iva_factura',
    total_factura='$total_factura',subtotal_tiket='$subtotal_tiket',iva_tiket='$iva_tiket',
      total_tiket='$total_tiket',ganancias_caja='$ganancias_caja',importe_caja='$importe_caja',estado='CERRADO',fecha_cierre='$fecha_emision'
     WHERE id = '$id_caja' AND caja.IDROLPUNTOVENTA='ADMIN'");
  if ($query_insert) {
      $arrayName = array('noticia'=>'insert_correct');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      $arrayName = array('noticia' =>'error_insertar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

   // code...
 }



 ?>
