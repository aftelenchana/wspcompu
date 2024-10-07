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

    if ($_POST['action'] == 'ingresar_vehiuclo') {
      if (!empty($_FILES['foto']['name'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/transporte/';
        $img_nombre = 'guibis_ingreso_vehiculo'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
        move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'transporte.png';
        // code...
      }

      $plan_vehiculo    = $_POST['plan_vehiculo'];
      $placa_ingreso    = $_POST['placa_ingreso'];
      $nombre_usuario   = $_POST['nombre_usuario'];
      $celular_usuario  = $_POST['celular_usuario'];
      //QR DEL TRANSPORTISTA

      $fecha_actual = date("d-m-Y H:i:s");

      $img_nombre = 'guibis_qringreso_'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);



      $query_verificador_secuencial = mysqli_query($conection, "SELECT * FROM  ingreso_vehiculo  WHERE  ingreso_vehiculo.iduser  = $iduser ORDER BY id DESC LIMIT 1");
      $result_verificador_secuencial = mysqli_fetch_array($query_verificador_secuencial);

      if ($result_verificador_secuencial) {
        $secuencial = $result_verificador_secuencial['secuencial'];
        $secuencial = $secuencial +1;
      }else {
        $secuencial =1;
      }



      $query_insert=mysqli_query($conection,"INSERT INTO ingreso_vehiculo(iduser,idplan,placa,nombre_usuario,celular,imagen,qr_imagen,qr_contenido,fecha_inicio,secuencial)
                                    VALUES('$iduser','$plan_vehiculo','$placa_ingreso','$nombre_usuario','$celular_usuario','$imgProducto','$qr_img','$contenido','$fecha_actual','$secuencial') ");

      $query_parqueo = mysqli_query($conection,"SELECT * FROM ingreso_vehiculo WHERE ingreso_vehiculo.iduser ='$iduser' ORDER BY ingreso_vehiculo.id DESC");
      $data_parqueo = mysqli_fetch_array($query_parqueo);
      $id_creado = $data_parqueo['id'];

      if ($query_insert) {

          $arrayName = array('img' =>$imgProducto,'noticia'=>'insert_correct','id_creado'=>$id_creado);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'agregar_tr') {
        $transportista = $_POST['transportista'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM transportistas WHERE transportistas.id ='$transportista'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }



  if ($_POST['action'] == 'cobrar_parqueo') {
    $idparqueo= $_POST['idparqueo'];

    $query_producto = mysqli_query($conection,"SELECT ingreso_vehiculo.imagen,ingreso_vehiculo.qr_imagen,ingreso_vehiculo.id,ingreso_vehiculo.fecha_inicio,
      planes_parqueo.precio_hora,ingreso_vehiculo.placa,ingreso_vehiculo.iduser FROM ingreso_vehiculo
      INNER JOIN  planes_parqueo ON planes_parqueo.id = ingreso_vehiculo.idplan
      where ingreso_vehiculo.estatus = '1' AND ingreso_vehiculo.iduser = '$iduser' AND ingreso_vehiculo.id = '$idparqueo'  ");

      $data_producto=mysqli_fetch_array($query_producto);
      $id = $data_producto['id'];
      $iduser = $data_producto['iduser'];
      $placa = $data_producto['placa'];
      $fecha_actual = date("d-m-Y H:i:s");

      $minutos = (strtotime(date($fecha_actual))-strtotime(date($data_producto['fecha_inicio'])))/(3600);
      $horas_calculadas = ceil($minutos);

      $precio_servicio = $horas_calculadas*$data_producto['precio_hora'];

      $query_update=mysqli_query($conection,"UPDATE ingreso_vehiculo SET horas='$horas_calculadas',fecha_final ='$fecha_actual',precio_cobrado='$precio_servicio',estado ='FINALIZADO'  WHERE id='$idparqueo' ");

      if ($query_update) {
          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }


  }


  if ($_POST['action'] == 'buscar_informacion_parqueo') {
    $codigo_parqueo = $_POST['parqueo'];

    $query_producto = mysqli_query($conection,"SELECT ingreso_vehiculo.imagen,ingreso_vehiculo.qr_imagen,ingreso_vehiculo.id,ingreso_vehiculo.fecha_inicio,
      planes_parqueo.precio_hora,ingreso_vehiculo.placa,ingreso_vehiculo.iduser,ingreso_vehiculo.estado FROM ingreso_vehiculo
      INNER JOIN  planes_parqueo ON planes_parqueo.id = ingreso_vehiculo.idplan

      where ingreso_vehiculo.estatus = '1' AND ingreso_vehiculo.iduser = '$iduser' AND ingreso_vehiculo.id = '$codigo_parqueo'  ");
    $numer_producto    = mysqli_num_rows($query_producto);

    if (!empty($numer_producto>0)) {

    	$data_producto=mysqli_fetch_array($query_producto);
    	$id = $data_producto['id'];
    	$iduser = $data_producto['iduser'];
    	$placa = $data_producto['placa'];
      $fecha_actual = date("d-m-Y H:i:s");

      $minutos = (strtotime(date($fecha_actual))-strtotime(date($data_producto['fecha_inicio'])))/(3600);
      $horas_calculadas = ceil($minutos);

      $precio_servicio = $horas_calculadas*$data_producto['precio_hora'];
      $arrayName = array('noticia' =>'existe_datos','horas_calculadas'=>$horas_calculadas,'precio_servicio'=>$precio_servicio,'fecha_inicio'=>$data_producto['fecha_inicio'],'placa'=>$placa,'id_parqueo'=>$id,
    'estado'=>$data_producto['estado']);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



    }else {
      $arrayName = array('noticia' =>'no_existe_datos');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    	// code...
    }
    // code...
  }



 ?>
