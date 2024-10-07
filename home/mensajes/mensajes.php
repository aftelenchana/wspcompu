<?php
function enviarMensajeWhatsApp_guibis($numero, $mensaje) {
    if (substr($numero, 0, 4) === '+593') {
        $numero = substr($numero, 1);
    }

    if (substr($numero, 0, 3) !== '593') {
        if (substr($numero, 0, 2) === '09' || strlen($numero) === 9) {
            $numero = '593' . substr($numero, (strlen($numero) == 9 ? 0 : 1));
        }
    }

    if (strlen($numero) > 11) {
        $url = 'http://whatsapp.guibis.com:3001/send-message';
        $data = array('number' => $numero, 'message' => $mensaje);
        $data_json = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    } else {
        return ['success' => false, 'message' => 'Agregar número de WhatsApp correcto para envío de mensaje'];
    }
}

 ?>
