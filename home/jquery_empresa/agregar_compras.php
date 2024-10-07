<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Mesero') {
    include "../sessiones/session_cuenta_mesero.php";

    }

    if ($_SESSION['rol'] == 'Cocina') {
    include "../sessiones/session_cuenta_cocina.php";
    }





mysqli_set_charset($conection, 'utf8'); //linea a colocar
$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
$result_configuracion = mysqli_fetch_array($query_configuracioin);
$ambito_area          =  $result_configuracion['ambito'];

$detalles_factura = $_POST['descripcion_compra'];
$banco_compra = $_POST['banco_compra'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$xml           =    $_FILES['xml_compras'];
$nombre_xml    =    $xml['name'];
$type 				 =    $xml['type'];
$url_temp      =    $xml['tmp_name'];



$extension = pathinfo($nombre_xml, PATHINFO_EXTENSION);
$destino = '../archivos/compras/';
$destino_autorizada = '../archivos/compras_autorizadas/';
$nombre_xml = 'guibis_xml_compra'.md5(date('d-m-Y H:m:s').$iduser);
$nombre_final_xml = $nombre_xml.'.'.$extension;
$src = $destino.$nombre_final_xml;
$src_autorizadas = $destino_autorizada.$nombre_final_xml;
move_uploaded_file($url_temp,$src);
copy($src, $src_autorizadas);

if ($ambito_area == 'prueba') {
  $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$nombre_final_xml.'';
}else {
  $ruta_compra = '../archivos/compras/'.$nombre_final_xml.'';
}




//CODIGO PARA SABER QUE DOCUMENTO ES
 $acceso_factura = simplexml_load_file($ruta_compra);

 $claveAcceso                       = (string)$acceso_factura->numeroAutorizacion[0];

 $cadena = $claveAcceso;
$posicion_inicio = 8;
$longitud = 2;
$subcadena = substr($cadena, $posicion_inicio, $longitud);
if ($subcadena == '01') {
}
if ($subcadena == '03') {
  $arrayName = array('noticia' =>'no_factura','mensaje'=>'LIQUIDACIÓN DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    unlink($ruta_compra);
    exit;
}

if ($subcadena == '04') {
  $arrayName = array('noticia' =>'no_factura','mensaje'=>'NOTA DE CRÉDITO ');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    unlink($ruta_compra);
    exit;
}
if ($subcadena == '05') {
  $arrayName = array('noticia' =>'no_factura','mensaje'=>'NOTA DE DÉBITO');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    unlink($ruta_compra);
    exit;
}
if ($subcadena == '06') {
  $arrayName = array('noticia' =>'no_factura','mensaje'=>'GUÍA DE REMISIÓN');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    unlink($ruta_compra);
    exit;
}

if ($subcadena == '07') {
  $arrayName = array('noticia' =>'no_factura','mensaje'=>'COMPROBANTE DE RETENCIÓN');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    unlink($ruta_compra);
    exit;
}


//CODIGO PARA VER SI ES AUTORIZADA O NO
$filename = '../archivos/compras/'.$nombre_final_xml.'';
$lines = file($filename);
foreach ($lines as $key => $line) {
    if (strpos($line, '<autorizacion>') !== false) {
        unset($lines[$key]);
    }
}
file_put_contents($filename, implode('', $lines));


$xml = file_get_contents($filename );
$nuevo_xml = substr($xml, 0, strpos($xml, '</infoAdicional>') + strlen('</infoAdicional>'));
file_put_contents('../archivos/compras/'.$nombre_final_xml.'', $nuevo_xml);
$xml = file_get_contents($filename);
$nuevo_contenido = $xml . '</factura>';

file_put_contents('../archivos/compras/'.$nombre_final_xml.'', $nuevo_contenido);
if ($ambito_area == 'prueba') {
  $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$nombre_final_xml.'';
}else {
  $ruta_compra = '../archivos/compras/'.$nombre_final_xml.'';
}

 $acceso_factura = simplexml_load_file($ruta_compra);


$claveAcceso                       = $acceso_factura->infoTributaria->claveAcceso;
$ruc_emisor                       = $acceso_factura->infoTributaria->ruc;
$razon_social_emisor             = $acceso_factura->infoTributaria->razonSocial;


$importeTotal                       = $acceso_factura->infoFactura->importeTotal;
//INFORMACION DEL RECEPTOR DE LA FACTURA
    $identificacion_receptor           = (string)$acceso_factura->infoFactura->identificacionComprador;
    $tipo_identificacion_receptor      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
    $razon_socialreceptorr             = (string)$acceso_factura->infoFactura->razonSocialComprador;

    $fechaEmision                      = (string)$acceso_factura->infoFactura->fechaEmision;
    $razonSocialreceptor               = (string)$acceso_factura->infoFactura->razonSocialComprador;
    $identificacionreceptor            = (string)$acceso_factura->infoFactura->identificacionComprador;



       $conte_variable_detalles= $acceso_factura->detalles->detalle;
       //var_dump($acceso_factura->detalles);
       $uig = 0;

       foreach($conte_variable_detalles as $Item){
            //var_dump($acceso_factura->detalles->detalle[$uig]);
           $uig =$uig +1;
         }
         $productos_totales =$uig ;


         if (!empty($_FILES['foto']['name'])) {
           $foto           =    $_FILES['foto'];
           $nombre_foto    =    $foto['name'];
           $type 					 =    $foto['type'];
           $url_temp       =    $foto['tmp_name'];
           $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
           $destino = '../img/uploads/';
           $img_nombre = 'guibis_img'.md5(date('d-m-Y H:m:s').$iduser);
           $imgProducto = $img_nombre.'.'.$extension;
           $src = $destino.$imgProducto;
           move_uploaded_file($url_temp,$src);
         }else {
           $imgProducto = '';
           // code...
         }

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;
    $query_insert=mysqli_query($conection,"INSERT INTO compras_facturacion  (iduser,monto,identificacion_emisor,identificacion_receptor,clave_acceso,fecha_emision_factura,xml,descripcion,razon_social_emisor,banco,tipo_movimiento,productos,boucher,url)
                                            VALUES('$iduser','$importeTotal','$ruc_emisor','$identificacion_receptor','$claveAcceso','$fechaEmision','$nombre_final_xml','$detalles_factura','$razon_social_emisor','$banco_compra','$tipo_movimiento','$productos_totales','$imgProducto','$url2') ");



    if ($query_insert) {
      $arrayName = array('noticia' =>'insert_correct');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      // code...
    }else {
      $arrayName = array('noticia' =>'error_servidor');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }







 exit;


 ?>
