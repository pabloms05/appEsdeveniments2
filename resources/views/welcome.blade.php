<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aplicació d'Esdeveniments</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                background-color: #6a0dad; /* Fons morat */
            }
            .recuadre {
                background-color: #d8b4f8; /* Lila clar */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ombra per destacar el requadre */
                border-radius: 10px; /* Cantonades arrodonides */
            }
        </style>
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100">
        <div class="container text-center p-5 recuadre" style="max-width: 500px;">
            <!-- Logotip -->
            <img src="{{ asset('ChatGPT_Image_8_may_2025__11_28_48-removebg-preview.png') }}" alt="Logotip de l'Aplicació" class="img-fluid mb-4" style="width: 150px;">

            <!-- Títol -->
            <h1 class="h3 mb-3">Benvingut a l'Aplicació d'Esdeveniments</h1>

            <!-- Descripció -->
            <p class="text-muted mb-4">
                Descobreix i participa en els millors esdeveniments de la teva ciutat. Uneix-te a la nostra comunitat i no et perdis cap oportunitat!
            </p>

            <!-- Formulari d'inici de sessió -->
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/esdeveniments') }}" class="btn btn-primary w-100 mb-3">Accedeix al Tauler</a>
                @else
                    <form method="POST" action="{{ route('login') }}" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Correu electrònic" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Contrasenya" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Inicia sessió</button>
                    </form>

                    <!-- Enllaç per registrar-se -->
                    @if (Route::has('register'))
                        <p class="text-muted">
                            Encara no tens compte? <a href="{{ route('register') }}" class="text-decoration-none">Registra't aquí</a>.
                        </p>
                    @endif
                @endauth
            @endif
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>