<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar




 if ($_POST['action'] == 'eliminar_venta_masiva') {
   $venta = $_POST['venta'];
    $query_delete=mysqli_query($conection,"UPDATE ventas_externas_generadas SET estatus= 0  WHERE id='$venta' ");

    if ($query_delete) {
      $arrayName = array('noticia' =>'elimado_correctamnete','venta'=>$venta);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }else {
        $arrayName = array('noticia' =>'error_insertar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
      exit;
 }

 ?>
