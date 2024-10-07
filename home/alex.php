<?php
include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar
      session_start();
      if (empty($_SESSION['active'])) {
        header('location:/');
      }else {

      }
   $iduser= $_SESSION['id'];

   $query_consulta = mysqli_query($conection, "SELECT consultas_medicas.id as 'codigo_consulta' FROM consultas_medicas
     INNER JOIN clientes ON clientes.id = consultas_medicas.paciente
      WHERE consultas_medicas.iduser ='$iduser'  AND consultas_medicas.estatus = '1'
   ORDER BY `consultas_medicas`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));

 ?>
