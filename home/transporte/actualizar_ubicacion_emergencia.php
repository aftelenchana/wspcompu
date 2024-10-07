<?php
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


session_start();

if ($_SESSION['rol'] == 'cuenta_empresa') {

  $rol_salida = $_SESSION['rol'];
include "../sessiones/session_cuenta_empresa.php";

}

if ($_SESSION['rol'] == 'Recursos Humanos') {
  $rol_salida = $_SESSION['rol_interno'];
include "../sessiones/session_recursos_humanos.php";

}

if ($_POST['action'] == 'actualizar_ubicacion_tiempo_real_emergencia') {


  $latitud    = $_POST['latitud'];
  $longitud    = $_POST['longitud'];


  $query_agregar_ubicacion = mysqli_query($conection,"UPDATE recursos_humanos SET longitud= '$longitud',latitud= '$latitud'  WHERE id = '$idrecursos_humanos' ");



  if ($query_agregar_ubicacion) {
    echo "se actualiza la ubicacion del de emergencia en tiempo real";
    // code...
  }else {
    echo "Error en la actualizacion de ubicacion";
  }


}




 ?>
