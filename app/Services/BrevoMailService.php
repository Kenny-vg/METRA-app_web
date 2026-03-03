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
                'api-key' => config('services.brevo.key'),
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'sender' => [
                    'name' => env('MAIL_FROM_NAME'),
                    'email' => env('MAIL_FROM_ADDRESS')
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