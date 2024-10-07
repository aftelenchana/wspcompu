<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

    $metodo = $_GET['metodo'];
    if ($metodo == 'fecha') {

      $busqueda = $_GET['busqueda'];
      $partesFechas = explode(' - ', $busqueda);
      $fecha1 = $partesFechas[0];
      $fecha2 = $partesFechas[1];




      $query_lista = mysqli_query($conection,"SELECT * FROM `comprobante_factura_final`
  WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000'
  BETWEEN '$fecha1' AND '$fecha2'
  GROUP BY comprobante_factura_final.codigo_factura
  ORDER BY `comprobante_factura_final`.`fecha` DESC");
          $result_lista= mysqli_num_rows($query_lista);
        if ($result_lista > 0) {
          // Crear un archivo ZIP para guardar los archivos descargados
          $zip = new ZipArchive();
          $nombre_zip = 'archivos_descargados.zip';

           if ($zip->open($nombre_zip, ZipArchive::CREATE) === TRUE) {
            // code...

            while ($data_lista=mysqli_fetch_array($query_lista)) {
              $nombre_xml= $data_lista['clave_acceso'].'.xml';
              $nombre_archivo = $data_lista['clave_acceso'];
                $ruta_archivo = '../facturacion/facturacionphp/comprobantes/autorizados/'. $nombre_archivo.'.xml'; // Cambiar la ruta según tu configuración del servidor
                      $ruta_pdf = '../facturacion/facturacionphp/comprobantes/pdf/'.$nombre_archivo.'.pdf'; // Cambiar la ruta según tu configuración del servidor
                if (file_exists($ruta_archivo)) {
                    $zip->addFile($ruta_archivo, $nombre_xml);
                }else {
                  echo "no se encontro el archivo";
                }

                $nombre_pdf = $data_lista['clave_acceso'].'.pdf';
                if (file_exists($ruta_pdf)) {
                    $zip->addFile($ruta_pdf, $nombre_pdf);
                } else {
                    echo "No se encontró el archivo PDF";
                }

            }

    
               $zip->close();

               // Descargar el archivo ZIP
          header('Content-Type: application/zip');
          header('Content-Disposition: attachment; filename="' . basename($nombre_zip) . '"');
          header('Content-Length: ' . filesize($nombre_zip));
          readfile($nombre_zip);

          // Eliminar el archivo ZIP del servidor
          unlink($nombre_zip);
        }else {
          echo "no se pudo crear el archivo zip";
        }

      }else {
        echo "no existen archivos entre estas fechas";
      }

    }


    if ($metodo == 'global') {

      $busqueda = $_GET['busqueda'];
      $query_lista = mysqli_query($conection,"SELECT *   FROM comprobante_factura_final
        WHERE (comprobante_factura_final.fecha like '%$busqueda%'
          OR comprobante_factura_final.codigo_factura like '%$busqueda%' OR comprobante_factura_final.nombres_receptor like '%$busqueda%'
          OR comprobante_factura_final.cedula_receptor like '%$busqueda%' OR comprobante_factura_final.email_receptor like '%$busqueda%' OR comprobante_factura_final.clave_acceso LIKE '%$busqueda%') AND  comprobante_factura_final.id_emisor = '$iduser'
          AND comprobante_factura_final.codigo_interno_factura != '00000000'
          AND comprobante = 'factura'");
          $result_lista= mysqli_num_rows($query_lista);
        if ($result_lista > 0) {
          // Crear un archivo ZIP para guardar los archivos descargados
          $zip = new ZipArchive();
          $nombre_zip = 'archivos_descargados.zip';

           if ($zip->open($nombre_zip, ZipArchive::CREATE) === TRUE) {
            // code...

              while ($data_lista=mysqli_fetch_array($query_lista)) {
                $nombre_xml= $data_lista['clave_acceso'].'.xml';
                $nombre_archivo = $data_lista['clave_acceso'];
                  $ruta_archivo = '../facturacion/facturacionphp/comprobantes/autorizados/' . $nombre_archivo.'.xml'; // Cambiar la ruta según tu configuración del servidor
                        $ruta_pdf = '../facturacion/facturacionphp/comprobantes/pdf/'.$nombre_archivo.'.pdf'; // Cambiar la ruta según tu configuración del servidor
                  if (file_exists($ruta_archivo)) {
                      $zip->addFile($ruta_archivo, $nombre_xml);
                  }else {
                    echo "no se encontro el archivo";
                  }

                  $nombre_pdf = $data_lista['clave_acceso'].'.pdf';

                  if (file_exists($ruta_pdf)) {
                      $zip->addFile($ruta_pdf, $nombre_pdf);
                  } else {
                      echo "No se encontró el archivo PDF";
                  }

              }


               $zip->close();

               // Descargar el archivo ZIP
          header('Content-Type: application/zip');
          header('Content-Disposition: attachment; filename="' . basename($nombre_zip) . '"');
          header('Content-Length: ' . filesize($nombre_zip));
          readfile($nombre_zip);

          // Eliminar el archivo ZIP del servidor
          unlink($nombre_zip);
        }else {
          echo "no se pudo crear el archivo zip";
        }

      }else {
        echo "no existen archivos entre estas fechas";
      }

    }




 ?>
