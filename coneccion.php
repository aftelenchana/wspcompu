<?php

$host='localhost';

$user='root';

$password='';

$db='wsp_compu';

$conection = @mysqli_connect($host,$user,$password,$db);

if (!$conection) {

  echo "Error en la coneccion";

}



 ?>
