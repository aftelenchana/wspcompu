<?php
include "../../coneccion.php";
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
$fecha_1 = '2022-11-28';
$fecha_2 = '2022-12-06';

$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro  FROM
comprobante_factura_final
WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000'
AND comprobante_factura_final.fecha BETWEEN '$fecha_1' AND '$fecha_2' GROUP BY comprobante_factura_final.codigo_factura ORDER BY `comprobante_factura_final`.`fecha` DESC  ");
$result_register = mysqli_fetch_array($sql_registe);
$total_registro = $result_register['total_registro'];
$query_lista = mysqli_query($conection,"SELECT * FROM `comprobante_factura_final`
WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000'
 AND comprobante_factura_final.fecha BETWEEN '$fecha_1' AND '$fecha_2'
GROUP BY comprobante_factura_final.codigo_factura
ORDER BY `comprobante_factura_final`.`fecha` DESC");
    $result_lista= mysqli_num_rows($query_lista);
        while ($data_lista=mysqli_fetch_array($query_lista)) {
          header('Content-disposition: attachment; filename=1212202201099330317800120010010000002041234567811.pdf');
          header("Content-type: application/pdf");
          readfile('../facturacion/facturacionphp/comprobantes/pdf/1212202201099330317800120010010000002041234567811.pdf');

  }

?>
