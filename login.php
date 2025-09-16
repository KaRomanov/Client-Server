<?php

require_once 'bootstrap.php';

$response = null;
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $response['is_logged_in'] = Session::isLoggedIn();
        break;
    case 'POST':

        // when the request sends json data
        $input = json_decode(file_get_contents('php://input'), true);
        
        // add for email!!!
        $email = $input['email'] ?: null;
        $username = $input['username'] ?: null;
        $password = $input['password'] ?: null;

        $validUser = DbRequestsFactory::getInstance()->validateUser($email, $username, $password);

        if ($validUser) {
            $response['success'] = $validUser;

            Session::login($username);

            echo json_encode(['redirect' => '../homepage.php']);
            exit;
        }

        $response['success'] = false;
        break;
}

echo json_encode($response);