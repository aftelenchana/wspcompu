<?php
require('../fpdf/clasepdf.php');

session_start();
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar

$mesa  = $_GET['mesa'];

   $iduser= $_SESSION['id'];

$query_raiz = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$iduser");
$data_raiz  =mysqli_fetch_array($query_raiz);
$nombres_raiz           = $data_raiz['nombres'];
$firma_electronica_raiz = $data_raiz['firma_electronica'];
$direccion_raiz         = $data_raiz['direccion'];
$codigo_sri_raiz        = $data_raiz['codigo_sri'];
$estableciminento_raiz  = $data_raiz['estableciminento_f'];
$punto_emision_raiz     = $data_raiz['punto_emision_f'];
$porcentaje_iva_raiz    = $data_raiz['porcentaje_iva_f'];
$apellidos_raiz         = $data_raiz['apellidos'];
$img_facturacion          = $data_raiz['img_facturacion'];
$nombre_empresa_raiz    = $data_raiz['nombre_empresa'];
$numero_identidad_raiz = $data_raiz['numero_identidad'];
$celular_raiz          = $data_raiz['celular'];
$url_img_upload        = $data_raiz['url_img_upload'];

$query_lista_t = mysqli_query($conection,"SELECT SUM(((tomar_pedidos_cafe_tech.cantidad_producto)*(tomar_pedidos_cafe_tech.valor_unidad))) as
  'compra_total', SUM(((tomar_pedidos_cafe_tech.iva_producto))) AS 'iva_general',
  SUM(((tomar_pedidos_cafe_tech.precio_neto)+(tomar_pedidos_cafe_tech.iva_producto))) AS 'precioncluido_iva',SUM(((tomar_pedidos_cafe_tech.cantidad_producto))) AS 'productos_totales'
  FROM `tomar_pedidos_cafe_tech`
  WHERE tomar_pedidos_cafe_tech.id_emisor = '$iduser' AND tomar_pedidos_cafe_tech.codigo_mesa = '$mesa'");
  $data_lista_t=mysqli_fetch_array($query_lista_t);
  $precio_12_iva = round(($data_lista_t['iva_general']),2);
  $precio_88_iva = round(($data_lista_t['compra_total']),2);
  $precio_total  = round( $precio_12_iva+$precio_88_iva,2);
  $productos_totales = $data_lista_t['productos_totales'];
  $fecha_actual = date("d-m-Y");
  $fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));
  $anchoImagen = 40; // Ancho de la imagen en milímetros
