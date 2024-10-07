<?php
ob_start();
include "../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
  session_start();
   $iduser= $_SESSION['id'];
$idp = $_GET['idp'];
$idp_ttt = $_GET['idp'];
if (empty($_GET['idp'])) {
  if (empty($_SESSION['active'])) {
    header('location:/');

  }
}else {
  if (empty($_SESSION['active'])) {
        header("location:/producto?idp=$idp");
  }
}

   $fecha=date('d/m/Y');
 $query_insert_busqueda=mysqli_query($conection,"INSERT INTO visitas(id_usuario,id_producto,tipo_busqueda,fecha)
 															VALUES('$iduser','$idp','interna','$fecha') ");
$query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $idp");
$data_producto = mysqli_fetch_array($query_producto);
$img_producto =  $data_producto['foto'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:locale" content="es_ES" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo $data_producto['nombre'] ?>" />
  <meta property="og:description" content="<?php echo $data_producto['descripcion'] ?>" />
  <meta property="og:image" content="https://www.guibis.com/home/img/reacciones/guibis.pg">
  <meta property="og:url" content="https://www.guibis.com/producto" />
  <title class="title"><?php echo $data_producto['nombre'] ?></title>
  <link rel="icon"  href="img/reacciones/guibis.png">
  <link rel="stylesheet" href="estiloshome/info_extra_pro.css">
	<link rel="stylesheet" href="emergencia/emergencia.css">
  <link rel="stylesheet" href="/home/estiloshome/vie-product.css">
  <link rel="stylesheet" href="estiloshome/new_servicio4.css">
  <link rel="stylesheet" href="../iniio/estilos.css">
  <link rel="stylesheet" href="jquery/foto_general.css">
  <link rel="stylesheet" href="jquery/foto_general2.css">
  <link rel="stylesheet" href="estiloshome/metodo_pago.css">
  <link rel="stylesheet" href="estiloshome/correciones3.css">
  <link rel="stylesheet" href="correcciones/pie_pagina.css">
  <link rel="stylesheet" href="correcciones/comprar_producto.css">
  <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estiloshome/bloque.css">
  <link rel="stylesheet" href="prueba_estilos/home.css">
  <link rel="stylesheet" href="estiloshome/estilos-generales.css">
  <link rel="stylesheet" href="estiloshome/estilos_contador_index.css">
  <link rel="stylesheet" href="estiloshome/estilos_paginador.css">
  <link rel="stylesheet" href="estiloshome/correcciones1.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estiloshome/sin_resultados.css">
  <link rel="stylesheet" href="estiloshome/cuadro_comparativo2.css">
  <link rel="stylesheet" href="estiloshome/load.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estiloshome/boton_pagos.css">
  <link rel="stylesheet" href="estiloshome/estrellas.css">
  <link rel="stylesheet" href="estiloshome/estrellas2.css">
  <link rel="stylesheet" href="estiloshome/cuenta_bancaria.css">
  <link rel="stylesheet" href="estiloshome/preguntas_respuestas.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="/estilos/targeta_producto.css?v=9">
  <link rel="stylesheet" href="estilos-importante/comprar-articulo.css?v=2">
  <link rel="stylesheet" href="estilos-importante/targeta_principal_articulo.css?v=14">
  <link rel="stylesheet" href="estilos-importante/video-js.css?v=1">
  <link rel="stylesheet" href="estilos-importante/video.css?v=1">
  <link rel="stylesheet" href="estilos-importante/parametros-descriptivos.css?v=4">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin="" />


</head>
<body>
 <?php
 $iduser= $_SESSION['id'];
 $queryu = mysqli_query($conection, "SELECT * FROM producto_venta  WHERE idproducto = '$idp'");
 $resultu = mysqli_fetch_array($queryu);
 $categorias = $resultu['categorias'];
  ?>



	<?php include "scripts/menu.php" ?>


    <input type="hidden" name="producto" value="<?php echo "$idp"; ?>" id="producto">



    <?php
    mysqli_query($conection,"SET lc_time_names = 'es_ES'");
    $query_producto = mysqli_query($conection, "SELECT
      producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,usuarios.longitud as 'longitud_user_producto',usuarios.latitud as 'latitud_user_producto',
      producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,producto_venta.id_usuario,producto_venta.pais,
      usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,producto_venta.cat1sub44_enlace_descarga,producto_venta.cat_1_sub_44_timpo_licencia,producto_venta.cat1sub44_desarrolador,
        DATE_FORMAT(producto_venta.fecha_producto, '%W  %d de %b %Y %h:%m:%s') as 'fecha_producto',producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
       producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,categorias.id as 'number_categorias',
       producto_venta.cantidad_boletos,usuarios.id as 'id_user',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
       producto_venta.peso,usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',producto_venta.provincia as 'provincia',producto_venta.ciudad as 'ciudad',
       subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias',usuarios.mi_leben,producto_venta.ficha_tecnica,producto_venta.video_explicativo,producto_venta.id_producto_sugerido
       ,producto_venta.cargador_1,producto_venta.peso_1,producto_venta.marca_1,producto_venta.tamano_1,producto_venta.almacenamiento_1,producto_venta.autor_libro_2,producto_venta.enlace_digital_2,
       producto_venta.introduccion_libro_2,producto_venta.talla_3,producto_venta.color_3,producto_venta.peso_3,producto_venta.material_4,producto_venta.medidas_4,producto_venta.peso_4,producto_venta.material_5,
       producto_venta.medidas5,producto_venta.posicionado_5,producto_venta.color_5,producto_venta.peso_5,producto_venta.material_6,producto_venta.medidas_6,producto_venta.marca_6,producto_venta.color_6,producto_venta.peso_6,producto_venta.perecederos_7,
       producto_venta.expiracion_7,producto_venta.peso_7,producto_venta.enlace_9,producto_venta.introducion_9,producto_venta.incluye_envio,producto_venta.utilizar_transporte_guibis
      FROM producto_venta
     INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
     INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
     INNER JOIN categorias ON producto_venta.categorias = categorias.id
        WHERE idproducto = $idp
        AND producto_venta.estatus = 1");
        $data_producto = mysqli_fetch_array($query_producto);
          $img_producto =  $data_producto['foto'];
          $id_categorias_number = $data_producto['number_categorias'];
          $nombre_para_tarjeta = $data_producto['nombre'];
          $precio_separador = explode(".",number_format($data_producto['precio'],2) );
          $ifra_entera = $precio_separador[0];
          if (!empty($precio_separador[1])) {
            $cigra_decimal =  $precio_separador[1];
          }else {
            $cigra_decimal= '00';
          }



     ?>
     <div class="contenedor_general_informacion_at">
       <div class="row">
         <div class="col col-lg-6 imagene_principal_at">
           <div class="imagener_contenededor_general_at">
             <div id="carouselExampleControls<?php echo $idp ?>" class="carousel slide" data-ride="carousel" >
                 <div class="carousel-inner">
                   <?php $query_imagenes = mysqli_query($conection,"SELECT * FROM img_producto WHERE idp = '$idp'");
                        $result_imagenes= mysqli_num_rows($query_imagenes);

                   ?>
                   <?php if ($result_imagenes<=1): ?>
                     <div class="carousel-item active"  >
                         <a href="perfil?id=<?php echo $data_producto['id_usuario'] ?>" target="_blanck" >
                         <img src="img/uploads/<?php echo $img_producto  ?>" class="d-block w-100 img-fluid" alt=""
                         >
                         </a>
                     </div>
                   <?php endif; ?>
                   <?php if ($result_imagenes>1): ?>
                     <?php
                     $img0= 0;
                     while ($data_lista_img=mysqli_fetch_array($query_imagenes)) {
                       $img0 =$img0+ 1;
                      ?>

                     <div class="carousel-item <?php  if ($img0 ==1) {echo "active"; } ?>" >
                         <a href="perfil?id=<?php echo $data_producto['id_usuario'] ?>" target="_blanck">
                         <img src="/home/img/uploads/<?php echo $data_lista_img['img']; ?>" class="d-block w-100 img-fluid" alt="<?php echo $data_lista_img['img']; ?>">
                         </a>
                     </div>

                   <?php
                       }
                    ?>

                   <?php endif; ?>

                 </div>
                 <?php if ($result_imagenes<=1): ?>
                   <a class="carousel-control-prev visu-laterales" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next visu-laterales" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
                 <?php endif; ?>
                 <?php if ($result_imagenes>1): ?>
                   <a class="carousel-control-prev barra_lateral_principal" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next barra_lateral_principal" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
                 <?php endif; ?>
             </div>
           </div>
                              <p>Descripción: <?php echo $data_producto['descripcion'] ?></p>
         </div>
         <div class="col informacion_productoat">
           <div class="row">
             <div class="col">
               <h1><?php echo $data_producto['nombre'] ?></h1>
               <a href="perfil?id=<?php echo $data_producto['id_usuario'] ?>">Visita toda la tienda</a>
                <div class="calificacion_resultado_at" id="calificacion_resultado_at"></div>
                 <p class="precio_articulo"><sup>$</sup> <?php echo $ifra_entera?><sup class="dedima_precio"><?php echo $cigra_decimal ?></sup> </p>
                 <?php if ($data_producto['incluye_envio'] =='SI'): ?>
                   <p class="disponible_envio_bajo">Este producto incluye envio, se puede tener articulos de menor precio sin envio</p>

                 <?php endif; ?>
                 <?php if ($data_producto['incluye_envio'] =='NO'): ?>
                   <p class="disponible_envio_bajo">No disponible a un precio mas económico con envio gratis</p>

                 <?php endif; ?>
                 <div class="categorizadas_at">
                   <p>Fecha:<?php echo $data_producto['fecha_producto'] ?> </p>
                   <p>Pais:<?php echo $data_producto['pais'] ?> </p>
                   <p>Provincia:<?php echo $data_producto['provincia'] ?> </p>
                   <p>Ciudad:<?php echo $data_producto['ciudad'] ?></p>
                   <p>Categorias: <span> <a href="#"><?php echo $data_producto['categorias'] ?></a> </span> </p>
                   <p>Subcategorias: <span> <a href="#"><?php echo $data_producto['subcategorias'] ?></a> </span> </p>

                 </div>
             </div>

           </div>
           <div class="row">
             <div class="col">
               <div class="contenedor-boton-pago">
                 <button type="button" articulo="<?php echo "$idp"; ?>" class="btn btn-primary btn-comprar_articulo boton_principal_articulo"  name="button">COMPRAR ARTICULO</button>
               </div>             </div>

           </div>

         </div>
         <div class="col acciones_producttos_at">
           <div class="row precio_3">
             <div class="col">
               <p class="precio_articulo"><sup>$</sup> <?php echo $ifra_entera?><sup class="dedima_precio"><?php echo $cigra_decimal ?></sup> </p>
             </div>

           </div>
           <div class="row">
             <div class="col">
               <?php
               $cuenta_digital = $data_producto['mi_leben'];
               if ($cuenta_digital == 'Activa') {
                 $estado_bancario = '<button type="button" class="btn btn-success btn-lg btn-block">Transacción Segura</button>';
                 // code...
               }else {
                 $estado_bancario = '<button type="button" class="btn btn-danger btn-lg btn-block">Trnasacción No Segura</button>';
               }
                ?>
                <?php echo $estado_bancario ?>

             </div>
           </div>
           <div class="row especificacion_vendedres">
             <?php
             $nombre_empresa = $data_producto['nombre_empresa'];
             $nombre_usuario = $data_producto['nombre_usuario'];
             if ($nombre_empresa == '') {
               $nombre_tienda = $nombre_usuario;
             }else {
               $nombre_tienda = $nombre_empresa;
             }
              ?>
             <div class="col">
               <p> <a class="" href="perfil?id=<?php echo $data_producto['id_usuario'] ?>&empresa=<?php echo $nombre_tienda ?>">Vendido por <?php echo $nombre_tienda ?></a> </p>
               <p> <a class="" href="perfil?id=<?php echo $data_producto['id_usuario'] ?>&empresa=<?php echo $nombre_tienda ?>">Empaquetado por <?php echo $nombre_tienda ?></a> </p>
             </div>
           </div>
           <div class="row">
             <div class="col">
               <div class="rating-css">
                 <div class="star-icon">
                   <form class="" action="index.html" method="post">
                     <input type="radio" name="rating1" id="rating1" value="1" oninput="calificar_1_estrella()">
                     <label for="rating1" class="fa fa-star"></label>

                     <input type="radio" name="rating1" id="rating2" value="2" oninput="calificar_2_estrella()">
                     <label for="rating2" class="fa fa-star"></label>

                     <input type="radio" name="rating1" id="rating3" value="3" oninput="calificar_3_estrella()">
                     <label for="rating3" class="fa fa-star"></label>

                     <input type="radio" name="rating1" id="rating4" value="4" oninput="calificar_4_estrella()">
                     <label for="rating4" class="fa fa-star"></label>

                     <input type="radio" name="rating1" id="rating5" value="5" oninput="calificar_5_estrella()">
                     <input type="hidden" name="id_producto" id="id_producto" value="<?php echo "$idp"; ?>">
                     <label for="rating5" class="fa fa-star"></label>
                   </form>
                 </div>
               </div>
             </div>
           </div>
           <div class="row redes_at">
             <div class="col">
              <?php
              $instagram      = $data_producto['instagram'];
              $whatsapp       = $data_producto['whatsapp'];
              $facebook       = $data_producto['facebook'];
              $tiktok         = $data_producto['tiktok'];
              if ($nombre_empresa == '') {
                $nombre_salida = $nombres;
                // code...
              }else {
                $nombre_salida = $nombre_empresa;
              }
              if ($instagram != '') {
                $instagram = '<a target="_blank"  href="'.$instagram.'"> <img src="img/reacciones/instagram.png" alt=""></a>';
                // code...
              }
              if ($whatsapp != '') {
                $whatsapp = '<a target="_blank" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&text=Hola!&nbsp;el&nbsp;producto&nbsp;Es&nbsp;https://guibis.com/producto.php?idp='.$data_producto['idproducto'].'"><img src="img/reacciones/whatsapp.png" alt=""></a>';
                // code...
              }
              if ($facebook != '') {
                $facebook = '<a target="_blank"  href="'.$facebook.'"> <img src="img/reacciones/facebook.png" alt=""></a>';
                // code...
              }
              if ($tiktok != '') {
                $tiktok = '<a target="_blank"  href="https://www.'.$tiktok.'"> <img src="img/reacciones/tiktok.png" alt=""></a>';
                // code...
              }
               ?>
               <?php echo $instagram ?>
               <?php echo $whatsapp ?>
               <?php echo $facebook ?>
               <?php echo $tiktok ?>
             </div>
           </div>
           <div class="row manuales">
             <div class="col descargar_manual">
               <p>Descargar Manual de Compra</p>
               <a href="archivos/accioncomprar/guia_compra.pdf" download> <img src="img/reacciones/pdf.png" alt=""> </a>
             </div>
           </div>
           <div class="row manuales">
             <div class="col descargar_manual">
               <p>Descargar Manual de Venta</p>
               <a href="archivos/accioncomprar/guia_venta.pdf" download> <img src="img/reacciones/pdf.png" alt=""> </a>
             </div>
           </div>
           <div class="row">
             <div class="col">

             </div>

           </div>
         </div>
       </div>

     </div>




     <div class="row informacion_subtotal_categorias">
       <?php if (!empty($data_producto['cargador_1'])): ?>
         <div class="col">
           <p><span>Tiene Cargador</span> <span><?php echo ($data_producto['cargador_1']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['peso_1'])): ?>
         <div class="col">
           <p><span>Peso del Producto</span> <span><?php echo ($data_producto['peso_1']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['marca_1'])): ?>
         <div class="col">
           <p><span>Marca</span> <span> <?php echo ($data_producto['marca_1']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['tamano_1'])): ?>
         <div class="col">
           <p><span>Tamaño</span> <span><?php echo ($data_producto['tamano_1']); ?>*15</span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['almacenamiento_1'])): ?>
         <div class="col">
           <p><span>Almacenamiento</span> <span> <?php echo ($data_producto['almacenamiento_1']); ?> GB</span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['autor_libro_2'])): ?>
         <div class="col">
           <p><span>Autor del Libro</span> <span><?php echo ($data_producto['autor_libro_2']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['enlace_digital_2'])): ?>
         <div class="col">
           <p><span>Enlace Digital</span> <span> <?php echo ($data_producto['enlace_digital_2']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['introduccion_libro_2'])): ?>
         <div class="col">
           <p><span>Introducción</span> <span> <?php echo ($data_producto['introduccion_libro_2']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['talla_3'])): ?>
         <div class="col">
           <p><span>Talla</span> <span> <?php echo ($data_producto['talla_3']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['color_3'])): ?>
         <div class="col">
           <p><span>Color</span> <span> <?php echo ($data_producto['color_3']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['peso_3'])): ?>
         <div class="col">
           <p><span>Peso</span> <span> <?php echo ($data_producto['peso_3']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['material_4'])): ?>
         <div class="col">
           <p><span>Material</span> <span> <?php echo ($data_producto['material_4']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['medidas_4'])): ?>
         <div class="col">
           <p><span>Medidas</span> <span> <?php echo ($data_producto['medidas_4']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['peso_4'])): ?>
         <div class="col">
           <p><span>Posicionado</span> <span> <?php echo ($data_producto['peso_4']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['material_5'])): ?>
         <div class="col">
           <p><span>Color</span> <span> <?php echo ($data_producto['material_5']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['medidas5'])): ?>
         <div class="col">
           <p><span>Peso</span> <span> <?php echo ($data_producto['medidas5']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['posicionado_5'])): ?>
         <div class="col">
           <p><span>Material 6</span> <span> <?php echo ($data_producto['posicionado_5']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['color_5'])): ?>
         <div class="col">
           <p><span>Medidas 6</span> <span> <?php echo ($data_producto['color_5']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['peso_5'])): ?>
         <div class="col">
           <p><span>Marca 6</span> <span> <?php echo ($data_producto['peso_5']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['material_6'])): ?>
         <div class="col">
           <p><span>Color 6</span> <span> <?php echo ($data_producto['material_6']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['medidas_6'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['medidas_6']); ?></span> </p>
         </div>

       <?php endif; ?>


       <?php if (!empty($data_producto['marca_6 '])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['marca_6']); ?></span> </p>
         </div>

       <?php endif; ?>

       <?php if (!empty($data_producto['color_6'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['color_6']); ?></span> </p>
         </div>

       <?php endif; ?>

       <?php if (!empty($data_producto['peso_6'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['peso_6']); ?></span> </p>
         </div>

       <?php endif; ?>

       <?php if (!empty($data_producto['perecederos_7'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['perecederos_7']); ?></span> </p>
         </div>

       <?php endif; ?>

       <?php if (!empty($data_producto['expiracion_7'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['expiracion_7']); ?></span> </p>
         </div>
       <?php endif; ?>
       <?php if (!empty($data_producto['peso_7'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['peso_7']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['enlace_9'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['enlace_9']); ?></span> </p>
         </div>
       <?php endif; ?>

       <?php if (!empty($data_producto['introducion_9'])): ?>
         <div class="col">
           <p><span>Peso 6</span> <span> <?php echo ($data_producto['introducion_9']); ?></span> </p>
         </div>
       <?php endif; ?>
       <?php if (!empty($data_producto['cat1sub44_enlace_descarga'])): ?>
         <div class="col">
           <p><span>Tiene Enlace de Descarga :</span>SI <br> (Una vez que compres este producto te llega un enlace de Descarga) <span></span> </p>
         </div>
       <?php endif; ?>
       <?php if (!empty($data_producto['cat_1_sub_44_timpo_licencia'])): ?>
         <div class="col">
           <p><span>Tiempo de Licencia :</span> <span> <?php echo ($data_producto['cat_1_sub_44_timpo_licencia']); ?></span> </p>
         </div>
       <?php endif; ?>
       <?php if (!empty($data_producto['cat1sub44_desarrolador'])): ?>
         <div class="col">
           <p><span>Desarrollador:</span> <span> <?php echo ($data_producto['cat1sub44_desarrolador']); ?></span> </p>
         </div>
       <?php endif; ?>
     </div>

     <?php if (!empty($data_producto['longitud_user_producto'])): ?>
       <?php
       $longitid = $data_producto['longitud_user_producto'];
       $latitud  = $data_producto['latitud_user_producto'];

        ?>
  <div id="myMap" style="height:300px"></div>
     <?php endif; ?>


     <div class="cotenedor_parametros_generales">
       <div class="row">

           <?php if (!empty($data_producto['ficha_tecnica'])): ?>
             <div class="col">
               <h3>Ficha Técnica</h3>
               <p> <span>Ficha Técnica</span> <span> <a target="_blank" href="/home/img/fichas/<?php echo $data_producto['ficha_tecnica'] ?>"> <img src="/home/img/reacciones/pdf.png" alt="" width="50px;"> </a> </span> </p>
             </div>
           <?php endif; ?>
           <?php if (!empty($data_producto['id_producto_sugerido'])): ?>
             <div class="col">
               <h3>Producto Sugerido</h3>
               <p> <span> Producto Sugerido : <?php echo $data_producto['id_producto_sugerido'] ?> </span> </p>
             </div>
           <?php endif; ?>
         <div class="col">
           <h3>INFORMACIÓN DE  ENVIO</h3>
           <?php
           $incluye_envio = $data_producto['incluye_envio'];
           $utilizar_transporte_guibis = $data_producto['utilizar_transporte_guibis'];
           if ($incluye_envio == 'SI') {
              $incluye_envio = '<div class="alert alert-success" role="alert">Este producto si incluye Envio!</div>';
           }else {
             $incluye_envio = '<div class="alert alert-danger" role="alert">Este producto no incluye Envio!</div>';
           }

           if ($utilizar_transporte_guibis == 'SI') {
             $utilizar_transporte_guibis = '<div class="alert alert-success" role="alert">Este producto si ocupa transporte Guibis!</div>';
           }else {
             $utilizar_transporte_guibis = '<div class="alert alert-danger" role="alert">Este producto no ocupa Trnasporte Guibis!</div>';
           }


            ?>

           <p><span>Incluye Envio</span> <span> <a target="_blank" href="informacion_envio"> <?php echo $incluye_envio ?> </a> </span>  </p>
           <p> <span>Ocupa Transpote <a href="#">Guibis.com</a> : </span> <span> <a href="informacion_transporte"><?php echo $utilizar_transporte_guibis ?></a> </span> </p>
         </div>
       </div>
     </div>


     <?php if (!empty($data_producto['video_explicativo'])): ?>
       <div class="titulo_producto_sugerido">
         <h4>Video Explicativo</h4>
       </div>
       <div class="contenedor_video">
         <video class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="fm-video">
           <source src="img/videos/<?php echo $data_producto['video_explicativo'] ?>" type="">
           </video>
         </div>

     <?php endif; ?>








     <?php if (!empty($data_producto['id_producto_sugerido'])): ?>
       <div class="titulo_producto_sugerido">
         <h4>Producto Anclado por la tienda</h4>
       </div>
       <?php
       $idp_sugerido= $data_producto['id_producto_sugerido'];
       $query_producto_sugerido = mysqli_query($conection, "SELECT
         producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
         producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,
         usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,
         producto_venta.fecha_producto,producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
         producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,
         producto_venta.cantidad_boletos,usuarios.id as 'id_user',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
         producto_venta.peso,usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',producto_venta.provincia as 'provincia',producto_venta.ciudad as 'ciudad',
         subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias',usuarios.mi_leben,producto_venta.ficha_tecnica
         FROM producto_venta
         INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
         INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
         INNER JOIN categorias ON producto_venta.categorias = categorias.id
         WHERE idproducto = $idp_sugerido
         AND producto_venta.estatus = 1");
         $data_producto_sugerido = mysqli_fetch_array($query_producto_sugerido);
         $img_producto_sugerido =  $data_producto_sugerido['foto'];
         $precio_separador_sugerido = explode(".",$data_producto_sugerido['precio'] );
         $ifra_entera_sugerido = $precio_separador_sugerido[0];
         if (!empty($precio_separador_sugerido[1])) {
           $cigra_decimal_sugerido =  $precio_separador_sugerido[1];
         }else {
           $cigra_decimal_sugerido= '00';
         }
         ?>
         <div class="producto_sugerido">
           <div class="container">
             <div class="row">
               <div class="col">
                 <div class="imagener_contenededor_general_at">
                   <div id="carouselExampleControls<?php echo $idp_sugerido ?>" class="carousel slide" data-ride="carousel" >
                     <div class="carousel-inner">
                       <?php $query_imagenes = mysqli_query($conection,"SELECT * FROM img_producto WHERE idp = '$idp_sugerido'");
                       $result_imagenes= mysqli_num_rows($query_imagenes);

                       ?>
                       <?php if ($result_imagenes<=1): ?>
                         <div class="carousel-item active"  >
                           <a href="producto?idp=<?php echo $idp_sugerido ?>" target="_blanck" >
                             <img src="img/uploads/<?php echo $img_producto_sugerido  ?>" class="d-block w-100 img-fluid" alt=""
                             >
                           </a>
                         </div>
                       <?php endif; ?>
                       <?php if ($result_imagenes>1): ?>
                         <?php
                         $img0= 0;
                         while ($data_lista_img=mysqli_fetch_array($query_imagenes)) {
                           $img0 =$img0+ 1;
                           ?>

                           <div class="carousel-item <?php  if ($img0 ==1) {echo "active"; } ?>" >
                             <a href="" target="_blanck">
                               <img src="/home/img/uploads/<?php echo $data_lista_img['img']; ?>" class="d-block w-100 img-fluid" alt="<?php echo $data_lista_img['img']; ?>">
                             </a>
                           </div>

                           <?php
                         }
                         ?>

                       <?php endif; ?>

                     </div>
                     <?php if ($result_imagenes<=1): ?>
                       <a class="carousel-control-prev visu-laterales" href="#carouselExampleControls<?php echo $idp_sugerido ?>" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                       </a>
                       <a class="carousel-control-next visu-laterales" href="#carouselExampleControls<?php echo $idp_sugerido ?>" role="button" data-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                       </a>
                     <?php endif; ?>
                     <?php if ($result_imagenes>1): ?>
                       <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $idp_sugerido ?>" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                       </a>
                       <a class="carousel-control-next" href="#carouselExampleControls<?php echo $idp_sugerido ?>" role="button" data-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                       </a>
                     <?php endif; ?>
                   </div>

                 </div>
               </div>
               <div class="col-5">
                 <p>Nombre:<?php echo $data_producto_sugerido['nombre']; ?></p>
                 <p class="precio_articulo_producto_sugerido"><sup>$</sup> <?php echo $ifra_entera_sugerido?><sup class="dedima_precio"><?php echo $cigra_decimal_sugerido ?></sup> </p>
               </div>
               <div class="col">
                 <?php
                 $cuenta_digital = $data_producto_sugerido['mi_leben'];
                 if ($cuenta_digital == 'Activa') {
                   $estado_bancario = '<button type="button" class="btn btn-success btn-lg btn-block">Transacción Segura</button>';
                   // code...
                 }else {
                   $estado_bancario = '<button type="button" class="btn btn-danger btn-lg btn-block">Trnasacción No Segura</button>';
                 }
                 ?>
                 <?php echo $estado_bancario ?>
               </div>
             </div>
           </div>

         </div>

     <?php endif; ?>


     <div class="contendedor_parametros_acturales">
       <table class="table table-responsive " >
          <thead>
            <tr>
              <th scope="col">Parámetros</th>
              <th scope="col">Imagen</th>
              <th scope="col">Producto</th>
              <th scope="col">Precio</th>
              <th scope="col">Garantia</th>
              <th scope="col">Icluye Envio</th>
              <th scope="col">Video</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query_lista = mysqli_query($conection, "SELECT usuarios.nombre_empresa,usuarios.nombres as 'nombre_usuario',producto_venta.garantia,producto_venta.ficha_tecnica,producto_venta.video_explicativo,
              producto_venta.foto,producto_venta.nombre as 'nombre_producto',producto_venta.precio,producto_venta.idproducto,producto_venta.incluye_envio,usuarios.id as 'id_tienda' FROM producto_venta
              INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
              INNER JOIN categorias ON categorias.id = producto_venta.categorias
            WHERE producto_venta.estatus = 1 AND categorias.id ='$id_categorias_number'  ORDER BY producto_venta.idproducto DESC LIMIT 1,8 " );
             while ($data_lista=mysqli_fetch_array($query_lista)) {
               $nombre_empresa = $data_lista['nombre_empresa'];
               $nombre_usuario = $data_lista['nombre_usuario'];
               if ($nombre_empresa == '') {
                 $nombre_tienda = $nombre_usuario;
               }else {
                 $nombre_tienda = $nombre_empresa;
               }
                     ?>
            <tr class="guia_">
              <th scope="row"> <a target="_blank" href="perfil?id=<?php echo $data_lista['id_tienda'] ?>"><?php echo $nombre_tienda ?></a> </th>
              <td> <img src="img/uploads/<?php echo $data_lista['foto'] ?>" width="100px" alt=""> </td>
              <td> <a target="_blank" href="producto?idp=<?php echo $data_lista['idproducto'] ?>"> <?php echo $data_lista['nombre_producto'] ?> </a> </td>
              <td>$<?php echo number_format($data_lista['precio'],2) ?></td>
              <td><?php echo $data_lista['garantia'] ?> TIENE GARANTIA</td>
              <td class="ficha_tecnica_at">
              <?php echo $data_lista['incluye_envio'] ?> INCLUYE ENVIO
               </td>

              <td class="video_at">
                <?php
                if ($data_lista['video_explicativo'] != '') {
                  echo '<a target="_blank" href="img/videos/'.$data_lista['video_explicativo'].'"> <img src="img/reacciones/video.png" alt=""> </a>';
                }
                 ?>
              </td>
            </tr>
            <?php
            }
        ?>
          </tbody>
        </table>
     </div>


  <br>


  <br>
  <h3 style="text-align: center;font-size: 40px;">Preguntas y Respuestas</h3>
<div class="">
  <div class="contenedor-preguntas">
  <?php

  $query_lista = mysqli_query($conection,"SELECT preguntas.fecha,preguntas.pregunta,preguntas.id_pregunta,usuario_pregunta.nombres
     as 'nombres_pregunta',usuario_pregunta.apellidos as 'apellidos_pregunta',preguntas.fecha,preguntas.id   FROM preguntas
INNER JOIN usuarios AS usuario_pregunta ON usuario_pregunta.id = preguntas.id_pregunta
WHERE id_producto = '$idp'  ORDER BY fecha DESC  LIMIT 0,10");
  $result_lista= mysqli_num_rows($query_lista);
  if ($result_lista > 0) {
        while ($data_lista=mysqli_fetch_array($query_lista)) {
          $nombres_pregunta = $data_lista['nombres_pregunta'];
          $apellidos_pregunta = $data_lista['apellidos_pregunta'];
          $fecha_pregunta = $data_lista['fecha'];
          $pregunta = $data_lista['pregunta'];
          $id_pregunta = $data_lista['id'];
            if ($nombres_pregunta == '') {
              $n_1 = 'G';
              $nombres_pregunta='G';
            }else {
            $n_1 = $nombres_pregunta[0];
            }
            if ($apellidos_pregunta == '') {
              $n_2 = 'G';
              $apellidos_pregunta='G';
            }else {
            $n_2 = $apellidos_pregunta[0];
            }
            $nombre_pregunta = "$n_1$n_2";
   ?>
    <div class="pregunta">
      <div class="img_user_pregunta conte_img_name">
        <p class="name_delta"><?php echo $nombre_pregunta ?></p> <p style="display: flex;" class="name_uer"> <span><?php echo $nombres_pregunta ?> comenta el <?php echo $fecha_pregunta ?> :</span> </p>
      </div>
      <p class="pregunta_user"><?php echo $pregunta ?></p>
    </div>
    <?php
    $query_responde = mysqli_query($conection,"SELECT preguntas.fecha_respuesta,preguntas.respuesta,preguntas.id_pregunta,usuario_responde.nombres
      as 'nombres_responde',usuario_responde.apellidos as 'apellidos_responde',preguntas.fecha,preguntas.id  FROM `preguntas`
      INNER JOIN usuarios AS usuario_responde ON usuario_responde.id=preguntas.id_responde
      WHERE preguntas.id = '$id_pregunta'");
      $data_respuesta=mysqli_fetch_array($query_responde);
      $respuesta =  $data_respuesta['respuesta'];
      if ($respuesta == '') {
        $respuesta_interna = 'Ninguna';
        // code...
      }else {
        $nombres_responde = $data_lista['nombres_responde'];
        $apellidos_responde = $data_lista['apellidos_responde'];
        $fecha_respuesta = $data_lista['fecha_respuesta'];
        $respuesta = $data_lista['respuesta'];
        if ($nombres_responde == '') {
          $n_1 = 'G';
          $nombres_responde='G';
        }else {
          $n_1 = $nombres_responde[0];
        }
        if ($apellidos_responde == '') {
          $n_2 = 'G';
          $apellidos_responde='G';
        }else {
          $n_2 = $apellidos_responde[0];
        }
        $nombre_responde = "$n_1$n_2";
      }
      ?>
      <?php if ($respuesta==''): ?>
        <div class="respuesta">
          <div class="img_user_respuesta conte_img_name">
            <p style="display: flex;" class="name_uer" >Respuesta:Ninguna</p>
          </div>
        </div>

      <?php endif; ?>
      <?php if ($respuesta!=''): ?>
        <div class="respuesta">
          <div class="img_user_respuesta conte_img_name">
             <p class="name_delta">VE</p><p style="display: flex;" class="name_uer" ><span>Vendedor responde el <?php echo $fecha_respuesta ?>:</span></p>
          </div>
          <p class="respuesta_user"><?php echo $respuesta; ?></p>
        </div>

      <?php endif; ?>

    <?php
    }
  }
?>
    <div class="code_respuesta" id="code_respuesta">
      <div class="notificacion_pregunta" style="text-align: center;">

      </div>

    </div>
    <div class="hacer_pregunta">
      <form class="" action="" method="post" name="add_preguntas" id="add_preguntas" onsubmit="event.preventDefault(); sendData_preguntas();" >
        <input type="submit" name="" value="Comentar">
        <input type="hidden" name="action" value="agregar_pregunta">
        <input type="hidden" name="idp" value="<?php echo $idp; ?>">
        <textarea name="pregunta" rows="3" cols="140" required></textarea>
      </form>
    </div>

  </div>
</div>


  <div style="text-align: center;font-size: 35px;" class="suge_titu">
    <p>Sugerencias de Producto</p>
  </div>

  <div class="contenedor_productos_footer">




  <?php

  $query_sugerencias = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
    producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias', ciudad.nombre as 'ciudad2', usuarios.nombre_empresa,
    usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp, usuarios.img_logo,usuarios.id,
     producto_venta.fecha_producto,producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
     producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,
     producto_venta.cantidad_boletos,usuarios.id as 'ide',provincia.nombre as 'provincia',producto_venta.forma,producto_venta.marca,
     producto_venta.peso,producto_venta.embalaje,usuarios.posicion,producto_venta.id_usuario
    FROM producto_venta
      INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
          INNER JOIN categorias ON producto_venta.categorias = categorias.id
      INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
      INNER JOIN provincia ON provincia.id = producto_venta.provincia
      INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
      WHERE idproducto = $idp
      AND producto_venta.estatus = 1 ");
      $result_sugerencias = mysqli_fetch_array($query_sugerencias);
      $nombre_p_sugerencia = $result_sugerencias['nombre'];
$precio_p_sugerencia = $result_sugerencias['precio'];
$provincia_p_sugerencia = $result_sugerencias['provincia'];
$ciudad_p_sugerencia = ($result_sugerencias['ciudad2']);
$subcategorias_p_sugerencia = $result_sugerencias['subcategorias'];
$categorias_p_sugerencia = $result_sugerencias['categorias'];
$descripcion_p_sugerencia = $result_sugerencias['descripcion'];
   ?>
       <?php
       //PAGINADOR
       $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro FROM producto_venta
INNER JOIN categorias ON producto_venta.categorias = categorias.id
INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
INNER JOIN provincia ON producto_venta.provincia = provincia.id
INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id WHERE (producto_venta.nombre like '%$nombre_p_sugerencia%' OR producto_venta.descripcion like '%$descripcion_p_sugerencia%' OR producto_venta.precio like '%$precio_p_sugerencia%' OR
  ciudad.nombre like '%$ciudad_p_sugerencia%' OR provincia.nombre like '%$provincia_p_sugerencia%' OR
   categorias.nombre LIKE '%$categorias_p_sugerencia%' OR
   subcategorias.nombre LIKE '%$subcategorias_p_sugerencia%') AND producto_venta.estatus = 1 AND  producto_venta.idproducto != $idp" );
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



       $query_lista = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre as 'nombre_producto', producto_venta.precio,producto_venta.estado,provincia.nombre as 'provincia',ciudad.nombre as 'ciudad',producto_venta.foto,usuarios.facebook,
          usuarios.instagram,usuarios.whatsapp,usuarios.empresa, producto_venta.fecha_producto,categorias.nombre as 'categoria', subcategorias.nombre as 'subcategorias',categorias.imagen as 'imagen_cat',usuarios.id as 'id_usuario_hg'  FROM producto_venta
       INNER JOIN categorias ON producto_venta.categorias = categorias.id
       INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
       INNER JOIN provincia ON producto_venta.provincia = provincia.id
       INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
       INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
       WHERE (producto_venta.nombre like '%$nombre_p_sugerencia%' OR producto_venta.descripcion like '%$descripcion_p_sugerencia%' OR producto_venta.precio like '%$precio_p_sugerencia%' OR
         ciudad.nombre like '%$ciudad_p_sugerencia%' OR provincia.nombre like '%$provincia_p_sugerencia%' OR
          subcategorias.nombre LIKE '%$subcategorias_p_sugerencia%' OR categorias.nombre LIKE '%$categorias_p_sugerencia%')
       AND producto_venta.estatus = 1  AND  producto_venta.idproducto != $idp ORDER BY idproducto DESC LIMIT $desde,$por_pagina ");
       $result_lista= mysqli_num_rows($query_lista);
       if ($result_lista > 0) {
             while ($data_lista=mysqli_fetch_array($query_lista)) {
                 $foto = 'img/uploads/'.$data_lista['foto'];
                 $idp = $data_lista['idproducto'];
                 $caracteres = strlen($data_lista['nombre_producto']);
                 $nombre_final =substr($data_lista['nombre_producto'], 0, 55);

       ?>
       <div class="contenedor_targeta">
         <div class="card" >
         <p class="indicador_categorias">  <?php echo $data_lista['categoria'] ?>-<small class="text-muted"><?php echo $data_lista['subcategorias'] ?></small></p>
           <div class="">
             <div id="carouselExampleControls<?php echo $idp ?>" class="carousel slide" data-ride="carousel" >
                 <div class="carousel-inner">
                   <?php $query_imagenes = mysqli_query($conection,"SELECT * FROM img_producto WHERE idp = '$idp' ORDER BY  id ASC ");
                        $result_imagenes= mysqli_num_rows($query_imagenes);

                   ?>
                   <?php if ($result_imagenes<=1): ?>
                     <div class="carousel-item active"  >
                         <a href="perfil?id=<?php echo $data_lista['id_usuario_hg'] ?>" target="_blanck" >
                         <img src="<?php echo $foto ?>" class="d-block w-100" alt="<?php echo $foto ?>"
                         >
                         </a>
                     </div>
                   <?php endif; ?>
                   <?php if ($result_imagenes>1): ?>
                     <?php
                     $img0= 0;
                     while ($data_lista_img=mysqli_fetch_array($query_imagenes)) {
                       $img0 =$img0+ 1;
                      ?>

                     <div class="carousel-item <?php  if ($img0 ==1) {echo "active"; } ?>" >
                         <a href="" target="_blanck">
                         <img src="/home/img/uploads/<?php echo $data_lista_img['img']; ?>" class="d-block w-100" alt="<?php echo $data_lista_img['img']; ?>">
                         </a>
                     </div>

                   <?php
                       }
                    ?>

                   <?php endif; ?>

                 </div>
                 <?php if ($result_imagenes<=1): ?>
                   <a class="carousel-control-prev visu-laterales" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next visu-laterales" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
                 <?php endif; ?>
                 <?php if ($result_imagenes>1): ?>
                   <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next" href="#carouselExampleControls<?php echo $idp ?>" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
                 <?php endif; ?>
             </div>
             <div class="contendor_estrellas_ka">
               <?php
               require "scripts/estrellas2.php";
                ?>

             </div>
           </div>
           <div class="contenedor_informacion_artiulo">
             <div class="card-body">
               <h5 class="precio_articulo"><?php echo number_format($data_lista['precio'],2) ?></h5>
               <h9 class="card-title"> <?php echo $nombre_final; ?> </h9>
               <button type="button" articulo="<?php  echo $idp ?>" class="btn btn-primary btn-ventana2323 boton_principal_articulo"  name="button">Ver Articulo</button>
             </div>
           </div>

         </div>
       </div>
       <?php
       }
     }
   ?>
  </div>
   <?php
       require "../scripts/modal_vista_general.php";

    ?>


       <div class="modal fade vista_comprar_articulo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
         <div class="modal-content" id="comprar_articulo">
           <div class="modal-header">
             <h5 class="modal-title" >Comprar  <?php echo $nombre_para_tarjeta; ?> </h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body" >
                 <form class="" action="" method="post" name="comprar_articulo_inicial" id="comprar_articulo_inicial" onsubmit="event.preventDefault(); sendData_comprar_articulo();" >
             <div class="row">
               <div class="card" >
                 <img class="card-img-top" src="img/uploads/<?php echo   $img_producto ?>" style="width: 200px;margin: 0 auto;" alt="Card image cap">
               </div>
             </div>
             <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Elije la cantidad</label>
                          <select class="form-control" name="cantidad_producto" id="cantodad_producto_articulo">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>10</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Contraseña</label>
                          <input type="password" class="form-control" name="password_user" id="exampleInputPassword1" placeholder="">
                          <input type="hidden" name="action" value="comprar_articulo_producto">
                          <input type="hidden" name="id_articulo" value="<?php echo $idp_ttt ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <button type="submit" class="btn btn-primary">Comprar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                      </div>

                    </div>
                    <div class="row">
                      <div class="notificacion_compra_articulo">

                      </div>

                    </div>


                  </div>
                  <div class="col-sm">
                    <div class="row">
                      <h4>Entrega del Producto</h4>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Deseas Ocupar <a href="#">Transporte Guibis</a> </label>
                        <input type="hidden" id="precio_viaje" name="precio_viaje" value="">
                        <input type="hidden" id="latitude_at" name="latitude_at" value="">
                        <input type="hidden" id="longitude_at" name="longitude_at" value="">
                        <select class="form-control" name="transporte_guibis" id="elegir_servicio_guibis">
                          <option>NO</option>
                          <option>SI</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="notificacion_tranasporte_producto">

                      </div>

                    </div>
                    <div class="row">
                      <div id="map" style="height:400px;width:100%">
                      </div>

                    </div>

                  </div>
                </div>
              </div>

             </form>
           </div>
         </div>
       </div>
     </div>
<?php if ($total_registro == 0): ?>
  <div class="contene_sin_resultados">
    <div  class="texto_sin_resultados">
      <p>No existe Sugerencias </p>
    </div>
    <div class="img_sin_resultados">
      <img src="img/reacciones/sin-contenido.png" alt="">
    </div>
  </div>
<?php endif; ?>


<div class="paginador">
 <ul>
   <?php
   if ($pagina != 1) {
     // code...

    ?>
   <li> <a href="?pagina=<?php echo 1; ?>">|<</a></li>

   <li> <a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
   <?php
 }

 ?>
<li> <a href=""><?php echo "$pagina"; ?> </a></li>
 <?php


   if ($pagina != $total_paginas) {
    ?>
   <li> <a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>

   <li> <a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
   <?php 	} ?>
 </ul>
</div>

  <?php
      require "scripts/footer.php";

   ?>

   <?php
   $latitud = '-1.2036275';
   $longitud = '-78.5969678';
    ?>
	<script src="main.js"></script>
  <script type="text/javascript" src="jquery/jquery.min.js"></script>
  <script type="text/javascript" src="jquery/comprar_un_producto.js"></script>
  <script type="text/javascript" src="jquery_preguntas/preguntas.js"></script>
  <script type="text/javascript" src="jquery_producto/producto.js"></script>
  <script type="text/javascript" src="jquery_comprar/calculo_transporte.js"></script>
  <script src="jquery/simplyCountdown.min.js"></script>
  <script type="text/javascript" src="jquery/home.js"></script>
  <script type="text/javascript" src="jquery_producto/estrellas.js"></script>
  <script type="text/javascript" src="jquery_producto/mostrar_estrellas.js"></script>
  <script type="text/javascript" src="jquery_producto/preguntas.js"></script>
  <script src="jquery_producto/generar_codigos.js"></script>
  <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <script src="/java/vista_articulo.js"></script>
  <script src="java/comprar_articulo.js"></script>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
crossorigin=""></script>

<script type="text/javascript">
let myMap = L.map('myMap').setView([<?=$latitud?>,<?=$longitud?>], 13)

L.tileLayer(`https://{s}.tile.osm.org/{z}/{x}/{y}.png`, {
maxZoom: 18,
}).addTo(myMap);
myMap.panTo(new L.LatLng(<?=$latitud?>,<?=$longitud?> ))
L.marker([<?=$latitud?>,<?=$longitud?>]).addTo(myMap)

</script>

  <script type="text/javascript" src="jquery_producto/video.js"></script>
    <script>
  		var reproductor = videojs('fm-video', {
  			fluid: true
  		});
  	</script>


</body>
</html>
<?php
ob_end_flush();
?>
