<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

  $clave_acceso_factura = $_POST['clave_acceso_factura'];

     include 'ctr_xml_corregir_error.php';
     include 'ctr_firmarxml_corregir_no_autorizado.php';

     $xmlf=new xml();
     $xmlf->xmlFactura($iduser,$clave_acceso_factura);

     $xmla=new autorizar();
     $xmla->autorizar_xml($iduser,$clave_acceso_factura);






?>
