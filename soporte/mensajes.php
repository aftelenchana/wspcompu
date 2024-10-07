<?php

require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];
  $envio_wsp          =  $result_configuracion['envio_wsp'];

  $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '279'");
  $result_documentos = mysqli_fetch_array($query_doccumentos);

  $celular_empresa_emisor   = $result_documentos['celular'];

if ($_POST['action'] == 'empezar_chat') {
        $mensaje = $_POST['mensaje'];
        // Verificar si la cookie 'codigo_mensaje' ya existe
        if (!isset($_COOKIE['codigo_mensaje'])) {
          session_start();
                // Verificar si la sesión está activa
                if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
                  $sesion_iduser = $_SESSION['id'];
                  $codigo_mensaje = md5(date('Y-m-d H:i:s'));
                  setcookie('codigo_mensaje', $codigo_mensaje.'-'.$sesion_iduser, time() + (3600), "/"); // 86400 = 1 día
                } else {
                  $codigo_mensaje = md5(date('Y-m-d H:i:s'));
                  setcookie('codigo_mensaje', $codigo_mensaje, time() + (3600), "/"); // 86400 = 1 día
                }
        } else {
            session_start();
            if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
              $codigo_mensaje = $_COOKIE['codigo_mensaje'];
              $sesion_iduser = $_SESSION['id'];

              $partes_codigo_mensaje = explode('-', $codigo_mensaje);

              if(end($partes_codigo_mensaje) != $sesion_iduser) {
                  $codigo_mensaje = $codigo_mensaje . '-' . $sesion_iduser;
              } else {
                  $codigo_mensaje = $codigo_mensaje;
              }
            } else {
              $codigo_mensaje = $_COOKIE['codigo_mensaje'];
            }
        }


        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

        function getRealIP() {
            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                return $_SERVER["HTTP_CLIENT_IP"];
            } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
                return $_SERVER["HTTP_X_FORWARDED"];
            } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
                return $_SERVER["HTTP_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
                return $_SERVER["HTTP_FORWARDED"];
            } else {
                return $_SERVER["REMOTE_ADDR"];
            }
        }

        if ($url == 'http://localhost') {
            $direccion_ip = '186.42.9.232';
          // code...
        }else {
            $direccion_ip = getRealIP();
        }

        $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));

         $pais            = $datos['country'];
         $ciudad            = $datos['city'];
         $provincia         = $datos['regionName'];


       $query_insert=mysqli_query($conection,"INSERT INTO mensajes_guibis_soporte(mensaje,id_envio,idcliente,full_url,pais,ciudad,ip)
                                     VALUES('$mensaje','$codigo_mensaje','$codigo_mensaje','$url','$pais','$ciudad','$direccion_ip') ");

         if ($query_insert) {

           $mensaje .= "\nSoporte Guibis ";

           if ($envio_wsp == 'SI') {
             include '../mensajes/mensajes.php';
             $respuestaComprador    = enviarMensajeWhatsApp_guibis($celular_empresa_emisor, $mensajeVendedor);
         }



           $arrayName = array('noticia' =>'inser_correct');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }else {
           $arrayName = array('noticia' =>'error');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
       // code...
  }


if ($_POST['action'] == 'buscar_mensajes') {

  if (!isset($_COOKIE['codigo_mensaje'])) {

    session_start();
          // Verificar si la sesión está activa
          if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
            $sesion_iduser = $_SESSION['id'];
            $codigo_mensaje = md5(date('Y-m-d H:i:s'));
            setcookie('codigo_mensaje', $codigo_mensaje.'-'.$sesion_iduser, time() + (3600), "/"); // 86400 = 1 día
          } else {
            $codigo_mensaje = md5(date('Y-m-d H:i:s'));
            setcookie('codigo_mensaje', $codigo_mensaje, time() + (3600), "/"); // 86400 = 1 día
          }
  } else {
    session_start();
    if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
      $sesion_iduser = $_SESSION['id'];
      $codigo_mensaje = $_COOKIE['codigo_mensaje'];
      $partes_codigo_mensaje = explode('-', $codigo_mensaje);

      if(end($partes_codigo_mensaje) != $sesion_iduser) {
          $codigo_mensaje_nuevo = $codigo_mensaje . '-' . $sesion_iduser;
      } else {
          $codigo_mensaje_nuevo = $codigo_mensaje;
      }

      $query_update = mysqli_query($conection, "UPDATE mensajes_guibis_soporte SET idcliente = '$codigo_mensaje_nuevo',id_envio = '$codigo_mensaje_nuevo' WHERE idcliente = '$codigo_mensaje' AND id_envio='$codigo_mensaje' ");

      $query_update2 = mysqli_query($conection, "UPDATE mensajes_guibis_soporte SET idcliente = '$codigo_mensaje_nuevo' WHERE idcliente = '$codigo_mensaje' ");

      $codigo_mensaje = $codigo_mensaje_nuevo;


    } else {
      $codigo_mensaje = $_COOKIE['codigo_mensaje'];
    }

  }


  mysqli_query($conection,"SET lc_time_names = 'es_ES'");
    $query_lista = mysqli_query($conection,"SELECT * FROM mensajes_guibis_soporte WHERE idcliente = '$codigo_mensaje' AND  estatus = '1'    ORDER BY fecha ASC");
    $result_lista = mysqli_num_rows($query_lista);


      if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
        $sesion_iduser = $_SESSION['id'];

        $query_user_sesion = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$sesion_iduser");
        $data_user_sesion  = mysqli_fetch_array($query_user_sesion);
        $url_img_upload           = $data_user_sesion['url_img_upload'];
        $img_facturacion           = $data_user_sesion['img_facturacion'];

        $imagen_soporte = $url_img_upload.'/home/img/uploads/'.$img_facturacion;

      } else {
        $imagen_soporte = 'https://guibis.com/home/img/reacciones/soporte-tecnico.png';

      }

    $respuesta = '';

    // Inicializa la variable antes de usarla
