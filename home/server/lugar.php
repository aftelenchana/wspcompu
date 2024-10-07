<?php
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_lugar = mysqli_query($conection,"SELECT * FROM provincia ORDER BY nombre ASC");



while ($lugar = mysqli_fetch_array($query_lugar)) {
    echo '<option value="'.$lugar['id'].'">'.$lugar['nombre'].'</option>';
}
 ?>
