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


     if ($_POST['action'] == 'agrergar_pago_cuentas_cobrar') {


       if (!empty($_FILES['foto']['name'])) {
         $foto           =    $_FILES['foto'];
         $nombre_foto    =    $foto['name'];
         $type 					 =    $foto['type'];
         $url_temp       =    $foto['tmp_name'];
         $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
         $destino = '../img/uploads/';
         $img_nombre = 'guibis_boucher'.md5(date('d-m-Y H:m:s').$iduser);
         $imgProducto = $img_nombre.'.'.$extension;
         $src = $destino.$imgProducto;
           move_uploaded_file($url_temp,$src);
       }else {
         $imgProducto = '';
         // code...
       }
       $monto_recibir                         = $_POST['monto_recibir'];
       $descripcion_cuenta_conrar             = $_POST['descripcion_pago'];
       $id_cuentacobrado                      = $_POST['id_cuentacobrado'];

       $query_cuenta = mysqli_query($conection,"SELECT * FROM cuentas_por_cobrar
         WHERE cuentas_por_cobrar.id = '$id_cuentacobrado'");
         $data_cuenta  = mysqli_fetch_array($query_cuenta);
         $monto_debito = $data_cuenta['debito'];

         if ($monto_recibir <= $monto_debito) {

         $query_tablar=mysqli_query($conection,"INSERT INTO  facturacion_historial_cuentas_por_cobrar(id_cuentas_cobrar,id_user,valor_agregado,concepto,pdf)
                                                                        VALUES('$id_cuentacobrado','$iduser','$monto_recibir','$descripcion_cuenta_conrar','$imgProducto') ");

                                 $monto_debito = $monto_debito -$monto_recibir;


                 $query_insert=mysqli_query($conection,"UPDATE cuentas_por_cobrar SET debito='$monto_debito'  WHERE id='$id_cuentacobrado' ");

                 if ($query_insert && $query_tablar) {
                     $arrayName = array('noticia'=>'insert_correct','id'=>$id_cuentacobrado,'monto'=>$monto_debito);
                     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



                   }else {
                     $arrayName = array('noticia' =>'error_insertar');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                   }

         }else {
           $arrayName = array('noticia' =>'monto_cupera_capacidad');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }



     }







    if ($_POST['action'] == 'configurar_cuenta_transportista') {
      $monto_inicio                          = $_POST['monto_inicio'];
      $fecha_inicio_compra                   = $_POST['fecha_inicio_compra'];
      $fecha_final_compra                    = $_POST['fecha_final_compra'];
      $descripcion_cuenta_conrar             = $_POST['descripcion_cuenta_conrar'];
      $id_cuentacobrado                      = $_POST['id_cuentacobrado'];

      $query_cuenta = mysqli_query($conection,"SELECT * FROM cuentas_por_cobrar
        WHERE cuentas_por_cobrar.id = '$id_cuentacobrado'");
        $data_cuenta  = mysqli_fetch_array($query_cuenta);
        $monto_debito = $data_cuenta['debito'];
        $configurarcion = $data_cuenta['configurarcion'];
        if ($configurarcion == 'SI') {
          $arrayName = array('noticia' =>'cuenta_configurada');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         exit;
        }


        if ($monto_inicio <= $monto_debito) {

        $query_tablar=mysqli_query($conection,"INSERT INTO  facturacion_historial_cuentas_por_cobrar(id_cuentas_cobrar,id_user,valor_agregado,concepto)
                                                                       VALUES('$id_cuentacobrado','$iduser','$monto_inicio','MONTO INICIO') ");

                                $monto_debito = $monto_debito -$monto_inicio;


                $query_insert=mysqli_query($conection,"UPDATE cuentas_por_cobrar SET fecha_inicio ='$fecha_inicio_compra',fecha_final ='$fecha_final_compra',
                  descripcion ='$descripcion_cuenta_conrar',configurarcion='SI',debito='$monto_debito'  WHERE id='$id_cuentacobrado' ");

                if ($query_insert && $query_tablar) {
                    $arrayName = array('noticia'=>'insert_correct','id'=>$id_cuentacobrado);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



                  }else {
                    $arrayName = array('noticia' =>'error_insertar');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }

        }else {
          $arrayName = array('noticia' =>'monto_cupera_capacidad');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }



    }





    if ($_POST['action'] == 'buscar_producto_c_c') {
      $buscar_producto = $_POST['buscar_producto'];
      $query_producto = mysqli_query($conection,"SELECT * FROM producto_venta WHERE producto_venta.idproducto ='$buscar_producto'");
      $data_producto = mysqli_fetch_array($query_producto);
      echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);

    }

    if ($_POST['action'] == 'buscar_cliente_c') {
      $buscar_clientes = $_POST['buscar_clientes'];
      $query_clientes = mysqli_query($conection,"SELECT * FROM clientes WHERE clientes.id ='$buscar_clientes'");
      $data_clientes = mysqli_fetch_array($query_clientes);
      echo json_encode($data_clientes,JSON_UNESCAPED_UNICODE);

    }

    if ($_POST['action'] == 'agregar_item_asiento_perfomance') {
        $asiento              = $_POST['asiento'];
        $descripcion_concepto = $_POST['descripcion_concepto'];
        $debe                 = $_POST['debe'];
        $haber                = $_POST['haber'];
              $query_insert=mysqli_query($conection,"INSERT INTO asientos_contables (debe,haber,descripcion_concepto,secuencial,iduser)
                                                                           VALUES('$debe', '$haber','$descripcion_concepto','$asiento','$iduser') ");
        if ($query_insert) {
           $arrayName = array('noticia'=>'insert_correct');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
           $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }



    }




 ?>
