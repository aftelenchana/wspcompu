<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }



  ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Mi Perfil</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin="" />

    </head>

    <body>

     <?php
     require 'scripts/cabezera_general.php';
     ?>

              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">

                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="cover-profile">
                                              <div class="profile-bg-img">
                                                  <img class="profile-bg-img img-fluid" src="files/assets/images/user-profile/bg-img1.jpg" alt="bg-img" />
                                                  <div class="card-block user-info">
                                                      <div class="col-md-12">
                                                          <div class="media-left  ">
                                                            <a href="#" class="profile-image " >
                                                                <img class="user-img img-radius " src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo; ?>" width="50%" alt="user-img" />
                                                            </a>

                                                            <style media="screen">
                                                            .profile-image img{
                                                              max-width: 400px;
                                                            }

                                                            </style>

                                                          </div>
                                                          <div class="media-body row">
                                                              <div class="col-lg-12">
                                                                  <div class="user-title">
                                                                      <h2><?php echo $nombres ?> <?php echo $_SESSION['rol_interno'] ?></h2>
                                                                  </div>
                                                              </div>
                                                              <div>

                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>


                                  <div class="modal fade" id="modal_editar_foto_perfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Editar Foto Perfil</h5>
                                          <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                        </div>
                                        <div class="modal-body">
                                          <form method="post" name="add_form_add_logo_empresa" id="add_form_add_logo_empresa" onsubmit="event.preventDefault(); sendDataedit_add_logo_empresa();">
                                            <div class="resultado_imagen_upload text-center">
                                              <img class="img-fluid" style="width: 180px;" src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo; ?>" alt="<?php echo $img_logo ?>">
                                            </div>
                                            <div class="mb-3 row">
                                              <label class="col-md-2 col-form-label text-md-end" for="foto">Foto Perfil</label>
                                              <div class="col-md-10">
                                                <input class="" type="file" name="foto" id="foto" accept="image/png,image/jpeg">
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <input type="hidden" name="action" value="add_foto_logo_empresarial" required>
                                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                              <button type="submit" class="btn btn-primary">Guardar Imagen</button>
                                            </div>
                                            <div class="notificacion_imagen_perfil"></div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>


                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="tab-header card">
                                              <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                                  <li class="nav-item">
                                                      <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Información Personal</a>
                                                      <div class="slide"></div>
                                                  </li>


                                              </ul>
                                          </div>

                                          <div class="tab-content">
                                              <div class="tab-pane active" id="personal" role="tabpanel">
                                                  <div class="card">
                                                      <div class="card-header">
                                                          <h5 class="card-header-text">Sobre Mi</h5>
                                                          <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                              <i class="icofont icofont-edit"></i>
                                                          </button>
                                                      </div>
                                                      <div class="card-block">
                                                          <div class="view-info">
                                                              <div class="row">
                                                                  <div class="col-lg-12">
                                                                      <div class="general-info">
                                                                          <div class="row">
                                                                              <div class="col-lg-12 col-xl-6">
                                                                                  <div class="table-responsive">
                                                                                      <table class="table m-0">
                                                                                          <tbody>
                                                                                              <tr>
                                                                                                  <th scope="row"  nombresh= "<?php echo $nombres ?>">
                                                                                                    Nombres
                                                                                                  </th>
                                                                                                  <td class="result_nombres"  ><?php echo $nombres ?></td>
                                                                                              </tr>

                                                                                              <tr>
                                                                                                  <th scope="row"   identificacion= "<?php echo $identificacion ?>">
                                                                                                      Identificación
                                                                                                  </th>
                                                                                                  <td class="result_identidicacion"><?php echo $identificacion ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row">
                                                                                                      Fecha Registro
                                                                                                  </th>
                                                                                                  <td><?php echo $fecha ?></td>
                                                                                              </tr>

                                                                                              <?php if (!empty($fecha_caducidad_firma)): ?>
                                                                                                <tr>
                                                                                                    <th scope="row">
                                                                                                      Caducidad de la Firma Electrónica
                                                                                                    </th>
                                                                                                    <td><?php echo $fecha_caducidad_firma ?></td>
                                                                                                </tr>

                                                                                              <?php endif; ?>


                                                                                              <tr>
                                                                                                  <th scope="row">
                                                                                                      Email
                                                                                                  </th>
                                                                                                  <td><?php echo $email_user ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row">
                                                                                                    ID
                                                                                                  </th>
                                                                                                  <td><?php echo $id_recursos_humanos ?></td>
                                                                                              </tr>

                                                                                              <tr>
                                                                                                  <th scope="row">
                                                                                                      Ciudad
                                                                                                  </th>
                                                                                                  <td><?php echo $ciudad_user ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row">
                                                                                                      Contraseña
                                                                                                  </th>
                                                                                                  <td>      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cambio_password">
                                                                                                          Cambiar de Contraseña
                                                                                                        </button></td>
                                                                                              </tr>
                                                                                          </tbody>
                                                                                      </table>
                                                                                  </div>
                                                                              </div>



                                                                              <!-- Modal -->
                                                                              <div class="modal fade" id="cambio_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                  <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                      <h5 class="modal-title" id="exampleModalLabel">Cambio de Contraseña</h5>
                                                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                      </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                      <form style="text-align: center;" class="" method="post" name="cambiar_contrasna" id="cambiar_contrasna" onsubmit="event.preventDefault(); sendDataedit_cambio_password_fc();">
                                                                                        <div class="form-group">
                                                                                          <label for="exampleInputPassword1">Ingresa tu atual Contraseña</label>
                                                                                          <input type="password" name="contrasena_actual" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                          <label for="exampleInputPassword1">Ingresa tu nueva contraseña</label>
                                                                                          <input type="password" name="new_contrasena" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                          <label for="exampleInputPassword1">Ingresa de nuevo contraseña</label>
                                                                                          <input type="password" name="new_contrasena_dos" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                                                        </div>

                                                                                        <div class="modal-footer">
                                                                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                                                          <button type="submit" class="btn btn-primary">Cambiar de Contraseña</button>
                                                                                        </div>
                                                                                        <div class="notificacion_contyrasena">

                                                                                        </div>
                                                                                      </form>
                                                                                    </div>

                                                                                  </div>
                                                                                </div>
                                                                              </div>




                                                                              <div class="col-lg-12 col-xl-6">
                                                                                  <div class="table-responsive">
                                                                                      <table class="table">
                                                                                          <tbody>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_telefono" telefono= "<?php echo $telefono ?>">
                                                                                                      Teléfono
                                                                                                  </th>
                                                                                                  <td class="result_telefono">
                                                                                                      <?php echo $telefono_user ?>
                                                                                                  </td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_celular"  celular= "<?php echo $celular_user ?>">
                                                                                                      Celular
                                                                                                  </th>
                                                                                                  <td class="rst_celular"><?php echo $celular_user ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_direccion" direccion= "<?php echo $direccion ?>">
                                                                                                      Dirección
                                                                                                  </th>
                                                                                                  <td class="result_direccion"><?php echo $direccion ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_whatsapp" whatsapp = "<?php echo $whatsapp ?>">
                                                                                                      Whatsapp
                                                                                                  </th>
                                                                                                  <td class="result_wsp"><?php echo $whatsapp ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_facebook" facebook = "<?php echo $facebook ?>">
                                                                                                      Facebook
                                                                                                  </th>
                                                                                                  <td class="result_facebook"><?php echo $facebook ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_instagram" instagram = "<?php echo $instagram ?>">
                                                                                                      Instagram
                                                                                                  </th>
                                                                                                  <td class="result_insta"><?php echo $instagram ?></td>
                                                                                              </tr>
                                                                                              <tr>
                                                                                                  <th scope="row" class="editar_pagina_web" pagina_web = "<?php echo $pagina_web ?>">
                                                                                                      Pagina Web
                                                                                                  </th>
                                                                                                  <td class="result_pagina_web"><a class="out_pagina_web" href="#!"><?php echo $pagina_web ?></a></td>
                                                                                              </tr>
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
                                                  <div class="row">
                                                      <div class="col-lg-12">
                                                          <div class="card">
                                                            <form   method="post" name="add_descripcion" id="add_descripcion" onsubmit="event.preventDefault(); sendData_descripcion();">
                                                              <div class="card-header">
                                                                  <h5 class="card-header-text">Descripción</h5>
                                                                  <button id="edit-info-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                                      <i class="icofont icofont-edit"></i>
                                                                  </button>
                                                              </div>
                                                              <div class="card-block user-desc">
                                                                  <div class="view-desc">
                                                      <textarea class="descripcion_int" name="descripcion" style="width: 100%;"><?php echo $descripcion_usuerio ?></textarea>

                                                                  </div>
                                                                  <div class="edit-desc">
                                                                      <div class="text-center">
                                                                        <input type="hidden" name="action" value="agregar_descripcion">
                                                                          <button type="submit" class="btn btn-primary">Guardar Descripción</button>
                                                                      </div>
                                                                  </div>
                                                                  <div class="notificacion_agregar_descripcion">

                                                                  </div>
                                                              </div>
                                                            </form>
                                                          </div>
                                                      </div>
                                                  </div>





                                              </div>

                                              <div class="tab-pane" id="binfo" role="tabpanel">
                                                  <div class="card">
                                                      <div class="card-header">
                                                          <h5 class="card-header-text">User Services</h5>
                                                      </div>
                                                      <div class="card-block">
                                                          <div class="row">
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-success business-info services m-b-20">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">
                                                                                      Shivani Hero
                                                                                  </h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-danger business-info services">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">
                                                                                      Dress and Sarees
                                                                                  </h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-info business-info services">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">
                                                                                      Shivani Auto Port
                                                                                  </h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-warning business-info services">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">
                                                                                      Hair stylist
                                                                                  </h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-danger business-info services">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">BMW India</h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="card b-l-success business-info services">
                                                                      <div class="card-header">
                                                                          <div class="service-header">
                                                                              <a href="#">
                                                                                  <h5 class="card-header-text">
                                                                                      Shivani Hero
                                                                                  </h5>
                                                                              </a>
                                                                          </div>
                                                                          <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                                          </span>
                                                                          <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                              <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="card-block">
                                                                          <div class="row">
                                                                              <div class="col-sm-12">
                                                                                  <p class="task-detail">
                                                                                      Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.
                                                                                  </p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-lg-12">
                                                          <div class="card">
                                                              <div class="card-header">
                                                                  <h5 class="card-header-text">Profit</h5>
                                                              </div>
                                                              <div class="card-block">
                                                                  <div id="main" style="height: 300px; width: 100%;"></div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="tab-pane" id="contacts" role="tabpanel">
                                                  <div class="row">
                                                      <div class="col-xl-3">
                                                          <div class="card">
                                                              <div class="card-header contact-user">
                                                                  <img class="img-radius img-40" src="files/assets/images/avatar-4.jpg" alt="contact-user" />
                                                                  <h5 class="m-l-10">John Doe</h5>
                                                              </div>
                                                              <div class="card-block">
                                                                  <ul class="list-group list-contacts">
                                                                      <li class="list-group-item active"><a href="#">All Contacts</a></li>
                                                                      <li class="list-group-item"><a href="#">Recent Contacts</a></li>
                                                                      <li class="list-group-item"><a href="#">Favourite Contacts</a></li>
                                                                  </ul>
                                                              </div>
                                                              <div class="card-block groups-contact">
                                                                  <h4>Groups</h4>
                                                                  <ul class="list-group">
                                                                      <li class="list-group-item justify-content-between">
                                                                          Project
                                                                          <span class="badge badge-primary badge-pill">30</span>
                                                                      </li>
                                                                      <li class="list-group-item justify-content-between">
                                                                          Notes
                                                                          <span class="badge badge-success badge-pill">20</span>
                                                                      </li>
                                                                      <li class="list-group-item justify-content-between">
                                                                          Activity
                                                                          <span class="badge badge-info badge-pill">100</span>
                                                                      </li>
                                                                      <li class="list-group-item justify-content-between">
                                                                          Schedule
                                                                          <span class="badge badge-danger badge-pill">50</span>
                                                                      </li>
                                                                  </ul>
                                                              </div>
                                                          </div>
                                                          <div class="card">
                                                              <div class="card-header">
                                                                  <h4 class="card-title">Contacts<span class="f-15"> (100)</span></h4>
                                                              </div>
                                                              <div class="card-block">
                                                                  <div class="connection-list">
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-1.jpg"
                                                                              alt="f-1"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Airi Satou"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-2.jpg"
                                                                              alt="f-2"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Angelica Ramos"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-3.jpg"
                                                                              alt="f-3"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Ashton Cox"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-4.jpg"
                                                                              alt="f-4"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Cara Stevens"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-5.jpg"
                                                                              alt="f-5"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Garrett Winters"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-1.jpg"
                                                                              alt="f-6"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Cedric Kelly"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-3.jpg"
                                                                              alt="f-7"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Brielle Williamson"
                                                                          />
                                                                      </a>
                                                                      <a href="#">
                                                                          <img
                                                                              class="img-fluid img-radius"
                                                                              src="files/assets/images/user-profile/follower/f-5.jpg"
                                                                              alt="f-8"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-original-title="Jena Gaines"
                                                                          />
                                                                      </a>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-xl-9">
                                                          <div class="row">
                                                              <div class="col-sm-12">
                                                                  <div class="card">
                                                                      <div class="card-header">
                                                                          <h5 class="card-header-text">Contacts</h5>
                                                                      </div>
                                                                      <div class="card-block contact-details">
                                                                          <div class="data_table_main table-responsive dt-responsive">
                                                                              <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                                                  <thead>
                                                                                      <tr>
                                                                                          <th>Name</th>
                                                                                          <th>Email</th>
                                                                                          <th>Mobileno.</th>
                                                                                          <th>Favourite</th>
                                                                                          <th>Action</th>
                                                                                      </tr>
                                                                                  </thead>
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="3150535200030271565c50585d1f525e5c"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="55343736646766153238343c397b363a38"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="1677747527242556717b777f7a3875797b"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="c4a5a6a7f5f6f784a3a9a5ada8eaa7aba9"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="95f4f7f6a4a7a6d5f2f8f4fcf9bbf6faf8"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7617141547444536111b171f1a5815191b"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7f1e1d1c4e4d4c3f18121e1613511c1012"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="9bfaf9f8aaa9a8dbfcf6faf2f7b5f8f4f6"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="a0c1c2c3919293e0c7cdc1c9cc8ec3cfcd"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="6a0b08095b58592a0d070b030644090507"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="c1a0a3a2f0f3f281a6aca0a8adefa2aeac"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="debfbcbdefeced9eb9b3bfb7b2f0bdb1b3"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="ef8e8d8cdedddcaf88828e8683c18c8082"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="2746454416151467404a464e4b0944484a"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="e1808382d0d3d2a1868c80888dcf828e8c"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="fb9a9998cac9c8bb9c969a9297d5989496"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="d3b2b1b0e2e1e093b4beb2babffdb0bcbe"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="f0919293c1c2c3b0979d91999cde939f9d"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="9efffcfdafacaddef9f3fff7f2b0fdf1f3"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="c8a9aaabf9fafb88afa5a9a1a4e6aba7a5"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="1372717022212053747e727a7f3d707c7e"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="fe9f9c9dcfcccdbe99939f9792d09d9193"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7213101143404132151f131b1e5c111d1f"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="1071727321222350777d71797c3e737f7d"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="adcccfce9c9f9eedcac0ccc4c183cec2c0"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="f7969594c6c5c4b7909a969e9bd994989a"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7e1f1c1d4f4c4d3e19131f1712501d1113"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="83e2e1e0b2b1b0c3e4eee2eaefade0ecee"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="08696a6b393a3b486f65696164266b6765"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="f2939091c3c0c1b2959f939b9edc919d9f"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="99f8fbfaa8abaad9fef4f8f0f5b7faf6f4"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="dcbdbebfedeeef9cbbb1bdb5b0f2bfb3b1"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7c1d1e1f4d4e4f3c1b111d1510521f1311"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="6302010052515023040e020a0f4d000c0e"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="2041424311121360474d41494c0e434f4d"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="1677747527242556717b777f7a3875797b"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="6b0a09085a59582b0c060a020745080406"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="a9c8cbca989b9ae9cec4c8c0c587cac6c4"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="7a1b18194b48493a1d171b131654191517"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="2b4a49481a19186b4c464a424705484446"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="fa9b9899cbc8c9ba9d979b9396d4999597"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="8beae9e8bab9b8cbece6eae2e7a5e8e4e6"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="abcac9c89a9998ebccc6cac2c785c8c4c6"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="9efffcfdafacaddef9f3fff7f2b0fdf1f3"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="87e6e5e4b6b5b4c7e0eae6eeeba9e4e8ea"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="80e1e2e3b1b2b3c0e7ede1e9ecaee3efed"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="cdacafaefcfffe8daaa0aca4a1e3aea2a0"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="2647444517141566414b474f4a0845494b"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="e7868584d6d5d4a7808a868e8bc984888a"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="ea8b8889dbd8d9aa8d878b8386c4898587"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Garrett Winters</td>
                                                                                          <td>
                                                                                              <a
                                                                                                  href="https://demo.dashboardpack.com/cdn-cgi/l/email-protection"
                                                                                                  class="__cf_email__"
                                                                                                  data-cfemail="c8a9aaabf9fafb88afa5a9a1a4e6aba7a5"
                                                                                              >
                                                                                                  [email&#160;protected]
                                                                                              </a>
                                                                                          </td>
                                                                                          <td>9989988988</td>
                                                                                          <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                          <td class="dropdown">
                                                                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                                                                              </button>
                                                                                              <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-eye"></i>Activity</a>
                                                                                                  <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                              </div>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                                  <tfoot>
                                                                                      <tr>
                                                                                          <th>Name</th>
                                                                                          <th>Email</th>
                                                                                          <th>Mobileno.</th>
                                                                                          <th>Favourite</th>
                                                                                          <th>Action</th>
                                                                                      </tr>
                                                                                  </tfoot>
                                                                              </table>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="tab-pane" id="review" role="tabpanel">
                                                  <div class="card">
                                                      <div class="card-header">
                                                          <h5 class="card-header-text">Review</h5>
                                                      </div>
                                                      <div class="card-block">
                                                          <ul class="media-list">
                                                              <li class="media">
                                                                  <div class="media-left">
                                                                      <a href="#">
                                                                          <img class="media-object img-radius comment-img" src="files/assets/images/avatar-1.jpg" alt="Generic placeholder image" />
                                                                      </a>
                                                                  </div>
                                                                  <div class="media-body">
                                                                      <h6 class="media-heading">Sortino media<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                      <div class="stars-example-css review-star">
                                                                          <i class="icofont icofont-star"></i>
                                                                          <i class="icofont icofont-star"></i>
                                                                          <i class="icofont icofont-star"></i>
                                                                          <i class="icofont icofont-star"></i>
                                                                          <i class="icofont icofont-star"></i>
                                                                      </div>
                                                                      <p class="m-b-0">
                                                                          Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus
                                                                          viverra turpis.
                                                                      </p>
                                                                      <div class="m-b-25">
                                                                          <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                      </div>
                                                                      <hr />

                                                                      <div class="media mt-2">
                                                                          <a class="media-left" href="#">
                                                                              <img class="media-object img-radius comment-img" src="files/assets/images/avatar-2.jpg" alt="Generic placeholder image" />
                                                                          </a>
                                                                          <div class="media-body">
                                                                              <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                              <div class="stars-example-css review-star">
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                              </div>
                                                                              <p class="m-b-0">
                                                                                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                                  tempus viverra turpis.
                                                                              </p>
                                                                              <div class="m-b-25">
                                                                                  <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                              </div>
                                                                              <hr />

                                                                              <div class="media mt-2">
                                                                                  <div class="media-left">
                                                                                      <a href="#">
                                                                                          <img class="media-object img-radius comment-img" src="files/assets/images/avatar-3.jpg" alt="Generic placeholder image" />
                                                                                      </a>
                                                                                  </div>
                                                                                  <div class="media-body">
                                                                                      <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                      <div class="stars-example-css review-star">
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                      </div>
                                                                                      <p class="m-b-0">
                                                                                          Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate
                                                                                          at, tempus viverra turpis.
                                                                                      </p>
                                                                                      <div class="m-b-25">
                                                                                          <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                      </div>
                                                                                  </div>
                                                                                  <hr />
                                                                              </div>
                                                                          </div>
                                                                      </div>

                                                                      <div class="media mt-2">
                                                                          <div class="media-left">
                                                                              <a href="#">
                                                                                  <img class="media-object img-radius comment-img" src="files/assets/images/avatar-1.jpg" alt="Generic placeholder image" />
                                                                              </a>
                                                                          </div>
                                                                          <div class="media-body">
                                                                              <h6 class="media-heading">Cedric Kelly<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                              <div class="stars-example-css review-star">
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                              </div>
                                                                              <p class="m-b-0">
                                                                                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                                  tempus viverra turpis.
                                                                              </p>
                                                                              <div class="m-b-25">
                                                                                  <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                              </div>
                                                                              <hr />
                                                                          </div>
                                                                      </div>
                                                                      <div class="media mt-2">
                                                                          <a class="media-left" href="#">
                                                                              <img class="media-object img-radius comment-img" src="files/assets/images/avatar-4.jpg" alt="Generic placeholder image" />
                                                                          </a>
                                                                          <div class="media-body">
                                                                              <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                              <div class="stars-example-css review-star">
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                              </div>
                                                                              <p class="m-b-0">
                                                                                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                                  tempus viverra turpis.
                                                                              </p>
                                                                              <div class="m-b-25">
                                                                                  <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                              </div>
                                                                              <hr />

                                                                              <div class="media mt-2">
                                                                                  <div class="media-left">
                                                                                      <a href="#">
                                                                                          <img class="media-object img-radius comment-img" src="files/assets/images/avatar-3.jpg" alt="Generic placeholder image" />
                                                                                      </a>
                                                                                  </div>
                                                                                  <div class="media-body">
                                                                                      <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                      <div class="stars-example-css review-star">
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                          <i class="icofont icofont-star"></i>
                                                                                      </div>
                                                                                      <p class="m-b-0">
                                                                                          Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate
                                                                                          at, tempus viverra turpis.
                                                                                      </p>
                                                                                      <div class="m-b-25">
                                                                                          <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                      </div>
                                                                                  </div>
                                                                                  <hr />
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="media mt-2">
                                                                          <div class="media-left">
                                                                              <a href="#">
                                                                                  <img class="media-object img-radius comment-img" src="files/assets/images/avatar-2.jpg" alt="Generic placeholder image" />
                                                                              </a>
                                                                          </div>
                                                                          <div class="media-body">
                                                                              <h6 class="media-heading">Mark Doe<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                              <div class="stars-example-css review-star">
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                                  <i class="icofont icofont-star"></i>
                                                                              </div>
                                                                              <p class="m-b-0">
                                                                                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                                  tempus viverra turpis.
                                                                              </p>
                                                                              <div class="m-b-25">
                                                                                  <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                              </div>
                                                                              <hr />
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </li>
                                                          </ul>
                                                          <div class="input-group">
                                                              <input type="text" class="form-control" placeholder="Right addon" />
                                                              <div class="input-group-append">
                                                                  <span class="input-group-text"><i class="icofont icofont-send-mail"></i></span>
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

                      <div id="styleSelector"></div>
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
                <p style="font-size: 24px;">Se produjo un error en el servidor. Intente nuevamente más tarde.</p>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="error_general" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Contenido del modal -->
              <div class="modal-body text-center">
                <div class="circle-icon">
                  <i class="fas fa-exclamation-triangle text-danger" style="font-size: 72px;"></i>
                </div>
                <p style="font-size: 24px;" class="mensaje_error_general">.</p>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
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
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
         integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
         crossorigin=""></script>
        <script src="jquery_empresa/proveedor.js"></script>
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>

        <script src="java/cuenta.js"></script>
          <script src="java2/perfil.js"></script>

          <script type="text/javascript">
              let myMap = L.map('myMap').setView([<?php echo $latitude_view ?>, <?php echo $longitud_view ?>], 13);

              L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                  maxZoom: 18,
              }).addTo(myMap);

              function updateMap(latitude, longitude) {
                  myMap.panTo(new L.LatLng(latitude, longitude));
                  L.marker([latitude, longitude]).addTo(myMap);
              }

              updateMap(<?php echo $latitude_view ?>, <?php echo $longitud_view ?>);
          </script>

          <script type="text/javascript">
              $(document).ready(function(){
                  $('.activar_mi_ubicacion').click(function(e){
                      e.preventDefault();
                      $('.notificacion_mapa_agregado').html('<div class="notificacion_negativa"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

                      if (navigator.geolocation) {
                          navigator.geolocation.getCurrentPosition(showPosition);
                      } else {
                          x.innerHTML = "No es compatible tu navegador";
                      }

                      function showPosition(position){
                          var latitud = position.coords.latitude;
                          var longitud = position.coords.longitude;
                          var action = 'agregar_ubicacion';

                          $.ajax({
                              url:'php/cuenta.php',
                              type:'POST',
                              async: true,
                              data: {action:action,latitud:latitud,longitud:longitud},
                              success: function(response){
                                  console.log(response);
                                  if (response != 'error') {
                                      var info = JSON.parse(response);
                                      if (info.noticia == 'ubicacion_agregada_correctamente') {
                                          var latitud = info.latitud;
                                          var longitud = info.longitud;
                                          updateMap(latitud, longitud); // Actualiza el mapa con la nueva ubicación
                                          $('.notificacion_mapa_agregado').html('<div class="alert alert-success background-success"><strong>Ubicación Agregada Correctamente!</strong> tu perfil se actualizo</div>');
                                      }
                                      if (info.noticia == 'error_servidor') {
                                          $('.notificacion_mapa_agregado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
                                      }
                                  }
                              },
                              error:function(error){
                                  console.log(error);
                              }
                          });
                      }
                  });
              });
          </script>


          <script type="text/javascript">
          (function(){
            $(function(){
              $('.editar_pagina_web').on('click',function(){
              var pagina_web = $(this).attr('pagina_web');
               $(".result_pagina_web").html(' <form   method="post" name="add_pagina_web" id="add_pagina_web" onsubmit="event.preventDefault(); sendData_pagina_web();">'+
                          ' <div class="form-group">'+
                            ' <textarea class="form-control" required id="pagina_web" name="pagina_web" aria-describedby="emailHelp" placeholder="Ingrese la URL ">'+pagina_web+'</textarea>'+
                          ' </div>'+
                          '   <input type="hidden" name="action" value="add_pagina_web" required>'+
                            '   <div class="notificacion_editar_pagina_web"></div>'+
                          '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                        '</form>');
              });
            });

          }());

          </script>

          <script>
            $(document).on('input', '.area_ecritura_restringida', function() {
                    var textAreaValue = $(this).val();
                    if (textAreaValue.includes('ñ') || textAreaValue.includes('&')) {
                        console.log('Caracteres "ñ" y "&" no están permitidos.');
                        $('#error_general').modal();
                      $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                      '<i class="icofont icofont-close-line-circled text-white"></i>'+
                      '</button>'+
                      '<strong>Error!</strong> No puedes ingresar estos caracteres [ñ-&]'+
                      '</div>');
                        $(this).val(textAreaValue.replace(/[ñ&]/g, ''));
                    }
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
<script type="text/javascript">
(function() {
  $(function() {
    $('.boton_editar_foto_perfil').on('click', function() {
      $('#modal_editar_foto_perfil').modal();
    });
  });
})();
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
var botonCopiar = document.getElementById("boton-copiar");
var enlaceOculto = document.getElementById("enlace-oculto");

botonCopiar.addEventListener("click", function() {
  enlaceOculto.select();
  document.execCommand("copy");
  botonCopiar.classList.remove("btn-info"); // Remover la clase btn-info
  botonCopiar.classList.add("btn-success");
  botonCopiar.querySelector("span").textContent = "Copiado";
});
});
</script>




<script type="text/javascript">
(function(){
  $(function(){
    $('.editar_facebook').on('click',function(){
    var facebook = $(this).attr('facebook');
     $(".result_facebook").html(' <form   method="post" name="add_form_facebook" id="add_form_facebook" onsubmit="event.preventDefault(); sendData_facebook();">'+
                ' <div class="form-group">'+
                  ' <textarea class="form-control" required id="facebook" name="facebook" aria-describedby="emailHelp" placeholder="Ingrese la URL ">'+facebook+'</textarea>'+
                ' </div>'+
                '   <input type="hidden" name="action" value="addFacebook" required>'+
                  '   <div class="notificacion_facebook"></div>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
              '</form>');
    });
  });

}());

</script>



<script type="text/javascript">
(function(){
  $(function(){
    $('.editar_instagram').on('click',function(){
    var instagram = $(this).attr('instagram');
     $(".result_insta").html(' <form   method="post" name="add_form_instagram" id="add_form_instagram" onsubmit="event.preventDefault(); sendDatainstagram();">'+
                ' <div class="form-group">'+
                  ' <textarea class="form-control" required id="instagram" name="instagram" aria-describedby="emailHelp" placeholder="Ingrese la URL">'+instagram+'</textarea>'+
                ' </div>'+
                '   <input type="hidden" name="action" value="addinstagram" required>'+
                  '   <div class="notificacion_instagram"></div>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
              '</form>');
    });
  });

}());

</script>




      <script type="text/javascript">
      (function(){
        $(function(){
          $('.editar_whatsapp').on('click',function(){
          var whatsapp = $(this).attr('whatsapp');
           $(".result_wsp").html(' <form   method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();">'+
                      ' <div class="form-group">'+
                        ' <textarea class="form-control" required id="whatsapp" name="whatsapp" aria-describedby="emailHelp" placeholder="Ingrese el número">'+whatsapp+'</textarea>'+
                      ' </div>'+
                      '   <input type="hidden" name="action" value="addwhatsapp" required>'+
                      '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                    '</form>');
          });
        });

      }());

      </script>


    <script type="text/javascript">
    (function(){
      $(function(){
        $('.editar_direccion').on('click',function(){
        var direccion = $(this).attr('direccion');
         $(".result_direccion").html(' <form   method="post" name="add_direccion" id="add_direccion" onsubmit="event.preventDefault(); sendData_direccion();">'+
                        '   <div class="form-group">'+
                          '   <label for="exampleFormControlTextarea1">Ingresa la Dirección</label>'+
                            ' <textarea class="form-control area_ecritura_restringida" name="direccion_u" id="area_direccion" rows="3">'+direccion+'</textarea>'+
                          ' </div>'+
                        ' <div class="modal-footer">'+
                    '   <input type="hidden" name="action" value="agregar_direccion" required>'+
                    '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                    ' </div>'+
                  '</form>');
        });
      });

    }());

    </script>




    <script type="text/javascript">
    (function(){
      $(function(){
        $('.editar_celular').on('click',function(){
        var celular = $(this).attr('celular');
         $(".rst_celular").html(' <form   method="post" name="add_form_celular" id="add_form_celular" onsubmit="event.preventDefault(); sendDatacelular();">'+
                    ' <div class="form-group">'+
                      ' <input type="number" class="form-control" value="'+celular+'"  required id="celular" name="celular" aria-describedby="emailHelp" placeholder="Ingrese el Celular">'+
                    ' </div>'+
                    ' <div class="modal-footer">'+
                    '   <input type="hidden" name="action" value="addcelular" required>'+
                    '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                    ' </div>'+
                  '</form>');
        });
      });

    }());

    </script>

    <script type="text/javascript">
    (function(){
      $(function(){
        $('.editar_telefono').on('click',function(){
        var telefono = $(this).attr('telefono');
         $(".result_telefono").html(' <form   method="post" name="add_form_telefono" id="add_form_telefono" onsubmit="event.preventDefault(); sendDatatelefono();">'+
                    ' <div class="form-group">'+
                      ' <input type="number" class="form-control" value="'+telefono+'"  required id="telefono" name="telefono" aria-describedby="emailHelp" placeholder="Ingrese el teléfono">'+
                    ' </div>'+
                    ' <div class="modal-footer">'+
                    '   <input type="hidden" name="action" value="addtelefono" required>'+
                    '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                    ' </div>'+
                  '</form>');
        });
      });

    }());

    </script>

    <script type="text/javascript">
    function sendDataedit_cambio_password_fc(){
      $('.notificacion_contyrasena').html(' <div class="notificacion_negativa">'+
         '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
       '</div>');
      var parametros = new  FormData($('#cambiar_contrasna')[0]);
      $.ajax({
        data: parametros,
        url: 'jquery_administrativo/cambio_password.php',
        type: 'POST',
        contentType: false,
        processData: false,
        beforesend: function(){

        },
        success: function(response){
          console.log(response);

          if (response =='error') {
            $('.alert_general').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
          }else {
          var info = JSON.parse(response);
          if (info.noticia == 'positiva') {
            $('.notificacion_contyrasena').html('<div class="alert alert-success" role="alert">Contraseña Cambiada Correctamente!</div>');

          }
          if (info.noticia == 'error_servidor') {
          $('.notificacion_contyrasena').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

          }
          if (info.noticia == 'contrasena_invalida') {
          $('.notificacion_contyrasena').html('<div class="alert alert-danger" role="alert">Error en Credenciales!</div>');

          }
          if (info.noticia == 'contra_diferentes') {
          $('.notificacion_contyrasena').html('<div class="alert alert-danger" role="alert">Ingresa contraseñas iguales!</div>');

          }

          }

        }

      });

    }



    </script>


    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
