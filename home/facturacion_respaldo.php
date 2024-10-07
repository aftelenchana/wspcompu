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

       $codigo_factura = $_GET['factura'];



  ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Facturación</title>
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
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" type="text/css" href="estilos/facturacion.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="particulas/estilos.css">
    </head>

    <body>

     <?php
     require 'scripts/loader.php';


   $fecha=date('d/m/Y');

   $query_cantidad = mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
   $result_cantidad = mysqli_fetch_array($query_cantidad);
   $documentos_electronicos = $result_cantidad['documentos_electronicos'];
   $estableciminento_f = $result_cantidad['estableciminento_f'];
   $punto_emision_f = $result_cantidad['punto_emision_f'];


    $query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' ORDER BY fecha DESC");
     $result_secuencia = mysqli_fetch_array($query_secuencia);
     if ($result_secuencia) {
       $secuencial = $result_secuencia['codigo_factura'];
       $secuencial = $secuencial +1;
       // code...
     }else {
       $secuencial =1;
     }
     $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
     $estableciminento_f = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
     $punto_emision_f = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
    ?>
    <?php
 $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes
 WHERE id_emisor= '$iduser' AND  modulo = 'central' ");
 $resultados_ff = mysqli_fetch_array($query_resultados_ff);
    if (empty($resultados_ff['nombres_receptor'])) {
        $nombres_receptor   = '';
    }else {
      $nombres_receptor   = $resultados_ff['nombres_receptor'];
    }
    if (empty($resultados_ff['celular_receptor'])) {
        $celular_receptor   = '';
    }else {
      $celular_receptor   = $resultados_ff['celular_receptor'];
    }
    if (empty($resultados_ff['numero_identidad_receptor'])) {
        $cedula_receptor    = '';
    }else {
        $cedula_receptor    = $resultados_ff['numero_identidad_receptor'];
    }
    if (empty($resultados_ff['email_reeptor'])) {
      $email_recepto      = '';
    }else {
      $email_recepto      = $resultados_ff['email_reeptor'];
    }
    if (empty($resultados_ff['direccion_reeptor'])) {
      $direccion_receptor = '';
    }else {
      $direccion_receptor = $resultados_ff['direccion_reeptor'];
    }
    if (empty($resultados_ff['id_receptor'])) {
      $id_receptor = '0';
    }else {
      $id_receptor = $resultados_ff['id_receptor'];
    }
    if (empty($resultados_ff['tipo_identificacion'])) {
      $tipo_identificacion = '0';
    }else {
      $tipo_identificacion = $resultados_ff['tipo_identificacion'];
    }

    //INFORMACION DEL USUARIO QUE VA A FACTURAR


    $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
    $result = mysqli_fetch_array($query);
    $nombres_user = $result['nombres'];
    $direccion_user = $result['direccion'];




                  require 'scripts/iconos.php';


              ?>
                    <div class="pcoded-wrapper">
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="page-body m-t-50">
                                          <div class="row">
                                              <div id="particles-js"></div>
                                              <div class="col-xl-12 col-md-18 reservado_query">
                                                <div class="conte_principal_bloque_superior">
                                                  <div class="contenedor_interno_bloque1">
                                                    <div class="info_matriz">
                                                      <label for="">Establecimiento</label>
                                                      <select class="select-custom"name="">
                                                        <option value="<?php echo $estableciminento_f ?>-<?php echo $direccion_user ?>"> <?php echo $estableciminento_f ?>-<?php echo $direccion_user ?> </option>
                                                      </select>
                                                    </div>


                                                    <div class="informacion_punto_emision">
                                                      <label for="">Punto de Emision</label>
                                                      <select class="select-custom" name="">
                                                        <option value=""> <?php echo $punto_emision_f ?></option>
                                                      </select>
                                                    </div>

                                                  </div>
                                                  <div class="contenedor_interno_bloque2">
                                                    <div class="razon_social_cliente_info">
                                                      <label for="">Cliente</label>
                                                      <select class="select-custom clase_buscador_select_clientes" id="search_usuarios"  name="">
                                                        <option value="0">99999999999- Consumidor Final</option>
                                                        <?php
                                                        $query_clientes = mysqli_query($conection,"SELECT * FROM clientes WHERE  clientes.iduser= '$iduser'   AND clientes.estatus = 1");
                                                        while ($clientes = mysqli_fetch_array($query_clientes)) {
                                                          echo '<option  value="'.$clientes['id'].'">'.$clientes['nombres'].'/ '.$clientes['identificacion'].'</option>';
                                                        }
                                                         ?>
                                                      </select>
                                                    </div>
                                                    <div class="informacion_fecha">
                                                      <div class="custom-input">
                                                          <label for="">Fecha</label>
                                                          <input type="text" class="custom-input-field" value="<?php echo $fecha ?>" readonly>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="contenedor_interno_bloque3">
                                                    <div class="informacion_cliente">
                                                      <div class="datos_cliente_direccion">
                                                        <label for="">Dirección</label>
                                                        <input type="" class="custom-input-field" id="direccion_reeptor"  name="direccion_cliente" value="Ninguno">
                                                      </div>
                                                      <div class="datos_cliente_email_telefono">
                                                        <div class="email_cliente">
                                                          <label for="">E-mail</label>
                                                          <input type="" class="custom-input-field" id="email_reeptor"  name="email_cliente" value="factura@facturacion.guibis.com">
                                                        </div>
                                                        <div class="telefono_cliente">
                                                          <label for="">Telefóno</label>
                                                          <input type="" class="custom-input-field" id="celular_receptor"  name="telefono_cliente" value="99999999">
                                                        </div>
                                                      </div>

                                                    </div>
                                                    <div class="numero_guia_remision">
                                                      <label for="">Número Guia de Remisión</label>
                                                      <input type="" name="" class="custom-input-field"   value="">
                                                    </div>
                                                  </div>


                                                </div>
                                              </div>

                                              <div class="col-xl-12 col-md-18 reservado_query">
                                                <div class="conte_principal_bloque_inferior">

                                                  <div class="contenedor_bloque_inferior_1">
                                                    <div class="info_producto">
                                                      <select class="select-custom clase_buscador_select_clientes" id="busqueda_producto"   name="">
                                                        <?php
                                                        $query_opciones = mysqli_query($conection,"SELECT * FROM producto_venta WHERE producto_venta.id_usuario= '$iduser' AND producto_venta.estatus = 1
                                                        ORDER BY producto_venta.idproducto DESC");
                                                        while ($producto = mysqli_fetch_array($query_opciones)) {
                                                          echo '<option producto="'.$producto['idproducto'].'" value="'.$producto['idproducto'].'">'.$producto['nombre'].'- Precio:$'.number_format($producto['precio'],2).'</option>';
                                                        }
                                                        ?>
                                                      </select>
                                                    </div>

                                                  </div>

                                                  <div class="infor_btn_dg_arriba">
                                                    <p>Descripción</p>
                                                    <p>Cantidad</p>
                                                    <p>Precio</p>
                                                    <p>% Desc</p>
                                                    <p>Iva</p>
                                                    <p>Subtotal</p>
                                                  </div>





                                                <form class="" action="" method="post"   name="agregar_producto" id="agregar_producto" onsubmit="event.preventDefault(); sendData_agregar_producto();">
                                                  <div class="opcion_agregar_informacion">
                                                      <div class="botone_mas">
                                                        <button type="submit" class="btn btn-info">Agregar <i class="feather-plus" ></i> </button>
                                                      </div>
                                                        <div class="infor_btn_dg">
                                                          <p>1.00</p>
                                                          <p id="valor_unidad" >0.00</p>
                                                          <p id="">0</p>
                                                          <p id="impuesto">0.00</p>
                                                          <p id="subtotal">0.00</p>
                                                          <input type="hidden" class="producto" name="id_producto" id="id_producto" value="">
                                                          <input type="hidden" name="codigo_factura" id="codigo_factura" value="<?php echo $codigo_factura ?>">
                                                          <input type="hidden" name="action" value="agregar_producto">
                                                        </div>
                                                  </div>
                                                </form>
                                                <div class="resultado_productos_guardados2">

                                                  <?php
                                                    mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                     $query_lista = mysqli_query($conection,"SELECT *
                                                 FROM `comprobantes`
                                                 WHERE comprobantes.id_emisor = '$iduser' AND comprobantes.secuencial = '$codigo_factura'
                                                 ORDER BY `comprobantes`.`fecha` DESC ");
                                                         $result_lista= mysqli_num_rows($query_lista);
                                                       if ($result_lista > 0) {
                                                             while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                      ?>
                                                        <div class="bloque_input_informacion_producto" id="fila<?php echo $data_lista['id']  ?>">
                                                          <p class="nombre_<?php echo $data_lista['id']  ?>" style="display: inline-block;width: 19%;"><?php echo $data_lista['nombre_producto'] ?></p>
                                                          <input idItem="<?php echo $data_lista['id']  ?>"  class="cantidad_<?php echo $data_lista['id']  ?> seleccionar_editar_input_cantidad" type="number" placeholder="Cant.." name="" value="<?php echo ($data_lista['cantidad_producto']) ?>">
                                                          <input readonly class="precio__<?php echo $data_lista['id']?> respuesta_editar_precio" type="text" placeholder="Prec." name="" value="<?php echo number_format($data_lista['valor_unidad'],2 )?>">
                                                          <input idItem="<?php echo $data_lista['id']  ?>"  class="porcentaje_descuento_<?= $registro['id'] ?> respuesta_editar_descuento" type="text" placeholder="%Des." name="" value="<?php echo ($data_lista['descuento']) ?>">
                                                          <input class="iva__<?php echo $data_lista['id']?> respuesta_editar_iva" type="text" placeholder="Iva" name="" value="<?php echo number_format($data_lista['iva_producto'],2) ?>">
                                                          <p class="subtotal__<?php echo $data_lista['id']?> respuesta_editar_subtotal" style="display: inline-block;width: 16%;text-align: center;">$<?php echo number_format($data_lista['subtotal_frontend'],2) ?></p>
                                                          <p item="<?php echo $data_lista['id']  ?>"  class="nombre_<?php echo $data_lista['id']  ?> eliminar_item" style="display: inline-block;width: 3%;"><i class="fas fa-trash-alt"></i> </p>
                                                      </div>
                                                      <hr>

                                                      <?php
                                                      }
                                                      }
                                                  ?>

                                                </div>

                                                <style media="screen">
                                                  .modal {
                                                  z-index: 1050; /* Ajusta este valor según sea necesario */
                                                  }
                                                </style>
                                                <style media="screen">
                                                .form-inline {
                                                  display: flex; /* Mostrar elementos en fila */
                                                  align-items: center; /* Alinear verticalmente en el centro */
                                                }

                                                #formaPago {
                                                  flex: 1; /* Permitir que el select ocupe el espacio disponible */
                                                  margin-right: 10px; /* Agregar espacio a la derecha del select */
                                                }
                                                .contenedor_botones_envia{
                                                  padding: 3px;
                                                  margin: 3px;
                                                  margin-left: auto; /* Mover el botón a la derecha utilizando margen izquierdo automático */
                                                  font-size: 13px;
                                                }
                                              </style>


                                                  <div class="matematica_factura">
                                                    <div class="formas_pago_detalles_adicionales">
                                                      <div class="forma_pago">
                                                    <form class="" method="post" name="agregar_metodo_pago" id="agregar_metodo_pago" onsubmit="event.preventDefault(); sendData_agregar_metodo_pago();" >
                                                      <label for="formaPago">Formas Pago</label>
                                                      <select class="form-control select-custom clase_buscador_select_clientes" name="formaPago" id="formaPago">
                                                        <option value="01">SIN UTILIZACION DEL SISTEMA FINANCIERO</option>
                                                        <option value="15">COMPESACION DE DE DEUDAS</option>
                                                        <option value="16">TARJETA DE DEBITO</option>
                                                        <option value="17">DINERO ELECTRONICO</option>
                                                        <option value="18">TARJETA PREPAGO</option>
                                                        <option value="19">TARJETA DE CREDITO</option>
                                                        <option value="20">OTROS CON UTILIZACION DEL SISTEMA FINANCIERO</option>
                                                        <option value="21">ENDOSO DE TITULOS</option>
                                                      </select>
                                                        <label for="">Ingrese El Valor para este método de Pago</label>
                                                        <input type="number" class="custom-input-field" required id="cantidad_metodo_pago"  name="cantidad_metodo_pago" value="">
                                                      <div class="contenedor_botones_envia">
                                                        <input type="hidden" name="action" value="agregar_metodo_pago">
                                                        <input type="hidden" name="codigo_factura" value="<?php echo $codigo_factura ?>">
                                                        <button type="submit" class="btn btn-success btn-sm">Agregar Forma de Pago</button>
                                                      </div>
                                                      <div class="notificacion_agregar_metodo_pago">

                                                      </div>
                                                    </form>
                                                      </div>


                                                      <main role="main" class="container">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4>Resúmen de Método Pago</h4>
                                                                    <div class="table-responsive tabla_resultados_metodo_pago">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Cantidad</th>
                                                                                    <th>Código</th>
                                                                                    <th>Nombre</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                              <?php
                                                                                mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                                                 $query_lista = mysqli_query($conection,"SELECT * FROM formas_pago_facturacion WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigo_factura'
                                                                                 ORDER BY `formas_pago_facturacion`.`fecha` DESC ");
                                                                                     $result_lista= mysqli_num_rows($query_lista);
                                                                                   if ($result_lista > 0) {
                                                                                         while ($data_lista=mysqli_fetch_array($query_lista)) {

                                                                                            $id_pago = $data_lista['id'];

                                                                                           $codigo_formas_pago = $data_lista['formaPago'];
                                                                                            $cantidad_metodo_pago = $data_lista['cantidad_metodo_pago'];

                                                                                           if ($codigo_formas_pago == 01) {
                                                                                              $nombre_formas_pago = 'SIN UTILIZACION DEL SISTEMA FINANCIERO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 15) {
                                                                                              $nombre_formas_pago = 'COMPESACION DE DE DEUDAS';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 16) {
                                                                                              $nombre_formas_pago = 'TARJETA DE DEBITO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 17) {
                                                                                              $nombre_formas_pago = 'DINERO ELECTRONICO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 18) {
                                                                                              $nombre_formas_pago = 'TARJETA PREPAGO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 19) {
                                                                                              $nombre_formas_pago = 'TARJETA DE CREDITO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 20) {
                                                                                              $nombre_formas_pago = 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO';
                                                                                            }

                                                                                            if ($codigo_formas_pago == 21) {
                                                                                              $nombre_formas_pago = 'ENDOSO DE TITULOS';
                                                                                            }
                                                                                  ?>

                                                                                    <tr id="fila_pago<?php echo $id_pago ?>" >
                                                                                        <td>$<span><?php echo number_format($cantidad_metodo_pago,2) ?></span> </td>
                                                                                        <td><?php echo $codigo_formas_pago ?></td>
                                                                                        <td><?php echo $nombre_formas_pago ?></td>
                                                                                        <td class="eliminar_forma_pago" pago="<?php echo $id_pago ?>" ><i class="fas fa-trash-alt"></i></td>
                                                                                    </tr>

                                                                                  <?php
                                                                                  }
                                                                                  }
                                                                              ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </main>

                                                    </div>
                                                    <?php
                                                    $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                                    'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
                                                    SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                                    FROM `comprobantes`
                                                    WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
                                                    $data_lista_t=mysqli_fetch_array($query_lista_t);

                                                     ?>
                                                    <div class="rseumen_pago_factura">
                                                      <div class="tabla_resumen_factura">
                                                        <table>
                                                          <tr>
                                                            <td>Subtotal Base 0%</td>
                                                            <td>$0.00</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Subtotal Base Iva</td>
                                                            <td class="">$<span class="compra_total"><?php echo number_format($data_lista_t['compra_total'],2); ?></span> </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Subtotal no sujeto</td>
                                                            <td>$0.00</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Subtotal Exento</td>
                                                            <td>$0.00</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Subtotal</td>
                                                            <td class="">$<span class="compra_total"><?php echo number_format($data_lista_t['compra_total'],2); ?></span> </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Iva:</td>
                                                            <td class="">$<span class="iva_general"><?php echo number_format($data_lista_t['iva_general'],2); ?></span> </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Propina</td>
                                                            <td>$0.00</td>
                                                          </tr>
                                                          <tr>
                                                            <td>TOTAL A PAGAR</td>
                                                            <td class="">$<span class="total_pagar"><?php echo number_format($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'],2) ?></span> </td>
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
                                    <div id="styleSelector"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
          .circle-icon {
            border: 5px solid #dc3545; /* Color del borde del círculo */
            width: 150px; /* Aumenta el tamaño del círculo */
            height: 150px; /* Aumenta el tamaño del círculo */
            border-radius: 50%; /* Esto crea un círculo */
            margin: 0 auto; /* Centra el círculo horizontalmente */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px; /* Espaciado opcional entre el ícono y el texto */
          }
        </style>
        <button type="button" class="btn btn-primary" id="btn-ventana" name="button">Abrir Modals</button>

        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Contenido del modal -->
              <div class="modal-body text-center">
                <div class="circle-icon">
                  <i class="fas fa-exclamation-triangle text-danger" style="font-size: 72px;"></i>
                </div>
                <p style="font-size: 24px;">Se produjo un error en el servidor. Intente nuevamente más tarde.</p>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
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
        <script src="particulas/particles.js"></script>
        <script src="area_facturacion/busqueda_cliente.js"></script>
        <script src="area_facturacion/busqueda_producto.js"></script>
        <script src="area_facturacion/agregar_producto.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="area_facturacion/eliminar_item.js"></script>
        <script src="area_facturacion/agregar_metodo_pago.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/js/select2.min.js"></script>
        <script type="text/javascript">
        $(document).on('input', '.seleccionar_editar_input_cantidad', function() {
          // Obtén el valor actual del elemento input
          var valor = parseFloat($(this).val());
          var idItem = $(this).attr('idItem');

          if (valor < 0) {
            $(this).val("1");
          } else {
            var action = 'editar_cantidad_producto';
            $.ajax({
              type: "post",
              url: "area_facturacion/editar_cantidad_producto.php",
              data: { action: action, valor: valor, idItem: idItem },
              success: function(response) {
                console.log(response);
                if (response == 'error') {
                  $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
                } else {
                  var info = JSON.parse(response);
                  if (info.noticia == 'cero_no_valida') {
                    // Aquí puedes manejar el caso de cero no válido si es necesario
                  }
                  if (info.noticia == 'editado_correctamente') {
                    var ivaFormateado = parseFloat(info.iva_producto).toFixed(2);
                    $('.iva__' + info.idItem + ' ').val(ivaFormateado);
                    var subtotalFormateado = parseFloat(info.subtotal_frontend).toFixed(2);
                    $('.subtotal__' + info.idItem + ' ').html('$' + subtotalFormateado + ' ');

                    var action = 'actualizar_resumen';
                    var codigoFactura = $('#codigo_factura').val(); // Usar jQuery para obtener el valor
                    $.ajax({
                      url: 'area_facturacion/actualizar_resumen_pago.php',
                      type: 'POST',
                      async: true,
                      data: { action: action, codigoFactura: codigoFactura },
                      success: function(response) {
                        console.log(response);
                        var info = JSON.parse(response);
                        var compra_total = parseFloat(info.compra_total) || 0;
                        var iva_general = parseFloat(info.iva_general) || 0;
                        var descuento_total = parseFloat(info.descuento_total) || 0;

                        var resultado = compra_total + iva_general - descuento_total;
                        var resultadoFormateado = resultado.toFixed(2);
                        $(".compra_total").html(compra_total.toFixed(2));
                        $(".iva_general").html(iva_general.toFixed(2));
                        $(".total_pagar").html(resultadoFormateado);
                      },
                    });
                  }
                }
              },
            });
          }
        });

        </script>
       <script type="text/javascript">
       $(document).ready(function() {
           $('.clase_buscador_select_clientes').select2();
       });
       </script>
       <script type="text/javascript">
         (function() {
           $(function() {
             $('#btn-ventana').on('click', function() {
               $('#errorModal').modal();
             });
           });
         })();
       </script>
       <script type="text/javascript">

       </script>
    </body>
</html>
