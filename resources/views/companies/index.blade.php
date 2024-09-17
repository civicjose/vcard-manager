@extends('layouts.app')

@section('title', 'Listado de Empresas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de Empresas</h1>
    <a href="{{ route('companies.create') }}" class="btn btn-primary">Añadir nueva Empresa</a>
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
            <th>Logo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
                <td>
                    @if ($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Empresa" width="200">
                    @else
                        Sin logo
                    @endif
                </td>
                <td>
                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline-block">
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
