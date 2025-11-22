<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserToken;

class UserTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        UserToken::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['token' => $request->token]
        );

        return response()->json(['message' => 'Token guardado correctamente']);
    }
}
