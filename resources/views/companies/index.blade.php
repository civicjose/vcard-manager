@extends('layouts.app')

@section('title', 'Listado de Empresas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('companies.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Añadir nueva Empresa</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white border border-gray-200 shadow-sm">
    <thead>
        <tr class="bg-gray-800 text-white">
            <th class="text-left px-4 py-2">Nombre</th>
            <th class="text-left px-4 py-2">Logo</th>
            <th class="text-left px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($companies as $company)
            <tr class="border-t border-gray-200">
                <td class="px-4 py-2">{{ $company->name }}</td>
                <td class="px-4 py-2">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo de {{ $company->name }}" class="w-24 h-auto">
                    @else
                        <span class="text-gray-500">Sin logo</span>
                    @endif
                </td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="{{ route('companies.edit', $company->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Editar</a>
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta empresa?')">
                        @csrf
                        @method('DELETE')
<<<<<<< HEAD
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
=======
                        <button type="button" class="btn btn-danger btn-sm btn-delete">Eliminar</button>
>>>>>>> 2736f2f813a1498ed8ccc38039a773e44d63b147
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
