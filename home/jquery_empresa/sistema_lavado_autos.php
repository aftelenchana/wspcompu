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




    if ($_POST['action'] == 'configurar_espacios_lavanderia') {

      $numerio_espcaioc_lavanderia    = $_POST['numerio_espcaioc_lavanderia'];


      $query_insert=mysqli_query($conection,"INSERT INTO espacios_lavanderia_autos(iduser,espacios)
                                    VALUES('$iduser','$numerio_espcaioc_lavanderia') ");

      if ($query_insert) {

          $arrayName = array('respuesta'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('respuesta' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }


    if ($_POST['action'] == 'agregar_tipo_vehiuclo') {

      $tipo_vehioculoo    = $_POST['tipo_vehioculoo'];
      $query_insert=mysqli_query($conection,"INSERT INTO tipo_vehiculo(iduser,tipo_vehiculo)
                                    VALUES('$iduser','$tipo_vehioculoo') ");

      if ($query_insert) {

          $arrayName = array('respuesta'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('respuesta' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }


    if ($_POST['action'] == 'agregar_tarifa_tiempop') {

      $nombre_tarifa    = $_POST['nombre_tarifa'];
      $intervalo_tiempo_minutos    = $_POST['intervalo_tiempo_minutos'];
      $valor_recargo    = $_POST['valor_recargo'];
      $valor_servicio    = $_POST['valor_servicio'];
        $timpo_espera    = $_POST['timpo_espera'];
      $query_insert=mysqli_query($conection,"INSERT INTO  tarifas_parqueo_lavado_autos (iduser,nombre_servicio,minutos_servicio,precio_sobrecargo,valor_servicio,timpo_espera)
                                    VALUES('$iduser','$nombre_tarifa','$intervalo_tiempo_minutos','$valor_recargo','$valor_servicio','$timpo_espera') ");

      if ($query_insert) {

          $arrayName = array('respuesta'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('respuesta' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }



    if ($_POST['action'] == 'ingresar_vehiuclo') {


      $sql_espacios = mysqli_query($conection,"SELECT *  FROM
      espacios_lavanderia_autos  WHERE espacios_lavanderia_autos.iduser  = '$iduser'  ORDER BY id DESC");

      $result_lista= mysqli_num_rows($sql_espacios);
      if ($result_lista>0) {
        $result_espacios = mysqli_fetch_array($sql_espacios);
        $total_espacios = $result_espacios['espacios'];
        $total_espacios =$total_espacios-1;
      }else {
        $total_espacios = 100;
      }


        $query_update=mysqli_query($conection,"UPDATE espacios_lavanderia_autos SET espacios ='$total_espacios'  WHERE iduser='$iduser' ");



      $tarida_parqueo_lavado    = $_POST['tarida_parqueo_lavado'];
      $tipo_vehiculo_lavanderia    = $_POST['tipo_vehiculo_lavanderia'];
      $placa_ingreso    = strtoupper($_POST['placa_ingreso']);
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



    if ($_POST['action'] == 'ingresar_vehiuclo_reserva') {

      $sql_espacios = mysqli_query($conection,"SELECT *  FROM
      espacios_lavanderia_autos  WHERE espacios_lavanderia_autos.iduser  = '$iduser'  ORDER BY id DESC");

      $result_lista= mysqli_num_rows($sql_espacios);
      if ($result_lista>0) {
        $result_espacios = mysqli_fetch_array($sql_espacios);
        $total_espacios = $result_espacios['espacios'];
        $total_espacios =$total_espacios-1;
      }else {
        $total_espacios = 100;
      }


        $query_update=mysqli_query($conection,"UPDATE espacios_lavanderia_autos SET espacios ='$total_espacios'  WHERE iduser='$iduser' ");


      $tarida_parqueo_lavado    = $_POST['tarida_parqueo_lavado'];
      $tipo_vehiculo_lavanderia    = $_POST['tipo_vehiculo_lavanderia'];
      $placa_ingreso    = $_POST['placa_ingreso'];
      $nombre_usuario   = $_POST['nombre_usuario'];
      $celular_usuario  = $_POST['celular_usuario'];
      $fecha_reserva_parqueo  = $_POST['fecha_reserva_parqueo'];
      $hora_reserva  = $_POST['hora_reserva'];


      $nueva_fecha = date('d-m-Y', strtotime($fecha_reserva_parqueo));


      $fecha_reserca = $nueva_fecha.' '.$hora_reserva.':00';


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



      $query_insert=mysqli_query($conection,"INSERT INTO ingreso_vehiculo_lavanderia(iduser,idtarifa,idvehiculo,placa,nombre_usuario,celular,qr_imagen,qr_contenido,fecha_inicio,secuencial,metodo)
                                    VALUES('$iduser','$tarida_parqueo_lavado','$tipo_vehiculo_lavanderia','$placa_ingreso','$nombre_usuario','$celular_usuario','$qr_img','$contenido','$fecha_reserca','$secuencial','reserva') ");

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



    if ($_POST['action'] == 'ingresar_vehiuclo_mesnualidades') {

      $sql_espacios = mysqli_query($conection,"SELECT *  FROM
      espacios_lavanderia_autos  WHERE espacios_lavanderia_autos.iduser  = '$iduser'  ORDER BY id DESC");

      $result_lista= mysqli_num_rows($sql_espacios);
      if ($result_lista>0) {
        $result_espacios = mysqli_fetch_array($sql_espacios);
        $total_espacios = $result_espacios['espacios'];
        $total_espacios =$total_espacios-1;
      }else {
        $total_espacios = 100;
      }


        $query_update=mysqli_query($conection,"UPDATE espacios_lavanderia_autos SET espacios ='$total_espacios'  WHERE iduser='$iduser' ");


      $tarida_parqueo_lavado    = $_POST['tarida_parqueo_lavado'];
      $tipo_vehiculo_lavanderia    = $_POST['tipo_vehiculo_lavanderia'];
      $placa_ingreso    = $_POST['placa_ingreso'];
      $fecha_inicio_mesualidades  = $_POST['fecha_inicio_mesualidades'];
      $fecha_final_mensualidades  = $_POST['fecha_final_mensualidades'];
      $cliente  = $_POST['cliente'];


      $fecha_inicio_mesualidades = date('d-m-Y', strtotime($fecha_inicio_mesualidades));
        $fecha_final_mensualidades = date('d-m-Y', strtotime($fecha_final_mensualidades));




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



      $query_insert=mysqli_query($conection,"INSERT INTO ingreso_vehiculo_lavanderia(iduser,idtarifa,idvehiculo,placa,qr_imagen,qr_contenido,fecha_inicio,secuencial,metodo,idcliente,fecha_inicio_mesualidad,fecha_final_mensualidad)
                                    VALUES('$iduser','$tarida_parqueo_lavado','$tipo_vehiculo_lavanderia','$placa_ingreso','$qr_img','$contenido','$fecha_actual','$secuencial','mensualidad','$cliente','$fecha_inicio_mesualidades','$fecha_final_mensualidades') ");

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







    if ($_POST['action'] == 'cobrar_parqueo') {

      $sql_espacios = mysqli_query($conection,"SELECT *  FROM
      espacios_lavanderia_autos  WHERE espacios_lavanderia_autos.iduser  = '$iduser'  ORDER BY id DESC");

      $result_lista= mysqli_num_rows($sql_espacios);
      if ($result_lista>0) {
        $result_espacios = mysqli_fetch_array($sql_espacios);
        $total_espacios = $result_espacios['espacios'];
        $total_espacios =$total_espacios+1;
      }else {
        $total_espacios = 100;
      }


      $query_update=mysqli_query($conection,"UPDATE espacios_lavanderia_autos SET espacios ='$total_espacios'  WHERE iduser='$iduser' ");



      $idparqueo= $_POST['idparqueo'];

      $query_producto = mysqli_query($conection,"SELECT ingreso_vehiculo_lavanderia.qr_imagen,ingreso_vehiculo_lavanderia.id,ingreso_vehiculo_lavanderia.fecha_inicio,ingreso_vehiculo_lavanderia.placa,
        ingreso_vehiculo_lavanderia.iduser,tarifas_parqueo_lavado_autos.valor_servicio,
        tipo_vehiculo.tipo_vehiculo,tarifas_parqueo_lavado_autos.nombre_servicio,tarifas_parqueo_lavado_autos.minutos_servicio,tarifas_parqueo_lavado_autos.timpo_espera,tarifas_parqueo_lavado_autos.precio_sobrecargo
         FROM ingreso_vehiculo_lavanderia
        INNER JOIN tarifas_parqueo_lavado_autos ON tarifas_parqueo_lavado_autos.id = ingreso_vehiculo_lavanderia.idtarifa
        INNER JOIN tipo_vehiculo ON tipo_vehiculo.id = ingreso_vehiculo_lavanderia.idvehiculo
        where ingreso_vehiculo_lavanderia.estatus = '1' AND ingreso_vehiculo_lavanderia.iduser = '$iduser' AND ingreso_vehiculo_lavanderia.id = '$idparqueo';  ");

        $data_producto=mysqli_fetch_array($query_producto);
        $id = $data_producto['id'];
        $iduser = $data_producto['iduser'];
        $placa = $data_producto['placa'];
        $fecha_actual = date("d-m-Y H:i:s");

        $minutos_servicio = $data_producto['minutos_servicio'];
        $nombre_servicio = $data_producto['nombre_servicio'];
        $valor_servicio  =$data_producto['valor_servicio'];

        $minutos = ((strtotime(date($fecha_actual))-strtotime(date($data_producto['fecha_inicio'])))/(60));

        if ($minutos < $minutos_servicio) {
          $minutos = $minutos_servicio;
          // code...
        }


        $ancho_minutos = ceil($minutos/$minutos_servicio);


         $precio_servicio = $ancho_minutos*$valor_servicio;
        $query_update=mysqli_query($conection,"UPDATE ingreso_vehiculo_lavanderia SET horas='$ancho_minutos',fecha_final ='$fecha_actual',precio_cobrado='$precio_servicio',estado ='FINALIZADO'  WHERE id='$idparqueo' ");

        if ($query_update) {
            $arrayName = array('noticia'=>'insert_correct','idparqueo'=>$idparqueo);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
            $arrayName = array('noticia' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }


    }


    if ($_POST['action'] == 'buscar_informacion_parqueo') {
      $codigo_parqueo = $_POST['parqueo'];

      $query_producto = mysqli_query($conection,"SELECT ingreso_vehiculo_lavanderia.qr_imagen,ingreso_vehiculo_lavanderia.id,
        ingreso_vehiculo_lavanderia.fecha_inicio,ingreso_vehiculo_lavanderia.placa,
        ingreso_vehiculo_lavanderia.iduser,tarifas_parqueo_lavado_autos.valor_servicio,ingreso_vehiculo_lavanderia.estado,
        tipo_vehiculo.tipo_vehiculo,tarifas_parqueo_lavado_autos.nombre_servicio,tarifas_parqueo_lavado_autos.minutos_servicio,tarifas_parqueo_lavado_autos.timpo_espera,tarifas_parqueo_lavado_autos.precio_sobrecargo
         FROM ingreso_vehiculo_lavanderia
        INNER JOIN tarifas_parqueo_lavado_autos ON tarifas_parqueo_lavado_autos.id = ingreso_vehiculo_lavanderia.idtarifa
        INNER JOIN tipo_vehiculo ON tipo_vehiculo.id = ingreso_vehiculo_lavanderia.idvehiculo
        where ingreso_vehiculo_lavanderia.estatus = '1' AND ingreso_vehiculo_lavanderia.iduser = '$iduser' AND ingreso_vehiculo_lavanderia.id = '$codigo_parqueo'; ");
      $numer_producto    = mysqli_num_rows($query_producto);

      if (!empty($numer_producto>0)) {

        $data_producto=mysqli_fetch_array($query_producto);
        $id = $data_producto['id'];
        $iduser = $data_producto['iduser'];
        $placa = $data_producto['placa'];
        $fecha_actual = date("d-m-Y H:i:s");

        //INFORMACION DEL TIPO DE PLAN
        $minutos_servicio = $data_producto['minutos_servicio'];
        $nombre_servicio = $data_producto['nombre_servicio'];
        $valor_servicio  =$data_producto['valor_servicio'];

        $minutos = ((strtotime(date($fecha_actual))-strtotime(date($data_producto['fecha_inicio'])))/(60));

        if ($minutos < $minutos_servicio) {
          $minutos = $minutos_servicio;
          // code...
        }


        $ancho_minutos = ceil($minutos/$minutos_servicio);

        $precio_servicio = number_format(($ancho_minutos*$valor_servicio),2);
        $arrayName = array('noticia' =>'existe_datos','tiempo_calculado'=>$minutos,'precio_servicio'=>$precio_servicio,'fecha_inicio'=>$data_producto['fecha_inicio'],'placa'=>$placa,'id_parqueo'=>$id,
      'estado'=>$data_producto['estado'],'minutos_servicio'=>$minutos_servicio,'nombre_servicio'=>$nombre_servicio);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



      }else {
        $arrayName = array('noticia' =>'no_existe_datos');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        // code...
      }
      // code...
    }




    if ($_POST['action'] == 'agregar_tr') {
        $transportista = $_POST['transportista'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM transportistas WHERE transportistas.id ='$transportista'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }

      if ($_POST['action'] == 'bucar_inofrmacion_tarigfda') {
          $tarifa = $_POST['tarifa'];
          $query_tarifa = mysqli_query($conection,"SELECT * FROM tarifas_parqueo_lavado_autos WHERE tarifas_parqueo_lavado_autos.id ='$tarifa'");
          $data_tarifa = mysqli_fetch_array($query_tarifa);
          echo json_encode($data_tarifa,JSON_UNESCAPED_UNICODE);
        }

        if ($_POST['action'] == 'eliminar_tarifa_tiempo') {
            $tarifa = $_POST['tarifa_form'];
            $query_delete=mysqli_query($conection,"UPDATE tarifas_parqueo_lavado_autos SET estatus= 0  WHERE id='$tarifa' ");
            if ($query_delete) {
              $arrayName = array('respuesta' =>'elimado_correctamnete','tarifa'=>$tarifa);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }else {
                $arrayName = array('respuesta' =>'error_insertar');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
          }
      if ($_POST['action'] == 'bucar_inofrmacion_tipo_vehiculo') {
          $tipo_vehiculo = $_POST['tipo_vehiculo'];
          $query_tipo_vehiculo = mysqli_query($conection,"SELECT * FROM tipo_vehiculo WHERE tipo_vehiculo.id ='$tipo_vehiculo'");
          $data_tipo_vehiculo = mysqli_fetch_array($query_tipo_vehiculo);
          echo json_encode($data_tipo_vehiculo,JSON_UNESCAPED_UNICODE);
        }

        if ($_POST['action'] == 'eliminar_tipo_vehucloo') {
            $tipo_vehiculo_form = $_POST['tipo_vehiculo_form'];
            $query_delete=mysqli_query($conection,"UPDATE tipo_vehiculo SET estatus= 0  WHERE id='$tipo_vehiculo_form' ");
            if ($query_delete) {
              $arrayName = array('respuesta' =>'elimado_correctamnete','tipo_vehiculo_form'=>$tipo_vehiculo_form);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }else {
                $arrayName = array('respuesta' =>'error_insertar');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
          }




 ?>
