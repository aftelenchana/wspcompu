<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar

if ($_POST['action'] == 'infoproducto') {

  $producto = $_POST['producto'];
  $query = mysqli_query($conection, "SELECT *  FROM producto_venta
      WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;

  // code...
}

if ($_POST['action'] == 'add_factores_libros') {
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');

  }
  $iduser= $_SESSION['id'];
  $idproducto = $_POST['idproducto'];
  $paginas_libro_into = $_POST['paginas_libro_into'];
  $aotir_libro_into = $_POST['aotir_libro_into'];
  $edicion_libro_into = $_POST['edicion_libro_into'];
    $existencia_erchivo = $_POST['existencia_erchivo'];
  $tangibilidad = $_POST['tangibilidad'];
  $codigo_encriptado_int = $_POST['codigo_encriptado_int'];
  $enlace_mega_int_d = $_POST['enlace_mega_int_d'];
  /**/
  if ($tangibilidad=="Digital") {
    // code...
    if ($codigo_encriptado_int == "" || $enlace_mega_int_d=="") {
      $arrayName = array('noticia' =>'campo_vacio_digital');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;
   }
   if ( $enlace_mega_int_d != "") {
     // code...
     $enlace_mega_int_d = $_POST['enlace_mega_int_d'];
     $enlace_mega_int_d_sin_espacios = trim($enlace_mega_int_d);
     $enlace_mega__number = str_split($enlace_mega_int_d_sin_espacios);
     $enlace_mega__array = count($enlace_mega__number);
     if ($enlace_mega__array>14) {
       // code...
       $A0 = $enlace_mega__number[0];
       $A1 = $enlace_mega__number[1];
       $A2 = $enlace_mega__number[2];
       $A3 = $enlace_mega__number[3];
       $A4 = $enlace_mega__number[4];
       $A5 = $enlace_mega__number[5];
       $A6 = $enlace_mega__number[6];
       $A7 = $enlace_mega__number[7];
       $A8 = $enlace_mega__number[8];
       $A9 = $enlace_mega__number[9];
       $A10 = $enlace_mega__number[10];
       $A11 = $enlace_mega__number[11];
       $A12 = $enlace_mega__number[12];
       $A13 = $enlace_mega__number[13];
       $A14 = $enlace_mega__number[14];
       if ($A0== 'h' && $A1 == 't' && $A2 == 't' && $A3 == 'p' && $A4 == 's' && $A8 == 'm' && $A9 == 'e' && $A10 == 'g' &&
       $A11 == 'a' &&  $A12 == '.' && $A13 == 'n' && $A14 == 'z' ) {
       }else {
         $arrayName = array('noticia' =>'enlace_no_valido');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         exit;
       }
     }else {
       $arrayName = array('noticia' =>'enlace_corto');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       exit;
     }
   }
  }

if ($tangibilidad=="Fisico") {
  $codigo_encriptado_int = "";
$enlace_mega_int_d = "";
}
  $pdf_extra         =    $_FILES['pdf_extra'];
  $nombre_pdf_extra  =    $pdf_extra['name'];
  if ($nombre_pdf_extra =="") {
    if ($existencia_erchivo =="") {
      $archivo_pdf_extra ="";
    }else {
      $archivo_pdf_extra =$existencia_erchivo;
      // code...
    }
    // code...
  }
  if ($nombre_pdf_extra != "") {
    $nombre_pdf_extra  =    $pdf_extra['name'];
    $url_temp1         =    $pdf_extra['tmp_name'];
    $destino1 = '../archivos/extras/';
    $img_nombre_pdf = 'pdf_extra'.$iduser.md5(date('d-m-Y H:m:s').$iduser).'.pdf';
    $src1 = $destino1.$img_nombre_pdf;
    $archivo_pdf_extra =$img_nombre_pdf;
    move_uploaded_file($url_temp1,$src1);
  }
  $query_insert_factor=mysqli_query($conection,"UPDATE producto_venta SET tipo_libro='$tangibilidad',enlace_mega='$enlace_mega_int_d',
    encriptacion_mega_libro='$codigo_encriptado_int',pdf_extra ='$archivo_pdf_extra',paginas_libro ='$paginas_libro_into',autor_libro ='$aotir_libro_into',editorial_libro ='$edicion_libro_into'
    WHERE idproducto='$idproducto' ");
  if ($query_insert_factor) {
    $arrayName = array('tangibilidad' =>$tangibilidad,'codigo_encriptado_int' =>$codigo_encriptado_int,'enlace_mega_int_d' =>$enlace_mega_int_d,
  'pdf_extra' =>$archivo_pdf_extra,'paginas_libro' =>$paginas_libro_into,'autor_libro' =>$aotir_libro_into,'editorial_libro' =>$edicion_libro_into,'noticia' =>'inser_exito');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }


  // code...
}


/*Agregar factores en zapatos*/
if ($_POST['action'] == 'add_factores_zapatos') {
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');

  }
  $iduser= $_SESSION['id'];
  $idproducto           = $_POST['idproducto'];
  $tipo_calzado_hh      = $_POST['tipo_calzado_hh'];
  $color_calzado_hh     = $_POST['color_calzado_hh'];
  $talla_calzado        = $_POST['talla_calzado'];
  $planta_calzado_int   = $_POST['planta_calzado_int'];
  $material_corte       = $_POST['material_corte'];


  $pdf_extra         =    $_FILES['pdf_extra'];
  $existencia_erchivo   = $_POST['existencia_erchivo'];
  $nombre_pdf_extra  =    $pdf_extra['name'];
  if ($nombre_pdf_extra =="") {
    if ($existencia_erchivo =="") {
      $archivo_pdf_extra ="";
    }else {
      $archivo_pdf_extra =$existencia_erchivo;
      // code...
    }
    // code...
  }
  if ($nombre_pdf_extra != "") {
    $nombre_pdf_extra  =    $pdf_extra['name'];
    $url_temp1         =    $pdf_extra['tmp_name'];
    $destino1 = '../archivos/extras/';
    $img_nombre_pdf = 'pdf_extra'.$iduser.md5(date('d-m-Y H:m:s').$iduser).'.pdf';
    $src1 = $destino1.$img_nombre_pdf;
    $archivo_pdf_extra =$img_nombre_pdf;
    move_uploaded_file($url_temp1,$src1);
  }
  $query_insert_factor=mysqli_query($conection,"UPDATE producto_venta SET tipo_calzado='$tipo_calzado_hh',color_calzado='$color_calzado_hh',
    talla_calzado='$talla_calzado',pdf_extra ='$archivo_pdf_extra',planta_calzado ='$planta_calzado_int',material_corte ='$material_corte'
    WHERE idproducto='$idproducto' ");
  if ($query_insert_factor) {
    $arrayName = array('tipo_calzado' =>$tipo_calzado_hh,'color_calzado' =>$color_calzado_hh,'talla_calzado' =>$talla_calzado,
  'pdf_extra' =>$archivo_pdf_extra,'planta_calzado' =>$planta_calzado_int,'material_corte' =>$material_corte,'noticia' =>'inser_exito');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }else {
   $arrayName = array('noticia' =>'error_insertar');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }


  // code...
}



/*Agregar factores en ropa subcategoria 10*/
if ($_POST['action'] == 'add_factores_ropa') {
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');

  }
  $iduser= $_SESSION['id'];
  $idproducto           = $_POST['idproducto'];
  $tipo_ropa_hh      = $_POST['tipo_ropa_hh'];
  $color_ropa_hh     = $_POST['color_ropa_hh'];
  $envios_hh        = $_POST['envios_hh'];
  $talla_ropa   = $_POST['talla_ropa'];
  $tela_int       = $_POST['tela_int'];
  $genero_ropa_int       = $_POST['genero_ropa_int'];


  $pdf_extra         =    $_FILES['pdf_extra'];
  $existencia_erchivo   = $_POST['existencia_erchivo'];
  $nombre_pdf_extra  =    $pdf_extra['name'];
  if ($nombre_pdf_extra =="") {
    if ($existencia_erchivo =="") {
      $archivo_pdf_extra ="";
    }else {
      $archivo_pdf_extra =$existencia_erchivo;
      // code...
    }
    // code...
  }
  if ($nombre_pdf_extra != "") {
    $nombre_pdf_extra  =    $pdf_extra['name'];
    $url_temp1         =    $pdf_extra['tmp_name'];
    $destino1 = '../archivos/extras/';
    $img_nombre_pdf = 'pdf_extra'.$iduser.md5(date('d-m-Y H:m:s').$iduser).'.pdf';
    $src1 = $destino1.$img_nombre_pdf;
    $archivo_pdf_extra =$img_nombre_pdf;
    move_uploaded_file($url_temp1,$src1);
  }
  $query_insert_factor=mysqli_query($conection,"UPDATE producto_venta SET tipo_ropa='$tipo_ropa_hh',color_ropa='$color_ropa_hh',
    envios='$envios_hh',talla_ropa ='$talla_ropa',tela_ropa ='$tela_int'
    ,genero_ropa ='$genero_ropa_int',pdf_extra ='$archivo_pdf_extra'
    WHERE idproducto='$idproducto' ");
  if ($query_insert_factor) {
    $arrayName = array('tipo_ropa' =>$tipo_ropa_hh,'color_ropa' =>$color_ropa_hh,'envios' =>$envios_hh,
    'talla_ropa' =>$talla_ropa,'tela_ropa' =>$tela_int,'genero_ropa' =>$genero_ropa_int,
    'noticia' =>'inser_exito','pdf_extra' =>$archivo_pdf_extra);
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }else {
   $arrayName = array('noticia' =>'error_insertar');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }


  // code...
}
 ?>
