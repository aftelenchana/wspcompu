<?php
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_retenciones = mysqli_query($conection,"SELECT * FROM conceptos_retencion  ORDER BY id ASC");



while ($data_retenciones = mysqli_fetch_array($query_retenciones)) {
    echo '<option value="'.$data_retenciones['codigo'].'">'.$data_retenciones['codigo'].'-'.$data_retenciones['nombre'].'</option>';
}
 ?>
