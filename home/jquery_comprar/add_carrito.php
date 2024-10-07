<?php
 session_start();
 $iduser= $_SESSION['id'];
 if (empty($_SESSION['active'])) {
   header('location:/');
 }
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
  if ($_POST['action']=='agregar_producto_carrito') {
    $producto = $_POST['producto'];
    $codigo_mesa = $_POST['codigo_mesa'];

    $query_producto = mysqli_query($conection, "SELECT * FROM tomar_pedidos_cafe_tech   WHERE id_producto = '$producto'
    AND id_emisor = '$iduser' AND codigo_mesa = '$codigo_mesa'");
    $resultu = mysqli_fetch_array($query_producto);
    if ($resultu > 0) {

      $query_info_producto = mysqli_query($conection, "SELECT * FROM producto_venta   WHERE idproducto = '$producto'");
        $data_producto = mysqli_fetch_array($query_info_producto);
        $nombre_producto = $data_producto['nombre'];
        $valor_unidad = $data_producto['precio'];
        $descripcion_producto = $data_producto['descripcion'];
        $valor_unidad_final_con_impuestps = $data_producto['valor_unidad_final_con_impuestps'];

        $tipo_ambiente = $data_producto['tipo_ambiente'];
        $codigos_impuestos = $data_producto['codigos_impuestos'];

        $cantidad_producto = $resultu['cantidad_producto'];
        $cantidad_producto =$cantidad_producto+1;

        $iva_producto = $cantidad_producto*($valor_unidad_final_con_impuestps-$valor_unidad);

        $precio_neto = $valor_unidad*$cantidad_producto;


        $query_edit_saldo=mysqli_query($conection,"UPDATE tomar_pedidos_cafe_tech SET cantidad_producto= '$cantidad_producto',nombre_producto='$nombre_producto',
          valor_unidad = '$valor_unidad',descripcion_producto='$descripcion_producto',iva_producto=$iva_producto,precio_neto='$precio_neto',precio_p_incluido_iva='$valor_unidad_final_con_impuestps',
          tipo_ambiente='$tipo_ambiente',codigos_impuestos='$codigos_impuestos'
          WHERE id_producto = '$producto' AND id_emisor = '$iduser'  AND codigo_mesa = '$codigo_mesa' ");
          if ($query_edit_saldo) {

            $arrayName = array('noticia' =>'agregado_mas_uno','idp'=>$producto,'cantidad'=>$cantidad_producto,'codigo_mesa'=>$codigo_mesa );
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
    }else {


      $query_info_producto = mysqli_query($conection, "SELECT * FROM producto_venta   WHERE idproducto = '$producto'");
        $data_producto = mysqli_fetch_array($query_info_producto);
        $nombre_producto = $data_producto['nombre'];
        $valor_unidad = $data_producto['precio'];
        $descripcion_producto = $data_producto['descripcion'];
        $valor_unidad_final_con_impuestps = $data_producto['valor_unidad_final_con_impuestps'];

        $tipo_ambiente = $data_producto['tipo_ambiente'];
        $codigos_impuestos = $data_producto['codigos_impuestos'];

        $cantidad_producto = 1;


        $iva_producto = $cantidad_producto*($valor_unidad_final_con_impuestps-$valor_unidad);

        $precio_neto = $valor_unidad*$cantidad_producto;




    $query_insert=mysqli_query($conection,"INSERT INTO tomar_pedidos_cafe_tech(id_producto,id_emisor,cantidad_producto,codigo_mesa,nombre_producto,valor_unidad,descripcion_producto,iva_producto,precio_neto,precio_p_incluido_iva,tipo_ambiente,codigos_impuestos)
                                                                VALUES('$producto','$iduser','$cantidad_producto','$codigo_mesa','$nombre_producto','$valor_unidad','$descripcion_producto','$iva_producto','$precio_neto','$valor_unidad_final_con_impuestps','$tipo_ambiente','$codigos_impuestos') ");
            if ($query_insert) {
                $arrayName = array('noticia' =>'agregado_mas_uno','idp'=>$producto,'cantidad'=>$cantidad_producto,'codigo_mesa'=>$codigo_mesa );
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }



    }


  }

  if ($_POST['action']=='limpiar_carrito_compras') {

    $query_delete=mysqli_query($conection,"DELETE add_carrito_general FROM add_carrito_general WHERE add_carrito_general.id_comprador = '$iduser' ");
    if ($query_delete) {
      if ($query_delete){
        $arrayName = array('noticia' =>'limpia_correcta');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
        }
    }
  }




  if ($_POST['action']=='restar_uno_producto') {
    $producto = $_POST['producto'];
        $codigo_mesa = $_POST['codigo_mesa'];
    $query_producto = mysqli_query($conection, "SELECT * FROM tomar_pedidos_cafe_tech   WHERE id_producto = '$producto'
    AND id_emisor = '$iduser' AND codigo_mesa = '$codigo_mesa'");
    $resultu = mysqli_fetch_array($query_producto);
    if ($resultu > 0) {
        $cantidad_producto = $resultu['cantidad_producto'];
        $cantidad_producto =$cantidad_producto-1;
        if ($cantidad_producto <  0) {
            $cantidad_producto = 0;
        }
        if ($cantidad_producto == 0) {

          $query_delete=mysqli_query($conection,"DELETE tomar_pedidos_cafe_tech FROM tomar_pedidos_cafe_tech WHERE tomar_pedidos_cafe_tech.id_emisor = '$iduser'
            AND tomar_pedidos_cafe_tech.id_producto='$producto' AND codigo_mesa = '$codigo_mesa' ");

            if ($query_delete) {
              $arrayName = array('noticia' =>'agregado_menos_uno','idp'=>$producto,'cantidad'=>$cantidad_producto,'codigo_mesa'=>$codigo_mesa );
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              // code...
            }
        }else {


          $query_info_producto = mysqli_query($conection, "SELECT * FROM producto_venta   WHERE idproducto = '$producto'");
            $data_producto = mysqli_fetch_array($query_info_producto);
            $nombre_producto = $data_producto['nombre'];
            $valor_unidad = $data_producto['precio'];
            $descripcion_producto = $data_producto['descripcion'];
            $valor_unidad_final_con_impuestps = $data_producto['valor_unidad_final_con_impuestps'];

            $tipo_ambiente = $data_producto['tipo_ambiente'];
            $codigos_impuestos = $data_producto['codigos_impuestos'];

            $iva_producto = $cantidad_producto*($valor_unidad_final_con_impuestps-$valor_unidad);

            $precio_neto = $valor_unidad*$cantidad_producto;

          $query_edit_saldo=mysqli_query($conection,"UPDATE tomar_pedidos_cafe_tech SET cantidad_producto= '$cantidad_producto',nombre_producto='$nombre_producto',
            valor_unidad = '$valor_unidad',descripcion_producto='$descripcion_producto',iva_producto=$iva_producto,precio_neto='$precio_neto',precio_p_incluido_iva='$valor_unidad_final_con_impuestps',
            tipo_ambiente='$tipo_ambiente',codigos_impuestos='$codigos_impuestos'
            WHERE id_producto = '$producto' AND id_emisor = '$iduser' AND codigo_mesa = '$codigo_mesa' ");
            if ($query_edit_saldo) {
              $arrayName = array('noticia' =>'agregado_menos_uno','idp'=>$producto,'cantidad'=>$cantidad_producto,'codigo_mesa'=>$codigo_mesa );
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
        }


    }else {
                $arrayName = array('noticia' =>'agregado_menos_uno','idp'=>$producto,'cantidad'=>'0','codigo_mesa'=>$codigo_mesa );
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

    }
  }

  if ($_POST['action'] == 'comprar_varios') {
    $tienda   = $_POST['tienda'];
    $password = $_POST['password'];

    $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
    $result = mysqli_fetch_array($query);
    $password_bd =  $result['password'];
    $query_saldo = mysqli_query($conection, "SELECT * FROM saldo_total_leben WHERE idusuario = $iduser");
    $result_saldo = mysqli_fetch_array($query_saldo);
    $saldo =  $result_saldo['cantidad'];

    $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $iduser ");
    $intentos_result= mysqli_fetch_array($intentos);
    $intentos_totales = $intentos_result['intentos'];

    $query_lista_t = mysqli_query($conection,"SELECT SUM(((add_carrito_general.cantidad_producto)*(producto_venta.precio))) as
    'compra_total'
    FROM `add_carrito_general`
       INNER JOIN producto_venta ON producto_venta.idproducto = add_carrito_general.id_producto
       INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
       WHERE add_carrito_general.id_comprador = $iduser AND producto_venta.id_usuario = $tienda");
    $data_lista_t=mysqli_fetch_array($query_lista_t);
    $precio_compra = $data_lista_t['compra_total'];
    $saldo_nuevo = ($saldo-$precio_compra);




    if ($intentos_totales < 4) {

       if (md5($password) == $password_bd) {
         if ( $saldo >= $precio_compra) {
           date_default_timezone_set("America/Lima");
          $fecha_actual = date('d-m-Y H:m:s', time());
          $fecha_tope_venta = date("d-m-Y H:m:s",strtotime($fecha_actual."+ 1 days"));
          $query_ganancias = mysqli_query($conection, "SELECT * FROM ganacias_netas_1804843900_leben_t");
          $result_ganancias = mysqli_fetch_array($query_ganancias);
          $ganancias_anteriores = $result_ganancias['ganacias_netas'];
          $ganancias_comision = $precio_compra*0.03;
          $nuva_cantidad_ganancias = $ganancias_anteriores+$ganancias_comision;



            require '../QR/phpqrcode/qrlib.php';
            $dir = '../img/qr_ventas/';
            $oidgo_venta_evento = 'qr'.md5($iduser.$password_bd.date('d-m-Y H:m:s')).'.png';
            $int_contenido = md5($iduser.$password_bd.date('d-m-Y H:m:s').$iduser.$password_bd);
            $filename = $dir.$oidgo_venta_evento;
            $tamanio = 7;
            $level = 'H';
            $frameSize = 5;
            $contenido = $int_contenido;
            QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
            $query_lista = mysqli_query($conection,"SELECT add_carrito_general.id_producto,producto_venta.nombre,add_carrito_general.cantidad_producto,producto_venta.precio FROM `add_carrito_general`
            INNER JOIN producto_venta ON producto_venta.idproducto = add_carrito_general.id_producto
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            WHERE add_carrito_general.id_comprador = $iduser AND producto_venta.id_usuario = $tienda");
            while ($data_lista=mysqli_fetch_array($query_lista)) {
              $id_producto = $data_lista['id_producto'];
              $precio_producto      = $data_lista['precio'];
              $cantidad_producto      = $data_lista['cantidad_producto'];

              $query_insert=mysqli_query($conection,"INSERT INTO ventas(codigo_venta,qr_venta,precio_compra,desde_transporta,tiempo_entrega,hasta_donde_se_transporta,precio_transporte,transporte_compra_agil,cantidad_producto,idp,id_comprador,estado_financiero,metodo_pago,fecha_inicio_venta,fecha_tope_venta)
              VALUES('$contenido','$oidgo_venta_evento','$precio_producto','','','','','','$cantidad_producto','$id_producto','$iduser','PAGADO','Mi Leben','$fecha_actual','$fecha_tope_venta') ");

              $query_historial=mysqli_query($conection,"INSERT INTO historial_bancario(precio_unidad,cantidad_producto,idp,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
              VALUES('$precio_producto','$cantidad_producto','$id_producto','$precio_producto','0','$iduser','$precio_producto','Compra','Mi Leben','$tienda','Ninguno') ");

              $query_insert_historial=mysqli_query($conection,"INSERT INTO  historial_pagos(id_usuario,idproducto,cantidad_antes,cantidad_despues,precio_prod)
                                             VALUES('$iduser','$id_producto','$saldo','$saldo_nuevo','$precio_producto') ");
            }

            $query_cambio_ganancias =mysqli_query($conection,"UPDATE ganacias_netas_1804843900_leben_t SET ganacias_netas= '$nuva_cantidad_ganancias'");
            if ($query_insert) {
              $query_delete=mysqli_query($conection,"DELETE add_carrito_general FROM add_carrito_general
         INNER JOIN producto_venta  ON producto_venta.idproducto=add_carrito_general.id_producto WHERE add_carrito_general.id_comprador = '$iduser' AND producto_venta.id_usuario='$tienda' ");


              $saldo_nuevo = ($saldo-$precio_compra);
              $saldo_nuevo = ($saldo_nuevo);
              $query_insert_saldo=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad='$saldo_nuevo' WHERE idusuario = $iduser ");

              if ($query_insert_saldo && $query_historial ){

                            if ($query_insert_historial){
                        $arrayName = array('resultado' =>'comprado_correctamente','nuevo_saldo' =>$saldo_nuevo);
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        }else {
                        $arrayName = array('resultado' =>'error_insertar_historial');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                        }
                }else {
                  $arrayName = array('resultado' =>'error_insertar_saldo');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }
            }else {
              $arrayName = array('resultado' =>'error_insertar_en_ventas');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
         }else {
           $arrayName = array('resultado' =>'saldo_insuficiente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
         // code...
       }else {
         $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario)
                                       VALUES('$iduser') ");
                                       if ($query_insert_incorrect_password){
                                         $arrayName = array('resultado' =>'contrasena_incorrecta');
                                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                         }else {
                                         }
       }
     }else {
       $arrayName = array('resultado' =>'intentos_maximos');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }
    // code...
  }


?>
