@extends('layouts.app')

@section('title', 'Listado de vCards')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Listado de vCards</h1>
    <a href="{{ route('vcards.create') }}" class="btn btn-primary">Añadir nueva vCard</a>
</div>

<!-- Campo de búsqueda -->
<div class="mb-3">
    <input type="text" id="search" class="form-control" placeholder="Buscar por nombre, apellidos, teléfono, empresa..." onkeyup="searchTable()">
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-hover table-bordered" id="vcardTable">
    <thead class="table-dark">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Puesto</th>
            <th>Teléfono</th>
            <th>Empresa</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vcards as $vcard)
        <tr>
            <td>{{ $vcard->name }}</td>
            <td>{{ $vcard->lastname }}</td>
            <td>{{ $vcard->position }}</td>
            <td>{{ $vcard->phone }}</td>
            <td>
                @if($vcard->company)
                {{ $vcard->company->name }}
                @else
                Sin empresa
                @endif
            </td>
            <td>
                <a href="{{ route('vcards.show', [$vcard->slug]) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('vcards.edit', $vcard->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('vcards.destroy', $vcard->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
                <!-- Botón para ver el QR -->
                @php
                $qrUrl = asset('storage/' . $vcard->qr_code);
                @endphp

                @if($vcard->qr_code)
                <button type="button" class="btn btn-secondary btn-sm" onclick="showQrCode('{{ $qrUrl }}')">Ver QR</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal para mostrar el QR -->
<div id="qrModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Código QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrImage" src="" alt="Código QR" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function searchTable() {
        let input = document.getElementById('search').value.toLowerCase();
        let rows = document.querySelectorAll('#vcardTable tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }

    function showQrCode(imageUrl) {
        var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
        document.getElementById('qrImage').src = imageUrl;
        qrModal.show();
    }
</script>
@endsection