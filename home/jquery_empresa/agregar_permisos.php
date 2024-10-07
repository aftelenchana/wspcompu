<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_POST['action'] == 'permisos_documentos') {
      $idpuntoventa = $_POST['idpuntoventa'];


      $facturacion = $_POST['facturacion'];
      $nota_credito = $_POST['nota_credito'];
      $guia_remision = $_POST['guia_remision'];
      $nota_venta = $_POST['nota_venta'];
      $liquidacion_compra = $_POST['liquidacion_compra'];
      $retenciones = $_POST['retenciones'];
      $proformas = $_POST['proformas'];

      $query_insert=mysqli_query($conection,"INSERT INTO permisos_emision_documentos (iduser,idpuntoventa,factura,nota_credito,guia_demision,nota_venta,liquidacion_compra,retenciones,proformas)
                                    VALUES('$iduser','$idpuntoventa','$facturacion','$nota_credito','$guia_remision','$nota_venta','$liquidacion_compra','$retenciones','$proformas') ");

      if ($query_insert) {

          $arrayName = array('noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'agregar_tr') {
        $transportista = $_POST['transportista'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM transportistas WHERE transportistas.id ='$transportista'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }




 ?>
