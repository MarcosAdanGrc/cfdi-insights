<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = DB::transaction(function() use ($data){
            $company = Company::create(['name' => $data['company_name']]);

            return User::create([
                'company_id' => $company->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
        });

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $user->load('company'),
            'token' => $token,
        ], 201);
    }
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
            $user = User::where('email', $data['email'])->first();
                if (!$user || !Hash::check($data['password'],$user->password)){
                    return response()->json([
                    'message' => 'Credenciales incorrectas'
                    ], 401);}
            $token = $user->createToken('api')->plainTextToken;
             return response()->json([
            'user' => $user->load('company'),
            'token' => $token,
            ], 200);
    }
    public function logout(Request $request){
        $request -> user() -> currentAccessToken()->delete();
             return response()->json([
            'message' => 'Sesion Cerrada']);
    }
    public function me(Request $request){
       return response()->json([
        'user' => $request->user()->load('company'),
    ]);
    }
}
//3|3IX2zCyHaUfDHyvoyus8eydOPlolagEQ0GG2Esz68e718739