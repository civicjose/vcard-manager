@extends('layouts.app')

@section('title', 'Listado de vCards')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de vCards</h1>
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
            <th>Email</th>
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
            <td>{{ $vcard->email }}</td>
            <td>
                @if ($vcard->company)
                {{ $vcard->company->name }}
                @else
                Sin empresa
                @endif
            </td>
            <td>
                <!-- Botón de Ver -->
                <a href="{{ route('vcards.show', [$vcard->slug]) }}" class="btn btn-info btn-sm">Ver</a>
                <!-- Otras acciones como Editar y Eliminar -->
                <a href="{{ route('vcards.edit', $vcard->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('vcards.destroy', $vcard->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
                <!-- Botón para ver el QR -->
                @if($vcard->qr_code)
                <button type="button" class="btn btn-secondary btn-sm" onclick="showQrCode(`{{ asset('storage' . $vcard->qr_code) }}`)">Ver QR</button>
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
    function showQrCode(imageUrl) {
        var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
        document.getElementById('qrImage').src = imageUrl;
        qrModal.show();
    }
</script>

<script>
    function searchTable() {
        // Obtener el valor del campo de búsqueda
        let input = document.getElementById('search');
        let filter = input.value.toLowerCase();

        // Obtener la tabla y todas las filas
        let table = document.getElementById('vcardTable');
        let rows = table.getElementsByTagName('tr');

        // Iterar sobre todas las filas, comenzando desde la segunda fila (para ignorar el encabezado)
        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];

            // Obtener todas las celdas en la fila
            let nameCell = row.getElementsByTagName('td')[0];
            let lastnameCell = row.getElementsByTagName('td')[1];
            let positionCell = row.getElementsByTagName('td')[2];
            let phoneCell = row.getElementsByTagName('td')[3];
            let mailCell = row.getElementsByTagName('td')[4];
            let companyCell = row.getElementsByTagName('td')[5];

            // Comprobar si las celdas contienen el valor buscado
            if (nameCell || lastnameCell || phoneCell || mailCell || companyCell) {
                let nameText = nameCell.textContent.toLowerCase();
                let lastnameText = lastnameCell.textContent.toLowerCase();
                let positionText = positionCell.textContent.toLowerCase();
                let phoneText = phoneCell.textContent.toLowerCase();
                let mailText = mailCell.textContent.toLowerCase();
                let companyText = companyCell.textContent.toLowerCase();

                // Si cualquier celda coincide, mostramos la fila, de lo contrario la ocultamos
                if (nameText.indexOf(filter) > -1 ||
                    lastnameText.indexOf(filter) > -1 ||
                    positionText.indexOf(filter) > -1 ||
                    phoneText.indexOf(filter) > -1 ||
                    mailText.indexOf(filter) > -1 ||
                    companyText.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }
</script>
@endsection