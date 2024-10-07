<?php
  function buscar_direccion($latitud,$longitud) {

    $search_url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat='.$longitud.'&lon='.$latitud.'&zoom=18&addressdetails=1';

    $httpOptions = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Nominatim-Test"
        ]
    ];
    $streamContext = stream_context_create($httpOptions);
    $json = file_get_contents($search_url, false, $streamContext);
    $datos = json_decode($json,true);
    $busqueda_direccion = $datos['display_name'];
    return($busqueda_direccion);




}


 ?>
