<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
if ($_POST['action']=='actualizar_resumen') {
$consulta = $_POST['consulta'];
  $query_lista_t = mysqli_query($conection,"SELECT SUM(((consulta_veterinaria.cantidad_producto)*(consulta_veterinaria.valor_unidad))) as
  'compra_total', SUM(((consulta_veterinaria.iva_producto))) AS 'iva_general',
  SUM(((consulta_veterinaria.precio_neto)+(consulta_veterinaria.iva_producto))) AS 'precioncluido_iva',SUM(consulta_veterinaria.descuento) AS 'descuento_total'
  FROM `consulta_veterinaria`
  WHERE consulta_veterinaria.id_emisor = '$iduser' AND  consulta_veterinaria.estado_pedido ='INICIADO' AND consulta_veterinaria.IDROLPUNTOVENTA='ADMIN' AND consulta_veterinaria.consulta = '$consulta' ");
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
