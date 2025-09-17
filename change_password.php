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
        $password = $input['newPassword'] ?: null;
        
        if(!validatePassword($password)){
            $response['error'] = 'Invalid password!';
            break;
        }

        if (DbRequestsFactory::getInstance()->updateUserPassword($username, $password)) {
            $response['success'] = "Password updated!";
            break;
        }

        $response['success'] = false;
        break;
}

echo json_encode($response);