<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar


if ($_POST['action'] == 'busqueda_producto') {
  $producto = $_POST['producto'];
  $query_producto = mysqli_query($conection, "SELECT *
    FROM producto_venta   WHERE idproducto = $producto
      AND producto_venta.estatus = 1");
      $data_producto = mysqli_fetch_array($query_producto);

echo '       <form method="post" name="agregar_cantidad_producto" id="agregar_cantidad_producto" onsubmit="event.preventDefault(); sendData_agregar_canntidad();">
        <div class="row">
        <p class="col-4">Nombre del Producto:</p>
          <div class="col-8">
            <input type="text" class="form-control form-control-sm" name="nombre_producto" value="'.$data_producto['nombre'].'" placeholder="Ingrese nombre del producto" required>
          </div>
          <p class="col-4">Cantidad:</p>
          <div class="col-8">
            <input class="form-control form-control-sm" type="number" name="cantidad_producto" value="" placeholder="Ingrese la cantidad de producto" required>
          </div>
          <p class="col-4">Precio de Venta por Unidad</p>
          <div class="col-8">
          <select class="form-control form-control-sm" name="tipo_ambiente" required>
          <option value="unidad">Unidad /'.$data_producto['precio'].'</option>
          <option value="docena">Docenas/'.$data_producto['precio_docena'].'</option>
          <option value="cientos">Cientos/'.$data_producto['precio_cientos'].' </option>
        </select>
          </div>
          <p class="col-4">Tarifa IVA</p>
          <div class="col-8">
          <select class="form-control form-control-sm" name="tipo_ambiente" required>
          <option value="2">CON IVA</option>
          <option value="0">SIN IVA</option>
          <option value="6">Exento de IVA </option>
          <option value="7">No Objeto de Impuesto </option>
        </select>
          </div>
          <p class="col-4">Códigos de los impuestos</p>
          <div class="col-8">
          <select class="form-control form-control-sm" name="codigos_impuestos" required>
          <option value="2">IVA</option>
          <option value="3">ICE</option>
          <option value="5">IRBPNR</option>
        </select>
          </div>
          <p class="col-4">Descripción del Producto</p>
          <div class="col-8">
          <input type="text" class="form-control form-control-sm" name="descripcion_producto" rows="8" cols="50" required value="'.$data_producto['descripcion'].'">
          </div>
          <p class="col-4">Detalle Extra</p>
          <div class="col-8">
          <input class="form-control form-control-sm" type="text" name="detalle_extra" value="" placeholder="Ingrese el detalle Adicional">
          </div>
          <div class="d-flex align-items-center justify-content-center sbn_a col-12">
          <input type="submit" class="btn btn-primary" value="Agregar Producto"></div>
          <br>
          <div class="notificacion_add_producto">
          </div>
        </div>
      </form>';
}

if ($_POST['action'] == 'buscar_usuarios') {
  $usario_tabla = $_POST['usario_tabla'];
  $query_producto = mysqli_query($conection, "SELECT *   FROM clientes   WHERE clientes.identificacion = $usario_tabla");
      $data_producto = mysqli_fetch_array($query_producto);

echo '        <div class="tabala_ch">
        <form class="" method="post" name="agregar_usuario_receptor" id="agregar_usuario_receptor" onsubmit="event.preventDefault(); sendData_agregar_usuario_receptor();">
          <table>
            <tr>
              <td>Nombres:</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="nombres_receptor" value="'.$data_producto['nombres'].'" required placeholder="Nombre del usuario"> </td>
            </tr>
            <tr>
              <td>Tipo de identificación</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="tipo_identificacion" value="'.$data_producto['tipo_identificacion'].'" required> </td>
            </tr>
            <tr>
              <td>Cedula o Ruc</td>
              <td> <input style="width: 80%;text-align: center;" type="text" class="clase_consumidor_final" name="numero_identidad_receptor" value="'.$data_producto['identificacion'].'" required placeholder="Ingrese cedula de identidad"> </td>
            </tr>

            <tr>
              <td>Email</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="email_reeptor" value="'.$data_producto['mail'].'" required placeholder=" Ingrese email del usuario "> </td>
            </tr>
            <tr>
              <td>Direccion</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="direccion_reeptor" value="'.$data_producto['direccion'].'" required placeholder="Ingrese la direccion"> </td>
            </tr>
            <tr>
              <td>Celular Receptor</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="celular_receptor" value="'.$data_producto['celular'].'" required placeholder="Ingrese el Celular"> </td>
            </tr>
            <tr>
              <td>ID (Opcional)</td>
              <td> <input style="width: 80%;text-align: center;" type="text" name="id_usuario_receptor" value="'.$data_producto['id'].'" readonly  > </td>
            </tr>
          </table>
          <div class="">
            <input type="hidden" name="action" value="agregar_usuario_sin_id">
            <div class="sub_rcpt_factura">
              <input type="submit" name="" value="Agregar Receptor de Factura">
            </div>
            <div class="notificacion_add_usuario_recpetor">

            </div>
          </div>
        </form>
      </div>
          ';
}




if ($_POST['action'] == 'agregar_cantidad') {
    $tipo_ambiente       = $_POST['tipo_ambiente'];
    $nombre_producto      = $_POST['nombre_producto'];
    $cantidad_producto    = $_POST['cantidad_producto'];
    $valor_unidad         = $_POST['valor_unidad'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $detalle_extra        = $_POST['detalle_extra'];
    $codigos_impuestos    = $_POST['codigos_impuestos'];
    if ($tipo_ambiente == '2') {
      $iva = (12)/100;
      $complementoiva = 1- $iva;
      // code...
    }else {
      $iva = 0;
      $complementoiva = 1- $iva;
    }


        $precio_neto = $cantidad_producto*$valor_unidad;
        $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);
        $iva_producto = $valor_unidad*$iva;
        date_default_timezone_set("America/Lima");
        $fecha_actual = date('d-m-Y H:m:s', time());
        $codigo_factura = $iduser.md5(date('d-m-Y H:m:s')).$iduser;

        $query_insert=mysqli_query($conection,"INSERT INTO comprobantes(detalle_extra,id_emisor,nombre_producto,cantidad_producto,descripcion_producto,valor_unidad,precio_neto,tipo_ambiente,iva_producto,precio_p_incluido_iva,codigos_impuestos)
                                                                    VALUES('$detalle_extra','$iduser','$nombre_producto','$cantidad_producto','$descripcion_producto','$valor_unidad','$precio_neto','$tipo_ambiente','$iva_producto','$precio_p_incluido_iva','$codigos_impuestos') ");

      echo '    <div class="card-body tabala_ch">
            <table class="table table-bordered table-hover table-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>P/U</th>
                <th>Precio</th>
                <th>Iva/P</th>
                <th>Descripcion</th>
                <th>Detalle Extra</th>
                <th>Eliminar</th>
              </tr>
              </thead>
              <tbody>';
              $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
              'compra_total', SUM(((comprobantes.cantidad_producto)*(comprobantes.iva_producto))) AS 'iva_general',
              SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva'
              FROM `comprobantes`
              WHERE comprobantes.id_emisor = '$iduser'");
              $data_lista_t=mysqli_fetch_array($query_lista_t);


      $query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
        WHERE id_emisor= '$iduser'");

      while ($resultados = mysqli_fetch_array($query_resultados)) {
        echo '  <tr>
                <td>'.$resultados['id'].'</td>
                <td style="width: 15%;">'.$resultados['nombre_producto'].'</td>
                <td>'.$resultados['cantidad_producto'].'</td>
                <td>$'.number_format($resultados['valor_unidad'],2).'</td>
                <td>$'.number_format($resultados['precio_neto'],2).'</td>
                <td>$'.number_format($resultados['iva_producto']*$resultados['cantidad_producto'],2).'</td>
                <td style="width: 20%;">'.$resultados['descripcion_producto'].'</td>
                <td style="width: 20%;">'.$resultados['detalle_extra'].'</td>
                  <td align="center"> <a style="color:red;" class="eliminar_producto" idproducto="'.$resultados['id'].'" href="#"><i class="fas fa-trash-alt"></i></a> </p> </td>
              </tr>';

      }
      echo '

        </tbody>';


        echo '        <tfoot class="reslt_componentes">
                <tr class="tabala_ch">
                  <th>Subtotal</th>
                  <th>12%</th>
                  <th>Valor Total</th>
                </tr>
                <tr>
              <tr>
              <td class="out_number">$ '.number_format($data_lista_t['compra_total'],2).'</td>
              <td class="out_number">$ '.number_format(($data_lista_t['iva_general']),2).'</td>
              <td class="out_number">$ '.number_format($data_lista_t['compra_total']+$data_lista_t['iva_general'],2).'</td>
              </tr>
            </table>
              </div>
            </div>';


}


if ($_POST['action'] == 'eliminar_producto_unico') {
    $idproducto       = $_POST['idproducto'];
    $query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id = '$idproducto' ");
    if ($query_delete) {
      $arrayName = array('noticia' =>'insert_correct');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      // code...
    }else {
      $arrayName = array('noticia' =>'error');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }




}

if ($_POST['action'] == 'limpiar_factura') {
  $query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id_emisor = '$iduser' ");
  if ($query_delete) {
    $arrayName = array('noticia' =>'factura_limpia');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    // code...
  }

}
if ($_POST['action'] == 'buscar_producto') {
  $busqueda = $_POST['busqueda'];
  $query_opciones = mysqli_query($conection,"SELECT * FROM producto_venta WHERE (producto_venta.nombre like '%$busqueda%') AND producto_venta.id_usuario= '$iduser'   AND producto_venta.estatus = 1");
  while ($producto = mysqli_fetch_array($query_opciones)) {
    echo '<option onchange ="elejir()"  producto="'.$producto['idproducto'].'" value="'.$producto['idproducto'].'">'.$producto['nombre'].'</option>';

  }
}


if ($_POST['action'] == 'agregar_usuario_sin_id') {
  $nombres_receptor          = strtoupper($_POST['nombres_receptor']);
  $numero_identidad_receptor = $_POST['numero_identidad_receptor'];
  $id_usuario_receptor       = $_POST['id_usuario_receptor'];
  $tipo_identificacion       = $_POST['tipo_identificacion'];
  $celular_receptor          = $_POST['celular_receptor'];

  $email_reeptor             = strtoupper($_POST['email_reeptor']);
  $direccion_reeptor         = strtoupper($_POST['direccion_reeptor']);
  $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes
    WHERE id_emisor= '$iduser'");
    $resultados_ff = mysqli_fetch_array($query_resultados_ff);
    if ($resultados_ff) {
      // code...
      $query_agregar_usuario_sin_id = mysqli_query($conection,"UPDATE comprobantes SET nombres_receptor='$nombres_receptor',numero_identidad_receptor='$numero_identidad_receptor',email_reeptor='$email_reeptor',
        direccion_reeptor='$direccion_reeptor', id_receptor='$id_usuario_receptor',tipo_identificacion='$tipo_identificacion',celular_receptor='$celular_receptor'
        WHERE id_emisor = '$iduser'");
        if ($query_agregar_usuario_sin_id) {
          echo '<div class="notio_positiva" ><p style="background: green;width: 50%;margin: 0 auto;padding: 5px;">Usuario Agregado Correctamente</p></div>';
        }
    }else {
      echo '<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>';
    }
}

if ($_POST['action'] == 'agregar_forma_pago') {

  $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes
    WHERE id_emisor= '$iduser'");
    $resultados_ff = mysqli_fetch_array($query_resultados_ff);
    if ($resultados_ff) {
      $formas_pago = $_POST['formas_pago'];
          $query_agregar_usuario_sin_id = mysqli_query($conection,"UPDATE comprobantes SET formas_pago='$formas_pago'
            WHERE id_emisor = '$iduser'");
            if ($query_agregar_usuario_sin_id) {

                        $arrayName = array('noticia'=>'insert_correct');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);        }
    }else {
      $arrayName = array('noticia'=>'vacio');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

}
 ?>
