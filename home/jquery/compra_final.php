<?php
include "../../coneccion.php";
     session_start();
     $iduser= $_SESSION['id'];



if  ($_POST['action'] == 'enviar_boucher') {
  $codigounico  = $_POST['numero_unico'];
  $id_producto  = $_POST['id_producto'];
  $foto           =    $_FILES['foto'];
  $nombre_foto    =    $foto['name'];
  $type 					 =    $foto['type'];
  $url_temp       =    $foto['tmp_name'];

  $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
  if ($nombre_foto != '') {
   $destino = '../img/comprobantes_pago/';
   $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
   $imgProducto = $img_nombre.'.jpg';
   $imgProducto2 = $img_nombre.'.png';
   $src = $destino.$imgProducto;
  }

  $query_consulta = mysqli_query($conection, "SELECT * FROM ventas WHERE codigo_comprobante = '$codigounico' ");
  $result_consulta = mysqli_fetch_array($query_consulta);
  $result_numero = mysqli_num_rows($query_consulta);

  if ($result_numero > 0) {
    $arrayName = array('noticia' =>'codigo_existente');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $query_consultaventa = mysqli_query($conection, "SELECT * FROM ventas WHERE idp = '$id_producto' ORDER BY fecha DESC ");
    $result_consulta = mysqli_fetch_array($query_consultaventa);
    $id_venta = $result_consulta['id'];
    $query_insert=mysqli_query($conection,"UPDATE ventas SET codigo_comprobante='$codigounico',img_comprobantes = '$imgProducto'  WHERE id='$id_venta' ");
    if ($query_insert) {
      if ($nombre_foto != '') {
        move_uploaded_file($url_temp,$src);
      }
      $arrayName = array('respuest' =>'positiva');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      $arrayName = array('noticia' =>'Error 500');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    exit;
  }

 }
}


 ?>
