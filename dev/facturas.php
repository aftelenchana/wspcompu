<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET');
header('content-type: application/json; charset=utf-8');

 if (!empty($_GET['user'])) {
   $id_usuario_ip = $_GET['user'];
    require "../coneccion.php" ;
   $query_usuario = "SELECT * FROM usuarios WHERE id ='$id_usuario_ip'";
   $result_usuario = mysqli_query($conection, $query_usuario);
   $existencia_usuario = mysqli_num_rows($result_usuario);
  if ($existencia_usuario>0) {

     $data_usuario =mysqli_fetch_array($result_usuario);
     $numero_identidad = $data_usuario ['numero_identidad'];
     $nombre_empresa = $data_usuario ['nombre_empresa'];

    $query_lista = mysqli_query($conection,"SELECT comprobante_factura_final.fecha,comprobante_factura_final.codigo_factura,comprobante_factura_final.nombres_receptor,
      comprobante_factura_final.cedula_receptor,comprobante_factura_final.email_receptor,comprobante_factura_final.clave_acceso,comprobante_factura_final.descripcion,
      comprobante_factura_final.id_producto,comprobante_factura_final.total,comprobante_factura_final.id,comprobante_factura_final.estado,comprobante_factura_final.subtotal
      ,comprobante_factura_final.iva
      FROM `comprobante_factura_final`
      WHERE comprobante_factura_final.id_emisor  = '$id_usuario_ip' AND (comprobante_factura_final.secuencia != '00000000' || comprobante_factura_final.secuencia IS NOT NULL) AND comprobante ='factura'
      GROUP BY comprobante_factura_final.codigo_factura
      ORDER BY `comprobante_factura_final`.`fecha` DESC");
      $result_lista= mysqli_num_rows($query_lista);
         $as= 1;
      if ($result_lista > 0) {
          while ($data_lista=mysqli_fetch_array($query_lista)) {
            $arr_facturas[$as] = array(
                  "clave_acceso" => "$data_lista[clave_acceso]",
                  "fecha" => "$data_lista[fecha]",
                  "nombres_receptor" => "$data_lista[nombres_receptor]",
                  "email_receptor" => "$data_lista[email_receptor]",
                  "estado" => "$data_lista[estado]",
                  "cedula_receptor" => "$data_lista[cedula_receptor]",
                  "subtotal" => "$data_lista[subtotal]",
                  "iva" => "$data_lista[iva]",
                  "total" => "$data_lista[total]"
                  );
       $as=$as+1;
      }
      $array_multi_general = array('numero_identidad' => $numero_identidad,'nombre_empresa'=>$nombre_empresa,'facturas'=>$arr_facturas );
      echo $json = json_encode($array_multi_general);

}else {
  $data = ['respuesta'=>'el usuario no tiene facturas'];
  echo $json_info = json_encode($data);
}

     // code...
   }else {
     $data = ['respuesta'=>'no existe el usuario'];
     echo $json_info = json_encode($data);
   }


 }else {
   $data = ['respuesta'=>'usuario vacio'];
   echo $json_info = json_encode($data);
 }

 ?>
