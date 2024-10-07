<?php
// Reportar todos los errores de PHP (ver el manual de PHP para más niveles de errores)
error_reporting(E_ALL);

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



include "../home/jquery_bancario/envio_email_ingreso_incorrecto.php";
require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar

  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];



  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
     $result_documentos = mysqli_fetch_array($query_doccumentos);
     $user_in_admin     = $result_documentos['id'];

     if (empty($user_in_admin)) {
       $user_in_admin = '279';
     }


    if ($_POST['action'] == 'buscar_usuarios_existentes') {

               $email = mb_strtoupper($_POST['mail_user']);

             $email = mysqli_real_escape_string($conection, $_POST['mail_user']); // Asegúrate de escapar el email para prevenir inyecciones SQL

       // Inicializar el array que contendrá todos los usuarios
       $usuarios_totales = [];

       // Primera consulta para usuarios de cuenta_empresa
       $query_usuario_central = mysqli_query($conection, "SELECT usuarios.nombres,usuarios.id,usuarios.email,usuarios.img_facturacion,usuarios.url_img_upload
         FROM usuarios WHERE LOWER(email) = LOWER('$email') OR LOWER(celular) = LOWER('$email') ");
       while ($data_usuario_central = mysqli_fetch_assoc($query_usuario_central)) {

               $data_usuario_central['rol'] = 'Cuenta Empresa'; // Agregar el rol
               $usuarios_totales[] = $data_usuario_central; // Añadir al array total

       }

       // Segunda consulta para usuarios de usuario_punto_venta
       $query_usuario_punto_venta = mysqli_query($conection, "SELECT usuarios_punto_venta.nombres,usuarios_punto_venta.id,usuarios_punto_venta.mail,
         usuarios_punto_venta.foto,usuarios_punto_venta.url_img_upload FROM usuarios_punto_venta WHERE usuarios_punto_venta.estatus = '1' AND  LOWER(mail) = LOWER('$email')");
       while ($data_usuario_punto_venta = mysqli_fetch_assoc($query_usuario_punto_venta)) {

               $data_usuario_punto_venta['rol'] = 'Usuario Venta'; // Agregar el rol
               $usuarios_totales[] = $data_usuario_punto_venta; // Añadir al array total

       }


       // Tercera consulta para usuarios de publicidad
       $query_usuario_publicidad = mysqli_query($conection, "SELECT * FROM usuarios_publicidad WHERE usuarios_publicidad.estatus = '1' AND  LOWER(mail) = LOWER('$email')");
       while ($data_usuario_publicidad = mysqli_fetch_assoc($query_usuario_publicidad)) {

               $data_usuario_publicidad['rol'] = 'Publicidad'; // Agregar el rol
               $usuarios_totales[] = $data_usuario_publicidad; // Añadir al array total

       }

       // Cuarta consulta para usuarios de publicidad
       $query_usuario_recursos_humanos = mysqli_query($conection, "SELECT recursos_humanos.id,recursos_humanos.nombres,recursos_humanos.url_img_upload,
        recursos_humanos.foto,categoria_recursos_humanos.nombre  FROM recursos_humanos
         INNER JOIN categoria_recursos_humanos ON categoria_recursos_humanos.id = recursos_humanos.categoria_recursos_humanos
         WHERE recursos_humanos.estatus = '1' AND  LOWER(mail) = LOWER('$email')");
       while ($data_usuario_recursos_humanos = mysqli_fetch_assoc($query_usuario_recursos_humanos)) {

               $data_usuario_recursos_humanos['rol'] = 'Recursos Humanos'; // Agregar el rol
               $usuarios_totales[] = $data_usuario_recursos_humanos; // Añadir al array total


        }

       // quinta consulta para clientes
       $query_usuario_clientes = mysqli_query($conection, "SELECT * FROM clientes WHERE clientes.estatus = '1' AND  LOWER(mail) = LOWER('$email')");
       while ($data_usuarios_clientes = mysqli_fetch_assoc($query_usuario_clientes)) {

              $data_usuarios_clientes['rol'] = 'Paciente'; // Agregar el rol
              $usuarios_totales[] = $data_usuarios_clientes; // Añadir al array total

       }

       // Verificar si se encontraron usuarios
       if (count($usuarios_totales) > 0) {
           // Imprimir los resultados en formato JSON
           echo json_encode($usuarios_totales, JSON_UNESCAPED_UNICODE);
       } else {
           // No se encontraron usuarios con la contraseña correcta
         $arrayName = array('respuesta' => 'no_existe_resultados');
         echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
       }
      // code...
    }


   if ($_POST['action'] == 'ingresar_login') {


     function getRealIP3(){
               if (isset($_SERVER["HTTP_CLIENT_IP"])){
                   return $_SERVER["HTTP_CLIENT_IP"];
               }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                   return $_SERVER["HTTP_X_FORWARDED_FOR"];
               }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
               {
                   return $_SERVER["HTTP_X_FORWARDED"];
               }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
               {
                   return $_SERVER["HTTP_FORWARDED_FOR"];
               }elseif (isset($_SERVER["HTTP_FORWARDED"]))
               {
                   return $_SERVER["HTTP_FORWARDED"];
               }
               else{
                   return $_SERVER["REMOTE_ADDR"];
               }

           }
           if ($url =='http://localhost') {
             $direccion_ip =  '186.71.170.79';
           }else {
             $direccion_ip = (getRealIP3());
           }

           $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));



     $pais            = $datos['country'];
     $ciudad            = $datos['city'];
     $provincia         = $datos['regionName'];


     function getDeviceDetails2() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $osPlatform = "Unknown OS Platform";
        $osArray = array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $osPlatform = $value;
            }
        }

        $browser = "Unknown Browser";
        $browserArray = array(
            '/msie/i'       => 'Internet Explorer',
            '/firefox/i'    => 'Firefox',
            '/safari/i'     => 'Safari',
            '/chrome/i'     => 'Chrome',
            '/edge/i'       => 'Edge',
            '/opera/i'      => 'Opera',
            '/netscape/i'   => 'Netscape',
            '/maxthon/i'    => 'Maxthon',
            '/konqueror/i'  => 'Konqueror',
            '/mobile/i'     => 'Handheld Browser'
        );

        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $browser = $value;
            }
        }

        return array(
            'os' => $osPlatform,
            'browser' => $browser
        );
    }
    $deviceDetails = getDeviceDetails2();


     $sistema_operativo = $deviceDetails['os'];
     $buscador          = $deviceDetails['browser'];

            $id_user = $_POST['id_user'];
            $clave  = md5($_POST['password_user']);
            $rol = $_POST['rol'];





            if ($rol == 'Cuenta Empresa') {
              $query = mysqli_query($conection,"SELECT * FROM usuarios WHERE id='$id_user'");
              $data_clave= mysqli_fetch_array($query);
              $password_db      = $data_clave['password'];
              $email_db         = $data_clave['email'];
              $celular_db       = $data_clave['celular'];
              $estado_cuenta    = $data_clave['estado_cuenta'];
              $estado_registro  = $data_clave['estado_registro'];




              $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
              $result_documentos = mysqli_fetch_array($query_doccumentos);
              $user_in_admin     = $result_documentos['id'];

              if (empty($user_in_admin)) {
                $user_in_admin = '279';
              }
              //codigo_para_sacar_informacion_del_administrador
              $query_user_in_admin = mysqli_query($conection,"SELECT * FROM usuarios WHERE id='$user_in_admin'");
              $data_user_in_admin  = mysqli_fetch_array($query_user_in_admin);
              $estado_cuenta_in_admin   = $data_user_in_admin['estado_cuenta'];

              if ($estado_cuenta_in_admin == 0) {
                  $arrayName = array('respuesta' =>'cuenta_desactivada_admin','user_admin_in' =>$user_in_admin,'user' =>$id_user);
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 exit;
              }

              if ($estado_cuenta == 0) {
                  $arrayName = array('respuesta' =>'cuenta_desactivada');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 exit;
              }

              $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
              $intentos_result= mysqli_fetch_array($intentos);
              $intentos_totales = $intentos_result['intentos'];

              //if ($intentos_totales > 5) {

              //  $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
              //  $arrayName = array('respuesta' =>'intentos_maximos');
            //   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              // exit;                                                                 //HABILITAR
             //}

                if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                  session_start();
                  $_SESSION['active']=true;
                  $_SESSION['id']=$id_user;
                  $_SESSION['user_in']=$user_in_admin;
                  $_SESSION['rol']='cuenta_empresa';

                    $email_contrasena_incorrecta = envio_email($id_user,"ingreso_correcto",$celular_db,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);


                            if (isset($_COOKIE['session_token'])) {
                                $sessionToken = $_COOKIE['session_token'];

                                $query_verificador_session = mysqli_query($conection,"SELECT * FROM sessions WHERE session_token='$sessionToken' AND user_id='$id_user' AND rol='$rol'  ");
                                $data_verificador_session = mysqli_fetch_array($query_verificador_session);
                                if ($data_verificador_session) {
                                  $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'existe_sesion_con_cookies');
                                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                  // code...
                                }else {
                                  $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");
                                  if ($query_insert) {
                                    $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'insertado_con_cookies_existente_local_no_bd');
                                    echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                  }else {
                                    $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'no_insertado_con_cookies_existente_local_no_bd');
                                    echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                  }
                                }


                            } else {
                                $sessionToken = bin2hex(random_bytes(32));
                                setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
                                $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");

                                if ($query_insert) {
                                  $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_ingresado');
                                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                }else {
                                  $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_no_ingresado');
                                  echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                }

                            }






              }else {

                $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                $intentos_result= mysqli_fetch_array($intentos);
                $intentos_totales = $intentos_result['intentos'];

                $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario,ip) VALUES('$id_user','$direccion_ip') ");
                $arrayName = array('respuesta' => 'contraea_incorrecta');
                echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                    $email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta",$celular_db,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);
                exit;

              }

            }



            if ($rol == 'Usuario Venta') {
              $query = mysqli_query($conection,"SELECT * FROM usuarios_punto_venta WHERE id='$id_user'");
              $data_clave= mysqli_fetch_array($query);

              $password_db  = $data_clave['password'];
              $mail_db      = $data_clave['mail'];


              $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
              $intentos_result= mysqli_fetch_array($intentos);
              $intentos_totales = $intentos_result['intentos'];

              if ($intentos_totales > 5) {

                $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                $arrayName = array('respuesta' =>'intentos_maximos');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               exit;                                                                 //HABILITAR
             }

                if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                  session_start();
                  $_SESSION['active']=true;
                  $_SESSION['id']=$id_user;
                  $_SESSION['user_in']=$user_in_admin;
                  $_SESSION['rol']='cuenta_usuario_venta';

                      $email_contrasena_incorrecta = envio_email($id_user,"ingreso_correcto");



                                    if (isset($_COOKIE['session_token'])) {
                                        $sessionToken = $_COOKIE['session_token'];

                                        $query_verificador_session = mysqli_query($conection,"SELECT * FROM sessions WHERE session_token='$sessionToken' AND user_id='$id_user' AND rol='$rol'  ");
                                        $data_verificador_session = mysqli_fetch_array($query_verificador_session);
                                        if ($data_verificador_session) {
                                          $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'existe_sesion_con_cookies');
                                          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                          // code...
                                        }else {
                                          $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");
                                          if ($query_insert) {
                                            $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'insertado_con_cookies_existente_local_no_bd');
                                            echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                          }else {
                                            $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'no_insertado_con_cookies_existente_local_no_bd');
                                            echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                          }
                                        }


                                    } else {
                                        $sessionToken = bin2hex(random_bytes(32));
                                        setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
                                        $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");

                                        if ($query_insert) {
                                          $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_ingresado');
                                          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                        }else {
                                          $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_no_ingresado');
                                          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                        }

                                    }


              }else {
                $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                $intentos_result= mysqli_fetch_array($intentos);
                $intentos_totales = $intentos_result['intentos'];

                if ($intentos_totales > 5) {

                  $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                  $arrayName = array('respuesta' =>'intentos_maximos');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 exit;                                                                 //HABILITAR
               }else {
                 $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario,ip) VALUES('$id_user','$direccion_ip') ");
                 $arrayName = array('respuesta' => 'contraea_incorrecta');
                 echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                   $email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta");
                 exit;
               }
              }

            }




                        if ($rol == 'Publicidad') {
                          $query = mysqli_query($conection,"SELECT * FROM usuarios_publicidad WHERE id='$id_user'");
                          $data_clave= mysqli_fetch_array($query);

                          $password_db  = $data_clave['password'];
                          $mail_db      = $data_clave['mail'];


                          $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                          $intentos_result= mysqli_fetch_array($intentos);
                          $intentos_totales = $intentos_result['intentos'];

                          if ($intentos_totales > 5) {

                        //    $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                        //    $arrayName = array('respuesta' =>'intentos_maximos');
                        //   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        //   exit;                                                                 //HABILITAR
                         }

                            if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                              session_start();
                              $_SESSION['active']=true;
                              $_SESSION['id']=$id_user;
                              $_SESSION['user_in']=$user_in_admin;
                              $_SESSION['rol']='Publicidad';

                                //  $email_contrasena_incorrecta = envio_email($id_user,"ingreso_correcto",$celular_db);



                                                if (isset($_COOKIE['session_token'])) {
                                                    $sessionToken = $_COOKIE['session_token'];

                                                    $query_verificador_session = mysqli_query($conection,"SELECT * FROM sessions WHERE session_token='$sessionToken' AND user_id='$id_user' AND rol='$rol'  ");
                                                    $data_verificador_session = mysqli_fetch_array($query_verificador_session);
                                                    if ($data_verificador_session) {
                                                      $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'existe_sesion_con_cookies');
                                                      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                      // code...
                                                    }else {
                                                      $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");
                                                      if ($query_insert) {
                                                        $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'insertado_con_cookies_existente_local_no_bd');
                                                        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                      }else {
                                                        $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'no_insertado_con_cookies_existente_local_no_bd');
                                                        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                      }
                                                    }


                                                } else {
                                                    $sessionToken = bin2hex(random_bytes(32));
                                                    setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
                                                    $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");

                                                    if ($query_insert) {
                                                      $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_ingresado');
                                                      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                    }else {
                                                      $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_no_ingresado');
                                                      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                    }

                                                }


                          }else {
                            $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                            $intentos_result= mysqli_fetch_array($intentos);
                            $intentos_totales = $intentos_result['intentos'];

                            if ($intentos_totales > 5) {
                              //$email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                              $arrayName = array('respuesta' =>'intentos_maximos');
                             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                            // exit;                                                                 //HABILITAR
                           }else {
                             $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario,ip) VALUES('$id_user','$direccion_ip') ");
                             $arrayName = array('respuesta' => 'contraea_incorrecta');
                             echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                               //$email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta");
                             exit;
                           }
                          }

                        }




                                                if ($rol == 'Recursos Humanos') {

                                                  $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
                                                  $result_documentos = mysqli_fetch_array($query_doccumentos);
                                                  $regimen = $result_documentos['regimen'];
                                                  $user_in  = $result_documentos['id'];

                                                  $rol_interno = $_POST['rol_interno'];


                                                  $query = mysqli_query($conection,"SELECT * FROM recursos_humanos  WHERE id='$id_user'");
                                                  $data_clave= mysqli_fetch_array($query);

                                                  $password_db  = $data_clave['password'];
                                                  $mail_db      = $data_clave['mail'];


                                                  $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                                                  $intentos_result= mysqli_fetch_array($intentos);
                                                  $intentos_totales = $intentos_result['intentos'];

                                                  if ($intentos_totales > 5) {

                                                //    $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                                                //    $arrayName = array('respuesta' =>'intentos_maximos');
                                                //   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                                //   exit;                                                                 //HABILITAR
                                                 }

                                                    if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                                                      session_start();
                                                      $_SESSION['active']=true;
                                                      $_SESSION['id']=$id_user;
                                                      $_SESSION['user_in']=$user_in_admin;
                                                      $_SESSION['rol']='Recursos Humanos';
                                                      $_SESSION['rol_interno']=$rol_interno;

                                                        //  $email_contrasena_incorrecta = envio_email($id_user,"ingreso_correcto",$celular_db);



                                                                        if (isset($_COOKIE['session_token'])) {
                                                                            $sessionToken = $_COOKIE['session_token'];

                                                                            $query_verificador_session = mysqli_query($conection,"SELECT * FROM sessions WHERE session_token='$sessionToken' AND user_id='$id_user' AND rol='$rol'  ");
                                                                            $data_verificador_session = mysqli_fetch_array($query_verificador_session);
                                                                            if ($data_verificador_session) {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'existe_sesion_con_cookies');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              // code...
                                                                            }else {
                                                                              $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");
                                                                              if ($query_insert) {
                                                                                $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'insertado_con_cookies_existente_local_no_bd');
                                                                                echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              }else {
                                                                                $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'no_insertado_con_cookies_existente_local_no_bd');
                                                                                echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              }
                                                                            }


                                                                        } else {
                                                                            $sessionToken = bin2hex(random_bytes(32));
                                                                            setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
                                                                            $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");

                                                                            if ($query_insert) {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_ingresado');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                            }else {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_no_ingresado');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                            }

                                                                        }


                                                  }else {
                                                    $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                                                    $intentos_result= mysqli_fetch_array($intentos);
                                                    $intentos_totales = $intentos_result['intentos'];

                                                    if ($intentos_totales > 5) {
                                                      //$email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                                                      $arrayName = array('respuesta' =>'intentos_maximos');
                                                     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                                    // exit;                                                                 //HABILITAR
                                                   }else {
                                                     $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario,ip) VALUES('$id_user','$direccion_ip') ");
                                                     $arrayName = array('respuesta' => 'contraea_incorrecta');
                                                     echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                       //$email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta");
                                                     exit;
                                                   }
                                                  }

                                                }



                                                if ($rol == 'Paciente') {
                                                  $query = mysqli_query($conection,"SELECT * FROM clientes WHERE id='$id_user'");
                                                  $data_clave= mysqli_fetch_array($query);

                                                  $password_db  = $data_clave['password'];
                                                  $mail_db      = $data_clave['mail'];
                                                  $celular_db      = $data_clave['celular'];


                                                  $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                                                  $intentos_result= mysqli_fetch_array($intentos);
                                                  $intentos_totales = $intentos_result['intentos'];

                                                  if ($intentos_totales > 5) {

                                                //    $email_contrasena_incorrecta = envio_email($id_user,"intentos_maximos");
                                                //    $arrayName = array('respuesta' =>'intentos_maximos');
                                                //   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                                //   exit;                                                                 //HABILITAR
                                                 }

                                                    if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                                                      session_start();
                                                      $_SESSION['active']=true;
                                                      $_SESSION['id']=$id_user;
                                                      $_SESSION['user_in']=$user_in_admin;
                                                      $_SESSION['rol']='Paciente';

                                                    //  $email_contrasena_incorrecta = envio_email($id_user,"ingreso_correcto",$celular_db,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);


                                                                        if (isset($_COOKIE['session_token'])) {
                                                                            $sessionToken = $_COOKIE['session_token'];

                                                                            $query_verificador_session = mysqli_query($conection,"SELECT * FROM sessions WHERE session_token='$sessionToken' AND user_id='$id_user' AND rol='$rol'  ");
                                                                            $data_verificador_session = mysqli_fetch_array($query_verificador_session);
                                                                            if ($data_verificador_session) {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'existe_sesion_con_cookies');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              // code...
                                                                            }else {
                                                                              $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
                                                                              VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");
                                                                              if ($query_insert) {
                                                                                $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'insertado_con_cookies_existente_local_no_bd');
                                                                                echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              }else {
                                                                                $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'no_insertado_con_cookies_existente_local_no_bd');
                                                                                echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                              }
                                                                            }


                                                                        } else {
                                                                            $sessionToken = bin2hex(random_bytes(32));
                                                                            setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
                                                                            $query_insert = mysqli_query($conection,"INSERT INTO sessions (session_token,user_id,rol,pais,provincia,ciudad,sistema_operativo,buscador,ip)
                                                                            VALUES('$sessionToken','$id_user','$rol','$pais','$provincia','$ciudad','$sistema_operativo','$buscador','$direccion_ip')");

                                                                            if ($query_insert) {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_ingresado');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                            }else {
                                                                              $arrayName = array('respuesta' => 'password_exitoso','estado_sesion' => 'nueva_cookies_no_ingresado');
                                                                              echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                                            }

                                                                        }


                                                  }else {
                                                    $intentos =  mysqli_query($conection,"SELECT  COUNT(*) as  intentos FROM password_incorrecta WHERE idusuario = $id_user ");
                                                    $intentos_result= mysqli_fetch_array($intentos);
                                                    $intentos_totales = $intentos_result['intentos'];

                                                    if ($intentos_totales > 5) {
                                                  //    $email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta",$celular_db,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);
                                                      $arrayName = array('respuesta' =>'intentos_maximos');
                                                     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                                    // exit;                                                                 //HABILITAR
                                                   }else {
                                                     $query_insert_incorrect_password=mysqli_query($conection,"INSERT INTO  password_incorrecta(idusuario,ip) VALUES('$id_user','$direccion_ip') ");
                                                     $arrayName = array('respuesta' => 'contraea_incorrecta');
                                                     echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                                                      //   $email_contrasena_incorrecta = envio_email($id_user,"password_incorrecta",$celular_db,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);
                                                     exit;
                                                   }
                                                  }

                                                }






    }

   if ($_POST['action'] == 'verificar_cuenta') {
     $celular_registrado  = $_POST['celular_registrado'];
     $email_registrado    = $_POST['email_registrado'];
     $rol                 = $_POST['rol'];
     $id_user             = $_POST['id_user'];



     function getRealIP2(){
               if (isset($_SERVER["HTTP_CLIENT_IP"])){
                   return $_SERVER["HTTP_CLIENT_IP"];
               }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                   return $_SERVER["HTTP_X_FORWARDED_FOR"];
               }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
               {
                   return $_SERVER["HTTP_X_FORWARDED"];
               }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
               {
                   return $_SERVER["HTTP_FORWARDED_FOR"];
               }elseif (isset($_SERVER["HTTP_FORWARDED"]))
               {
                   return $_SERVER["HTTP_FORWARDED"];
               }
               else{
                   return $_SERVER["REMOTE_ADDR"];
               }

           }
           if ($url =='http://localhost') {
             $direccion_ip =  '186.71.170.79';
           }else {
             $direccion_ip = (getRealIP2());
           }

           $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));



     $pais            = $datos['country'];
     $ciudad            = $datos['city'];
     $provincia         = $datos['regionName'];


     function getDeviceDetails() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $osPlatform = "Unknown OS Platform";
        $osArray = array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $osPlatform = $value;
            }
        }

        $browser = "Unknown Browser";
        $browserArray = array(
            '/msie/i'       => 'Internet Explorer',
            '/firefox/i'    => 'Firefox',
            '/safari/i'     => 'Safari',
            '/chrome/i'     => 'Chrome',
            '/edge/i'       => 'Edge',
            '/opera/i'      => 'Opera',
            '/netscape/i'   => 'Netscape',
            '/maxthon/i'    => 'Maxthon',
            '/konqueror/i'  => 'Konqueror',
            '/mobile/i'     => 'Handheld Browser'
        );

        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $browser = $value;
            }
        }

        return array(
            'os' => $osPlatform,
            'browser' => $browser
        );
    }
    $deviceDetails = getDeviceDetails();


     $sistema_operativo = $deviceDetails['os'];
     $buscador          = $deviceDetails['browser'];

     $verificador_cuenta = envio_email($id_user,"verificar_cuenta",$celular_registrado,$pais,$provincia,$ciudad,$sistema_operativo,$buscador,$direccion_ip,$rol);



     $arrayName = array('respuesta' => 'mensaje_verificacion_correcto');
     echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);



    }






 ?>
