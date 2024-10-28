<?php
session_start();

class ProductController {
    private $apiUrl = 'https://crud.jonathansoto.mx/api/products';
    private $apiToken = '635|dpQ8rIYnu4zuYBZB71sBeAhBrEtTuTZe8M4SGYjQ';

    public function getProducts() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->apiToken
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $productos = json_decode($response, true);
        header('Content-Type: application/json');
        echo json_encode($productos['data'] ?? []); 
    }
}

$controller = new ProductController();
$controller->getProducts();
