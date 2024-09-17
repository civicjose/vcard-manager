@extends('layouts.app')

@section('title', 'Crear nueva vCard')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Crear nueva vCard</h2>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="card-body">
        <form action="{{ route('vcards.store') }}" method="POST" enctype="multipart/form-data">
            @csrf  <!-- Token CSRF es obligatorio para formularios POST -->
            
            <!-- Nombre -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="lastname" class="form-label">Apellidos</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}" required>
            </div>

            <!-- Puesto -->
            <div class="mb-3">
                <label for="position" class="form-label">Puesto</label>
                <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}" required>
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="+34 000 000 000" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <!-- Empresa -->
            <div class="mb-3">
                <label for="company_id" class="form-label">Empresa</label>
                <select name="company_id" id="company_id" class="form-select">
                    <option value="">Selecciona una empresa</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto de perfil -->
            <div class="mb-3">
                <label for="image" class="form-label">Foto de perfil (opcional)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <!-- Botón para enviar -->
            <button type="submit" class="btn btn-success">Crear vCard</button>
        </form>
    </div>
</div>
@endsection
