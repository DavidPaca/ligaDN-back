<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validamos que el usuario envíe correo y clave
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Buscamos al usuario en la base de datos por su email
        $user = User::where('email', $request->email)->first();
        
        // 2. ¿El usuario existe?
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'El correo electrónico no está registrado en nuestro sistema.'
            ], 404); // 404 significa "No encontrado"
        }

        // 3. Comprobamos si el usuario existe y si la contraseña es correcta
        // Hash::check compara la clave escrita con la clave encriptada de la DB
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales incorrectas. Revisa tu email o contraseña.'
            ], 401);
        }

        // 4. GENERAMOS EL TOKEN (El "Gafete" de entrada)
        // Esta es la función de Sanctum que crea la llave para React
        $token = $user->createToken('token-liga')->plainTextToken;

        // 5. Respuesta final para el Frontend
        return response()->json([
            'status' => 'success',
            'message' => '¡Bienvenido al sistema!',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'email' => $user->email,
                ]
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        // Borramos el token actual para cerrar la sesión
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
