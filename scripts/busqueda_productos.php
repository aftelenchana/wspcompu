<?php
require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


if ($_POST['action'] == 'buscar_producto') {
  $busqueda = strtolower($_POST['valorBusqueda']);

  $empresa = $_POST['empresa'];

  if (empty($busqueda)) {
    $query_lista = mysqli_query($conection, "SELECT producto_venta.idproducto,producto_venta.url_upload_img,producto_venta.nombre,producto_venta.categoria_rst,producto_venta.maximo_seleccion,producto_venta.nombre,
      producto_venta.precio,producto_venta.foto FROM producto_venta

    INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
                WHERE producto_venta.id_usuario = '$empresa' AND  producto_venta.foto != '' AND  producto_venta.url_upload_img != ''
                ORDER BY producto_venta.id_usuario DESC");
  }else {
    $query_lista = mysqli_query($conection, "SELECT producto_venta.idproducto,producto_venta.url_upload_img,producto_venta.nombre,producto_venta.categoria_rst,producto_venta.maximo_seleccion,producto_venta.nombre,
      producto_venta.precio,producto_venta.foto  FROM producto_venta
    INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
                WHERE (producto_venta.nombre like '%$busqueda%' OR producto_venta.descripcion like '%$busqueda%' OR producto_venta.precio like '%$busqueda%') AND producto_venta.id_usuario = '$empresa' AND  producto_venta.foto != '' AND  producto_venta.url_upload_img != ''
                ORDER BY producto_venta.id_usuario DESC");
  }




    $result_lista= mysqli_num_rows($query_lista);

    if ($result_lista > 0) {
      echo '           <div class="contenedor-sin-resultados">
          <p class="texto-sin-resultados">Existen '.$result_lista.' resultados para la búsqueda '.$busqueda.'</p>
                  </div>';
      while ($data_lista=mysqli_fetch_array($query_lista)) {
        $idp = $data_lista['idproducto'];
      $url_upload_img = $data_lista['url_upload_img'];
      $caracteres = strlen($data_lista['nombre']);
      $nombre_final =substr($data_lista['nombre'], 0, 35);
      $precio_rst = $data_lista['precio'];
        $foto = $data_lista['foto'];

        //codigo para la calificacion
        $query=mysqli_query($conection,"SELECT * FROM `estrellas`
         WHERE id_producto='$idp'");
         $result_lista= mysqli_num_rows($query);
         if ($result_lista>0) {
           $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
           WHERE id_producto='$idp'");
           $data_estrella=mysqli_fetch_array($sql_estrella);
           $numero_calificaciones =  $data_estrella['numero_calificaciones'];
           $estrellas_totales =  $data_estrella['estrellas_totales'];
           $calificacion = round($estrellas_totales/$numero_calificaciones);
         }else {
           $calificacion = 0;
         }

         if ($calificacion == 0) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
             <div class="star-icon">
             <form class="" action="index.html" method="post">
             <label style="font-weight: 1;" for="rating1" class="fa fa-star"></label><label style="font-weight: 1;"  for="rating2" class="fa fa-star"></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
             </form>
             </div>
             </div>';
           // code...
         }
         if ($calificacion == 1) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
           <div class="star-icon">
             <form class="" action="index.html" method="post">
               <label for="rating1" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
             </form>
           </div>
             </div>';
         }
         if ($calificacion == 2) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
           <div class="star-icon">
           <form class="" action="index.html" method="post">
           <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
           </form>
           </div>
             </div>';
         }
         if ($calificacion == 3) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
           <div class="star-icon">
           <form class="" action="index.html" method="post">
             <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label  for="rating3" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
         </form>
       </div>
             </div>';
         }
         if ($calificacion == 4) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
           <div class="star-icon">
             <form class="" action="index.html" method="post">
               <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label  for="rating3" class="fa fa-star estrella_pintada"></label><label  for="rating4" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
             </form>
           </div>
             </div>';
         }
         if ($calificacion == 5) {
           $estrellas = '   <div class="result_estrellas estrellas'.$empresa.' ">
           <div class="star-icon">
             <form class="" action="index.html" method="post">
               <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label  for="rating3" class="fa fa-star estrella_pintada"></label><label  for="rating4" class="fa fa-star estrella_pintada"></label><label  for="rating5" class="fa fa-star estrella_pintada"></label>
             </form>
           </div>
             </div>';
         }

         echo '

         <a  href="producto?codigo='.$idp.'"  >
           <div class="olmedo_secundario_jl">
             <div class="articulo_lista_salida">
               <!-- Producto 1 -->
               <article class="product agregar_articulo_orden" >
                   <div class="product-content">
                       <img src="'.$url_upload_img.'/home/img/uploads/'.$foto.'" alt="Imagen del producto 1" />
                   </div>

               </article>

               <div  class="contenedor_informaciongeneral_tienda">
                 <p style="padding: 0;margin: 0;" class="nombre_producto_empresa_out">'.$nombre_final.'</p>
                 '.$estrellas.'

                 <p style="padding: 0;margin: 0;">$'.round($precio_rst,2).'</p>
               </div>
             </div>
           </div>
         </a>

         ';





      }
    }else {
      echo '           <div class="contenedor-sin-resultados">
      <p class="texto-sin-resultados">No existen resultados para: '.$busqueda.'</p>
                    <img src="home/img/reacciones/sin-resultados.png" alt="No hay resultados" class="imagen-sin-resultados" />
                  </div>';
    }
}

 ?>
