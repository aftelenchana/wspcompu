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

  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Home</title>

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
        <link rel="stylesheet" href="/css/front.css">
        <link rel="stylesheet" href="/css/index.css?v=2">
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

                            <main >

                              <div class="info-container-secundario">
                                <div class="search-container">
                                    <input type="text" required id="campo_busqueda" name="busqueda" class="search-input" placeholder="Buscar..">
                                </div>

                              </div>
                              <div class="productos_restaurantes">
                                  <div class="product-list scroll_der res" id="list-prods" >

                                    <?php
                                    //permiso para visualizar

                                    $query_lista = mysqli_query($conection, "SELECT * FROM usuarios
                                                INNER JOIN producto_venta ON producto_venta.id_usuario = usuarios.id
                                                WHERE (usuarios.img_facturacion != '' OR usuarios.img_facturacion IS NOT NULL)
                                                AND (usuarios.nombre_empresa != '' OR usuarios.nombre_empresa IS NOT NULL)
                                                AND usuarios.nombre_empresa != '0'
                                                AND (usuarios.url_img_upload != '' OR usuarios.url_img_upload IS NOT NULL)
                                                AND usuarios.direccion != ''
                                                AND usuarios.id_e != ''
                                                AND usuarios.id_e != '0'
                                                GROUP BY usuarios.id");


                                    $result_lista= mysqli_num_rows($query_lista);
                                    if ($result_lista > 0) {
                                          while ($data_lista=mysqli_fetch_array($query_lista)) {
                                            $nombre_empresa = $data_lista['nombre_empresa'];
                                            $img_facturacion = $data_lista['img_facturacion'];
                                            $url_img_upload = $data_lista['url_img_upload'];
                                            $direccion = $data_lista['direccion'];
                                            $empresa = $data_lista['id'];
                                            $id_e = $data_lista['id_e'];

                                         ?>
                                         <a href="code_user?code=<?php echo $id_e ?>&name=<?php echo $nombre_empresa ?>">
                                           <div class="olmedo_secundario_jl">
                                             <div class="articulo_lista_salida">
                                               <!-- Producto 1 -->
                                               <article class="product card mb-3 agregar_articulo_orden" >
                                                   <div class="product-name bg-info">
                                                       <?php echo $nombre_empresa ?>
                                                   </div>
                                                   <div class="product-content">
                                                       <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion?>" class="card-img-top" alt="Imagen del producto 1" />
                                                   </div>
                                                <?php include "../scripts/mostrar_estrellas.php"; ?>

                                               </article>
                                               <div class="contenedor_informaciongeneral_tienda">
                                                 <p><?php echo $nombre_empresa ?></p>
                                                 <p><?php echo $direccion ?></p>
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


    </body>

</html>
