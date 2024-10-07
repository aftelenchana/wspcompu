<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
 $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
 $result_configuracion = mysqli_fetch_array($query_configuracioin);
 $ambito_area          =  $result_configuracion['ambito'];
     include 'ctr_xml_guia_remision.php';
     include 'ctr_firmar_guis_remision.php';
     $tipoIdentificacionTransportista = $_POST['tipoIdentificacionTransportista'];
    $clave_acceso_factura            = $_POST['clave_acceso_factura'];
    $direccion_partida               = $_POST['direccion_partida'];
    $razon_social_transportista      = $_POST['razon_social_transportista'];
    $fecha_inicio_transporte         = $_POST['fecha_inicio_transporte'];
    $fecha_final_transporte          = $_POST['fecha_final_transporte'];
    $placa_transportista             = $_POST['placa_transportista'];
    $ruc_transportista               = $_POST['ruc_transportista'];

    $direccion_llegada               = $_POST['direccion_llegada'];
    $motivo_traslado                 = $_POST['motivo_traslado'];

   $fecha_inicio_transporte = date("d/m/Y", strtotime($fecha_inicio_transporte));
   $fecha_final_transporte = date("d/m/Y", strtotime($fecha_final_transporte));

    if ($ambito_area == 'prueba') {
      $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

    }else {
      $ruta_factura = '../comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
    }
    if (!is_file($ruta_factura)) {
      $arrayName = array('noticia' =>'no_existe_archivo');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;

    }


     $xmlf=new xml();
     $xmlf->xmlFactura($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado);


     $xmla=new autorizar();
     $xmla->autorizar_xml($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado);

     // code...





?>
