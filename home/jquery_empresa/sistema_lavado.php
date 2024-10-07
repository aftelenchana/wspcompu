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




if ($_POST['action'] == 'agregar_plan_lavado') {

  $nombre_tipo_lavado         = $_POST['nombre_tipo_lavado'];
  $precio_servicio       = $_POST['precio_servicio'];
  $descripcion      = $_POST['descripcion'];


  $query_insert=mysqli_query($conection,"INSERT INTO plan_lavado(iduser,nombre_tipo_lavado,precio_servicio,descripcion)
                                VALUES('$iduser','$nombre_tipo_lavado','$precio_servicio','$descripcion') ");

  if ($query_insert) {

      $arrayName = array('noticia'=>'insert_correct');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



    }else {
      $arrayName = array('noticia' =>'error_insertar');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

}











    if ($_POST['action'] == 'ingresar_vehiuclo_area_lavado') {

      $tipo_lavado         = $_POST['tipo_lavado'];
      $placa_ingreso       = $_POST['placa_ingreso'];
      $nombre_usuario      = $_POST['nombre_usuario'];
      $celular_usuario     = $_POST['celular_usuario'];
      $notas_extras        = $_POST['notas_extras'];

      //QR
      $img_nombre = 'guibis_area_lavado_'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $query_insert=mysqli_query($conection,"INSERT INTO area_lavado(iduser,tipo_lavado,nombre_usuario,celular_usuario,qr,qr_contenido,notas_extras)
                                    VALUES('$iduser','$tipo_lavado','$nombre_usuario','$celular_usuario','$qr_img','$contenido','$notas_extras') ");

      if ($query_insert) {

          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }




    if ($_POST['action'] == 'ingresar_vehiuclo_reserva_lavado') {


      $tipo_lavado    = $_POST['tipo_lavado'];
      $tipo_vehiculo_lavanderia    = $_POST['tipo_vehiculo_lavanderia'];
      $placa_ingreso    = $_POST['placa_ingreso'];
      $fecha_reserva_parqueo  = $_POST['fecha_reserva_parqueo'];
      $hora_reserva  = $_POST['hora_reserva'];
      $nombre_usuario   = $_POST['nombre_usuario'];
      $celular_usuario  = $_POST['celular_usuario'];
      $notas_extras  = $_POST['notas_extras'];
      $nueva_fecha = date('d-m-Y', strtotime($fecha_reserva_parqueo));
      $fecha_reserva = $nueva_fecha.' '.$hora_reserva.':00';
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


      $query_insert=mysqli_query($conection,"INSERT INTO area_lavado(iduser,tipo_lavado,nombre_usuario,celular_usuario,qr,qr_contenido,notas_extras,fecha_inicio_reserva,metodo)
                                          VALUES('$iduser','$tipo_lavado','$nombre_usuario','$celular_usuario','$qr_img','$contenido','$notas_extras','$fecha_reserva','reserva') ");




      $query_parqueo = mysqli_query($conection,"SELECT * FROM area_lavado WHERE area_lavado.iduser ='$iduser' ORDER BY area_lavado.id DESC");
      $data_parqueo = mysqli_fetch_array($query_parqueo);
      $id_creado = $data_parqueo['id'];

      if ($query_insert) {

          $arrayName = array('noticia'=>'insert_correct','id_creado'=>$id_creado);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }














    if ($_POST['action'] == 'ingresar_vehiuclo') {


      $tarida_parqueo_lavado    = $_POST['tarida_parqueo_lavado'];
      $tipo_vehiculo_lavanderia    = $_POST['tipo_vehiculo_lavanderia'];
      $placa_ingreso    = $_POST['placa_ingreso'];
      $nombre_usuario   = $_POST['nombre_usuario'];
      $celular_usuario  = $_POST['celular_usuario'];
      $notas_extras  = $_POST['notas_extras'];
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



      $query_verificador_secuencial = mysqli_query($conection, "SELECT * FROM  ingreso_vehiculo_lavanderia  WHERE  ingreso_vehiculo_lavanderia.iduser  = $iduser ORDER BY id DESC LIMIT 1");
      $result_verificador_secuencial = mysqli_fetch_array($query_verificador_secuencial);

      if ($result_verificador_secuencial) {
        $secuencial = $result_verificador_secuencial['secuencial'];
        $secuencial = $secuencial +1;
      }else {
        $secuencial =1;
      }



      $query_insert=mysqli_query($conection,"INSERT INTO ingreso_vehiculo_lavanderia(iduser,idtarifa,idvehiculo,placa,nombre_usuario,celular,qr_imagen,qr_contenido,fecha_inicio,secuencial)
                                    VALUES('$iduser','$tarida_parqueo_lavado','$tipo_vehiculo_lavanderia','$placa_ingreso','$nombre_usuario','$celular_usuario','$qr_img','$contenido','$fecha_actual','$secuencial') ");

      $query_parqueo = mysqli_query($conection,"SELECT * FROM ingreso_vehiculo_lavanderia WHERE ingreso_vehiculo_lavanderia.iduser ='$iduser' ORDER BY ingreso_vehiculo_lavanderia.id DESC");
      $data_parqueo = mysqli_fetch_array($query_parqueo);
      $id_creado = $data_parqueo['id'];

      if ($query_insert) {

          $arrayName = array('noticia'=>'insert_correct','id_creado'=>$id_creado);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }







 ?>
