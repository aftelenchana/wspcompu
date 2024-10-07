<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Mesero') {
    include "../sessiones/session_cuenta_mesero.php";

    }

    if ($_SESSION['rol'] == 'Cocina') {
    include "../sessiones/session_cuenta_cocina.php";
    }



    if ($_POST['action'] == 'epicrisis') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);

      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


      $query_consulta = mysqli_query($conection, "SELECT * FROM clientes
         WHERE clientes.iduser ='$iduser'  AND clientes.estatus = '1' AND clientes.id = '$paciente' ");
       $data_paciente = mysqli_fetch_array($query_consulta);
       $celular_paciente = $data_paciente['celular'];
       $telefono_paciente = $data_paciente['telefono'];
       $mail_paciente = $data_paciente['mail'];
       $nombres_paciente = $data_paciente['nombres'];
       $secuencial = $data_paciente['secuencial'];
       $nombres_paciente = $data_paciente['nombres'];




   //INFORMACION DEL VIDEO EXPLICATIVO
  if (!empty($_FILES['video_explicativo']['name'])) {
    $video           =    $_FILES['video_explicativo'];
    $nombre_video    =    $video['name'];
    $type 					 =   $video['type'];
    $url_temp        =    $video['tmp_name'];
    $extension = pathinfo($nombre_video, PATHINFO_EXTENSION);
    $nombre_video = 'guibis_ingreso'.md5(date('d-m-Y H:m:s'));
    $nombre_video_new = $nombre_video.'.'.$extension;
    $destino = '../img/videos/';
    $src = $destino.$nombre_video_new;
     move_uploaded_file($url_temp,$src);

     $url_video = $url;
    }else {
      $nombre_video_new = '';
      $url_video = '';
    }


    $talla              =  mysqli_real_escape_string($conection,$_POST['talla']);
    $peso               =  mysqli_real_escape_string($conection,$_POST['peso']);
    $presion_arterial        =  mysqli_real_escape_string($conection,$_POST['presion_arterial']);
    $motivo_admision           =  mysqli_real_escape_string($conection,$_POST['motivo_admision']);
    $diagnostico       =  mysqli_real_escape_string($conection,$_POST['diagnostico']);
    $recomendaciones    =  mysqli_real_escape_string($conection,$_POST['recomendaciones']);
    $observaciones        =  mysqli_real_escape_string($conection,$_POST['observaciones']);


    $query=mysqli_query($conection,"SELECT * FROM consultas_medicas  ORDER BY fecha DESC");
     $result = mysqli_fetch_array($query);
     if ($result) {
        $idconsulta = $result['id']+1;
       // code...
     }else {
       $idconsulta = 1;
     }


    $img_nombre = 'guibis_consulta'.md5(date('d-m-Y H:m:s'));
    $qr_img = $img_nombre.'.png';

    $contenido = md5(date('d-m-Y H:m:s').$paciente.$idconsulta);
    $direccion_qr = '../img/qr/';
    $filename = $direccion_qr.$qr_img;
    $tamanio = 7;
    $level = 'H';
    $frameSize = 5;
    $contenido = $contenido;
    QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

    $query_insert_epicrisis=mysqli_query($conection,"INSERT INTO consultas_medicas(iduser,paciente,talla,peso,presion_arterial,motivo_admision,diagnostico,recomendaciones,observaciones,qr_img,url_qr,contenido_qr,video,url_video,rol,idrol)
                               VALUES('$iduser','$paciente','$talla','$peso','$presion_arterial','$motivo_admision','$diagnostico','recomendaciones','$observaciones','$qr_img','$url','$contenido','$nombre_video_new','$url_video','$rol','$id_generacion') ");


$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Extensiones permitidas
    $cont = 1;
    foreach ($_FILES["lista"]["name"] as $key => $value) {
        // Verifica si hay un archivo subido y si no está vacío
        if (!empty($_FILES["lista"]["name"][$key])) {
            // Obtenemos la extensión del archivo
            $ext = explode('.', $_FILES["lista"]["name"][$key]);
            $file_extension = strtolower(end($ext)); // Convierte la extensión a minúsculas para la comparación

            // Verifica si la extensión del archivo está en la lista de permitidos
            if (in_array($file_extension, $allowedExtensions)) {
                // Generamos un nuevo nombre del archivo
                $renombrar = $cont.md5(date('d-m-Y H:m:s').$iduser.$paciente);
                $nombre_final = $renombrar.".".$file_extension;

                // Inserta la información en la base de datos
                $query_insert = mysqli_query($conection, "INSERT INTO img_consultas(iduser, idconsulta, img, url)
                                                          VALUES('$iduser', '$idconsulta', '$nombre_final', '$url')");

                // Se copian los archivos de la carpeta temporal del servidor a su ubicación final
                move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../img/uploads/".$nombre_final);
                $cont++;
            } else {
                // Manejar el caso en que la extensión no esté permitida
            }
        } else {
            // Manejar el caso en que no haya un archivo seleccionado
        }
    }


          if ($query_insert_epicrisis) {

            if (substr($celular_paciente, 0, 4) === '+593') {
                $celular_paciente = substr($celular_paciente, 1);
            }

            // Verifica si el número ya tiene el prefijo '593'
            if (substr($celular_paciente, 0, 3) !== '593') {
                // Verifica si comienza con '09' o tiene 9 dígitos y agrega '593'
                if (substr($celular_paciente, 0, 2) === '09' || strlen($celular_paciente) === 9) {
                    $celular_paciente = '593' . substr($celular_paciente, (strlen($celular_paciente) == 9 ? 0 : 1));
                }
            }

            if (strlen($celular_paciente) > 11) {
              $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;



            // Suponiendo que tienes una variable para la fecha de inicio de la consulta
            $fecha_inicio = date('Y-m-d H:i:s'); // Ajusta el formato de fecha según necesites

            $mensaje = "Hola *$nombres_paciente*,\n\n" .
                     "Se ha iniciado una consulta médica en nuestro sistema con los siguientes detalles:\n\n" .
                     "*Fecha de Inicio*: $fecha_inicio\n" .
                     "*Consulta*: $idconsulta\n" .
                     "*Talla*: $talla cm\n" .
                     "*Peso*: $peso Kg\n" .
                     "*Presión Arterial*: $presion_arterial mmHg\n" .
                     "*Motivo de Admisión*: $motivo_admision\n\n" .
                     "Datos del Paciente:\n" .
                     "*Nombres y Apellidos*: $nombres_paciente\n" .
                     "*Número de Historia Clínica*: $secuencial\n" .
                     "*Celular*: $celular_paciente\n" .
                     "*Teléfono*: $telefono_paciente\n" .
                     "*Correo Electrónico*: $mail_paciente\n\n" .
                     "Si tienes alguna duda o necesitas más información, no dudes en contactarnos.";


              // URL de la API a la que te quieres conectar
                $url = 'http://whatsapp.guibis.com:3001/send-message';

                // Los datos que quieres enviar en formato JSON
                $data = array(
                    'number' => $celular_paciente,
                    'message' => $mensaje
                );
                $data_json = json_encode($data);

                // Inicializa cURL
                $ch = curl_init($url);

                // Configura las opciones de cURL para POST
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_json)
                ));

                // Ejecuta la sesión cURL
                $response = curl_exec($ch);


                // Verifica si hubo un error en la solicitud
                if(curl_errno($ch)){
                    throw new Exception(curl_error($ch));
                }

                // Cierra la sesión cURL
                curl_close($ch);



              // Decodifica la respuesta JSON y la imprime
              $responseData = json_decode($response, true);
              if (isset($responseData['success']) && $responseData['success'] === true) {

                $estado_wsp = 'Mensaje Enviado por WhatsApp '.$celular_paciente.'';
              }else {
                $estado_wsp = 'Mensaje por WhatsApp '.$celular_paciente.' no Enviado '.$response.' ';
              }
              // code...
            }else {
                $estado_wsp = 'número no soportado '.$celular_paciente.'';
            }


            $arrayName = array('noticia' =>'insert_correct','paciente'=>$paciente,'wsp'=>$estado_wsp);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }else {
            $arrayName = array('noticia' =>'error');
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }


      // code...
    }

 ?>
