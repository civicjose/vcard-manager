<?php

namespace App\Http\Controllers;

use App\Models\VCard;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
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

    // Generar un slug único
    $slug = $this->generateUniqueSlug($request->name, $request->lastname);



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

        // Usar Endroid QRCode para generar el QR
        $qrCode = new QrCode($url);
        $qrCode->setSize(200); // Tamaño del QR

        // Generar el archivo PNG
        $writer = new PngWriter();
        $qrPath = 'qrcodes/' . $slug . '.png';
        $result = $writer->write($qrCode);

        // Guardar el archivo PNG en el almacenamiento público
        Storage::disk('public')->put($qrPath, $result->getString());

        // Actualizar la vCard para guardar la ruta del código QR
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

        // Guardar el slug y la imagen anteriores para comparar
        $oldSlug = $vcard->slug;
        $oldImage = $vcard->image;

    // Generar un slug único si cambian el nombre o apellidos
    $newSlug = $this->generateUniqueSlug($request->name, $request->lastname);

        // Subir la nueva imagen de perfil si existe y eliminar la anterior
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            // Subir la nueva imagen
            $imagePath = $request->file('image')->store('profiles', 'public');
            $vcard->image = $imagePath;
        }

        // Actualizar la vCard con los nuevos datos (incluido el nuevo slug)
        $vcard->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'show_brands' => $request->show_brands,
            'slug' => $newSlug,
        ]);

        // Si el slug ha cambiado, eliminar el QR anterior y generar uno nuevo
        if ($oldSlug !== $newSlug) {
            // Eliminar el QR anterior
            if ($vcard->qr_code && Storage::disk('public')->exists($vcard->qr_code)) {
                Storage::disk('public')->delete($vcard->qr_code);
            }

            // Generar la nueva URL para el QR code
            $url = route('vcards.show', [$newSlug]);

            // Usar Endroid QRCode para generar el nuevo QR
            $qrCode = new QrCode($url);
            $qrCode->setSize(200);

            // Generar el nuevo archivo PNG
            $writer = new PngWriter();
            $qrPath = 'qrcodes/' . $newSlug . '.png';
            $result = $writer->write($qrCode);

            // Guardar el nuevo archivo PNG en el almacenamiento público
            Storage::disk('public')->put($qrPath, $result->getString());

            // Actualizar la vCard con la nueva ruta del QR
            $vcard->update(['qr_code' => $qrPath]);
        }

        return redirect()->route('vcards.index')->with('success', 'vCard actualizada correctamente');
    }


    // Función para eliminar una vCard existente
    public function destroy($id)
    {
        $vcard = VCard::findOrFail($id);

        // Eliminar la imagen de perfil si existe
        if ($vcard->image && Storage::disk('public')->exists($vcard->image)) {
            Storage::disk('public')->delete($vcard->image);
        }

        // Eliminar el código QR si existe
        if ($vcard->qr_code && Storage::disk('public')->exists($vcard->qr_code)) {
            Storage::disk('public')->delete($vcard->qr_code);
        }

        // Eliminar la vCard de la base de datos
        $vcard->delete();

        return redirect()->route('vcards.index')->with('success', 'vCard eliminada correctamente, incluyendo todos sus recursos.');
    }

    public function show($slug)
    {
        $vcard = VCard::where('slug', $slug)->firstOrFail();
        return view('vcards.show', compact('vcard'));
    }

    public function generateUniqueSlug($name, $lastname)
    {
        // Generar el slug base a partir del nombre y apellidos
        $slug = Str::slug($name . '-' . $lastname);

        // Comprobar si ya existe el slug en la base de datos
        $originalSlug = $slug;
        $count = 1;

        while (VCard::where('slug', $slug)->exists()) {
            // Si el slug ya existe, añadir un número secuencial al final
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
