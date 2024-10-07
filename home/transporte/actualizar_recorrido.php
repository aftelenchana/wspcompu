<?php
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
require '../QR/phpqrcode/qrlib.php';

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
session_start();
$id_transporte= $_SESSION['id'];

$query_transporte = mysqli_query($conection, "SELECT * FROM transporte_guibis    WHERE transporte_guibis.id =$id_transporte");
$data_transporte =mysqli_fetch_array($query_transporte);
$nombres_transporte          = $data_transporte['nombres'];
$direccion_transpporte          = $data_transporte['direccion'];
$mail_transporte               = $data_transporte['mail'];
$iduser_raiz                = $data_transporte['iduser'];
$cambio_password_transporte   = $data_transporte['cambio_password'];
$foto_transporte              = $data_transporte['foto'];
$fecha_registro_transporte    = $data_transporte['fecha'];
$url_img_upload_transporrte     = $data_transporte['url_img_upload'];
$identificacion_transporte     = $data_transporte['identificacion'];
$foto_transporte               = $data_transporte['foto'];
$ciudad_transporte               = $data_transporte['ciudad'];
$telefono_transporte               = $data_transporte['telefono'];
$celular_transporte               = $data_transporte['celular'];

if ($_POST['action'] == 'informacion_movimineto') {


  $codigo_movimiento    = $_POST['codigo_movimiento'];


  $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa = '$codigo_movimiento'");
  $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
  $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];



        $id_emisor_enviando    = $data_verificador_secuencial['id_emisor'];
        $latitude_origen    = '-2.059148978871448';
        $longitude_origen    = '-79.88914003535304';


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
        $latitud_raiz           = $data_raiz['latitud'];
        $longitud_raiz           = $data_raiz['longitud'];




      $arrayName = array('noticia' =>'pedido_ocupado_usuario_activo','latitude_origen' =>$latitude_origen,'longitude_origen' =>$longitude_origen,'latitud_raiz' =>'-0.2140894','longitud_raiz' =>'-78.4961882');
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
