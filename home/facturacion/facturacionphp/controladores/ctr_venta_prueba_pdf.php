<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
 $query_consultor = mysqli_query($conection,"SELECT * FROM comprobantes
   WHERE id_emisor= '$iduser'");
   $result_consultor=mysqli_fetch_array($query_consultor);
   if ($result_consultor) {
     include 'ctr_xml.php';
     include 'ctr_firmarxml_prueba_pdf.php';
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


     if (empty($result_documentos['img_facturacion'])) {
       $arrayName = array('noticia'=>'logo_vacio');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
     }else {
         $extension = pathinfo($img_logo, PATHINFO_EXTENSION);
         if ($extension == 'jfif') {
           $arrayName = array('noticia'=>'imagen_invalida');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            exit;
         }
     }
    if (empty($result_documentos['numero_identidad'])) {
      $arrayName = array('noticia'=>'cedula_vacia');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;
     }

        if (empty($result_documentos['nombre_empresa'])) {
          $arrayName = array('noticia'=>'nombre_vacio');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              exit;
         }

         if (empty($result_documentos['nombre_empresa'])) {
           $arrayName = array('noticia'=>'nombre_vacio');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               exit;
          }



     $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
     $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
     $porcentaje_iva_f     = ($result_documentos['porcentaje_iva_f'])/100;

     $direccion = $result_documentos['direccion'];

     $query_secuencial = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = $iduser ORDER BY fecha DESC LIMIT 1");
     $result_secuencial = mysqli_fetch_array($query_secuencial);
     if ($result_secuencial) {
       $secuencial = $result_secuencial['codigo_factura'];
       $secuencial = $secuencial +1;
       // code...
     }else {
       $secuencial =1;
     }
     $queryemisor = mysqli_query($conection, "SELECT * FROM usuarios  WHERE id = '$iduser'");
     $resulemisor = mysqli_fetch_array($queryemisor);

     $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
     'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
     SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva', SUM(((comprobantes.descuento))) AS 'descuento_general'
     FROM `comprobantes`
     WHERE comprobantes.id_emisor = '$iduser'");
     $data_lista_t=mysqli_fetch_array($query_lista_t);

     $precio_12_iva = round(($data_lista_t['iva_general']),2);
     $precio_88_iva = round(($data_lista_t['compra_total']),2);
     $precio_total  = round( $precio_12_iva+$precio_88_iva,2);



     $fecha_actual = date("d-m-Y");

     $fecha_actual = date("d-m-Y");
     $fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));

     $fecha_emision_factura2 = $fecha_actual = date("d-m-Y h:m:s");
     $fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));



     $fecha2      =date('dmY');
     $correo 	  =$resulemisor['email'];
     $numeroConCeros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
     $secuencial = $numeroConCeros;

     $codigo	    =$fecha2.$secuencial.$iduser;
     $cantidad   =1;
     $descripcion='Varios';
     $preciou    =$precio_88_iva;
     $descuento  =0.00;
     $preciot    =$precio_88_iva;
     $subtotal   =$precio_88_iva;
     $iva0 		=0.00;
     $iva12 		=$precio_12_iva ;
     $descuento  =0.00;
     $total 		=$precio_total ;




     $query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
     WHERE id_emisor= '$iduser'");
     $data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
     $id_receptor        = $data__emmisor['id_receptor'];
     $nombres_receptor   = $data__emmisor['nombres_receptor'];
     $precio_neto        = $data__emmisor['precio_neto'];
     $codigo_formas_pago = $data__emmisor['formas_pago'];
     $codigos_impuestos  = $data__emmisor['codigos_impuestos'];
     $tipo_ambiente = $data__emmisor['tipo_ambiente'];
     if ($data__emmisor['formas_pago'] =='') {
       $codigo_formas_pago   = 01;
     }
     if ($codigo_formas_pago == 01) {
       $nombre_formas_pago = 'SIN UTILIZACION DEL SISTEMA FINANCIERO';
     }
     if ($codigo_formas_pago == 15) {
       $nombre_formas_pago = 'COMPESACION DE DE DEUDAS';
     }
     if ($codigo_formas_pago == 16) {
       $nombre_formas_pago = 'TARJETA DE DEBITO';
     }
     if ($codigo_formas_pago == 17) {
       $nombre_formas_pago = 'DINERO ELECTRONICO';
     }
     if ($codigo_formas_pago == 18) {
       $nombre_formas_pago = 'TARJETA PREPAGO';
     }
     if ($codigo_formas_pago == 19) {
       $nombre_formas_pago = 'TARJETA DE CREDITO';
     }
     if ($codigo_formas_pago == 20) {
       $nombre_formas_pago = 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO';
     }
     if ($codigo_formas_pago == 21) {
       $nombre_formas_pago = 'ENDOSO DE TITULOS';
     }



     $tipo_ambiente = $data__emmisor['tipo_ambiente'];
     if ($tipo_ambiente =='serivicios') {
       $precio_total  = round($data_lista_t['compra_total'],2);
       $precio_12_iva =  0;
       $precio_88_iva = $precio_total - $precio_12_iva;
       // code...
     }
     $direccion_receptor = $data__emmisor['direccion_reeptor'];
     $celular_receptor = $data__emmisor['celular_receptor'];
     $email_receptor = $data__emmisor['email_reeptor'];
     $numero_identidad_receptor = $data__emmisor['numero_identidad_receptor'];
     $tipo_identificacion = $data__emmisor['tipo_identificacion'];
     $numero_cedula_receptor = $numero_identidad_receptor;
     $nombres_receptor = $nombres_receptor;
     $nombre_empresa = $nombre_empresa;
     if ($direccion_receptor == '') {
       $direccion_receptor = 'Eustorgio Salgado y Santa Rosa';
     }else {
       $direccion_receptor = $direccion_receptor;
     }



     $xmlf=new xml();
     $xmlf->xmlFactura($fecha,$correo,$secuencial,$codigo,$cantidad,$descripcion,$preciou,$descuento,$preciot,$subtotal,$iva12,$total,$numero_cedula_receptor,$nombres_receptor,$nombre_empresa,$direccion,$tipo_identificacion,$estableciminento_f,$punto_emision_f,$porcentaje_iva_f,$numero_identidad_emisor,$contabilidad,$codigo_formas_pago,$iduser,$tipo_ambiente,$codigos_impuestos);

     $xmla=new autorizar();
     $xmla->autorizar_xml($fecha,$correo,$porcentaje_iva_f,$nombre_empresa,$img_logo,$direccion_emisor,$numero_identidad_emisor,$estableciminento_f,$punto_emision_f,$fecha_emision,$nombres_receptor,$numero_cedula_receptor,$precio_88_iva,$precio_12_iva,$precio_total,$email_emisor,$direccion_receptor,$celular_receptor,$email_receptor,$email_emisor,$secuencial,$numeroConCeros,$query_resultados_emmisor);

     // code...
   }else {
     echo '<script>alert("INGRESE AL MENOS UN REGISTRO ");</script>';
   }





?>
