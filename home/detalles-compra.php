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

        $compra = $_GET['compra'];

  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Detalles de la Compra con Código #<?php echo $compra ?></title>

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

        <link rel="stylesheet" href="estilos-importante/cuenta-bancaria.css?v=3">
        <link rel="stylesheet" href="estilos-importante/cuenta.css?v=2">

        <link rel="stylesheet" href="estilos/categorias.css">
        <link rel="stylesheet" href="/css/pie_pagina.css?v=2">

        <link rel="stylesheet" href="estiloshome/cuenta_bancaria.css?v=5">
        <link rel="stylesheet" href="estiloshome/estilos_paginador.css">
        <link rel="stylesheet" href="estiloshome/load.css">
        <link rel="stylesheet" href="estilos/tabla_front.css">

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
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">


                                              <?php
                                              $query_lista = mysqli_query($conection,"SELECT ventas.id as 'idcompra', producto_venta.idproducto as 'idproducto', producto_venta.qr, producto_venta.nombre,
                                                ventas.id_comprador,ventas.fecha as 'feha_compra',ventas.metodo_pago,producto_venta.precio,ventas.cantidad_producto,
                                                ventas.estado_financiero,ventas.estado_fisico,ventas.estado,producto_venta.foto,ventas.precio_compra,
                                                ventas.qr_venta,ventas.fecha_inicio_venta,ventas.fecha_tope_venta,ventas.fecha_tope_sin_novedades,ventas.estado_reporte,
                                                ventas.fecha_cancelacion_venta,ventas.fecha_final_reporte,usuarios.id as 'id_vendedor',ventas.img_reporte
                                            FROM ventas  INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
                                            INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
                                            WHERE id_comprador = $iduser AND ventas.id='$compra'");

                                                    $data_lista=mysqli_fetch_array($query_lista);
                                                        $qr = 'img/qr/'.$data_lista['qr'];
                                                        if ($data_lista['img_reporte'] == '') {
                                                          $img_reporte = 'Ninguna';
                                                          // code...
                                                        }else {
                                                          $img_reporte =' <a target="_blank" href="img/reportes/'.$data_lista['img_reporte'].'"><img style="width: 80px;" src="img/reportes/'.$data_lista['img_reporte'].'" alt=""></a>';
                                                        }


                                               ?>

                                                 <h3 style="text-align: center;">Detalles de la compra de <?php echo $data_lista['nombre'] ?> con código  #<?php echo $compra ?></h3>






                                        <div class="contenedor_fgt">
                                          <div class="histial_bancario_general" style="padding: 15px;">
                                            <div class="">
                                              <table>
                                                <tr class="titu_table">
                                                  <td>Fecha</td>
                                                  <td>Vendedor</td>
                                                  <td>Producto</td>
                                                    <td>Cantidad </td>
                                                    <td>Precio </td>
                                                    <td>Fecha </td>
                                                  <td>Entrega </td>
                                                  <td>Reporte</td>
                                                  <td>Imagen </td>
                                                <td>Cancelacion </td>
                                                <td>Otros</td>
                                                </tr>


                                                 <tr>
                                                   <td data-titulo="Fecha"><?php echo $data_lista['feha_compra'];?></td>
                                                       <td data-titulo="Vendedor"> <a href="perfil.php?id=<?php echo $data_lista['id_vendedor']?>">#<?php echo $data_lista['id_vendedor']?></a> </td>
                                                       <td data-titulo="Producto"><a href="producto.php?idp<?php echo ($data_lista['idproducto']);?>"> <img style="width: 80px;" src="img/uploads/<?php echo $data_lista['foto']; ?>" alt=""> </a> </td>
                                                       <td data-titulo="Cantidad"><?php echo $data_lista['cantidad_producto'];  ?></td>
                                                       <td data-titulo="Monto"> $ <?php echo $data_lista['precio_compra']; ?></td>
                                                       <td data-titulo="Fecha Maxima">  <?php echo $data_lista['fecha_tope_sin_novedades']; ?></td>
                                                       <td data-titulo="Entrega">  <?php echo $data_lista['estado_fisico']; ?></td>
                                                       <td data-titulo="Reporte">  <?php echo $data_lista['estado_reporte']; ?></td>
                                                       <td data-titulo="Imagen Reporte"><?php echo $img_reporte ?></td>
                                                       <td data-titulo="Cancelacion">  <?php echo $data_lista['fecha_cancelacion_venta']; ?></td>
                                                       <td data-titulo="Mas Detalles"> Otros</td>
                                                 </tr>

                                              </table>
                                            </div>
                                          </div>
                                        </div>



                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>

                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="reportar_movimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reportar Movimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body respuesta_reporte_movimientos">

              </div>
            </div>
          </div>
        </div>







        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  ">
              <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                <h5 class="modal-title" id="proveedorModalLabel">Recargar en mi Cuenta</h5>
              </div>
              <div class="modal-body text-center">
                  <form  action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData_add_comprobante2();" >
                  <div class="form-group" id="formulario_activar_cuentas" >
                      <label for="exampleFormControlFile1">Agregar el boucher en formato imagen(image/png, .jpeg, .jpg)</label>
                      <input type="file" class="form-control-file"  name="foto"  accept="image/png, .jpeg, .jpg" required id="exampleFormControlFile1">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Elija el Banco a depositar.</label>
                      <select class="form-control" name="tipo_banco" id="exampleFormControlSelect1">
                        <option value="Banco Pichincha">Banco Pichincha 2206665812</option>
                        <option value="Produbanco">Produbanco (Grupo Promerica) 12080241145</option>
                        <option value="Banco Guayaquil">Banco Guayaquil 0047825380</option>
                        <option value="Banco Pacifico">Banco del Pacifico  1049945475</option>
                        <option value="Camara de Comercio Ambato">Camara de Comercio Ambato CCCA 403095054137</option>
                        <option value="Cooperativa Mushuc Runa">Cooperativa Mushuc Runa 404406513458</option>
                      </select>
                    </div>
                    <div class="form-group">
                       <label for="exampleFormControlInput1">Cantidad del depósito</label>
                       <input type="number" class="form-control" id="exampleFormControlInput1" name="cantidad" step="0.01" placeholder="12.34" required>
                     </div>
                     <div class="form-group">
                        <label for="exampleFormControlInput1">Número Único del Déposito</label>
                        <input type="number" name="numero_unico" class="form-control" id="exampleFormControlInput1"  placeholder="1234567" required>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" id="accionar_formulario_re" class="btn btn-primary">Realizar Déposito </button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <input type="hidden" name="action" value="deposito_comprobante" required>
                        <div class="informacion-usuario" id="informacion-deposito-bancario"></div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>










        <!-- MODAL PARA RETIROS BANCARIOS -->
        <div class="modal fade" id="exampleModalCenter-retiros" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Retira dinero hacia tus cuentas Bancarias.
                <img src="img/reacciones/depositos-electronicos.png" alt="" style="width: 5%;"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="" name="retiro_comprobante2" id="retiro_comprobante2" onsubmit="event.preventDefault(); sendData_retiro_comprobante2();" >
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Elije la cuenta bancaria a la cual vas a retirar, puedes agregar mas cuentas bancarias en cuenta.</label>
                      <select class="form-control" name="banco_tipo_retiro">
                          <?php if(!empty($cuenta_bancaria)){?>
                           <option value="Banco Pichincha">Banco Pichincha</option>
                           <?php } ?>
                           <?php if(!empty($banco_guayaquil)){?>
                           <option value="Banco Guayaquil">Banco Guayaquil</option>
                          <?php } ?>
                          <?php if(!empty($banco_produbanco)){?>
                          <option value="Banco Produbanco">Banco Produbanco</option>
                          <?php } ?>
                          <?php if(!empty($banco_pacifico)){?>
                          <option value="Banco Pacifico">Banco Pacifico</option>
                          <?php } ?>
                          <?php if(!empty($camara_comercio_ambato)){?>
                          <option value="Camara de Comercio Ambato">Camara de Comercio Ambato</option>
                          <?php } ?>
                          <?php if(!empty($mushuc_runa)){?>
                          <option value="Cooperativa Mushuc Runa">Cooperativa Mushuc Runa</option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                       <label for="exampleFormControlInput1">Cantidad:</label>
                       <div class="col">
                          <label class="sr-only" for="inlineFormInputGroup">Cantidad:</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">$</div>
                            </div>
                            <input type="number" name="cantidad" class="form-control" id="inlineFormInputGroup" step="0.01" placeholder="1234" required>
                          </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="exampleFormControlInput1">Contraseña :</label>
                        <input type="password" class="form-control" id="exampleFormControlInputpass" step="0.01" name="password"  placeholder="***********" required>
                      </div>


                      <div class="informacion-usuario" id="informacion-retiro-bancario"></div>
                  <div class="modal-footer">
                    <button type="submit"  class="btn btn-danger">Realizar Retiro </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <input type="hidden" name="action" value="retiro_bancario" required>
                  </div>
                </form>

                      <div class="tempo-identificacion">
                        <div class="notificacion-identificacion-envio">
                        </div>

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
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
        <script src="https://guibis.com/home/main.js"></script>
        <script src="/js/categorias.js"></script>

        <script type="text/javascript" src="jquery_bancario/depositos.js"></script>
        <script type="text/javascript" src="jquery_bancario/mi-leben.js"></script>


    </body>

</html>
