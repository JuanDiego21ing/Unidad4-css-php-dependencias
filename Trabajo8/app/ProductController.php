<?php
session_start();

class ProductController {
    private $apiUrl = 'https://crud.jonathansoto.mx/api/products';
    private $apiToken = '39|2PaV3tMBbId1602axrWWhq8nPIl3BbzEdsSloCO5';

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

    public function addProduct($productData) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($productData), 
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->apiToken,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $responseDecoded = json_decode($response, true);
        header('Content-Type: application/json');
        echo json_encode($responseDecoded);
    }
}

$controller = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getProducts();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['name'], $input['slug'], $input['description'], $input['features'])) {
        $controller->addProduct($input);
    } else {
        header('Content-Type: application/json', true, 400);
        echo json_encode(['error' => 'Faltan campos necesarios en la solicitud']);
    }
}
