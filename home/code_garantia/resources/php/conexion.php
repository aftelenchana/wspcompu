<?php
$host='localhost';
$user='guibisco_alex';
$password='MACAra666_';
$db='guibisco_gabriela';
$con = @mysqli_connect($host,$user,$password,$db);
if (!$con) {
  echo "Error en la coneccion";
}
?>
