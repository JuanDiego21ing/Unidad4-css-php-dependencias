<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_GET['slug'])) {
    echo json_encode(['error' => 'Falta el slug del producto']);
    exit();
}

$slug = $_GET['slug'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/' . $slug, 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer 1291|OKnLnmWRRHXku2CjMQ0QpCZBCUJDVVmnX0K6OXgl'
    ),
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode(['error' => 'Error en la solicitud: ' . curl_error($curl)]);
    curl_close($curl);
    exit();
}

curl_close($curl);

header('Content-Type: application/json');
echo $response;
