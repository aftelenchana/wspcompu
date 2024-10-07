<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('content-type: application/json; charset=utf-8');

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  include 'ctr_xml_api.php';
  include 'ctr_firmarxml_api.php';
  $JSONData = file_get_contents("php://input");
  $dataObject = json_decode($JSONData);
  $input = (array) $dataObject;
  $produ = $input['productos'];
    if (empty($input['key'])) {
      $data = ['Error' => "298",'noticia'=>'Empty Key'];
      echo $json_info = json_encode($data);
      exit;
    }else {
      $key          = $input['key'];
      $query_lista_t = mysqli_query($conection,"SELECT * FROM `usuarios`
      WHERE id_e = '$key'");
      $existencia_usuario = mysqli_num_rows($query_lista_t);
      if ($existencia_usuario) {
        $data_lista_t=mysqli_fetch_array($query_lista_t);
        $id_usuario_logeado  = $data_lista_t['id'];
      }else {
        $data = ['Error' => "192",'noticia'=>'Key Incorreta'];
        echo $json_info = json_encode($data);
        exit;
      }
    }
    $celular_receptor   = $input['celular_receptor'];
    $direccion_receptor   = $input['direccion_receptor'];
    $email_receptor           = $input['correo'];
    $tipo_identificacion      = $input['tipo_identificacion'];
    $numero_cedula_receptor   = $input['numero_cedula_receptor'];
    $nombres_receptor         = $input['nombres_receptor'];
    $regimen                  = $input['regimen'];
    $contabilidad             = $input['contabilidad'];
    $efectivo                 = $input['efectivo'];
    $vuelto                   = $input['vuelto'];
    $code_sucursal                   = $input['code_sucursal'];



    //codigo para saber el punto de emison y el establecimiento

    $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$code_sucursal'");
    $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

    $direccion_sucursal        = $data_sucursal['direccion_sucursal'];

    $estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
    $punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);

    $fecha_actual = date("d-m-Y");
    $fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));


    //codigo para sacar la secuencia del usuario

    $establecimiento_sinceros        = $data_sucursal['establecimiento'];
    $punto_emision_sinceros        = $data_sucursal['punto_emision'];



    $query_secuencia = mysqli_query($conection,"SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$id_usuario_logeado' ORDER BY id DESC");
    $data_secuencia = mysqli_fetch_array($query_secuencia);
    if ($data_secuencia) {
      $secuencial_actual = $data_secuencia['secuencial'];
       $secuencial = $data_secuencia['secuencial']+1;

    }else {
      $secuencial = 1;
    }






    $rec = 0;
    foreach ($input["productos"] as $key => $value) {
      $cantidad_producto     =($dataObject->productos[$rec]->cantidad_producto);
      $nombre       =($dataObject->productos[$rec]->nombre);
      $descripcion  =($dataObject->productos[$rec]->descripcion);
      $valor_unidad =($dataObject->productos[$rec]->precio);
      $porcentaje_descuento  =($dataObject->productos[$rec]->porcentaje_descuento);
      $tipo_ambiente =($dataObject->productos[$rec]->tipo_ambiente);
      $codigos_impuestos  =($dataObject->productos[$rec]->codigos_impuestos);
      $codigo_producto  =($dataObject->productos[$rec]->codigo_producto);
      $nota_extra1      =($dataObject->productos[$rec]->nota_extra1);
      $nota_extra2      =($dataObject->productos[$rec]->nota_extra2);

      if ($tipo_ambiente == '2') {
      $iva = (12)/100;
      $complementoiva = 1- $iva;
    }else {
      $iva = 0;
      $complementoiva = 1- $iva;
    }

    $cantidad_descuento =round(($valor_unidad*$cantidad_producto*$porcentaje_descuento/100),2);


    $iva_cantidad          = round((($valor_unidad*$cantidad_producto))*$iva,2);
    $iva_frontend          = round((($valor_unidad*$cantidad_producto)-$cantidad_descuento)*$iva,2);
    $subtotal_frontend = ($cantidad_producto*$valor_unidad)-$cantidad_descuento ;
    $precio_neto           = round($cantidad_producto*$valor_unidad,2) ;
    $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);

    $precio_p_incluido_iva = round($precio_p_incluido_iva,2);



      $query_insert_comprobantes=mysqli_query($conection,"INSERT INTO comprobantes (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,nombres_receptor,numero_identidad_receptor,
        tipo_identificacion,email_reeptor,direccion_reeptor,celular_receptor,efectivo,vuelto,secuencial,estado_f,sucursal_facturacion,codigo_secundario,detalle_extra,detalle_extra2,iva_frontend)
                                                               VALUES('$id_usuario_logeado','$nombre', '$descripcion', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','$precio_neto','$iva_cantidad','$precio_p_incluido_iva','','$cantidad_descuento','$nombres_receptor','$numero_cedula_receptor',
                                                                 '$tipo_identificacion','$email_receptor','$direccion_receptor','$celular_receptor','$efectivo','$vuelto','$secuencial','FINALIZADO','$code_sucursal','$codigo_producto','$nota_extra1','$nota_extra2','$iva_frontend') ");

      $rec =$rec+1;
    }






    //codigo para ingresar en formas de pago
    $itera_formas_pago = 0;
    foreach ($input["formas_pago"] as $key => $value) {
      $cantidad_metodo_pago     =($dataObject->formas_pago[$itera_formas_pago]->cantidad_metodo_pago);
      $codigo_forma_pago     =($dataObject->formas_pago[$itera_formas_pago]->codigo_forma_pago);


      $query_insert_metodo_pago=mysqli_query($conection,"INSERT INTO formas_pago_facturacion (iduser,codigo_factura, formaPago,cantidad_metodo_pago,sucursal_facturacion,establecimiento,punto_emision)
     VALUES('$id_usuario_logeado','$secuencial', '$codigo_forma_pago', '$cantidad_metodo_pago','$code_sucursal','$establecimiento_sinceros','$punto_emision_sinceros') ");

     $itera_formas_pago =$itera_formas_pago+1;

    }





   //codigo para validar la cantidad de pago y las formas de formaPago

   $query_forma_pago = mysqli_query($conection,"SELECT SUM(((formas_pago_facturacion.cantidad_metodo_pago))) as 'cantidad_metodo_pago'
     FROM formas_pago_facturacion  WHERE formas_pago_facturacion.iduser ='$id_usuario_logeado' AND formas_pago_facturacion.codigo_factura = '$secuencial'  ");
    $data_forma_pago = mysqli_fetch_array($query_forma_pago);
        $cantidad_metodo_pago_base  = $data_forma_pago['cantidad_metodo_pago'];


        $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
        'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
        SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
        FROM `comprobantes`
        WHERE comprobantes.id_emisor = '$id_usuario_logeado'  AND comprobantes.secuencial = '$secuencial' ");
        $data_lista_t=mysqli_fetch_array($query_lista_t);

        $total_real_factura = (($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total']));


        if ($total_real_factura <= 999) {

                 // Redondeamos a dos decimales.
                 $cantidad_metodo_pago_base = round($cantidad_metodo_pago_base, 2);
                 $total_real_factura = round($total_real_factura, 2);

                 // Ahora puedes hacer la comparación.
                 if ($cantidad_metodo_pago_base != $total_real_factura) {
                   $arrayName = array(
                     'noticia' => 'metodo_pago_diferente_cantidad',
                     'valor_factura' => $total_real_factura,
                     'cantidad_metodo_pago_base' => $cantidad_metodo_pago_base
                   );
                   echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                   exit;
                 } else {

                 }

        }else {

          $cantidad_metodo_pago_base = str_replace(',', '', $cantidad_metodo_pago_base);

          // Luego convertimos las comas en puntos para manejar los decimales.
          $cantidad_metodo_pago_base = str_replace('.', ',', $cantidad_metodo_pago_base);
          $cantidad_metodo_pago_base = floatval($cantidad_metodo_pago_base);

          $total_real_factura = str_replace(',', '', $total_real_factura);
          $total_real_factura = str_replace('.', ',', $total_real_factura);
          $total_real_factura = floatval($total_real_factura);

          // Redondeamos a dos decimales.
          $cantidad_metodo_pago_base = round($cantidad_metodo_pago_base, 2);
          $total_real_factura = round($total_real_factura, 2);

          // Ahora puedes hacer la comparación.
          if ($cantidad_metodo_pago_base != $total_real_factura) {
            $arrayName = array(
              'noticia' => 'metodo_pago_diferente_cantidad',
              'valor_factura' => $total_real_factura,
              'cantidad_metodo_pago_base' => $cantidad_metodo_pago_base
            );
            echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
            exit;
          } else {

          }
        }



    $contenido_colateral_rt = 'facturacion_api';

    $xmlf=new xml();
    $xmlf->xmlFactura($secuencial,$id_usuario_logeado,$contenido_colateral_rt);

    $xmla=new autorizar();
    $xmla->autorizar_xml($secuencial,$id_usuario_logeado,$contenido_colateral_rt);


    header("HTTP/1.1 200 OK");
    //echo json_encode($result);
    exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>
