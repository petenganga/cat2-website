<?php
header('Content-Type: application/json');
echo json_encode([
    'function' => 'hello',
    'message' => 'Hello from a serverless-style function',
    'time' => date('c')
]);
?>
