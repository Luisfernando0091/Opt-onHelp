<?php

namespace App\Services;

use Google\Client;
use GuzzleHttp\Client as HttpClient;

class FirebaseService
{
    protected $httpClient;
    protected $projectId;
    protected $messagingUrl;
    protected $googleClient;

    public function __construct()
    {
        $this->projectId = "notifiacionoptionhelp"; // TU PROJECT ID
        $this->messagingUrl = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        // Ruta de tu archivo JSON que descargaste
        $serviceAccountPath = storage_path('app/firebase/service-account.json');

        // Autenticación OAuth
        $this->googleClient = new Client();
        $this->googleClient->setAuthConfig($serviceAccountPath);
        $this->googleClient->addScope("https://www.googleapis.com/auth/firebase.messaging");

        $this->httpClient = new HttpClient();
    }

    public function sendNotification($token, $title, $body)
    {
        $accessToken = $this->googleClient->fetchAccessTokenWithAssertion()["access_token"];

        $message = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body"  => $body
                ],
            ]
        ];

        $response = $this->httpClient->post($this->messagingUrl, [
            "headers" => [
                "Authorization" => "Bearer {$accessToken}",
                "Content-Type" => "application/json",
            ],
            "json" => $message,
        ]);

        return json_decode($response->getBody(), true);
    }
}
