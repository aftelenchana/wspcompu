<?php
include "../../coneccion.php";
session_start();
if (empty($_SESSION['active'])) {
  header('location:/');
}else {
  // code...
  $iduser= $_SESSION['id'];
  $producto = $_POST['producto'];
     mysqli_query($conection,"SET lc_time_names = 'es_ES'");
  $query_visitas = mysqli_query($conection,"SELECT inventario.cantidad_new,inventario.fecha,DATE_FORMAT(inventario.fecha, '%W  %d de %b %Y %H:%m') as 'fecha_p' FROM `inventario` WHERE inventario.idproducto = $producto ");
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
