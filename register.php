<?php

require_once './bootstrap.php';
require_once './Classes/validateFunctions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        
        break;

    case 'POST':
        // register a new user
        
        $input = json_decode(file_get_contents('php://input'), true);
    
        $email = $input['email'] ?? null;
        $username = $input['username'] ?? null;
        $password = $input['password'] ?? null;
        
        // data validation
        if(!(validateEmail($email) && validatePassword($password) && validateUsername($username))) {
            $response['error'] = 'Form data is not valid!';
            break;
        }

        $insertedUser = DbRequestsFactory::getInstance()->insertUser($email, $username, $password);

        if ($insertedUser) {
            $response = $insertedUser;
        } else {
            $response = ['error' => 'Failed to create user'];
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        $response = ['error' => 'Method not allowed'];
    }

echo json_encode($response);