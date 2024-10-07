<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
     include 'ctr_xml_notas_creditos.php';
     include 'ctr_nota_credito_firmarxml.php';



     $nomnto_modificacion = $_POST['nomnto_modificacion'];
     $razon_modficiacion = $_POST['razon_modficiacion'];
     $clave_acceso_factura = $_POST['clave_acceso_factura'];
     $sucursal_facturacion = $_POST['sucursal_facturacion'];

     $tipo_anulacion = $_POST['tipo_anulacion'];

     if ($tipo_anulacion == 'sin_sri') {
       $query_cambiar_estado=mysqli_query($conection,"UPDATE comprobante_factura_final SET estado= 'ANULADO'  WHERE clave_acceso='$clave_acceso_factura'  ");
       if ($query_cambiar_estado) {
         $arrayName = array('noticia'=>'estado_factura_anulada_internamente');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
         // code...
       }else {
         $arrayName = array('noticia'=>'error_servidor_cambiando_estado_sin_sri');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
       }


     }


     //codigo para sacar información para ver si ya esta hecha la nota de credito para no hacer denuevo

     $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_nota_credito WHERE comprobante_nota_credito.clave_acceso_factura ='$clave_acceso_factura' ");
     $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
     if ($data_existencia) {
       		$arrayName = array('noticia'=>'nota_credito_existente');
       		echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          exit;

     }

    $xmlf=new xml();
    $xmlf->xmlFactura($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$sucursal_facturacion);

    $xmla=new autorizar();
    $xmla->autorizar_xml($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$sucursal_facturacion);

?>
