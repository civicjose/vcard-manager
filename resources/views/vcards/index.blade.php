@extends('layouts.app')

@section('title', 'Listado de vCards')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de vCards</h1>
    <a href="{{ route('vcards.create') }}" class="btn btn-primary">Añadir nueva vCard</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-hover table-bordered">
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
                        <img src="{{ asset('storage/' . $vcard->company->logo) }}" alt="Logo Empresa" width="50">
                    @else
                        Sin empresa
                    @endif
                </td>
                <td>
                    <a href="{{ route('vcards.edit', $vcard->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('vcards.destroy', $vcard->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
