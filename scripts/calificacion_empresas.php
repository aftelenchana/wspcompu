<?php



$query=mysqli_query($conection,"SELECT * FROM `estrellas`
  INNER JOIN producto_venta ON producto_venta.idproducto = estrellas.id_producto
  INNER JOIN usuarios ON usuarios.id =  producto_venta.id_usuario
 WHERE usuarios.id='$empresa'");
 $result_lista= mysqli_num_rows($query);
 if ($result_lista>0) {
   $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
   INNER JOIN producto_venta ON producto_venta.idproducto = estrellas.id_producto
   INNER JOIN usuarios ON usuarios.id =  producto_venta.id_usuario
   WHERE usuarios.id='$empresa'");
   $data_estrella=mysqli_fetch_array($sql_estrella);
   $numero_calificaciones =  $data_estrella['numero_calificaciones'];
   $estrellas_totales =  $data_estrella['estrellas_totales'];
   $calificacion = round($estrellas_totales/$numero_calificaciones);


   echo "$calificacion";

 }else {
   echo "0";
 }

 ?>
