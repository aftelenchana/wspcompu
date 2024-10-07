<?php

session_start();
$iduser= $_SESSION['id'];
include "../../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
$result_configuracion = mysqli_fetch_array($query_configuracioin);
$ambito_area          =  $result_configuracion['ambito'];

$estado_fisico = $_POST['estado_factura'];
if ($estado_fisico == 'digital') {
  $numero_autorizacion = $_POST['xml_nota_credito'];
}
if ($estado_fisico == 'fisico') {
  // code...
  $xml           =    $_FILES['xml_nota_credito'];
  $nombre_xml    =    $xml['name'];
  $type 					 =    $xml['type'];
  $url_temp       =    $xml['tmp_name'];

  $extension = pathinfo($nombre_xml, PATHINFO_EXTENSION);
  $destino = '../nota_credito/';
  $nombre_xml = 'guibis_xml'.md5(date('d-m-Y H:m:s').$iduser);
  $nombre_final_xml = $nombre_xml.'.'.$extension;
  $src = $destino.$nombre_final_xml;
  move_uploaded_file($url_temp,$src);
  //VAMOS A SACAR LA INFORMACION DEL XML
  $archivo_subido = simplexml_load_file($nombre_final_xml);
  $json_archivo_subido = json_encode($archivo_subido); // convert the XML string to JSON
  $array_archivo_subido = json_decode($json_archivo_subido, true);
  $numero_autorizacion =$array_archivo_subido['numeroAutorizacion'];

}






 if ($ambito_area == 'prueba') {
   $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$numero_autorizacion.'.xml';

     if (is_file($ruta_factura)) {

      $acceso_factura = simplexml_load_file($ruta_factura);

    //INFORMACION DEL DOCUMENTO
    $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

     //para crear el numero dl documento necesito de 4 partes
      $estab                       = $acceso_factura->infoTributaria->estab;
      $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
      $secuencial                  = $acceso_factura->infoTributaria->secuencial;
    $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';



    //informacion del comprador
      $identificacion_comprador           = (string)$acceso_factura->infoFactura->identificacionComprador;
      $tipo_identificacion_comprador      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
      $razon_social_comprador             = (string)$acceso_factura->infoFactura->razonSocialComprador;

      $fechaEmision             = (string)$acceso_factura->infoFactura->fechaEmision;
      $razonSocialComprador     = (string)$acceso_factura->infoFactura->razonSocialComprador;
      $identificacionComprador  = (string)$acceso_factura->infoFactura->identificacionComprador;

      //valor total de la factura
      $valor_totald_factura                = (string)$acceso_factura->infoFactura->importeTotal;
      $conte_variable_impuestos= (string)$acceso_factura->infoFactura->totalConImpuestos;
      $conte_variable_detalles= (string)$acceso_factura->detalles->detalle;



            if ($numDocModificado != '') {
              $arrayName = array('noticia' =>'si_da','clave_acceso'=>$numero_autorizacion,'valor_total'=>$valor_totald_factura,
            'fechaEmision'=>$fechaEmision,'razonSocialComprador'=>$razonSocialComprador,'identificacionComprador'=>$identificacionComprador);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }else {
              $arrayName = array('noticia' =>'vacio_consola');
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }


    }else {
      $arrayName = array('noticia' =>'no_encuentra_archivo');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      // code...
    }

 }else {
   $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$numero_autorizacion' ");
   $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
   $ininterno = $data_existencia['id'];
   $url_file_upload = $data_existencia['url_file_upload'];
   $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$numero_autorizacion.'.xml';
   function urlExists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

if (urlExists($ruta_factura)) {


   $acceso_factura = simplexml_load_file($ruta_factura);

 //INFORMACION DEL DOCUMENTO
 $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

  //para crear el numero dl documento necesito de 4 partes
   $estab                       = $acceso_factura->infoTributaria->estab;
   $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
   $secuencial                  = $acceso_factura->infoTributaria->secuencial;
 $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';



 //informacion del comprador
   $identificacion_comprador           = (string)$acceso_factura->infoFactura->identificacionComprador;
   $tipo_identificacion_comprador      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
   $razon_social_comprador             = (string)$acceso_factura->infoFactura->razonSocialComprador;

   $fechaEmision             = (string)$acceso_factura->infoFactura->fechaEmision;
   $razonSocialComprador     = (string)$acceso_factura->infoFactura->razonSocialComprador;
   $identificacionComprador  = (string)$acceso_factura->infoFactura->identificacionComprador;

   //valor total de la factura
  $valor_totald_factura                = (string)$acceso_factura->infoFactura->importeTotal;
   $conte_variable_impuestos= (string)$acceso_factura->infoFactura->totalConImpuestos;
   $conte_variable_detalles= (string)$acceso_factura->detalles->detalle;



         if ($numDocModificado != '') {
           $arrayName = array('noticia' =>'si_da','clave_acceso'=>$numero_autorizacion,'valor_total'=>$valor_totald_factura,
         'fechaEmision'=>$fechaEmision,'razonSocialComprador'=>$razonSocialComprador,'identificacionComprador'=>$identificacionComprador);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }else {
           $arrayName = array('noticia' =>'vacio_consola');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }


 }else {
   $arrayName = array('noticia' =>'no_encuentra_archivo');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   // code...
 }




 }






exit;




 ?>
