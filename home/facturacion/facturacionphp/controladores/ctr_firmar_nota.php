<?php
//require_once 'ruth_esmeralda_sanchez_herrera.p12';
//if (isset($_POST['submit'])) {
class autorizar_ticket {
	public function autorizar_xml_tiket($codigo_factura) {



		 require '../../../QR/phpqrcode/qrlib.php';
	   	include "../../../../coneccion.php";
		  mysqli_set_charset($conection, 'utf8'); //linea a colocar


		    if ($_SESSION['rol'] == 'cuenta_empresa') {
		    include "../../../sessiones/session_cuenta_empresa.php";

		    }

		    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
		    include "../../../sessiones/session_cuenta_usuario_venta.php";

		    }

		    if ($_SESSION['rol'] == 'Mesero') {
		    include "../../../sessiones/session_cuenta_mesero.php";

		    }

		    if ($_SESSION['rol'] == 'Cocina') {
		    include "../../../sessiones/session_cuenta_cocina.php";
		    }

				$rol_user = $_SESSION['rol'];





		include '../lib/PHPMailer/PHPMailerAutoload.php';

		$codigo_factura_comprobantes = $codigo_factura;


   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;


	 $query_secuencial = mysqli_query($conection, "SELECT * FROM  tikets  WHERE  tikets.id_emisor  = '$iduser'  ORDER BY fecha DESC");
		$result = mysqli_fetch_array($query_secuencial);
		if ($result) {
			$secuencial = $result['codigo_factura'];
			$secuencial = $secuencial+1;
			// code...
		}else {
			$secuencial =1;
		}
		//CODIGO PARA DISMINUIR LA CANTIDAD DE LOS PRODUCTOS EXISTENTES
		$query_actualizar_cantidad = mysqli_query($conection,"SELECT * FROM comprobantes
			WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura'");
	 while ($resultados_actualizar = mysqli_fetch_array($query_actualizar_cantidad)) {
			 if ($resultados_actualizar['id_producto'] != '0') {
         $id_producto = $resultados_actualizar['id_producto'];
				 $cantidad_vende = $resultados_actualizar['cantidad_producto'];

				 $query_resultados_productos = mysqli_query($conection,"SELECT * FROM producto_venta   WHERE idproducto= '$id_producto'");
				 $resultados_producto = mysqli_fetch_array($query_resultados_productos);
				 $cantidad_existente = $resultados_producto['cantidad'];
         $cantidad_new = $cantidad_existente-$cantidad_vende;
				 $query_edit_cantidad = mysqli_query($conection,"UPDATE producto_venta SET cantidad='$cantidad_new' WHERE idproducto = '$id_producto'");
				 $query_insert_cantidad=mysqli_query($conection,"INSERT INTO inventario(cantidad,motivo,detalles_extras,idproducto,iduser,cantidad_new,accion,codigo_ingreso,url_upload)
																																		 VALUES('$cantidad_vende','VENTA SISTEMA','TICKET','$id_producto','$iduser','$cantidad_new','DISMINUIR','$codigo_factura','$url2') ");

			 }
		}

		$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
		$result_documentos = mysqli_fetch_array($query_doccumentos);
		$img_logo                = $result_documentos['img_facturacion'];
		$url_img_upload           = $result_documentos['url_img_upload'];
		$email_emisor                = $result_documentos['email'];
		$celular                = $result_documentos['celular'];
		$telefono                = $result_documentos['telefono'];
		$direccion                = $result_documentos['direccion'];
		$nombre_empresa                = $result_documentos['nombre_empresa'];
		$razon_social                = $result_documentos['razon_social'];
		$numero_identidad               = $result_documentos['numero_identidad'];

		$punto_emision_f         = $result_documentos['punto_emision_f'];
		$estableciminento_f      = $result_documentos['estableciminento_f'];
		//codigo para saber como va el emisor
		if (empty($nombre_empresa) || $nombre_empresa == '0') {
			$nombre_salida = $razon_social;
		}else {
			$nombre_salida = $nombre_empresa;
		}

		//redes

		$facebook                = $result_documentos['facebook'];
		$instagram           = $result_documentos['instagram'];
		$whatsapp             = $result_documentos['whatsapp'];



		if (!empty($facebook)) {
			$facebook = '<a style="text-align: center; margin:3px; padding4px;" href="'.$facebook.'"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="30px;"></a>';
		}else {
			$facebook = '';
		}

		if (!empty($instagram)) {
			$instagram = '<a style="text-align: center; margin:3px; padding4px;" href="'.$instagram.'"> <img src="https://guibis.com/home/img/reacciones/instagram.png" alt="" width="30px;"></a>';
		}else {
			$instagram = '';
		}

		if (!empty($whatsapp)) {
			$whatsapp = '<a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;'.$nombre_salida.'&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="30px;"></a>';
		}else {
			$whatsapp = '';
		}


		$host_envio                 = $result_documentos['host_envio'];
		$puerto_email_envio         = $result_documentos['puerto_email_envio'];
		$email_user_name_envio      = $result_documentos['email_user_name_envio'];
		$password_envio_email       = $result_documentos['password_envio_email'];
		$descripcion_envio_email    = $result_documentos['descripcion_envio_email'];


		if (empty($host_envio)) {
			$host_envio = 'mail.guibis.com';
		}
		if (empty($puerto_email_envio)) {
			$puerto_email_envio = '465';
		}
		if (empty($password_envio_email)) {
			$password_envio_email = 'MACAra666_';
		}
		if (empty($email_user_name_envio)) {
			$email_user_name_envio = 'prueba_registro@guibis.com';
		}
		if (empty($descripcion_envio_email)) {
			$descripcion_envio_email = '';
		}

		//fechas
		$fecha_actual = date("d-m-Y");
		$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));



