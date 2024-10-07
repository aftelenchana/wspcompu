<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
 include '../facturacion/facturacionphp/lib/PHPMailer/PHPMailerAutoload.php';
 require '../QR/phpqrcode/qrlib.php';



    if ($_POST['action'] == 'crear_cuentas_cobrar') {
      $id_producto                  = $_POST['id_producto'];
      $id_cliente                  = $_POST['id_cliente'];
      $fecha_inicio_pago            = $_POST['fecha_inicio_pago'];
      $fecha_final_pago            = $_POST['fecha_final_pago'];

      $query = mysqli_query($conection, "SELECT * FROM  cuentas_por_cobrar  WHERE  cuentas_por_cobrar.iduser  = '$iduser' ORDER BY id DESC");
        $result = mysqli_fetch_array($query);
        if ($result) {
          $secuencial = $result['secuencial'];
          $secuencial = $secuencial +1;
        }else {
          $secuencial =1;
        }
        $query_producto = mysqli_query($conection,"SELECT * FROM producto_venta WHERE producto_venta.idproducto ='$id_producto'");
        $data_producto = mysqli_fetch_array($query_producto);
        $precio = $data_producto['precio'];



      $query_insert=mysqli_query($conection,"INSERT INTO cuentas_por_cobrar (iduser,secuencial,id_producto,id_cliente,fecha_inicio,fecha_final,debito,credito,pdf,descripcion)
                                                                   VALUES('$iduser','$secuencial','$id_producto','$id_cliente','$fecha_inicio_pago','$fecha_final_pago','$precio','0','','N') ");

      if ($query_insert) {
          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'buscar_producto_c_c') {
      $buscar_producto = $_POST['buscar_producto'];
      $query_producto = mysqli_query($conection,"SELECT * FROM producto_venta WHERE producto_venta.idproducto ='$buscar_producto'");
      $data_producto = mysqli_fetch_array($query_producto);
      echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);

    }

    if ($_POST['action'] == 'buscar_cliente_c') {
      $buscar_clientes = $_POST['buscar_clientes'];
      $query_clientes = mysqli_query($conection,"SELECT * FROM clientes WHERE clientes.id ='$buscar_clientes'");
      $data_clientes = mysqli_fetch_array($query_clientes);
      echo json_encode($data_clientes,JSON_UNESCAPED_UNICODE);

    }

    if ($_POST['action'] == 'agregar_item_asiento_perfomance') {
        $asiento              = $_POST['asiento'];
        $descripcion_concepto = $_POST['descripcion_concepto'];
        $debe                 = $_POST['debe'];
        $haber                = $_POST['haber'];
              $query_insert=mysqli_query($conection,"INSERT INTO asientos_contables (debe,haber,descripcion_concepto,secuencial,iduser)
                                                                           VALUES('$debe', '$haber','$descripcion_concepto','$asiento','$iduser') ");
        if ($query_insert) {
           $arrayName = array('noticia'=>'insert_correct');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
           $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }



    }




 ?>
