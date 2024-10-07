<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }




  ?>





<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Productos</title>

        <meta charset="UTF-8">
      	<meta name="viewport" content="width=device-width, initial-scale=1.0">
      	<meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta property="og:locale" content="es_ES" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="" />
        <meta property="og:description" content="" />
        <meta property="og:image" content="https://www.guibis.com/home/img/reacciones/guibis.pg">
        <meta property="og:url" content="https://www.guibis.com/producto" />
        <title class="title">Home</title>
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin="" />
          <link rel="stylesheet" href="https://guibis.com/estilos/targeta_producto.css?v=11">
          <link rel="stylesheet" href="https://guibis.com/estilos/index.css?v=6">
          <link rel="stylesheet" href="https://guibis.com/estiloshome/boton_pagos.css">
          <link rel="stylesheet" href="https://guibis.com/estilos/targeta_producto.css?v=9">
          <link rel="stylesheet" href="https://guibis.com/home/estilos-importante/comprar-articulo.css?v=2">
          <link rel="stylesheet" href="https://guibis.com/home/estilos-importante/targeta_principal_articulo.css?v=14">
          <link rel="stylesheet" href="https://guibis.com/home/estilos-importante/video-js.css?v=1">
          <link rel="stylesheet" href="https://guibis.com/home/estilos-importante/video.css?v=1">
          <link rel="stylesheet" href="https://guibis.com/home/estilos-importante/parametros-descriptivos.css?v=4">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/boton_pagos.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas2.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/cuenta_bancaria.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/preguntas_respuestas.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estilos_paginador.css">


    </head>

    <body>
    <input type="hidden" name="producto" value="<?php echo "$idp"; ?>" id="producto">


