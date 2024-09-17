@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Empresa</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Empresa</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo (SVG)</label>
                <input type="file" name="logo" id="logo" class="form-control" accept=".svg">
                @if ($company->logo)
                    <p>Logo actual:</p>
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Empresa" width="50">
                @endif
            </div>

            <button type="submit" class="btn btn-warning">Actualizar Empresa</button>
        </form>
    </div>
</div>
@endsection
