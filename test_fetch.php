<?php
$cases = [
    'A (Sin Comprobante)' => 'testA@test.com',
    'B (Con Comprobante pendiente)' => 'testB@test.com',
    'C (Aprobado)' => 'testC@test.com'
];

foreach($cases as $name => $email) {
    echo "--- CASO: $name ---\n";
    $ch = curl_init('http://metra-app-web.test/api/auth/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['email' => $email, 'password' => 'password123']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
    
    $result = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "STATUS: $status\n";
    echo "BODY:\n" . json_encode(json_decode($result), JSON_PRETTY_PRINT) . "\n\n";
}
