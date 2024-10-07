<?php
$user_in= $_SESSION['user_in'];

$id_usuario_venta= $_SESSION['id'];

$id_generacion =  $id_usuario_venta;

$query_usuario_venta = mysqli_query($conection, "SELECT * FROM usuarios_punto_venta    WHERE usuarios_punto_venta.id =$id_usuario_venta");
$data_usuario_venta =mysqli_fetch_array($query_usuario_venta);
$nombres_usuarios_punto_venta    = $data_usuario_venta['nombres'];
$direccion_usuario_venta         = $data_usuario_venta['direccion'];
$mail_usuario_venta              = $data_usuario_venta['mail'];
$iduser                     =     $data_usuario_venta['iduser'];
$cambio_password_usuarios_punto_venta   = $data_usuario_venta['cambio_password'];
$foto_usuarios_punto_venta       = $data_usuario_venta['foto'];
$fecha_registro_usuario_venta    = $data_usuario_venta['fecha'];
$url_img_upload_usuario_venta    = $data_usuario_venta['url_img_upload'];
$identificacion_usuario_venta    = $data_usuario_venta['identificacion'];
$foto_usuario_venta              = $data_usuario_venta['foto'];
$ciudad_usuario_venta            = $data_usuario_venta['ciudad'];
$telefono_usuario_venta          = $data_usuario_venta['telefono'];
$celular_usuario_venta           = $data_usuario_venta['celular'];




$query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$iduser");
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
?>

<div class="theme-loader">
    <div class="ball-scale">
        <div class="contain">
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
        </div>
    </div>
