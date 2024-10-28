<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Por favor, complete todos los campos.";
        header("Location: /Unidad4-css-php-dependencias/Trabajo8/index.html");
        exit();
    }

    $response = login($email, $password);

    if (isset($response['code']) && $response['code'] == 2) {
        $_SESSION['user'] = $response['data']['email'];  
        $_SESSION['token'] = $response['data']['token'];  

        header("Location: /Unidad4-css-php-dependencias/Trabajo8/home.html");  
        exit();  
    } else {
        $_SESSION['error'] = $response['message'] ?? "Credenciales incorrectas.";
        header("Location: /Unidad4-css-php-dependencias/Trabajo8/index.html");  
        exit();
    }
}

function login($email, $password) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'email' => $email,
            'password' => $password
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        error_log('Error cURL: ' . curl_error($curl));
        curl_close($curl);
        return ['code' => 0, 'message' => 'Error en la conexión con el servidor de autenticación'];
    }

    curl_close($curl);
    return json_decode($response, true);
}
