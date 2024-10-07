<?php
include "../../coneccion.php";
session_start();
if (empty($_SESSION['active'])) {
  header('location:/');
}else {
  // code...
  $iduser= $_SESSION['id'];
  $producto = $_POST['producto'];
  $query_visitas = mysqli_query($conection,"SELECT COUNT(*) as  total_visitas,visitas.id_producto,visitas.fecha FROM `visitas` WHERE visitas.id_producto = $producto GROUP BY visitas.fecha;");
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
