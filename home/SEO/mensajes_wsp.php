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

    if ($_POST['action'] == 'informacion_plan_wsp') {
      if ($iduser == $user_in) {

        $datos = json_decode(file_get_contents('https://guibis.com/api/suscripciones/check?producto=5136&email='.$email_user.''),true);
        $noticia = $datos['NOTICIA'];
        if ($noticia == 'no existe ventas de este producto') {
          $arrayName = array('tipo_cuenta' =>'administrador','noticia' =>'no existe ventas de este producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        if ($noticia == 'NO EXISTE VENTA PARA '.$email_user.'') {
          $arrayName = array('tipo_cuenta' =>'administrador','noticia' =>'no existe ventas de este producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        if ($noticia == 'VENTA EXISTENTE') {
          $arrayName = array('tipo_cuenta' =>'administrador','noticia' =>'Venta Existente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }
      }else {

        $datos = json_decode(file_get_contents('https://guibis.com/api/suscripciones/check?producto=5136&email='.$email_user.''),true);
        $noticia = $datos['NOTICIA'];
        if ($noticia == 'no existe ventas de este producto') {
          $arrayName = array('tipo_cuenta' =>'usuario','noticia' =>'no existe ventas de este producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        if ($noticia == 'NO EXISTE VENTA PARA '.$email_user.'') {
          $arrayName = array('tipo_cuenta' =>'usuario','noticia' =>'no existe ventas de este producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        if ($noticia == 'VENTA EXISTENTE') {
          $arrayName = array('tipo_cuenta' =>'usuario','noticia' =>'Venta Existente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      }
    }




    if ($_POST['action'] == 'activar_paquete') {


      $producto          = '5136';
      //INFORMACION DEL USUARIO COMPRADOR

      $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,producto_venta.direccion_1,
      producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,
      producto_venta.id_usuario,usuarios.posicion,usuarios.email as 'email_vendedor',producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion,producto_venta.meses_suscripcion,
      producto_venta.longitud,producto_venta.latitud,producto_venta.ip_1,producto_venta.ciudad,producto_venta.provincia,producto_venta.utilizar_transporte_guibis,producto_venta.cantidad
      FROM producto_venta
      INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
      WHERE idproducto = $producto;");
      $result_producto = mysqli_fetch_array($query_producto);
      $precio_producto      =  $result_producto['precio'];
      $dueno_producto       =  $result_producto['id_usuario'];
      $email_vendedor       =  $result_producto['email_vendedor'];
      $meses_suscripcion       =  $result_producto['meses_suscripcion'];
      $cantidad_producto       =  $result_producto['cantidad'];

        $dir = '../img/qr_ventas/';
        $oidgo_venta_evento = 'qr_guibis_venta'.md5($iduser.date('d-m-Y H:m:s')).'.png';
        $int_contenido = md5($iduser.date('d-m-Y H:m:s'));
        $filename = $dir.$oidgo_venta_evento;
        $tamanio = 7;
        $level = 'H';
        $frameSize = 5;
        $contenido = $int_contenido;
        QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);

        date_default_timezone_set("America/Lima");
        $fecha_actual = date('d-m-Y H:m:s', time());

        if (empty($meses_suscripcion)) {
          $meses_suscripcion = 12;
        }

        date_default_timezone_set("America/Lima");
        $fecha_actual = date('d-m-Y H:m:s', time());
        $fecha_tope_venta = date("d-m-Y H:m:s",strtotime($fecha_actual."+ 1 days"));


        $mifecha = new DateTime();
        $mifecha->modify('+'.$meses_suscripcion.' month');
       $fecha_limite_suscripcion =  $mifecha->format('d-m-Y H:i:s');
        //INSERSION EN VENTAS
        $query_insert=mysqli_query($conection,"INSERT INTO ventas(codigo_venta,qr_venta,cantidad_producto,idp,id_comprador,estado_financiero,metodo_pago,fecha_inicio_venta,fecha_tope_venta,fecha_limite_suscripcion)
        VALUES('$contenido','$oidgo_venta_evento','$cantidad_producto','$producto','$iduser','PAGADO','Mi Leben','$fecha_actual','$fecha_tope_venta','$fecha_limite_suscripcion') ");


        if ($query_insert)  {
          $arrayName = array('resultado' =>'compra_exitosa');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

       }else {
         $arrayName = array('resultado' =>'error_servidor');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         // code...
       }

    }


 ?>
