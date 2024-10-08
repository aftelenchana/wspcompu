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
        <title>Cuenta Bancaria</title>

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



              $query = mysqli_query($conection, "SELECT * FROM `saldo_total_leben`
               INNER JOIN usuarios ON saldo_total_leben.idusuario = usuarios.id
               WHERE usuarios.id = $iduser ");
               $result_bq_r = mysqli_fetch_array($query);
               $qr_bancario =  $result_bq_r['qr_bancario'];

              $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
              $result = mysqli_fetch_array($query);
              $email_usuario = $result['email'];
              $nombres_usuario = $result['nombres'];
              $apellidos_usuario = $result['apellidos'];
              $cuenta_bancaria = $result['banco_pichincha'];
              $banco_guayaquil = $result['banco_guayaquil'];
              $banco_produbanco = $result['banco_produbanco'];
              $banco_pacifico = $result['banco_pacifico'];
              $camara_comercio_ambato = $result['camara_comercio_ambato'];
              $mushuc_runa = $result['mushuc_runa'];
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


                                            <!-- Contenedor Principal -->
                                            <!-- Contenedor Principal -->
                                            <div class="container py-5">
                                              <!-- Fila de tarjetas de acciones -->
                                              <div class="row g-4">
                                                <!-- Tarjeta de Recargar en mi Cuenta -->
                                                <div class="col-12">
                                                  <div class="card text-center shadow">
                                                    <div class="card-body">
                                                      <i class="fas fa-plus-circle fa-3x mb-3" style="color: #26c6da;"></i>
                                                      <h5 class="card-title">Recargar en mi Cuenta</h5>
                                                      <p class="card-text">Recarga mediante nuestras cuentas bancarias para que puedas comprar y vender en todas las tiendas que están en nuestro sitio.</p>
                                                      <button type="button" class="btn btn-primary" id="btn-ventana">Recargar en mi Cuenta</button>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- Tarjeta de Retirar de mi Cuenta -->
                                                <div class="col-12">
                                                  <div class="card text-center shadow">
                                                    <div class="card-body">
                                                      <i class="fas fa-minus-circle fa-3x mb-3" style="color: #ef5350;"></i>
                                                      <h5 class="card-title">Retirar de mi Cuenta</h5>
                                                      <p class="card-text">Retira tu dinero generado en tu cuenta hacia tus cuentas bancarias agregadas en nuestros sitios.</p>
                                                      <button type="button" class="btn btn-danger" id="btn-ventana-retiros">Retirar de mi Cuenta</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>





                                            <style media="screen">
                                              .imagen_token_seguridad{
                                                width: 15%;
                                              }

                                              @media (max-width: 768px) {
                                                .imagen_token_seguridad{
                                                  width: 50%;
                                                }

                                              }
                                            </style>





                                            <div class="container mt-4">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="text-center mb-3">
                                        <a href="/home/active-token">
                                            <img class="imagen_token_seguridad" src="https://guibis.com/home/img/qr_bancario/<?php echo $qr_bancario ?>" alt="QR Bancario" class="img-fluid" >
                                        </a>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive"> <!-- Clase table-responsive agregada aquí -->
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td><i class="fas fa-user"></i> Nombre: <?php echo $result['nombres'] . " " . $result['apellidos']; ?></td>
                                                            <td><i class="fas fa-wallet"></i> Saldo Total: <span class="saldo_total">$<?php echo round($result_bq_r['cantidad'], 2) ?></span></td>
                                                            <td><i class="fas fa-envelope"></i> Email: <?php echo $result['email']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-id-card"></i> Cédula: <?php echo $result['numero_identidad']; ?></td>
                                                            <td><i class="fas fa-mobile-alt"></i> Celular: <?php echo $result['celular']; ?></td>
                                                            <td><i class="fas fa-phone"></i> Teléfono: <?php echo $result['telefono']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                                        <!-- Contenedor Principal -->

                                        <div class="histo_banca ">
                                          <div class="container py-5">
                                            <!-- Primera fila de acciones -->
                                            <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                                              <!-- Acción Activar Token -->
                                              <div class="col">
                                                <a href="/home/active-token" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-qrcode fa-3x mb-3" style="color: #FFC107;"></i>
                                                    <h5 class="card-title mb-0">Activar Token</h5>
                                                  </div>
                                                </a>
                                              </div>
                                              <!-- Acción Créditos Directos -->
                                              <div class="col">
                                                <a href="creditos" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-wallet fa-3x mb-3" style="color: #4CAF50;"></i>
                                                    <h5 class="card-title mb-0">Créditos Directos</h5>
                                                  </div>
                                                </a>
                                              </div>
                                            </div>
                                            <!-- Segunda fila de acciones -->
                                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                              <!-- Acción Historial de Depósitos -->
                                              <div class="col">
                                                <a href="historial-depositos" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3" style="color: #FFC107;"></i>
                                                    <h5 class="card-title mb-0">Historial Depósitos</h5>
                                                  </div>
                                                </a>
                                              </div>
                                              <!-- Acción Historial de Retiros -->
                                              <div class="col">
                                                <a href="historial-retiros" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-hand-holding-usd fa-3x mb-3" style="color: #4CAF50;"></i>
                                                    <h5 class="card-title mb-0">Historial Retiros</h5>
                                                  </div>
                                                </a>
                                              </div>
                                            </div>
                                          </div>

                                        </div>


                                    <style media="screen">
                                    /* Estilo base para el contenedor con clase raíz histo_banca */
                                    .histo_banca .container {
                                      max-width: 100%;
                                      padding: 0;
                                      background: linear-gradient(to right, #ffffff, #e6e6e6); /* Degradado de izquierda a derecha */
                                    }

                                    /* Estilo para la fila de tarjetas */
                                    .histo_banca .row {
                                      margin: 0;
                                    }

                                    /* Estilo para las columnas individuales */
                                    .histo_banca .col {
                                      padding: 0; /* Elimina el espaciado interno para que no haya espacio entre las tarjetas */
                                    }

                                    /* Estilo para las tarjetas */
                                    .histo_banca .card {
                                      margin: 0; /* Elimina cualquier margen alrededor de las tarjetas */
                                      border-radius: 0; /* Elimina los bordes redondeados */
                                      background: transparent; /* Fondo transparente para que se vea el degradado */
                                    }

                                    /* Estilo para el cuerpo de la tarjeta */
                                    .histo_banca .card-body {
                                      padding: 1rem; /* Añade un poco de espaciado interno */
                                    }

                                    /* Estilos para dispositivos móviles */
                                    @media (max-width: 576px) {
                                      .histo_banca .card-body {
                                        padding: 0.5rem; /* Reduce el espaciado interno en dispositivos móviles */
                                      }

                                      .histo_banca .card i {
                                        font-size: 1.5rem; /* Reduce el tamaño de los íconos en dispositivos móviles */
                                      }

                                      .histo_banca .card .card-title {
                                        font-size: 0.8rem; /* Reduce el tamaño del texto en dispositivos móviles */
                                      }
                                    }



                                    </style>





                                        <div class="contenedor_fgt">
                                          <div class="histial_bancario_general" style="padding: 15px;">
                                            <div class="">
                                              <table>
                                                <tr class="titu_table">
                                                  <td>Código</td>
                                                  <td>Total</td>
                                                  <td>Subtotal</td>
                                                  <td>Comisión</td>
                                                  <td>Fecha</td>
                                                  <td>Acción</td>
                                                  <td>Reportar</td>
                                                </tr>
                                                <?php

                                                $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro   FROM historial_bancario
                                                INNER JOIN usuarios ON usuarios.id = historial_bancario.id_admin WHERE id_usuario = $iduser    ORDER BY historial_bancario.fecha DESC");
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
                                                $query_lista = mysqli_query($conection,"SELECT historial_bancario.cantidad,historial_bancario.cantidad_parcial,historial_bancario.id,
                                                historial_bancario.cantidad_comision,  DATE_FORMAT(historial_bancario.fecha, '%W  %d de %b %Y %h:%m:%s') as 'fecha' ,historial_bancario.accion,usuarios.nombres,usuarios.apellidos
                                                FROM historial_bancario INNER JOIN usuarios ON usuarios.id = historial_bancario.id_admin WHERE id_usuario = $iduser    ORDER BY historial_bancario.fecha DESC  LIMIT  $desde,$por_pagina ");
                                                while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                  $id = $data_lista['id'];
                                                  $accion = $data_lista['accion'];


                                                 ?>
                                                 <tr>
                                                   <td data-titulo="Código">
                                                     <?php if ($accion == 'Compra'): ?>
                                                       <a href="detalles-movimiento-compra?movimiento_compra=<?php echo $id ?>"><?php echo $data_lista['id'] ?></a>

                                                     <?php endif; ?>
                                                     <?php if ($accion == 'Venta'): ?>
                                                       <a href="detalles-movimiento-venta?movimiento_venta=<?php echo $id ?>"><?php echo $data_lista['id'] ?></a>

                                                     <?php endif; ?>
                                                     <?php if ($accion == 'Deposito'): ?>
                                                       <?php echo $data_lista['id'] ?>

                                                     <?php endif; ?>



                                                     </td>
                                                   <td data-titulo="Total">$<?php echo number_format($data_lista['cantidad'],2)?></td>
                                                   <td data-titulo="Subtotal">$<?php echo number_format($data_lista['cantidad_parcial'],2)?></td>
                                                   <td data-titulo="Comisión">$<?php echo number_format($data_lista['cantidad_comision'],2)?></td>
                                                   <td data-titulo="Fecha"><?php echo mb_strtoupper($data_lista['fecha']);  ?></td>
                                                   <td data-titulo="Acción"> <?php echo $data_lista['accion']; ?></td>
                                                   <td data-titulo="Reportar">
                                                     <?php
                                                     $query_movimiento = mysqli_query($conection, "SELECT * FROM `reporte_movimientos` WHERE iduser = $iduser AND idmovimiento = '$id'");
                                                     $result_movimientos = mysqli_num_rows($query_movimiento);
                                                      ?>
                                                      <?php if ($result_movimientos>0): ?>
                                                        <button type="button" class="btn btn-warning boton_reportar_movimiento" movimiento='<?php echo $data_lista['id'] ?>' id="boton_reportar_movimiento" name="button">Reportado <?php echo $data_lista['id'] ?></button>

                                                      <?php endif; ?>

                                                      <?php if ($result_movimientos == 0): ?>
                                                        <button type="button" class="btn btn-info boton_reportar_movimiento" movimiento='<?php echo $data_lista['id'] ?>' id="boton_reportar_movimiento" name="button">Reportar <?php echo $data_lista['id'] ?></button>

                                                      <?php endif; ?>
                                                   </td>
                                                 </tr>
                                                 <?php
                                                 }

                                             ?>
                                              </table>
                                            </div>
                                          </div>
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

        <script type="text/javascript">
          (function(){
            $(function(){
              $('.boton_reportar_movimiento').on('click',function(){
                    var movimiento = $(this).attr('movimiento');
                    console.log(movimiento);
                $('#reportar_movimiento').modal();
                var action = 'info_reportes';
                $.ajax({
                  url:'jquery_bancario/reportes.php',
                  type:'POST',
                  async: true,
                  data: {action:action,movimiento:movimiento},
                   success: function(response){
                     console.log(response);
                       var info = JSON.parse(response);
                       if (info.respuesta == 'no_existente') {
                         $('.respuesta_reporte_movimientos').html('<form class="form_add_producto" action="" method="post" name="enviar_reporte_movimiento" id="enviar_reporte_movimiento" onsubmit="event.preventDefault(); sendData_reportar_movimientos();">'+
                                   '<h3>No existe reporte para este movimiento</h3>'+
                                   '<p>Realiza un reporte en caso de que tengas problemas con este movimiento</p>'+
                                   '<div class="form-group">'+
                                     '<label for="exampleFormControlTextarea1">Descripción del Reporte</label>'+
                                     '<textarea class="form-control" name="descripcion_reporte" id="exampleFormControlTextarea1" rows="3"></textarea>'+
                                   '</div>'+
                                   '<div class="modal-footer">'+
                                   '<input type="hidden" name="action" value="agregar_reporte_movimientos">'+
                                   '<input type="hidden" name="movimiento" value="'+info.movimiento+'">'+
                                     '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                     '<button type="submit" class="btn btn-primary">Enviar Reporte</button>'+
                                   '</div>'+
                                   '<div class="respuesta_reporte_movimientos_jk">'+
                                  ' </div>'+
                                 '</form>');

                       }

                       if (info.respuesta == 'existente') {
                         $('.respuesta_reporte_movimientos').html('<form class="form_add_producto" action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData_add_comprobante();">'+
                                   '<h3>Existe un reporte para el movimiento '+info.movimiento+' </h3>'+
                                   '<p>Existe un movimiento con código '+info.movimiento+'</p>'+
                                   '<div class="row">'+
                                       '<div class="col-12">'+
                                         '  <div class="table-responsive">'+
                                               '<table class="table table-bordered">'+
                                                   '<thead>'+
                                                       '<tr>'+
                                                           '<th>Código</th>'+
                                                           '<th>Reporte</th>'+
                                                           '<th>Fecha</th>'+
                                                           '<th>Estado</th>'+
                                                           '<th>Resolución</th>'+
                                                       '</tr>'+
                                                   '</thead>'+
                                                   '<tbody>'+
                                                       '<tr>'+
                                                           '<td>'+info.movimiento+'</td>'+
                                                           '<td>'+info.reporte+'</td>'+
                                                           '<td>'+info.fecha+'</td>'+
                                                           '<td>'+info.estado+'</td>'+
                                                           '<td>'+info.resolucion+'</td>'+
                                                       '</tr>'+
                                                   '</tbody>'+
                                               '</table>'+
                                           '</div>'+
                                       '</div>'+
                                   '</div>'+
                                   '<div class="modal-footer">'+
                                     '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                   '</div>'+
                                   '<div class="respuesta_reporte_movimientos_jk">'+
                                  ' </div>'+

                                 '</form>');


                       }

                   },
                   error:function(error){
                     console.log(error);
                     }

                   });
              });


            });

          }());



          function sendData_reportar_movimientos(){
            $('.respuesta_reporte_movimientos_jk').html(' <div class="">'+
               '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
             '</div>');
             var parametros = new  FormData($('#enviar_reporte_movimiento')[0]);
            $.ajax({
              data: parametros,
               url:'jquery_bancario/reportes.php',
              type: 'POST',
              contentType: false,
              processData: false,
              beforesend: function(){

              },
              success: function(response){
                console.log(response);

                if (response =='error') {
                  $('#informacion-retiro-bancario').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                }else {
                var info = JSON.parse(response);
                if (info.respuesta == 'exitoso') {
                  $('.respuesta_reporte_movimientos_jk').html('<div class="alert alert-success" role="alert">Reporte Enviado Correctamente</div>');
                }

                if (info.respuesta == 'error') {
                  $('.respuesta_reporte_movimientos_jk').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
                }
                if (info.respuesta == 'existente') {
                  $('.respuesta_reporte_movimientos_jk').html('<div class="alert alert-danger" role="alert">El reporte ya se ha enviado!</div>');
                }

                }

              }

            });

          }










        </script>



        <script type="text/javascript">
        (function(){
          $(function(){
            $('#btn-ventana-retiros').on('click',function(){
              $('#exampleModalCenter-retiros').modal();
              $('#exampleFormControlFile1').val('');
              var usuario = $(this).attr('usuario');
              var action = 'infoUsuario';
              $.ajax({
                type:"post",
                  url:'jquery/general.php',
                  data: {action:action},
                success:function(response){
                  console.log('agregar_informacion para el deposito');
                  if (response =='error') {
                    $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
                  }else {
                  var info = JSON.parse(response);



                  }
                }

              })
            });


          });

        }());


        function sendData_retiro_comprobante2(){
          $('#informacion-retiro-bancario').html(' <div class="">'+
             '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
           '</div>');
           var parametros = new  FormData($('#retiro_comprobante2')[0]);
          $.ajax({
            data: parametros,
            url: 'jquery_bancario/depositos.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){

            },
            success: function(response){
              console.log(response);

              if (response =='error') {
                $('#informacion-retiro-bancario').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
              }else {
              var info = JSON.parse(response);
              if (info.noticia == 'retiro_agregado') {
                $('#informacion-retiro-bancario').html('<div class="alert alert-success" role="alert">Retiro Exitoso! Espera unos minutos y verifica tu cuenta bancaria</div>');
              }

              if (info.noticia == 'contrasena_incorrecta') {
                $('#informacion-retiro-bancario').html('<div class="alert alert-danger" role="alert">Contraseña Incorrecta, recuerda que el sistema bloquea tu cuenta si detecta movimiento inusuales!</div>');
              }
              if (info.noticia == 'saldo_insuficiente') {
                $('#informacion-retiro-bancario').html('<div class="alert alert-danger" role="alert">No tienes fondos suficientes para realizar esta transacción!</div>');
              }
              if (info.noticia == 'cuenta_bancaria_inactiva') {
                $('#informacion-retiro-bancario').html('<div class="alert alert-danger" role="alert">Tu cuenta esta inactiva para este proceso, ve a cuenta y activa los movimientos bancarios!</div>');

              }
              if (info.noticia == 'menos_24_horas_sin_compra') {
                $('#informacion-retiro-bancario').html('<div class="alert alert-danger" role="alert">El sistema a detectado que deseas hacer una transferencia interbancaria, realiza una compra o espera 24 horas desde tu ultimo depósito.!</div>');

              }




              }

            }

          });

        }

        </script>



       <script type="text/javascript">
       (function(){
         $(function(){
           $('#btn-ventana').on('click',function(){
             $('.notificacion-identificacion-envio').html('');
             $('#exampleModalCenter').modal();
             $('#exampleFormControlFile1').val('');
             var usuario = $(this).attr('usuario');
             var action = 'infoUsuario';
             $.ajax({
               type:"post",
                 url:'jquery/general.php',
                 data: {action:action},
               success:function(response){
                 console.log('agregar_informacion para el deposito');
                 if (response =='error') {
                   $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
                 }else {
                 var info = JSON.parse(response);






                 }
               }

             })
           });


         });

       }());


       function sendData_add_comprobante2(){
         $('#informacion-deposito-bancario').html(' <div class="">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
          '</div>');
         var parametros = new  FormData($('#add_comprobante')[0]);
         $.ajax({
           data: parametros,
           url: 'jquery_bancario/depositos.php',
           type: 'POST',
           contentType: false,
           processData: false,
           beforesend: function(){

           },
           success: function(response){
             console.log(response);

             if (response =='error') {
               $('#informacion-deposito-bancario').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
             }else {
             var info = JSON.parse(response);
             if (info.noticia == 'pago_agregado') {
               $('#informacion-deposito-bancario').html('<div class="alert alert-success" role="alert">Depósito Agregado Correctamente!</div>');
             }

             if (info.noticia == 'comprobante_igual') {
               $('#informacion-deposito-bancario').html('<div class="alert alert-danger" role="alert">Este comprobante ya se encuentra en nuestra base de datos!</div>');
             }
             if (info.noticia == 'entidad_bancaria_vacia') {
               $('#informacion-deposito-bancario').html('<div class="alert alert-danger" role="alert">Elije una cuenta Bancaria para realizar este proceso!</div>');
             }
             if (info.noticia == 'cuenta_bancaria_inactiva') {
               $('#informacion-deposito-bancario').html('<div class="alert alert-danger" role="alert">Tu cuenta esta inactiva para este proceso, ve a cuenta y activa los movimientos bancarios!</div>');

             }




             }

           }

         });

       }

       </script>



    </body>

</html>
