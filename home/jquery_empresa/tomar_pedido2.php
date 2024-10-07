<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
if ($_POST['action']=='actualizar_resumen') {

  $query_lista_t = mysqli_query($conection,"SELECT SUM(((pedidos_restaurant.cantidad_producto)*(pedidos_restaurant.valor_unidad))) as
  'compra_total', SUM(((pedidos_restaurant.iva_producto))) AS 'iva_general',
  SUM(((pedidos_restaurant.precio_neto)+(pedidos_restaurant.iva_producto))) AS 'precioncluido_iva',SUM(pedidos_restaurant.descuento) AS 'descuento_total'
  FROM `pedidos_restaurant`
  WHERE pedidos_restaurant.id_emisor = '$iduser' AND  pedidos_restaurant.estado_pedido ='INICIADO' AND pedidos_restaurant.IDROLPUNTOVENTA='ADMIN' ");
  $data_lista_t=mysqli_fetch_array($query_lista_t);

      echo '
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


}



 ?>
