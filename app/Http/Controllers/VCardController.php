<?php

namespace App\Http\Controllers;

use App\Models\VCard;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Importar la librería para generar QR
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+34 \d{3} \d{3} \d{3}$/',
            'email' => 'required|email|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'image' => 'nullable|image|max:1024',
            'show_brands' => 'required|in:yes,no',
        ]);

        // Subir la imagen si existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
        }

        // Generar el slug a partir del nombre y apellidos
        $slug = Str::slug($request->name . '-' . $request->lastname);

        // Crear la nueva vCard con el slug
        $vcard = VCard::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'image' => $imagePath,
            'show_brands' => $request->show_brands,
            'slug' => $slug,  // Asegúrate de que el slug se genere y guarde
        ]);

        if (empty($slug)) {
            return back()->withErrors(['slug' => 'El slug no se pudo generar.']);
        }

        // Generar la URL para el QR code
        $url = route('vcards.show', [$vcard->slug]);

        // Generar la imagen QR y guardarla en el almacenamiento público
        $qrPath = 'qrcodes/' . $slug . '.png'; // Nombre del archivo QR
        QrCode::format('png')->size(200)->generate($url, storage_path('app/public/' . $qrPath));

        // Guardar la ruta del QR en la vCard (opcional si quieres guardarlo)
        $vcard->update(['qr_code' => $qrPath]);

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
        $vcard = VCard::findOrFail($id);

        // Validar los datos enviados desde el formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+34 \d{3} \d{3} \d{3}$/',
            'email' => 'required|email|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'image' => 'nullable|image|max:1024',
            'show_brands' => 'required|in:yes,no',
        ]);

        // Generar el slug a partir del nombre y apellidos
        $slug = Str::slug($request->name . '-' . $request->lastname);

        // Subir la imagen si existe
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
            $vcard->image = $imagePath;
        }

        // Actualizar los datos de la vCard
        $vcard->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'show_brands' => $request->show_brands,  // Actualizar la selección de marcas
            'slug' => $slug,  // Asegúrate de que el slug se genere y guarde
        ]);

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

    public function show($slug)
    {
        $vcard = VCard::where('slug', $slug)->firstOrFail();
        return view('vcards.show', compact('vcard'));
    }
}
