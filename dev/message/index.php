<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('content-type: application/json; charset=utf-8');
// Obtén los datos del cuerpo de la solicitud POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);


// Verifica si alguna de las dos variables está vacía
if (empty($data['mensaje']) || empty($data['numero_wsp'])) {
      echo json_encode(['noticia' => 'parametros incompletos']);
      exit;
} else {
  $mensaje = $data['mensaje'];
  $numero_wsp = $data['numero_wsp'];
}



if (!empty($data['KEY'])) {
if (!empty($data['callback'])) {
   require "../../coneccion.php" ;
   mysqli_set_charset($conection, 'utf8'); //linea a colocar
  $token_usuario = $data['KEY'];
  $query_existencia_token = "SELECT * FROM usuarios WHERE id_e ='$token_usuario'";
  $result_usuario = mysqli_query($conection, $query_existencia_token);
  $existencia_usuario = mysqli_num_rows($result_usuario);
  if ($existencia_usuario>0) {



    $data_user = mysqli_fetch_array($result_usuario);
    $email = $data_user['email'];
    $iduser = $data_user['id'];
    //codigo para saber si ha comprado o no un paquete
    $datos = json_decode(file_get_contents('https://guibis.com/api/suscripciones/check?producto=5136&email='.$email.''),true);

    $noticia = $datos['NOTICIA'];
    if ($noticia == 'no existe ventas de este producto') {
      echo json_encode(['noticia' => 'compra un paquete en https://guibis.com/suscripcion?codigo=5136']);
    }

    if ($noticia == 'NO EXISTE VENTA PARA '.$email.'') {
      echo json_encode(['noticia' => 'NO EXISTE VENTA PARA '.$email.' compra un paquete en https://guibis.com/suscripcion?codigo=5136']);
    }

    if ($noticia == 'VENTA EXISTENTE') {


      $cantidad = $datos['CANTIDAD'];

      $sql_cantidad_mensajes = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_mensajes  FROM
      envio_mensajes WHERE envio_mensajes.iduser =  '$iduser' AND envio_mensajes.producto ='5136'");
      $data_cantidad_mensajes = mysqli_fetch_array($sql_cantidad_mensajes);
      $cantidad_mensajes      = $data_cantidad_mensajes['cantidad_mensajes'];

      $mensajes_existentes = $cantidad - $cantidad_mensajes;

      if ($cantidad > $cantidad_mensajes ) {
        // URL de la API a la que te quieres conectar
          $url = 'http://whatsapp.guibis.com:3001/send-message';

          // Los datos que quieres enviar en formato JSON
          $data = array(
              'number' => $numero_wsp,
              'message' => $mensaje
          );
          $data_json = json_encode($data);

          // Inicializa cURL
          $ch = curl_init($url);

          // Configura las opciones de cURL para POST
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Content-Length: ' . strlen($data_json)
          ));

          // Ejecuta la sesión cURL
          $response = curl_exec($ch);


          // Verifica si hubo un error en la solicitud
          if(curl_errno($ch)){
              throw new Exception(curl_error($ch));
          }

          // Cierra la sesión cURL
          curl_close($ch);

          // Decodifica la respuesta JSON
          $responseData = json_decode($response, true);

          // Comprueba la respuesta y realiza una acción basada en ella
          if (isset($responseData['success']) && $responseData['success'] === true) {



              $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

            function getRealIP(){
                      if (isset($_SERVER["HTTP_CLIENT_IP"])){
                          return $_SERVER["HTTP_CLIENT_IP"];
                      }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                          return $_SERVER["HTTP_X_FORWARDED_FOR"];
                      }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
                      {
                          return $_SERVER["HTTP_X_FORWARDED"];
                      }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
                      {
                          return $_SERVER["HTTP_FORWARDED_FOR"];
                      }elseif (isset($_SERVER["HTTP_FORWARDED"]))
                      {
                          return $_SERVER["HTTP_FORWARDED"];
                      }
                      else{
                          return $_SERVER["REMOTE_ADDR"];
                      }

                  }
                  if ($url =='http://localhost') {
                    $direccion_ip =  '186.42.10.32';
                  }else {
                    $direccion_ip = (getRealIP());
                  }

                  $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));

                   $pais              = $datos['country'];
                   $ciudad            = $datos['city'];
                   $provincia         = $datos['regionName'];
                   $lon               = $datos['lon'];
                   $lat               = $datos['lat'];

          $query_insert_historial=mysqli_query($conection,"INSERT INTO envio_mensajes(iduser,producto,mensaje,numero_wsp,ip,pais,ciudad,provincia,lon,lat)
                                    VALUES('$iduser','5136','$mensaje','$numero_wsp','$direccion_ip','$pais','$ciudad','$provincia','$lon','$lat') ");

                    if ($query_insert_historial) {
                        echo json_encode(['noticia' => 'mensaje_enviado' ,'mensajes_restantes' =>$mensajes_existentes]);
                                      // code...
                    }else {
                      echo json_encode(['noticia' => 'mensaje_enviado','mensajes_restantes' =>$mensajes_existentes]);
                      // code...
                    }
          } else {
              // Puedes manejar diferentes respuestas de la API aquí
                echo json_encode(['noticia' => 'No se pudo enviar el mensaje']);
              //echo "No se pudo enviar el mensaje. Respuesta: " . $response;
          }
      }else {
          echo json_encode(['noticia' => 'cantidad_mensajes_limites']);
      }
    }
  }else {
      echo json_encode(['noticia' => 'token de seguridad invalido']);
  }
  }else {
    echo json_encode(['noticia' => 'accion_vacio']);
  }
} else {
    // Envía el mensaje de error
    echo json_encode(['noticia' => 'token_vacio']);
}


 ?>
