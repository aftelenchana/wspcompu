<?php
include("resources/php/conexion.php");
$sql = "SELECT * FROM acceso ORDER BY id DESC";
		$resultado = mysqli_query($con, $sql);
		echo '<table class="table" style="font-size:15px; width: 100%;">
			<tr class="active" style="background: #333; height: 40px; color: #fff;">
				<th>ID</th>
				<th>Código</th>
				<th>Referencia</th>
				<th>Estado</th>
			</tr>';
			while ($mostrar = $resultado->fetch_array(MYSQLI_BOTH))
			{
				echo '<tr class="datos">
						<td>'.$mostrar['id'].'</td>
						<td>'.$mostrar['codigo'].'</td>
						<td>'.$mostrar['referencia'].'</td>
						<td>'.$mostrar['status'].'</td>
					 </tr>';
			}
			echo '</table>';
?>
