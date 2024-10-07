<?php
include("../../coneccion.php");
mysqli_set_charset($conection, 'utf8'); //linea a colocar
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');

  }else {

  }
$iduser= $_SESSION['id'];
$CodigoIngreso = $_REQUEST['codigo'];
$producto = $_REQUEST['producto'];
$comprador = $_REQUEST['comprador'];
$separacion_codigo = explode("-",$CodigoIngreso);
$contenido_qr = $separacion_codigo[0];
$token = $separacion_codigo[1];


$query_comprador_user  = mysqli_query($conection,"SELECT * FROM usuarios WHERE id='$comprador'");
$existencia_user    = mysqli_num_rows($query_comprador_user);
$result_user 	  = mysqli_fetch_array($query_comprador_user);
$codigo_interno_user = $result_user['codigo_qr_unico'];
$token_id = $result_user['token'];
$estado_token_id = $result_user['estado_token'];
$fecha_maxima_token_id = $result_user['fecha_maxima_token'];


$query_comprador_codigo  = mysqli_query($conection,"SELECT * FROM usuarios WHERE codigo_qr_unico= '$contenido_qr' ");
$existencia_codigo    = mysqli_num_rows($query_comprador_codigo);
$result_user_codigo 	  = mysqli_fetch_array($query_comprador_codigo);
$id_interno             = $result_user_codigo['id'];
$password_bd             = $result_user_codigo['password'];
$token_qr                = $result_user_codigo['token'];
$estado_token_qr         = $result_user_codigo['estado_token'];
$fecha_maxima_token_qr   = $result_user_codigo['fecha_maxima_token'];



$query_producto  = mysqli_query($conection,"SELECT * FROM producto_venta WHERE idproducto='$producto'");
$existencia_producto    = mysqli_num_rows($query_producto);
$result_producto_codigo 	  = mysqli_fetch_array($query_producto);
$id_interno_producti = $result_producto_codigo['precio'];
$dueno_producto  = $result_producto_codigo['id_usuario'];
$categorias_imt = $result_producto_codigo['categorias'];
//COMPROBAMOS SI LA PERSONA ES LA QUE VENDE, SI LA PERSONA ES DUENA DEL PRODUCTO SE REALIZA LA VENTA SINO MUESTRA ERROR
if ($iduser != $dueno_producto ) {
  echo '
  <div class="mensaje_registro_existente">
       <p style="font-size: 25px">ERROR EN LA PRIVACIDAD</label>
    </p>
    </div>
  ';
  exit;
}else {
          if ($token_qr == $token) {
            if ($estado_token_qr == 'Activo') {
              $mifecha = new DateTime();
              $mifecha->modify('-5 hours');
              $y =  $mifecha->format('d-m-Y H:i:s');
            }else {
              echo '
              <div class="mensaje_registro_existente">
                   <p style="font-size: 25px">CREDENCIALES INACTIVAS</label>
                </p>
                </div>
              ';
              exit;
            }

            if ($fecha_maxima_token_qr>$y) {
            }else {
              echo '
              <div class="mensaje_registro_existente">
                   <p style="font-size: 25px">TIEMPO DE CODIGO AGOTADO</label>
                </p>
                </div>
              ';
              exit;
            }
            // code...
          }else {
            echo '
            <div class="mensaje_registro_existente">
                 <p style="font-size: 25px">ERROR EN PARAMETROS DE SEGURIDAD</label>
              </p>
              </div>
            ';
            exit;
          }
}