$altoImagen = 30; // Alto de la imagen en milímetros
  $pdf = new TICKET('P','mm',array(76,297));
					$pdf->AddPage();
					$pdf->SetFont('Times', '', 12);
					$pdf->SetAutoPageBreak(true,1);
					$pdf->setXY(2,1.5);

          $extension = pathinfo($img_facturacion, PATHINFO_EXTENSION);

          //echo "$extension";

                      // Agregar imagen de cabecera
            $pdf->Image('../img/uploads/'.$img_facturacion.'', 20, 10, $anchoImagen, $altoImagen, $extension);

            // Ajustar la posición para el contenido posterior
            $pdf->SetY($altoImagen + 20);
					$pdf->setXY(20,10);


					$get_YD = $pdf->GetY();
					$pdf->setXY(4,5);
					$pdf->SetFont('Times', 'B', 10);
					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa_raiz).'', 0,'C',0 ,1);


			    /*INGRESAR EN ESTA LINEA EL TELEFONO DEL TICKET*/
         $pdf->SetFont('Times', '', 8);
			    $pdf->setXY(2,$get_YD+$altoImagen);
			    $pdf->MultiCell(73, 4.2, ''.utf8_decode('Teléfono').'  :'.$celular_raiz.' ', 0,'C',0 ,1);
			    $pdf->setXY(2,$get_YD + $altoImagen+3);
			    $pdf->MultiCell(73, 4.2, 'RUC :'.$numero_identidad_raiz.' ', 0,'C',0 ,1);
          $pdf->setXY(2,$get_YD + $altoImagen+6);
          $pdf->MultiCell(73, 4.2, ' '.utf8_decode('Dirección').' :'.$direccion_raiz.' ', 0,'C',0 ,1);
			    $get_YH = $pdf->GetY();

									$pdf->SetFont('Times', '', 9.2);
									$pdf->Text(2, $get_YH + 2 , '------------------------------------------------------------------');
									$pdf->SetFont('Times', 'B', 8.5);
									$pdf->Text(3.8, $get_YH  + 5, 'Factura : Proceso');
									$pdf->Text(55, $get_YH + 5, 'Mesa:'.$mesa.'');
									$pdf->Text(4, $get_YH + 10, 'Fecha : '.$fecha_actual.'');
									$pdf->Text(4, $get_YH + 15, 'Cliente : Proceso');
									$pdf->Text(4, $get_YH + 20, 'No. Ticket Proceso ');
									$pdf->Text(38, $get_YH  + 20, 'Cajero : '.substr(1, 0,5));
									$pdf->SetFont('Times', '', 9.2);
									$pdf->Text(2, $get_YH + 23, '------------------------------------------------------------------');
									$pdf->SetXY(2,$get_YH + 24);
					        		$pdf->SetFillColor(255,255,255);
					        		$pdf->SetFont('Times','B',8.5);
					        		$pdf->Cell(13,4,'Cantid',0,0,'L',1);
					        		$pdf->Cell(28,4,''.utf8_decode('Descripción').'',0,0,'L',1);
					        		$pdf->Cell(16,4,'Precio',0,0,'L',1);
					        		$pdf->Cell(12,4,'Total',0,0,'L',1);
					        		$pdf->SetFont('Times','',8.5);
					        		$pdf->Text(2, $get_YH + 29, '-----------------------------------------------------------------------');
									$pdf->Ln(6);
									$item = 0;
									$query_resultados = mysqli_query($conection,"SELECT * FROM tomar_pedidos_cafe_tech
										WHERE id_emisor= '$iduser' AND codigo_mesa = '$mesa'");
                    while ($resultados = mysqli_fetch_array($query_resultados)) {
                        $item = $item + 1;
                        $pdf->setX(1.1);
                        $pdf->Cell(13, 4, $resultados['cantidad_producto'], 0, 0, 'L');

                        // Calcular el espacio disponible para la descripción
                        $anchoDescripcion = 28;
                        $altoCelda = 4;
                        $xDescripcion = $pdf->GetX();
                        $yDescripcion = $pdf->GetY();

                        // Añadir la descripción con MultiCell
                        $pdf->MultiCell($anchoDescripcion, $altoCelda, $resultados['descripcion_producto'].'-'.$resultados['nota_extra'], 0, 'L');

                        // Calcular el nuevo Y después de la descripción
                        $nuevoY = max($pdf->GetY(), $yDescripcion + $altoCelda);

                        // Posicionar para los siguientes elementos
                        $pdf->setXY($xDescripcion + $anchoDescripcion, $yDescripcion);

                        $pdf->Cell(16, $nuevoY - $yDescripcion, '$' . round($resultados['valor_unidad'], 3), 0, 0, 'L');
                        $pdf->Cell(8, $nuevoY - $yDescripcion, '$' . round($resultados['precio_neto'], 3), 0, 0, 'L');

                        // Mover a la siguiente línea
                        $pdf->Ln($nuevoY - $yDescripcion);
                        $get_Y = $pdf->GetY();
                    }



									$pdf->Text(2, $get_Y+1, '-----------------------------------------------------------------------');
									$pdf->SetFont('Times','B',8.5);
									$pdf->Text(4,$get_Y + 5,'G = GRAVADO');
									$pdf->Text(30,$get_Y + 5,'E = EXENTO');
									$pdf->Text(4,$get_Y + 10,'SUBTOTAL :');
									$pdf->Text(57,$get_Y + 10,'$'.round($precio_88_iva,3));
									$pdf->Text(4,$get_Y + 15,'EXENTO :');
									$pdf->Text(57,$get_Y + 15,'$0.00');
									$pdf->Text(4,$get_Y + 20,'IVA 12% :');
									$pdf->Text(57,$get_Y + 20,'$'.round($precio_12_iva,3));
									$pdf->Text(4,$get_Y + 25,'DESCUENTO :');
									$pdf->Text(56,$get_Y + 25,' $0.00');
									$pdf->Text(4,$get_Y + 30,'TOTAL A PAGAR :');
									$pdf->SetFont('Times','B',8.5);
									$pdf->Text(57,$get_Y + 30,'$'.round($precio_total,3));
									$pdf->Text(2, $get_Y+33, '-----------------------------------------------------------------------');
									$pdf->Text(4,$get_Y + 36,'Productos :');
									$pdf->Text(57,$get_Y + 36,'#'.round($productos_totales,3).'');
									$pdf->Text(2, $get_Y+47, '-----------------------------------------------------------------------');
									$pdf->SetFont('Times','BI',8.5);
                  // Generar el contenido del PDF en memoria
                  ob_start();
                  $pdf->Output();
                  $pdfContent = ob_get_clean();

                  // Enviar el PDF al navegador como descarga sin guardarlo
                  header('Content-Type: application/pdf');
                  header('Content-Disposition: attachment; filename="nombre_del_archivo.pdf"');
                  header('Content-Length: ' . strlen($pdfContent));
                  echo $pdfContent;
                  exit();







 ?>
