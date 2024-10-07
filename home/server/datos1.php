<?php
$dato = $_GET['id'];
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_dato = mysqli_query($conection,"SELECT * FROM subcategorias WHERE id_c = $dato ");
while ($dato = mysqli_fetch_array($query_dato)) {
    echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';
}
 ?>
