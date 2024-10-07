<?php
if (isset($_POST['numeroIdentificacion'])) {
    $numeroIdentificacion = $_POST['numeroIdentificacion'];

    if (strlen($numeroIdentificacion) == 10) {
        $tipoIdentificacion = 'C';
    } elseif (strlen($numeroIdentificacion) == 13) {
        $tipoIdentificacion = 'R';
    } else {
        echo json_encode(['error' => 'numero_no_valido']);
        exit;
    }

    $url = "https://srienlinea.sri.gob.ec/sri-catastro-sujeto-servicio-internet/rest/Persona/obtenerPorTipoIdentificacion?numeroIdentificacion=$numeroIdentificacion&tipoIdentificacion=$tipoIdentificacion";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    // Decodificar la respuesta JSON
    $responseData = json_decode($response, true);

    // Verificar si la respuesta es válida
    if (isset($responseData['identificacion']) && isset($responseData['nombreCompleto'])) {
        $resultado = [
            'identificacion' => $responseData['identificacion'],
            'nombreCompleto' => $responseData['nombreCompleto'],
            'tipoPersona' => $responseData['tipoPersona'],
            'codigoPersona' => $responseData['codigoPersona'],
            'tipoIdentificacion' => $tipoIdentificacion
        ];

        echo json_encode($resultado);
    } else {
        echo json_encode(['error' => 'respuesta_invalida']);
    }
} else {
    echo json_encode(['error' => 'no_identificacion']);
}
?>
