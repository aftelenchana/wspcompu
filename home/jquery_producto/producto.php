<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones


session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

  if ($_POST['action'] == 'buscar_producto') {
    $producto = $_POST['idproducto'];
    $query = mysqli_query($conection, "SELECT * FROM producto_venta
        WHERE idproducto =  $producto ");
      $data = mysqli_fetch_assoc($query);
      echo json_encode($data,JSON_UNESCAPED_UNICODE);

  // code...
}

  if ($_POST['action'] == 'editar_producto') {

        $idproducto   = $_POST['idproducto'];



      if (!empty($_FILES['foto']['name'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/uploads/';
        $img_nombre = 'producto_guibis'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
          move_uploaded_file($url_temp,$src);

       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
       $url_upload_img = $url;
      }else {
        $query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE producto_venta.idproducto = $idproducto");
        $data_producto = mysqli_fetch_array($query_producto);
        $imgProducto = $data_producto['foto'];
        $url_upload_img = $data_producto['url_upload_img'];
      }

      $proveedor           = (isset($_REQUEST['proveedor'])) ? $_REQUEST['proveedor'] : '';
      $codigo_extra           = (isset($_REQUEST['codigo_extra'])) ? $_REQUEST['codigo_extra'] : '';

      $nombre_producto   =  ($_POST['nombre_producto']);
      $precio            =  $_POST['precio'];
      $precio_costo      =  $_POST['precio_costo'];
      $codigo_barras      =  $_POST['codigo_barras'];



      //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

      $tipo_ambiente                    =  ($_POST['elejir_tarifa_iva']);
      $codigos_impuestos                =  $_POST['codigos_impuestos'];
      $valor_unidad_final_con_impuestps =  round($_POST['resultado_calculo'],2);

      $cantidad          =  $_POST['cantidad'];
      $descripcion       =  ($_POST['descripcion']);
      $marca_producto    =  $_POST['marca'];


      $query_insert = mysqli_query($conection,"UPDATE producto_venta SET proveedor='$proveedor',codigo_extra='$codigo_extra',nombre='$nombre_producto',
        precio='$precio', precio_costo='$precio_costo',tipo_ambiente='$tipo_ambiente',codigos_impuestos='$codigos_impuestos'
        ,valor_unidad_final_con_impuestps='$valor_unidad_final_con_impuestps',cantidad='$cantidad', descripcion='$descripcion',marca='$marca_producto'
        ,foto='$imgProducto',codigo_barras='$codigo_barras',url_upload_img='$url_upload_img'
        WHERE idproducto = '$idproducto'");
      if ($query_insert) {
          $arrayName = array('noticia'=>'insert_correct','idproducto'=> $idproducto,'imgProducto'=> $imgProducto);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }









 ?>
