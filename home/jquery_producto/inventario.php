<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

if ($_POST['action'] == 'disminuir_produc') {
  $cantidad_disminuir = $_POST['cantidad_disminuir'];
  $motivo_disminucion = $_POST['motivo_disminucion'];
  $detalles_extras    = $_POST['detalles_extras'];
  $idproducto         = $_POST['idproducto'];

  $query_lista = mysqli_query($conection,"SELECT * FROM producto_venta where estatus = 1 and producto_venta.idproducto=$idproducto ");
  $data_lista=mysqli_fetch_array($query_lista);
  $cantidad_producto = $data_lista['cantidad'];
  $cantidad_new  = $cantidad_producto - $cantidad_disminuir;
  if ($cantidad_new < 0) {
        $arrayName = array('noticia' =>'numero_invalido');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
  }


  $query_edit_cantidad = mysqli_query($conection,"UPDATE producto_venta SET cantidad='$cantidad_new' WHERE idproducto = '$idproducto'");
  $query_insert=mysqli_query($conection,"INSERT INTO inventario(cantidad,motivo,detalles_extras,idproducto,iduser,cantidad_new,accion )
                                                              VALUES('$cantidad_disminuir','$motivo_disminucion','$detalles_extras','$idproducto','$iduser','$cantidad_new','DISMINUIR') ");

      if ($query_insert) {
        $arrayName = array('noticia' =>'insert_correct','cantidad'=>$cantidad_new,'producto'=>$idproducto);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        // code...
      }else {
        $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
 }


 if ($_POST['action'] == 'aumentar_producto') {
   $cantidad_aumentar = $_POST['cantidad_aumentar'];
   $motivo_entrada = $_POST['motivo_entrada'];
   $detalles_extras    = $_POST['detalles_extras'];
   $idproducto         = $_POST['idproducto'];

   $query_lista = mysqli_query($conection,"SELECT * FROM producto_venta where estatus = 1 and producto_venta.idproducto=$idproducto ");
   $data_lista=mysqli_fetch_array($query_lista);
   $cantidad_producto = $data_lista['cantidad'];
   $cantidad_new  = $cantidad_producto + $cantidad_aumentar;


   $query_edit_cantidad = mysqli_query($conection,"UPDATE producto_venta SET cantidad='$cantidad_new' WHERE idproducto = '$idproducto'");
   $query_insert=mysqli_query($conection,"INSERT INTO inventario(cantidad,motivo,detalles_extras,idproducto,iduser,cantidad_new,accion )
                                                               VALUES('$cantidad_aumentar','$motivo_entrada','$detalles_extras','$idproducto','$iduser','$cantidad_new','AUMENTAR') ");

       if ($query_insert && $query_edit_cantidad) {
         $arrayName = array('noticia' =>'insert_correct','cantidad'=>$cantidad_new,'producto'=>$idproducto);
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         // code...
       }else {
         $arrayName = array('noticia' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }
  }
 ?>
