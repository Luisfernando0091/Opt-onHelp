<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FirebaseMessagingService
{
    private $client;
    private $credentials;

    public function __construct()
    {
        // 🚨 CÓDIGO CORREGIDO AQUÍ: Usamos FIREBASE_CREDENTIALS_PATH del .env
        $relativePath = env('FIREBASE_CREDENTIALS_PATH'); 
        
        // Convertir la ruta relativa a una ruta absoluta usando base_path()
        $jsonPath = base_path($relativePath); 

        // Verificar que el archivo exista
        if (!$relativePath || !file_exists($jsonPath)) {
             Log::error("⚠️ Archivo de credenciales Firebase no encontrado: La ruta esperada era $jsonPath. Revisa la variable FIREBASE_CREDENTIALS_PATH en tu .env.");
             return; 
        }

        try {
            // Configurar credenciales para FCM con la ruta corregida
            $this->credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/firebase.messaging'],
                $jsonPath
            );
            
            $this->client = new Client();
            Log::info("✅ FCM Service inicializado: Credenciales cargadas desde $jsonPath");

        } catch (\Throwable $e) {
             Log::error("🔥 ERROR CRÍTICO al inicializar credenciales de Firebase: " . $e->getMessage());
        }
    }

    /**
     * Obtiene el Access Token de OAuth2 necesario para la API de FCM.
     */
    private function getAccessToken()
    {
        if (!$this->credentials) {
            throw new \Exception("⚠️ El servicio de credenciales no se ha inicializado correctamente.");
        }

        $token = $this->credentials->fetchAuthToken();

        if (!isset($token['access_token'])) {
            throw new \Exception("⚠️ No se pudo obtener el token de acceso de Firebase.");
        }

        return $token['access_token'];
    }

    /**
     * Enviar notificación a un dispositivo por token
     *
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @param array $data
     * @return string|null
     */
    public function sendToToken($deviceToken, $title, $body, $data = [])
    {
        if (!$this->credentials) {
            Log::warning("⚠️ FCM Service no disponible. No se intentará el envío.");
            return null;
        }

        try {
            $projectId = env('FIREBASE_PROJECT_ID');

            $url = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

            // Asegurarse que todos los valores de data sean strings (requisito de FCM)
            $stringData = [];
            foreach ($data as $key => $value) {
                $stringData[$key] = is_string($value) ? $value : json_encode($value);
            }

            $payload = [
                "message" => [
                    "token" => $deviceToken,
                    "notification" => [
                        "title" => $title,
                        "body"  => $body,
                    ],
                    "data" => $stringData
                ]
            ];

            // 1. Obtener el token de acceso (Autenticación)
            $accessToken = $this->getAccessToken();

            // 2. Realizar la solicitud POST a la API de FCM
            $response = $this->client->post($url, [
                "headers" => [
                    "Authorization" => "Bearer $accessToken", 
                    "Content-Type" => "application/json",
                ],
                "json" => $payload
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            // Aquí se captura el 403 Forbidden
            Log::error("⚠️ Error al enviar FCM: " . $e->getMessage());
            throw $e; 
        }
    }
}