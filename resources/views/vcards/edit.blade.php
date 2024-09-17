@extends('layouts.app')

@section('title', 'Editar vCard')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar vCard</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('vcards.update', $vcard->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $vcard->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Apellidos</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname', $vcard->lastname) }}" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Puesto</label>
                <input type="text" name="position" id="position" class="form-control" value="{{ old('position', $vcard->position) }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', $vcard->phone) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $vcard->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="company_id" class="form-label">Empresa</label>
                <select name="company_id" id="company_id" class="form-select">
                    <option value="">Selecciona una empresa</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $vcard->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Foto de perfil (opcional)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning">Actualizar vCard</button>
        </form>
    </div>
</div>
@endsection

