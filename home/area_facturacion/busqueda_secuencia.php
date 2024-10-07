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


 if ($_POST['action'] == 'busqueda_secuencia') {

   $query_secuencia = mysqli_query($conection,"SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$iduser' ORDER BY secuencial DESC");
   $data_secuencia = mysqli_fetch_array($query_secuencia);
   if ($data_secuencia) {
     $estado_facturacion = $data_secuencia['estado_f'];
     if ($estado_facturacion == 'PROCESO') {
           $secuencial = $data_secuencia['secuencial'];

     }else {
       $secuencial = $data_secuencia['secuencial']+1;
     }



   }else {
     $secuencial = 1;
   }


   $arrayName = array('secuencial' =>$secuencial);
 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

 }



 if ($_POST['action'] == 'buscar_scuenccia_documento') {
   $tipo_documento_electronico_elejir = $_POST['tipo_documento_electronico_elejir'];


   $query_cantidad = mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
   $result_cantidad = mysqli_fetch_array($query_cantidad);
   $documentos_electronicos = $result_cantidad['documentos_electronicos'];
   $estableciminento_f = $result_cantidad['estableciminento_f'];
   $punto_emision_f = $result_cantidad['punto_emision_f'];

   if ($tipo_documento_electronico_elejir == 'Proforma') {
     $query = mysqli_query($conection, "SELECT * FROM  proformas   WHERE  proformas.id_emisor  = '$iduser'  ORDER BY secuencial DESC");
     $result = mysqli_fetch_array($query);
     if ($result) {
       $secuencial_proforma = $result['secuencial'];
       $secuencial_proforma = $secuencial_proforma+1;
       // code...
     }else {
       $secuencial_proforma =1;
     }

     $secuencial = str_pad($secuencial_proforma, 9, "0", STR_PAD_LEFT);
     $estableciminento_f = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
     $punto_emision_f = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);

     $numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;

     $resultado_documento_secuencial = 'Proforma:'.$numDocModificado;

     $arrayName = array('resultado_documento_secuencial' =>$resultado_documento_secuencial);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);




     // code...
   }


   if ($tipo_documento_electronico_elejir == 'Tiket Venta') {
     $query_secuencial = mysqli_query($conection, "SELECT * FROM  tikets  WHERE  tikets.id_emisor  = '$iduser'  ORDER BY secuencial DESC");
  		$result = mysqli_fetch_array($query_secuencial);
  		if ($result) {
  			$secuencial = $result['codigo_factura'];
  			$secuencial = $secuencial+1;
  			// code...
  		}else {
  			$secuencial =1;
  		}

      $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
      $estableciminento_f = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
      $punto_emision_f = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
      $numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;

      $resultado_documento_secuencial = 'Tiket Venta:'.$numDocModificado;
      $arrayName = array('resultado_documento_secuencial' =>$resultado_documento_secuencial);
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     // code...
   }


   if ($tipo_documento_electronico_elejir == 'Facturación') {
     $query = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser'  ORDER BY secuencial DESC");
     $result = mysqli_fetch_array($query);
     if ($result) {
       $secuencial = $result['codigo_factura'];
       $secuencial = $secuencial+1;
       // code...
     }else {
       $secuencial =1;
     }

     $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
     $estableciminento_f = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
     $punto_emision_f = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
     $numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;

     $resultado_documento_secuencial = 'Factura:'.$numDocModificado;
     $arrayName = array('resultado_documento_secuencial' =>$resultado_documento_secuencial);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     // code...
   }

   if ($tipo_documento_electronico_elejir == 'Nota de Venta Autorizada') {
     $query_secuencial = mysqli_query($conection, "SELECT * FROM  nota_venta_autorizada  WHERE  nota_venta_autorizada.id_emisor  = '$iduser'  ORDER BY secuencial DESC");
  		$result = mysqli_fetch_array($query_secuencial);
  		if ($result) {
  			$secuencial = $result['codigo_factura'];
  			$secuencial = $secuencial+1;
  			// code...
  		}else {
  			$secuencial =1;
  		}

      $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
      $estableciminento_f = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
      $punto_emision_f = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
      $numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;

      $resultado_documento_secuencial = 'Nota Venta Autorizada:'.$numDocModificado;
      $arrayName = array('resultado_documento_secuencial' =>$resultado_documento_secuencial);
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     // code...
   }



 }

 ?>
