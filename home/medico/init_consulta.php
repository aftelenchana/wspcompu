<?php

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

require_once '../pdf/dompdf/autoload.inc.php';


use Dompdf\Dompdf;
use Dompdf\Options;



use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

$mail = new  PHPMailer ( true );

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {

      $rol_salida = $_SESSION['rol'];
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'Recursos Humanos') {
      $rol_salida = $_SESSION['rol_interno'];
    include "../sessiones/session_recursos_humanos.php";

    }


    if ($_POST['action'] == 'antropometria') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);
      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


      $query_consulta = mysqli_query($conection, "SELECT * FROM clientes
         WHERE clientes.iduser ='$iduser'  AND clientes.estatus = '1' AND clientes.id = '$paciente' ");
       $data_paciente = mysqli_fetch_array($query_consulta);
       $celular_paciente  = $data_paciente['celular'];
       $telefono_paciente = $data_paciente['telefono'];
       $mail_paciente     = $data_paciente['mail'];
       $nombres_paciente  = $data_paciente['nombres'];
       $secuencial        = $data_paciente['secuencial'];
       $nombres_paciente  = $data_paciente['nombres'];

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


    $temperatura              =  mysqli_real_escape_string($conection,$_POST['temperatura']);
    $peso                     =  mysqli_real_escape_string($conection,$_POST['peso']);
    $talla                    =  mysqli_real_escape_string($conection,$_POST['talla']);
    $imc                      =  mysqli_real_escape_string($conection,$_POST['imc']);
    $presion_arterial         =  mysqli_real_escape_string($conection,$_POST['presion_arterial']);
    $pulso                    =  mysqli_real_escape_string($conection,$_POST['pulso']);
    $frecuencia_respiratoria  =  mysqli_real_escape_string($conection,$_POST['frecuencia_respiratoria']);
    $saturacion_oxigeno       =  mysqli_real_escape_string($conection,$_POST['saturacion_oxigeno']);
    $perimetro_cefalico       =  mysqli_real_escape_string($conection,$_POST['perimetro_cefalico']);
    $perimetro_toracico       =  mysqli_real_escape_string($conection,$_POST['perimetro_toracico']);
    $perimetro_abdominal      =  mysqli_real_escape_string($conection,$_POST['perimetro_abdominal']);
    $perimetro_inguinal       =  mysqli_real_escape_string($conection,$_POST['perimetro_inguinal']);
    $codigo_unico             =  mysqli_real_escape_string($conection,$_POST['codigo_unico']);


    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


    $query_update_epicrisis = mysqli_query($conection,"UPDATE consultas_medicas SET temperatura= '$temperatura',peso= '$peso'
      ,talla='$talla',talla= '$talla',imc= '$imc',presion_arterial= '$presion_arterial',pulso= '$pulso',frecuencia_respiratoria= '$frecuencia_respiratoria'
      ,saturacion_oxigeno= '$saturacion_oxigeno',perimetro_cefalico= '$perimetro_cefalico',perimetro_toracico= '$perimetro_toracico'
      ,perimetro_abdominal= '$perimetro_abdominal',perimetro_inguinal= '$perimetro_inguinal',idantro= '$id_generacion',rolantro= '$rol_salida'
        WHERE codigo_unico = '$codigo_unico' AND iduser = '$iduser' ");

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
                $query_insert = mysqli_query($conection, "INSERT INTO img_consultas(iduser, codigo_unico, img, url)
                                                          VALUES('$iduser', '$codigo_unico', '$nombre_final', '$url')");

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


          if ($query_update_epicrisis) {

            $arrayName = array('noticia' =>'insert_antropometria','paciente'=>$paciente);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }else {

            $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }


      // code...
    }





    if ($_POST['action'] == 'ingreso_antecedentes') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);
      $codigo_unico   =  mysqli_real_escape_string($conection,$_POST['codigo_unico']);
      //CODIGO PARA ANTECEDENTES

      $cardiopatia    = (isset($_REQUEST['cardiopatia'])) ? $_REQUEST['cardiopatia'] : '';
      $hipertension   = (isset($_REQUEST['hipertension'])) ? $_REQUEST['hipertension'] : '';
      $vascular       = (isset($_REQUEST['vascular'])) ? $_REQUEST['vascular'] : '';
      $endocrino      = (isset($_REQUEST['endocrino'])) ? $_REQUEST['endocrino'] : '';
      $cancer         = (isset($_REQUEST['cancer'])) ? $_REQUEST['cancer'] : '';
      $tuberculosis   = (isset($_REQUEST['tuberculosis'])) ? $_REQUEST['tuberculosis'] : '';
      $mental         = (isset($_REQUEST['mental'])) ? $_REQUEST['mental'] : '';
      $infecciosa     = (isset($_REQUEST['infecciosa'])) ? $_REQUEST['infecciosa'] : '';
      $malformacion   = (isset($_REQUEST['malformacion'])) ? $_REQUEST['malformacion'] : '';
      $otro           = (isset($_REQUEST['otro'])) ? $_REQUEST['otro'] : '';
      $cardiopatia_f  = (isset($_REQUEST['cardiopatia_f'])) ? $_REQUEST['cardiopatia_f'] : '';
      $hipertension_f = (isset($_REQUEST['hipertension_f'])) ? $_REQUEST['hipertension_f'] : '';
      $vascular_f     = (isset($_REQUEST['vascular_f'])) ? $_REQUEST['vascular_f'] : '';
      $endocrino_f    = (isset($_REQUEST['endocrino_f'])) ? $_REQUEST['endocrino_f'] : '';
      $cancer_f       = (isset($_REQUEST['cancer_f'])) ? $_REQUEST['cancer_f'] : '';
      $tuberculosis_f = (isset($_REQUEST['tuberculosis_f'])) ? $_REQUEST['tuberculosis_f'] : '';
      $mental_f       = (isset($_REQUEST['mental_f'])) ? $_REQUEST['mental_f'] : '';
      $infecciosa_f   = (isset($_REQUEST['infecciosa_f'])) ? $_REQUEST['infecciosa_f'] : '';
      $malformacion_f = (isset($_REQUEST['malformacion_f'])) ? $_REQUEST['malformacion_f'] : '';
      $otro_f         = (isset($_REQUEST['otro_f'])) ? $_REQUEST['otro_f'] : '';

   $query_verificador_antecedentes = mysqli_query($conection,"SELECT *
   FROM `antecedentes_medicos`
   WHERE antecedentes_medicos.iduser = '$iduser' AND antecedentes_medicos.estatus = '1' AND antecedentes_medicos.paciente = '$paciente' ");

   $result_antecedentes= mysqli_num_rows($query_verificador_antecedentes);

     if ($result_antecedentes > 0) {

       $query_update_antecedentes = mysqli_query($conection,"UPDATE antecedentes_medicos SET cardiopatia= '$cardiopatia',hipertension= '$hipertension'
         ,vascular='$vascular',endocrino= '$endocrino',cancer= '$cancer',tuberculosis= '$tuberculosis',mental= '$mental',infecciosa= '$infecciosa'
         ,malformacion= '$malformacion',otro= '$otro',cardiopatia_f= '$cardiopatia_f'
         ,hipertension_f= '$hipertension_f',vascular_f= '$vascular_f',endocrino_f= '$endocrino_f',cancer_f= '$cancer_f'
         ,tuberculosis_f= '$tuberculosis_f',mental_f= '$mental_f',infecciosa_f= '$infecciosa_f',malformacion_f= '$malformacion_f'
           , otro_f = '$otro_f' WHERE paciente = '$paciente'
           AND iduser = '$iduser' ");

           if ($query_update_antecedentes) {
             $resultado_antecedentes = 'Antecedente Actualizado';
             // code...
           }else {
             $resultado_antecedentes = 'Error al actualizar:'.mysqli_error($conection);
           }

    }else {
       //INSERTAMOS
      $query_insert_antecedente=mysqli_query($conection,"INSERT INTO antecedentes_medicos(iduser,paciente,cardiopatia,hipertension,vascular,endocrino,cancer,tuberculosis,mental,infecciosa,
      malformacion,otro,cardiopatia_f,hipertension_f,vascular_f,endocrino_f,cancer_f,tuberculosis_f,mental_f,infecciosa_f,malformacion_f,otro_f)
                                            VALUES('$iduser','$paciente','$cardiopatia','$hipertension','$vascular','$endocrino','$cancer','$tuberculosis','$mental','$infecciosa',
                                            '$malformacion','$otro','$cardiopatia_f','$hipertension_f','$vascular_f','$endocrino_f','$cancer_f','$tuberculosis_f','$mental_f','$infecciosa_f',
                                          '$malformacion_f','$otro_f') ");

          if ($query_insert_antecedente) {
            $resultado_antecedentes = 'Antecedente Creado';
            // code...
          }else {
            $resultado_antecedentes = 'Error al crear antecedente:'.mysqli_error($conection);
          }
    }



      //CODIGO PARA REVISION ACTUAL Y FISICO
      $piel           = (isset($_REQUEST['piel'])) ? $_REQUEST['piel'] : '';
      $sentidos       = (isset($_REQUEST['sentidos'])) ? $_REQUEST['sentidos'] : '';
      $respiratorio   = (isset($_REQUEST['respiratorio'])) ? $_REQUEST['respiratorio'] : '';
      $cardio         = (isset($_REQUEST['cardio'])) ? $_REQUEST['cardio'] : '';
      $digestivo      = (isset($_REQUEST['digestivo'])) ? $_REQUEST['digestivo'] : '';
      $genito         = (isset($_REQUEST['genito'])) ? $_REQUEST['genito'] : '';
      $musculo        = (isset($_REQUEST['musculo'])) ? $_REQUEST['musculo'] : '';
      $hemo           = (isset($_REQUEST['hemo'])) ? $_REQUEST['hemo'] : '';
      $nervioso       = (isset($_REQUEST['nervioso'])) ? $_REQUEST['nervioso'] : '';
      $efpiel         = (isset($_REQUEST['efpiel'])) ? $_REQUEST['efpiel'] : '';
      $efojos         = (isset($_REQUEST['efojos'])) ? $_REQUEST['efojos'] : '';
      $efoidosOidos   = (isset($_REQUEST['efoidosOidos'])) ? $_REQUEST['efoidosOidos'] : '';
      $efbocafaringe  = (isset($_REQUEST['efbocafaringe'])) ? $_REQUEST['efbocafaringe'] : '';
      $cuello         = (isset($_REQUEST['cuello'])) ? $_REQUEST['cuello'] : '';
      $efrespiratorio = (isset($_REQUEST['efrespiratorio'])) ? $_REQUEST['efrespiratorio'] : '';
      $efcardio       = (isset($_REQUEST['efcardio'])) ? $_REQUEST['efcardio'] : '';
      $efabdomen      = (isset($_REQUEST['efabdomen'])) ? $_REQUEST['efabdomen'] : '';
      $efgenito       = (isset($_REQUEST['efgenito'])) ? $_REQUEST['efgenito'] : '';
      $efextremidades = (isset($_REQUEST['efextremidades'])) ? $_REQUEST['efextremidades'] : '';
      $efneurologico  = (isset($_REQUEST['efneurologico'])) ? $_REQUEST['efneurologico'] : '';
      $endocrino  = (isset($_REQUEST['endocrino'])) ? $_REQUEST['endocrino'] : '';



    $query_update_epicrisis = mysqli_query($conection,"UPDATE consultas_medicas SET piel= '$piel',sentidos= '$sentidos'
      ,respiratorio='$respiratorio',cardio= '$cardio',digestivo= '$digestivo',genito= '$genito',musculo= '$musculo',hemo= '$hemo'
      ,nervioso= '$nervioso',efpiel= '$efpiel',efojos= '$efojos' ,idantecedentes = '$id_generacion',rolantecedentes= '$rol_salida'
      ,efoidosOidos= '$efoidosOidos',efbocafaringe= '$efbocafaringe',cuello= '$cuello',efrespiratorio= '$efrespiratorio'
      ,efcardio= '$efcardio',efabdomen= '$efabdomen',efgenito= '$efgenito',efextremidades= '$efextremidades'
      ,efneurologico= '$efneurologico',endocrino= '$endocrino'
        WHERE codigo_unico = '$codigo_unico' AND iduser = '$iduser' ");



          if ($query_update_epicrisis) {

            $arrayName = array('noticia' =>'insert_antecedentes','resultado_antecedentes'=>$resultado_antecedentes);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }else {

            $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
    }




    if ($_POST['action'] == 'ingreso_anamnesis') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);
      $codigo_unico   =  mysqli_real_escape_string($conection,$_POST['codigo_unico']);
      //CODIGO PARA ANTECEDENTES

      $motivo_consultar             =  mysqli_real_escape_string($conection,$_POST['motivo_consultar']);
      $problema_actual              =  mysqli_real_escape_string($conection,$_POST['problema_actual']);
      $antecedentes_personal_txt    =  mysqli_real_escape_string($conection,$_POST['antecedentes_personal_txt']);
      $antecedentes_familiares_text =  mysqli_real_escape_string($conection,$_POST['antecedentes_familiares_text']);
      $revision_organos_sistemas    =  mysqli_real_escape_string($conection,$_POST['revision_organos_sistemas']);
      $examen_fisico_regional       =  mysqli_real_escape_string($conection,$_POST['examen_fisico_regional']);




    $query_update_anamnesis = mysqli_query($conection,"UPDATE consultas_medicas SET motivo_consultar= '$motivo_consultar',problema_actual= '$problema_actual'
      ,antecedentes_personal_txt='$antecedentes_personal_txt',antecedentes_familiares_text= '$antecedentes_familiares_text',revision_organos_sistemas= '$revision_organos_sistemas',examen_fisico_regional= '$examen_fisico_regional'
      ,idanam = '$id_generacion',rolanam= '$rol_salida'
        WHERE codigo_unico = '$codigo_unico' AND iduser = '$iduser' ");



          if ($query_update_anamnesis) {

            $arrayName = array('noticia' =>'insert_anamesis');
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }else {

            $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
    }


    if ($_POST['action'] == 'agregar_receta') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);
      $codigo_unico   =  mysqli_real_escape_string($conection,$_POST['codigo_unico']);


      $presuntivo_checked      = (isset($_REQUEST['presuntivo_checked'])) ? $_REQUEST['presuntivo_checked'] : '';
      $definitivo_checked       = (isset($_REQUEST['definitivo_checked'])) ? $_REQUEST['definitivo_checked'] : '';
      $presuntivo_id        =  $_POST['presuntivo_id'];
      $definitivo_id        =  $_POST['definitivo_id'];
      $cantidad             =  $_POST['cantidad'];
      $dosis                =  $_POST['dosis'];
      $frecuencia           =  $_POST['frecuencia'];
      $duracion             =  $_POST['duracion'];
      $observacion          =  $_POST['observacion'];
      $farmaco              =  $_POST['farmaco'];



      // Agrupación de datos
      $definitivo = [];
      foreach ($definitivo_id as $index => $id) {
          $definitivo[] = [
              'checked' => isset($definitivo_checked[$index]) ? $definitivo_checked[$index] : 'off',
              'id' => $id
          ];
      }

      $presuntivo = [];
      foreach ($presuntivo_id as $index => $id) {
          $presuntivo[] = [
              'checked' => isset($presuntivo_checked[$index]) ? $presuntivo_checked[$index] : 'off',
              'id' => $id
          ];
      }

      $medicamentos = [];
      for ($i = 0; $i < count($farmaco); $i++) {
          $medicamentos[] = [
              'farmaco' => $farmaco[$i],
              'cantidad' => isset($cantidad[$i]) ? $cantidad[$i] : '',
              'dosis' => isset($dosis[$i]) ? $dosis[$i] : '',
              'frecuencia' => isset($frecuencia[$i]) ? $frecuencia[$i] : '',
              'duracion' => isset($duracion[$i]) ? $duracion[$i] : '',
              'observacion' => isset($observacion[$i]) ? $observacion[$i] : ''
          ];
      }

      $definitivo_json = json_encode($definitivo);
      $presuntivo_json = json_encode($presuntivo);
      $medicamentos_json = json_encode($medicamentos);



      $query_update_anamnesis = mysqli_query($conection,"UPDATE consultas_medicas SET definitivo= '$definitivo_json',presuntivo= '$presuntivo_json'
        ,medicamentos='$medicamentos_json',idreceta = '$id_generacion',rolreceta= '$rol_salida',estado='FINALIZADO'
          WHERE codigo_unico = '$codigo_unico' AND iduser = '$iduser' ");

          if ($query_update_anamnesis) {
            // AQUI VAMOS A GENERAR EL PDF A FIRMAR Y A GUARDAR
            $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;


            $html=file_get_contents("$url2/home/medico/receta.php?iduser=$iduser&codigo_unico=$codigo_unico");

            // Instanciamos un objeto de la clase DOMPDF.
            $options = new Options();
            $options  -> set('isRemoteEnabled', TRUE);
            // Instanciamos un objeto de la clase DOMPDF.
            $pdf = new DOMPDF($options);
            // Definimos el tamaño y orientación del papel que queremos.
            $pdf->set_paper("letter", "landscape");
            //$pdf->set_paper(array(0,0,104,250));ntenido HTML.
            $pdf->load_html($html,'UTF-8');
            $pdf->setPaper('A4', 'landscape');
            // Renderizamos el documento PDF.
            $pdf->render();
            $archivo = '../medico/recetas/receta_'.$codigo_unico.'.pdf';
            file_put_contents($archivo, $pdf->output());


            $query_correo_registro= mysqli_query($conection, "SELECT * FROM credenciales_correos  WHERE area = 'registro'");
            $data_correo_registro = mysqli_fetch_array($query_correo_registro);

            $Host_registro        = $data_correo_registro['Host'];
            $Username_registro    = $data_correo_registro['Username'];
            $Password_registro    = $data_correo_registro['Password'];
            $Port_registro        = $data_correo_registro['Port'];
            $SMTPSecure_registro  = $data_correo_registro['SMTPSecure'];

            try {


                  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;


                  $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
                  $result_documentos = mysqli_fetch_array($query_doccumentos);
                  $regimen = $result_documentos['regimen'];
                  $contabilidad             = $result_documentos['contabilidad'];
                  $email_empresa_emisor     = $result_documentos['email'];
                  $celular_empresa_emisor   = $result_documentos['celular'];
                  $telefono_empresa_emisor  = $result_documentos['telefono'];
                  $direccion_emisor          = $result_documentos['direccion'];
                  $whatsapp                 = $result_documentos['whatsapp'];
                  $nombres_user                  = $result_documentos['nombres'];
                  $apellidos                = $result_documentos['apellidos'];
                  $numero_identificacion_emisor  = $result_documentos['numero_identidad'];
                  $contribuyente_especial   = $result_documentos['contribuyente_especial'];
                  $estableciminento_f      = $result_documentos['estableciminento_f'];
                  $contabilidad            = $result_documentos['contabilidad'];
                  $punto_emision_f         = $result_documentos['punto_emision_f'];
                  $img_facturacion         = $result_documentos['img_facturacion'];
                  $contabilidad         = $result_documentos['contabilidad'];
                  $regimen         = $result_documentos['regimen'];
                  $url_img_upload                     = $result_documentos['url_img_upload'];

                  $nombre_empresa               = $result_documentos['nombre_empresa'];


             $filex = '../medico/recetas/receta_'.$codigo_unico.'.pdf';

             $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
             $mail -> isSMTP ();                                          // Enviar usando SMTP
             $mail -> Host        = "$Host_registro" ;                  // Configure el servidor SMTP para enviar a través de
             $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
             $mail->Username = "$Username_registro";
             $mail->Password = "$Password_registro";                              // Contraseña SMTP
             $mail -> SMTPSecure = "$SMTPSecure_registro";         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
             $mail->Port = "$Port_registro";                            // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba
             // Destinatarios
             $mail -> setFrom ( $Username_registro , 'Rezeta' );
             $mail -> addAddress ($email_empresa_emisor);
             $mail -> addAddress ('alejiss401997@gmail.com');  // Agrega un destinatario

             $query__correos_email = mysqli_query($conection, "SELECT *  FROM farmacias_guibis
                WHERE farmacias_guibis.iduser ='$iduser'  AND farmacias_guibis.estatus = '1' ");
              $result__email= mysqli_num_rows($query__correos_email);
             if ($result__email > 0) {
                   while ($data_email=mysqli_fetch_array($query__correos_email)) {
                     $mail->addAddress($data_email['email']);
                   }
                 }
             // Contenido
             $mail->isHTML(true);

             $mail->AddAttachment($filex, ''.$codigo_unico.'.pdf');
             $mail->CharSet = 'UTF-8'; // Establecer el formato de correo electrónico en HTML
             $mail->Subject = 'Solicitud de Receta';
             $mail->Body = '
             <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
                 <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                     <div class="logo-empresa" style="text-align: center;">
                         <img src="' . $url . '/img/guibis.png" alt="Logo de la Empresa" style="width: 200px;">
                     </div>
                     <div class="contenedor-informacion" style="text-align: justify;">
                         <p>Se ha generado una proforma en automático.</p>
                         <p>Con aprecio,<br>El Equipo de '.$nombre_empresa.'</p>
                     </div>
                 </div>
             </body>
             ';
                     if (!$mail->send()) {
                         // Manejo del caso de fallo en el envío
                         $response = array('noticia_email' => 'error_envio','noticia' =>'insert_receta','codigo_unico' => $codigo_unico);
                         echo json_encode($response, JSON_UNESCAPED_UNICODE);
                     } else {
                         // Manejo del caso de éxito en el envío
                         $response = array('noticia_email' => 'envio_exitoso','noticia' =>'insert_receta','codigo_unico' => $codigo_unico);
                         echo json_encode($response, JSON_UNESCAPED_UNICODE);
                     }
                 } catch (Exception $e) {
                     // Manejo de una excepción durante la configuración o el envío
                     $response = array('codigo_unico' => $codigo_unico,'noticia_email' => 'error_excepcion','noticia' =>'insert_receta','detalle' => 'Ocurrió un error al intentar enviar el correo','error' => $e->getMessage());
                     echo json_encode($response, JSON_UNESCAPED_UNICODE);
                 }


          }else {

            $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }


    }


    if ($_POST['action'] == 'ingresar_documento') {

      $paciente       =  mysqli_real_escape_string($conection,$_POST['paciente']);
      $codigo_unico   =  mysqli_real_escape_string($conection,$_POST['codigo_unico']);


      $dias_descanso       =  mysqli_real_escape_string($conection,$_POST['dias_descanso']);
      $entidad             =  mysqli_real_escape_string($conection,$_POST['entidad']);
      $contingencia        =  mysqli_real_escape_string($conection,$_POST['contingencia']);
      $actividad           =  mysqli_real_escape_string($conection,$_POST['actividad']);
      $diagnostico         =  mysqli_real_escape_string($conection,$_POST['diagnostico']);
      $observacion_descanso   =  mysqli_real_escape_string($conection,$_POST['observacion_descanso']);
      $solicitud_revision     =  mysqli_real_escape_string($conection,$_POST['solicitud_revision']);
      $autorizacion_imagenes  =  mysqli_real_escape_string($conection,$_POST['autorizacion_imagenes']);
      $autorizacion_laboratorio =  mysqli_real_escape_string($conection,$_POST['autorizacion_laboratorio']);
      $interconsulta       =  mysqli_real_escape_string($conection,$_POST['interconsulta']);
      $proc_interconsulta  =  mysqli_real_escape_string($conection,$_POST['proc_interconsulta']);
      $motivo_documento    =  mysqli_real_escape_string($conection,$_POST['motivo_documento']);


      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

      if (!empty($_FILES['pdf']['name'])) {
        $pdf           =    $_FILES['pdf'];
        $nombre        =    $pdf['name'];
        $type 					 =    $pdf['type'];
        $url_temp_2       =    $pdf['tmp_name'];
        $extension = pathinfo($nombre, PATHINFO_EXTENSION);
        $destino = '../archivos/documentos/';
        $documento = 'documentos_consulta_guibis'.md5(date('d-m-Y H:m:s').$iduser);
        $documento = $documento.'.'.$extension;
        $src_2 = $destino.$documento;
        move_uploaded_file($url_temp_2,$src_2);
      }else {
        $documento ='';
      }

      $query_update_ingresar_documento = mysqli_query($conection,"UPDATE consultas_medicas SET dias_descanso= '$dias_descanso',entidad= '$entidad'
        ,contingencia='$contingencia',actividad= '$actividad',diagnostico= '$diagnostico',observacion_descanso= '$observacion_descanso'
        ,solicitud_revision= '$solicitud_revision',autorizacion_imagenes= '$autorizacion_imagenes'
          ,autorizacion_laboratorio='$autorizacion_laboratorio',interconsulta= '$interconsulta',proc_interconsulta= '$proc_interconsulta',motivo_documento= '$motivo_documento'
          ,url_documento= '$url',documento= '$documento',iddocumento = '$id_generacion',roldocumento= '$rol_salida'
          WHERE codigo_unico = '$codigo_unico' AND iduser = '$iduser' ");



            if ($query_update_ingresar_documento) {

              // AQUI VAMOS A GENERAR EL PDF A FIRMAR Y A GUARDAR
              $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;



              $html=file_get_contents("$url2/home/medico/certificado.php?iduser=$iduser&codigo_unico=$codigo_unico");

              // Instanciamos un objeto de la clase DOMPDF.
              $options = new Options();
              $options  -> set('isRemoteEnabled', TRUE);
              // Instanciamos un objeto de la clase DOMPDF.
              $pdf = new DOMPDF($options);
              // Definimos el tamaño y orientación del papel que queremos.
              $pdf->set_paper("letter", "portrait");
              //$pdf->set_paper(array(0,0,104,250));ntenido HTML.
              $pdf->load_html($html,'UTF-8');
              $pdf->setPaper('A4', 'portrait');
              // Renderizamos el documento PDF.
              $pdf->render();
              $archivo = '../medico/certificados/certificado_'.$codigo_unico.'.pdf';
              file_put_contents($archivo, $pdf->output());

              $arrayName = array('noticia' =>'insert_documento','codigo_unico' => $codigo_unico);
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }else {

              $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }


      // code...
    }
 ?>
