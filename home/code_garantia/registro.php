<!DOCTYPE html>
<html>
<head>
	<title>Control de Acceso | Registro</title>
	<link rel="shortcut icon" type="image/png" href="resources/img/sysTas.png">
	<link rel="stylesheet" type="text/css" href="resources/css/framework/semantic/semantic.min.css">
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Varela+Round&display=swap');
		body{
			background: #0f0f0f;
			font-family: 'Varela Round', sans-serif;
		}
		.formulario{
			background: #333;
			max-width: 500px;
			text-align: center;
			margin: auto;
			margin-top: 50px;
			border-radius: 20px;
			padding: 20px;
		}
		.titulo{
			color: #fff;
		}
		.camp{
			width: 80%;
			border:none;
			border-radius: 50px;
			padding: 20px;

			font-size: 18px;
			color: #000;
			background: #00ffff;
		}
		.referencia{
			width: 80%;
			border: none;
			border-radius: 5px;
			padding: 20px;
			font-size: 18px;
			color: #000;
			margin-top: 20px;
		}
		.btn{
			border:none;
			padding: 15px 50px;
			border-radius: 50px;
			margin-top: 20px;
			background: #333;
			border: 2px solid #00ffff;
			color: #00ffff;
			font-size: 20px;
		}
		.btn:hover{
			background: #000;
			transition: 0.5s ease;
			cursor: pointer;
		}
		.tablaDatos{
			max-width: 700px;
			background: #fff;
			margin: auto;
			margin-top: 30px;
			text-align: center;
			border-radius: 10px;
			padding: 20px;
		}
		.tabla{
			width: 100%;
		}
		.cabeceraTabla{
			background: #333;
			height: 40px;
			color: #fff;
		}
		.datos{
			height: 50px;
		}
		.datos:nth-child(odd){
			background: #ccc;
		}
		.datos:nth-child(even){
			background: #f2f2f2;
		}
	</style>
</head>
<body>
	<?php require "vistas/menu.php" ?>
	<div class="formulario">
		<h1 class="titulo">Ingresar nuevo Código</h1>
		<form action="resources/php/guardar_datos.php" method="POST">
			<input class="camp" type="text" name="Codigo" placeholder="Ingresar nuevo Código" required>
			<input class="referencia" type="text" name="Referencia" placeholder="Ingresa una referencia">
			<input class="btn" type="submit" value="Guardar" name="btn-guardar">
		</form>
	</div>
	<?php
		include("resources/php/conexion.php");
	?>
	<div class="tablaDatos">
		<table class="tabla">
			<form action="resources/php/eliminar_registros.php" method="POST"><input class="btn" type="submit" value="Eliminar Registros" name="btn-eliminar"></form><br><br>
			<tr class="cabeceraTabla">
				<td>ID</td>
				<td>Código</td>
				<td>Referencia</td>
				<td>Estado</td>
			</tr>
			<?php
				$sql = "SELECT * FROM acceso ORDER BY id DESC";
				$resultado = mysqli_query($con, $sql);
				while($mostrar = mysqli_fetch_array($resultado)){
				?>
			<tr class="datos">
				<td><?php echo $mostrar['id'] ?></td>
				<td><?php echo $mostrar['codigo'] ?></td>
				<td><?php echo $mostrar['referencia'] ?></td>
				<td><?php echo $mostrar['status'] ?></td>
			</tr>
		<?php } ?>
		</table>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="resources/css/framework/semantic/semantic.min.js"></script>
</body>
</html>