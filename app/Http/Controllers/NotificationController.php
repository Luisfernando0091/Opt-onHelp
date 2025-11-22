<?php

namespace App\Http\Controllers;

use App\Models\UserToken;
use Illuminate\Http\Request;    

class NotificationController extends Controller
{
    public function testNotification()
    {
        $token = UserToken::first()->token_fcm;

        $data = [
            "to" => $token,
            "notification" => [
                "title" => "🔥 Notificación de Prueba",
                "body" => "Esto es una prueba desde tu backend Laravel"
            ]
        ];

        $response = $this->sendFcm($data);

        return response()->json(["fcm_response" => $response]);
    }

    private function sendFcm($data)
    {
        $url = "https://fcm.googleapis.com/fcm/send";

        $serverKey = env("FIREBASE_SERVER_KEY");

        $headers = [
            "Authorization: key=$serverKey",
            "Content-Type: application/json"
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        return curl_exec($curl);
    }
}
