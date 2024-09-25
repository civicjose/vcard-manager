<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {
        return view('admin.create-user'); // Crea una vista de formulario
    }

    // Almacenar el nuevo usuario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Redirigir a la vista de creación de usuarios, o donde prefieras
        return redirect()->route('vcards.index')->with('success', 'Usuario creado exitosamente.');
    }
    
}
