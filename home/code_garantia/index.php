<?php include("resources/php/conexion.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Control de Acceso | SysTas</title>
	<link rel="icon" type="image/png" href="resources/img/systas.png">
	<link rel="stylesheet" type="text/css" href="resources/css/framework/semantic/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="resources/css/hoja_de_estilos_generales.css">
	<link rel="stylesheet" type="text/css" href="resources/css/hoja_de_estilos_lector.css">
	<script  src="resources/js/jsQR.js"></script>
	<script>
		function Actualizacion(){
			var tabla = $.ajax({
				url:'tabla_consulta.php',
				dataType:'text',
				async:false
			}).responseText;
			document.getElementById("miTabla").innerHTML = tabla;}
		//setInterval(Actualizacion, 1000);
	</script>
</head>
<div class="">
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
<body>

	<div class="panel-lectura">
		<div class="panel-camara">
			<div id="preMensaje">No se encuentra una cámara, asegúrate de tener habilitada una.</div>
				<canvas id="canvas" hidden></canvas>
			<div id="datosSalida" hidden>
				<div id="mensajeSalida">No se ha detectado ningún código QR</div>
				<div hidden><b>Código: </b><span id="qrDetectado"></span></div>
			</div>
		</div>
		<div class="panel-resultado" id="resultado">
		</div>
	</div>
<h1 class="titulo">Códigos Escaneados</h1>
	<section id="miTabla" style="max-width: 700px;
			background: #fff;
			margin: auto;
			margin-top: 30px;
			text-align: center;
			border-radius: 10px;
			padding: 20px;">
	</section>
	<div class="sonido">
		<audio controls id="sonido_qr">
			<source src="resources/sonido/beep.mp3" type="audio/mpeg">
		</audio>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="resources/css/framework/semantic/semantic.min.js"></script>
<script src="resources/js/Escaner_qr.js"></script>
</body>
</html>