</div>



        <div id="pcoded" class="pcoded">
            <div class="pcoded-container">


                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="feather icon-menu"></i>
                            </a>
                            <a href="/">
                                <img class="img-fluid" src="/img/guibis.png" width="50px;" alt="Theme-Logo" />
                            </a>
                            <a class="mobile-options">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>
                        <div class="navbar-container">
                            <ul class="nav-left">
                                <li class="header-search">
                                    <div class="main-search morphsearch-search">
                                        <div class="input-group">
                                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                            <input type="text" class="form-control" />
                                            <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="feather icon-maximize full-screen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <li class="header-notification">
                                    <div class="dropdown-primary dropdown">
                                      <div class="dropdown-toggle" data-toggle="dropdown">

                                        <?php
                                        $cunatificar_cuantas_notis_hay = mysqli_query($conection, "SELECT COUNT(*) as cantidad FROM preguntas WHERE id_responde = '$iduser' AND respuesta != ''");
                                        $data_cuantas_notis_hay = mysqli_fetch_array($cunatificar_cuantas_notis_hay);
                                        $notificacion_totales = $data_cuantas_notis_hay['cantidad'];
                                         ?>

                                          <i class="feather icon-bell"></i>
                                          <span class="badge bg-c-pink"><?php echo $notificacion_totales ?></span>
                                      </div>
                                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <h6>Notifications</h6>
                                                <label class="label label-danger">New</label>
                                            </li>

                                            <style media="screen">
                                            .lista-notificaciones {
                                                  max-height: 300px; /* Ajusta según tus necesidades */
                                                  overflow-y: auto;
                                                  width: 90%;
                                                }

                                            </style>

                                            <ul class="lista-notificaciones">
                                              <?php
                                               mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                              $query_lista = mysqli_query($conection,"SELECT preguntas.id_responde,preguntas.pregunta,preguntas.id
                                                ,DATE_FORMAT(preguntas.fecha_respuesta, '%W  %d de %b %Y %h:%m:%i') as 'fecha_respuesta',preguntas.id_pregunta,preguntas.fecha
                                                 FROM preguntas WHERE id_responde = '$iduser' AND respuesta != ''  ORDER BY fecha DESC  ");
                                              $result_lista = mysqli_num_rows($query_lista);
                                              if ($result_lista > 0) {
                                                while ($data_lista = mysqli_fetch_array($query_lista)) {

                                                    $id_pregunta = $data_lista['id_pregunta'];
                                                  //codigo para sacar informacion del cliente

                                                  $query_informacion_pregunta = mysqli_query($conection,"SELECT *
                                                     FROM clientes WHERE id = '$id_pregunta'");

                                                     $data_cliente_pregunta = mysqli_fetch_array($query_informacion_pregunta);
                                                     $foto_clientes              = $data_cliente_pregunta['foto'];
                                                     $url_img_upload_cliente     = $data_cliente_pregunta['url_img_upload'];
                                                      $nombres_cliente     = $data_cliente_pregunta['nombres'];

                                                  $fecha_respuesta = $data_lista['fecha_respuesta'];
                                                    $fecha_pregunta = $data_lista['fecha'];
                                                  $pregunta = $data_lista['pregunta'];
                                                  $id_pregunta = $data_lista['id'];

                                                  ?>
                                              <li>
                                                  <div class="media">
                                                      <img class="d-flex align-self-center img-radius" src="<?php echo $url_img_upload_cliente ?>/home/img/<?php echo $foto_clientes ?>" alt="<?php echo $foto_clientes ?>" />
                                                      <div class="media-body">
                                                          <h5 class="notification-user"><?php echo $nombres_cliente ?></h5>
                                                          <p class="notification-msg">A realizado una pregunta <?php echo $pregunta ?>.  </p>
                                                          <span class="notification-time"><?php echo $fecha_pregunta ?></span>
                                                      </div>
                                                  </div>
                                              </li>
                                              <?php
                                            }
                                          }

                                        ?>
                                            </ul>



                                        </ul>
                                    </div>
                                </li>
                                <li class="header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                                            <i class="feather icon-message-square"></i>
                                            <span class="badge bg-c-green">3</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">

                                            <img src="<?php echo $url_img_upload_usuario_venta ?>/home/img/uploads/<?php echo $foto_usuarios_punto_venta; ?>" class="img-radius" alt="User-Profile-Image" />
                                            <span><?php echo $nombres_usuarios_punto_venta ?></span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <a href="user"> <i class="feather icon-user"></i> Perfil </a>
                                            </li>
                                            <li>
                                                <a href="config_email"> <i class="feather icon-mail"></i>Configurar Email </a>
                                            </li>
                                            <li>
                                                <a href="config_notas_venta"> <i class="feather icon-lock"></i> Configurar N V</a>
                                            </li>
                                            <li>
                                              <a href="config_facturacion"> <i class="feather icon-settings"></i>Facturación</a>
                                            </li>
                                            <li>
                                                <a href="salir"> <i class="feather icon-log-out"></i> Salir </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="pcoded-main-container">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar">
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-map"></i></span>
                                        <span class="pcoded-mtext">Extras</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-home"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.dash.main">Notas</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class>
                                                    <a href="add_notes">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.default">Agregar Notas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="active_notes">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Notas Activas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="history_notes">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.crm">Historial Notas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-layout"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Proveedores</span>
                                                <span class="pcoded-badge label label-warning">NEW</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">


                                                <li class=" ">
                                                    <a href="add_proveedor" data-i18n="nav.page_layout.bottom-menu">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Añadir Proveedores</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="view_proveedor"  data-i18n="nav.page_layout.box-layout">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Ver Proveedores</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-layout"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Compras</span>
                                                <span class="pcoded-badge label label-warning">NEW</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">


                                                <li class=" ">
                                                    <a href="add_compras" data-i18n="nav.page_layout.bottom-menu">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Añadir Compras</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="view_compras" data-i18n="nav.page_layout.box-layout">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Ver Compras</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-layout"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Ventas</span>
                                                <span class="pcoded-badge label label-warning">NEW</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">


                                                <li class=" ">
                                                    <a href="add_ventas" data-i18n="nav.page_layout.bottom-menu">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Añadir Ventas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="view_ventas"  data-i18n="nav.page_layout.box-layout">
                                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                                        <span class="pcoded-mtext">Ver Ventas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-home"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.dash.main">Sucursales</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">

                                                <li class=" ">
                                                    <a href="sucursales">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Sucursales</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>



                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-home"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.dash.main">Almacenes</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="almacenes">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Almacenes</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                                        <span class="pcoded-mtext">Área Transportista</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                                <span class="pcoded-mtext">Transportista</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="transportistas" data-i18n="nav.basic-components.alert">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Transportistas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="add_transportista" data-i18n="nav.basic-components.breadcrumbs">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Agregar Transportista</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>



                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                                        <span class="pcoded-mtext">Administrativo</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.form-components.main">
                                                <span class="pcoded-micon"><i class="ti-layers"></i></span>
                                                <span class="pcoded-mtext">Cajas</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="abrir_cajas" data-i18n="nav.form-components.form-components">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Abrir Cajas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="cajas_abiertas" data-i18n="nav.form-components.form-elements-add-on">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Cajas Abiertas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="historial_cajas" data-i18n="nav.form-components.form-elements-advance">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Historial Cajas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.form-components.main">
                                                <span class="pcoded-micon"><i class="ti-layers"></i></span>
                                                <span class="pcoded-mtext">Cuentas</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="cuentas_cobrar" data-i18n="nav.form-components.form-components">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Cuentas por Cobrar</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.ready-to-use.main">
                                                <span class="pcoded-micon"><i class="ti-receipt"></i></span>
                                                <span class="pcoded-mtext">Bancos</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="agregar_cuentas_bancarias" data-i18n="nav.ready-to-use.cloned-elements-form">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Agregar Cuentas Bancarias</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="cuentas_bancarias" data-i18n="nav.ready-to-use.currency-form">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Cuentas Bancarias</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-unlock"></i></span>
                                        <span class="pcoded-mtext">Usuarios</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu" id="contenedor_permisos_ver_clientes">
                                            <a href="javascript:void(0)" data-i18n="nav.authentication.main">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                <span class="pcoded-mtext">Área Clientes</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class>
                                                    <a href="clientes"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Clientes</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class>
                                                    <a href="subir_masivamente_clientes"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Subir Masivamente</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>

                                        <?php if ($iduser == $user_in): ?>
                                          <li class="pcoded-hasmenu">
                                              <a href="javascript:void(0)" data-i18n="nav.authentication.main">
                                                  <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                  <span class="pcoded-mtext">Usuarios Base</span>
                                                  <span class="pcoded-mcaret"></span>
                                              </a>
                                              <ul class="pcoded-submenu">
                                                  <li class>
                                                      <a href="usuarios_base_in"  data-i18n="nav.authentication.login-bg-image">
                                                          <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                          <span class="pcoded-mtext">Mis Usuarios Base</span>
                                                          <span class="pcoded-mcaret"></span>
                                                      </a>
                                                  </li>
                                              </ul>
                                          </li>

                                        <?php endif; ?>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.authentication.main">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                <span class="pcoded-mtext">Usuarios Correos </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class>
                                                    <a href="usuarios_correo_envio"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Correos Envio</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-message-square"></i></span>
                                        <span class="pcoded-mtext">Kardex</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="inventario_general" data-i18n="nav.chat.main">
                                                <span class="pcoded-micon"><i class="ti-comments"></i></span>
                                                <span class="pcoded-mtext">Inventario General</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>


                                        <li class="pcoded-hasmenu" id="contenedor_permisos_ver_productos">
                                            <a href="javascript:void(0)" data-i18n="nav.authentication.main">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                <span class="pcoded-mtext">Área Productos</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class>
                                                    <a href="productos"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Productos</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                                <li class>
                                                    <a href="subir_masivamente_productos"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Subir Masivamente</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>
                                    </ul>

                                </li>


                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                        <span class="pcoded-mtext">Documentos</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.bootstrap-table.main">
                                                <span class="pcoded-micon"><i class="ti-receipt"></i></span>
                                                <span class="pcoded-mtext">Generados</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="facturas" data-i18n="nav.bootstrap-table.basic-table">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Facturas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="notas_venta" data-i18n="nav.bootstrap-table.sizing-table">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Notas de Venta</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="tikets_venta" data-i18n="nav.bootstrap-table.sizing-table">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Tikets de Venta</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="notas_credito" data-i18n="nav.bootstrap-table.border-table">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Notas de Crédito</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="guias_remision" data-i18n="nav.bootstrap-table.styling-table">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Guias de Remisión</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" data-i18n="nav.data-table.main">
                                                <span class="pcoded-micon"><i class="ti-widgetized"></i></span>
                                                <span class="pcoded-mtext">Guardados</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="facturas_guardadas" data-i18n="nav.data-table.basic-initialization">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Facturas</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>



                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Transacciones</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class>
                                          <a href="#" data-i18n="nav.disabled-menu.main" class="disabled enlace_verificacion_secuencia_factura">
                                              <span class="pcoded-micon"><i class="ti-na"></i></span>
                                              <span class="pcoded-mtext">Generar Documento</span>
                                              <span class="pcoded-mcaret"></span>
                                          </a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
