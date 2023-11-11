<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return $users;
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al obtener usuarios: ' . $e->getMessage()], 500);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // La autenticación fue exitosa
            $user = Auth::user();
            return response()->json(['message' => 'Autenticación exitosa', 'user' => $user]);
        } else {
            // La autenticación falló
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada']);
    }


    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['code' => 404, 'message' => 'Usuario no encontrado: ' . $e->getMessage()], 404);
        }
    }

    // Método para almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['code' => 200, 'message'=> 'Usuario creado correctamente', 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al crear usuario: ' . $e->getMessage()], 500);
        }
    }
}
