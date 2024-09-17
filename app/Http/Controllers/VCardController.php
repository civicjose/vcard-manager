<?php

namespace App\Http\Controllers;

use App\Models\VCard;
use App\Models\Company;
use Illuminate\Http\Request;

class VCardController extends Controller
{
    // Función para mostrar el listado de todas las vCards
    public function index()
    {
        // Obtener todas las vCards de la base de datos junto con la empresa asociada
        $vcards = VCard::with('company')->get();

        // Retornar la vista con los datos de las vCards
        return view('vcards.index', compact('vcards'));
    }

    // Función para mostrar el formulario de creación de vCard
    public function create()
    {
        // Obtener todas las empresas para mostrar en el formulario
        $companies = Company::all();

        // Retornar la vista de creación de vCard con las empresas disponibles
        return view('vcards.create', compact('companies'));
    }

    // Función para almacenar una nueva vCard en la base de datos

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+34 \d{3} \d{3} \d{3}$/',
            'email' => 'required|email|max:255',
            'company_id' => 'nullable|exists:companies,id',  // Validar que la empresa exista
            'image' => 'nullable|image|max:1024',  // Validar que el archivo sea una imagen
        ]);
    
        // Subir la imagen si existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Guardar la imagen en storage/app/public/profiles
            $imagePath = $request->file('image')->store('profiles', 'public');
        }
    
        // Crear la nueva vCard
        VCard::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'image' => $imagePath,  // Guardar la ruta de la imagen en la base de datos
        ]);
    
        // Redirigir al listado de vCards con un mensaje de éxito
        return redirect()->route('vcards.index')->with('success', 'vCard creada correctamente');
    }
    
    

    // Función para mostrar el formulario de edición de una vCard existente
    public function edit($id)
    {
        // Buscar la vCard por su ID
        $vcard = VCard::findOrFail($id);

        // Obtener todas las empresas para mostrar en el formulario de edición
        $companies = Company::all();

        // Retornar la vista de edición de la vCard con los datos actuales y las empresas disponibles
        return view('vcards.edit', compact('vcard', 'companies'));
    }

    // Función para actualizar una vCard existente en la base de datos
    public function update(Request $request, $id)
    {
        // Buscar la vCard por su ID
        $vcard = VCard::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'position' => 'required',
            'phone' => 'required|regex:/^\+34 \d{3} \d{3} \d{3}$/',
            'email' => 'required|email',
            'company_id' => 'nullable|exists:companies,id',
            'image' => 'nullable|image|max:1024',
        ]);

        // Subir la imagen de perfil si existe
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
            $vcard->image = $imagePath;
        }

        // Actualizar la vCard en la base de datos
        $vcard->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id,
        ]);

        // Redirigir al listado de vCards con un mensaje de éxito
        return redirect()->route('vcards.index')->with('success', 'vCard actualizada correctamente');
    }

    // Función para eliminar una vCard existente
    public function destroy($id)
    {
        // Buscar la vCard por su ID y eliminarla
        $vcard = VCard::findOrFail($id);
        $vcard->delete();

        // Redirigir al listado de vCards con un mensaje de éxito
        return redirect()->route('vcards.index')->with('success', 'vCard eliminada correctamente');
    }

    public function show($id)
    {
        // Buscar la vCard por su ID junto con la empresa relacionada
        $vcard = VCard::with('company')->findOrFail($id);
    
        // Retornar la vista que mostrará los detalles de la vCard
        return view('vcards.show', compact('vcard'));
    }
    
}



