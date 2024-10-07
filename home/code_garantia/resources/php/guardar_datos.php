<?php
include("conexion.php");
$codigo = $_POST["Codigo"];
$referencia = $_POST["Referencia"];
$insertar = "INSERT INTO acceso (codigo, referencia) VALUES ('$codigo', '$referencia')";
$resultado = mysqli_query($con, $insertar);
if (!$resultado) {
	echo 'Error al registrar';
}else{
	header("Location: ../../registro.php");
}
?>