$status =1;
if (!empty($existencia_codigo)) {
		if($codigo_interno_user== $contenido_qr){
      $queryu = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$comprador'");
     $resultu = mysqli_fetch_array($queryu);
     $fecha_usuario = $resultu['fecha_creacion'];
     $email_comprador = $resultu['email'];
     $nombres_comprador = $resultu['nombres'];
       $apellidos_comprador = $resultu['apellidos'];
       $query_config          = mysqli_query($conection, "SELECT * FROM `configuraciones` ");
       $result_config         = mysqli_fetch_array($query_config);
       $porcentaje_venta           = $result_config['porcentaje_venta'];
       $query_producto = mysqli_query($conection, "SELECT producto_venta.nombre,producto_venta.precio,ciudad.nombre as 'ciudad', provincia.nombre as 'provincia',producto_venta.fecha_evento,
producto_venta.hora_evento,producto_venta.identificador_trabajo,producto_venta.porcentaje,producto_venta.foto,producto_venta.tipo_libro,producto_venta.enlace_mega,producto_venta.encriptacion_mega_libro,
producto_venta.id_usuario,producto_venta.peso,usuarios.posicion,usuarios.email,producto_venta.categorias,producto_venta.subcategorias,producto_venta.estado_colaboracion FROM producto_venta
       INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
       INNER JOIN provincia ON provincia.id = producto_venta.provincia
       INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
       WHERE idproducto = $producto");
       $result_producto = mysqli_fetch_array($query_producto);
       $peso_uu              =  $result_producto['peso'];
       $precio_producto      =  $result_producto['precio'];
       $nombre_producto      =  $result_producto['nombre'];
       $tipo_libro      =  $result_producto['tipo_libro'];


       $cantidad_producto = 1;
       $precio_totalitario_compra = ($precio_producto*$cantidad_producto);
       $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $comprador ");
       $intentos_result= mysqli_fetch_array($intentos);
       $intentos_totales = $intentos_result['intentos'];
       $query_important = mysqli_query($conection, "SELECT * FROM telenchana_1804843900");
       $result_important = mysqli_fetch_array($query_important);
       $cantidad_importante =  $result_important['cantidad'];

       if ($intentos_totales < 4) {
          if ( $contenido_qr == $codigo_interno_user) {
            $query_saldo = mysqli_query($conection, "SELECT * FROM saldo_total_leben WHERE idusuario = $comprador");
            $result_saldo = mysqli_fetch_array($query_saldo);
            $saldo =  $result_saldo['cantidad'];
            if ( $saldo >= $precio_totalitario_compra) {
              date_default_timezone_set("America/Lima");
              $fecha_actual = date('d-m-Y H:m:s', time());
              $fecha_tope_venta = date("d-m-Y H:m:s",strtotime($fecha_actual."+ 1 days"));
             $query_ganancias = mysqli_query($conection, "SELECT * FROM ganacias_netas_1804843900_leben_t");
             $result_ganancias = mysqli_fetch_array($query_ganancias);
             $ganancias_anteriores = $result_ganancias['ganacias_netas'];
             $ganancias_comision = ($precio_producto - ($precio_producto-($precio_producto*$porcentaje_venta/100)))*$cantidad_producto;
             $nuva_cantidad_ganancias = $ganancias_anteriores+$ganancias_comision;
             $posicion_producto = '';
             $tiempo_entrega  ='';
             $posicion_total  = '';
             $precio_final_transporte  = '';
             $transporte_compra_agil  = '';
             $precio_final_transporte  = '';
               $identificador_trabajo =  $result_producto['identificador_trabajo'];
             if ($identificador_trabajo == 'producto') {
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
               $query_insert=mysqli_query($conection,"INSERT INTO ventas(codigo_venta,qr_venta,precio_compra,desde_transporta,tiempo_entrega,hasta_donde_se_transporta,precio_transporte,transporte_compra_agil,cantidad_producto,idp,id_comprador,estado_financiero,metodo_pago,fecha_inicio_venta,fecha_tope_venta)
               VALUES('$contenido','$oidgo_venta_evento','$precio_totalitario_compra','$posicion_producto','$tiempo_entrega','$posicion_total','$precio_final_transporte','$transporte_compra_agil','$cantidad_producto','$producto','$comprador','PAGADO','Mi Leben','$fecha_actual','$fecha_tope_venta') ");

             }

            $query_cambio_ganancias =mysqli_query($conection,"UPDATE ganacias_netas_1804843900_leben_t SET ganacias_netas= '$nuva_cantidad_ganancias'");
               if ($query_insert) {

                 $saldo_nuevo = $saldo - $precio_totalitario_compra;


                 $importante_nuevo = $cantidad_importante+$precio_producto;
                 $query_insert_saldo=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad='$saldo_nuevo' WHERE idusuario = $comprador ");
                 $query_insert_saldo=mysqli_query($conection,"UPDATE telenchana_1804843900 SET cantidad='$importante_nuevo'");
                 $query_historial=mysqli_query($conection,"INSERT INTO historial_bancario(precio_unidad,cantidad_producto,idp,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
                 VALUES('$precio_producto','$cantidad_producto','$producto','$precio_totalitario_compra','0','$comprador','$precio_totalitario_compra','Compra','Mi Leben','$dueno_producto','Ninguno') ");

                 if ($query_insert_saldo && $query_historial ){
                   $query_insert_historial=mysqli_query($conection,"INSERT INTO  historial_pagos(id_usuario,idproducto,cantidad_antes,cantidad_despues,precio_prod)
                                                  VALUES('$comprador','$producto','$saldo','$saldo_nuevo','$precio_totalitario_compra') ");
                               if ($query_insert_historial){
                                 /*AQUI VA EL CODIGO PARA TRANSFERIIR EL DINERO A LA PERSONA PROPIETARIA DEL PROPDUCTO*/
                                 $query_bancario = mysqli_query($conection, "SELECT saldo_total_leben.cantidad,saldo_total_leben.idusuario FROM saldo_total_leben
                                 WHERE idusuario = $iduser");
                                 $result_bancario = mysqli_fetch_array($query_bancario);
                                 $cantidad_bancaria = $result_bancario['cantidad'];//CANTIDAD ACTUAL DEL PROPIETARIO DEL PRODUCTO
                                 $porcentaje_comision = 0.025;
                                 $detalle_colaboracion = '';

                                 //CODIGO PARA SEPARA LOS DIFERENTES PORCENTAJES
                                 $total_precio_compra_k = $precio_producto*$cantidad_producto;
                                 if ($total_precio_compra_k < 10) {
                                   $total_transferencia = ($precio_producto-($precio_producto*$porcentaje_comision))*$cantidad_producto+$cantidad_bancaria;
                                   $cantidad_parcial = ($precio_producto-($precio_producto*$porcentaje_comision))*$cantidad_producto;
                                   $cantidad_comision = $precio_producto*$cantidad_producto*$porcentaje_comision;
                                   $G_T = $cantidad_producto*$precio_producto;
                                   // code...
                                 }else {
                                   $total_transferencia = $precio_producto*$cantidad_producto+$cantidad_bancaria-0.25;
                                   $cantidad_parcial = $precio_producto*$cantidad_producto-0.25;
                                   $cantidad_comision = 0.25;
                                   $G_T = $cantidad_producto*$precio_producto;
                                   // code...
                                 }

                                 /**/
                                 /*CODIGO PARA SACAR EL ID DE LA VENTA */
                                 $query_id_venta = mysqli_query($conection,"SELECT ventas.id as 'venta_id_if',usuarios.email as 'email_propietario' FROM ventas
                                    INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
                                    INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
                                    WHERE id_comprador = '$comprador' AND idp = '$producto' AND producto_venta.id_usuario = '$iduser'
                                    ORDER BY ventas.id DESC LIMIT 1");
                                    $result_info_venta = mysqli_fetch_array($query_id_venta);
                                    $venta_id_if = $result_info_venta['venta_id_if'];
                                    $email_propietario = $result_info_venta['email_propietario'];

                                 /*CODIGO PARA INSERTA AL PROPIETARIO */
                                 $query_insert_dinero=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$total_transferencia'  WHERE idusuario='$iduser' ");
                                 $query_insert=mysqli_query($conection,"UPDATE ventas SET solicitud_pago='PAGADO',fecha_solicitud_pago ='$fecha_actual',tipo_retiro='Mi leben',estado='Finalizada'  WHERE ventas.id='$venta_id_if' ");
                                 $query_historial=mysqli_query($conection,"INSERT INTO historial_bancario(detalle_colaboracion,id_venta,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
                                 VALUES('$detalle_colaboracion','$venta_id_if','$cantidad_parcial','$cantidad_comision','$iduser','$G_T','Venta','Mi Leben','$iduser','Ninguno') ");

                                   if ($identificador_trabajo == 'producto') {
                                     if ($query_insert) {
                                         try {
                                           // Configuración del servidor
                                           $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                           $mail -> isSMTP ();                                          // Enviar usando SMTP
                                           $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                           $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                           $mail ->Username = 'guibis-ecuador@guibis.com' ;                    // Nombrede usuario SMTP
                                           $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                           $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                           $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                           // Destinatarios
                                           $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                           $mail -> addAddress ( $email_comprador);     // Agrega un destinatario
                                            $mail -> addAddress ( $email_propietario);     // Agrega un destinatario

                                           // Contenido
                                           $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                           $mail->CharSet = 'UTF-8';
                                           $mail -> Subject = 'Compra Exitosa de '.$nombre_producto.'' ;
                                           if ($tipo_libro=='Digital') {
                                             $mail -> Body     = '
                                             <div class="img_logo" style="text-align: center;  background:">
                                               <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >
                                             </div>
                                             <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                                <h3 style="text-align:center; color:#fff;   font-size: 25px; margin:0; padding:0;">'.$nombres_comprador.' '.$apellidos_comprador.' Tu compra del Evento '.$nombre_producto.' ha sido exitosa. </h3>
                                                <p style="font-weight: bold; font-style: italic;" >Gracias por ser parte de esta familia</p>
                                                <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">
                                               '.$nombres_comprador.' '.$apellidos_comprador.' haz realizado una compra de '.$nombre_producto.' a un precio de $'.$precio_producto.' por unidad y el total de $'.$precio_totalitario_compra.', la cantidad de '.$cantidad_producto.',
                                             este producto se encuentra en Categorias Libros, por lo que el usuario a subido la informacion necesaria para que puedas acceder de manera remota.</p>
                                                <br>
                                                <div class="encriptacion_mega">
                                                  <p style="background: #fff;color: #000;width: 500px;margin: 0 auto;font-size: 20px;border-radius: 20px;">'.$encriptacion_mega_libro.'</p>

                                                </div>
                                                <div style="padding: 6px;margin: 10px;" class="contenido_mega">
                                                  <a href="'.$enlace_mega.'"> <img style="width: 90px;" src="https://guibis.com/home/img/reacciones/mega.png" alt=""> </a>
                                                </div>

                                                <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                                                <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                                                <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                                                <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                                                <div style="border-color: #fff;border-width: 1px;
                                             border-style: solid;
                                             border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                                             <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                                </div>
                                              <br>
                                                </div>
                                                <br>
                                                <div class="redes_email" style="text-align: center;">
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                                                </div>
                                             ' ;
                                           }else {
                                             // code...
                                             $mail -> Body     = '
                                             <div class="img_logo" style="text-align: center;  background:">
                                               <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >
                                             </div>
                                             <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                                <h3 style="text-align:center; color:#fff;   font-size: 25px; margin:0; padding:0;">'.$nombres_comprador.' '.$apellidos_comprador.' Tu compra del Evento '.$nombre_producto.' ha sido exitosa. </h3>
                                                <p style="font-weight: bold; font-style: italic;" >Gracias por ser parte de esta familia</p>
                                                <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">
                                               '.$nombres_comprador.' '.$apellidos_comprador.' haz realizado una compra de '.$nombre_producto.' a un precio de $'.$precio_producto.' por unidad y el total de $'.$precio_totalitario_compra.', la cantidad de '.$cantidad_producto.',
                                             este producto se encuentra en Categorias Libros, por lo que el usuario no ha indicado el tipo de libro que es.</p>
                                                <br>

                                                <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                                                <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                                                <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                                                <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                                                <div style="border-color: #fff;border-width: 1px;
                                             border-style: solid;
                                             border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                                             <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                                </div>
                                              <br>
                                                </div>
                                                <br>
                                                <div class="redes_email" style="text-align: center;">
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                                  <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                                                </div>
                                             ' ;
                                           }
                                           $mail -> send ();
                                         } catch ( Exception  $e ) {
                                         }
                                         // CODIGO PARA HACER LA TRANSFERENCIA
                                       }
                                   }
                           echo '
                           <div class="tabla_resultados">
                             <h4>Compra Exitosa</h4>
                             <table>
                               <tr>
                                 <td>  <img src="/home/img/reacciones/garrapata.png" alt="" width="50%"> </td>
                               </tr>

                             </table>
                           </div>
                           ';
                           }else {

                           }
                   }else {

                    echo '
                    <div class="tabla_resultados">
                      <h4>Error de servidor</h4>
                      <table>
                        <tr>
                          <td>  <img src="/home/img/reacciones/cerrar.png" alt="" width="50%"> </td>
                        </tr>

                      </table>
                    </div>
                    ';
                   }
               }else {
                echo '
                <div class="tabla_resultados">
                  <h4>Error en el servidor</h4>
                  <table>
                    <tr>
                      <td>  <img src="/home/img/reacciones/cerrar.png" alt="" width="50%"> </td>
                    </tr>

                  </table>
                </div>
                ';
               }
            }else {

             echo '
             <div class="tabla_resultados">
               <h4>Saldo Insuficiente</h4>
               <table>
                 <tr>
                   <td>  <img src="/home/img/reacciones/cerrar.png" alt="" width="50%"> </td>
                 </tr>

               </table>
             </div>
             ';
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
         echo '
         <div class="tabla_resultados">
           <h4>Intentos Maximos</h4>
           <table>
             <tr>
               <td>  <img src="/home/img/reacciones/cerrar.png" alt="" width="50%"> </td>
             </tr>

           </table>
         </div>
         ';
        }



		}else{ ?>
			<div class="mensaje_registro_existente">
		       <p style="font-size: 25px;font-family: 'Varela Round', sans-serif;">Error de Privacidad</label>
		        inactivo </b>.
				</p>
		    </div>
			<?php }
}else{ ?>
	 	<div class="mensaje_registro_no_existente">
           <p style="font-family: 'Varela Round', sans-serif;">No hay registro asociado
				<b style="color: red;font-family: 'Varela Round', sans-serif;"></b>
			</p>
        </div>
<?php } ?>
