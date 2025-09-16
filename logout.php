<?php

require_once 'bootstrap.php';

$response = null;

if($_SERVER['REQUEST_METHOD'] === "POST"){

        Session::logout();
        header('Location: index.html');
        $response['success'] = true;
}else{
    $response['success'] = false;
}

echo json_encode($response);
