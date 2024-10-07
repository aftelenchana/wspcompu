<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('content-type: application/json; charset=utf-8');



// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  session_start(); // Iniciar sesión

  // Destruir la sesión existente
  if (session_id() != "" || isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 2592000, '/');
  }
  session_destroy();

  // Limpiar las variables de sesión
  $_SESSION = array();

  // Iniciar una nueva sesión
  session_start();

  include "../../../../coneccion.php";
   mysqli_set_charset($conection, 'utf8'); //linea a colocar

  $JSONData = file_get_contents("php://input");
  $dataObject = json_decode($JSONData);
  $input = (array) $dataObject;
    if (empty($input['key'])) {
      $data = ['Error' => "298",'noticia'=>'Empty Key'];
      echo $json_info = json_encode($data);
      exit;
    }else {
      $key          = $input['key'];
      $query_lista_t = mysqli_query($conection,"SELECT * FROM `usuarios`
      WHERE id_e = '$key'");
      $existencia_usuario = mysqli_num_rows($query_lista_t);
      if ($existencia_usuario) {
        $data_lista_t=mysqli_fetch_array($query_lista_t);
        $id_usuario_logeado  = $data_lista_t['id'];

        $user_in = $input['user_in'];
       $_SESSION['active'] = true;
       $_SESSION['id'] = $id_usuario_logeado;
       $_SESSION['user_in'] = $user_in;
       $_SESSION['rol'] = 'cuenta_empresa';

       // var_dump($_SESSION); // Solo para depuración
       // exit; // Recuerda quitar esto para la ejecución normal

       $iduser = $_SESSION['id'];

        include 'ctr_xml_notas_creditos.php';
        include 'ctr_nota_credito_firmarxml.php';


      }else {
        $data = ['noticia'=>'Key Incorreta'];
        echo $json_info = json_encode($data);
        exit;
      }
    }


        $razon_modficiacion   = $input['razon_modficiacion'];
        $clave_acceso_factura = $input['clave_acceso_factura'];
        $sucursal_facturacion = $input['sucursal_emision'];

    //sacamos informacion para saber el monto que se debe realizar la nota de credito

    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];



     if ($ambito_area == 'prueba') {
       $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

         if (is_file($ruta_factura)) {

          $acceso_factura = simplexml_load_file($ruta_factura);

        //INFORMACION DEL DOCUMENTO
        $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

         //para crear el numero dl documento necesito de 4 partes
          $estab                       = $acceso_factura->infoTributaria->estab;
          $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
          $secuencial                  = $acceso_factura->infoTributaria->secuencial;
          $claveAcceso             = (string)$acceso_factura->infoTributaria->claveAcceso;
        $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';



        //informacion del comprador
          $identificacion_comprador           = (string)$acceso_factura->infoFactura->identificacionComprador;
          $tipo_identificacion_comprador      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
          $razon_social_comprador             = (string)$acceso_factura->infoFactura->razonSocialComprador;


          $fechaEmision             = (string)$acceso_factura->infoFactura->fechaEmision;
          $razonSocialComprador     = (string)$acceso_factura->infoFactura->razonSocialComprador;
          $identificacionComprador  = (string)$acceso_factura->infoFactura->identificacionComprador;

          //valor total de la factura
          $valor_totald_factura                = (string)$acceso_factura->infoFactura->importeTotal;
          $conte_variable_impuestos= (string)$acceso_factura->infoFactura->totalConImpuestos;
          $conte_variable_detalles= (string)$acceso_factura->detalles->detalle;



                if ($numDocModificado != '') {

                }else {
                  $arrayName = array('noticia' =>'error_al_recuperar_informacion');
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                    exit;
                }


        }else {
          $arrayName = array('noticia' =>'no_encuentra_archivo');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            exit;
          // code...
        }

     }else {
       $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$clave_acceso_factura' ");
       $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
       $ininterno = $data_existencia['id'];
       $url_file_upload = $data_existencia['url_file_upload'];
       $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
       function urlExists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    if (urlExists($ruta_factura)) {


       $acceso_factura = simplexml_load_file($ruta_factura);

     //INFORMACION DEL DOCUMENTO
     $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

      //para crear el numero dl documento necesito de 4 partes
       $estab                       = $acceso_factura->infoTributaria->estab;
       $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
       $secuencial                  = $acceso_factura->infoTributaria->secuencial;
       $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
       $claveAcceso             = (string)$acceso_factura->infoTributaria->claveAcceso;



     //informacion del comprador
       $identificacion_comprador           = (string)$acceso_factura->infoFactura->identificacionComprador;
       $tipo_identificacion_comprador      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
       $razon_social_comprador             = (string)$acceso_factura->infoFactura->razonSocialComprador;

       $fechaEmision             = (string)$acceso_factura->infoFactura->fechaEmision;
       $razonSocialComprador     = (string)$acceso_factura->infoFactura->razonSocialComprador;
       $identificacionComprador  = (string)$acceso_factura->infoFactura->identificacionComprador;

       //valor total de la factura
       $valor_totald_factura                = (string)$acceso_factura->infoFactura->importeTotal;
       $conte_variable_impuestos= (string)$acceso_factura->infoFactura->totalConImpuestos;
       $conte_variable_detalles= (string)$acceso_factura->detalles->detalle;



          if ($numDocModificado != '') {

         }else {
           $arrayName = array('noticia' =>'error_al_recuperar_informacion');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               exit;
          }


     }else {
       $arrayName = array('noticia' =>'error_al_recuperar_informacion');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       // code...
     }

     }

     $nomnto_modificacion = $valor_totald_factura;


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



    header("HTTP/1.1 200 OK");
    //echo json_encode($result);
    exit();
}




//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>
