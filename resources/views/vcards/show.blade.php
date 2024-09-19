<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'vCard de ' . $vcard->name . ' ' . $vcard->lastname)</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('scripts/scripts.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
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
            <!-- Mostrar este div solo si show_brands es 'yes' -->
            @if($vcard->show_brands == 'yes')
            <div class="logo-marcas">
                <img src="{{ asset('img/marcas.svg') }}" alt="Logos">
            </div>
            @endif
            <div class="contact-info">
                <p id="phone-info">
                    <i class="fas fa-phone-alt"></i><strong> Teléfono:</strong><span class="phone">{{ $vcard->phone }}</span>
                </p>
                <p id="email-info">
                    <i class="fas fa-envelope"></i><strong> Email:</strong><span class="email">{{ $vcard->email }}</span>
                </p>
                <p id="website-info">
                    @if($vcard->company)
                    <i class="fas fa-globe"></i><strong> Web:</strong><a href="https://www.macrosad.com"><span class="website">www.macrosad.com</span></a>
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
</body>

</html>