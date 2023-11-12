<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect.'],
    //         ]);
    //     }

    //     $token = $user->createToken('api-token')->plainTextToken;
    //     $user->api_token = Str::random(60);
    //     $user->save();
    //     return response()->json(['token' => $token], 200);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    
    //     if (!auth()->attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }
    
    //     // Crea una nuova sessione per l'utente
    //     $request->session()->regenerate();
    
    //     return response()->json(['message' => 'Logged in successfully']);
    // }
    

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        // Revoke the user's current token
        // $request->user()->currentAccessToken()->delete();

        // return response()->json(['message' => 'Logged out successfully'], 200);

        auth('api')->logout();
    return response()->json(['message' => 'Successfully logged out']);
    }
}
