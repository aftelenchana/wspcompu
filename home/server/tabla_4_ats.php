<?php
require "../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_tabla_4_ast = mysqli_query($conection,"SELECT * FROM tabla_4_ats  ORDER BY id ASC");



while ($data_tabla_4_ats = mysqli_fetch_array($query_tabla_4_ast)) {
    echo '<option value="'.$data_tabla_4_ats['codigo'].'">'.$data_tabla_4_ats['codigo'].'-'.$data_tabla_4_ats['tipo_comprobante'].'</option>';
}
 ?>
