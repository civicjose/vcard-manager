@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">

    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre de la Empresa -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nombre de la Empresa</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('name', $company->name) }}" required>
        </div>

        <!-- Logo de la Empresa -->
        <div class="mb-4">
            <label for="logo" class="block text-gray-700 font-medium">Logo (SVG)</label>
            <input type="file" name="logo" id="logo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".svg">
            @if ($company->logo)
                <p class="mt-2 text-gray-600">Logo actual:</p>
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Empresa" class="w-12 h-auto">
            @endif
        </div>

        <!-- Botón para actualizar -->
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Actualizar Empresa
        </button>
    </form>
</div>
@endsection
