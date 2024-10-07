<?php
include("../escan_evento/resources/php/conexion.php");
include "../../coneccion.php";
session_start();
if (empty($_SESSION['active'])) {
	header('location:/');
}else {
	   $iduser= $_SESSION['id'];
	$queryu = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
 $resultu = mysqli_fetch_array($queryu);
 $email_user_login = $resultu['email'];
 $nombres_user_login = $resultu['nombres'];
	 $apellidos_user_login = $resultu['apellidos'];
}
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );

$CodigoIngreso = $_REQUEST['codigo'];


$BuscarCodigo   = ("SELECT * FROM ventas WHERE codigo_venta='".$CodigoIngreso."' LIMIT 1");
$resultado  = mysqli_query($con, $BuscarCodigo);
$cantidadExistente    = mysqli_num_rows($resultado);
$InfoCodigo 	  = mysqli_fetch_array($resultado);
echo "<br><br>";
$status ='Escaneado';
if (!empty($cantidadExistente)) {
		if($InfoCodigo['estatdus_entrada_evento'] != $status){
				$cambiarStatus = ("UPDATE ventas SET estatdus_entrada_evento='".$status."'  WHERE codigo_venta='".$CodigoIngreso."'");
				$resStatu =    mysqli_query($con,$cambiarStatus);
				$sql = ("SELECT * FROM ventas
					INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
          INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
					 WHERE codigo_venta='".$CodigoIngreso."' ");
				$listado_clientes = mysqli_query($con, $sql);
					include('salida_datos.php');
				$nombres = $row_expo['nombres'];
				$apellidos= $row_expo['apellidos'];
				$email_comprador= $row_expo['email'];
				$id_venta= $row_expo['id'];
				$idp= $row_expo['idp'];
				$nombre_evento = $row_expo['nombre'];
				$fecha_venta= $row_expo['fecha_inicio_venta'];
				$qr_venta= $row_expo['qr_venta'];
				$descripcion= $row_expo['descripcion'];
				$foto_evento= $row_expo['foto'];
				$fecha_producto= $row_expo['fecha_producto'];
				$fecha_evento= $row_expo['fecha_evento'];
				$hora_evento= $row_expo['hora_evento'];
				$tipo_evento= $row_expo['tipo_evento'];
				$tipo_asiento= $row_expo['tipo_asiento'];

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
				  $mail -> addAddress ('eventos@guibis.com');     // Agrega un destinatario
				  $mail -> addAddress ($email_user_login);     // Agrega un destinatario



				  // Contenido
				  $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
				  $mail->CharSet = 'UTF-8';
				  $mail -> Subject = 'Entrada al Evento '.$nombre_evento.' Exitosa ' ;
				  $mail -> Body     = '
				  <div class="img_logo" style="text-align: center;  background:">
				    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

				  </div>
				  <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;" >
				     <h3 style="text-align:center; color:#fff;   font-size: 25px; margin:0; padding:0;">'.$nombres.' '.$apellidos.' entrada al Evento Exitoso. </h3>
				     <p style="font-weight: bold; font-style: italic;" >Gracias por ser parte de esta familia</p>
				     <p style="text-align: justify; width: 85%; margin: 0 auto;">
				'.$nombres.' '.$apellidos.' se ha realizado el proceso de verificación con éxito  de tu entrada digital #'.$id_venta.' , para el evento '.$nombre_evento.' con codigo #'.$idp.',
				  la creación del este evento fue '.$fecha_producto.' con descripción “'.$descripcion.'” ,  tu compra fue el '.$fecha_venta.', el evento  a realizarse
				  para el '.$fecha_evento.' a la hora  '.$hora_evento.' de tipo '.$tipo_evento.' con asiento '.$tipo_asiento.', esta entrada se ha escaneado con éxito y ya no tiene validez.</p>
				     <br>


				     <p>Te recordamos que la seguridad externa de tu entrada es netamente del propietario de la cuenta.</p>
				     <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
				     <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
				     <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte-eventos@guibis.com </p>
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
				  $mail -> send ();
				} catch ( Exception  $e ) {
				}





		}else{ ?>
			<?php
			$sql = ("SELECT * FROM ventas
				INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
				INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
				 WHERE codigo_venta='".$CodigoIngreso."' ");
			$listado_clientes = mysqli_query($con, $sql);
			 $row_expo = mysqli_fetch_array($listado_clientes); ?>
			<div class="mensaje_registro_existente">
		       <p style="font-size: 25px;font-family: 'Varela Round', sans-serif;">El Código de<label style="color: white;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['nombres'];?> <?php echo $row_expo['apellidos'];?></label>
		        ya ha sido <b style="color: white;font-family: 'Varela Round', sans-serif;">Escaneado</b>.
				</p>
		    </div>
			<?php }
}else{ ?>
	 	<div class="mensaje_registro_no_existente">
           <p style="font-family: 'Varela Round', sans-serif;">No hay registro asociado al Código
				<b style="color: red;font-family: 'Varela Round', sans-serif;"> (<?php echo $CodigoIngreso; ?>)</b>
			</p>
        </div>
<?php } ?>
