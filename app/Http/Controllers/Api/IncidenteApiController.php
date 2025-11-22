<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incidente;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\UserToken;
use App\Events\IncidenteCreado;

class IncidenteApiController extends Controller
{ 
    public function index()
{
    return response()->json(Incidente::all());
}

   public function store(Request $request)
{
    $data = $request->validate([
        'titulo'      => 'required|string|max:255',
        'descripcion' => 'required|string',
        'user_id'     => 'required|integer',
    ]);

    $incidente = Incidente::create($data);

    event(new IncidenteCreado($incidente));
    return response()->json([
        'message'   => 'Incidente registrado y notificación enviada',
        'incidente' => $incidente
    ], 201);
    // Obtener todos los tokens guardados
   // $tokens = UserToken::pluck('token')->toArray();

    // $firebase = new FirebaseService();

    // foreach ($tokens as $token) {
    //     $firebase->sendNotification(
    //         $token,
    //         'Nuevo Incidente',
    //         $incidente->titulo,
    //         ['incidente_id' => $incidente->id]
    //     );
    // }

    // return response()->json([
    //     'message'   => 'Incidente registrado y notificación enviada',
    //     'incidente' => $incidente
    // ], 201);
}

}
