<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 require '../QR/phpqrcode/qrlib.php';


  if ($_POST['action'] == 'informacion_pedido') {
    $secuencial_pedido = $_POST['secuencial_cuenta'];
    $idrolpuntoventa = $_POST['idrolpuntoventa'];

    $fila_pedidos = '';

    $query_pedido = mysqli_query($conection, "SELECT * FROM  pedidos_restaurant  WHERE  pedidos_restaurant.id_emisor  = '$iduser' AND pedidos_restaurant.secuencial ='$secuencial_pedido' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa'  ORDER BY id DESC ");
    while ($result_pedido = mysqli_fetch_array($query_pedido)) {

      $idproducto = $result_pedido['id_producto'];
      //INFORMACION DEL PRODUCTO
      $query_producto = mysqli_query($conection, "SELECT * FROM  producto_venta  WHERE  idproducto='$idproducto' ");
      $result_producto = mysqli_fetch_array($query_producto);


      $fila_pedidos =  '
      <tr>
          <td><img src="/home/img/uploads/'.$result_producto['foto'].'" width="50px" alt=""> </td>
          <td> <a target="_blank" href="ver_producto.php?producto='.$idproducto.'">'.$result_producto['nombre'].'</a>  </td>
          <td>'.$result_pedido['cantidad_producto'].'</td>
          <td>$'.$result_pedido['descuento'].'</td>
          <td>$'.$result_pedido['iva_producto'].'</td>
          <td>$'.$result_pedido['subtotal_frontend'].'</td>
      </tr>'.$fila_pedidos.'
      ';

      $codigo_mesa = $result_pedido['codigo_mesa'];

    }

    $query_lista_t = mysqli_query($conection,"SELECT SUM(((pedidos_restaurant.cantidad_producto)*(pedidos_restaurant.valor_unidad))) as
    'compra_total', SUM(((pedidos_restaurant.iva_producto))) AS 'iva_general',
    SUM(((pedidos_restaurant.precio_neto)+(pedidos_restaurant.iva_producto))) AS 'precioncluido_iva',SUM(pedidos_restaurant.descuento) AS 'descuento_total'
    FROM `pedidos_restaurant`
    WHERE pedidos_restaurant.id_emisor = '$iduser' AND pedidos_restaurant.secuencial ='$secuencial_pedido' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa' ");
    $data_lista_t=mysqli_fetch_array($query_lista_t);
    $resumen_pago_orden = '
    <table id="example2" class="table  table-hover table-responsive">
     <tr class="tabala_ch">
        <th>Subtotal</th>
        <th>12%</th>
        <th>Descuento</th>
        <th>Valor Total</th>
      </tr>
      <tr>
      <td class="out_number">$ '.number_format($data_lista_t['compra_total'],2).'</td>
      <td class="out_number">$ '.number_format(($data_lista_t['iva_general']),2).'</td>
      <td class="out_number">$ '.number_format(($data_lista_t['descuento_total']),2).'</td>
      <td class="out_number">$ '.number_format($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'],2).'</td>
    </tr>
