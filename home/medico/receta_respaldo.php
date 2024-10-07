<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
$iduser = $_GET['iduser'];


$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_documentos = mysqli_fetch_array($query_doccumentos);
$regimen = $result_documentos['regimen'];
$contabilidad             = $result_documentos['contabilidad'];
$email_empresa_emisor     = $result_documentos['email'];
$celular_empresa_emisor   = $result_documentos['celular'];
$telefono_empresa_emisor  = $result_documentos['telefono'];
$direccion_emisor          = $result_documentos['direccion'];
$nombres                  = $result_documentos['nombres'];
$apellidos                = $result_documentos['apellidos'];
$numero_identificacion_emisor  = $result_documentos['numero_identidad'];
$contribuyente_especial   = $result_documentos['contribuyente_especial'];

$contabilidad            = $result_documentos['contabilidad'];
$img_facturacion         = $result_documentos['img_facturacion'];
$contabilidad         = $result_documentos['contabilidad'];
$regimen         = $result_documentos['regimen'];
$razon_social         = $result_documentos['razon_social'];

$facebook                = $result_documentos['facebook'];
$pagina_web                = $result_documentos['pagina_web'];
$instagram           = $result_documentos['instagram'];
$whatsapp             = $result_documentos['whatsapp'];
$url_img_upload             = $result_documentos['url_img_upload'];
$nombre_empresa      = $result_documentos['nombre_empresa'];




 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Receta </title>
  </head>
  <body>



    <style media="screen">
    .header-separator {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .line {
        flex-grow: 1;
        height: 3px;
        background-color: black;
        position: relative;
    }
    .cabezera{
      text-align: center;
    }
    .cabezera img{
      width: 100px;
    }

    .negrita{
      font-weight: bold;
    }

    .bloque_gene_cabezera{
      width: 33%;
      display: inline-block;
      vertical-align: top; /* Añadir alineación vertical */

    }

    /* Asegúrate de que las tablas llenen el espacio del bloque contenedor */
    .bloque_gene_cabezera table {
      text-align: center;
      width: 100%;
    }

    </style>


    <div class="cabezera">
      <div class="bloque_gene_cabezera">
          <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
      </div>


      <div class="bloque_gene_cabezera">
         <h2><?php echo $nombre_empresa ?></h2>
      </div>

      <div class="bloque_gene_cabezera">
        <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
      </div>
    </div>
    <div class="header-separator">
     <div class="line"></div>
   </div>




  </body>
</html>