	 $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
	 $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
	 $secuencial           = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
			$query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(((comprobantes.cantidad_producto))) AS 'productos_totales'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser' AND secuencial = '$codigo_factura'");
      $data_lista_t=mysqli_fetch_array($query_lista_t);
      $precio_12_iva = round(($data_lista_t['iva_general']),2);
      $precio_88_iva = round(($data_lista_t['compra_total']),2);
      $precio_total  = round( $precio_12_iva+$precio_88_iva,2);
			$productos_totales = $data_lista_t['productos_totales'];
			$fecha_actual = date("d-m-Y");
			$fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));

			$clave_acc_guardar = $fechasf.$punto_emision_f.$estableciminento_f.$numero_identidad.$secuencial;

			$numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;


	    $fecha_actual = date("d-m-Y h:m:s");
			$fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));

			$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
				WHERE id_emisor= '$iduser'");
				$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
				$id_receptor = $data__emmisor['id_receptor'];
				$nombres_receptor   = $data__emmisor['nombres_receptor'];
				$precio_neto        = $data__emmisor['precio_neto'];
				$descripcion        = $data__emmisor['descripcion_producto'];
				$direccion_receptor = $data__emmisor['direccion_reeptor'];
				$celular_receptor   = $data__emmisor['celular_receptor'];
				$email_receptor     = $data__emmisor['email_reeptor'];
				$numero_identidad_receptor = $data__emmisor['numero_identidad_receptor'];
				$tipo_identificacion = $data__emmisor['tipo_identificacion'];
				$efectivo = $data__emmisor['efectivo'];
				$vuelto = $data__emmisor['vuelto'];


			require('clasepdf.php');
					$pdf = new TICKET('P','mm',array(76,297));
					$pdf->AddPage();
					$pdf->SetFont('Arial', '', 12);
					$pdf->SetAutoPageBreak(true,1);
					$pdf->setXY(2,1.5);

					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);
					$pdf->setXY(2,10);
					$pdf->SetFont('Arial', '', 6.9);
					$pdf->MultiCell(73, 4.2, utf8_decode(''.$direccion.''), 0,'C',0 ,1);
					$get_YD = $pdf->GetY();
					$pdf->setXY(2,6);
					$pdf->SetFont('Arial', '', 8);
					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);
					$pdf->setXY(2,$get_YD);
					$pdf->MultiCell(73, 4.2, 'RUC : '.$numero_identidad.'', 0,'C',0 ,1);



			    /*INGRESAR EN ESTA LINEA EL TELEFONO DEL TICKET*/

			    $pdf->setXY(2,$get_YD + 4);
			    $pdf->MultiCell(73, 4.2, 'Telefono :'.$celular.' ', 0,'C',0 ,1);
			    $pdf->setXY(2,$get_YD + 8);
			    $pdf->MultiCell(73, 4.2, 'Serie : '.$punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial.'', 0,'C',0 ,1);
			    $get_YH = $pdf->GetY();

									$pdf->SetFont('Arial', '', 9.2);
									$pdf->Text(2, $get_YH + 2 , '------------------------------------------------------------------');
									$pdf->SetFont('Arial', 'B', 8.5);
									$pdf->Text(3.8, $get_YH  + 5, 'Factura : '.$secuencial.'');
									$pdf->Text(55, $get_YH + 5, 'Caja No.: 1');
									$pdf->Text(4, $get_YH + 10, 'Fecha : '.$fecha_emision.'');
									$pdf->Text(4, $get_YH + 15, 'Cliente : '.$nombres_receptor.'');
									$pdf->Text(4, $get_YH + 20, 'No. Ticket :'.$secuencial.' ');
									$pdf->Text(38, $get_YH  + 20, 'Cajero : '.substr(1, 0,5));
									$pdf->SetFont('Arial', '', 9.2);
									$pdf->Text(2, $get_YH + 23, '------------------------------------------------------------------');
									$pdf->SetXY(2,$get_YH + 24);
					        		$pdf->SetFillColor(255,255,255);
					        		$pdf->SetFont('Arial','B',8.5);
					        		$pdf->Cell(13,4,'Cantid',0,0,'L',1);
					        		$pdf->Cell(28,4,'Descripcion',0,0,'L',1);
					        		$pdf->Cell(16,4,'Precio',0,0,'L',1);
					        		$pdf->Cell(12,4,'Total',0,0,'L',1);
					        		$pdf->SetFont('Arial','',8.5);
					        		$pdf->Text(2, $get_YH + 29, '-----------------------------------------------------------------------');
									$pdf->Ln(6);
									$item = 0;
									$query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
										WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura'");
								 while ($resultados = mysqli_fetch_array($query_resultados)) {
									 $item = $item + 1;
										$pdf->setX(1.1);
										$pdf->Cell(13,4,$resultados['cantidad_producto'],0,0,'L');
										$pdf->Cell(28,4,$resultados['descripcion_producto'],0,0,'L',1);
										$pdf->Cell(16,4,'$'.round($resultados['valor_unidad'],3),0,0,'L',1);
										$pdf->Cell(8,4,'$'.round($resultados['precio_neto'],3),0,0,'L',1);
										$pdf->Ln(4.5);
										$get_Y = $pdf->GetY();

									}


									$pdf->Text(2, $get_Y+1, '-----------------------------------------------------------------------');
									$pdf->SetFont('Arial','B',8.5);
									$pdf->Text(4,$get_Y + 5,'G = GRAVADO');
									$pdf->Text(30,$get_Y + 5,'E = EXENTO');
									$pdf->Text(4,$get_Y + 10,'SUBTOTAL :');
									$pdf->Text(57,$get_Y + 10,'$'.round($precio_88_iva,3));
									$pdf->Text(4,$get_Y + 15,'EXENTO :');
									$pdf->Text(57,$get_Y + 15,'$0.00');
									$pdf->Text(4,$get_Y + 20,'IVA 12% :');
									$pdf->Text(57,$get_Y + 20,'$'.round($precio_12_iva,3));
									$pdf->Text(4,$get_Y + 25,'DESCUENTO :');
									$pdf->Text(56,$get_Y + 25,'$0.00');
									$pdf->Text(4,$get_Y + 30,'TOTAL A PAGAR :');
									$pdf->SetFont('Arial','B',8.5);
									$pdf->Text(57,$get_Y + 30,'$'.round($precio_total,3));
									$pdf->Text(2, $get_Y+33, '-----------------------------------------------------------------------');
									$pdf->Text(4,$get_Y + 36,'Numero de Productos :');
									$pdf->Text(57,$get_Y + 36,'#'.round($productos_totales,3).'');
									$pdf->Text(24,$get_Y + 40,'Efectivo :');
									$pdf->Text(57,$get_Y + 40,'$'.round($efectivo,3).'');
									$pdf->Text(24,$get_Y + 44,'Cambio :');
									$pdf->Text(57,$get_Y + 44,'$'.round($vuelto,3).'');
									$pdf->Text(2, $get_Y+47, '-----------------------------------------------------------------------');
									$pdf->SetFont('Arial','BI',8.5);
						$pdf->Output('../comprobantes/tikets/'.$clave_acc_guardar.'.pdf','F');

					$nuevo_xml = ''.$clave_acc_guardar.'.xml';
					$tiket_pdf = ''.$clave_acc_guardar.'.pdf';


					date_default_timezone_set("America/Lima");
					$fecha_actual = date('d-m-Y H:m:s', time());





						$query_insert=mysqli_query($conection,"INSERT INTO tikets(codigo_factura,id_emisor,id_receptor,nombres_receptor,
							cedula_receptor,email_receptor,precio_neto,descripcion,direccion_receptor,celular_receptor,clave_acceso,tipo_identificacion,subtotal,iva,total,url,secuencia,IDROLPUNTOVENTA,rol)
						VALUES('$secuencial','$iduser','$id_receptor','$nombres_receptor','$numero_identidad_receptor',
							'$email_receptor','$precio_neto','$descripcion','$direccion_receptor','$celular_receptor','$clave_acc_guardar','$tipo_identificacion','$precio_88_iva','$precio_12_iva','$precio_total','$url2','$codigo_factura_comprobantes','$id_generacion','$rol_user') ");

						//$query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id_emisor = '$iduser' AND secuencial = '$codigo_factura' ");
						try{

						$filep = '../comprobantes/tikets/'.$clave_acc_guardar.'.pdf';

						// Creamos una nueva instancia
						$mail = new PHPMailer();
						// Activamos el servicio SMTP
						$mail->isSMTP();
				    // Activamos / Desactivamos el "debug" de SMTP (Lo activo para ver en el HTML el resultado)
				    // 0 = Apagado, 1 = Mensaje de Cliente, 2 = Mensaje de Cliente y Servidor
				    $mail->SMTPDebug = 0;
				    // Log del debug SMTP en formato HTML
				    $mail->Debugoutput = 'html';
						// Servidor SMTP (para este ejemplo utilizamos gmail)
				    $mail->Host = $host_envio;
				    // Puerto SMTP
				    $mail->Port = $puerto_email_envio ;
				    // Tipo de encriptacion SSL ya no se utiliza se recomienda TSL
				    $mail->SMTPSecure = 'ssl';
				    // Si necesitamos autentificarnos
				    $mail->SMTPAuth = true;
				    // Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com)
				    $mail->Username = $email_user_name_envio;
				    // Contraseña
				    $mail->Password = $password_envio_email;

						$mail -> setFrom ( $email_user_name_envio , 'Sistema de Facturación' );
				    $mail->addAddress('factura@facturacion.guibis.com');
						$mail->addAddress($email_receptor);
						$mail->addAddress($email_emisor);


						$query_lista = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email
							 WHERE lista_correos_envios_email.iduser ='$iduser'  AND lista_correos_envios_email.estatus = '1'
						ORDER BY `lista_correos_envios_email`.`fecha` DESC ");
						 $result_lista= mysqli_num_rows($query_lista);
						if ($result_lista > 0) {
									while ($data_lista=mysqli_fetch_array($query_lista)) {
										$mail->addAddress($data_lista['correo']);
									}
							}

							//CODIGO PARA SACAR LOS EMAIL DEL CLIENTE
							$query__correos_email = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email_cliente
								 WHERE lista_correos_envios_email_cliente.iduser ='$iduser'  AND lista_correos_envios_email_cliente.estatus = '1' AND lista_correos_envios_email_cliente.cliente = '$id_receptor'
							ORDER BY `lista_correos_envios_email_cliente`.`fecha` DESC ");
							 $result__email= mysqli_num_rows($query__correos_email);
							if ($result__email > 0) {
										while ($data_email=mysqli_fetch_array($query__correos_email)) {
											$mail->addAddress($data_email['correo']);
										}
									}





						$mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
						$mail->CharSet = 'UTF-8';
						$mail->Subject = 'Tiket de Venta';
						//Creamos el mensaje
						$message =
				 '
				 <body>


		 			<div class="conte_general" style="text-align: center;background: #f5f5f5;border-radius: 10px;">
		 				<div class="contenedor_image">
		 					<img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" width="150px;" alt="">
		 				</div>
		 				<div class="redes_email" style="text-align: center;">
		 				'.$facebook.'
		 				'.$instagram.'
		 				'.$whatsapp.'

		 		</div>
		 		<div style="margin: 0; padding: 0;">
		 				<p style="margin: 5px 0;">'.$direccion.'</p>
		 		</div>
		 		<div style="margin: 0; padding: 0;">
		 			<strong><p style="margin: 5px 0;">'.$celular.' '.$telefono.'</p></strong>

		 		</div>

		 				<div class="contenedor_informacion_factura">
		 					<table style="margin: 0 auto;width: 80%;">
		 						<tr>
		 							<td></td>
		 							<td><hr></td>
		 						</tr>
		 						<tr>
		 							<td> <strong>DESTINATARIO:</strong> </td>
		 							<td>
		 								<div style="margin: 0; padding: 0;">
		 							<strong style="display: block; margin: 5px 0;background: #d8d6d5;">'.$nombres_receptor.'</strong>
		 								</div>
		 							<div style="margin: 0; padding: 0;">
		 									<p style="margin: 5px 0;font-size: 12px;">Has recibido un Tiket de Venta de:</p>
		 							</div>
		 							</td>
		 						</tr>
		 						<tr>
		 							<td> <strong>EMISOR</strong> </td>
		 							<td style="background: #d8d6d5;"> <strong>'.$nombre_salida.'</strong> </td>
		 						</tr>
		 						<tr>
		 							<td>  </td>
		 							<td> <hr>  </td>
		 						</tr>
		 						<tr>
		 							<td> <strong>FACTURA:</strong> </td>
		 							<td> '.$numDocModificado.' </td>
		 						</tr>
		 						<tr>
		 							<td> <strong>FECHA EMISION:</strong> </td>
		 							<td>'.$fecha_actual.'</td>
		 						</tr>

		 						<tr>
		 							<td> <strong>VALOR:</strong> </td>
		 							<td>Por el Valor de</td>
		 						</tr>
		 						<tr>
		 							<td></td>
		 							<td style="font-size: 25px;background: #d8d6d5;"> <strong>$'.$precio_total.'</strong> </td>
		 						</tr>
		 						<tr>
		 							<td>  </td>
		 							<td> <hr>  </td>
		 						</tr>
		 						<tr>
		 							<td> </td>
		 							<td style="font-size: 10px;">'.$descripcion_envio_email.'</td>
		 						</tr>
		 						<tr>
		 							<td> </td>
		 							<td style="font-size: 10px;">Descarga tus documentos electrónicos en el siguiente  <a href="https://guibis.com/mis_facturas">Enlace</a> </td>
		 						</tr>
		 					</table>
		 				</div>
		 			</div>
		 		</body>

								';
						//Agregamos el mensaje al correo
						$mail->msgHTML($message);
						// Enviamos el Mensaje
						if (!$mail->send()) {

						} else {

						 }
						}catch(Exception $e){}

					 $arrayName = array('noticia' =>'insert_correct','clave_acc_guardar'=>$clave_acc_guardar);
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);







	}
}

?>
