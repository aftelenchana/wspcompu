<?php

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
$mail = new  PHPMailer ( true );
    include "../../coneccion.php";
      mysqli_set_charset($conection, 'utf8'); //linea a colocar
         session_start();
         $iduser= $_SESSION['id'];
         $query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.mi_leben FROM usuarios WHERE usuarios.id = $iduser");
         $result = mysqli_fetch_array($query);
         $email_usuario = $result['email'];
         $email = $result['email'];
         $nombres = $result['nombres'];
         $apellidos = $result['apellidos'];
         $mi_leben = $result['mi_leben'];

    //print_r($_POST);
    if (!empty($_POST)) {
      if ($_POST['action'] == 'infoUsuario') {
        $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
        mysqli_close($conection);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

        }
      }


      if ($_POST['action'] == 'add_foto_perfil') {
      echo "Vamos a insertar la foto";
      }








      if ($_POST['action'] == 'infoplan') {

        $query=mysqli_query($conection,"SELECT *FROM  notificaciones WHERE  usuario= $iduser  ORDER BY fecha_inicio DESC ");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else {
          $arrayName = array('sinplan' =>'Usted no tiene ningun plan');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }



      }

      if ($_POST['action'] == 'add_fecha_nacimiento') {
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET fecha='$fecha_nacimiento' WHERE id='$iduser' ");
        $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                      VALUES('fecha nacimiento','$fecha_nacimiento','$iduser') ");


        if ($query_insert) {
           $arrayName = array('fecha_nacimiento' =>$fecha_nacimiento);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
          $arrayName = array('error' =>'error_insertar_fecha');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

      }


      if ($_POST['action'] == 'editt_password') {
        $actual_password = md5($_POST['actual_password']);
        $new_password = md5($_POST['new_password']);
        $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
        $result = mysqli_fetch_array($query);
        $password_bd =  $result['password'];

        if ($actual_password == $password_bd ) {
          $query_insert=mysqli_query($conection,"UPDATE usuarios SET password='$new_password' WHERE id='$iduser' ");
          $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                        VALUES('password','$new_password','$iduser') ");


          if ($query_insert) {
             $arrayName = array('resp_password' =>'positiva');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            //Aqui va para enviar el correo de actualizacion de contrasena


            try {
                 // Configuración del servidor
                 $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                 $mail -> isSMTP ();                                          // Enviar usando SMTP
                 $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                 $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                 $mail ->Username = 'guibis-ecuador@guibis.com' ;                         // Nombrede usuario SMTP
                 $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                 $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                 $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                // Destinatarios
                $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                $mail -> addAddress ('guibis-ecuador@guibis.com');
                $mail -> addAddress ($email_usuario);
                    // Agrega un destinatario


                // Contenido
                $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                $mail->CharSet = 'UTF-8';
                $mail -> Subject = 'Cambio de Contraseña' ;
                $mail -> Body     = '    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                    <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Bienvenido a Guibis.com '.$nombres.' '.$apellidos.'</h3>
                    <p style="font-weight: bold; font-style: italic;" >Una experiencia de comprar y vender de una manera segura</p>
                    <p>Estamos comprometidos contigo y te mostramos las lineas directas para cuelquier inquietud</p>
                    <h3>Se ha cambiado tu contraseña en nuestro sitio si tu no fuiste, comunicate a nuestras lineas directas </h3>
                    <p>Celular: 0998855160</p>
                    <p>Telefono: 032436519</p>
                    <p>Correo:soporte@guibis.com </p>
                    <div style="border-color: #fff;border-width: 1px;
                border-style: solid;
                border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                <a style="color:#fff;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                    </div>
                  <br>



                    </div>' ;

                $mail -> send ();
            } catch ( Exception  $e ) {
            }




          }else {
            $arrayName = array('resp_password' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
        }else {
          $arrayName = array('resp_password' =>'contrasena_incorrecta');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

      }


      if ($_POST['action'] == 'addinstagram') {
        $instagram = $_POST['instagram'];
        $instagram_sin_espacios = trim($instagram);
        $instagram_number = str_split($instagram_sin_espacios);
        $instagram_array = count($instagram_number);
        if ($instagram_array > 24) {
          $A0 = $instagram_number[0];
          $A1 = $instagram_number[1];
          $A2 = $instagram_number[2];
          $A3 = $instagram_number[3];
          $A4 = $instagram_number[4];
          $A5 = $instagram_number[5];
          $A6 = $instagram_number[6];
          $A7 = $instagram_number[7];
          $A8 = $instagram_number[8];
          $A9 = $instagram_number[9];
          $A10 = $instagram_number[10];
          $A11 = $instagram_number[11];
          $A12 = $instagram_number[12];
          $A13 = $instagram_number[13];
          $A14 = $instagram_number[14];
          $A15 = $instagram_number[15];
          $A16 = $instagram_number[16];
          $A17 = $instagram_number[17];
          $A18 = $instagram_number[18];
          $A19 = $instagram_number[19];
          $A20 = $instagram_number[20];
          $A21 = $instagram_number[21];
          $A22 = $instagram_number[22];
          $A23 = $instagram_number[23];
          $A24 = $instagram_number[24];
          if ($A0== 'h' && $A1 == 't' && $A2 == 't' && $A3 == 'p' && $A4 == 's' && $A12 == 'i' && $A13 == 'n' && $A14 == 's' && $A15 == 't' &&  $A16 == 'a' && $A17 == 'g' && $A18 == 'r' && $A19 == 'a'  && $A20 == 'm' && $A22 == 'c' && $A23 == 'o' && $A24 == 'm') {
            $query_insert=mysqli_query($conection,"UPDATE usuarios SET instagram='$instagram' WHERE id='$iduser' ");
            if ($query_insert) {
              $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                            VALUES('instagram','$instagram','$iduser') ");


               $arrayName = array('instagram' =>$instagram);
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

            }else {
              $arrayName = array('Error' =>'Error al Insertar');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
          }else {
            $arrayName = array('Error' =>'Ingrese una direccion Valida');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }

        }else {
          $arrayName = array('Error' =>'Su enlace es muy pequeño');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
        mysqli_close($conection);


      }




      if ($_POST['action'] == 'editt_nombre') {
        if ($mi_leben == 'Activa') {
          $arrayName = array('noticia' =>'cuenta_activa_leben');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          // code...
          $editt_nombre = $_POST['editt_nombre'];
          $query_insert=mysqli_query($conection,"UPDATE usuarios SET nombres='$editt_nombre' WHERE id='$iduser' ");
          if ($query_insert) {
            $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                          VALUES('nombres','$editt_nombre','$iduser') ");


            $arrayName = array('noticia' => 'editado_correctamente','nombres' =>$editt_nombre);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

          }else {
            $arrayName = array('noticia' => 'Error al editar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
          mysqli_close($conection);
        }



      }
      //Para cambiar el apellido
      if ($_POST['action'] == 'editt_Apellido') {
        if ($mi_leben == 'Activa') {
          $arrayName = array('noticia' =>'cuenta_activa_leben');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }else {
         // code...
         $editt_apellido = $_POST['editt_apellido'];
         $query_insert=mysqli_query($conection,"UPDATE usuarios SET apellidos='$editt_apellido' WHERE id='$iduser' ");
         if ($query_insert) {
           $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                         VALUES('apellidos','$editt_apellido','$iduser') ");

           $arrayName = array('noticia' => 'Editado_correctamente','editt_apellido' =>$editt_apellido);
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

         }else {
           $arrayName = array('noticia' => 'Error al editar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
         mysqli_close($conection);
       }


      }

      //Para cambiar el email
      if ($_POST['action'] == 'editt_email') {
        $email = $_POST['editt_email'];
        $password = md5($_POST['password']);

        $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
        $result_password = mysqli_fetch_array($query_passsword);
        $password_bd =  $result_password['password'];
        if ($password == $password_bd) {
        $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE (email='$email')");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
          $arrayName = array('Error' =>'email_existente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
             $sql_update= mysqli_query($conection,"UPDATE usuarios SET email='$email' WHERE id='$iduser' ");
             $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                           VALUES('email','$email','$iduser') ");

           if ($sql_update) {
             $arrayName = array('email' =>$email);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        try {
                             // Configuración del servidor
                            $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                            $mail -> isSMTP ();                                          // Enviar usando SMTP
                            $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                            $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                            $mail ->Username = 'guibis-ecuador@guibis.com' ;                 // Nombrede usuario SMTP
                            $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                            $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                            $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                            // Destinatarios
                            $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                            $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                            $mail -> addAddress ( $email);



                            // Contenido
                            $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                            $mail -> Subject = 'Cambio de email' ;
                            $mail -> Body     = '    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Bienvenido a Guibis.com '.$nombres.' '.$apellidos.'</h3>
                                <p style="font-weight: bold; font-style: italic;" >Una experiencia de comprar y vender de una manera segura</p>
                                <p>Estamos comprometidos contigo y te mostramos las lineas directas para cuelquier inquietud</p>
                                <h3>Se ha cambiado tu email con quien inicias sesion en nuestro sitio si tu no fuiste, comunicate a nuestras lineas directas </h3>
                                <p>Celular: 0998855160</p>
                                <p>Telefono: 032436519</p>
                                <p>Correo:soporte@guibis.com </p>
                                <div style="border-color: #fff;border-width: 1px;
                            border-style: solid;
                            border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                            <a style="color:#fff;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                </div>
                              <br>



                                </div>' ;

                            $mail -> send ();
                        } catch ( Exception  $e ) {
                        }




           }else {
             $arrayName = array('Error' =>'Error al insertar el Correo');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

           }
        }

      }else {
        $arrayName = array('Error' =>'password_incorrect');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }

    }




      if ($_POST['action'] == 'editt_add_ruc') {
        $ruc = $_POST['editt_add_ruc'];
        $query_insert=mysqli_query($conection,"UPDATE usuarios SET ruc='$ruc' WHERE id='$iduser' ");
        if ($query_insert) {
          $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                        VALUES('ruc','$ruc','$iduser') ");


           $arrayName = array('ruc' =>$ruc);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
          $arrayName = array('noticia' =>'error');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
        mysqli_close($conection);


      }




            if ($_POST['action'] == 'editt_add_direccion') {
              $direccion = $_POST['editt_add_direccion'];
              $query_insert=mysqli_query($conection,"UPDATE usuarios SET direccion='$direccion' WHERE id='$iduser' ");
              if ($query_insert) {
                $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                              VALUES('direccion','$direccion','$iduser') ");


                 $arrayName = array('direccion' =>$direccion);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

              }else {
                echo "Error al insertar ";
              }
              mysqli_close($conection);


            }


            if ($_POST['action'] == 'editt_add_paypal') {
              $password = md5($_POST['password']);
              $pay_pal = $_POST['editt_add_paypal'];
              $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
              $result_password = mysqli_fetch_array($query_passsword);
              $password_bd =  $result_password['password'];
              if ($password == $password_bd) {
                $query_insert=mysqli_query($conection,"UPDATE usuarios SET cuenta_paypal='$pay_pal' WHERE id='$iduser' ");
                if ($query_insert) {
                  $arrayName = array('pay_pal' =>$pay_pal);
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                               VALUES('cuenta_paypal','$pay_pal','$iduser') ");



                             try {
                                  // Configuración del servidor
                                 $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                 $mail -> isSMTP ();                                          // Enviar usando SMTP
                                 $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                 $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                 $mail ->Username = 'guibis-ecuador@guibis.com' ;                       // Nombrede usuario SMTP
                                 $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                 $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                 $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                 // Destinatarios
                                 $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                 $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                 $mail -> addAddress ( $email);


                                 // Contenido
                                 $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                 $mail -> Subject = 'Cuenta Pay-Pal' ;
                                 $mail -> Body     = '    <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                     <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Bienvenido a Guibis.com '.$nombres.' '.$apellidos.'</h3>
                                     <p style="font-weight: bold; font-style: italic;" >Una experiencia de comprar y vender de una manera segura</p>
                                     <p>Estamos comprometidos contigo y te mostramos las lineas directas para cuelquier inquietud</p>
                                     <h3>Se ha ingresado una cuenta Pay-Pal en nuestro sitio si tu no fuiste, comunicate a nuestras lineas directas </h3>
                                     <p>Celular: 0998855160</p>
                                     <p>Telefono: 032436519</p>
                                     <p>Correo:soporte@guibis.com </p>
                                     <div style="border-color: #fff;border-width: 1px;
                                 border-style: solid;
                                 border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                                       <a style="color:#fff;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                     </div>
                                   <br>



                                     </div>' ;

                                 $mail -> send ();
                             } catch ( Exception  $e ) {
                             }

                }else {
                  $arrayName = array('Error' =>'Error al insertar la Cuenta ');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }


              }else {
                $arrayName = array('Error' =>'La contraseña Ingresada es incorrecta');
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
              mysqli_close($conection);


            }



            if ($_POST['action'] == 'addFacebook') {
              $iduser= $_SESSION['id'];
              $facebook = $_POST['facebook'];
              $facebook_sin_espacios = trim($facebook);
              $facebook_number = str_split($facebook_sin_espacios);
              $facebook_array = count($facebook_number);
              if ($facebook_array > 23) {
                $A0 = $facebook_number[0];
                $A1 = $facebook_number[1];
                $A2 = $facebook_number[2];
                $A3 = $facebook_number[3];
                $A4 = $facebook_number[4];
                $A5 = $facebook_number[5];
                $A6 = $facebook_number[6];
                $A7 = $facebook_number[7];
                $A8 = $facebook_number[8];
                $A9 = $facebook_number[9];
                $A10 = $facebook_number[10];
                $A11 = $facebook_number[11];
                $A12 = $facebook_number[12];
                $A13 = $facebook_number[13];
                $A14 = $facebook_number[14];
                $A15 = $facebook_number[15];
                $A16 = $facebook_number[16];
                $A17 = $facebook_number[17];
                $A18 = $facebook_number[18];
                $A19 = $facebook_number[19];
                $A20 = $facebook_number[20];
                $A21 = $facebook_number[21];
                $A22 = $facebook_number[22];
                $A23 = $facebook_number[23];
                $A24 = $facebook_number[24];
                if ($A0== 'h' && $A1 == 't' && $A2 == 't' && $A3 == 'p' && $A4 == 's' && $A12 == 'f' && $A13 == 'a' && $A14 == 'c' && $A15 == 'e' &&  $A16 == 'b' && $A17 == 'o' && $A18 == 'o' && $A19 == 'k' && $A21 == 'c' && $A22 == 'o' && $A23 == 'm') {
                  $query_insert=mysqli_query($conection,"UPDATE usuarios SET facebook='$facebook' WHERE id='$iduser' ");
                  if ($query_insert) {
                    $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                  VALUES('facebook','$facebook','$iduser') ");


                     $arrayName = array('facebook' =>$facebook);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                  }else {
                    $arrayName = array('Error' =>'Error al Insertar');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }
                }else {
                  $arrayName = array('Error' =>'Ingrese una direccion Valida');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                }

              }else {
                $arrayName = array('Error' =>'Su enlace es muy pequeño');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }

              mysqli_close($conection);


            }

            if ($_POST['action'] == 'addwhatsapp') {
              $iduser= $_SESSION['id'];
              $whatsapp = $_POST['whatsapp'];
              $whatsapp2 = trim($whatsapp);
             $number = str_split($whatsapp2);
             $ejemplo = count($number);
             if ($ejemplo > 10) {
               $arrayName = array('Error' =>'el numero es mayor a 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 10){
               if ($number['0']==0) {
                 $_number_total= ['5','9','3',$number['1'],$number['2'],$number['3'],$number['4'],$number['5'],$number['6'],$number['7'],$number['8'],$number['9']];
                 $numero_guardar = implode('',$_number_total);
                 $query_insert=mysqli_query($conection,"UPDATE usuarios SET whatsapp='$numero_guardar' WHERE id='$iduser' ");
                 if ($query_insert) {
                   $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                 VALUES('whatsapp','$numero_guardar','$iduser') ");


                    $arrayName = array('whatsapp' =>$numero_guardar,'id'=>$iduser);
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                 }else {
                   $arrayName = array('Error' =>'Error al  insertar en la base de datos');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 }
               }else {
                 $arrayName = array('Error' =>'el primer digito tiene que ser cero');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               }


             }


             if ($ejemplo == 9) {
               $arrayName = array('Error' =>'El numero contiene 9 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

             }
             if ($ejemplo == 8) {
               $arrayName = array('Error' =>'El numero contiene 8 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 7) {
               $arrayName = array('Error' =>'El numero contiene 7 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 6) {
               $arrayName = array('Error' =>'El numero contiene 6 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 5) {
               $arrayName = array('Error' =>'El numero contiene 5 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 4) {
               $arrayName = array('Error' =>'El numero contiene 4 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 3) {
               $arrayName = array('Error' =>'El numero contiene 3 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 2) {
               $arrayName = array('Error' =>'El numero contiene 2 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 1) {
               $arrayName = array('Error' =>'El numero contiene 1 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 0) {
               $arrayName = array('Error' =>'El numero contiene 0 digitos, ingresa uno de 10 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }

            }




            if ($_POST['action'] == 'addtelefono') {
              $iduser= $_SESSION['id'];
              $telefono = $_POST['telefono'];
              $telefono2 = trim($telefono);
             $number = str_split($telefono2);
             $ejemplo = count($number);
             if ($ejemplo > 9) {
               $arrayName = array('Error' =>'el numero es mayor a 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 9){
               if ($number['0']==0) {
                 $sql_update2= mysqli_query($conection,"UPDATE usuarios SET celular='$telefono' WHERE id='$iduser' ");
                 if ($sql_update2) {
                   $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                 VALUES('celular','$telefono','$iduser') ");

                    $arrayName = array('telefono' =>$telefono);
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                 }else {
                   $arrayName = array('Error' =>'Error al  insertar en la base de datos');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 }
               }else {
                 $arrayName = array('Error' =>'el primer digito tiene que ser cero');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               }


             }

             if ($ejemplo == 8) {
               $arrayName = array('Error' =>'El numero contiene 8 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 7) {
               $arrayName = array('Error' =>'El numero contiene 7 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 6) {
               $arrayName = array('Error' =>'El numero contiene 6 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 5) {
               $arrayName = array('Error' =>'El numero contiene 5 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 4) {
               $arrayName = array('Error' =>'El numero contiene 4 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 3) {
               $arrayName = array('Error' =>'El numero contiene 3 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 2) {
               $arrayName = array('Error' =>'El numero contiene 2 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 1) {
               $arrayName = array('Error' =>'El numero contiene 1 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
             if ($ejemplo == 0) {
               $arrayName = array('Error' =>'El numero contiene 0 digitos, ingresa uno de 9 digitos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }

            }







            if ($_POST['action'] == 'addbanca_p') {
              $banca_p = $_POST['banca_p'];
              $password = md5($_POST['password']);
              $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
              $result_password = mysqli_fetch_array($query_passsword);
              $password_bd =  $result_password['password'];
              if ($password == $password_bd) {
                $query_insert=mysqli_query($conection,"UPDATE usuarios SET cuenta_bancaria='$banca_p' WHERE id='$iduser' ");

                 if ($query_insert) {
                   $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                 VALUES('cuenta_bancaria','$banca_p','$iduser') ");


                              try {
                                   // Configuración del servidor
                                  $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                  $mail -> isSMTP ();                                          // Enviar usando SMTP
                                  $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                  $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                  $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                  $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                  $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                  $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                  // Destinatarios
                                  $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                  $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                  $mail -> addAddress ( $email);
                                      // Agrega un destinatario


                                  // Contenido
                                  $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                    $mail->CharSet = 'UTF-8';
                                  $mail -> Subject = 'Cuenta Bancaria Pichicha Agregada' ;
                                  $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                  </div>
                                  <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                     <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                     <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Pichincha) en nuestra plataforma.</p>
                                     <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Pichincha)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                                     <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                                     <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                                     <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                                     <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                                     <div style="border-color: #fff;border-width: 1px;
                                  border-style: solid;
                                  border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                                  <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                     </div>
                                   <br>
                                     </div>
                                     <br>
                                     <div class="redes_email" style="text-align: center;">
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                                     </div>' ;

                                  $mail -> send ();
                              } catch ( Exception  $e ) {
                              }

                  $arrayName = array('banca_p' =>$banca_p,'noticia' =>'insert_correct');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                 }else {
                   $arrayName = array('noticia' =>'error_interno');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                 }
            }else {
              $arrayName = array('noticia' =>'password_incorrect');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
        }





/*Banco Guayaquil*/

            if ($_POST['action'] == 'add_banco_guayaquil') {
              $iduser= $_SESSION['id'];
              $banca_p = $_POST['banca_p'];
              $password = md5($_POST['password']);
              $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
              $result_password = mysqli_fetch_array($query_passsword);
              $password_bd =  $result_password['password'];
              if ($password == $password_bd) {
                $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_guayaquil ='$banca_p' WHERE id='$iduser' ");

                 if ($query_insert) {
                   $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                                 VALUES('banco_guayaquil','$banca_p','$iduser') ");


                              try {
                                   // Configuración del servidor
                                  $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                                  $mail -> isSMTP ();                                          // Enviar usando SMTP
                                  $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                                  $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                                  $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                                  $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                                  $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                                  $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                  // Destinatarios
                                  $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                                  $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                                  $mail -> addAddress ( $email);
                                      // Agrega un destinatario


                                  // Contenido
                                  $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                                    $mail->CharSet = 'UTF-8';
                                  $mail -> Subject = 'Cuenta Banco Guayaquil Agregada' ;
                                  $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                                    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                                  </div>
                                  <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                     <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                                     <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Guayaquil) en nuestra plataforma.</p>
                                     <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Guayaquil)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                                     <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                                     <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                                     <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                                     <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                                     <div style="border-color: #fff;border-width: 1px;
                                  border-style: solid;
                                  border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                                  <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                     </div>
                                   <br>
                                     </div>
                                     <br>
                                     <div class="redes_email" style="text-align: center;">
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                       <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                                     </div>' ;

                                  $mail -> send ();
                              } catch ( Exception  $e ) {
                              }

                  $arrayName = array('banca_p' =>$banca_p);
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                 }else {
                   $arrayName = array('noticia' =>'error_interno');
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                 }
            }else {
              $arrayName = array('noticia' =>'password_incorrect');
              echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            }
        }

/*Banco Produbanco*/
if ($_POST['action'] == 'add_banco_produbanco') {
  $iduser= $_SESSION['id'];
  $banca_p = $_POST['banca_p'];
  $password = md5($_POST['password']);
  $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
  $result_password = mysqli_fetch_array($query_passsword);
  $password_bd =  $result_password['password'];
  if ($password == $password_bd) {
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_produbanco ='$banca_p' WHERE id='$iduser' ");

     if ($query_insert) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('banco_produbanco','$banca_p','$iduser') ");


                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                      $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                      $mail -> addAddress ( $email);
                          // Agrega un destinatario


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                        $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cuenta Banco Produbanco Agregada' ;
                      $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                        <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                      </div>
                      <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                         <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                         <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Produbanco) en nuestra plataforma.</p>
                         <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Produbanco)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                         <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                         <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                         <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                         <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                         <div style="border-color: #fff;border-width: 1px;
                      border-style: solid;
                      border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                      <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                         </div>
                       <br>
                         </div>
                         <br>
                         <div class="redes_email" style="text-align: center;">
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                         </div>' ;

                      $mail -> send ();
                  } catch ( Exception  $e ) {
                  }

      $arrayName = array('banca_p' =>$banca_p);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }else {
       $arrayName = array('noticia' =>'error_interno');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
}else {
  $arrayName = array('noticia' =>'password_incorrect');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
}




/*Banco PACIFICO*/
if ($_POST['action'] == 'add_banco_pacifico') {
  $iduser= $_SESSION['id'];
  $banca_p = $_POST['banca_p'];
  $password = md5($_POST['password']);
  $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
  $result_password = mysqli_fetch_array($query_passsword);
  $password_bd =  $result_password['password'];
  if ($password == $password_bd) {
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET banco_pacifico ='$banca_p' WHERE id='$iduser' ");

     if ($query_insert) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('banco_pacifico','$banca_p','$iduser') ");


                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                      $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                      $mail -> addAddress ( $email);
                          // Agrega un destinatario


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                        $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cuenta Banco Pacifico Agregada' ;
                      $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                        <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                      </div>
                      <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                         <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                         <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Pacifico) en nuestra plataforma.</p>
                         <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Pacifico)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                         <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                         <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                         <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                         <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                         <div style="border-color: #fff;border-width: 1px;
                      border-style: solid;
                      border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                      <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                         </div>
                       <br>
                         </div>
                         <br>
                         <div class="redes_email" style="text-align: center;">
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                         </div>' ;

                      $mail -> send ();
                  } catch ( Exception  $e ) {
                  }

      $arrayName = array('banca_p' =>$banca_p);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }else {
       $arrayName = array('noticia' =>'error_interno');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
}else {
  $arrayName = array('noticia' =>'password_incorrect');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
}



/*Banco CCA*/
if ($_POST['action'] == 'add_cca') {
  $iduser= $_SESSION['id'];
  $banca_p = $_POST['banca_p'];
  $password = md5($_POST['password']);
  $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
  $result_password = mysqli_fetch_array($query_passsword);
  $password_bd =  $result_password['password'];
  if ($password == $password_bd) {
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET camara_comercio_ambato ='$banca_p' WHERE id='$iduser' ");

     if ($query_insert) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('camara_comercio_ambato','$banca_p','$iduser') ");


                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                      $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                      $mail -> addAddress ( $email);
                          // Agrega un destinatario


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                        $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cuenta Banco CCA Agregada' ;
                      $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                        <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                      </div>
                      <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                         <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                         <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (CCA) en nuestra plataforma.</p>
                         <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (CCA)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                         <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                         <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                         <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                         <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                         <div style="border-color: #fff;border-width: 1px;
                      border-style: solid;
                      border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                      <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                         </div>
                       <br>
                         </div>
                         <br>
                         <div class="redes_email" style="text-align: center;">
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                         </div>' ;

                      $mail -> send ();
                  } catch ( Exception  $e ) {
                  }

      $arrayName = array('banca_p' =>$banca_p);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }else {
       $arrayName = array('noticia' =>'error_interno');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
}else {
  $arrayName = array('noticia' =>'password_incorrect');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
}



/*Banco mushuc*/
if ($_POST['action'] == 'add_banco_mushuc') {
  $iduser= $_SESSION['id'];
  $banca_p = $_POST['banca_p'];
  $password = md5($_POST['password']);
  $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
  $result_password = mysqli_fetch_array($query_passsword);
  $password_bd =  $result_password['password'];
  if ($password == $password_bd) {
    $query_insert=mysqli_query($conection,"UPDATE usuarios SET mushuc_runa ='$banca_p' WHERE id='$iduser' ");

     if ($query_insert) {
       $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                     VALUES('mushuc_runa','$banca_p','$iduser') ");


                  try {
                       // Configuración del servidor
                      $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                      $mail -> isSMTP ();                                          // Enviar usando SMTP
                      $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                      $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                      $mail ->Username = 'guibis-ecuador@guibis.com' ;                      // Nombrede usuario SMTP
                      $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                      $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                      $mail -> Port        = 465 ;                                    // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                      // Destinatarios
                      $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                      $mail -> addAddress ('guibis-ecuador@guibis.com');   // Agrega un destinatario
                      $mail -> addAddress ( $email);
                          // Agrega un destinatario


                      // Contenido
                      $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                        $mail->CharSet = 'UTF-8';
                      $mail -> Subject = 'Cuenta Banco Mushuc Runa Agregada' ;
                      $mail -> Body     = '<div class="img_logo" style="text-align: center;  background:">
                        <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >

                      </div>
                      <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                         <h3 style="text-align:center; color:#fff;   font-size: 33px; margin:0; padding:0;">Hola '.$nombres.' '.$apellidos.'</h3>
                         <p style="font-weight: bold; font-style: italic;" >Agregaste una cuenta Bancaria (Mushuc Runa) en nuestra plataforma.</p>
                         <p style="text-align: justify; width: 85%; margin: 0 auto;border-color: #fff;border-width: 1px; border-style: solid; border-radius: 9px;padding:20px;">Se ha agregado una Cuenta Bancaria (Mushuc Runa)  a nuestro sitio, ahora puedes realizar retiros directos a la cuenta agregada, te recordamos que los retiros son verificados en el caso de que el titular de la cuenta Bancaria no sea el mismo que el titular en nuestra plataforma el proceso de retiro no se realizara. </p>
                         <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                         <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                         <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                         <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                         <div style="border-color: #fff;border-width: 1px;
                      border-style: solid;
                      border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                      <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                         </div>
                       <br>
                         </div>
                         <br>
                         <div class="redes_email" style="text-align: center;">
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                           <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                         </div>' ;

                      $mail -> send ();
                  } catch ( Exception  $e ) {
                  }

      $arrayName = array('banca_p' =>$banca_p);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


     }else {
       $arrayName = array('noticia' =>'error_interno');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }
}else {
  $arrayName = array('noticia' =>'password_incorrect');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
}
}


            if ($_POST['action'] == 'editt_nombre_empresa') {
              $iduser= $_SESSION['id'];
              $nombre_empresa = $_POST['editt_nombre_empresa'];
              $query_insert=mysqli_query($conection,"UPDATE usuarios SET nombre_empresa='$nombre_empresa' WHERE id='$iduser' ");
              if ($query_insert) {
                $query_cambio=mysqli_query($conection,"INSERT INTO historial_cambios(campo,contenido,idusuario)
                                              VALUES('nombre_empresa','$nombre_empresa','$iduser') ");

                 $arrayName = array('nombre_empresa' =>$nombre_empresa);
                echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

              }else {
                echo "Error al insertar ";
              }
              mysqli_close($conection);


            }





      // code...
    }


 ?>
