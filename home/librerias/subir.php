<?php
require('PHPExcel-1.8/Classes/PHPExcel.php');
  require '../QR/phpqrcode/qrlib.php';
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8');


if ($_POST['action'] == 'subir_clientes') {

  // code...
  $clientes           =    $_FILES['clientes'];
  $nombre_archivo     =    $clientes['name'];
  $url_temp           =    $clientes['tmp_name'];
  $extension = 'xlsx';
  $nombre_archivo = 'excel'.md5(date('d-m-Y H:m:s').$iduser);
  $nombre_archivo = $nombre_archivo.'.'.$extension;
  $destino = '../librerias/';
  $src = $destino.$nombre_archivo;
  move_uploaded_file($url_temp,$src);
  $archivos = $nombre_archivo;
  $excel = PHPExcel_IOFactory::load($archivos);
   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
  $excel -> setActiveSheetIndex(0);
  $numerofila = $excel ->setActiveSheetIndex(0)->getHighestRow();
  for ($i=2; $i <= $numerofila; $i++) {

    $contenido = md5(date('d-m-Y H:m:s').$iduser);
    $img_nombre = 'cliente'.md5(date('d-m-Y H:m:s').$i);
    $qr_img = $img_nombre.'.png';
    $direccion = '../img/qr/';
    $filename = $direccion.$qr_img;
    $tamanio = 7;
    $level = 'H';
    $frameSize = 5;
    $contenido = $contenido;
    QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


    $nombre             = $excel ->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
    $mail                = $excel ->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
    $direccion           = $excel ->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
    $identificacion      = $excel ->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
    $celular             = $excel ->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
    $tipo_cliente        = $excel ->getActiveSheet(0)->getCell('F'.$i)->getCalculatedValue();
    $actividad_economica        = $excel ->getActiveSheet(0)->getCell('G'.$i)->getCalculatedValue();

    $parroquia           = $excel ->getActiveSheet(0)->getCell('H'.$i)->getCalculatedValue();
    $ciudad              = $excel ->getActiveSheet(0)->getCell('I'.$i)->getCalculatedValue();
    $provincia           = $excel ->getActiveSheet(0)->getCell('J'.$i)->getCalculatedValue();
    $telefono            = $excel ->getActiveSheet(0)->getCell('K'.$i)->getCalculatedValue();


    $largo_cadena = strlen($identificacion);

      if ($largo_cadena < 10 || $largo_cadena > 13 ) {
        $arrayName = array('noticia'=>'identificacion_invalida','identificacion'=>$identificacion,'columna'=>$i);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
      }else {
        if ($largo_cadena == '13') {
          if ($identificacion == '9999999999999') {
              $tipo_identificacion       = '07';
          }
          if ($identificacion != '9999999999999') {
            //echo "Esto es un ruc";
              $tipo_identificacion       = '04';
          }
        }
        if ($largo_cadena == '10') {
            $tipo_identificacion       ='05';
          //echo "Este es cedula";
        }

      }

      $img_cliente = 'avatar.png';


       $query_insert=mysqli_query($conection,"INSERT INTO clientes(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,sistema,qr,qr_contenido,
       actividad_economica,parroquia,ciudad,provincia,url_img_upload,url_upload_qr,telefono)
                                     VALUES('$nombre','$mail','$tipo_identificacion','$direccion','$identificacion','$celular','$img_cliente','$iduser','$tipo_cliente','subida_xml','$qr_img','$contenido',
                                     '$actividad_economica','parroquia','$ciudad','$provincia','$url','$url','$telefono') ");
  }
  if ($query_insert) {
    $arrayName = array('registros' =>($i-2),'noticia'=>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia'=>'error_insertar');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
  unlink($src);
}
if ($_POST['action'] == 'subir_productos') {
  // code...
  $productos           =    $_FILES['productos'];
  $nombre_archivo     =    $productos['name'];
  $url_temp           =    $productos['tmp_name'];
  $extension = 'xlsx';
  $nombre_archivo = 'excel'.md5(date('d-m-Y H:m:s').$iduser);
  $nombre_archivo = $nombre_archivo.'.'.$extension;
  $destino = '../librerias/';
  $src = $destino.$nombre_archivo;
    move_uploaded_file($url_temp,$src);

  $archivos = $nombre_archivo;
  $excel = PHPExcel_IOFactory::load($archivos);
  $excel -> setActiveSheetIndex(0);
  $numerofila = $excel ->setActiveSheetIndex(0)->getHighestRow();

   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
   $codigos_impuestos                =  2;
   $imgProducto = 'img_producto.png';

  for ($i=2; $i <= $numerofila; $i++) {
    $contenido = md5(date('d-m-Y H:m:s').$iduser);
    $img_nombre = 'producto'.md5(date('d-m-Y H:m:s').$i);
    $qr_img = $img_nombre.'.png';
    $direccion = '../img/qr/';
    $filename = $direccion.$qr_img;
    $tamanio = 7;
    $level = 'H';
    $frameSize = 5;
    $contenido = $contenido;
    QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);



    $nombre              = $excel ->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
    $cantidad            = $excel ->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
    $descripcion         = $excel ->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
    $precio_sin_impuestos= $excel ->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
    $precio_con_impuestos= $excel ->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
    $precio_costo        = $excel ->getActiveSheet(0)->getCell('F'.$i)->getCalculatedValue();
    $identificacion_proveedor = $excel ->getActiveSheet(0)->getCell('G'.$i)->getCalculatedValue();
    $marca_producto= $excel ->getActiveSheet(0)->getCell('H'.$i)->getCalculatedValue();
    $codigo_extra= $excel ->getActiveSheet(0)->getCell('I'.$i)->getCalculatedValue();
    $codigo_barras= $excel ->getActiveSheet(0)->getCell('J'.$i)->getCalculatedValue();

    //CODIGO PARA SACAR INFORMACION DEL PROVEEDOR

    if (!empty($identificacion_proveedor)) {
      $query_proveedor = mysqli_query($conection, "SELECT * FROM proveedor WHERE proveedor.identificacion = $identificacion_proveedor");
      $result_proveedor = mysqli_fetch_array($query_proveedor);
      if ($result_proveedor) {
        $proveedor = $result_proveedor['id'];
      }else {
        $proveedor = '';
      }

    }else {
        $proveedor = '';
    }



    //CODIGO PARA SABER QUE TIPO DE IMPUESTOS ES

    if ($precio_sin_impuestos == $precio_con_impuestos) {
      $tipo_ambiente = 0;
    }else {
      $tipo_ambiente = 2;
    }

    $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(foto,nombre,precio,precio_costo,descripcion,id_usuario,qr,contenido_qr,identificador_trabajo,marca,cantidad,sistema,proveedor,codigo_extra,
                                 tipo_ambiente,codigos_impuestos,valor_unidad_final_con_impuestps,url_upload_img,url_upload_qr,codigo_barras)
                                  VALUES('$imgProducto','$nombre','$precio_sin_impuestos','$precio_costo','$descripcion','$iduser','$qr_img','$contenido','producto','$marca_producto','$cantidad','subida_xml','$proveedor','$codigo_extra',
                                  '$tipo_ambiente','$codigos_impuestos','$precio_con_impuestos','$url','$url','$codigo_barras') ");
  }
  if ($query_insert) {
    $arrayName = array('registros' =>($i-2),'noticia'=>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia'=>'error_insertar');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
  unlink($src);
}





if ($_POST['action'] == 'subir_clientes_credenciales') {

  // code...
  $clientes           =    $_FILES['clientes'];
  $nombre_archivo     =    $clientes['name'];
  $url_temp           =    $clientes['tmp_name'];
  $extension = 'xlsx';
  $nombre_archivo = 'excel'.md5(date('d-m-Y H:m:s').$iduser);
  $nombre_archivo = $nombre_archivo.'.'.$extension;
  $destino = '../librerias/';
  $src = $destino.$nombre_archivo;
  move_uploaded_file($url_temp,$src);
  $archivos = $nombre_archivo;
  $excel = PHPExcel_IOFactory::load($archivos);
   $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
  $excel -> setActiveSheetIndex(0);
  $numerofila = $excel ->setActiveSheetIndex(0)->getHighestRow();
  for ($i=2; $i <= $numerofila; $i++) {



    $nombres             = $excel ->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
    $identificacion                = $excel ->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
    $clave_sri           = $excel ->getActiveSheet(0)->getCell('F'.$i)->getCalculatedValue();
    $clavr_iees_patronal      = $excel ->getActiveSheet(0)->getCell('G'.$i)->getCalculatedValue();
    $clave_mrl_contratos             = $excel ->getActiveSheet(0)->getCell('H'.$i)->getCalculatedValue();
    $clave_mrl_decimos        = $excel ->getActiveSheet(0)->getCell('I'.$i)->getCalculatedValue();
    $clave_turismo        = $excel ->getActiveSheet(0)->getCell('J'.$i)->getCalculatedValue();
    $clave_municipio           = $excel ->getActiveSheet(0)->getCell('K'.$i)->getCalculatedValue();
    $clave_turismo_municipio              = $excel ->getActiveSheet(0)->getCell('L'.$i)->getCalculatedValue();
    $clave_bombero           = $excel ->getActiveSheet(0)->getCell('M'.$i)->getCalculatedValue();
    $clave_ambiental            = $excel ->getActiveSheet(0)->getCell('N'.$i)->getCalculatedValue();
    $clave_intendencia           = $excel ->getActiveSheet(0)->getCell('O'.$i)->getCalculatedValue();
    $clave_iees_personal              = $excel ->getActiveSheet(0)->getCell('P'.$i)->getCalculatedValue();

    $clave_iees_domestica           = $excel ->getActiveSheet(0)->getCell('Q'.$i)->getCalculatedValue();
    $clave_ambiente            = $excel ->getActiveSheet(0)->getCell('R'.$i)->getCalculatedValue();
    $usuario_arcsa           = $excel ->getActiveSheet(0)->getCell('S'.$i)->getCalculatedValue();
    $clave_arcsa              = $excel ->getActiveSheet(0)->getCell('T'.$i)->getCalculatedValue();
    $clave_firma_electronica           = $excel ->getActiveSheet(0)->getCell('U'.$i)->getCalculatedValue();
    $usuario_facturacion_electronica            = $excel ->getActiveSheet(0)->getCell('V'.$i)->getCalculatedValue();
    $clave_facturacion_electronica           = $excel ->getActiveSheet(0)->getCell('W'.$i)->getCalculatedValue();
    $usuario_sercop              = $excel ->getActiveSheet(0)->getCell('X'.$i)->getCalculatedValue();
    $clave_sercop           = $excel ->getActiveSheet(0)->getCell('Y'.$i)->getCalculatedValue();
    $usuario_gerente_superior            = $excel ->getActiveSheet(0)->getCell('Z'.$i)->getCalculatedValue();

    $clave_gerente_superior           = $excel ->getActiveSheet(0)->getCell('AA'.$i)->getCalculatedValue();
    $clave_super_compania              = $excel ->getActiveSheet(0)->getCell('AB'.$i)->getCalculatedValue();
    $representante_legal           = $excel ->getActiveSheet(0)->getCell('AC'.$i)->getCalculatedValue();
    $cedula            = $excel ->getActiveSheet(0)->getCell('AD'.$i)->getCalculatedValue();
    $mail              = $excel ->getActiveSheet(0)->getCell('AE'.$i)->getCalculatedValue();
    $clave_correo           = $excel ->getActiveSheet(0)->getCell('AF'.$i)->getCalculatedValue();
    $telefono            = $excel ->getActiveSheet(0)->getCell('AG'.$i)->getCalculatedValue();



      $img_cliente = 'avatar.png';


       $query_insert=mysqli_query($conection,"INSERT INTO usuarios_credenciales(nombres,identificacion,clave_sri,clavr_iees_patronal,clave_mrl_contratos,clave_mrl_decimos,clave_turismo,clave_municipio,clave_turismo_municipio,clave_bombero,clave_ambiental,clave_intendencia,clave_iees_personal,clave_iees_domestica,clave_ambiente,usuario_arcsa,clave_arcsa,clave_firma_electronica,usuario_facturacion_electronica,
         clave_facturacion_electronica,usuario_sercop,clave_sercop,usuario_gerente_superior,clave_gerente_superior,clave_super_compania,representante_legal,cedula,mail,clave_correo,telefono,iduser)
         VALUES('$nombres','$identificacion','$clave_sri','$clavr_iees_patronal','$clave_mrl_contratos','$clave_mrl_decimos','$clave_turismo','$clave_municipio','$clave_turismo_municipio','$clave_bombero','$clave_ambiental',
           '$clave_intendencia','$clave_iees_personal','$clave_iees_domestica','$clave_ambiente','$usuario_arcsa','$clave_arcsa','$clave_firma_electronica','$usuario_facturacion_electronica','$clave_facturacion_electronica',
           '$usuario_sercop','$clave_sercop','$usuario_gerente_superior','$clave_gerente_superior','$clave_super_compania','$representante_legal','$cedula','$mail','$clave_correo','$telefono','$iduser') ");
  }
  if ($query_insert) {
    $arrayName = array('registros' =>($i-2),'noticia'=>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia'=>'error_insertar');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
  unlink($src);
}

  ?>
