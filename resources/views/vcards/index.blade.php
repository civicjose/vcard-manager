@extends('layouts.app')

@section('title', 'Listado de vCards')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('vcards.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Añadir nueva vCard</a>
</div>

<!-- Campo de búsqueda -->
<div class="mb-4">
    <input type="text" id="search" class="border border-gray-300 rounded px-4 py-2 w-full" placeholder="Buscar por nombre, apellidos, teléfono, empresa..." onkeyup="searchTable()">
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-4 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<table class="min-w-full bg-white border-collapse">
    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="px-6 py-3 text-left">Nombre</th>
            <th class="px-6 py-3 text-left">Apellidos</th>
            <th class="px-6 py-3 text-left">Puesto</th>
            <th class="px-6 py-3 text-left">Teléfono</th>
            <th class="px-6 py-3 text-left">Empresa</th>
            <th class="px-6 py-3 text-left">Acciones</th>
        </tr>
    </thead>
    <tbody id="vcardTable">
        @foreach ($vcards as $vcard)
        <tr class="border-b">
            <td class="px-6 py-4">{{ $vcard->name }}</td>
            <td class="px-6 py-4">{{ $vcard->lastname }}</td>
            <td class="px-6 py-4">{{ $vcard->position }}</td>
            <td class="px-6 py-4">{{ $vcard->phone }}</td>
            <td class="px-6 py-4">
                @if($vcard->company)
                {{ $vcard->company->name }}
                @else
                Sin empresa
                @endif
            </td>
<<<<<<< HEAD
            <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('vcards.show', [$vcard->slug]) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Ver</a>
                <a href="{{ route('vcards.edit', $vcard->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Editar</a>
                <form action="{{ route('vcards.destroy', $vcard->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Eliminar</button>
=======
            <td>
                <a href="{{ route('vcards.show', [$vcard->slug]) }}" class="btn btn-info btn-sm" target="_blank">Ver</a>
                <a href="{{ route('vcards.edit', $vcard->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('vcards.destroy', $vcard->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete">Eliminar</button>
>>>>>>> 2736f2f813a1498ed8ccc38039a773e44d63b147
                </form>

                <!-- Botón para ver el QR -->
                @php
                $qrUrl = asset('storage/' . $vcard->qr_code);
                @endphp

                @if($vcard->qr_code)
                <button type="button" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-sm cursor-alias" onclick="showQrCode('{{ $qrUrl }}')">Ver QR</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal para mostrar el QR -->
<div id="qrModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg">
        <h5 class="text-lg font-bold mb-4">Código QR</h5>
        <img id="qrImage" src="" alt="Código QR" class="w-full h-auto">
        <button class="bg-red-500 text-white mt-4 px-4 py-2 rounded" onclick="closeQrModal()">Cerrar</button>
    </div>
</div>

<script>
    function searchTable() {
        let input = document.getElementById('search').value.toLowerCase();
        let rows = document.querySelectorAll('#vcardTable tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }

    function showQrCode(imageUrl) {
        document.getElementById('qrImage').src = imageUrl;
        document.getElementById('qrModal').classList.remove('hidden');
    }

    function closeQrModal() {
        document.getElementById('qrModal').classList.add('hidden');
    }
</script>
@endsection
