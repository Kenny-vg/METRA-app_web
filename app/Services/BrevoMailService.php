<?php

namespace App\Services;

use GuzzleHttp\Client;

class BrevoMailService
{
    public static function send($to, $subject, $html)
    {
        $client = new Client();

        $client->post('https://api.brevo.com/v3/smtp/email', [
            'headers' => [
                'api-key' => env('BREVO_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'sender' => [
                    'name' => 'METRA Soporte',
                    'email' => 'vtech.metra.soporte@gmail.com'
                ],
                'to' => [
                    ['email' => $to]
                ],
                'subject' => $subject,
                'htmlContent' => $html
            ]
        ]);
    }
}