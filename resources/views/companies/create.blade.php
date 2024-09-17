@extends('layouts.app')

@section('title', 'Crear nueva Empresa')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Crear nueva Empresa</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Empresa</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo (SVG)</label>
                <input type="file" name="logo" id="logo" class="form-control" accept=".svg">
            </div>

            <button type="submit" class="btn btn-success">Crear Empresa</button>
        </form>
    </div>
</div>
@endsection
