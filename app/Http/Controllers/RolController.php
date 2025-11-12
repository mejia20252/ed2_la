<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
     public function index()
    {
        $roles = Role::all(); // Obtiene todos los roles
        return response()->json($roles);
    }
      // Obtener un rol específico
    public function show($id)
    {
        $rol = Role::findOrFail($id); // Busca un rol por ID
        return response()->json($rol);
    }

   //POST
    public function store(Request $request)
    {
        // Validar los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear el rol
        $rol = Role::create($request->all());

        // Retornar el rol recién creado
        return response()->json($rol, 201);
    }

    // Actualizar un rol
    public function update(Request $request, $id)
    {
        $rol = Role::findOrFail($id); // Busca el rol por ID
        $rol->update($request->all()); // Actualiza los datos del rol

        return response()->json($rol);
    }

    // Eliminar un rol
    public function destroy($id)
    {
        $rol = Role::findOrFail($id); // Busca el rol por ID
        $rol->delete(); // Elimina el rol

        return response()->json(null, 204); // 204 No Content
    }
}
