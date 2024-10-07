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



    if ($_POST['action']=='actualizar_resumen') {
      $codigo_factura = $_POST['codigoFactura'];
      // code...
      $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
      $data_lista_t=mysqli_fetch_array($query_lista_t);

      $descuento_total = $data_lista_t['descuento_total'];
      $iva_general_real = $data_lista_t['iva_general'];


             //codigo para sacr el 12 %
      $query_lista_12 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '2'");
      $data_lista_12=mysqli_fetch_array($query_lista_12);

      //codigo para sacr el 12 %
      $compra_total_iva = $data_lista_12['compra_total']-$data_lista_12['descuento_total'];

      //codigo para sacr el 0%

      $query_lista_base_0 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '0'");
      $data_lista_t_base_0=mysqli_fetch_array($query_lista_base_0);

       $compra_total_base_cero = $data_lista_t_base_0['compra_total']-$data_lista_t_base_0['descuento_total'];


       //codigo para sacr el no_objeto

       $query_lista_no_objeto = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
       'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
       SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
       FROM `comprobantes`
       WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '7'");
       $data_lista_no_objeto =mysqli_fetch_array($query_lista_no_objeto);

        $compra_total_no_objeto = $data_lista_no_objeto['compra_total']-$data_lista_no_objeto['descuento_total'];

        //codigo para sacar excento_iva

        $query_lista_excento_iva = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
        'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
        SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
        FROM `comprobantes`
        WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '6'");
        $data_lista_excento_iva =mysqli_fetch_array($query_lista_excento_iva);

         $compra_total_excento_iva = $data_lista_excento_iva['compra_total']-$data_lista_excento_iva['descuento_total'];

             $compra_general = $compra_total_iva + $compra_total_base_cero + $compra_total_no_objeto +$compra_total_excento_iva;

             $total_pagar = round(($compra_general+$data_lista_t['iva_general']),2);


             if (empty($iva_general_real)) {
               $iva_general = '0.00';
               // code...
             }


          $arrayName = array('compra_total_base_cero' =>$compra_total_base_cero,'compra_total_iva' =>$compra_total_iva,'compra_total_no_objeto' =>number_format(($compra_total_no_objeto),2)
        ,'compra_total_excento_iva' =>number_format(($compra_total_excento_iva),2),'subtotal' =>number_format($compra_general,2),'iva_general' =>number_format($iva_general_real,2),'total_pagar' =>number_format(($total_pagar),2)
      ,'descuento_total' =>number_format(($descuento_total),2));
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);





    }




 ?>
