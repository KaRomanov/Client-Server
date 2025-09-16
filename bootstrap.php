<?php

session_start();

spl_autoload_register(function ($class) {

    $includePaths = [
        './DB',
        './Classes'
    ];

    foreach ($includePaths as $path) {
        $file = "{$path}/{$class}.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    die("Class {$class} not found in include paths: " . implode(', ', $includePaths));

});

set_exception_handler(function ($exception)
{
    if ($exception instanceof RegisterUserException) {
        http_response_code(400);
        $error = $exception->getMessage();
    } else {
        http_response_code(500); // Internal Server Error
        $error = "Unknown error occurred";
    }
    
    echo json_encode(['error' => $error], JSON_UNESCAPED_UNICODE);
});