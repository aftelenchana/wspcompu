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

       $codigo_producto = $_GET['p'];
       mysqli_query($conection,"SET lc_time_names = 'es_ES'");
       $query_lista = mysqli_query($conection,"SELECT *
          FROM producto_venta where estatus = 1 and idproducto=$codigo_producto"  );
       $data_producto=mysqli_fetch_array($query_lista);
       $nombre_producto = $data_producto['nombre'];
       $precio_producto = $data_producto['precio'];
       $descripcion = $data_producto['descripcion'];

       $url_upload_img_producto = $data_producto['url_upload_img'];
       $cantidad = $data_producto['cantidad'];
       $codigo_barras = $data_producto['codigo_barras'];
       $valor_unidad_final_con_impuestps = $data_producto['valor_unidad_final_con_impuestps'];
       $fecha_producto = $data_producto['fecha_producto'];
       $marca = $data_producto['marca'];
       $estado = $data_producto['estado'];
       $foto_producto = $data_producto['foto'];


       $url_upload_qr = $data_producto['url_upload_qr'];
       $qr_imagen = $data_producto['qr'];



  ?>




<!DOCTYPE html>
<html lang="es">
    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:14 GMT -->
    <head>
        <title>Producto <?php echo $nombre_producto; ?></title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
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
        <link rel="stylesheet" href="estilos/producto_view.css?v=3">
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
                                      <div class="col-md-12">
                                          <div class="card product-detail-page">
                                              <div class="card-block">

                                                  <div class="row">
                                                      <div class="col-lg-5">
                                                          <div class="port_details_all_img row">
                                                              <div class="col-lg-12 m-b-15">
                                                                  <div id="big_banner">
                                                                      <div class="port_big_img">
                                                                          <img class="img img-fluid"  src="<?php echo $data_producto['url_upload_img']?>/home/img/uploads/<?php echo $data_producto['foto']?>" alt="Big_ Details" />
                                                                      </div>

                                                                  </div>
                                                              </div>

                                                          </div>
                                                      </div>
                                                      <div class="col-lg-7 product-detail" id="product-detail">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <h4 class="pro-desc"><?php echo $nombre_producto ?></h4>
                                                                <span class="text-primary product-price">
                                                                    <i class="icofont icofont-cur-dollar"></i>
                                                                    $<?php echo number_format($precio_producto,2) ?>
                                                                </span>
                                                                <div class="mt-4 mb-4">
                                                                  <?php
                                                                   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

                                                                   ?>
                                                                    <p><strong>Descripción:</strong> <?php echo $descripcion ?></p>
                                                                    <p><strong>Cantidad:</strong> <?php echo $cantidad ?></p>
                                                                    <p><strong>Valor Con impuestos:</strong> <?php echo $valor_unidad_final_con_impuestps ?></p>
                                                                    <p><strong>Fecha:</strong> <?php echo $fecha_producto ?></p>
                                                                    <p><strong>Marca:</strong> <?php echo $marca ?></p>
                                                                    <p><strong>Estado:</strong> <?php echo $estado ?></p>
                                                                    <p><strong>URL Local:</strong> <a target="_blank" href="<?php echo $url ?>/producto?idp=<?php echo $codigo_producto ?>"><?php echo $url ?>/producto?idp=<?php echo $codigo_producto ?></a>  </p>
                                                                    <p><strong>URL General:</strong> <a target="_blank" href="https://guibis.com/producto?idp=<?php echo $codigo_producto ?>">https://guibis.com/producto?idp=<?php echo $codigo_producto ?></a> </p>
                                                                    <p><strong>URL Sistema Transporte:</strong>  <a target="_blank" href="https://transporte.guibis.com/idp=<?php echo $codigo_producto ?>">https://transporte.guibis.com/idp=<?php echo $codigo_producto ?></a> </p>
                                                                    <p><strong>URL Sistema Educativo:</strong>  <a target="_blank" href="https://educacion.guibis.com/idp=<?php echo $codigo_producto ?>">https://educacion.guibis.com/idp=<?php echo $codigo_producto ?></a> </p>
                                                                    <p><strong>Código Barras:</strong> <svg id="barcode"></svg></p>

                                                                      <?php
                                                                          $full_path = "img/qr/" . $qr_imagen;
                                                                          // Verifica si la imagen ya existe en el servidor.
                                                                          if (!file_exists($full_path)) {


                                                                              $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
                                                                              // Si no existe, genera el QR.
                                                                              $img_nombre = 'guibis' . md5(date('d-m-Y H:m:s'));
                                                                              $qr_img = $img_nombre . '.png';
                                                                              $contenido = md5(date('d-m-Y H:m:s') . $iduser); // Asegúrate de que $iduser está definido y es único para cada QR.

                                                                              // Ruta donde se guardará la nueva imagen QR.
                                                                              $direccion = 'img/qr/';
                                                                              $filename = $direccion . $qr_img;
                                                                              $tamanio = 7;
                                                                              $level = 'H';
                                                                              $frameSize = 5;

                                                                              // Asegúrate de que la biblioteca PHP QR Code está incluida.
                                                                              require 'QR/phpqrcode/qrlib.php';

                                                                              // Genera el QR y lo guarda en el archivo.
                                                                              QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);


                                                                                $query_insert = mysqli_query($conection,"UPDATE producto_venta SET url_upload_qr='$url',qr='$qr_img'
                                                                                  WHERE idproducto = '$codigo_producto'");

                                                                                  if ($query_insert) {
                                                                                    //echo "se insero";
                                                                                    // code...
                                                                                  }else {
                                                                                  //  echo "no se inserto";
                                                                                  }

                                                                              // Actualiza la ruta de la imagen para usar la nueva imagen QR generada.
                                                                              $full_path = $url_upload_qr . "/home/img/qr/" . $qr_img;
                                                                              echo '<p><strong>QR:</strong> <img src="' . $full_path . '" width="100px;" alt="QR Code"></p>';
                                                                          }else {

                                                                              echo '<p><strong>QR:</strong> <img src="' . $full_path . '" width="130px;" alt="QR Code"></p>';
                                                                          }
                                                                       ?>






                                                                </div>
                                                                <style media="screen">
                                                                .mt-4.mb-4 p {
                                                                    margin-top: 0.5rem; /* Ajusta este valor según necesites */
                                                                    margin-bottom: 0.5rem; /* Ajusta este valor según necesites */
                                                                    }

                                                                </style>

                                                                <button type="button" class="btn btn-primary boton_editar_producto">
                                                                        <i class="icofont icofont-edit f-16"></i>
                                                                        <span class="m-l-10">Editar Producto</span>
                                                                    </button>

                                                                    <button type="button" class="btn btn-success boton_aumentar">
                                                                        <i class="icofont icofont-plus f-16"></i>
                                                                        <span class="m-l-10">Aumentar Producto</span>
                                                                    </button>

                                                                    <button type="button" class="btn btn-info boton_disminuir">
                                                                        <i class="icofont icofont-minus f-16"></i>
                                                                        <span class="m-l-10">Disminuir Producto</span>
                                                                    </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                  </div>
                                                  <div class="row">
                                            <div class="col-lg-5">
                                              <div class="port_details_all_img row">

                                                <div class="upload-container">


                                                  <form action="" method="post" name="agregar_varias_imagenes" id="agregar_varias_imagenes" enctype="multipart/form-data" onsubmit="event.preventDefault(); sendData_agregar_varias_iamgenes();">
                                                    <div class="titulo_agrega_img_extras">
                                                      <div class="titulo_agre_imagens">
                                                            <h4>Imagenes Extras Externas</h4>
                                                      </div>
                                                    </div>
                                                    <div class="contenedor_imagenes_agregas_subidas">
                                                      <?php
                                                      $query_img_productos = mysqli_query($conection,"SELECT * FROM `img_producto` WHERE img_producto.idp  = '$codigo_producto' ORDER BY `img_producto`.`id`  DESC");
                                                          $result_lista_productos= mysqli_num_rows($query_img_productos);
                                                        if ($result_lista_productos > 0) {
                                                              while ($data_producto_img_productos=mysqli_fetch_array($query_img_productos)) {

                                                       ?>
                                                       <div class="contenddir_imagens_resultado_bd eliminar_imagen imagem_<?php echo $data_producto_img_productos['id'] ?>" imagen="<?php echo $data_producto_img_productos['id'] ?>" id="imagen<?php echo $data_producto_img_productos['id'] ?>" >
                                                          <img src="<?php echo $data_producto_img_productos['url'] ?>/home/img/uploads/<?php echo $data_producto_img_productos['img'] ?>" width="70px;" alt="">
                                                          <div class="icon-container">
                                                            <i class="fas fa-times"></i>
                                                          </div>
                                                         </div>
                                                       <?php
                                                       }
                                                       }
                                                   ?>
                                                    </div>
                                                    <div class="icone_agragr_imagenes">
                                                      <label for="upload-images" class="upload-icon">
                                                        <i class="fas fa-images"></i>
                                                        <span>Añadir imágenes</span>
                                                      </label>
                                                          <div id="image-preview-container"></div>
                                                    </div>
                                                    <input type="file" name="lista[]" required id="upload-images" multiple="multiple" accept="image/png, .jpeg, .jpg" style="display: none;" onchange="previewImages()">
                                                    <input type="hidden" name="producto" value="<?php echo $codigo_producto ?>">
                                                    <input type="hidden" name="action" value="agregar_varias_imagenes">
                                                    <button type="submit" class="btn btn-primary">Agregar Imagenes</button>
                                                    <div class="notificacion_agregar_imagenes">

                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-7 product-detail" id="product-detail">
                                              <div class="row">
                                                <div class="col-lg-12">
                                                  <div class="titulo_base_productos">
                                                    <h4>Bases para Publicación de Producto</h4>
                                                  </div>

                                                  <div class="contenedor_exlica">
                                                    <p>Para agregar un producto se tiene que agregar categorias,subcategorias, provincia y ciudad, con esto aparece automaticamente en todos los sistemas que estan asociados
                                                    con nuestos sistemas</p>
                                                  </div>

                                                  <?php

                                                  $categoria = $data_producto['categorias'];
                                                  $subcategoria = $data_producto['subcategorias'];
                                                  $provincia = $data_producto['provincia'];
                                                  $ciudad = $data_producto['ciudad'];

                                                   ?>
                                                  <div class="">
                                                    <form method="post" name="configurar_factores" id="configurar_factores"  onsubmit="event.preventDefault(); sendData_agregar_factores();">

                                                      <?php if (empty($categoria)): ?>
                                                        <div class="alert alert-warning background-warning">
                                                        <strong><?php echo $nombres ?>!</strong> No has conigurado la categoria y la subcategoria
                                                        </div>
                                                      <?php endif; ?>
                                                      <?php if (!empty($categoria)): ?>
                                                        <div class="alert alert-success background-success">
                                                        <strong><?php echo $nombres ?>!</strong> Ya tienes Configurado las categorias y subcategorias con código <?php echo $categoria ?>
                                                        </div>
                                                      <?php endif; ?>
                                                            <label for="precio" class="form-label">Configurar la Categoria</label>
                                                      <div class="row">
                                                          <div class="col">
                                                            <div class="form-group">
                                                              <label for="exampleFormControlSelect1">Categorias</label>
                                                              <select class="form-control" name="categorias" id="categorias" required>
                                                              </select>
                                                            </div>
                                                          </div>
                                                          <div class="col">
                                                            <div class="form-group">
                                                              <label for="exampleFormControlSelect1">Subcategoiras</label>
                                                              <select class="form-control" name="subcategorias" id="subcategorias" required>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>
                                                          <label for="precio" class="form-label">Configurar el Lugar</label>
                                                          <?php if (empty($provincia)): ?>
                                                            <div class="alert alert-warning background-warning">
                                                            <strong><?php echo $nombres ?>!</strong> No has conigurado el lugar
                                                            </div>
                                                          <?php endif; ?>
                                                          <?php if (!empty($provincia)): ?>
                                                            <div class="alert alert-success background-success">
                                                            <strong><?php echo $nombres ?>!</strong> Ya tienes Configurado el lugar
                                                            </div>
                                                          <?php endif; ?>
                                                        <div class="row">
                                                            <div class="col">
                                                              <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Provincia</label>
                                                                <select class="form-control" name="provincia" id="provincia" required>
                                                                </select>
                                                              </div>
                                                            </div>
                                                            <div class="col">
                                                              <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Ciudad</label>
                                                                <select class="form-control" name="ciudad" id="ciudad" required>
                                                                </select>
                                                              </div>
                                                            </div>
                                                          </div>

                                                        <button type="submit" class="btn btn-primary">Configurar Factores</button>
                                                        <input type="hidden" name="action" value="agregar_factores">
                                                        <input type="hidden" name="producto" value="<?php echo $codigo_producto ?>">
                                                        <div class="notificacion_agregar_producto">
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col" style="text-align: center;">
                                              <iframe width="90%" height="315" src="https://www.youtube.com/embed/b2rDMNGGgWw?si=gboWaGXIGVv5Bgpr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                            </div>
                                            <div class="col" style="text-align: center;">
                                              <iframe width="90%" height="315" src="https://www.youtube.com/embed/0fhow0seZkQ?si=g5IDlfnjOqsiN2CA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                            </div>

                                          </div>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="pcoded-inner-content">
                          <div class="main-body">
                              <div class="page-wrapper">


                                  <div class="page-body">
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <div class="card">
                                                  <div class="card-header table-card-header">
                                                      <h5>Inventario de <?php echo $nombre_producto ?></h5>
                                                  </div>
                                                  <div class="card-block">
                                                      <div class="dt-responsive table-responsive">
                                                          <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                              <thead>
                                                                  <tr>
                                                                    <th>Imagen</th>
                                                                    <th>Acción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Motivo</th>
                                                                    <th>Fecha</th>
                                                                    <th>Cantidad Estandar</th>
                                                                    <th>Detalles</th>
                                                                    <th>Archivo Generado</th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>
                                                                <?php
                                                                //PAGINADOR

                                                                mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                                $query_lista = mysqli_query($conection,"SELECT producto_venta.foto,inventario.accion,producto_venta.idproducto,inventario.motivo,DATE_FORMAT(inventario.fecha, '%W  %d de %b %Y %H:%m') as 'fecha_inventario',
                                                                inventario.cantidad_new,inventario.detalles_extras,inventario.cantidad,inventario.codigo_ingreso,inventario.url_upload FROM inventario
                                                          INNER JOIN producto_venta ON producto_venta.idproducto = inventario.idproducto
                                                          WHERE producto_venta.idproducto = '$codigo_producto'  ORDER BY inventario.id DESC");
                                                                $result_lista= mysqli_num_rows($query_lista);
                                                                  if ($result_lista > 0) {
                                                                        while ($data_producto=mysqli_fetch_array($query_lista)) {
                                                                          $foto = 'img/uploads/'.$data_producto['foto'];
                                                                 ?>
                                                                 <tr>
                                                                   <td class="" data-titulo="Imagen"><img src="<?php echo "$foto"; ?>" width="100px;" alt=""></td>
                                                                   <td class="" data-titulo="Acción"><?php echo $data_producto['accion']; ?></td>
                                                                   <td class="" data-titulo="Cantidad"><?php echo $data_producto['cantidad']; ?></td>
                                                                   <td class="" data-titulo="Motivo"><?php echo $data_producto['motivo']; ?>  </td>
                                                                   <td class="" data-titulo="Fecha"><?php echo mb_strtoupper( $data_producto['fecha_inventario']); ?>  </td>
                                                                   <td class="" data-titulo="Cantidad Estandar"><?php echo $data_producto['cantidad_new']; ?>  </td>
                                                                   <td class="" data-titulo="Detalles">
                                                                     <?php if ($data_producto['detalles_extras'] == 'TICKET'): ?>
                                                                       Nota de Venta

                                                                     <?php endif; ?>
                                                                     <?php if ($data_producto['detalles_extras'] == 'FACTURA'): ?>
                                                                       Factura Electrónica

                                                                     <?php endif; ?>

                                                                   </td>
                                                                   <td class="" data-titulo="Archivo Generado">
                                                                     <?php if ($data_producto['accion'] == 'DISMINUIR'): ?>
                                                                       <?php if ($data_producto['detalles_extras'] == 'TICKET'): ?>
                                                                             <a download href="<?php echo $data_producto['url_upload'] ?>/home/facturacion/facturacionphp/comprobantes/tikets/<?php echo $data_producto['codigo_ingreso'];?>.pdf"><img src="img/reacciones/pdf.png" width="45px" alt=""></a>

                                                                       <?php endif; ?>

                                                                     <?php endif; ?>


                                                                    </td>

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


        <div class="modal fade" id="modal_editar_producto" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Producto <span class="producto_a_editar"></span></h5>
        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" name="editar_producto" id="editar_producto" onsubmit="event.preventDefault(); sendData_editar_producto();">
          <div class="img_edit_noticia text-center">

          </div>
          <div class="mb-3">
            <label for="exampleFormControlFile1" class="form-label">Agregue una imagen</label>
            <input type="file" class="form-control" name="foto" accept="image/png, .jpeg, .jpg" id="exampleFormControlFile1">
          </div>

          <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
            <input type="text" maxlength="120" name="nombre_producto" class="form-control" id="nombre_producto" placeholder="Nombre del Producto">
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="precio" class="form-label">Precio (SIN IMPUESTOS)</label>
                <input oninput="calculo_precio_final_input()" type="number" step="0.00001" class="form-control" name="precio" id="precio" placeholder="Ingrese el precio">
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

          <div class="mb-3">
            <label for="codigo_barras" class="form-label">Código de Barras</label>
            <input type="text" maxlength="120" name="codigo_barras" class="form-control" id="codigo_barras" placeholder="Código de Barras">
          </div>

          <p>Información de los impuestos</p>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="codigos_impuestos" class="form-label">Elija la Tarifa IVA</label>
                <select class="form-control" name="codigos_impuestos" id="codigos_impuestos">
                  <option value="2">IVA</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="elejir_tarifa_iva" class="form-label">Elija la Tarifa IVA</label>
                <select oninput="calculo_precio_final_input()" class="form-control" name="elejir_tarifa_iva" id="elejir_tarifa_iva">
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
            <label for="marca_codigo" class="form-label">Agregue Marca o Código</label>
            <input type="text" maxlength="120" name="marca" class="form-control" id="marca_codigo" placeholder="Marca o Código">
          </div>

          <div class="mb-3">
            <label for="cantidad" class="form-label">Agregue Un proveedor</label>
            <select class="form-control " name="proveedor" id="proveedor">
              <?php
              $query_proveedor = mysqli_query($conection, "SELECT * FROM proveedor WHERE  proveedor.iduser= '$iduser'   AND proveedor.estatus = 1");
              while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                echo '<option  value="' . $proveedor['id'] . '">' . $proveedor['razon_social'] . '/ ' . $proveedor['identificacion'] . '</option>';
              }
              ?>
              </select>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Agregue una descripción</label>
            <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion" rows="3"></textarea>
          </div>
          <small class="form-text text-muted">Este producto no se sube a la nube de <a href="https://guibis.com">guibis.com</a>.</small>

          <div class="modal-footer">
            <input type="hidden" name="action" value="editar_producto">
            <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $codigo_producto ?>">
             <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>Editar Producto</button>
          </div>
          <div class="notificacion_editar_producto">

          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_aumentar" tabindex="-1" aria-labelledby="modalAumentarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAumentarLabel">Aumentar Producto en el inventario <?php echo $nombre_producto ?></h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
            </div>
            <div class="modal-body">
                <form method="post" name="aumentar_producto" id="aumentar_producto" onsubmit="event.preventDefault(); sendData_aumentar();">
                    <div class="mb-3">
                        <label for="tipo_aumento" class="form-label">Tipo de Aumento</label>
                        <select class="form-select" name="motivo_entrada" id="tipo_aumento">
                            <option value="Mercaderia Nueva">Mercaderia Nueva</option>
                            <option value="Devolución">Devolución</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad_aumentar" class="form-label">Ingrese la cantidad del Producto</label>
                        <input type="number" class="form-control" name="cantidad_aumentar" required id="cantidad_aumentar" placeholder="Ingrese la Cantidad a Aumentar">
                    </div>
                    <div class="mb-3">
                        <label for="detalles_extras" class="form-label">Ingrese una Descripción</label>
                        <textarea class="form-control" name="detalles_extras" id="detalles_extras" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="aumentar_producto" required>
                        <input type="hidden" name="idproducto" value="<?php echo $codigo_producto ?>">
                         <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Aumentar Producto</button>
                    </div>
                    <div class="noticia_aumentar_cantidad"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_disminuir" tabindex="-1" aria-labelledby="modalDisminuirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDisminuirLabel">Disminuir el Producto en el inventario de <?php echo $nombre_producto?></h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
            </div>
            <div class="modal-body">
                <form method="post" name="disminuir_producto" id="disminuir_producto" onsubmit="event.preventDefault(); sendData_disminuir();">
                    <div class="mb-3">
                        <label for="motivo_disminucion" class="form-label">Motivo de disminución</label>
                        <select class="form-select" name="motivo_disminucion" id="motivo_disminucion">
                            <option value="Venta">Venta</option>
                            <option value="Caducidad">Caducidad</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad_disminuir" class="form-label">Ingrese la cantidad del Producto a disminuir</label>
                        <input type="number" class="form-control" name="cantidad_disminuir" required id="cantidad_disminuir" placeholder="Ingrese la Cantidad a Disminuir">
                    </div>
                    <div class="mb-3">
                        <label for="detalles_extras" class="form-label">Ingrese una Descripción</label>
                        <textarea class="form-control" name="detalles_extras" id="detalles_extras" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="disminuir_produc" required>
                        <input type="hidden" name="idproducto" value="<?php echo $codigo_producto ?>">
                        <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-minus"></i> Disminuir Producto</button>
                    </div>
                    <div class="noticia_disminuir_produtto"></div>
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
<script type="text/javascript" src="jquery_producto/inventario.js"></script>
<script src="area_facturacion/busqueda_secuencia.js"></script>
<script type="text/javascript" src="jquery_producto/producto.js"></script>
<script type="text/javascript" src="jquery_administrativo/agregar_varias_imagenes.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
  JsBarcode("#barcode", "<?php echo $codigo_barras; ?>", {
      format: "CODE128", // Asegúrate de que este formato sea compatible con tu código
      lineColor: "#0aa",
      width: 2,
      height: 30,
      displayValue: true
  });
});

</script>


<script>
$(document).ready(function() {
    $('#tabla_productos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            url: "/home/guibis/data-table.json"
        },
        order: []
    });
});

</script>

<script>
    function previewImages() {
      var previewContainer = document.getElementById('image-preview-container');
      previewContainer.innerHTML = ''; // Limpiar vista previa anterior
      var files = document.getElementById('upload-images').files;

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function(event) {
          var div = document.createElement('div');
          div.className = 'image-preview';
          div.innerHTML = '<img src="' + event.target.result + '" alt="Vista previa de imagen"><span class="remove-image" onclick="removePreviewImage(this)">&times;</span>';
          previewContainer.appendChild(div);
        };

        reader.readAsDataURL(file);
      }
    }

    function removePreviewImage(span) {
      var div = span.parentElement;
      div.parentElement.removeChild(div);
    }
  </script>
</div>
<script type="text/javascript">

              $("document").ready(function(){
              $( "#categorias" ).load( "server/datos.php" );
              $("#categorias").change(function(){
                  var id =   $("#categorias").val();
                  $.get("server/datos1.php", {id:id})
                  .done(function(data){
                  $("#subcategorias" ).html(data);
                 })
              })
              })

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
</html>
