@extends('layouts.app')

@section('title', 'Crear nueva vCard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vcards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf  <!-- Token CSRF es obligatorio para formularios POST -->
        
        <!-- Nombre -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nombre</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('name') }}" required>
        </div>

        <!-- Apellidos -->
        <div class="mb-4">
            <label for="lastname" class="block text-gray-700 font-medium">Apellidos</label>
            <input type="text" name="lastname" id="lastname" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('lastname') }}" required>
        </div>

        <!-- Puesto -->
        <div class="mb-4">
            <label for="position" class="block text-gray-700 font-medium">Puesto</label>
            <input type="text" name="position" id="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('position') }}" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-medium">Teléfono</label>
            <input type="tel" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('phone') }}" placeholder="+34 000 000 000" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('email') }}" required>
        </div>

        <!-- Empresa -->
        <div class="mb-4">
            <label for="company_id" class="block text-gray-700 font-medium">Empresa</label>
            <select name="company_id" id="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Selecciona una empresa</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Foto de perfil -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium">Foto de perfil (opcional)</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Mostrar marcas -->
        <div class="mb-4">
            <label for="show_brands" class="block text-gray-700 font-medium">¿Mostrar marcas?</label>
            <select name="show_brands" id="show_brands" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="no" {{ old('show_brands', $vcard->show_brands ?? 'no') == 'no' ? 'selected' : '' }}>No</option>
                <option value="yes" {{ old('show_brands', $vcard->show_brands ?? 'no') == 'yes' ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <!-- Botón para enviar -->
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Crear vCard
        </button>
    </form>
</div>
@endsection
