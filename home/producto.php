<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }



        $producto = $_GET['codigo'];


                $query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $producto");
                $data_producto = mysqli_fetch_array($query_producto);
                $img_producto =  $data_producto['foto'];
                $url_upload_img =  $data_producto['url_upload_img'];


         $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

         mysqli_query($conection,"SET lc_time_names = 'es_ES'");
         $query_producto = mysqli_query($conection, "SELECT
           producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,usuarios.longitud as 'longitud_user_producto',usuarios.latitud as 'latitud_user_producto',
           producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,producto_venta.id_usuario,producto_venta.pais,
           usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,
             DATE_FORMAT(producto_venta.fecha_producto, '%W  %d de %b %Y %h:%m:%s') as 'fecha_producto',producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
            producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,categorias.id as 'number_categorias',
            producto_venta.cantidad_boletos,usuarios.id as 'id_user',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
            usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',provincia.nombre as 'provincia',ciudad.nombre as 'ciudad',
            subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias',usuarios.mi_leben,producto_venta.ficha_tecnica,producto_venta.video_explicativo,producto_venta.id_producto_sugerido,
            producto_venta.incluye_envio,producto_venta.utilizar_transporte_guibis,producto_venta.url_upload_img,
            usuarios.direccion as 'direccion_empresa',usuarios.celular as 'celular_empresa',usuarios.email as 'email_empresa',usuarios.razon_social as 'razon_social_empresa',
            usuarios.fecha_creacion as 'fecha_creacion_empresa',usuarios.id_e as 'id_e_empresa',producto_venta.url_video,producto_venta.meses_suscripcion,
            producto_venta.cantidad
           FROM producto_venta
          INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
          INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
          INNER JOIN categorias ON producto_venta.categorias = categorias.id
          INNER JOIN provincia ON producto_venta.provincia = provincia.id
          INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
             WHERE  producto_venta.estatus = 1 AND producto_venta.idproducto = '$producto'   ");

             $data_producto=mysqli_fetch_array($query_producto);

             $url_upload_img = $data_producto['url_upload_img'];
             $id_e_empresa = $data_producto['id_e_empresa'];

             $direccion_empresa = $data_producto['direccion_empresa'];
             $celular_empresa = $data_producto['celular_empresa'];
             $email_empresa = $data_producto['email_empresa'];

             $id_empresa = $data_producto['id_user'];
             $razon_social_empresa = $data_producto['razon_social_empresa'];
             $fecha_creacion_empresa = $data_producto['fecha_creacion_empresa'];

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





<!DOCTYPE html>
<html lang="es">
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


          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/boton_pagos.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas2.css">

          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/preguntas_respuestas.css">
          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estilos_paginador.css">

          <link rel="stylesheet" href=" https://guibis.com/api/estilos/payguibis.css">
          <link rel="stylesheet" href="/css/pie_pagina.css">
          <link rel="stylesheet" href="/css/front.css">
          <link rel="stylesheet" href="/css/index.css?v=2">
          <link rel="stylesheet" href="/css/producto.css">

          <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">



<body>

 <?php
      if ($_SESSION['rol'] == 'cuenta_empresa') {
   require 'scripts/loader.php';
   require 'scripts/iconos.php';

 }


 if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
   require 'scripts_usuario_venta/loader.php';
   require 'scripts_usuario_venta/iconos.php';

 }

          ?>
          <div class="pcoded-content">
