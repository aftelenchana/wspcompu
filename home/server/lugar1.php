<?php
$lugar = $_GET['id'];
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_lugar = mysqli_query($conection,"SELECT * FROM ciudad WHERE id_p = $lugar ");
while ($lugar = mysqli_fetch_array($query_lugar)) {
    echo '<option value="'.$lugar['id'].'">'.$lugar['nombre'].'</option>';
}
 ?>
