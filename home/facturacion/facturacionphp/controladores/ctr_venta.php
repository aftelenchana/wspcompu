<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

  $contenido_colateral_rt = $_POST['action'];
  $codigo_factura_SC = $_POST['codigo_factura'];

 $query_consultor = mysqli_query($conection,"SELECT * FROM comprobantes
   WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_SC' ");
   $result_consultor=mysqli_fetch_array($query_consultor);
   if ($result_consultor) {
     include 'ctr_xml.php';
     include 'ctr_firmarxml.php';
     $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
     $result_documentos = mysqli_fetch_array($query_doccumentos);
     $documentos_electronicos = $result_documentos['documentos_electronicos'];
     $nombre_empresa          = $result_documentos['nombre_empresa'];
     $email_emisor            = $result_documentos['email'];
     $estableciminento_f      = $result_documentos['estableciminento_f'];
     $contabilidad            = $result_documentos['contabilidad'];
     $punto_emision_f         = $result_documentos['punto_emision_f'];
     $numero_identidad_emisor = $result_documentos['numero_identidad'];
     $direccion_emisor        = $result_documentos['direccion'];
     $img_logo                = $result_documentos['img_facturacion'];


    if (empty($result_documentos['numero_identidad'])) {
      $arrayName = array('noticia'=>'cedula_vacia');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;
     }


     $query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
     WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_SC' ORDER BY comprobantes.fecha DESC");
     $data__emmisor=mysqli_fetch_array($query_resultados_emmisor);

     $id_receptor       					 	 = $data__emmisor['id_receptor'];
     $sucursal_facturacion_code     = $data__emmisor['sucursal_facturacion'];

     //codigo para sacar la informacion de la sucursal que se esta ocupando



     $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion_code'");
     $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

     $direccion_sucursal        = $data_sucursal['direccion_sucursal'];

     $estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
     $punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);

     $fecha_actual = date("d-m-Y");
     $fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));


     //codigo para sacar la secuencia del usuario

     $establecimiento_sinceros        = $data_sucursal['establecimiento'];
     $punto_emision_sinceros        = $data_sucursal['punto_emision'];

     $query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.punto_emision ='$punto_emision_sinceros'
       AND comprobante_factura_final.establecimiento ='$establecimiento_sinceros' ORDER BY id DESC");
      $result_secuencia = mysqli_fetch_array($query_secuencia);
      if ($result_secuencia) {
        $secuencial = $result_secuencia['codigo_factura'];
        $secuencial = $secuencial +1;
        // code...
      }else {
        $secuencial =1;
      }
      $secuencial_conceros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);

      $secuencial_verificacion = $estableciminento_f.'-'.$punto_emision_f.'-'.$secuencial_conceros;


      $query_verificacion = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.secuencia  = '$secuencial_verificacion' AND comprobante_factura_final.id_emisor ='$iduser'");
      $result_verificacion = mysqli_num_rows($query_verificacion);
      if ($result_verificacion > 0) {
        $query_insert=mysqli_query($conection,"INSERT INTO comprobante_factura_final(codigo_factura,codigo_interno_factura,id_emisor,establecimiento,punto_emision,sucursal_facturacion)
        VALUES('$secuencial','00000000','$iduser','$establecimiento_sinceros','$punto_emision_sinceros','$sucursal_facturacion_code') ");



          if ($query_insert) {
            $arrayName = array('noticia'=>'secuencial_registrada_corregida','secuencial'=>$secuencial_verificacion);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }else {
            $arrayName = array('noticia'=>'secuencial_registrada_error_base_datos','secuencial'=>$secuencial_verificacion);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
          exit;
        // code...
      }







     $xmlf=new xml();
     $xmlf->xmlFactura($codigo_factura_SC,$iduser,$contenido_colateral_rt);

     $xmla=new autorizar();
     $xmla->autorizar_xml($codigo_factura_SC,$iduser,$contenido_colateral_rt);

     // code...
   }else {
     $arrayName = array('noticia'=>'no_existe_registros');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         exit;
   }





?>
