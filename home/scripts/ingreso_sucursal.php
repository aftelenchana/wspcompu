<?php
session_start();
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8');

$query_lista = mysqli_query($conection," SELECT *
   FROM usuarios");
    $result_lista= mysqli_num_rows($query_lista);
  if ($result_lista > 0) {
        while ($data_lista=mysqli_fetch_array($query_lista)) {
          $iduser =$data_lista['id'];
          $estableciminento_f =$data_lista['estableciminento_f'];
          $punto_emision_f =$data_lista['punto_emision_f'];
          $direccion =$data_lista['direccion'];

          $query_insert_dato=mysqli_query($conection,"INSERT INTO sucursales(iduser,direccion_sucursal,punto_emision,establecimiento,tipo)
                                                                      VALUES('$iduser','$direccion','$punto_emision_f','$estableciminento_f','MATRIZ') ");



            if ($query_insert_dato) {
              $arrayName = array('noticia'=>'insertado_correctamente');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              // code...
            }else {
              $arrayName = array('noticia'=>'error_editar');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }


        }
    }






 ?>
