<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
    if ($_POST['action']=='facturar_proforma') {

      $query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id_emisor = '$iduser' ");

      $codigo_proforma = $_POST['codigo_proforma'];

      mysqli_query($conection,"SET lc_time_names = 'es_ES'");
      $query_proforma = mysqli_query($conection,"SELECT * FROM `proformas`
        WHERE proformas.id_emisor  = '$iduser' AND proformas.id = '$codigo_proforma'");
        $data_proforma=mysqli_fetch_array($query_proforma);
        $clave_acceso = $data_proforma['clave_acceso'];

        mysqli_query($conection,"SET lc_time_names = 'es_ES'");
        $query_lista = mysqli_query($conection,"SELECT * FROM `proformas`
        WHERE proformas.id_emisor  = '$iduser' AND proformas.clave_acceso = '$clave_acceso'
        ORDER BY `proformas`.`id` DESC");
        $result_lista= mysqli_num_rows($query_lista);
        if ($result_lista > 0) {
        while ($resultados=mysqli_fetch_array($query_lista)) {

          //EMPESAMOS A SACAR LA INFORMACION DEL COMPROBANTE PARA PASAR AL PROFORMAS
          $id_emisor = $resultados['id_emisor'];
          $nombre_producto = $resultados['nombre_producto'];
          $descripcion_producto = $resultados['descripcion_producto'];
          $valor_unidad = $resultados['valor_unidad'];
          $cantidad_producto = $resultados['cantidad_producto'];
          $tipo_ambiente = $resultados['tipo_ambiente'];
          $codigos_impuestos = $resultados['codigos_impuestos'];
          $detalle_extra = $resultados['detalle_extra'];
          $precio_neto = $resultados['precio_neto'];
          $iva_producto = $resultados['iva_producto'];
          $precio_p_incluido_iva = $resultados['precio_p_incluido_iva'];
          $id_producto = $resultados['id_producto'];
          $descuento = $resultados['descuento'];
          $iva_frontend = $resultados['iva_frontend'];
          $subtotal_frontend = $resultados['subtotal_frontend'];
          $imagen = $resultados['imagen'];



          $nombres_receptor = $resultados['nombres_receptor'];
          $numero_identidad_receptor = $resultados['numero_identidad_receptor'];
          $email_reeptor = $resultados['email_reeptor'];
          $direccion_reeptor = $resultados['direccion_reeptor'];
          $id_receptor = $resultados['id_receptor'];
          $tipo_identificacion = $resultados['tipo_identificacion'];
          $celular_receptor = $resultados['celular_receptor'];
          $id_receptor = $resultados['id_receptor'];
          $formas_pago = $resultados['formas_pago'];
          $efectivo = $resultados['efectivo'];
          $vuelto = $resultados['vuelto'];
          $estado_financiero = $resultados['estado_financiero'];
          $limpiar_consola = $resultados['limpiar_consola'];

          $query_insert=mysqli_query($conection,"INSERT INTO comprobantes (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,
           nombres_receptor, numero_identidad_receptor,email_reeptor,direccion_reeptor,id_receptor,tipo_identificacion,celular_receptor,formas_pago,efectivo,vuelto)
          VALUES('$iduser','$nombre_producto', '$descripcion_producto', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','$detalle_extra','$precio_neto','$iva_producto','$precio_p_incluido_iva','$id_producto','$descuento','$iva_frontend','$subtotal_frontend',
          '$nombres_receptor', '$numero_identidad_receptor','$email_reeptor','$direccion_reeptor','$id_receptor','$tipo_identificacion','$celular_receptor','$formas_pago','$efectivo','$vuelto')");
         }
        }

        if ($query_insert) {
          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          $arrayName = array('noticia'=>'error');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }



    }

 ?>
