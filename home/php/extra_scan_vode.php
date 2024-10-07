<?php
include("../../coneccion.php");
$CodigoIngreso = $_REQUEST['codigo'];
$producto = $_REQUEST['producto'];
$comprador = $_REQUEST['comprador'];


echo "$producto";
exit;
 $position1 = explode("=",$CodigoIngreso);
$producto = end($position1);


$BuscarCodigo   = ("SELECT * FROM producto_venta WHERE idproducto='".$producto."' LIMIT 1");
$resultado  = mysqli_query($conection, $BuscarCodigo);

$cantidadExistente    = mysqli_num_rows($resultado);
$InfoCodigo 	  = mysqli_fetch_array($resultado);

$status =1;
if (!empty($cantidadExistente)) {
		if($InfoCodigo['estatus'] == $status){
				include('salida_datos.php');

		}else{ ?>
			<div class="mensaje_registro_existente">
		       <p style="font-size: 25px;font-family: 'Varela Round', sans-serif;">Producto</label>
		        inactivo </b>.
				</p>
		    </div>
			<?php }
}else{ ?>
	 	<div class="mensaje_registro_no_existente">
           <p style="font-family: 'Varela Round', sans-serif;">No hay registro asociado
				<b style="color: red;font-family: 'Varela Round', sans-serif;"></b>
			</p>
        </div>
<?php } ?>
