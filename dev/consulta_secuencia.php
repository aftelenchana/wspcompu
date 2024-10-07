<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET');
header('content-type: application/json; charset=utf-8');


if (!empty($_GET['id'])) {
  require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
  $iduser          = $_GET['user'];
  $codigo_sucursal = $_GET['codigo_sucursal'];


  $query_usuario = "SELECT * FROM usuarios WHERE id ='$iduser'";
  $result_usuario = mysqli_query($conection, $query_usuario);
  $existencia_usuario = mysqli_num_rows($result_usuario);

  if ($existencia_usuario>0) {

    $query_secuencial = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = $iduser ORDER BY fecha DESC LIMIT 1");
   $result_secuencial = mysqli_fetch_array($query_secuencial);
   if ($result_secuencial) {
     $secuencial = $result_secuencial['codigo_factura'];
     $secuencial = $secuencial +1;
     // code...
   }else {
     $secuencial =1;
   }

   $data = ['iduser'=>$iduser,'secuencial'=>$secuencial];
   echo $json_info = json_encode($data);


  }else {
    $data = ['respuesta'=>'usuario no existente'];
    echo $json_info = json_encode($data);
  }




}else {
  $data = ['respuesta'=>'id_usuario_vacio'];
  echo $json_info = json_encode($data);
}


 ?>
