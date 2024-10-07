<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

       if ($_POST['action'] == 'buscar_suscripciones') {
         $id_cliente = $_POST['cliente'];
         $query_suscripciones = mysqli_query($conection,"SELECT * FROM suscripciones_facturacion WHERE suscripciones_facturacion.idcliente ='$id_cliente' AND iduser = '$iduser'");
         $exustencia_suscripciones = mysqli_num_rows($query_suscripciones);
         if ($exustencia_suscripciones>0) {
           $data_suscripciones = mysqli_fetch_array($query_suscripciones);
           $arrayName = array('noticia' =>'titne_susacripciones','cliente'=>$id_cliente);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
          $arrayName = array('noticia' =>'no_tiene_suscripciones','cliente'=>$id_cliente);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      }



      if ($_POST['action'] == 'agregar_plan_suscripcion') {

        $cliente       = $_POST['cliente'];
        $plan_suscripcion    = $_POST['plan_suscripcion'];
        $descripcion       = $_POST['descripcion'];

        $query_producto = mysqli_query($conection,"SELECT * FROM producto_venta WHERE producto_venta.idproducto ='$plan_suscripcion'");
        $data_producto = mysqli_fetch_array($query_producto);

          $meses_suscripcion       =  $data_producto['meses_suscripcion'];
          $mifecha = new DateTime();
          $mifecha->modify('+'.$meses_suscripcion.' month');
         $fecha_limite_suscripcion =  $mifecha->format('Y-m-d H:i:s');

        $query_insert=mysqli_query($conection,"INSERT INTO suscripciones_facturacion(iduser,idcliente,idsuscripcion,descripcion,fecha_maxima_suscripcion)
                                      VALUES('$iduser','$cliente','$plan_suscripcion','$descripcion','$fecha_limite_suscripcion') ");
        if ($query_insert) {


            $arrayName = array('noticia'=>'insert_correct');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
            $arrayName = array('noticia' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }

      }

 ?>