<br>




                        <main >
                          <div class="card">
                              <div class="card-block">
                                     <div class="contenedor_general_informacion_at">
                                       <div class="row">
                                         <div class="col">
                                               <h3><?php echo $data_producto['nombre'] ?></h3>

                                         </div>

                                       </div>
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
                                                         <a href="producto?codigo=<?php echo $data_producto['idproducto'] ?>" >
                                                         <img src="<?php echo $url_upload_img?>/home/img/uploads/<?php echo $img_producto  ?>" class="d-block w-100 img-fluid" alt=""
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
                                                         <a href="producto?codigo=<?php echo $data_producto['idproducto'] ?>" >
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

                                               <a href="code_user?code=<?php echo $id_e_empresa?>">Visita toda la tienda</a>
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
                                                 <button  id="payguibis" class="custom-button boton_ingresar_producto">Pay Guibis</button>
                                             </div>
                                           </div>
                                         </div>

                                         <?php
                                          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
                                          ?>


                                         <div class="modal fade" id="modal_inicio_sesion_producto" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                                           <div class="modal-dialog modal-dialog-centered">
                                             <div class="modal-content  ">
                                               <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                                                 <h5 class="modal-title" id="proveedorModalLabel">Ingresa a nuestros sistemas</h5>
                                               </div>
                                               <div class="modal-body text-center">
                                                 <h2 class="mb-4">Elige tu tipo de cuenta</h2>
                                                 <div class="row">
                                                   <div class="col _elegir_cuenta _cuenta_empresa">
                                                     <a href="<?php echo $url ?>/login" class="d-block p-4 text-decoration-none">
                                                       <i class="fa fa-building fa-3x" aria-hidden="true"></i>
                                                       <h3 class="mt-3">Cuenta Empresa</h3>
                                                       <p>Crea tu tienda, Factura Electrónicamente y unete a la red mas grande del país.</p>
                                                     </a>
                                                   </div>
                                                   <div class="col _elegir_cuenta _cuenta_cliente">
                                                     <a href="usuario/<?php echo $url ?>/login" class="d-block p-4 text-decoration-none">
                                                       <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                                                       <h3 class="mt-3">Cuenta Cliente</h3>
                                                       <p>Compra en cualquier empresa, busca tus facturas y muchos mas servicios que esta en la red de guibis.com </p>
                                                     </a>
                                                   </div>
                                                 </div>
                                               </div>

                                               <style media="screen">
                                               .modal-body a {
                                                 color: #333; /* Cambia esto al color deseado */
                                                 transition: transform 0.2s ease-in-out;
                                                 }

                                                 .modal-body a:hover {
                                                 transform: scale(1.05);
                                                 color: #0056b3; /* Cambia esto al color que desees para el hover */
                                                 }

                                               </style>

                                               <div class="modal-footer">
                                                 <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
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
                                               <p> <a class="" href="code_user?code=<?php echo $id_e_empresa?>&empresa=<?php echo $nombre_tienda ?>">Vendido por <?php echo $nombre_tienda ?></a> </p>
                                               <p> <a class="" href="code_user?code=<?php echo $id_e_empresa?>&empresa=<?php echo $nombre_tienda ?>">Empaquetado por <?php echo $nombre_tienda ?></a> </p>
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
                                                $whatsapp = '<a target="_blank" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&text=Hola!&nbsp;el&nbsp;producto&nbsp;Es&nbsp;https://guibis.com/producto.php?codigo='.$data_producto['idproducto'].'"><img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt=""></a>';
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

                                           <style media="screen">
                                             .botones_compartit_afuer{
                                               text-align: center;
                                             }
                                           </style>

                                           <div class="botones_compartit_afuer">
                                             <button class="btn btn-primary" id="botonCompartir">
                                                 <i class="fa fa-share-alt"></i> Compartir Producto
                                             </button>

                                           </div>


                                         </div>
                                       </div>

                                     </div>





                                                                     <?php if ($id_empresa == $iduser): ?>
                                                                       <div class="container conte_heidi_agente_vendedor mt-5">
                                                                           <div class="card">
                                                                             <div class="card-body">
                                                                               <h2 class="card-title">Activar Este Producto para Agentes Vendedores</h2>
                                                                               <p class="card-text">En este campo puedes accionar el porcentaje de venta que tenga tus agentes vendedores sobre este producto. Recuerda que una vez hecha esta acción se bloquearán ciertas acciones.</p>
                                                                               <form action="" method="post" name="porcentaje_ini" id="porcentaje_ini" onsubmit="event.preventDefault(); sendData_porcentaje_ini();">
                                                                                 <div class="mb-3">
                                                                                   <label for="porcentaje_hotmart" class="form-label">Porcentaje de Venta:</label>
                                                                                   <select class="form-control" name="porcentaje_hotmart" id="porcentaje_hotmart">
                                                                                     <option value="5">5%</option>
                                                                                     <option value="10">10%</option>
                                                                                     <option value="15">15%</option>
                                                                                     <option value="20">20%</option>
                                                                                     <option value="25">25%</option>
                                                                                     <option value="30">30%</option>
                                                                                     <option value="35">35%</option>
                                                                                   </select>
                                                                                 </div>
                                                                                 <button type="submit" class="btn btn-primary">Enviar a Vendedores</button>
                                                                                 <input type="hidden" name="action" value="insertar_porcentaje">
                                                                                 <input type="hidden" name="idproducto" value="<?php echo $producto ?>">
                                                                               </form>
                                                                             </div>
                                                                           </div>
                                                                           <div class="notificacion_ini_hotmart"  >
                                                                             <!-- Las notificaciones aparecerán aquí -->
                                                                           </div>
                                                                         </div>

                                                                         <style media="screen">
                                                                             .conte_heidi_agente_vendedor {
                                                                                 background: linear-gradient(to right, #6dd5ed, #2193b0); /* Degradado de azul claro a azul oscuro */
                                                                                 backdrop-filter: blur(5px); /* Efecto de desenfoque detrás de la tarjeta */
                                                                                 border-radius: 4px; /* Bordes redondeados para el contenedor */
                                                                                 padding: 15px; /* Espaciado interno para el contenedor */
                                                                               }

                                                                               .conte_heidi_agente_vendedor .card {
                                                                                 background: rgba(255, 255, 255, 0.9); /* Fondo semitransparente para la tarjeta */
                                                                               }

                                                                               .conte_heidi_agente_vendedor .card-title {
                                                                                 color: #007bff; /* Color del título de la tarjeta */
                                                                               }

                                                                               .conte_heidi_agente_vendedor .card-text {
                                                                                 color: #343a40; /* Color del texto de la tarjeta */
                                                                               }

                                                                               .conte_heidi_agente_vendedor .btn-primary {
                                                                                 background-color: #28a745; /* Color de fondo para el botón */
                                                                                 border-color: #28a745; /* Color del borde para el botón */
                                                                               }

                                                                         </style>





                                                                     <?php endif; ?>









                                                                          <style media="screen">
                                                                            .mmaite_video{
                                                                              text-align: center;
                                                                            }
                                                                            .mmaite_video video{
                                                                              width: 95%;
                                                                            }
                                                                          </style>



                                                                        <?php if (!empty($data_producto['video_explicativo'])): ?>
                                                                          <div class="titulo_producto_sugerido">
                                                                            <h4>Video Explicativo</h4>
                                                                          </div>
                                                                          <div class="mmaite_video">
                                                                            <video  autoplay  controls>
                                                                             <source src="<?php echo $data_producto['url_video'] ?>/home/img/videos/<?php echo $data_producto['video_explicativo'] ?>" type="video/mp4">
                                                                             </video>
                                                                          </div>




                                                                        <?php endif; ?>







                                     <?php if (!empty($data_producto['longitud_user_producto'])): ?>
                                           <?php
                                           $longitud = $data_producto['longitud_user_producto'];
                                           $latitud  = $data_producto['latitud_user_producto'];

                                            ?>


                                          <?php endif; ?>
                                          <div class="resultado_existencia_imagen">

                                          </div>
                                          <br>





                                          <br>

                                                         <div class="container mt-4 tabla_secunadaria_compara_dtos">
                                              <div class="table-responsive">
                                                  <table class="table">
                                                      <thead class="bg-primary text-white">
                                                          <tr>
                                                              <th scope="col">Parámetros</th>
                                                              <th scope="col">Imagen</th>
                                                              <th scope="col">Producto</th>
                                                              <th scope="col">Descripción</th>
                                                              <th scope="col">Precio</th>
                                                              <th scope="col">Garantía</th>
                                                              <th scope="col">Incluye Envío</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        <?php
                                                        $query_lista = mysqli_query($conection, "SELECT usuarios.nombre_empresa,usuarios.nombres as 'nombre_usuario',producto_venta.garantia,producto_venta.ficha_tecnica,producto_venta.video_explicativo,
                                                          producto_venta.foto,producto_venta.nombre as 'nombre_producto',producto_venta.precio,producto_venta.idproducto,producto_venta.incluye_envio,usuarios.id as 'id_tienda',producto_venta.url_upload_img,
                                                              producto_venta.descripcion
                                                           FROM producto_venta
                                                          INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
                                                          INNER JOIN categorias ON categorias.id = producto_venta.categorias
                                                        WHERE producto_venta.estatus = 1 AND categorias.id ='$id_categorias_number'  ORDER BY producto_venta.idproducto DESC LIMIT 1,8 " );
                                                         while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                           $nombre_empresa = $data_lista['nombre_empresa'];
                                                           $nombre_usuario = $data_lista['nombre_usuario'];
                                                           $url_upload_img = $data_lista['url_upload_img'];
                                                           if ($nombre_empresa == '') {
                                                             $nombre_tienda = $nombre_usuario;
                                                           }else {
                                                             $nombre_tienda = $nombre_empresa;
                                                           }
                                                                 ?>
                                                          <tr>
                                                              <th scope="row"> <a target="_blank" href="perfil?id=<?php echo $data_lista['id_tienda'] ?>"><?php echo $nombre_tienda ?></a> </ </th>
                                                              <td> <img src="<?php echo $url_upload_img ?>/home/img/uploads/<?php echo $data_lista['foto'] ?>" width="100px" alt=""> </td>
                                                              <td> <a target="_blank" href="producto?codigo=<?php echo $data_lista['idproducto'] ?>"> <?php echo $data_lista['nombre_producto'] ?> </a> </td>
                                                              <td> <?php echo $data_lista['descripcion'] ?> </td>
                                                              <td>$<?php echo number_format($data_lista['precio'],2) ?></td>
                                                              <td><?php echo $data_lista['garantia'] ?> TIENE GARANTIA</td>
                                                              <td class="ficha_tecnica_at">
                                                              <?php echo $data_lista['incluye_envio'] ?> INCLUYE ENVIO
                                                               </td>

                                                          </tr>
                                                          <?php
                                                          }
                                                      ?>
                                                          <!-- End PHP Loop -->
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>

                                          <style media="screen">
                                          .tabla_secunadaria_compara_dtos .table {
                                            border-collapse: separate;
                                            border-spacing: 0 15px;
                                          }

                                          .tabla_secunadaria_compara_dtos .table th, .table td {
                                            border: 1px solid #ddd;
                                            padding: 8px;
                                          }

                                          .tabla_secunadaria_compara_dtos .table th {
                                            background-color: #263238;
                                            font-weight: bold;
                                          }

                                          .tabla_secunadaria_compara_dtos .table td {
                                            background-color: #fff;
                                          }

                                          /* Estilos para imágenes y videos */
                                          .tabla_secunadaria_compara_dtos .table img {
                                            width: 100px; /* Ajustar según sea necesario */
                                            height: auto;
                                            border-radius: 5px;
                                          }

                                          /* Estilos para enlaces */
                                          .tabla_secunadaria_compara_dtos .table a {
                                            text-decoration: none;
                                            color: #007bff;
                                          }

                                          .tabla_secunadaria_compara_dtos .table a:hover {
                                            color: #0056b3;
                                          }

                                          .tabla_secunadaria_compara_dtos .table th, .tabla_secunadaria_compara_dtos .table td {
                                            text-align: center; /* Alineación horizontal */
                                            vertical-align: middle; /* Alineación vertical */
                                            border: 1px solid #ddd;
                                            padding: 8px;
                                          }

                                          /* Estilos para imágenes y videos */
                                          .tabla_secunadaria_compara_dtos .table img {
                                            display: block; /* Hace que la imagen sea un bloque para centrarla */
                                            margin: 0 auto; /* Centra la imagen horizontalmente */
                                            width: 100px; /* Ajustar según sea necesario */
                                            height: auto;
                                            border-radius: 5px;
                                          }



                                          </style>










                                        <h3 class="text-center fs-1 mb-4">Preguntas y Respuestas</h3>
                     <div class="container">
                     <div class="contenedor-preguntas">
                     <?php
                     $query_lista = mysqli_query($conection,"SELECT *
                     FROM preguntas WHERE id_producto = '$idp' ORDER BY fecha ASC  ");
                     $result_lista = mysqli_num_rows($query_lista);
                     if ($result_lista > 0) {
                     while ($data_lista = mysqli_fetch_array($query_lista)) {

                     $id_pregunta = $data_lista['id_pregunta'];
                     //codigo para sacar informacion del cliente

                     $query_informacion_pregunta = mysqli_query($conection,"SELECT *
                     FROM clientes WHERE id = '$id_pregunta'");

                     $data_cliente_pregunta = mysqli_fetch_array($query_informacion_pregunta);
                     $nombres_pregunta = $data_cliente_pregunta['nombres'];

                     $fecha_pregunta = $data_lista['fecha'];
                     $pregunta = $data_lista['pregunta'];
                     $id_pregunta = $data_lista['id'];

                     ?>
                     <div class="row mb-3 conte_pegunta_gk">
                     <div class="col-8">
                     <div class="card border-0">
                     <div class="card-body shadow-sm" style="border-radius: 15px; background-color: #f8d7da;">
                     <h5 class="card-title"><?php echo $nombres_pregunta; ?> <small class="text-muted"><?php echo $nombres_pregunta; ?> comenta el <?php echo $fecha_pregunta; ?></small></h5>
                     <p class="card-text"><?php echo $pregunta; ?></p>
                     </div>
                     </div>
                     </div>
                     <div class="col-4"></div>
                     </div>
                     <?php
                     $query_responde = mysqli_query($conection,"SELECT preguntas.fecha_respuesta,preguntas.respuesta,preguntas.id_pregunta,usuario_responde.nombres as 'nombres_responde',usuario_responde.apellidos as 'apellidos_responde',preguntas.fecha,preguntas.id FROM `preguntas`

                     INNER JOIN usuarios AS usuario_responde ON usuario_responde.id=preguntas.id_responde WHERE preguntas.id = '$id_pregunta'");
                     $data_respuesta = mysqli_fetch_array($query_responde);
                     $respuesta = $data_respuesta['respuesta'];
                     if ($respuesta == '') {

                     $nombres_responde = $data_respuesta['nombres_responde'];
                     $respuesta_interna = 'Ninguna';

                     echo '
                     <div class="row mb-3">
                     <div class="col-4"></div>
                     <div class="col-8">
                     <div class="card border-0">
                     <div class="card-body shadow-sm" style="border-radius: 15px; background-color: #d4edda;">
                     <h5 class="card-title">'.$nombres_responde.' <small class="text-muted">'.$nombres_responde.' Todavia no ha respondido a esta pregunta</small></h5>
                     <p class="card-text">Ninguna</p>
                     </div>
                     </div>
                     </div>
                     </div>

                     ';
                     }
                     if ($respuesta != '') {
                     $nombres_responde = $data_respuesta['nombres_responde'];
                     $apellidos_responde = $data_respuesta['apellidos_responde'];
                     $fecha_respuesta = $data_respuesta['fecha_respuesta'];
                     $respuesta = $data_respuesta['respuesta'];
                     ?>


                     <div class="row mb-3 conte_respuesta_gk">
                     <div class="col-4"></div>
                     <div class="col-8">
                     <div class="card border-0">
                     <div class="card-body shadow-sm" style="border-radius: 15px; background-color: #d4edda;">
                     <h5 class="card-title"><?php echo $nombres_responde; ?> <small class="text-muted"><?php echo $nombres_responde; ?> responde el <?php echo $fecha_respuesta; ?></small></h5>
                     <p class="card-text"><?php echo $respuesta; ?></p>
                     </div>
                     </div>
                     </div>
                     </div>


                     <?php
                     }
                     }
                     }
                     ?>
                     <div class="code_respuesta" id="code_respuesta">
                     <div class="notificacion_pregunta text-center">
                     <!-- Aquí puedes agregar notificaciones si las necesitas -->
                     </div>
                     </div>






                     </div>
                     </div>


                     <style media="screen">
                     .conte_pegunta_gk, .conte_respuesta_gk {
                     margin-bottom: 0px; /* Ajusta este valor según tus necesidades */
                     padding: 0px; /* Ajusta este valor según tus necesidades */
                     }
                     .conte_pegunta_gk .card {
                     margin-bottom: 0 !important;

                     }
                     .conte_respuesta_gk .card {
                     margin-bottom: 0 !important;

                     }

                     </style>

                              </div>

                          </div>

                        </main>
                        <div id="myMap" style="height:300px"></div>
                        <div style="width: 80%;margin: 0 auto;" class="">
                           <canvas id="myChart" width="50" height="25"></canvas>
                        </div>
          </div>

            </div>
        </div>
    </div>


    <div class="modal fade vista_comprar_articulo" tabindex="-1" aria-labelledby="modalCompraLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">

            <h5 class="modal-title" id="modalCompraLabel">Comprar <?php echo $data_producto['nombre']; ?> <img src="/img/guibis.png" alt="guibis.com Logo" class="float-start" style="height: 30px;"></h5>
          </div>
          <div class="modal-body">
            <form id="comprar_articulo_inicial" method="post" onsubmit="event.preventDefault(); sendData_comprar_articulo();">
              <div class="row mb-3">
                <div class="col-md-6">
                  <h6 class="mb-2" style="font-size: 1.25rem; font-weight: bold; font-style: italic;">Información del Comprador</h6>
                  <p><strong>Nombre:</strong><?php echo $nombres ?> <?php echo $apellidos ?></p>
                  <p><strong>Email:</strong> <?php echo $email_user ?></p>
                  <p><strong>Código:</strong> <?php echo $iduser ?></p>
                  <p><strong>Dirección:</strong> <?php echo $direccion ?></p>
                  <p><strong>Teléfono:</strong> <?php echo $telefono_user ?></p>
                  <p><strong>Celular:</strong> <?php echo $celular_user ?></p>
                  <p><strong>Razón Social:</strong> <?php echo $razon_social ?></p>
                  <p><strong>Fecha de Registro:</strong> <?php echo $fecha ?></p>
                </div>


                <div class="col-md-6">
                  <h6 class="mb-2" style="font-size: 1.25rem; font-weight: bold; font-style: italic;">Información del Vendedor</h6>
                  <p><strong>Nombre:</strong><?php echo $nombre_tienda ?></p>
                  <p><strong>Email:</strong> <?php echo $email_empresa ?></p>
                  <p><strong>Código:</strong> <?php echo $id_empresa ?></p>
                  <p><strong>Dirección:</strong> <?php echo $direccion_empresa ?></p>
                  <p><strong>Teléfono:</strong> <?php echo $telefono_user ?></p>
                  <p><strong>Celular:</strong> <?php echo $celular_empresa ?></p>
                  <p><strong>Razón Social:</strong> <?php echo $razon_social_empresa ?></p>
                  <p><strong>Fecha de Registro:</strong> <?php echo $fecha_creacion_empresa ?></p>
                  <!-- Más campos relacionados con el vendedor si es necesario -->
                </div>
              </div>
              <div class="text-center mb-4">

                <div class="imagener_contenededor_general_at">
                  <div id="carouselExampleControls2<?php echo $idp ?>" class="carousel slide" data-ride="carousel" >
                      <div class="carousel-inner">
                        <?php $query_imagenes = mysqli_query($conection,"SELECT * FROM img_producto WHERE idp = '$idp'");
                             $result_imagenes= mysqli_num_rows($query_imagenes);

                        ?>
                        <?php if ($result_imagenes<=1): ?>
                          <div class="carousel-item active"  >
                              <a href="producto?codigo=<?php echo $data_producto['idproducto'] ?>" >
                              <img src="<?php echo $url_upload_img?>/home/img/uploads/<?php echo $img_producto  ?>" class="d-block w-100 img-fluid" alt=""
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
                              <a href="producto?codigo=<?php echo $data_producto['idproducto'] ?>" >
                              <img src="<?php echo $data_lista_img['url']; ?>/home/img/uploads/<?php echo $data_lista_img['img']; ?>" class="d-block w-100 img-fluid" alt="<?php echo $data_lista_img['img']; ?>">
                              </a>
                          </div>

                        <?php
                            }
                         ?>

                        <?php endif; ?>

                      </div>
                      <?php if ($result_imagenes<=1): ?>
                        <a class="carousel-control-prev visu-laterales" href="#carouselExampleControls2<?php echo $idp ?>" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next visu-laterales" href="#carouselExampleControls2<?php echo $idp ?>" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      <?php endif; ?>
                      <?php if ($result_imagenes>1): ?>
                        <a class="carousel-control-prev barra_lateral_principal" href="#carouselExampleControls2<?php echo $idp ?>" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next barra_lateral_principal" href="#carouselExampleControls2<?php echo $idp ?>" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      <?php endif; ?>
                  </div>
                </div>


              </div>
              <div class="container">
                <!-- Estilos para la cantidad y contraseña -->
                <div class="mb-3">
                  <label for="cantidadProducto" class="form-label">Elije la cantidad</label>
                  <div class="input-group">
                    <span class="input-group-text" id="basic-addon1" style="background-color: #6c757d; color: white;"><i class="fas fa-sort-amount-up"></i></span>
                    <select class="form-control" name="cantidad_producto" id="cantidadProducto">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>10</option>
                    </select>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="passwordUser" class="form-label">Contraseña</label>
                  <div class="input-group">
                    <span class="input-group-text" id="basic-addon2" style="background-color: #6c757d; color: white;"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password_user" id="passwordUser" placeholder="Tu contraseña">
                  </div>
                </div>
                <!-- ... -->
              </div>

              <div class="modal-footer">
                <input type="hidden" name="action" value="comprar_articulo_producto">
                <input type="hidden" id="precio_viaje" name="precio_viaje" value="">
                <input type="hidden" id="latitude_at" name="latitude_at" value="">
                <input type="hidden" id="longitude_at" name="longitude_at" value="">
                <input type="hidden" name="id_articulo" value="<?php echo $producto ?>">
                <button type="submit" class="btn btn-primary" style="background-color: #263238;">Comprar <img src="https://guibis.com/home/img/reacciones/guibis.png" style="height: 20px;"  alt=""> </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
              </div>
              <div class="notificacion_compra_articulo">


              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

            <audio id="successSound" src="audio/compra_correcta.mp3" preload="auto"></audio>


    <?php
        require "../scripts/footer.php";

     ?>



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

    <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
<script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>



    <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
    <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
    <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
    <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="area_facturacion/busqueda_secuencia.js"></script>
     <script src="jquery_bancario/comprar_articulo.js"></script>

     <script src="hotmart/iniciar_hotmart.js"></script>
     <script src="SEO/estadisticas_producto.js"></script>

    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
      integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
      crossorigin=""></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.esm.min.js"></script>

      <script type="text/javascript">
      let myMap = L.map('myMap').setView([51.505, -0.09], 13)

      L.tileLayer(`https://{s}.tile.osm.org/{z}/{x}/{y}.png`, {
      maxZoom: 18,
      }).addTo(myMap);
      myMap.panTo(new L.LatLng(-1.2484,-78.6133 ))
      L.marker([-1.2484, -78.6133]).addTo(myMap)

      </script>
      <script type="text/javascript">

        (function() {
          $(function() {
            $('#payguibis').on('click', function() {
              $('.vista_comprar_articulo').modal();
            });
          });
        })();

      </script>

      <script type="text/javascript">
      $(document).on('click', '#botonCompartir', function() {
      var url = 'https://guibis.com/producto?codigo=<?php echo $producto ?>&name=<?php echo $data_producto['nombre'] ?>'; // Reemplaza con la URL dinámica si es necesario
      navigator.clipboard.writeText(url).then(function() {
          alert("URL copiada al portapapeles: " + url);
      }).catch(function(error) {
          alert("Error al copiar la URL: ", error);
      });
  });
      </script>


      <script type="text/javascript">
      $(document).ready(function(){
        var producto = <?php echo $producto ?>;
        var action = 'estadisticas';
          $.ajax({
            url:'SEO/estadisticas_producto.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                  var info = JSON.parse(response);
                  var fecha_analisis = [];
                  var cantidad_vistas = [];
                  for (var i = 0; i < info.visitas.length; i++) {
                    cantidad_vistas.push(info.visitas[i][0]);
                    fecha_analisis.push(info.visitas[i][2]);
                  }
                  const ctx = document.getElementById('myChart');
                  const myChart = new Chart(ctx, {
                      type: 'bar',
                      data: {
                          labels: fecha_analisis,
                          datasets: [{
                              label: 'Cantidad de Visistas por Fecha',
                              data: cantidad_vistas,
                              backgroundColor: [
                                  'rgba(255, 99, 132, 0.2)',
                                  'rgba(54, 162, 235, 0.2)',
                                  'rgba(255, 206, 86, 0.2)',
                                  'rgba(75, 192, 192, 0.2)',
                                  'rgba(153, 102, 255, 0.2)',
                                  'rgba(255, 159, 64, 0.2)'
                              ],
                              borderColor: [
                                  'rgba(255, 99, 132, 1)',
                                  'rgba(54, 162, 235, 1)',
                                  'rgba(255, 206, 86, 1)',
                                  'rgba(75, 192, 192, 1)',
                                  'rgba(153, 102, 255, 1)',
                                  'rgba(255, 159, 64, 1)'
                              ],
                              borderWidth: 1
                          }]
                      },
                      options: {
                          scales: {
                              y: {
                                  beginAtZero: true
                              }
                          }
                      }
                  });



               }

             },
             error:function(error){
               console.log(error);
               }


             });


      });

      </script>


</body>

</html>
