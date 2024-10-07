<?php
include("resources/php/conexion.php");



$CodigoIngreso = $_REQUEST['codigo'];

$BuscarCodigo   = ("SELECT * FROM acceso WHERE codigo='".$CodigoIngreso."' LIMIT 1");
$resultado  = mysqli_query($con, $BuscarCodigo);
$cantidadExistente    = mysqli_num_rows($resultado);
$InfoCodigo 	  = mysqli_fetch_array($resultado);
echo "<br><br>";
$status ='Escaneado';
if (!empty($cantidadExistente)) {
if($InfoCodigo['status'] != $status){
$cambiarStatus = ("UPDATE acceso SET status ='" . $status . "'  WHERE codigo='".$CodigoIngreso."'");
$resStatu =    mysqli_query($con,$cambiarStatus);
$sql = ("SELECT * FROM acceso WHERE codigo='".$CodigoIngreso."' ");
$listado_clientes = mysqli_query($con, $sql);
include('salida_datos.php');
}else{ ?>
	<div class="mensaje_registro_existente">
       <p style="font-size: 25px;font-family: 'Varela Round', sans-serif;">El Código <label style="color: white;font-family: 'Varela Round', sans-serif;"><?php echo $InfoCodigo['codigo']; ?></label>
        ya ha sido <b style="color: white;font-family: 'Varela Round', sans-serif;">Escaneado</b>.
		</p>
    </div>
	<?php }
}else{ ?>
	<?php echo 'essssssssssssss' ?>
	<?php echo "$CodigoIngreso"; ?>
	 	<div class="mensaje_registro_no_existente">
           <p style="font-family: 'Varela Round', sans-serif;">No hay registro asociado al Código
				<b style="color: red;font-family: 'Varela Round', sans-serif;"> (<?php echo $CodigoIngreso; ?>)</b>
			</p>
        </div>
<?php } ?>
