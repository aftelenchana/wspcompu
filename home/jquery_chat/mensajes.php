<?php
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar


session_start();
if (empty($_SESSION['active'])) {
  header('location:/');
}else {
  $iduser= $_SESSION['id'];
}

if ($_POST['action'] == 'buscar_chat_usuario') {

    $codigo_cliente = $_POST['codigo'];

    $query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id ='$iduser'");
    $result=mysqli_fetch_array($query);
    $nombres_user_raiz           = $result['nombres'];
    $firma_electronica = $result['firma_electronica'];
    $direccion         = $result['direccion'];
    $codigo_sri        = $result['codigo_sri'];
    $estableciminento        = $result['estableciminento_f'];
    $punto_emision        = $result['punto_emision_f'];
    $porcentaje_iva       = $result['porcentaje_iva_f'];
    $apellidos         = $result['apellidos'];
    $img_logo          = $result['img_facturacion'];
    $url_img_upload           = $result['url_img_upload'];

    $query_cliente = mysqli_query($conection, "SELECT * FROM clientes    WHERE clientes.id =$codigo_cliente");
    $data_cliente =mysqli_fetch_array($query_cliente);
    $nombres_clientes           = $data_cliente['nombres'];
    $direccion_cliente          = $data_cliente['direccion'];
    $mail_cliente               = $data_cliente['mail'];
    $iduser_raiz                = $data_cliente['iduser'];
    $cambio_password_clientes   = $data_cliente['cambio_password'];
    $foto_clientes              = $data_cliente['foto'];
    $fecha_registro_cliente    = $data_cliente['fecha'];
    $url_img_upload_cliente     = $data_cliente['url_img_upload'];


    $respuesta = '';

    mysqli_query($conection,"SET lc_time_names = 'es_ES'");
    $query_lista = mysqli_query($conection,"SELECT * FROM mensajes_guibis WHERE idcliente = '$codigo_cliente'  ORDER BY fecha ASC");
    $result_lista = mysqli_num_rows($query_lista);

    if ($result_lista > 0) {
        while ($data_lista = mysqli_fetch_array($query_lista)) {

            $iduser_mensjaes    = $data_lista['iduser'];
            $idcluente_mesnajes = $data_lista['idcliente'];
            $id_envio_envio     = $data_lista['id_envio'];
            $fecha_envio     = $data_lista['fecha'];
            $mensaje_envio     = $data_lista['mensaje'];

            if ($idcluente_mesnajes == $id_envio_envio) {
                $respuesta .= '
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" alt="Generic placeholder image" />
                    </a>
                    <div class="media-body chat-menu-content">
                        <div>
                            <p class="chat-cont">'.$mensaje_envio.'</p>
                            <p class="chat-time">'.$fecha_envio.'</p>
                        </div>
                    </div>
                </div>';
            }

            if ($idcluente_mesnajes != $id_envio_envio) {
              $respuesta .= '
              <div class="media chat-messages">
                  <div class="media-body chat-menu-reply">
                      <div>
                          <p class="chat-cont"> '.$mensaje_envio.'</p>
                          <p class="chat-time">'.$fecha_envio.'</p>
                      </div>
                  </div>
                  <div class="media-right photo-table">
                      <a href="#!">
                          <img class="media-object img-radius img-radius m-t-5" src="'.$url_img_upload_cliente.'/home/img/uploads/'.$foto_clientes.'" alt="Generic placeholder image" />
                      </a>
                  </div>
              </div>';
            }
        }

        $arrayName = array('noticia' => 'existe_chat', 'respuesta' => $respuesta, 'nombres_user_raiz' => $nombres_user_raiz);
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
    }else {

      $arrayName = array('noticia' => 'no_existe_datos', 'respuesta' => $respuesta, 'nombres_user_raiz' => $nombres_user_raiz);
      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);


    }


}


if ($_POST['action'] == 'agregar_chat') {
      $mensaje = $_POST['mensaje'];
      $usuario_ingreso = $_POST['usuario_ingreso'];

      $query_insert=mysqli_query($conection,"INSERT INTO mensajes_guibis(idcliente,iduser,mensaje,id_envio)
                                    VALUES('$usuario_ingreso','$iduser','$mensaje','$iduser') ");

        if ($query_insert) {
          $arrayName = array('noticia' =>'inser_correct','codigo'=>$usuario_ingreso);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
          $arrayName = array('noticia' =>'error');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }


}



 ?>
