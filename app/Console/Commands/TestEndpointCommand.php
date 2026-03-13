<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestEndpointCommand extends Command
{
    protected $signature = 'test:endpoint';
    protected $description = 'Test API endpoint';

    public function handle()
    {
        $user = User::where('role', 'personal')->orderBy('id', 'desc')->first();
        if (!$user) {
            $this->info("No staff user found.");
            return;
        }

        $token = $user->createToken('test-token')->plainTextToken;
        
        $url = 'http://metra-app-web.test/api/staff/mesas';
        $options = [
            'http' => [
                'header'  => "Authorization: Bearer $token\r\nAccept: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => true,
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $this->info("HTTP Request Result: " . $result);

        $user->tokens()->where('name', 'test-token')->delete();
    }
}
