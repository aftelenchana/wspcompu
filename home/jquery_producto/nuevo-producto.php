<?php   include "../../coneccion.php";
  session_start();
  require '../QR/phpqrcode/qrlib.php';
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres_usuario = $result['nombres'];
$apellidos_usuario = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];
if ($nombre_empresa == '') {
  $nombre_empresarial = $nombres_usuario;

}else {
  $nombre_empresarial = $nombre_empresa;

}

$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
$result_configuracion = mysqli_fetch_array($query_configuracioin);
$ambito_area          =  $result_configuracion['ambito'];


  if ($_POST['action'] == 'agregar_producto') {
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
      $imgProducto = 'img_producto.png';
      // code...
    }

    $proveedor           = (isset($_REQUEST['proveedor'])) ? $_REQUEST['proveedor'] : '';
    $codigo_extra           = (isset($_REQUEST['codigo_extra'])) ? $_REQUEST['codigo_extra'] : '';

    $nombre_producto   =  ($_POST['nombre_producto']);
    $precio            =  $_POST['precio'];
    $precio_costo      =  $_POST['precio_costo'];



    //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

    $tipo_ambiente                    =  ($_POST['elejir_tarifa_iva']);
    $codigos_impuestos                =  $_POST['codigos_impuestos'];
    $valor_unidad_final_con_impuestps =  round($_POST['resultado_calculo'],2);



    $provincia         =  $_POST['provincia'];
    $ciudad            =  $_POST['ciudad'];
    $categorias        =  $_POST['categorias'];
    $cantidad          =  $_POST['cantidad'];
    $subcategorias     =  $_POST['subcategorias'];
    $descripcion       =  ($_POST['descripcion']);
    $marca_producto    =  $_POST['marca'];
    $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
    $qr_img = $img_nombre.'.png';
    $contenido = md5(date('d-m-Y H:m:s').$iduser);



                  $direccion = '../img/qr/';
                  $filename = $direccion.$qr_img;
                  $tamanio = 7;
                  $level = 'H';
                  $frameSize = 5;
                  $contenido = $contenido;
                  QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
                   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


    $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(foto,nombre,precio,precio_costo,descripcion,id_usuario,qr,contenido_qr,identificador_trabajo,marca,cantidad,sistema,proveedor,codigo_extra,
                                 tipo_ambiente,codigos_impuestos,valor_unidad_final_con_impuestps,url_upload_img,url_upload_qr)
                                  VALUES('$imgProducto','$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$qr_img','$contenido','producto','$marca_producto','$cantidad','facturacion','$proveedor','$codigo_extra',
                                  '$tipo_ambiente','$codigos_impuestos','$valor_unidad_final_con_impuestps','$url','$url') ");


    //$query_insert=mysqli_query($conection,"INSERT INTO producto_venta(foto,nombre,precio,precio_costo,descripcion,id_usuario,categorias,subcategorias,ciudad,provincia,qr,contenido_qr,identificador_trabajo,marca,cantidad)
      //                            VALUES('$imgProducto','$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$categorias','$subcategorias','$ciudad','$provincia','$qr_img','$contenido','producto','$marca_producto','$cantidad') ");


       $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $iduser  ORDER BY fecha_producto DESC");
       $result = mysqli_fetch_array($query);
       $idproducto = $result['idproducto'];

       if ($query_insert) {

         $arrayName = array('noticia' =>'add_ok_prod','idproduto'=>$idproducto);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }else {
         $arrayName = array('noticia' =>'error');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }
}






