<?php
session_start();
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8');

$query_lista = mysqli_query($conection," SELECT comprobante_factura_final.cedula_receptor,comprobante_factura_final.id,
  comprobante_factura_final.nombres_receptor,comprobante_factura_final.email_receptor,comprobante_factura_final.direccion_receptor,
  comprobante_factura_final.celular_receptor
   FROM comprobante_factura_final
  WHERE comprobante_factura_final.codigo_interno_factura != '00000000'
    AND comprobante = 'factura' AND comprobante_factura_final.personas_ecuador != 'PROCESADO'
ORDER BY `comprobante_factura_final`.`fecha` desc LIMIT 100 ");
    $result_lista= mysqli_num_rows($query_lista);
  if ($result_lista > 0) {
        while ($data_lista=mysqli_fetch_array($query_lista)) {

          $cedula_receptor =$data_lista['cedula_receptor'];
          $id_factura =$data_lista['id'];

          $query_personas_ecuador = mysqli_query($conection," SELECT *
             FROM personas_ecuador
            WHERE personas_ecuador.NUMERO_RUC = '$cedula_receptor'");
            $resultado_personas_ecuador= mysqli_num_rows($query_personas_ecuador);
            if ($resultado_personas_ecuador >0) {
               $data_persona_ecuador = mysqli_fetch_array($query_personas_ecuador);
                 $nombres_receptor =$data_lista['nombres_receptor'];
                 $email_receptor =$data_lista['email_receptor'];
                 $direccion_receptor =$data_lista['direccion_receptor'];
                 $celular_receptor =$data_lista['celular_receptor'];
                 $cedula_receptor =$data_lista['cedula_receptor'];

              $query_edit_personas_ecuador=mysqli_query($conection,"UPDATE personas_ecuador SET RAZON_SOCIAL= '$nombres_receptor',DIRECCION='$nombre_producto',
                CELULAR = '$celular_receptor',EMAIL='$email_receptor'
                WHERE NUMERO_RUC = '$cedula_receptor'  ");

                $query_edit_comprbante=mysqli_query($conection,"UPDATE comprobante_factura_final SET personas_ecuador= 'PROCESADO'
                  WHERE id = '$id_factura'  ");
                  if ($query_edit_personas_ecuador && $query_edit_comprbante) {
                    $arrayName = array('noticia'=>'dato_editado');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                    // code...
                  }else {
                    $arrayName = array('noticia'=>'error_editar');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }


            }else {
              $data_persona_ecuador = mysqli_fetch_array($query_personas_ecuador);
                $nombres_receptor =$data_lista['nombres_receptor'];
                $email_receptor =$data_lista['email_receptor'];
                $direccion_receptor =$data_lista['direccion_receptor'];
                $celular_receptor =$data_lista['celular_receptor'];
                $cedula_receptor =$data_lista['cedula_receptor'];
              $query_insert_dato=mysqli_query($conection,"INSERT INTO personas_ecuador(RAZON_SOCIAL,EMAIL,DIRECCION,CELULAR,NUMERO_RUC)
                                            VALUES('$nombres_receptor','$email_receptor','$direccion_receptor','$celular_receptor','$cedula_receptor') ");

              $query_edit_comprbante=mysqli_query($conection,"UPDATE comprobante_factura_final SET personas_ecuador= 'PROCESADO'
                WHERE id = '$id_factura'  ");
                if ($query_insert_dato) {
                  $arrayName = array('noticia'=>'dato_insertado');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }else {
                  $arrayName = array('noticia'=>'error_insertar');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }






 ?>
