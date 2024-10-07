<?php
require '../../../QR/phpqrcode/qrlib.php';
 include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();
   if ($_SESSION['rol'] == 'cuenta_empresa') {
   include "../../../sessiones/session_cuenta_empresa.php";

   }

   if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
   include "../../../sessiones/session_cuenta_usuario_venta.php";

   }

   if ($_SESSION['rol'] == 'Mesero') {
   include "../../../sessiones/session_cuenta_mesero.php";

   }

   if ($_SESSION['rol'] == 'Cocina') {
   include "../../../sessiones/session_cuenta_cocina.php";
   }

   $rol_user = $_SESSION['rol'];





     $codigo_retencion = $_POST['proceso_retencion'];
     $porcentaje_retencion = $_POST['porcentajes_retencion'];
     $codigo_compra = $_POST['codigo_compra'];
     $clave_acceso_factura = $_POST['clave_acceso_factura'];

     $codSustento = $_POST['tabla_4_ats'];
     $codDocSustento = $_POST['tabla_5_ats'];
     $impuesto_retener = $_POST['impuesto_retener'];


     //codigo para sacar información para ver si ya esta hecha la nota de credito para no hacer denuevo

     $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso_retencion ='$clave_acceso_factura' ");
     $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
     if ($data_existencia) {
       		$arrayName = array('noticia'=>'nota_credito_existente');
       		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;

     }else {

       include 'ctr_xml_retencion.php';
       include 'ctr_retencion_firmar.php';




     }



     $xmlf=new xml();
     $xmlf->xmlFactura($codigo_retencion,$porcentaje_retencion,$codigo_compra,$clave_acceso_factura,$codSustento,$codDocSustento,$impuesto_retener);

     $xmla=new autorizar();
     $xmla->autorizar_xml($codigo_retencion,$porcentaje_retencion,$codigo_compra,$clave_acceso_factura,$codSustento,$codDocSustento,$impuesto_retener);

?>
