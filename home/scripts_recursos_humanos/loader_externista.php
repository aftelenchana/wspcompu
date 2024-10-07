<?php


$id_recursos_humanos= $_SESSION['id'];

$id_generacion =  $id_recursos_humanos;

$user_in= $_SESSION['user_in'];




$query = mysqli_query($conection, "SELECT * FROM recursos_humanos    WHERE recursos_humanos.id =$id_recursos_humanos");
$result=mysqli_fetch_array($query);
$nombres           = $result['nombres'];
$firma_electronica = $result['firma_electronica'];
$direccion         = $result['direccion'];
$codigo_firma      = $result['codigo_firma'];

$img_logo          = $result['foto'];
$url_img_upload    = $result['url_img_upload'];

$email_user           = $result['mail'];
$fecha                = $result['fecha'];
$ciudad_user          = $result['ciudad'];
$telefono_user        = $result['telefono'];
$celular_user         = $result['celular'];


$identificacion       = $result['identificacion'];

$whatsapp             = $result['whatsapp'];
$instagram            = $result['instagram'];
$facebook             = $result['facebook'];
$pagina_web           = $result['pagina_web'];

$descripcion_usuerio  = $result['descripcion'];

$latitud             = $result['latitud'];
$longitud            = $result['longitud'];
$password_user       = $result['password'];
$fecha_caducidad_firma   = $result['fecha_caducidad_firma'];
$iduser       = $result['iduser'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                                <!--<i class="feather icon-menu"></i>-->
                              <i class="fa-solid fa-bars"></i>
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
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="feather icon-maximize full-screen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">




                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo; ?>" class="img-radius" alt="User-Profile-Image" />
                                            <span><?php echo $nombres ?></span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <a href="user_rrhh"> <i class="feather icon-user"></i> Perfil </a>
                                            </li>
                                            <li>
                                                <a href="config_email"> <i class="feather icon-mail"></i>Configurar Email </a>
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
                                        <span class="pcoded-micon"><i class="feather icon-unlock"></i></span>
                                        <span class="pcoded-mtext">Usuarios</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu" id="contenedor_permisos_ver_pacientes">
                                            <a href="javascript:void(0)" data-i18n="nav.authentication.main">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                <span class="pcoded-mtext">Pacientes</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class>
                                                    <a href="pacientes"  data-i18n="nav.authentication.login-bg-image">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Pacientes</span>
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

                                    </ul>
                                </li>



                                                                <li class="pcoded-hasmenu">
                                                                    <a href="javascript:void(0)">
                                                                        <span class="pcoded-micon"><i class="feather icon-heart"></i></span>
                                                                        <span class="pcoded-mtext">Hospital</span>
                                                                        <span class="pcoded-mcaret"></span>
                                                                    </a>
                                                                    <ul class="pcoded-submenu">
                                                                        <li class>
                                                                          <a href="ingresos_medicina" data-i18n="nav.disabled-menu.main" class="">
                                                                              <span class="pcoded-micon"><i class="ti-na"></i></span>
                                                                              <span class="pcoded-mtext">Ingresos</span>
                                                                              <span class="pcoded-mcaret"></span>
                                                                          </a>
                                                                        </li>
                                                                        <li class>
                                                                          <a href="enfermedades" data-i18n="nav.disabled-menu.main" class="">
                                                                              <span class="pcoded-micon"><i class="ti-na"></i></span>
                                                                              <span class="pcoded-mtext">Enfermedades</span>
                                                                              <span class="pcoded-mcaret"></span>
                                                                          </a>
                                                                        </li>
                                                                        <li class>
                                                                          <a href="farmacias" data-i18n="nav.disabled-menu.main" class="">
                                                                              <span class="pcoded-micon"><i class="ti-na"></i></span>
                                                                              <span class="pcoded-mtext">Farmacias</span>
                                                                              <span class="pcoded-mcaret"></span>
                                                                          </a>
                                                                        </li>





                                                                    </ul>
                                                                </li>


                            </ul>
                        </div>
                    </nav>
