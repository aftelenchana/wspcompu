<?php

include "../../../coneccion.php";
ob_start();
mysqli_set_charset($conection, 'utf8'); //linea a colocar
  session_start();
   $iduser= $_SESSION['id'];
  if (empty($_SESSION['active'])) {
      header('location:/');

  }else {

  }


$longitud = $_POST['longitud'];
$latitud = $_POST['latitud'];

        $fecha_actual = date("Y-m-d h:m:s");

       $query_insert=mysqli_query($conection,"INSERT INTO   historial_recorrido_transportista (id_transportista,longitud,latitud,fecha)
       VALUES('$iduser','$longitud','$latitud','$fecha_actual') ");
       if ($query_insert) {
          $last_inserted_id = mysqli_insert_id($conection);
         $arrayName = array('noticia' =>'insert_correct', 'id_insertado' => $last_inserted_id, 'longitud' => $longitud, 'latitud' => $latitud);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         // code...
       }else {
         $arrayName = array('noticia' =>'error_servidor');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }





 ?>
