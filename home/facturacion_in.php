<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }
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
        <link rel="stylesheet" type="text/css" href="estilos/facturacion.css?v=2" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="particulas/estilos.css">
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


$fecha=date('d/m/Y');

$query_cantidad = mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_cantidad = mysqli_fetch_array($query_cantidad);
$documentos_electronicos = $result_cantidad['documentos_electronicos'];
$estableciminento_f = $result_cantidad['estableciminento_f'];
$punto_emision_f = $result_cantidad['punto_emision_f'];
$nombres_user = $result_cantidad['nombres'];
$direccion_user = $result_cantidad['direccion'];




 $query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' ORDER BY fecha DESC");
  $result_secuencia = mysqli_fetch_array($query_secuencia);
  if ($result_secuencia) {
    $secuencial = $result_secuencia['codigo_factura'];
    $secuencial = $secuencial +1;
    // code...
  }else {
    $secuencial =1;
  }


           ?>
           <div class="pcoded-wrapper">
               <div class="pcoded-content">
                   <div class="pcoded-inner-content">
                       <div class="main-body">
                           <div class="page-wrapper">
                               <div class="page-body m-t-50">
                                 <div class="row">
                                   <div class="col">
                                     <div class="card bg-c-yellow update-card">
                                       <div class="card-footer " style="text-align: center;">
                                         <p class="text-white m-b-0 resultado_busqueda_secuencia_documento_l">Codigo Interno: <?php echo $codigo_factura ?>
                                           <?php if (!empty($fecha_caducidad_firma)): ?>
                                             - Fecha de Caducidad de Firma: <?php echo $fecha_caducidad_firma ?>
                                           <?php endif; ?>
                                         </p>
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                     <div id="particles-js"></div>



                                     <div class="col-xl-12 col-md-18 reservado_query">
                                       <div class="conte_principal_bloque_superior">

                                         <div class="contenedor_interno_bloque1">
                                             <label for="">Elija El Documento Electrónico</label>
                                             <select class="select-custom tipo_documento_electronico_elejir"name="documento_electronico" id="documento_electronico">
                                               <option id="permiso_facturacion"  value="Facturación">Facturación </option>
                                               <option value="Proforma">Proforma </option>
                                               <option value="Nota de Venta Autorizada">Nota de Venta Autorizada</option>
                                               <option value="Tiket Venta">Tiket Venta</option>
                                             </select>
                                         </div>

                                         <div class="contenedor_interno_bloque1">
                                           <div class="info_matriz">
                                             <label for="">Sucursal</label>
                                             <select class="select-custom" name="sucursal_facturacion" id="sucursal_facturacion">
                                               <?php
                                               $secuencial = str_pad($data_sucursal['secuencial'], 9, "0", STR_PAD_LEFT);
                                                $query_sucursal = mysqli_query($conection, "SELECT * FROM  sucursales  WHERE  sucursales.iduser ='$iduser'  AND sucursales.estatus = '1' ");
                                                 while ($data_sucursal = mysqli_fetch_array($query_sucursal)) {
                                                 $estableciminento = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
                                                 $punto_emision = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);
                                                 echo '<option  value="'.$data_sucursal['id'].'">('.$data_sucursal['direccion_sucursal'].')- '.$estableciminento.'-'.$punto_emision.'</option>';
                                               }
                                                ?>
                                             </select>
                                           </div>

                                         </div>
                                         <div class="contenedor_interno_bloque2">
                                           <div class="razon_social_cliente_info">
                                             <label for="">Cliente</label>
                                             <select class="select-custom clase_buscador_select_clientes" id="search_usuarios"  name="">

                                               <option value="0">99999999999- Consumidor Final</option>
                                               <option value="agregar_nuevo">Agregar Nuevo</option>
                                               <?php
                                               $query_clientes = mysqli_query($conection,"SELECT * FROM clientes WHERE  clientes.iduser= '$iduser'   AND clientes.estatus = 1 ORDER BY clientes.id DESC");
                                               while ($clientes = mysqli_fetch_array($query_clientes)) {
                                                 echo '<option  value="'.$clientes['id'].'">'.$clientes['nombres'].'/ '.$clientes['identificacion'].'/ '.$clientes['mail'].'/ '.$clientes['id'].'</option>';
                                               }
                                                ?>
                                             </select>
                                             <div class="resultado_elejir_agregar_nuevo">
                                               <label for="">Razon Social</label>
                                               <input type="text" name="razon_social_cliente" id="razon_social_cliente" class="custom-input-field" value="Consumidor Final" placeholder="Razon Social">
                                             </div>

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
                                                 <input type="" class="custom-input-field" id="email_reeptor"  name="email_cliente" value="<?php echo $email_user ?>">
                                               </div>
                                               <div class="telefono_cliente">
                                                 <label for="">Celular</label>
                                                 <input type="" class="custom-input-field" id="celular_receptor"  name="telefono_cliente" value="99999999">
                                                 <input type="hidden" name="idcliente" id="idcliente"  value="">
                                               </div>
                                             </div>

                                           </div>
                                           <div class="numero_guia_remision">
                                             <label for="">Identificación</label>
                                             <input type="" name="identificacion_cliente" id="identificacion_cliente"  class="custom-input-field"   value="9999999999999">
                                             <label for="">Tipo Identificación</label>
                                             <select class="select-custom " id="tipo_identificacion"  name="tipo_identificacion">
                                               <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                               <option value="04">RUC</option>
                                               <option value="05">CEDULA</option>
                                               <option value="06">PASAPORTE</option>
                                               <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                             </select>
                                           </div>

                                         </div>


                                       </div>
                                     </div>

                                     <div class="col-xl-12 col-md-18 reservado_query">
                                       <div class="conte_principal_bloque_inferior">

                                         <div class="contenedor_bloque_inferior_1">
                                           <div class="info_producto">
                                             <select class="select-custom clase_buscador_select_clientes" id="busqueda_producto"   name="">
                                                <option value="buscar_op">Buscar Producto</option>
                                                <option value="add_producto_sin_registrar">Agregar Producto sin Registrar</option>
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
                                           <p>%Desc</p>
                                           <p>Descuento</p>
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

                                       <style media="screen">
                                       .accordion-content {
                                          display: flex;
                                          align-items: center; /* Alinea los elementos verticalmente en el centro */
                                          justify-content: space-between; /* Separa los elementos equitativamente */
                                        }
                                        .accordion-desc > p,
                                              .accordion-desc > input {
                                                  flex: 1; /* Ocupar espacio disponible equitativamente */
                                                  margin: 5px; /* Agregar un poco de espacio alrededor de los elementos */
                                              }

                                       </style>
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
                                                      $clase_nota_extra1 = $data_lista['detalle_extra'];
                                                      $clase_nota_extra2 = $data_lista['detalle_extra2'];
                                                      if (!empty($clase_nota_extra1)) {
                                                        $clase_nota_extra1 = '#FFC300';
                                                      }
                                                      if (!empty($clase_nota_extra2)) {
                                                        $clase_nota_extra2 = '#FFC300';
                                                      }
                                                      //codigo para saber si se puede editar o no

                                                      $id_producto = $data_lista['id_producto'];
                                                      if (empty($id_producto) || $id_producto =='0') {
                                                        $estado_input_descuento_cantidad = 'readonly';
                                                      }else {
                                                          $estado_input_descuento_cantidad = '';
                                                      }
                                                      //CODIGO PARA COLOREAR EL INPUT QUE TIENE DESCUENTO
                                                      $descuento_alx_fernndo            = $data_lista['descuento'];

                                                      if (!empty($descuento_alx_fernndo)) {
                                                        $clase_descuento = '#DAF7A6 ';
                                                      }else {
                                                          $clase_descuento = '';
                                                      }

                                             ?>
                                               <div class="bloque_input_informacion_producto" id="fila<?php echo $data_lista['id']  ?>">
                                                 <p class="nombre_<?php echo $data_lista['id']  ?>" style="display: inline-block;width: 19%;"><?php echo $data_lista['nombre_producto'] ?></p>
                                                 <input <?php echo $estado_input_descuento_cantidad ?> idItem="<?php echo $data_lista['id']  ?>" porcentaje_descuento="<?php echo ($data_lista['porcentaje_descuento']) ?>"  class="cantidad_<?php echo $data_lista['id']  ?> seleccionar_editar_input_cantidad" type="number" placeholder="Cant.." name="" value="<?php echo ($data_lista['cantidad_producto']) ?>">
                                                 <input readonly class="precio__<?php echo $data_lista['id']?> respuesta_editar_precio" type="text" placeholder="Prec." name="" value="<?php echo number_format($data_lista['valor_unidad'],2 )?>">
                                                 <input  style="background:<?php echo $clase_descuento ?>" <?php echo $estado_input_descuento_cantidad ?> idItem="<?php echo $data_lista['id']  ?>"  required cantidad_producto = "<?php echo ($data_lista['cantidad_producto']) ?>" class="porcentaje_descuento_<?= $data_lista['id'] ?> respuesta_editar_descuento"  type="number" placeholder="%Des." name="" value="<?php echo ($data_lista['porcentaje_descuento']) ?>">
                                                 <input style="background:<?php echo $clase_descuento ?>" readonly idItem="<?php echo $data_lista['id']  ?>"  required cantidad_producto = "<?php echo ($data_lista['cantidad_producto']) ?>" class="cantidad_descuento_<?= $data_lista['id'] ?> respuesta_cantidad_descuento"  type="number" placeholder="Descuento" name="" value="<?php echo ($data_lista['descuento']) ?>">
                                                 <input readonly class="iva__<?php echo $data_lista['id']?> respuesta_editar_iva" type="text" placeholder="Iva" name="" value="<?php echo number_format($data_lista['iva_frontend'],2) ?>">
                                                 <p class="subtotal__<?php echo $data_lista['id']?> respuesta_editar_subtotal" style="display: inline-block;width: 16%;text-align: center;">$<?php echo round($data_lista['subtotal_frontend'],2) ?></p>
                                                 <p item="<?php echo $data_lista['id']  ?>"  class="nombre_<?php echo $data_lista['id']  ?> eliminar_item" style="display: inline-block;width: 3%;"><i class="fas fa-trash-alt"></i> </p>
                                             </div>


                                             <div id="accordion" class="conte_todo_notas_extras<?php echo $data_lista['id']  ?>"  role="tablist" aria-multiselectable="true" style="width: 100%;">
                                                 <div class="accordion-panel">
                                                     <div class="accordion-heading" role="tab" >
                                                             <a class="accordion-msg clase_dar_click_icono" id="contendeor_icono<?php echo $data_lista['id'];?>" estado="cerrado" codigo_nota = "<?php echo $data_lista['id']?>" id="contendeir_icono_agregar_nota" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $data_lista['id']  ?>"
                                                                aria-expanded="true" aria-controls="collapseOne<?php echo $data_lista['id']  ?>" style="color: #fff;">
                                                                <i class="far fa-plus-square"></i>
                                                             </a>
                                                     </div>
                                                     <div id="collapseOne<?php echo $data_lista['id']  ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                         <div class="accordion-content accordion-desc">
                                                            <span style="color: #fff;">Nota Extra 1</span>
                                                           <input style="background:<?php echo $clase_nota_extra1 ?>" codigo_nota="<?php echo $data_lista['id']?>" id="nota_1<?php echo $data_lista['id']?>" nivel_nota="nota_1"  class="nota_extra1<?php echo $data_lista['id']  ?> seleccionar_nota_extra" onchange="mostrarValor(this);"
                                                            type="text" placeholder="Nota Extra" name="nota_extra" value="<?php echo ($data_lista['detalle_extra']) ?>">
                                                           <span style="color: #fff;">Nota Extra 2</span>
                                                          <input style="background:<?php echo $clase_nota_extra2 ?>" codigo_nota="<?php echo $data_lista['id']?>"  id="nota_2<?php echo $data_lista['id']?>" nivel_nota="nota_2"  class="nota_extra2<?php echo $data_lista['id']  ?> seleccionar_nota_extra" onchange="mostrarValor(this);"
                                                          type="text" placeholder="Nota Extra" name="nota_extra" value="<?php echo ($data_lista['detalle_extra2']) ?>">
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <hr style="background: #FF5733;border: 1px solid #FF5733;">
                                             <?php
                                             }
                                             }
                                         ?>

                                       </div>
                                       <?php

                                       $query_nota = mysqli_query($conection, "SELECT * FROM notas_extras_facturacion   WHERE iduser = '$iduser'
                                       AND codigo_factura = '$codigo_factura'");
                                       $data_nota = mysqli_fetch_array($query_nota);

                                       if ($data_nota) {
                                         $nota_embrio = $data_nota['texto'];

                                       }else {
                                         $nota_embrio = '';
                                       }




                                        ?>



                                         <div class="matematica_factura">
                                           <div class="formas_pago_detalles_adicionales">

                                             <div class="forma_pago">
                                           <form class="" method="post" name="agregar_nota_extra" id="agregar_nota_extra" onsubmit="event.preventDefault(); sendData_agregar_nota_extra();" >
                                             <label for="formaPago">Nota Extra Factura</label>
                                               <textarea class="custom-input-field" class="nota_extra_ddd"  name="nota_extra" rows="4" cols="20"><?php echo $nota_embrio ?></textarea>
                                             <div class="contenedor_botones_envia">
                                               <input type="hidden" name="action" value="agregar_nota_extra">
                                               <input type="hidden" name="codigo_factura" value="<?php echo $codigo_factura ?>">
                                               <button type="submit" class="btn btn-success btn-sm">Agregar Nota Extra</button>
                                             </div>
                                             <div class="notificacion_agregar_nota_extra">

                                             </div>
                                           </form>
                                             </div>

                                             <?php
                                             $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                             'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
                                             SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                             FROM `comprobantes`
                                             WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
                                             $data_lista_t=mysqli_fetch_array($query_lista_t);

                                              ?>

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
                                               <input type="number" class="custom-input-field" step="0.0000001" required id="cantidad_metodo_pago"  name="cantidad_metodo_pago" value="<?php echo number_format($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'],2) ?>">
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

                                           //sacar informacion general de todo

                                           $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                           'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
                                           SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                           FROM `comprobantes`
                                           WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
                                           $data_lista_t=mysqli_fetch_array($query_lista_t);

                                           $descuento_total = $data_lista_t['descuento_total'];


                                                  //codigo para sacr el 12 %
                                           $query_lista_12 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                           'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
                                           SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                           FROM `comprobantes`
                                           WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '2'");
                                           $data_lista_12=mysqli_fetch_array($query_lista_12);

                                           //codigo para sacr el 12 %
                                           $compra_total_iva = $data_lista_12['compra_total']-$data_lista_12['descuento_total'];

                                           //codigo para sacr el 0%

                                           $query_lista_base_0 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                           'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
                                           SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                           FROM `comprobantes`
                                           WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '0'");
                                           $data_lista_t_base_0=mysqli_fetch_array($query_lista_base_0);

                                            $compra_total_base_cero = $data_lista_t_base_0['compra_total']-$data_lista_t_base_0['descuento_total'];


                                            //codigo para sacr el no_objeto

                                            $query_lista_no_objeto = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                            'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
                                            SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                            FROM `comprobantes`
                                            WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '7'");
                                            $data_lista_no_objeto =mysqli_fetch_array($query_lista_no_objeto);

                                             $compra_total_no_objeto = $data_lista_no_objeto['compra_total']-$data_lista_no_objeto['descuento_total'];

                                             //codigo para sacar excento_iva

                                             $query_lista_excento_iva = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
                                             'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
                                             SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
                                             FROM `comprobantes`
                                             WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '6'");
                                             $data_lista_excento_iva =mysqli_fetch_array($query_lista_excento_iva);

                                              $compra_total_excento_iva = $data_lista_excento_iva['compra_total']-$data_lista_excento_iva['descuento_total'];

                                              $compra_general = $compra_total_iva + $compra_total_base_cero + $compra_total_no_objeto + $compra_total_excento_iva;



                                            ?>
                                           <div class="rseumen_pago_factura">
                                             <div class="tabla_resumen_factura">
                                               <table>
                                                 <tr>
                                                   <td>Sin Iva</td>
                                                   <td>$<span class="compra_total_base_cero" ><?php echo number_format($compra_total_base_cero,2) ?></span> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>Con Iva</td>
                                                   <td class="">$<span class="compra_total_iva"><?php echo number_format($compra_total_iva,2); ?></span> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>No.Obj.Im.</td>
                                                   <td>$<span class="no_objeto_alex" ><?php echo number_format($compra_total_no_objeto,2) ?></span> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>Exento de Iva</td>
                                                   <td>$<span class="exento_alex" ><?php echo number_format($compra_total_excento_iva,2) ?></span> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>Subtotal</td>
                                                   <td class="">$<span class="subtotal_alex"><?php echo number_format($compra_general,2); ?></span> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>Descuento</td>
                                                   <td class="">$<span class="descuento_alex"><?php echo number_format($descuento_total,2); ?></span> </td>
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
                                                   <td>TOTAL</td>
                                                   <td class="">$<span id="total_pagar" class="total_pagar"><?php echo number_format(($compra_general+$data_lista_t['iva_general']),2) ?></span> </td>
                                                 </tr>
                                               </table>
                                             </div>
                                           </div>
                                         </div>
                                         <div class="botones_accion_sistema_facturacion">
                                             <button type="button" class="btn btn-primary btn-sm guardar_documento" name="button">
                                                 <i class="fas fa-folder"></i> Guardar Documento
                                             </button>
                                             <button type="button" class="btn btn-danger btn-sm previzualizar_pdf" name="button">
                                                 <i class="fas fa-file-pdf"></i> Pre Vizualizar PDF
                                             </button>
                                             <button type="button" class="btn btn-info btn-sm generar_documento" name="button">
                                                 <i class="fas fa-play-circle"></i> Generar Documento
                                             </button>
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



<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Contenido del modal -->
      <div class="modal-body text-center">
        <div class="circle-icon">
          <i class="fas fa-exclamation-triangle text-danger" style="font-size: 72px;"></i>
        </div>
        <div class="informacion_error_interno_genesis">
          <p class="informacion_error_sub" style="font-size: 24px;">Se produjo un error en el servidor. Intente nuevamente más tarde.</p>

        </div>
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="modal_agregar_producto_sin_registrar" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proveedorModalLabel">Agregar Producto sin Registrar</h5>
        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
      </div>
      <div class="modal-body">
        <form method="post" name="agregar_producto_sin_registrar" id="agregar_producto_sin_registrar" onsubmit="event.preventDefault(); sendData_agregar_sin_registrar();">

          <div class="mb-3">
              <label for="nombre_producto_2" class="form-label">Nombre del Producto:</label>
              <input type="text" class="form-control form-control-sm" id="nombre_producto_2" name="nombre_producto" placeholder="Ingrese nombre del producto">
          </div>
          <div class="mb-3">
              <label for="descripcion_producto_2" class="form-label">Descripción del Producto: <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" id="descripcion_producto_2" name="descripcion_producto" placeholder="Ingrese una Descripción como Desea en la factura" required>
          </div>

          <div class="row">
            <div class="col">
              <div class="mb-3">
                  <label for="cantidad_producto_2" class="form-label">Cantidad: <span class="text-danger">*</span></label>
                  <input oninput="calculo_precio_final_input()" type="number" class="form-control form-control-sm" step="0.001" id="cantidad_producto_2" name="cantidad_producto" placeholder="Ingrese la cantidad de producto" required>
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                  <label for="valor_unidad_2" class="form-label">Precio de Venta por Unidad: <span class="text-danger">*</span></label>
                  <input oninput="calculo_precio_final_input()" type="number" class="form-control form-control-sm" name="valor_unidad" id="valor_unidad_2" step="0.0000001" placeholder="Ingrese el valor por unidad" required>
                  <input  type="hidden" name="action" value="agregar_cantidad">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="mb-3">
                  <label for="codigos_impuestos_2" class="form-label">Códigos de los impuestos:</label>
                  <select oninput="calculo_precio_final_input()" class="form-control form-control-sm" name="codigos_impuestos" id="codigos_impuestos_2">
                      <option value="2">IVA</option>
                      <option value="3">ICE</option>
                      <option value="5">IRBPNR</option>
                  </select>
              </div>

            </div>
            <div class="col">
              <div class="mb-3">
                  <label for="tipo_ambiente_2" class="form-label">Tarifa IVA:</label>
                  <select oninput="calculo_precio_final_input()" class="form-control form-control-sm" name="tipo_ambiente" id="tipo_ambiente_2">
                      <option value="2">CON IVA</option>
                      <option value="0">SIN IVA</option>
                      <option value="6">Exento de IVA </option>
                      <option value="7">No Objeto de Impuesto </option>
                  </select>
              </div>
            </div>


          </div>

          <div class="mb-3">
              <label for="valor_unidad_2" class="form-label">Precio Final: <span class="text-danger">*</span></label>
              <input type="number" class="form-control form-control-sm" readonly name="precio_final_final" id="precio_final_final" step="0.0000001" placeholder="Ingrese el valor del Precio Final" required>
              <input type="hidden" name="action" value="agregar_cantidad">
          </div>
        </div>

              <input type="hidden" class="form-control form-control-sm" id="id_producto_2" name="id_producto_2" value="0" readonly>

          <div class="modal-footer">
            <input type="hidden" name="codigo_factura" value="<?php echo $codigo_factura ?>">
            <input type="hidden" name="action" value="agregar_produto_sin_registrar">
            <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
            <button type="submit" class="btn btn-primary">Agregar Producto Sin Registrar <i class="fas fa-plus"></i></button>

          </div>
          <div class="alerta_agregar_producto_sin_registrar"></div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_pago" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel">Información General</h5>

            </div>
            <div class="modal-body">
                <form class="" method="post" name="generar_documento" id="generar_documento">

                  <div class="noti_auto_pago">

                  </div>

                    <div class="notificacion_resumen_pago_paquete">

                    </div>



                    <div class="modal-footer">
                        <input type="hidden" name="action" value="generar_dicumento">
                        <input type="hidden" name="codigo_factura" value="">

                    </div>
                    <div class="notificacion_facturacion"></div>
                </form>
            </div>
        </div>
    </div>
</div>








<div class="modal fade" id="modal_informacion_documento" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proveedorModalLabel">Información General</h5>
        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
      </div>
      <div class="modal-body">

          <form  class="" method="post" name="generar_documento" id="generar_documento" onsubmit="event.preventDefault(); sendData_generar_dcocumento();">
          <main role="main" class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                        <style media="screen">
                        .tabla_socumentos_degenrd tr, th {
                            color: #FF5733 !important; */
                            text-align: center;
                            }
                        </style>
                          <table class="table table-bordered tabla_socumentos_degenrd">
                              <thead>
                                  <tr>
                                      <th>Documento</th>
                                      <th>Cliente</th>
                                      <th>Identificación</th>
                                      <th>Email</th>
                                      <th>Total</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="documento_a_generar"></td>
                                      <td class="client_a_generar"></td>
                                      <td class="identi_a_generar"></td>
                                      <td class="email_a_generar"></td>
                                      <td class="total_a_generar"></td>
                                  </tr>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </main>

            <div class="modal-footer">
              <input type="hidden" name="action" value="generar_dicumento">
              <input type="hidden" name="codigo_factura" value="<?php echo $codigo_factura ?>">
              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
              <button type="submit" class="btn btn-primary">Generar Documento</button>
            </div>
            <div class="notificacion_facturacion"></div>
            <div class="barra_proceso_facturacion">

            </div>
          </form>
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
  <script src="area_facturacion/acciones_botones.js"></script>
  <script src="area_facturacion/eliminar_item.js"></script>
  <script src="area_facturacion/generar_documento.js"></script>
  <script src="area_facturacion/agregar_metodo_pago.js"></script>
  <script src="area_facturacion/agregar_nota_extra.js"></script>
  <script src="area_facturacion/notas_extras.js"></script>
  <script src="area_facturacion/recordar_sucursal.js"></script>
  <script src="area_facturacion/descuento.js"></script>
  <script src="jquery_pago/plan.js"></script>
  <script src="area_facturacion/calculo_precio_final_producto_sin_registrar.js"></script>
  <script src="permisos/permisos_accion.js"></script>
  <script src="area_facturacion/editar_cantidad_producto.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/js/select2.min.js"></script>
  <script type="text/javascript">


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
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    particlesJS.load('particles-js', 'particles.json', function() {
      console.log('Particles.js loaded!');
    });
  </script>
</body>
</html>
