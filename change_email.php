<?php

require_once 'bootstrap.php';
require_once './Classes/validateFunctions.php';

$response = null;
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $response['error'] = "Not a valid method!";
        break;
    case 'POST':

        // when the request sends json data
        $input = json_decode(file_get_contents('php://input'), true);
        
        $username = $_SESSION['username'];
        $email = $input['email'] ?: null;
        
        if(!validateEmail($email)){
            $response['error'] = 'Invalid email format!';
            break;
        }

        if (DbRequestsFactory::getInstance()->updateUserEmail($username, $email);) {
            $response['success'] = "Email updated!";
            echo json_encode(['redirect' => '../homepage.php']);
            exit;
        }

        $response['success'] = false;
        break;
}

echo json_encode($response);