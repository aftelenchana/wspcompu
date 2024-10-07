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
        <title>Agregar Cliente</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
    </head>

    <body>

     <?php
     require 'scripts/loader.php';


                  require 'scripts/iconos.php';


              ?>

              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">

                              <div class="page-body">
                                  <div class="row">
                                      <div class="card-block">
                                          <div class="card product-detail-page">
                                            <div class="">
                                              <div class="card-block">
                                                <form action="" method="post" name="add_form_nuevo_producto" id="add_form_nuevo_producto" onsubmit="event.preventDefault(); sendDataedit_nuevo_producto();">
                                                    <div class="mb-3">
                                                      <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                                                      <input type="text" maxlength="120" name="nombre_producto" class="form-control" id="nombre_producto" placeholder="Nombre del Producto">
                                                    </div>
                                                    <div class="row">
                                                      <div class="col">
                                                        <div class="mb-3">
                                                          <label for="precio_sin_impuestos" class="form-label">Precio (SIN IMPUESTOS)</label>
                                                          <input oninput="calculo_precio_final_input()" type="number" step="0.00001" class="form-control" name="precio" id="precio_sin_impuestos" placeholder="Ingrese el precio">
                                                          <small class="form-text text-muted">Precio con el cual se calcula el precio final</small>
                                                        </div>
                                                      </div>
                                                      <div class="col">
                                                        <div class="mb-3">
                                                          <label for="precio_costo" class="form-label">Precio Costo</label>
                                                          <input type="number" step="0.00001" class="form-control" name="precio_costo" id="precio_costo" placeholder="Ingrese el precio">
                                                          <small class="form-text text-muted">Precio costo es el valor base no al público</small>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <p>Información de los impuestos</p>
                                                    <div class="row">
                                                      <div class="col">
                                                        <div class="mb-3">
                                                          <label for="codigos_impuestos" class="form-label">Elija la Tarifa IVA</label>
                                                          <select class="form-select" name="codigos_impuestos" id="codigos_impuestos">
                                                            <option value="2">IVA</option>
                                                          </select>
                                                        </div>
                                                      </div>
                                                      <div class="col">
                                                        <div class="mb-3">
                                                          <label for="elejir_tarifa_iva" class="form-label">Elija la Tarifa IVA</label>
                                                          <select oninput="calculo_precio_final_input()" class="form-select" name="elejir_tarifa_iva" id="elejir_tarifa_iva">
                                                            <option value="2">CON IVA</option>
                                                            <option value="0">SIN IVA</option>
                                                            <option value="6">Exento de IVA</option>
                                                            <option value="7">No Objeto de Impuesto</option>
                                                          </select>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="resultado_calculo" class="form-label">Precio Final del Producto</label>
                                                      <input type="number" step="0.00001" class="form-control" name="resultado_calculo" readonly id="resultado_calculo" placeholder="Precio Final">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="cantidad" class="form-label">Agregue Cantidad</label>
                                                      <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="exampleFormControlFile1" class="form-label">Agregue una imagen</label>
                                                      <input type="file" class="form-control-file" name="foto" accept="image/png, .jpeg, .jpg" id="exampleFormControlFile1">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="marca" class="form-label">Agregue Marca o Código</label>
                                                      <input type="text" maxlength="120" name="marca" class="form-control" id="marca" placeholder="Marca o Código">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="codigo_barras" class="form-label">Agregue el código de Barras</label>
                                                      <input type="text" maxlength="120" name="codigo_barras" class="form-control" id="codigo_barras" placeholder="Ingrese El Código de Barras">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="proveedor" class="form-label">Elija un Proveedor si no lo tienes <a href="agregar_proveedor">Agrega un Proveedor</a></label>
                                                      <select class="form-select" name="proveedor" id="proveedor">
                                                        <?php
                                                        $query_proveedor = mysqli_query($conection, "SELECT * FROM proveedor WHERE  proveedor.iduser= '$iduser'   AND proveedor.estatus = 1");
                                                        while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                                          echo '<option  value="' . $proveedor['id'] . '">' . $proveedor['razon_social'] . '/ ' . $proveedor['identificacion'] . '</option>';
                                                        }
                                                        ?>
                                                      </select>
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="descripcion" class="form-label">Agregue una descripcion</label>
                                                      <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion" rows="3"></textarea>
                                                    </div>

                                                    <small id="emailHelp" class="form-text text-muted">Este producto no se sube a la nube de <a href="https://guibis.com">guibis.com</a>.</small>
                                                    <input type="hidden" name="action" value="agregar_producto">
                                                    <input type="hidden" name="categorias" value="<?php echo $catego ?>">
                                                    <input type="hidden" name="subcategorias" value="<?php echo $subcatego ?>">
                                                    <input type="hidden" name="provincia" value="0">
                                                    <input type="hidden" name="ciudad" value="0">
                                                    <button type="submit" class="btn btn-primary">Agregar Producto</button>
                                                    <div class="alerta_nuevoproducto"></div>
                                                  </form>


                                              </div>
                                            </div>

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div id="styleSelector"></div>
                  </div>
              </div>










                </div>
            </div>
        </div>


        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
        <script type="text/javascript" src="jquery_producto/subir_nuevo_productoat.js"></script>
        <script type="text/javascript">
        $("document").ready(function(){
          $( "#provincia" ).load( "server/lugar.php" );
          $("#provincia").change(function(){
            var idd =   $("#provincia").val();
            $.get("server/lugar1.php", {id:idd})
            .done(function(data){
              $("#ciudad" ).html( data );
            })
          })
        })
        </script>

    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