$estadoEntregadoEncontrado = false;

      if ($result_lista > 0) {
          while ($data_lista = mysqli_fetch_array($query_lista)) {
              $idcluente_mesnajes = $data_lista['idcliente'];
              $id_envio_envio     = $data_lista['id_envio'];
              $idsoporte     = $data_lista['idsoporte'];
              $fecha_envio     = $data_lista['fecha'];
              $mensaje_envio     = $data_lista['mensaje'];
              $estado_mensaje     = $data_lista['estado_mensaje'];

              if ($idcluente_mesnajes == $id_envio_envio) {
                $regex = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $mensaje_envio = preg_replace($regex, '<a href="$0" target="_blank">$0</a>', $mensaje_envio);
                  $respuesta .= '
                  <div class="d-flex flex-column my-2 align-items-end">
                      <div class="d-flex align-items-center justify-content-end">
                          <div class="bubble">'.$mensaje_envio.'</div>
                          <img src="'.$imagen_soporte.'" alt="Tu Avatar" class="rounded-circle" style="width: 40px; height: 40px; margin-left: 10px;">
                      </div>
                      <small class="text-muted">'.$fecha_envio.'-'.$estado_mensaje.'</small>
                  </div>
                  ';
              }

              if ($idcluente_mesnajes != $id_envio_envio) {
                if ($data_lista['estado_mensaje'] == 'Entregado') {
               $estadoEntregadoEncontrado = true;
             }

             $regex = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
             $mensaje_envio = preg_replace($regex, '<a href="$0" target="_blank">$0</a>', $mensaje_envio);
                  $respuesta .= '
                  <div class="d-flex flex-column my-2" >
                      <div class="d-flex align-items-center">
                          <img src="https://guibis.com/img/guibis.png" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                          <div class="bubble" style="background: #263238;color: #fff;">'.$mensaje_envio.'</div>
                      </div>
                      <small class="text-muted" style="margin-left: 50px;">'.$fecha_envio.'-'.$estado_mensaje.'</small>
                  </div>';

              $query_update = mysqli_query($conection, "UPDATE mensajes_guibis_soporte SET estado_mensaje = 'Visto' WHERE idcliente = '$idcluente_mesnajes' AND id_envio != '$idcluente_mesnajes' ");


              }
          }

          $arrayName = array(
                  'noticia' => 'existe_chat',
                  'respuesta' => $respuesta,
                  'estado_mensaje' => $estadoEntregadoEncontrado ? 'Entregado' : 'No Entregado'
              );

              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);

              // Actualiza los mensajes a 'Visto'

      }else {

        $arrayName = array('noticia' => 'no_existe_datos', 'respuesta' => $respuesta);
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);


      }
}
 ?>
