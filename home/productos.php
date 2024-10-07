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

       $farmacia = $_GET['farmacias'];

  ?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Mis Productos para la Farmacia <?php echo $farmacia ?></title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
        <link rel="stylesheet" href="https://guibis.com/home/estilos/modal.css">


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
              <style media="screen">
                #tabla_productos td {
                white-space: normal; /* Permite saltos de línea */
                word-wrap: break-word; /* Asegura que las palabras largas no desborden la celda */
                }

                #tabla_productos td:nth-child(0) { /* Asegúrate de que el índice sea correcto */
                 max-width: 100px; /* Ajusta el ancho máximo según tus necesidades */
                }
                </style>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Productos Creados para la farmacia <?php echo $farmacia ?></h5>  <button type="button" class="btn btn-primary" id="boton_agregar_producto" name="button">Agregar Producto <i class="fas fa-plus"></i></button>

                                              </div>
                                              <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                  <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                      <tr>
                                                        <th>Actividad</th>
                                                        <th>Código</th>
                                                        <th>Imagen</th>
                                                        <th>Nombre Comercial</th>
                                                        <th>Precio</th>
                                                        <th>Concentración</th>
                                                        <th>Cantidad</th>
                                                        <th>Farmacos o Génericos</th>
                                                        <th>Presentación</th>
                                                        <th>Via de Administración</th>
                                                        <th>Codigo de Barra</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>

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


        <div class="modal fade" id="modal_agregar_producto" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl"> <!-- Aquí puedes cambiar 'modal-lg' a 'modal-xl' para un tamaño aún más grande -->
            <div class="modal-content">

              <div class="modal-header header_guibis" style="background-color: #263238;">
                <h5 class="modal-title" id="proveedorModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body">

                <form action=""  id="add_producto" >

                  <div class="mb-3">
                    <label class="label-guibis-sm">Nombre Comercial</label>
                    <input type="text" maxlength="120" name="nombre_producto" class="form-control input-guibis-sm"  id="nombre_producto" placeholder="Nombre Comercial">
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Precio (SIN IMPUESTOS)</label>
                        <input oninput="calculo_precio_final_input()" type="number" step="0.00001" class="form-control input-guibis-sm"  name="precio" id="precio_sin_impuestos" placeholder="Ingrese el precio">
                        <small class="form-text text-muted">Precio con el cual se calcula el precio final</small>
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Precio Costo</label>
                        <input type="number" step="0.00001" class="form-control input-guibis-sm"  name="precio_costo" id="precio_costo" placeholder="Ingrese el precio">
                        <small class="form-text text-muted">Precio costo es el valor base no al público</small>
                      </div>
                    </div>
                  </div>

                  <p>Información de los impuestos</p>
                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Elija la Tarifa IVA</label>
                        <select class="form-control input-guibis-sm"  name="codigos_impuestos" id="codigos_impuestos">
                          <option value="2">IVA</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Elija la Tarifa IVA</label>
                        <select oninput="calculo_precio_final_input()" class="form-control input-guibis-sm"  name="elejir_tarifa_iva" id="elejir_tarifa_iva">
                          <option value="4">15%</option>
                          <option value="0">0%</option>
                          <option value="6">No Objeto de Impuestos</option>
                          <option value="7">Excento Iva</option>
                          <option value="3">14%</option>
                          <option value="5">5%</option>
                          <option value="8">Iva Diferenciado</option>
                          <option value="10">13%</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Precio Final del Producto</label>
                        <input type="number" step="0.001"  oninput="calculo_precio_final_input()" class="form-control input-guibis-sm"  name="resultado_calculo"  id="resultado_calculo" placeholder="Precio Final">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm">Agregue Cantidad</label>
                        <input type="number" class="form-control input-guibis-sm"  name="cantidad" id="cantidad" placeholder="Ingrese la cantidad">
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="label-guibis-sm">Agregue Imagenes</label>
                    <input type="file" class="form-control input-guibis-sm"  name="lista[]"  multiple id="lista"  accept="image/png, .jpeg, .jpg" >
                  </div>

                  <style media="screen">
                    #miniaturas_productos img{
                      width: 10%;
                      display: inline-block;

                    }
                  </style>

                  <div class="row">
                     <span class="conte_img_pr" id="salida_imagenes_contenedor">
                       <output id="miniaturas_productos"></output>
                      </span>
                   </div>

                   <div class="mb-3">
                     <label class="label-guibis-sm">Subir Video del Evento</label>
                     <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <span class="input-group-text">Subir Video</span>
                         </div>
                         <div class="custom-file">
                           <input type="file" class="custom-file-input" accept="video/*" name="video_explicativo" id="inputGroupFile01">
                           <label class="custom-file-label" for="inputGroupFile01">Agregar Video</label>
                         </div>
                       </div>
                   </div>
                   <div class="row">
                     <div class="col">
                       <div class="mb-3">
                         <label class="label-guibis-sm">Concentración</label>
                         <input type="text" maxlength="120" name="marca" class="form-control input-guibis-sm"  id="marca" placeholder="Concentración">
                       </div>

                     </div>
                   </div>

                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label class="label-guibis-sm">Categorias</label>
                          <select class="form-control input-guibis-sm"  name="categorias" id="categorias" required>
                            <?php
                            $query_dato = mysqli_query($conection,"SELECT * FROM categorias
                              WHERE (categorias.iduser ='$iduser' || categorias.iduser ='279') AND categorias.estatus = '1'
                           ORDER BY `categorias`.`id` ASC
                            ");
                            while ($dato = mysqli_fetch_array($query_dato)) {
                                echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';
                            }
                             ?>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label class="label-guibis-sm">Subcategoiras</label>
                          <select class="form-control input-guibis-sm"  name="subcategorias" id="subcategorias" required>
                            <?php
                            $query_dato = mysqli_query($conection,"SELECT * FROM subcategorias WHERE id_c = '1'");
                            while ($dato = mysqli_fetch_array($query_dato)) {
                                echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';
                            }

                             ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="label-guibis-sm">Provincia</label>
                            <select class="form-control input-guibis-sm"  name="provincia" id="provincia2" required>

                            </select>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="label-guibis-sm">Ciudad</label>
                            <select class="form-control input-guibis-sm"  name="ciudad" id="ciudad2" required>
                              <?php
                              $query_lugar = mysqli_query($conection,"SELECT * FROM ciudad WHERE id_p = '4' ");
                              while ($lugar = mysqli_fetch_array($query_lugar)) {
                                  echo '<option value="'.$lugar['id'].'">'.$lugar['nombre'].'</option>';
                              }
                               ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="form-check form-switch">
                              <input class="form-check-input" name="visibilidadExterna" type="checkbox" checked id="customSwitchExterno" onchange="cambiarEstatus(this, 'externa');">
                              <label class="form-check-label" for="customSwitchExterno">Visibilidad del Producto Externo <span class="alerta_estado_visibilidad_externa" ><div class="alert alert-success" role="alert">El producto se visualiza en la tienda digital!</div></span> </label>
                          </div>

                        </div>
                        <div class="col">
                          <div class="form-check form-switch">
                              <input class="form-check-input" name="visibilidadInterna" type="checkbox" checked id="customSwitchInterno" onchange="cambiarEstatus(this, 'interna');">
                              <label class="form-check-label" for="customSwitchInterno">Visibilidad del Producto Interno <span class="alerta_estado_visibilidad_interna" ><div class="alert alert-success" role="alert">El producto se visualiza en el área de productos interna!</div></span> </label>
                          </div>

                        </div>
                      </div>
                  <div class="mb-3">
                    <label class="label-guibis-sm">Farmacos o Genéricos </label>
                    <textarea class="form-control input-guibis-sm"  placeholder="Farmacos o Genéricos"  name="descripcion" id="descripcion" rows="3"></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="label-guibis-sm">Presentación </i></label>
                    <textarea class="form-control input-guibis-sm"  placeholder="Presentación"  name="descripcion_tienda" id="descripcion_tienda" rows="3"></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="label-guibis-sm">Via de Administración</label>
                    <input type="text"  name="via_administracion" class="form-control input-guibis-sm"  id="via_administracion" placeholder="Via de Administración">
                  </div>

                    <div class="modal-footer">
                      <input type="hidden" name="action" value="agregar_producto">
                      <input type="hidden" name="codigo_farmacia" id="codigo_farmacia" value="<?php echo $farmacia ?>">
                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                      <button type="submit" class="btn btn-primary">Agregar Producto <i class="fas fa-plus"></i></button>
                      <button type="button"  class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>

                    </div>
                  </form>
                  <div class="alerta_nuevoproducto"></div>
                  <div class="boton_compartir_producto_nuevo">

                  </div>
              </div>
            </div>
          </div>
        </div>




        <div class="modal fade" id="modal_editar_producto" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                 <div class="modal-dialog  modal-xl">
                   <div class="modal-content">
                     <div class="modal-header header_guibis" style="background-color: #263238;">
                       <h5 class="modal-title" id="exampleModalLongTitle">Editar Producto <span class="producto_a_editar"></span>
                         <button class="btn btn-primary" id="botonCompartir_editar">
                            <i class="fa fa-share-alt"></i> Compartir
                        </button></h5>
                       <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close"> <i class="fas fa-times-circle"></i> </button>
                     </div>
                     <div class="modal-body">
                     <form  id="update_producto" >
                         <div class="img_edit_noticia text-center">

                         </div>
                         <div class="mb-3">
                           <label class="label-guibis-sm">Agregue una imagen</label>
                           <input type="file" class="form-control " name="foto" accept="image/png, .jpeg, .jpg" id="exampleFormControlFile1">
                         </div>

                         <div class="mb-3">
                           <label class="label-guibis-sm">Nombre Comercial</label>
                           <input type="text" maxlength="120" name="nombre_producto" class="form-control nombre_producto_edit" id="nombre_producto_upload" placeholder="Nombre Comercial">
                         </div>
                         <p>Información de los impuestos</p>
                         <div class="row">
                           <div class="col">
                             <div class="mb-3">
                               <label class="label-guibis-sm">Elija la Tarifa IVA</label>
                               <select class="form-control codigos_impuestos_edit" name="codigos_impuestos" id="codigos_impuestos">
                                 <option value="2">IVA</option>
                               </select>
                             </div>
                           </div>
                           <div class="col">
                             <div class="mb-3">
                               <label class="label-guibis-sm">Elija la Tarifa IVA</label>
                               <select  class="form-control elejir_tarifa_iva_upload" name="elejir_tarifa_iva" id="elejir_tarifa_iva_update">
                                 <option value="4">15%</option>
                                 <option value="0">0%</option>
                                 <option value="6">No Objeto de Impuestos</option>
                                 <option value="7">Excento Iva</option>
                                 <option value="3">14%</option>
                                 <option value="5">5%</option>
                                 <option value="8">Iva Diferenciado</option>
                                 <option value="10">13%</option>
                               </select>
                             </div>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col">
                             <div class="mb-3">
                               <label class="label-guibis-sm">Precio (SIN IMPUESTOS)</label>
                               <input type="number" step="0.00001" class="form-control precio_edit precio_sin_impuestos_upload" name="precio" id="precio_sin_impuestos_update" placeholder="Ingrese el precio">
                               <small class="form-text text-muted">Precio con el cual se calcula el precio final</small>
                             </div>
                           </div>
                           <div class="col">
                             <div class="mb-3">
                               <label class="label-guibis-sm">Precio Costo</label>
                               <input type="number" step="0.00001" class="form-control precio_costo_upload" name="precio_costo" id="precio_costo" placeholder="Ingrese el precio">
                               <small class="form-text text-muted">Precio costo es el valor base no al público</small>
                             </div>
                           </div>
                         </div>


                         <div class="mb-3">
                           <label class="label-guibis-sm">Precio Final del Producto</label>
                           <input type="number"   step="0.00001" class="form-control resultado_calculo_edit resultado_calculo_upload" name="resultado_calculo"  id="resultado_calculo_update" placeholder="Precio Final">
                         </div>

                         <div class="row">
                             <div class="col">
                               <div class="form-group">
                                 <label class="label-guibis-sm">Categorias</label>
                                 <select class="form-control input-guibis-sm"  name="categorias" id="categorias" required>
                                   <?php
                                   $query_dato = mysqli_query($conection,"SELECT * FROM categorias");
                                   while ($dato = mysqli_fetch_array($query_dato)) {
                                       echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';
                                   }
                                    ?>
                                 </select>
                               </div>
                             </div>
                             <div class="col">
                               <div class="form-group">
                                 <label class="label-guibis-sm">Subcategoiras</label>
                                 <select class="form-control input-guibis-sm"  name="subcategorias" id="subcategorias" required>

                                   <?php
                                   $query_dato = mysqli_query($conection,"SELECT * FROM subcategorias");
                                   while ($dato = mysqli_fetch_array($query_dato)) {
                                       echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';
                                   }

                                    ?>
                                 </select>
                               </div>
                             </div>
                           </div>

                           <div class="row">
                               <div class="col">
                                 <div class="form-group">
                                   <label class="label-guibis-sm">Provincia</label>
                                   <select class="form-control input-guibis-sm"  name="provincia" id="provincia" required>
                                     <?php
                                     $query_lugar = mysqli_query($conection,"SELECT * FROM provincia ORDER BY nombre ASC");
                                     while ($lugar = mysqli_fetch_array($query_lugar)) {
                                         echo '<option value="'.$lugar['id'].'">'.$lugar['nombre'].'</option>';
                                     }
                                      ?>
                                   </select>
                                 </div>
                               </div>
                               <div class="col">
                                 <div class="form-group">
                                   <label class="label-guibis-sm">Ciudad</label>
                                   <select class="form-control input-guibis-sm"  name="ciudad" id="ciudad" required>
                                     <?php
                                     $query_lugar = mysqli_query($conection,"SELECT * FROM ciudad ");
                                     while ($lugar = mysqli_fetch_array($query_lugar)) {
                                         echo '<option value="'.$lugar['id'].'">'.$lugar['nombre'].'</option>';
                                     }
                                      ?>
                                   </select>
                                 </div>
                               </div>
                             </div>


                             <div class="form-check form-switch">
                                 <input class="form-check-input" name="visibilidadExterna" type="checkbox" checked id="customSwitchExterno" onchange="cambiarEstatus(this, 'externa');">
                                 <label class="form-check-label" for="customSwitchExterno">Visibilidad del Producto Externo <span class="alerta_estado_visibilidad_externa" ><div class="alert alert-success" role="alert">El producto se visualiza en la tienda digital!</div></span> </label>
                             </div>

                             <div class="form-check form-switch">
                                 <input class="form-check-input" name="visibilidadInterna" type="checkbox" checked id="customSwitchInterno" onchange="cambiarEstatus(this, 'interna');">
                                 <label class="form-check-label" for="customSwitchInterno">Visibilidad del Producto Interno <span class="alerta_estado_visibilidad_interna" ><div class="alert alert-success" role="alert">El producto se visualiza en el área de productos interna!</div></span> </label>
                             </div>



                         <div class="mb-3">
                           <label class="label-guibis-sm">Agregue Cantidad</label>
                           <input type="number" class="form-control cantidad_edit" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad">
                         </div>

                         <div class="mb-3">
                           <label class="label-guibis-sm">Concentración</label>
                           <input type="text" maxlength="120" name="marca" class="form-control input-guibis-sm"  id="marca_codigo_edit" placeholder="Concentración">
                         </div>


                         <div class="mb-3">
                           <label class="label-guibis-sm">Presentacion</label>
                           <input type="text" maxlength="120" name="descripcion_tienda" class="form-control input-guibis-sm"  id="presentacion_edit" placeholder="Concentración">
                         </div>

                         <div class="mb-3">
                           <label class="label-guibis-sm">Via de Administración</label>
                           <input type="text" maxlength="120" name="via_administracion" class="form-control input-guibis-sm"  id="via_administracion_update" placeholder="Via de Administración">
                         </div>

                         <div class="mb-3">
                           <label class="label-guibis-sm">Farmacos o Genericos</label>
                           <textarea class="form-control descripcion_edit" maxlength="120" required name="descripcion" id="descripcion_edit" rows="3"></textarea>
                         </div>

                         <div class="modal-footer">
                           <input type="hidden" name="action" value="editar_producto">
                           <input type="hidden" name="url_producto" id="url_producto" value="">
                           <input type="hidden" name="idproducto" id="idproducto" value="">
                            <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar</button>
                           <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>Editar Producto</button>
                         </div>
                       </form>
                       <div class="notificacion_editar_producto">

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
        <script type="text/javascript" src="jquery_administrativo/producto.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
          <script src="cookies/productos.js"></script>
          <script src="jquery_administrativo/productos.js?v=3"></script>
          <script src="jquery_administrativo/proveedor_producto.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>

          <script type="text/javascript">
          (function() {
            $(function() {
              $('#boton_agregar_proveedor').on('click', function() {
                $('#modal_agregar_proveedor').modal();
              });
            });
          })();
          </script>

          <script type="text/javascript">
              function handleFileSelect(evt) {
                  var files = evt.target.files;
                  for (var i = 0, f; f = files[i]; i++) {
                    if (!f.type.match('image.*')) {
                      continue;
                    }

                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                      return function(e) {
                        var span = document.createElement('span');
                        span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                        document.getElementById('miniaturas_productos').insertBefore(span, null);
                      };
                    })(f);
                    reader.readAsDataURL(f);
                  }
                }
                  document.getElementById('lista').addEventListener('change', handleFileSelect, false);
              </script>


    </body>
</html>
