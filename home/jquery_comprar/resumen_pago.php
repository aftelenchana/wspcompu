<?php
require '../QR/phpqrcode/qrlib.php';
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
    if ($_POST['action']=='actualizar_resumen') {
      // code...
          $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
          'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
          SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
          FROM `comprobantes`
          WHERE comprobantes.id_emisor = '$iduser'");
          $data_lista_t=mysqli_fetch_array($query_lista_t);
          echo '
          <table id="example2" class="table table-bordered table-hover table-responsive">
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
    }
    if ($_POST['action']=='dar_vuelto') {
      $efectivo = $_POST['efectivo'];
      if ($efectivo == '' || $efectivo== '0') {
            echo "0";
      }else {
        $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
        'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
        SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
        FROM `comprobantes`
        WHERE comprobantes.id_emisor = '$iduser'");
        $data_lista_t=mysqli_fetch_array($query_lista_t);
        $total_venta = (($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total']));
        $vuelto = number_format(($efectivo-  $total_venta),2);
        echo "$vuelto";
      }



    }

    if ($_POST['action']=='facturar_final') {




      $nombres_receptor          = strtoupper($_POST['nombres_receptor']);
      $numero_identidad_receptor = $_POST['numero_identidad_receptor'];
      $id_usuario_receptor       = $_POST['id_usuario_receptor'];
      $tipo_identificacion       = $_POST['tipo_identificacion'];
      $celular_receptor          = $_POST['celular_receptor'];
      $id_receptor               = $_POST['id_usuario_receptor'];
      $tipo_documento_digital    = $_POST['tipo_documento_digital'];
      $email_reeptor             = strtoupper($_POST['email_reeptor']);
      $direccion_reeptor         = strtoupper($_POST['direccion_reeptor']);
      $formas_pago               = $_POST['formas_pago'];
      $estado_financiero               = $_POST['estado_financiero'];
      $limpiar_consola               = $_POST['limpiar_consola'];

      $largo_cadena = strlen($numero_identidad_receptor);

      if ($largo_cadena < 10 || $largo_cadena > 13 ) {
        $arrayName = array('noticia'=>'identificacion_invalida');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
      }


      if (empty($_POST['efectivo'])) {$efectivo = 0;}else {$efectivo= $_POST['efectivo'];}
      if (empty($_POST['vuelto'])) { $vuelto = 0;}else {$vuelto= $_POST['vuelto'];}
        if (empty($_POST['fecha_vencimiento_proforma'])) { $fecha_vencimiento_proforma = 0;}else {$fecha_vencimiento_proforma= $_POST['fecha_vencimiento_proforma'];}


        $query_veri_ruc = mysqli_query($conection,"SELECT * FROM clientes   WHERE identificacion= '$numero_identidad_receptor' AND iduser = $iduser ");
        $result_lista_ruc= mysqli_num_rows($query_veri_ruc);
        if ($result_lista_ruc == 0) {

          $correos = explode(";",$email_reeptor); // Separar los correos por el punto y coma (;)


          // Verificar si hay comas en la cadena
          if (count($correos) > 1) {
              // Si hay comas, obtener el primer correo electrónico después de eliminar los espacios en blanco
              $primerCorreo = trim($correos[0]);
          } else {
              // Si no hay comas, tomar el único correo electrónico después de eliminar los espacios en blanco
              $primerCorreo = trim($email_reeptor);
          }


          $img_nombre = 'guibis_cliente'.md5(date('d-m-Y H:m:s'));
          $qr_img = $img_nombre.'.png';
          $contenido = md5(date('d-m-Y H:m:s').$iduser);

          $direccion = '../img/qr/';
          $filename = $direccion.$qr_img;
          $tamanio = 7;
          $level = 'H';
          $frameSize = 5;
          $contenido = $contenido;
          QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);





          $query_insert_cliente=mysqli_query($conection,"INSERT INTO clientes(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,qr,qr_contenido,sistema)
          VALUES('$nombres_receptor','$primerCorreo','$tipo_identificacion','$direccion_reeptor','$numero_identidad_receptor','$celular_receptor','avatar.png','$iduser','NATURAL','$qr_img','$contenido','facturacion') ");

        }


        $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes   WHERE id_emisor= '$iduser'");
        $resultados_ff = mysqli_fetch_array($query_resultados_ff);
        if ($resultados_ff) {
          $query_agregar_usuario_sin_id = mysqli_query($conection,"UPDATE comprobantes SET nombres_receptor='$nombres_receptor',numero_identidad_receptor='$numero_identidad_receptor',email_reeptor='$email_reeptor',
            direccion_reeptor='$direccion_reeptor', id_receptor='$id_usuario_receptor',tipo_identificacion='$tipo_identificacion',celular_receptor='$celular_receptor',id_receptor='$id_receptor',
            formas_pago='$formas_pago',efectivo='$efectivo',vuelto='$vuelto',estado_financiero='$estado_financiero',limpiar_consola='$limpiar_consola',fecha_vencimiento_proforma='$fecha_vencimiento_proforma',
            IDROLPUNTOVENTA='ADMIN'
            WHERE id_emisor = '$iduser'");
            if ($query_agregar_usuario_sin_id) {
              $arrayName = array('noticia'=>'insert_correct','tipo_documento_digital'=>$tipo_documento_digital);
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
        }else {
          $arrayName = array('noticia'=>'vacio');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }



    }

    if ($_POST['action']=='verificar_cantidad') {
      $cantidad_producto = $_POST['cantidad_producto'];
      $id_producto = $_POST['id_producto'];

      $query_resultados_productos = mysqli_query($conection,"SELECT * FROM producto_venta   WHERE idproducto= '$id_producto'");
      $resultados_producto = mysqli_fetch_array($query_resultados_productos);
      $cantidad_existente = $resultados_producto['cantidad'];

      $query_user = mysqli_query($conection,"SELECT * FROM usuarios   WHERE id= '$iduser'");
      $resultados_user = mysqli_fetch_array($query_user);
      $nombres_user = $resultados_user['nombres'];

      $resultado = $cantidad_existente -$cantidad_producto;
      if ($resultado>=0) {
        $arrayName = array('noticia'=>'positivo','resultado'=>$resultado,'nombres_user'=>$nombres_user);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }else {
        $arrayName = array('noticia'=>'negativo','resultado'=>$resultado*-1,'nombres_user'=>$nombres_user);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
    }

    if ($_POST['action']=='verificar_descuento') {
      $id_producto = $_POST['id_producto'];
      if ($_POST['porcentaje_descuento']=='') {
      $porcentaje_descuento = 0;
      }else {
        $porcentaje_descuento = $_POST['porcentaje_descuento'];
      }

      if ($_POST['cantidad_producto']=='') {
      $cantidad_producto = 0;
      }else {
        $cantidad_producto = $_POST['cantidad_producto'];
      }

      $query_resultados_productos = mysqli_query($conection,"SELECT * FROM producto_venta   WHERE idproducto= '$id_producto'");
      $resultados_producto = mysqli_fetch_array($query_resultados_productos);
      $precio_producto = $resultados_producto['precio'];
      $descuento_total =$precio_producto*$cantidad_producto*$porcentaje_descuento/100;

      $arrayName = array('noticia'=>'insrt_correct','descuento'=>round($descuento_total,2));
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



    }

    if ($_POST['action']=='verificar_descuento_sin_id') {
      if ($_POST['porcentaje_descuento']=='') {
      $porcentaje_descuento = 0;
      }else {
        $porcentaje_descuento = $_POST['porcentaje_descuento'];
      }

      if ($_POST['cantidad_producto']=='') {
      $cantidad_producto = 0;
      }else {
        $cantidad_producto = $_POST['cantidad_producto'];
      }

      if ($_POST['valor_unidad_2']=='') {
      $precio_producto = 0;
      }else {
        $precio_producto = $_POST['valor_unidad_2'];
      }


      $descuento_total =$precio_producto*$cantidad_producto*$porcentaje_descuento/100;

      $arrayName = array('noticia'=>'insrt_correct','descuento'=>round($descuento_total,2));
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



    }




 ?>
