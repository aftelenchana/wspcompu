<?php
include("conexion.php");
$eliminar = mysqli_query($con,"TRUNCATE TABLE acceso");
if (!$eliminar) {
	echo 'Error al Borrar los Registros';
}else{
	header("Location: ../../registro.php");
}
?>