<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }
       $iduser= $_SESSION['id'];
       $code = $_GET['code'];


             $query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id_e ='$code'");
             $result=mysqli_fetch_array($query);
             $nombres           = $result['nombres'];
             $firma_electronica = $result['firma_electronica'];
             $direccion         = $result['direccion'];
             $codigo_sri        = $result['codigo_sri'];
             $estableciminento        = $result['estableciminento_f'];
             $punto_emision        = $result['punto_emision_f'];
             $porcentaje_iva       = $result['porcentaje_iva_f'];
             $apellidos         = $result['apellidos'];
             $img_logo          = $result['img_facturacion'];
             $url_img_upload           = $result['url_img_upload'];
             $email_user           = $result['email'];
             $fecha                = $result['fecha_creacion'];
             $ciudad_user          = $result['ciudad'];
             $telefono_user        = $result['telefono'];
             $celular_user         = $result['celular'];
             $contabilidad         = $result['contabilidad'];
             $regimen              = $result['regimen'];
             $contribuyente_especial             = $result['contribuyente_especial'];
             $resolucion_contribuyente_especial  = $result['resolucion_contribuyente_especial'];
             $agente_retencion                   = $result['agente_retencion'];
             $resolucion_retencion               = $result['resolucion_retencion'];

             $nombre_empresa                   = $result['nombre_empresa'];
             $razon_social               = $result['razon_social'];
             $numero_identidad               = $result['numero_identidad'];

             $whatsapp             = $result['whatsapp'];
             $instagram            = $result['instagram'];
             $facebook             = $result['facebook'];
             $pagina_web             = $result['pagina_web'];

             $descripcion_usuerio             = $result['descripcion'];

             $latitud             = $result['latitud'];
             $longitud             = $result['longitud'];

             $empresa             = $result['id'];

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Empresa <?php echo $nombre_empresa ?></title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
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

        <link rel="stylesheet" href="/css/pie_pagina.css">
        <link rel="stylesheet" href="/css/productos_empresa.css?v=2">
        <link rel="stylesheet" href="/css/index.css?v=2">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas2.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin="" />

    </head>

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

                            <br>
                            <style media="screen">
                            .imagen_interna_emrpesa{
                              text-align: center;
                            }
                              .imagen_interna_emrpesa img{
                                width: 15%;
                              }
                            </style>

                            <main >
                              <div class="imagen_interna_emrpesa">
                                  <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo; ?>" alt="<?php echo $img_logo; ?>">
                                  <p><?php echo $nombre_empresa ?></p>
                              </div>


                              <style media="screen">
                                .botones_compartit_afuer{
                                  text-align: center;
                                }
                              </style>

                              <div class="botones_compartit_afuer">
                                <button class="btn btn-primary" id="botonCompartir">
                                    <i class="fa fa-share-alt"></i> Compartir Empresa
                                </button>

                              </div>



                              <div class="info-container-secundario">
                                <div class="search-container">
                                    <input type="text" required id="campo_busqueda" name="busqueda" class="search-input" placeholder="Buscar..">
                                </div>

                              </div>
                              <div class="productos_restaurantes">
                                  <div class="product-list scroll_der res" id="list-prods" >



                                    <?php
                                    //permiso para visualizar

                                    $query_lista = mysqli_query($conection, "SELECT producto_venta.idproducto,producto_venta.url_upload_img,producto_venta.nombre,producto_venta.categoria_rst,producto_venta.maximo_seleccion,producto_venta.nombre,
                                      producto_venta.precio,producto_venta.foto,producto_venta.descripcion,producto_venta.identificador_trabajo FROM producto_venta
                                      INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
                                      INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
                                      INNER JOIN categorias ON producto_venta.categorias = categorias.id
                                      INNER JOIN provincia ON producto_venta.provincia = provincia.id
                                      INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id


                                                WHERE producto_venta.estatus = 1 AND  producto_venta.id_usuario = '$empresa'
                                                ORDER BY producto_venta.id_usuario DESC");

                                    $result_lista= mysqli_num_rows($query_lista);
                                    if ($result_lista > 0) {
                                          while ($data_lista=mysqli_fetch_array($query_lista)) {
                                            $idp = $data_lista['idproducto'];
                                          $url_upload_img = $data_lista['url_upload_img'];
                                          $nombre_comun = $data_lista['nombre'];
                                          $descripcion = $data_lista['descripcion'];
                                          $caracteres = strlen($data_lista['nombre']);
                                          $nombre_final =substr($data_lista['nombre'], 0, 35);
                                          $precio_rst = $data_lista['precio'];

                                         ?>
                                         <a href="<?php echo $data_lista['identificador_trabajo'] ?>?codigo=<?php echo $idp ?>&nombre=<?php echo $nombre_comun ?>&descripcion=<?php echo $descripcion ?> " >
                                           <div class="olmedo_secundario_jl">
                                             <div class="articulo_lista_salida">
                                               <!-- Producto 1 -->
                                               <article class="product agregar_articulo_orden" >
                                                   <div class="product-content">
                                                       <img src="<?php echo $url_upload_img ?>/home/img/uploads/<?php echo $data_lista['foto']?>" alt="Imagen del producto 1" />
                                                   </div>

                                               </article>

                                               <div  class="contenedor_informaciongeneral_tienda">
                                                 <p style="padding: 0;margin: 0;" class="nombre_producto_empresa_out"><?php echo $nombre_final ?></p>
                                                 <?php include "../scripts/mostrar_estrellas_productos.php"; ?>
                                                 <p style="padding: 0;margin: 0;">$<?php echo round($precio_rst,2) ?></p>
                                               </div>
                                             </div>
                                           </div>
                                         </a>

                                      <?php
                                      }
                                    }
                                  ?>

                                  </div>
                              </div>




                            </main>
                            <div id="myMap" style="height:300px"></div>















              </div>

                </div>
            </div>
        </div>




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
        <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
          integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
          crossorigin=""></script>

          <script type="text/javascript">
          let myMap = L.map('myMap').setView([51.505, -0.09], 13)

          L.tileLayer(`https://{s}.tile.osm.org/{z}/{x}/{y}.png`, {
          maxZoom: 18,
          }).addTo(myMap);
          myMap.panTo(new L.LatLng(-1.2484,-78.6133 ))
          L.marker([-1.2484, -78.6133]).addTo(myMap)

          </script>


          <script type="text/javascript">
          $(document).on('click', '#botonCompartir', function() {
          var url = 'https://guibis.com/code_user?code=<?php echo $code ?>&nombre_empresa=<?php echo $nombre_empresa ?>'; // Reemplaza con la URL dinámica si es necesario
          navigator.clipboard.writeText(url).then(function() {
              alert("URL copiada al portapapeles: " + url);
          }).catch(function(error) {
              alert("Error al copiar la URL: ", error);
          });
      });
          </script>


    </body>

</html>
