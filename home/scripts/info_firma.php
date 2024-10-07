<?php
session_start();
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8');

$user_in= $_SESSION['user_in'];
echo "Preparando para la insersion de datos de usuario $user_in <br>";

$query_lista = mysqli_query($conection," SELECT *
   FROM usuarios
  WHERE  user_in = '279'
ORDER BY `usuarios`.`id` desc");
    $result_lista= mysqli_num_rows($query_lista);
  if ($result_lista > 0) {
        while ($data_lista=mysqli_fetch_array($query_lista)) {
          $clave            =$data_lista['codigo_sri'];
          $firma_electronica     =$data_lista['firma_electronica'];
          $url_firma_electronica =$data_lista['url_firma_electronica'];
          $iduser =$data_lista['id'];
          $url_sistema_analisis = 'http://localhost';
          $firma = ''.$url_sistema_analisis.'/home/facturacion/facturacionphp/controladores/firmas_electronicas/'.$firma_electronica;
            if (!file_exists($firma)) {
              $almacen_cert = file_get_contents($firma);

              if (openssl_pkcs12_read($almacen_cert, $info_cert, $clave)) {
                // Asumiendo que $info_cert es tu array que contiene la información del certificado
                $certificado = openssl_x509_read($info_cert["cert"]);
                $detalles = openssl_x509_parse($certificado);
                // Fecha de caducidad del certificado
                $fechaCaducidad = $detalles['validTo_time_t'];
                // Convertir la fecha de caducidad a un formato legible
                $fechaCaducidadLegible = date('Y-m-d H:i:s', $fechaCaducidad);

                  // Obtener la fecha y hora actual
                  $fechaActual = date('Y-m-d H:i:s');

                  // Comparar las fechas
                  if (strtotime($fechaCaducidadLegible) > strtotime($fechaActual)) {
                     $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

                    $query_edit = mysqli_query($conection,"UPDATE usuarios SET fecha_caducidad_firma='$fechaCaducidadLegible',url_firma_electronica='$url_sistema_analisis' WHERE id='$iduser' ");
                      if ($query_edit) {
                          $arrayName = array('noticia'=>'insert_correct','fecha_caducidad'=>$fechaCaducidadLegible);
                          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                        }else {
                          $arrayName = array('noticia' =>'error_insertar');
                         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        }

                  } else {

                    $arrayName = array('noticia' => 'firma_caducada');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                  }

               }else {
                 echo "Error en credenciales de firmas";
               }

            }else {
              echo "no existe esta firma ";
              // code...
            }


        }
    }






 ?>
