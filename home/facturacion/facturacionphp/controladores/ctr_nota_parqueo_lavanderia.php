<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}

include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar
     include 'ctr_creador_pdf_parqueo_lavanderia.php';
     $codigo_entrada = $_POST['id_creado'];

     $xmla=new autorizar_parqueo();
     $xmla->autorizar_generar_pdf($codigo_entrada );





?>
