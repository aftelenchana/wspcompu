<?php
session_start();
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8');

$query_lista = mysqli_query($conection," SELECT comprobante_factura_final.cedula_receptor,comprobante_factura_final.id,
  comprobante_factura_final.nombres_receptor,comprobante_factura_final.email_receptor,comprobante_factura_final.direccion_receptor,
  comprobante_factura_final.celular_receptor,comprobante_factura_final.secuencia,comprobante_factura_final.clave_acceso,comprobante_factura_final.id_emisor
   FROM comprobante_factura_final
  WHERE  (comprobante_factura_final.secuencia != '00000000' || comprobante_factura_final.secuencia IS NOT NULL)
    AND comprobante = 'factura'
ORDER BY `comprobante_factura_final`.`fecha` desc");
    $result_lista= mysqli_num_rows($query_lista);
  if ($result_lista > 0) {
        while ($data_lista=mysqli_fetch_array($query_lista)) {
          $clave_acceso =$data_lista['clave_acceso'];
          $id_emisor =$data_lista['id_emisor'];

            $establecimiento = substr($clave_acceso, 24, 3); // Extrae los dígitos del establecimiento
            $punto_emision = substr($clave_acceso, 27, 3); // Extrae los dígitos del punto de emisión
            $secuencial = substr($clave_acceso, 30, 9); // Extrae los dígitos secuenciales

            $establecimiento_sin_ceros = ltrim($establecimiento, '0');
            $punto_emision_sin_ceros = ltrim($punto_emision, '0');



            $query_consulta = mysqli_query($conection, "SELECT * FROM sucursales
               WHERE sucursales.establecimiento ='$establecimiento_sin_ceros'  AND sucursales.punto_emision = '$punto_emision_sin_ceros' AND sucursales.iduser = '$id_emisor' ");

                 $resultado_existencias= mysqli_num_rows($query_consulta);

                 if ($resultado_existencias >0) {
                   $data_sucursales = mysqli_fetch_array($query_consulta);
                     $id_sucursal =$data_sucursales['id'];
                   // code...
                 }else {
                   $id_sucursal = '';
                 }



         $query_edit_comprbante=mysqli_query($conection,"UPDATE comprobante_factura_final SET establecimiento= '$establecimiento_sin_ceros',punto_emision= '$punto_emision_sin_ceros',
           sucursal_facturacion = '$id_sucursal'
           WHERE clave_acceso = '$clave_acceso'  ");
           if ($query_edit_comprbante) {
                       echo "$establecimiento_sin_ceros-$punto_emision_sin_ceros";
             // code...
           }else {
             $arrayName = array('noticia'=>'error_editar');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }


        }
    }






 ?>
