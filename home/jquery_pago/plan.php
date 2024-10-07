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


 if ($_POST['action'] == 'info_plan') {

   $sql_facturas = mysqli_query($conection,"SELECT COUNT(*) as  facturas  FROM
   comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000'
   AND comprobante ='factura' AND estado ='COMPLETADO'");
 $result_facturas = mysqli_fetch_array($sql_facturas);
 $total_facturas = $result_facturas['facturas'];


   $sql_notas_credito = mysqli_query($conection,"SELECT COUNT(*) as  notas_credito  FROM
   comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante ='nota_credito' AND estado ='COMPLETADO'");
   $result_notas_creditos = mysqli_fetch_array($sql_notas_credito);
   $total_notas_creditos = $result_notas_creditos['notas_credito'];

   $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as  tikets  FROM
   tikets WHERE tikets.id_emisor  = '$iduser' ");
   $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
   $total_result_notas_venta = $result_notas_venta['tikets'];

   $total_documentos = $total_facturas + $total_facturas + $total_result_notas_venta;


   $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios
      WHERE usuarios.id ='$iduser'  ");
   $data_plan = mysqli_fetch_array($query_consulta);

   $documentos_electronicos = $data_plan['documentos_electronicos'];
   $fecha_maxima_documentos = $data_plan['fecha_maxima_documentos']; // Ejemplo: "2023-10-27"

   // Convertir las fechas a timestamps para compararlas
   $timestamp_fecha_maxima = strtotime($fecha_maxima_documentos);
   $timestamp_fecha_actual = strtotime(date("Y-m-d"));
   $fecha_actual_alex = date("Y-m-d");

   // Comparar las fechas
if ($timestamp_fecha_actual <= $timestamp_fecha_maxima) {

     if ($total_documentos <= $documentos_electronicos) {
       $arrayName = array('noticia'=>'fecha_menor','cantidad'=>'cantidad_correcta');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia'=>'fecha_menor','cantidad'=>'cantidad_incorrecta','resumen'=>'La cantidad máxima de documentos del paquete es '.$total_documentos.' ');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       exit;
     }
    } elseif ($timestamp_fecha_actual > $timestamp_fecha_maxima) {
     $arrayName = array('noticia'=>'fecha_mayor','resumen'=> 'La fecha es mayor, Fecha actual '.$fecha_actual_alex.', fecha máxima del paquete '.$fecha_maxima_documentos.' ');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;
   }




 }




















 ?>