</table>

    ';
    $arrayName = array('fial_pedidos' =>$fila_pedidos,'resumen_pago_orden'=>$resumen_pago_orden,'codigo_mesa'=>$codigo_mesa);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

  }



  if ($_POST['action']=='procesar_pedido_para_factura') {

    			$query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id_emisor = '$iduser' ");

        $secuencial_pedido = $_POST['secuencial_cuenta'];
        $idrolpuntoventa = $_POST['idrolpuntoventa'];
        $query_pedido = mysqli_query($conection, "SELECT * FROM  pedidos_restaurant  WHERE  pedidos_restaurant.id_emisor  = '$iduser' AND pedidos_restaurant.secuencial ='$secuencial_pedido' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa'   ORDER BY id DESC ");
        while ($result_pedido = mysqli_fetch_array($query_pedido)) {
          $id_emisor = $result_pedido['id_emisor'];
          $nombre_producto = $result_pedido['nombre_producto'];
          $descripcion_producto = $result_pedido['descripcion_producto'];
          $valor_unidad = $result_pedido['valor_unidad'];
          $cantidad_producto = $result_pedido['cantidad_producto'];
          $tipo_ambiente = $result_pedido['tipo_ambiente'];
          $codigos_impuestos = $result_pedido['codigos_impuestos'];
          $detalle_extra = $result_pedido['detalle_extra'];
          $precio_neto = $result_pedido['precio_neto'];
          $iva_producto = $result_pedido['iva_producto'];
          $precio_p_incluido_iva = $result_pedido['precio_p_incluido_iva'];
          $id_producto = $result_pedido['id_producto'];
          $descuento = $result_pedido['descuento'];
          $iva_frontend = $result_pedido['iva_frontend'];
          $subtotal_frontend = $result_pedido['subtotal_frontend'];
          $imagen = $result_pedido['imagen'];
          $qr_contenido = $result_pedido['qr_contenido'];

          $query_insert=mysqli_query($conection,"INSERT INTO comprobantes (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,CODIGO_INTERNO_PEDIDO,modulo,IDROLPUNTOVENTA)
          VALUES('$iduser','$nombre_producto', '$descripcion_producto', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','$detalle_extra','$precio_neto','$iva_producto','$precio_p_incluido_iva','$id_producto','$descuento','$iva_frontend','$subtotal_frontend','$qr_contenido','restaurant','$idrolpuntoventa')");


        }



        $numero_identidad_receptor = $_POST['numero_identidad_receptor'];
        $id_usuario_receptor       = $_POST['id_usuario_receptor'];
        $tipo_identificacion       = $_POST['tipo_identificacion'];
        $celular_receptor          = $_POST['celular_receptor'];
        $id_receptor               = $_POST['id_usuario_receptor'];
        $tipo_documento_digital    = $_POST['tipo_documento_digital'];
        $email_reeptor             = strtoupper($_POST['email_reeptor']);
        $direccion_reeptor         = strtoupper($_POST['direccion_reeptor']);
        $formas_pago               = $_POST['formas_pago'];
        $nombres_receptor          = strtoupper($_POST['nombres_receptor']);
        $query_agregar_cambio_estado = mysqli_query($conection,"UPDATE pedidos_restaurant SET estado_pedido='FINALIZADO',documento_emitido='$tipo_documento_digital' WHERE pedidos_restaurant.secuencial = '$secuencial_pedido' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa' AND pedidos_restaurant.id_emisor = '$iduser' ");


              if (empty($_POST['efectivo'])) {$efectivo = 0;}else {$efectivo= $_POST['efectivo'];}
              if (empty($_POST['vuelto'])) { $vuelto = 0;}else {$vuelto= $_POST['vuelto'];}

                $query_veri_ruc = mysqli_query($conection,"SELECT * FROM clientes   WHERE identificacion= '$numero_identidad_receptor' AND iduser = $iduser ");
                $result_lista_ruc= mysqli_num_rows($query_veri_ruc);
                if ($result_lista_ruc == 0) {
                  $query_insert_cliente=mysqli_query($conection,"INSERT INTO clientes(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente)
                  VALUES('$nombres_receptor','$email_reeptor','$tipo_identificacion','$direccion_reeptor','$numero_identidad_receptor','$celular_receptor','avatar.png','$iduser','NATURAL') ");

                }



              $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes   WHERE id_emisor= '$iduser'");
              $resultados_ff = mysqli_fetch_array($query_resultados_ff);
              if ($resultados_ff) {
                $query_agregar_usuario_sin_id = mysqli_query($conection,"UPDATE comprobantes SET nombres_receptor='$nombres_receptor',numero_identidad_receptor='$numero_identidad_receptor',email_reeptor='$email_reeptor',
                  direccion_reeptor='$direccion_reeptor', id_receptor='$id_usuario_receptor',tipo_identificacion='$tipo_identificacion',celular_receptor='$celular_receptor',id_receptor='$id_receptor',
                  formas_pago='$formas_pago',efectivo='$efectivo',vuelto='$vuelto'
                  WHERE id_emisor = '$iduser'");
                  if ($query_agregar_usuario_sin_id) {
                    $arrayName = array('noticia'=>'insert_correct','tipo_documento_digital'=>$tipo_documento_digital);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                  }
                }else {
                  $arrayName = array('noticia'=>'vacio');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }



    // code...
  }

  if ($_POST['action']=='eliminar_pedido') {
    $pedido = $_POST['pedido'];
      $idrolpuntoventa = $_POST['idrolpuntoventa'];
        $secuencial = $_POST['secuencial'];

    $query_eliminar_pedido = mysqli_query($conection,"UPDATE pedidos_restaurant SET estatus='0'   WHERE pedidos_restaurant.id_emisor = '$iduser' AND pedidos_restaurant.secuencial ='$secuencial' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa'");
    if ($query_eliminar_pedido) {
      $arrayName = array('noticia'=>'insert_correct','pedido'=>$pedido);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      $arrayName = array('noticia'=>'error_servidor');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
    // code...
  }


  if ($_POST['action']=='dar_vuelto') {
    $efectivo = $_POST['efectivo'];
    $secuencial_cuenta = $_POST['secuencial_cuenta'];
    $idrolpuntoventa = $_POST['idrolpuntoventa'];
    if ($efectivo == '' || $efectivo== '0') {
          echo "0";
    }else {
      $query_lista_t = mysqli_query($conection,"SELECT SUM(((pedidos_restaurant.cantidad_producto)*(pedidos_restaurant.valor_unidad))) as
      'compra_total', SUM(((pedidos_restaurant.iva_producto))) AS 'iva_general',
      SUM(((pedidos_restaurant.precio_neto)+(pedidos_restaurant.iva_producto))) AS 'precioncluido_iva',SUM(pedidos_restaurant.descuento) AS 'descuento_total'
      FROM `pedidos_restaurant`
      WHERE pedidos_restaurant.id_emisor = '$iduser' AND pedidos_restaurant.secuencial ='$secuencial_cuenta' AND pedidos_restaurant.IDROLPUNTOVENTA='$idrolpuntoventa' ");
      $data_lista_t=mysqli_fetch_array($query_lista_t);
      $total_venta = (($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total']));
      $vuelto = number_format(($efectivo-  $total_venta),2);
      echo "$vuelto";

    }








  }



 ?>
