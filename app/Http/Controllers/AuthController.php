<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // ❌ ELIMINAR EL __construct() completamente
    // Ya no se usa en Laravel 11/12

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
 public function login(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Obtener las credenciales del usuario
        $credentials = $request->only('username', 'password');

        // Verificar si el usuario existe
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            // Si no existe el usuario
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Verificar si la contraseña es correcta
        if (!Hash::check($credentials['password'], $user->password)) {
            // Si la contraseña es incorrecta
            return response()->json(['error' => 'Contraseña incorrecta'], 401);
        }

        // Si las credenciales son correctas, generar un token
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Responder con el token
        return $this->respondWithToken($token);
    }


    public function me()
    {
        // Usar JWTAuth para obtener el usuario autenticado
        $user = JWTAuth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Cargar el rol relacionado solo si el usuario está autenticado
        $user->load('rol');

        return response()->json($user);
    }



    public function logout()
    {
        // Invalidar el token JWT
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => JWTAuth::user()
        ]);
    }
}
