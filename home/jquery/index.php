<?php
include "../../coneccion.php";
session_start();
$id_user           =  $_SESSION['id'];
$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro FROM producto_venta  WHERE estatus = 1");
$result_register = mysqli_fetch_array($sql_registe);
$total_registro = $result_register['total_registro'];

$por_pagina = 20;
if (empty($_GET['pagina'])) {
  $pagina = 1;
}else {
  $pagina = $_GET['pagina'];
}
$desde = ($pagina-1)*$por_pagina;
$total_paginas = ceil($total_registro/$por_pagina);


$query_lista = mysqli_query($conection,"SELECT producto_venta.idproducto, producto_venta.nombre as 'nombre_producto', producto_venta.precio,producto_venta.estado,provincia.nombre as 'provincia',ciudad.nombre as 'ciudad',producto_venta.foto,usuarios.facebook,
   usuarios.instagram,usuarios.whatsapp,usuarios.empresa, producto_venta.fecha_producto,categorias.nombre as 'categorias', subcategorias.nombre as 'subcategorias',categorias.imagen as 'imagen_cat'  FROM producto_venta
INNER JOIN categorias ON producto_venta.categorias = categorias.id
INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
INNER JOIN provincia ON producto_venta.provincia = provincia.id
INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id WHERE estatus = 1  ORDER BY fecha_producto DESC LIMIT $desde,$por_pagina");
$result_lista= mysqli_num_rows($query_lista);
 while ($data_lista=mysqli_fetch_array($query_lista)) {
   $foto = 'img/uploads/'.$data_lista['foto'];
   echo '<div class="total_comerse">
           <div class="producto">
             <div class="tabla_producto">
               <table>
                 <tr class="img_producto">
                   <td class="fila_img_producto"> <img src="'.$foto.'" alt=""> </td>
                 </tr>
                 <tr class="nomnre_producto_j">
                   <td class="fila_nombre_producto">'.$data_lista['nombre_producto'].'</td>
                 </tr>
                 <tr class="precio_columna">
                   <td class="fila_precio">$ '.$data_lista['precio'].'</td>
                 </tr>
                 <tr class="lugar_producto">
                   <td class="lugar_fila" >Quito</td>
                 </tr>
                 <tr class="columna_comprar">
                   <td> <a class="vista_comprar"  producto="<?php echo $idproducto; ?>" href="#">Comprar <img src="img/reacciones/carro_compras.png" alt=""> </a> </td>
                 </tr>
               </table>
             </div>
           </div>
         </div>';

   // code...
 }





?>
