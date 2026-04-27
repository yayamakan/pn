<?php
header('Content-Type: application/json');

$payload_file = '../payload.txt';

$valid_keys = [
    "PINOTAMPAN" => "2029-12-31 23:59:59"
];

$key = $_GET['key'] ?? $_POST['key'] ?? '';

if (!empty($key)) {
    if (array_key_exists($key, $valid_keys)) {
        $exp_date = $valid_keys[$key];
        
        if (date('Y-m-d H:i:s') < $exp_date) {

            $load_data_content = file_exists($payload_file) ? file_get_contents($payload_file) : "";
            
            $auth_message_content = "?\\u0015\"?\\u001a9+\t\\u0012%8\\u001d>,F)?3\\u001130\\u0015\t9#R\\u000f,\\u000e\\u0015\"?\\u001a9+\tZ\\u00049\\u00197\"\\u0007\\u001b+1\\u00137\"\\u0007\\u001b";

            echo json_encode([
                "status" => true,
                "expire_date" => $exp_date,
                "message" => "Login Success",
                "rng" => rand(1000000000, 1999999999),
                "load" => [
                    "load_data" => $load_data_content
                ],
                "auth" => [
                    "message" => $auth_message_content,
                    "token_access" => ""
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
        } else {
            echo json_encode(["status" => false, "message" => "Key Expired", "expire_date" => $exp_date]);
        }
    } else {
        echo json_encode(["status" => false, "message" => "Key inv\u00e1lida", "expire_date" => null]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Key inv\u00e1lida", "expire_date" => null]);
}
