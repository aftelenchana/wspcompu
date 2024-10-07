<?php
include "../../coneccion.php";
session_start();

mysqli_set_charset($conection, 'utf8'); //linea a colocar

$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres_usuario = $result['nombres'];
$apellidos_usuario = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];

          $query_lista = mysqli_query($conection,"SELECT * FROM `xml_subidos_masivos` WHERE xml_subidos_masivos.id_user  = '$iduser'  AND estado != 'AUTORIZADO' AND vista != '0'");
          $result_lista= mysqli_num_rows($query_lista);
             if ($result_lista > 0) {
               $cantidad = 1;
              while ($data_lista=mysqli_fetch_array($query_lista)) {
                	$ruta_no_firmados = 'C:\\xampp\\htdocs\\home\\archivos\\xml_nofirmados\\'.$data_lista['nombre'].'';
                  $acceso_no_firmados = simplexml_load_file($ruta_no_firmados);

                  //var_dump((string)$acceso_no_firmados->infoFactura->pagos->pago->formaPago);

                  $gtr = 01;

                  //var_dump((string)$acceso_no_firmados->infoAdicional->campoAdicional->attributes()->nombre);

                  //var_dump($acceso_no_firmados->infoAdicional->campoAdicional->atributo->value = 'email');

                  //var_dump((string)$acceso_no_firmados->infoAdicional->campoAdicional[0]);
                  $rrr= ($acceso_no_firmados->infoAdicional->campoAdicional);
                  foreach($rrr as $Item){
                    $atrinuto = (string)$acceso_no_firmados->infoAdicional->campoAdicional[0];
                    $posicion_coincidencia = strpos($atrinuto, '@');
                    if ($posicion_coincidencia === false) {

                    } else {
                    $email_receptor =$atrinuto;
                    }
                    }
                  $id_xml = $data_lista['id'];

                  $ruc             = substr($acceso_no_firmados->infoTributaria->ruc, 0, 13);
                  strlen($ruc);
                  $claveAcceso     = ($acceso_no_firmados->infoTributaria->claveAcceso);
                  strlen($claveAcceso);
                  $estab           = ($acceso_no_firmados->infoTributaria->estab);
                  $nombreComercial           = ($acceso_no_firmados->infoTributaria->nombreComercial);


                  $fechaEmision    = ($acceso_no_firmados->infoFactura->fechaEmision);
                  $dirEstablecimiento    = ($acceso_no_firmados->infoFactura->dirEstablecimiento);

                  $secuencial      = substr($acceso_no_firmados->infoTributaria->secuencial, 0, 13);
                  $totalSinImpuestos = ($acceso_no_firmados->infoFactura->totalSinImpuestos);
                  $importeTotal    = ($acceso_no_firmados->infoFactura->importeTotal);
                  //infofactura
                    $obligadoContabilidad    = $acceso_no_firmados->infoFactura->obligadoContabilidad;
                    $codDoc                  = $acceso_no_firmados->infoFactura->codDoc;
                    $estab                   = $acceso_no_firmados->infoFactura->estab;
                    $razonSocialComprador    = $acceso_no_firmados->infoFactura->razonSocialComprador;
                    $identificacionComprador = $acceso_no_firmados->infoFactura->identificacionComprador;




                  $query_lista_verificador = mysqli_query($conection,"SELECT * FROM `xml_subidos_masivos` WHERE xml_subidos_masivos.claveAcceso  = '$claveAcceso'");
                  $result_lista_verificador= mysqli_fetch_array($query_lista_verificador);
                  $clave_acceso_existente  = $result_lista_verificador['claveAcceso'];



                  if (empty($claveAcceso) || empty($fechaEmision)  || empty($ruc)) {
                    $estado_envio ='NO APROBADO';
                    $mensaje = 'Campos Vacios';
                  }else {
                    $estado_envio ='APROBADO';
                    $mensaje = 'NINGUNA';
                  }
                  echo "$cantidad ";


                  if ($cantidad == 1) {
                    // code...
                  }else {
                    $query_lista_verificador = mysqli_query($conection,"SELECT * FROM `xml_subidos_masivos` WHERE xml_subidos_masivos.claveAcceso  = '$claveAcceso'");
                    $result_lista_verificador= mysqli_fetch_array($query_lista_verificador);
                    $clave_acceso_existente  = $result_lista_verificador['claveAcceso'];
                    if ($clave_acceso_existente==$claveAcceso) {
                      $estado_envio ='NO APROBADO';
                        $mensaje = 'Revisar Campos y claves repetidas';
                    }else {
                      $estado_envio ='APROBADO';
                      $mensaje = 'NINGUNA';
                    }
                  }



                 $query_procesar_xml = mysqli_query($conection,"UPDATE xml_subidos_masivos SET ruc='$ruc',nombreComercial='$nombreComercial',claveAcceso='$claveAcceso',
                   estab='$estab', fechaEmision='$fechaEmision',secuencial='$secuencial',totalSinImpuestos='$totalSinImpuestos',importeTotal='$importeTotal',email_receptor='$email_receptor',
                   estado_envio='$estado_envio',mensaje_proceso='$mensaje',formaPago='$gtr',dirEstablecimiento='$dirEstablecimiento',
                   obligadoContabilidad='$obligadoContabilidad',codDoc='$codDoc',razonSocialComprador='$razonSocialComprador',identificacionComprador='$identificacionComprador'
                   WHERE id = '$id_xml'");
                     $cantidad = $cantidad+1;

               }

                  if ($query_procesar_xml) {
                    $arrayName = array('noticia' =>'insert_correct');
                                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                    // code...
                              }else {
                    $arrayName = array('noticia' =>'error');
                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }



             }else {
               $arrayName = array('noticia' =>'vacio_consola');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }






 ?>
