<?php
$codigo = $_GET['codigo'];
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

$query_tabla_5_ats = mysqli_query($conection,"SELECT * FROM tabla_5_ats   WHERE tipo_comprobante = '$codigo' ");
while ($data_tabla_5_ats = mysqli_fetch_array($query_tabla_5_ats)) {
    echo '<option value="'.$data_tabla_5_ats['tipo_comprobante'].'">'.$data_tabla_5_ats['tipo_sustento'].'</option>';
}
 ?>
