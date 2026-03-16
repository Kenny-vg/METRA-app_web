<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::first();

if ($user) {
    echo "User found: " . $user->email . "\n";
    echo "Token: " . $user->createToken('test-token')->plainTextToken . "\n";
} else {
    echo "No users found in DB.\n";
}