<?php
require 'scripts/loader.php';

             require 'scripts/iconos.php';
 ?>



                      <div class="pcoded-main-container">

              <div class="pcoded-content">
                <br><br><br>



                                                  <div class="card">
                                                      <div class="card-block">
                                                            <?php

                                                         $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro   FROM producto_venta
                                                         INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
                                                         INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
                                                         INNER JOIN categorias ON producto_venta.categorias = categorias.id
                                                            WHERE  producto_venta.estatus = 1");
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




                                                            mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                            $query_producto = mysqli_query($conection, "SELECT
                                                              producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,usuarios.longitud as 'longitud_user_producto',usuarios.latitud as 'latitud_user_producto',
                                                              producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,producto_venta.id_usuario,producto_venta.pais,producto_venta.enlace_web_demo,
                                                              usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,producto_venta.cat1sub44_enlace_descarga,producto_venta.cat_1_sub_44_timpo_licencia,producto_venta.cat1sub44_desarrolador,
                                                                DATE_FORMAT(producto_venta.fecha_producto, '%W  %d de %b %Y %h:%m:%s') as 'fecha_producto',producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
                                                               producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,categorias.id as 'number_categorias',
                                                               producto_venta.cantidad_boletos,usuarios.id as 'id_user',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
                                                               producto_venta.peso,usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',producto_venta.provincia as 'provincia',producto_venta.ciudad as 'ciudad',
                                                               subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias',usuarios.mi_leben,producto_venta.ficha_tecnica,producto_venta.video_explicativo,producto_venta.id_producto_sugerido
                                                               ,producto_venta.cargador_1,producto_venta.peso_1,producto_venta.marca_1,producto_venta.tamano_1,producto_venta.almacenamiento_1,producto_venta.autor_libro_2,producto_venta.enlace_digital_2,
                                                               producto_venta.introduccion_libro_2,producto_venta.talla_3,producto_venta.color_3,producto_venta.peso_3,producto_venta.material_4,producto_venta.medidas_4,producto_venta.peso_4,producto_venta.material_5,
                                                               producto_venta.medidas5,producto_venta.posicionado_5,producto_venta.color_5,producto_venta.peso_5,producto_venta.material_6,producto_venta.medidas_6,producto_venta.marca_6,producto_venta.color_6,producto_venta.peso_6,producto_venta.perecederos_7,
                                                               producto_venta.expiracion_7,producto_venta.peso_7,producto_venta.enlace_9,producto_venta.introducion_9,producto_venta.incluye_envio,producto_venta.utilizar_transporte_guibis,producto_venta.url_upload_img
                                                              FROM producto_venta
                                                             INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
                                                             INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
                                                             INNER JOIN categorias ON producto_venta.categorias = categorias.id
                                                                WHERE  producto_venta.estatus = 1   ORDER BY producto_venta.idproducto DESC  LIMIT  $desde,$por_pagina ");

                                                                $result_lista_producto= mysqli_num_rows($query_producto);
                                                              if ($result_lista_producto > 0) {
                                                                    while ($data_producto=mysqli_fetch_array($query_producto)) {

                                                                $idp = $data_producto['idproducto'];
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
                                                                                 <a href="producto?idp=<?php echo $data_producto['idproducto'] ?>" >
                                                                                 <img src="<?php echo $data_producto['url_upload_img'] ?>/home/img/uploads/<?php echo $img_producto  ?>" class="d-block w-100 img-fluid" alt=""
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
                                                                                 <a href="producto?idp=<?php echo $data_producto['idproducto'] ?>" >
                                                                                 <img src="<?php echo $data_lista_img['url']; ?>/home/img/uploads/<?php echo $data_lista_img['img']; ?>" class="d-block w-100 img-fluid" alt="<?php echo $data_lista_img['img']; ?>">
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


                                                                 </div>
                                                                 <div class="col acciones_producttos_at">
                                                                   <div class="row precio_3">
                                                                     <div class="col">
                                                                       <p class="precio_articulo"><sup>$</sup> <?php echo $ifra_entera?><sup class="dedima_precio"><?php echo $cigra_decimal ?></sup> </p>
                                                                     </div>

                                                                   </div>
                                                                   <br>
                                                                   <div class="row">
                                                                     <div class="col">
                                                                       <?php
                                                                       $cuenta_digital = $data_producto['mi_leben'];
                                                                       if ($cuenta_digital == 'Activa') {
                                                                         $estado_bancario = '<button type="button" class="btn btn-success btn-lg btn-block">Transacción Segura</button>';
                                                                         // code...
                                                                       }else {
                                                                         $estado_bancario = '<button type="button" class="btn btn-danger btn-lg btn-block">Transacción No Segura</button>';
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
                                                                        $instagram = '<a target="_blank"  href="'.$instagram.'"> <img src="https://guibis.com/home/img/reacciones/instagram.png" alt=""></a>';
                                                                        // code...
                                                                      }
                                                                      if ($whatsapp != '') {
                                                                        $whatsapp = '<a target="_blank" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&text=Hola!&nbsp;el&nbsp;producto&nbsp;Es&nbsp;https://guibis.com/producto.php?idp='.$data_producto['idproducto'].'"><img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt=""></a>';
                                                                        // code...
                                                                      }
                                                                      if ($facebook != '') {
                                                                        $facebook = '<a target="_blank"  href="'.$facebook.'"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt=""></a>';
                                                                        // code...
                                                                      }
                                                                      if ($tiktok != '') {
                                                                        $tiktok = '<a target="_blank"  href="https://www.'.$tiktok.'"> <img src="https://guibis.com/home/img/reacciones/tiktok.png" alt=""></a>';
                                                                        // code...
                                                                      }
                                                                       ?>
                                                                       <?php echo $instagram ?>
                                                                       <?php echo $whatsapp ?>
                                                                       <?php echo $facebook ?>
                                                                       <?php echo $tiktok ?>
                                                                     </div>
                                                                   </div>


                                                                 </div>
                                                               </div>

                                                             </div>


                                                             <?php
                                                             }
                                                             }
                                                         ?>

                                                      </div>


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
                                                          for ($i=1; $i <= $total_paginas; $i++) {
                                                            if ($i == $pagina ) {
                                                              echo '<li class="paginaactual">'.$i.'</li>';
                                                            }else {
                                                              echo '<li> <a href="?pagina='.$i.'">'.$i.'</a></li>';
                                                            }
                                                          }
                                                          if ($pagina != $total_paginas) {
                                                           ?>
                                                          <li> <a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                                                          <li> <a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
                                                          <?php 	} ?>
                                                        </ul>
                                                      </div>

                                                  </div>

                      <div id="styleSelector"></div>

              </div>


                </div>
            </div>
        </div>








        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script type="text/javascript" src="files/bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>



        <script type="text/javascript" src="files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

        <script type="text/javascript" src="files/bower_components/chart.js/dist/Chart.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/amcharts.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/serial.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/light.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/custom-dashboard.min.js"></script>
        <script src="files/assets/js/pcoded.min.js"></script>
        <script src="files/assets/js/horizontal-layout.min.js"></script>
        <script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="files/assets/js/script.js"></script>

        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>

        <script src="jquery_empresa/proveedor.js"></script>
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>

        <script type="text/javascript" src="jquery_producto/estrellas.js"></script>
        <script type="text/javascript" src="jquery_producto/mostrar_estrellas.js"></script>

        <script src="java/cuenta.js"></script>
          <script src="java2/perfil.js"></script>
       <script type="text/javascript" src="jquery_chat/mensajes.js"></script>




    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
