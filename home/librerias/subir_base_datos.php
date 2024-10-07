<?php
$inicio_secuncial = $_POST['inicio_secuncial'];
$final_secuencial = $_POST['final_secuencial'];


require('PHPExcel-1.8/Classes/PHPExcel.php');
include "../../coneccion.php";
$archivos = 'LOJA.xlsx'; 
$excel = PHPExcel_IOFactory::load($archivos);
$excel -> setActiveSheetIndex(0);
$numerofila_final = $excel ->setActiveSheetIndex(0)->getHighestRow();
$INICIA = $inicio_secuncial;
$numerofila = $final_secuencial;
for ($i=$inicio_secuncial; $i <= $numerofila; $i++) {
  $NUMERO_RUC          = $excel ->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
    $NUMERO_RUC = utf8_decode($NUMERO_RUC);
  $RAZON_SOCIAL        = $excel ->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
    $RAZON_SOCIAL = utf8_decode($RAZON_SOCIAL);
  $NOMBRE_COMERCIAL    = $excel ->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
    $NOMBRE_COMERCIAL = utf8_decode($NOMBRE_COMERCIAL);
  $ESTADO_CONTRIBUYENTE= $excel ->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
  $CLASE_CONTRIBUYENTE = $excel ->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
  $FECHA_INICIO_ACTIVIDADES= $excel ->getActiveSheet(0)->getCell('F'.$i)->getCalculatedValue();

  $FECHA_ACTUALIZACION = $excel ->getActiveSheet(0)->getCell('G'.$i)->getCalculatedValue();
  $FECHA_SUSPENSION_DEFINITIVA = $excel ->getActiveSheet(0)->getCell('H'.$i)->getCalculatedValue();
  $FECHA_REINICIO_ACTIVIDADES = $excel ->getActiveSheet(0)->getCell('I'.$i)->getCalculatedValue();
  $OBLIGADO = $excel ->getActiveSheet(0)->getCell('J'.$i)->getCalculatedValue();
  $TIPO_CONTRIBUYENTE = $excel ->getActiveSheet(0)->getCell('K'.$i)->getCalculatedValue();
  $NUMERO_ESTABLECIMIENTO = $excel ->getActiveSheet(0)->getCell('L'.$i)->getCalculatedValue();
  $NOMBRE_FANTASIA_COMERCIAL = $excel ->getActiveSheet(0)->getCell('M'.$i)->getCalculatedValue();
    $NOMBRE_FANTASIA_COMERCIAL = utf8_decode($NOMBRE_FANTASIA_COMERCIAL);
  $ESTADO_ESTABLECIMIENTO = $excel ->getActiveSheet(0)->getCell('N'.$i)->getCalculatedValue();
  $DESCRIPCION_PROVINCIA = $excel ->getActiveSheet(0)->getCell('O'.$i)->getCalculatedValue();
    $DESCRIPCION_PROVINCIA = utf8_decode($DESCRIPCION_PROVINCIA);
  $DESCRIPCION_CANTON = $excel ->getActiveSheet(0)->getCell('P'.$i)->getCalculatedValue();
  $DESCRIPCION_CANTON = utf8_decode($DESCRIPCION_CANTON);
  $DESCRIPCION_PARROQUIA = $excel ->getActiveSheet(0)->getCell('Q'.$i)->getCalculatedValue();
  $DESCRIPCION_PARROQUIA = utf8_decode($DESCRIPCION_PARROQUIA);
  $CODIGO_CIIU = $excel ->getActiveSheet(0)->getCell('R'.$i)->getCalculatedValue();
  $ACTIVIDAD_ECONOMICA = $excel ->getActiveSheet(0)->getCell('S'.$i)->getCalculatedValue();
    $ACTIVIDAD_ECONOMICA = utf8_decode($ACTIVIDAD_ECONOMICA);
  $query_insert=mysqli_query($conection,"INSERT INTO personas_ecuador(NUMERO_RUC,RAZON_SOCIAL,NOMBRE_COMERCIAL,ESTADO_CONTRIBUYENTE,CLASE_CONTRIBUYENTE,FECHA_INICIO_ACTIVIDADES,FECHA_ACTUALIZACION,FECHA_SUSPENSION_DEFINITIVA,FECHA_REINICIO_ACTIVIDADES,OBLIGADO,TIPO_CONTRIBUYENTE,NUMERO_ESTABLECIMIENTO,NOMBRE_FANTASIA_COMERCIAL,
    ESTADO_ESTABLECIMIENTO,DESCRIPCION_PROVINCIA,DESCRIPCION_CANTON,DESCRIPCION_PARROQUIA,CODIGO_CIIU,ACTIVIDAD_ECONOMICA)
  VALUES('$NUMERO_RUC','$RAZON_SOCIAL','$NOMBRE_COMERCIAL','$ESTADO_CONTRIBUYENTE','$CLASE_CONTRIBUYENTE','$FECHA_INICIO_ACTIVIDADES','$FECHA_ACTUALIZACION','$FECHA_SUSPENSION_DEFINITIVA','$FECHA_REINICIO_ACTIVIDADES','$OBLIGADO','$TIPO_CONTRIBUYENTE','$NUMERO_ESTABLECIMIENTO','$NOMBRE_FANTASIA_COMERCIAL','$ESTADO_ESTABLECIMIENTO'
    ,'$DESCRIPCION_PROVINCIA','$DESCRIPCION_CANTON','$DESCRIPCION_PARROQUIA','$CODIGO_CIIU','$ACTIVIDAD_ECONOMICA') ");

}
if ($query_insert) {
  $arrayName = array('noticia'=>'insert_correct','inicio' =>$INICIA,'llegada'=>$numerofila,'llegada_fin'=>$numerofila_final,'provincia'=>$DESCRIPCION_PROVINCIA);
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}else {
  $arrayName = array('noticia'=>'error_insertar');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}




 ?>
