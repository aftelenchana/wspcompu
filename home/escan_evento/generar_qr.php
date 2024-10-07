<!DOCTYPE html>
<html>
<head>
    <title>Control de Acceso | Generar QR</title>
    <link rel="icon" type="image/png" href="resources/img/systas.png">
    <link rel="stylesheet" type="text/css" href="resources/css/framework/semantic/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="resources/css/hoja_de_estilos_generales.css">
</head>
<body>
    <?php require "vistas/menu.php" ?>
    <div class="contenedor">
<?php    
    echo "<h1 class='title'>GENERADOR DE CODIGOS QR</h1>";
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    include "resources/php/phpqrcode/qrlib.php";    
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    
    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
    if (isset($_REQUEST['data'])) { 
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">Regresar</a>');
        $filename = $PNG_TEMP_DIR.'Código '.$_REQUEST['data'].'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    
    echo '
<div class="generador_contenedor">
    <form action="generar_qr.php" method="post">
        <input type="text" name="data" placeholder="Ingresa el Código" class="data"><br><br>
        <select name="level" class="selector_calidad">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>Baja Calidad</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>Mediana Calidad</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Gran Calidad</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>Definitivamente la Mejor</option>
        </select>
        <select name="size" class="selector_tamaño">';
            for($i=1;$i<=10;$i++)
            echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        echo '</select><br><br>
        <input class="btn btn-primary" type="submit" value="Generar QR">
    </form>
</div>';
    echo '
    <h1 class="title">RESULTADO</h1>
    <center><img src="'.$PNG_WEB_DIR.basename($filename).' " /><br><br><br><br><br></center>';  
    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="resources/css/framework/semantic/semantic.min.js"></script>
</body>
</html>