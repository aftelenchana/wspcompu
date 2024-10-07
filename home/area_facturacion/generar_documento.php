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


if ($_POST['action'] == 'generar_dicumento') {





    $sql_facturas = mysqli_query($conection,"SELECT COUNT(*) as  facturas  FROM
    comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000'
    AND comprobante ='factura' AND estado ='COMPLETADO'");
  $result_facturas = mysqli_fetch_array($sql_facturas);
  $total_facturas = $result_facturas['facturas'];


    $sql_notas_credito = mysqli_query($conection,"SELECT COUNT(*) as  notas_credito  FROM
    comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante ='nota_credito' AND estado ='COMPLETADO'");
    $result_notas_creditos = mysqli_fetch_array($sql_notas_credito);
    $total_notas_creditos = $result_notas_creditos['notas_credito'];

    $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as  tikets  FROM
    tikets WHERE tikets.id_emisor  = '$iduser' ");
    $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
    $total_result_notas_venta = $result_notas_venta['tikets'];

    $total_documentos = $total_facturas + $total_facturas + $total_result_notas_venta;


    $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios
       WHERE usuarios.id ='$iduser'  ");
    $data_plan = mysqli_fetch_array($query_consulta);

    $documentos_electronicos = $data_plan['documentos_electronicos'];
    $fecha_maxima_documentos = $data_plan['fecha_maxima_documentos']; // Ejemplo: "2023-10-27"

    // Convertir las fechas a timestamps para compararlas
    $timestamp_fecha_maxima = strtotime($fecha_maxima_documentos);
    $timestamp_fecha_actual = strtotime(date("Y-m-d"));
    // Comparar las fechas
    if ($timestamp_fecha_actual <= $timestamp_fecha_maxima) {

      if ($total_documentos <= $documentos_electronicos) {


      }else {
        $arrayName = array('noticia'=>'fecha_menor','cantidad'=>'cantidad_incorrecta');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
      }
    } elseif ($timestamp_fecha_actual > $timestamp_fecha_maxima) {
      $arrayName = array('noticia'=>'fecha_mayor');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      exit;
    }





  $documento_electronico  = $_POST['documento_electronico'];
  $codigo_factura         = $_POST['codigo_factura'];
  $razon_social_cliente2  = $_POST['razon_social_cliente2'];
  $direccion_reeptor      = $_POST['direccion_reeptor'];
  $email_reeptor          = $_POST['email_reeptor'];
  $celular_receptor       = $_POST['celular_receptor'];
  $idcliente              = $_POST['idcliente'];
  $identificacion_cliente = $_POST['identificacion_cliente'];
  $sucursal_facturacion   = $_POST['sucursal_facturacion'];


  //codigo para saber si la cantidad de metodo de pago es la correcta

  $query_forma_pago = mysqli_query($conection,"SELECT SUM(((formas_pago_facturacion.cantidad_metodo_pago))) as 'cantidad_metodo_pago'
    FROM formas_pago_facturacion  WHERE formas_pago_facturacion.iduser ='$iduser' AND formas_pago_facturacion.codigo_factura = '$codigo_factura'  ");
   $data_forma_pago = mysqli_fetch_array($query_forma_pago);
       $cantidad_metodo_pago_base  = $data_forma_pago['cantidad_metodo_pago'];


       $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
       'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
       SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
       FROM `comprobantes`
       WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' ");
       $data_lista_t=mysqli_fetch_array($query_lista_t);

       $total_real_factura = (($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total']));


       if ($total_real_factura <= 999) {

                // Redondeamos a dos decimales.
                $cantidad_metodo_pago_base = round($cantidad_metodo_pago_base, 2);
                $total_real_factura = round($total_real_factura, 2);

                // Ahora puedes hacer la comparación.
                if ($cantidad_metodo_pago_base != $total_real_factura) {
                  $arrayName = array(
                    'noticia' => 'metodo_pago_diferente_cantidad',
                    'valor_factura' => $total_real_factura,
                    'cantidad_metodo_pago_base' => $cantidad_metodo_pago_base
                  );
                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                  exit;
                } else {

                }

       }else {

         $cantidad_metodo_pago_base = str_replace(',', '', $cantidad_metodo_pago_base);

         // Luego convertimos las comas en puntos para manejar los decimales.
         $cantidad_metodo_pago_base = str_replace('.', ',', $cantidad_metodo_pago_base);
         $cantidad_metodo_pago_base = floatval($cantidad_metodo_pago_base);

         $total_real_factura = str_replace(',', '', $total_real_factura);
         $total_real_factura = str_replace('.', ',', $total_real_factura);
         $total_real_factura = floatval($total_real_factura);

         // Redondeamos a dos decimales.
         $cantidad_metodo_pago_base = round($cantidad_metodo_pago_base, 2);
         $total_real_factura = round($total_real_factura, 2);

         // Ahora puedes hacer la comparación.
         if ($cantidad_metodo_pago_base != $total_real_factura) {
           $arrayName = array(
             'noticia' => 'metodo_pago_diferente_cantidad',
             'valor_factura' => $total_real_factura,
             'cantidad_metodo_pago_base' => $cantidad_metodo_pago_base
           );
           echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
           exit;
         } else {

         }
       }

  //codigo para verificar si esta correcto la identificacion

       $tipo_identificacion = $_POST['tipo_identificacion'];



      if ($tipo_identificacion != '07') {
        $query_veri_ruc = mysqli_query($conection,"SELECT * FROM clientes   WHERE identificacion= '$identificacion_cliente' AND iduser = $iduser ");
        $result_lista_ruc= mysqli_num_rows($query_veri_ruc);
        if ($result_lista_ruc == 0) {
          $correos = explode(";",$email_reeptor); // Separar los correos por el punto y coma (;)
          if (count($correos) > 1) {
              $primerCorreo = trim($correos[0]);
          } else {
              $primerCorreo = trim($email_reeptor);
          }
          $img_nombre = 'guibis_cliente'.md5(date('d-m-Y H:m:s'));
          $qr_img = $img_nombre.'.png';
          $contenido = md5(date('d-m-Y H:m:s').$iduser);
          $direccion = '../img/qr/';
          $filename = $direccion.$qr_img;
          $tamanio = 7;
          $level = 'H';
          $frameSize = 5;
          $contenido = $contenido;
          QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);

          $query_insert_cliente=mysqli_query($conection,"INSERT INTO clientes(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,qr,qr_contenido,sistema)
          VALUES('$razon_social_cliente2','$email_reeptor','$tipo_identificacion','$direccion_reeptor','$identificacion_cliente','$celular_receptor','avatar.png','$iduser','NATURAL','$qr_img','$contenido','facturacion') ");

          $query_consulta_ultimo_cliente = mysqli_query($conection,"SELECT * FROM clientes   WHERE identificacion= '$identificacion_cliente' ORDER BY DESC id ");
          $data_cliente    = mysqli_fetch_array($query_consulta_ultimo_cliente);
          $idcliente = $data_cliente['id'];
        }else {

          $query_editar_cliente = mysqli_query($conection,"UPDATE clientes SET nombres='$razon_social_cliente2',mail='$email_reeptor',direccion='$direccion_reeptor',
              identificacion='$identificacion_cliente', celular='$celular_receptor'
              WHERE id = '$idcliente'");

              if ($query_editar_cliente) {
                  $estado_cliente = 'Cliente existente_actualizado';
              }else {
                  $estado_cliente = 'Cliente existente_no_actualizado_error_base_de_datos';
              }



        }
      }else {
        $estado_cliente = 'consumidor_final';
      }

      $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes   WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura'");
      $resultados_ff = mysqli_fetch_array($query_resultados_ff);
      if ($resultados_ff) {

        $query_agregar_usuario_sin_id = mysqli_query($conection,"UPDATE comprobantes SET nombres_receptor='$razon_social_cliente2',numero_identidad_receptor='$identificacion_cliente',email_reeptor='$email_reeptor',
          direccion_reeptor='$direccion_reeptor', id_receptor='$idcliente',tipo_identificacion='$tipo_identificacion',celular_receptor='$celular_receptor',
          IDROLPUNTOVENTA='ADMIN',estado_f = 'FINALIZADO',documento='Facturación',sucursal_facturacion='$sucursal_facturacion'
          WHERE id_emisor = '$iduser'  AND secuencial = '$codigo_factura' ");
          if ($query_agregar_usuario_sin_id) {
            $arrayName = array('noticia'=>'insert_correct','tipo_documento_digital'=>$documento_electronico,'codigo_factura'=>$codigo_factura,'estado_cliente'=>$estado_cliente,'estado_cliente'=>$estado_cliente,'sucursal_facturacion'=>$sucursal_facturacion);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
      }else {
        $arrayName = array('noticia'=>'vacio');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }

 }

if ($_POST['action'] == 'sacar_informacion_factura_guardada') {

  $codigo_factura = $_POST['codigo_factura'];
  $query_resultados_ff = mysqli_query($conection,"SELECT * FROM comprobantes  WHERE  secuencial = '$codigo_factura'  AND id_emisor= '$iduser' ");
  $resultados_ff = mysqli_fetch_array($query_resultados_ff);
  if ($resultados_ff) {
    $arrayName = array('noticia'=>'existe_datos','estado'=>$resultados_ff['estado_f'],'nombres_receptor'=>$resultados_ff['nombres_receptor'],'tipo_identificacion'=>$resultados_ff['tipo_identificacion'],'numero_identidad_receptor'=>$resultados_ff['numero_identidad_receptor']
  ,'email_reeptor'=>$resultados_ff['email_reeptor'],'direccion_reeptor'=>$resultados_ff['direccion_reeptor'],'celular_receptor'=>$resultados_ff['celular_receptor'],'id_receptor'=>$resultados_ff['id_receptor']
,'documento'=>$resultados_ff['documento']);
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia'=>'no_existe');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
 }




 ?>
