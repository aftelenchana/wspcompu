<?php
require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


if ($_POST['action'] == 'buscar_empresa') {
  $busqueda = strtolower($_POST['valorBusqueda']);

  if (empty($busqueda)) {
    $query_lista = mysqli_query($conection, "SELECT DISTINCT usuarios.id, usuarios.nombre_empresa, usuarios.img_facturacion, usuarios.url_img_upload, usuarios.direccion, usuarios.id_e FROM usuarios
                INNER JOIN producto_venta ON producto_venta.id_usuario = usuarios.id
                WHERE (usuarios.img_facturacion != '' OR usuarios.img_facturacion IS NOT NULL)
                AND (usuarios.nombre_empresa != '' OR usuarios.nombre_empresa IS NOT NULL)
                AND usuarios.nombre_empresa != '0'
                AND (usuarios.url_img_upload != '' OR usuarios.url_img_upload IS NOT NULL)
                AND usuarios.direccion != ''
                AND usuarios.id_e != ''
                AND usuarios.id_e != '0'
                GROUP BY producto_venta.id_usuario");
  }else {
    $query_lista = mysqli_query($conection, "SELECT DISTINCT usuarios.id, usuarios.nombre_empresa, usuarios.img_facturacion, usuarios.url_img_upload, usuarios.direccion, usuarios.id_e FROM usuarios
                INNER JOIN producto_venta ON producto_venta.id_usuario = usuarios.id
                WHERE (usuarios.nombres like '%$busqueda%' OR usuarios.apellidos like '%$busqueda%' OR usuarios.nombre_empresa like '%$busqueda%'
                OR usuarios.email like '%$busqueda%' OR usuarios.direccion like '%$busqueda%') AND (usuarios.img_facturacion != '' OR usuarios.img_facturacion IS NOT NULL)
                AND (usuarios.nombre_empresa != '' OR usuarios.nombre_empresa IS NOT NULL)
                AND usuarios.nombre_empresa != '0'
                AND (usuarios.url_img_upload != '' OR usuarios.url_img_upload IS NOT NULL)
                AND usuarios.direccion != ''
                AND usuarios.id_e != ''
                AND usuarios.id_e != '0'
                GROUP BY producto_venta.id_usuario");
  }




    $result_lista= mysqli_num_rows($query_lista);

    if ($result_lista > 0) {

      echo '           <div class="contenedor-sin-resultados">
          <p class="texto-sin-resultados">Existen '.$result_lista.' resultados para la búsqueda '.$busqueda.'</p>
                  </div>';


      while ($data_lista=mysqli_fetch_array($query_lista)) {
        $nombre_empresa = $data_lista['nombre_empresa'];
        $img_facturacion = $data_lista['img_facturacion'];
        $url_img_upload = $data_lista['url_img_upload'];
        $direccion = $data_lista['direccion'];
        $empresa = $data_lista['id'];
        $id_e = $data_lista['id_e'];

        //codigo para la calificacion
        $query=mysqli_query($conection,"SELECT * FROM `estrellas`
        INNER JOIN producto_venta ON producto_venta.idproducto = estrellas.id_producto
        INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
        WHERE usuarios.id = '$empresa'");
         $result_lista= mysqli_num_rows($query);
         if ($result_lista>0) {
           $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM `estrellas`
           INNER JOIN producto_venta ON producto_venta.idproducto = estrellas.id_producto
           INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
           WHERE usuarios.id = '$empresa'");
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


        echo  '
        <a href="code_user?code='.$id_e.'&name='.$nombre_empresa.'">
          <div class="olmedo_secundario_jl">
            <div class="articulo_lista_salida">
              <!-- Producto 1 -->
              <article class="product card mb-3 agregar_articulo_orden" >
                  <div class="product-name bg-info">
                      '.$nombre_empresa.'
                  </div>
                  <div class="product-content">
                      <img src="'.$url_img_upload.'/home/img/uploads/'.$img_facturacion.'" class="card-img-top" alt="Imagen del producto 1" />
                  </div>

               '.$estrellas.'

              </article>
              <div class="contenedor_informaciongeneral_tienda">
                <p>'.$nombre_empresa.'</p>
                <p>'.$direccion.'</p>
              </div>
            </div>
          </div>
        </a>';


      }
    }else {
      echo '           <div class="contenedor-sin-resultados">
      <p class="texto-sin-resultados">No existen resultados para: '.$busqueda.'</p>
                    <img src="home/img/reacciones/sin-resultados.png" alt="No hay resultados" class="imagen-sin-resultados" />
                  </div>';
    }
}

 ?>
