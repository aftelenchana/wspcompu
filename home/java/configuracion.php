<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
  include "../../coneccion.php";
    mysqli_set_charset($conection, 'utf8'); //linea a colocar
  $query_config = mysqli_query($conection, "SELECT * FROM `configuraciones` ");
  $result_config = mysqli_fetch_array($query_config);
  $nombre_empresa_ttt = $result_config['nombre_empresa'];
  $foto_representativa = $result_config['foto_representativa'];
  $web = $result_config['web'];
  $servidor_email = $result_config['servidor_email'];
  $email_empresa = $result_config['email_empresa'];

  if ($_POST['action']== 'consulta_ruc') {

    $numero_ciruc = $_POST['numero_ruc'];
    $datos = json_decode(file_get_contents('https://www.guibis.com/dev/ruc?key=F48ECE4E445FD02B738F96B8561E32B9&callback=all&CIRUC='.$numero_ciruc.''),true);

    $query_update=mysqli_query($conection,"UPDATE usuarios SET numero_identidad= '$numero_ciruc'  WHERE id='$iduser' ");


    if (!empty($datos['noticia'])){
      $arrayName = array('noticia'=>'consulta_no_existente');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      exit;
    }
    $arrayName = array('noticia'=>'consulta_exitosa','NUMERO_RUC' =>$datos['NUMERO_RUC'],'ACTIVIDAD_ECONOMICA'=>
    $datos['ACTIVIDAD_ECONOMICA'],'DESCRIPCION_PROVINCIA' =>$datos['DESCRIPCION_PROVINCIA'],'DESCRIPCION_CANTON' =>$datos['DESCRIPCION_CANTON'],'RAZON_SOCIAL' =>$datos['RAZON_SOCIAL'],
   'NOMBRE_COMERCIAL' =>$datos['NOMBRE_COMERCIAL'],'ESTADO_CONTRIBUYENTE' =>$datos['ESTADO_CONTRIBUYENTE']);
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }


  if ($_POST['action']== 'agregar_plan') {
      $sistema_seleccionado = $_POST['sistema_seleccionado'];

      $query_insert=mysqli_query($conection,"INSERT INTO configuracion_cuenta  (iduser,plan)
                                              VALUES('$iduser','$sistema_seleccionado') ");

      $query_update=mysqli_query($conection,"UPDATE usuarios SET configurado_facturacion= 'CONFIGURADO'  WHERE id='$iduser' ");



      if ($query_insert & $query_update) {
        $arrayName = array('noticia' =>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        // code...
      }else {
        $arrayName = array('noticia' =>'error_servidor');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }


  }






 ?>