if ($_POST['action'] == 'agregar_producto_restaurante') {
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
    $imgProducto = 'img_producto.png';
    // code...
  }

  $proveedor           = (isset($_REQUEST['proveedor'])) ? $_REQUEST['proveedor'] : '';
  $codigo_extra           = (isset($_REQUEST['codigo_extra'])) ? $_REQUEST['codigo_extra'] : '';

  $nombre_producto   =  ($_POST['nombre_producto']);
  $precio            =  $_POST['precio'];
  $precio_costo      =  $_POST['precio_costo'];



  //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

  $tipo_ambiente                    =  ($_POST['elejir_tarifa_iva']);
  $codigos_impuestos                =  $_POST['codigos_impuestos'];
  $valor_unidad_final_con_impuestps =  $_POST['resultado_calculo'];


  $categoria_rst           = (isset($_REQUEST['categoria_rst'])) ? $_REQUEST['categoria_rst'] : '';

  $cantidad          =  $_POST['cantidad'];
  $descripcion       =  ($_POST['descripcion']);
  $marca_producto    =  $_POST['marca'];
  $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
  $qr_img = $img_nombre.'.png';
  $contenido = md5(date('d-m-Y H:m:s').$iduser);




                $direccion = '../img/qr/';
                $filename = $direccion.$qr_img;
                $tamanio = 7;
                $level = 'H';
                $frameSize = 5;
                $contenido = $contenido;
                QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
                   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


  $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(foto,nombre,precio,precio_costo,descripcion,id_usuario,qr,contenido_qr,identificador_trabajo,marca,cantidad,sistema,proveedor,codigo_extra,
                               tipo_ambiente,codigos_impuestos,valor_unidad_final_con_impuestps,categoria_rst,url_upload_img,url_upload_qr)
                                VALUES('$imgProducto','$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$qr_img','$contenido','producto','$marca_producto','$cantidad','cafetech','$proveedor','$codigo_extra',
                                '$tipo_ambiente','$codigos_impuestos','$valor_unidad_final_con_impuestps','$categoria_rst','$url','$url') ");
  //$query_insert=mysqli_query($conection,"INSERT INTO producto_venta(foto,nombre,precio,precio_costo,descripcion,id_usuario,categorias,subcategorias,ciudad,provincia,qr,contenido_qr,identificador_trabajo,marca,cantidad)
    //                            VALUES('$imgProducto','$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$categorias','$subcategorias','$ciudad','$provincia','$qr_img','$contenido','producto','$marca_producto','$cantidad') ");


     $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $iduser  ORDER BY fecha_producto DESC");
     $result = mysqli_fetch_array($query);
     $idproducto = $result['idproducto'];

     if ($query_insert) {

       $arrayName = array('noticia' =>'add_ok_prod','idproduto'=>$idproducto);
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
}




if ($_POST['action'] == 'buscar_producto_factura') {
  $factura = $_POST['factura'];
  $codigoPrincipal_recibido = $_POST['codigoPrincipal'];
  if ($ambito_area == 'prueba') {
    $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$factura.'';
  }else {
    $ruta_compra = '../archivos/compras/'.$factura.'';
  }
  $acceso_factura = simplexml_load_file($ruta_compra);
  $dirMatriz                       = (string)$acceso_factura->infoTributaria->dirMatriz;
  $claveAcceso                       = (string)$acceso_factura->infoTributaria->claveAcceso;
  $ruc_emisor                        = (string)$acceso_factura->infoTributaria->ruc;
  $razon_social_emisor               = (string)$acceso_factura->infoTributaria->razonSocial;
  $obligadoContabilidad               = (string)$acceso_factura->infoFactura->obligadoContabilidad;


  $query_sensor  = mysqli_query($conection,"SELECT * FROM proveedor WHERE  proveedor.identificacion = '$ruc_emisor' AND proveedor.iduser = '$iduser' ");
  $result__sensor= mysqli_num_rows($query_sensor);
  $data_sensor   =mysqli_fetch_array($query_sensor);

  $id_proveedor = $data_sensor['id'];


  $contador_detalles = $acceso_factura->detalles->detalle;
  $base_tdll = 0;
  $base_array_detalle = 1;
  foreach($contador_detalles as $Item){
    $descripcion_producto= (string)$acceso_factura->detalles->detalle[$base_tdll]->descripcion;
    $codigoPrincipal= (string)$acceso_factura->detalles->detalle[$base_tdll]->codigoPrincipal;
    $cantidad= (string)$acceso_factura->detalles->detalle[$base_tdll]->cantidad;
    $cantidad = intval($cantidad);
    $precioUnitario= (string)$acceso_factura->detalles->detalle[$base_tdll]->precioUnitario;
    $descuento= (string)$acceso_factura->detalles->detalle[$base_tdll]->descuento;
    $precioTotalSinImpuesto= (string)$acceso_factura->detalles->detalle[$base_tdll]->precioTotalSinImpuesto;
     $impuestos= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto;
    //CODIGO PARA DETALLES
    $codigo= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigo;
    $codigoPorcentaje= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigoPorcentaje;
    $tarifa= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->tarifa;
    $baseImponible= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->baseImponible;

    $valor= (string)$acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->valor;
     $base_tdll =$base_tdll +1;
     $base_array_detalle =$base_array_detalle +1;

     if ($codigoPrincipal == $codigoPrincipal_recibido) {
       $arrayName = array('descripcion_producto' =>$descripcion_producto,'codigoPrincipal'=>$codigoPrincipal,'cantidad'=>$cantidad,
     'precioUnitario',$precioUnitario,'baseImponible'=>$baseImponible,'codigoPrincipal'=>$codigoPrincipal,'razon_social_emisor'=>$razon_social_emisor,'id_proveedor_rt'=>$id_proveedor);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }



    }




}
?>
