<?php
$codigo = $_GET['codigo'];
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_porcentaje_retenciones = mysqli_query($conection,"SELECT * FROM porcentajes_retencion  WHERE codigo = '$codigo' ");
while ($data_porcentajes_retenciones = mysqli_fetch_array($query_porcentaje_retenciones)) {
    echo '<option value="'.$data_porcentajes_retenciones['id'].'">'.$data_porcentajes_retenciones['porcentaje'].'</option>';
}
 ?>
