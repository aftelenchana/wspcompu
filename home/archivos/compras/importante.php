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
