<?php
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
require '../QR/phpqrcode/qrlib.php';

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
session_start();
$id_transporte= $_SESSION['id'];

$query_transporte = mysqli_query($conection, "SELECT * FROM transporte_guibis    WHERE transporte_guibis.id =$id_transporte");
$data_transporte =mysqli_fetch_array($query_transporte);
$nombres_transporte          = $data_transporte['nombres'];
$direccion_transpporte          = $data_transporte['direccion'];
$mail_transporte               = $data_transporte['mail'];
$iduser_raiz                = $data_transporte['iduser'];
$cambio_password_transporte   = $data_transporte['cambio_password'];
$foto_transporte              = $data_transporte['foto'];
$fecha_registro_transporte    = $data_transporte['fecha'];
$url_img_upload_transporrte     = $data_transporte['url_img_upload'];
$identificacion_transporte     = $data_transporte['identificacion'];
$foto_transporte               = $data_transporte['foto'];
$ciudad_transporte               = $data_transporte['ciudad'];
$telefono_transporte               = $data_transporte['telefono'];
$celular_transporte               = $data_transporte['celular'];

      if ($_POST['action'] == 'tomar_pedido') {
        $codigo_peidido_viaje    = $_POST['codigo_peidido_viaje'];
        $latitude      = $_POST['latitude'];
        $longitude    = $_POST['longitude'];
        $distancia      = $_POST['distancia'];
        $tiempo    = $_POST['tiempo'];


        $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa = '$codigo_peidido_viaje'");
        $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
        $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];

        if (empty($transporte_guibis) || $transporte_guibis == '') {

          $query_edit_tomar_pedido=mysqli_query($conection,"UPDATE comprobantes SET transporte_guibis= '$id_transporte',latitude_actual = '$latitude',longitude_actual= '$longitude' ,estado_f= 'INICIANDO TRANSPORTE'  WHERE codigo_mesa='$codigo_peidido_viaje' ");
          if ($query_edit_tomar_pedido) {

            $arrayName = array('noticia' =>'pedido_agregado_correctamente','distancia' =>$distancia,'tiempo' =>$tiempo);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }else {
            $arrayName = array('noticia' =>'error_servidor');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }


        }else {

          $arrayName = array('noticia' =>'pedido_ya_accionado');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

     }


     if ($_POST['action'] == 'info_viaje_pedido') {
       $secuencial    = $_POST['secuencial'];


       $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa = '$secuencial'");
       $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
       $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];

       if (empty($transporte_guibis) || $transporte_guibis == '') {

           $arrayName = array('noticia' =>'pedido_vacio');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


       }else {

         $arrayName = array('noticia' =>'pedido_ocupado');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }

    }



    if ($_POST['action'] == 'recoger_predido_cocina') {
      $codigo_peidido_viaje    = $_POST['codigo_peidido_viaje'];
      $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa= '$codigo_peidido_viaje'");
      $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
      $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];
        $estado_f    = $data_verificador_secuencial['estado_f'];

      if ($estado_f == 'INICIANDO TRANSPORTE') {
        $query_edit_tomar_pedido=mysqli_query($conection,"UPDATE comprobantes SET  estado_f= 'TRANSPORTANDO'  WHERE codigo_mesa='$codigo_peidido_viaje' ");
        if ($query_edit_tomar_pedido) {

          $arrayName = array('noticia' =>'pedido_tomado_cocina_correctamente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          $arrayName = array('noticia' =>'error_servidor');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        // code...
      }else {
        $arrayName = array('noticia' =>'pedido_ya_accionado_cocina');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }


    }




    if ($_POST['action'] == 'entregar_pedido_final') {
      $codigo_peidido_viaje    = $_POST['codigo_peidido_viaje'];
      $query_verificador_viaje = mysqli_query($conection, "SELECT * FROM comprobantes  WHERE comprobantes.codigo_mesa = '$codigo_peidido_viaje'");
      $data_verificador_secuencial = mysqli_fetch_array($query_verificador_viaje);
      $transporte_guibis    = $data_verificador_secuencial['transporte_guibis'];
        $estado_f    = $data_verificador_secuencial['estado_f'];

      if ($estado_f == 'TRANSPORTANDO') {
        $query_edit_tomar_pedido=mysqli_query($conection,"UPDATE comprobantes SET  estado_f= 'ENTREGADO-FINALIZADO'  WHERE codigo_mesa='$codigo_peidido_viaje' ");
        if ($query_edit_tomar_pedido) {

          $arrayName = array('noticia' =>'entregado_finalizado_correcto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          $arrayName = array('noticia' =>'error_servidor');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

        // code...
      }else {
        $arrayName = array('noticia' =>'finalizado_ya_accionado');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }


    }



 ?>
