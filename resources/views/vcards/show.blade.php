@extends('layouts.app')

@section('title', 'vCard de ' . $vcard->name . ' ' . $vcard->lastname)

@section('content')
<div class="vcard-container">
  <div class="header">
    <div class="profile-pic">
      <img src="{{ $vcard->image ? asset('storage/' . $vcard->image) : '' }}" alt="Foto de perfil">
    </div>
    <h2>{{ $vcard->name }} {{ $vcard->lastname }}</h2>
    <p>{{ $vcard->position }}</p>
  </div>
  <div class="content">
    <div class="contact-icons">
      <a href="tel:{{ $vcard->phone }}">
        <div class="icon-item">
          <i class="fas fa-phone-alt"></i>
        </div>
      </a>
      <a href="mailto:{{ $vcard->email }}">
        <div class="icon-item">
          <i class="fas fa-envelope"></i>
        </div>
      </a>
      <a href="https://wa.me/{{ $vcard->phone }}">
        <div class="icon-item">
          <i class="fab fa-whatsapp"></i>
        </div>
      </a>
    </div>
    <div class="logo-image">
      @if($vcard->company && $vcard->company->logo)
        <img src="{{ asset('storage/' . $vcard->company->logo) }}" alt="Logo Empresa">
      @endif
    </div>
    <div class="contact-info">
      <p id="phone-info">
        <i class="fas fa-phone-alt"></i><strong> Teléfono:</strong><span class="phone"> {{ $vcard->phone }}</span>
      </p>
      <p id="email-info">
        <i class="fas fa-envelope"></i><strong> Email:</strong><span class="email"> {{ $vcard->email }}</span>
      </p>
      <p id="website-info">
        @if($vcard->company)
          <i class="fas fa-globe"></i><strong> Web:</strong><a href="{{ $vcard->company->website }}"><span class="website">{{ $vcard->company->website }}</span></a>
        @endif
      </p>
    </div>        
    <button class="add-contact-button">
      <i class="fas fa-user-plus"></i> Añadir a Contactos
    </button>
    <div class="social-icons">
      <a href="https://www.instagram.com/macrosad_/"><i class="fab fa-instagram"></i></a>
      <a href="https://www.youtube.com/channel/UCuIgqKsaQe3idJhCeUQCo_A"><i class="fab fa-youtube"></i></a>
      <a href="https://www.linkedin.com/company/macrosad/"><i class="fab fa-linkedin"></i></a>
      <a href="https://twitter.com/macrosad"><i class="fab fa-x-twitter"></i></a>
      <a href="https://www.facebook.com/macrosad/"><i class="fab fa-facebook"></i></a>
    </div>
  </div>
  <div class="copy-confirm" id="copy-confirm">Copiado</div>
</div>
@endsection
