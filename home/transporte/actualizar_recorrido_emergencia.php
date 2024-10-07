<?php
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


session_start();

if ($_SESSION['rol'] == 'cuenta_empresa') {

  $rol_salida = $_SESSION['rol'];
include "../sessiones/session_cuenta_empresa.php";

}

if ($_SESSION['rol'] == 'Recursos Humanos') {
  $rol_salida = $_SESSION['rol_interno'];
include "../sessiones/session_recursos_humanos.php";

}



if ($_POST['action'] == 'informacion_movimineto') {


  $codigo_movimiento    = $_POST['codigo_movimiento'];

  //echo "este es el codigo de la emergencia  $codigo_movimiento";


  $query_emergencias  = mysqli_query($conection, "SELECT * FROM emergencias  WHERE emergencias.id = '$codigo_movimiento'");
  $data_emergencias   = mysqli_fetch_array($query_emergencias);

        $latitude_origen     = $data_emergencias['latitud'];
        $longitude_origen    = $data_emergencias['longitud'];

        $query_raiz = mysqli_query($conection, "SELECT * FROM recursos_humanos    WHERE recursos_humanos.id =$idrecursos_humanos");
        $data_raiz  =mysqli_fetch_array($query_raiz);

        $latitud_raiz           = $data_raiz['latitud'];
        $longitud_raiz           = $data_raiz['longitud'];


      $arrayName = array('noticia' =>'pedido_ocupado_usuario_activo','latitude_origen' =>$latitude_origen,'longitude_origen' =>$longitude_origen,'latitud_raiz' =>$latitud_raiz,'longitud_raiz' =>$longitud_raiz);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);




}



if ($_POST['action'] == 'ingresar_coordenaas_transporte') {

  $latitud = $_POST['latitud'];
  $longitud = $_POST['longitud'];
  $codigo_movimiento = $_POST['codigo_movimiento'];

  $fecha_actual = date("Y-m-d H:i:s");


  $query_insert=mysqli_query($conection,"INSERT INTO   historial_recorrido_guibis_transporte (viaje,longitud,latitud,fecha)
    VALUES('$codigo_movimiento','$longitud','$latitud','$fecha_actual') ");


  $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa = '$codigo_movimiento'");
  $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
  $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];
  $id_emisor_enviando    = $data_verificador_secuencial['id_emisor'];
  $estado_f    = $data_verificador_secuencial['estado_f'];



  if ($estado_f == 'INICIANDO TRANSPORTE') {
    $query_raiz = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$id_emisor_enviando");
    $data_raiz  =mysqli_fetch_array($query_raiz);
    $nombres_raiz           = $data_raiz['nombres'];
    $firma_electronica_raiz = $data_raiz['firma_electronica'];
    $direccion_raiz         = $data_raiz['direccion'];
    $codigo_sri_raiz        = $data_raiz['codigo_sri'];
    $estableciminento_raiz  = $data_raiz['estableciminento_f'];
    $punto_emision_raiz     = $data_raiz['punto_emision_f'];
    $porcentaje_iva_raiz    = $data_raiz['porcentaje_iva_f'];
    $apellidos_raiz         = $data_raiz['apellidos'];
    $img_logo_raiz          = $data_raiz['img_facturacion'];
    $nombre_empresa_raiz          = $data_raiz['nombre_empresa'];
    $latitud_raiz          = $data_raiz['latitud'];
    $longitud_raiz          = $data_raiz['longitud'];
    function calcularDistancia($lat1, $lon1, $lat2, $lon2) {
      $radioTierra = 6371; // Radio de la tierra en km
      $dLat = deg2rad($lat2 - $lat1);
      $dLon = deg2rad($lon2 - $lon1);
      $a = sin($dLat/2) * sin($dLat/2) +
           cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
           sin($dLon/2) * sin($dLon/2);
      $c = 2 * atan2(sqrt($a), sqrt(1-$a));
      $distancia = $radioTierra * $c; // Distancia en km
      return $distancia * 1000; // Distancia en metros
  }

  $latitudUsuario = $_POST['latitud'];
  $longitudUsuario = $_POST['longitud'];

  // Coordenadas del destino
  $latitudDestino = -0.093805;
  $longitudDestino = -78.449199;

  $distancia = calcularDistancia($latitud, $longitud, $latitud_raiz, $longitud_raiz);

  if ($distancia <= 30) {
    $arrayName = array('noticia' =>'habilitar_recogida_pedido_cocina');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  } else {
    $arrayName = array('noticia' =>'no_habilitar');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

  }




    if ($estado_f == 'TRANSPORTANDO') {
        $latitude_origen    = $data_verificador_secuencial['latitude_origen'];
        $longitude_origen    = $data_verificador_secuencial['longitude_origen'];

      function calcularDistancia($lat1, $lon1, $lat2, $lon2) {
        $radioTierra = 6371; // Radio de la tierra en km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distancia = $radioTierra * $c; // Distancia en km
        return $distancia * 1000; // Distancia en metros
    }

    $latitudUsuario = $_POST['latitud'];
    $longitudUsuario = $_POST['longitud'];

    // Coordenadas del destino
    $latitudDestino = -0.093805;
    $longitudDestino = -78.449199;

    $distancia = calcularDistancia($latitud, $longitud, $latitude_origen, $longitude_origen);

    if ($distancia <= 30) {
      $arrayName = array('noticia' =>'habilitar_entrega_final');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    } else {
      $arrayName = array('noticia' =>'no_habilitar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

    }

    if ($estado_f == 'ENTREGADO-FINALIZADO') {
      $arrayName = array('noticia' =>'entregado_finalizado');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

    }


}






 ?>
