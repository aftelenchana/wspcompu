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




if ($_POST['action'] == 'guardar_documento') {


  $documentoElectronico = $_POST['documento_electronico'];
  $codigoFactura        = $_POST['codigo_factura'];
  $razonSocialCliente2  = $_POST['razon_social_cliente2'];
  $direccionReeptor     = $_POST['direccion_reeptor'];
  $emailReeptor         = $_POST['email_reeptor'];
  $celularReceptor      = $_POST['celular_receptor'];
  $idcliente            = $_POST['idcliente'];
  $identificacionCliente= $_POST['identificacion_cliente'];

  $largo_cadena = strlen($identificacionCliente);

    if ($largo_cadena < 10 || $largo_cadena > 13 ) {
      $arrayName = array('noticia'=>'identificacion_invalida');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      exit;
    }else {
      if ($largo_cadena == '13') {
        if ($identificacionCliente == '9999999999999') {
            $tipo_identificacion       = '07';
        }
        if ($identificacionCliente != '9999999999999') {
          //echo "Esto es un ruc";
            $tipo_identificacion       = '04';
        }
      }
      if ($largo_cadena == '10') {
          $tipo_identificacion       ='05';
        //echo "Este es cedula";
      }

    }


   $query_comprobante = mysqli_query($conection, "SELECT * FROM comprobantes WHERE  comprobantes.secuencial = '$codigoFactura'
   ORDER BY `comprobantes`.`fecha` DESC ");
  $data_comprobante = mysqli_fetch_array($query_comprobante);
  //$estado_f = $data_comprobante['estado_f'];
  //if ($estado_f == 'GUARDADO') {
  //  $arrayName = array('noticia' =>'documento_guardado');
  //echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  //  exit;
  //}
     $query_edit=mysqli_query($conection,"UPDATE comprobantes SET
       estado_f = 'GUARDADO',documento = '$documentoElectronico',nombres_receptor = '$razonSocialCliente2' ,direccion_reeptor = '$direccionReeptor'
       ,email_reeptor = '$emailReeptor' ,celular_receptor = '$celularReceptor',id_receptor = '$idcliente', numero_identidad_receptor  = '$identificacionCliente',tipo_identificacion='$tipo_identificacion'  WHERE secuencial = '$codigoFactura' AND id_emisor = '$iduser'");
  if ($query_edit) {
    $query_secuencia = mysqli_query($conection,"SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$iduser' ORDER BY secuencial DESC");
    $data_secuencia = mysqli_fetch_array($query_secuencia);
    if ($data_secuencia) {
      $estado_facturacion = $data_secuencia['estado_f'];

      if ($estado_facturacion == 'PROCESO') {
            $secuencial = $data_secuencia['secuencial'];

      }else {
        $secuencial = $data_secuencia['secuencial']+1;
      }



    }else {
      $secuencial = 1;
    }
    $arrayName = array('noticia' =>'guardado_correctamente','secuencial' =>$secuencial);
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
 }



 ?>
