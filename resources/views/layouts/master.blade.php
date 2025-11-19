<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <title>@yield('title', 'Aplicació d\'Esdeveniments')</title>

    <style>
        body {
            background-color: #6a0dad; /* Fons morat */
            color: black; /* Text blanc per defecte */
        }
        .card {
            background-color: #d8b4f8; /* Fons lila clar per a les targetes */
            border: none;
        }
        .navbar, footer {
            background-color: #6a0dad; /* Navbar i footer morats */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ombra per destacar */
        }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Contingut principal -->
    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Footer -->
    {{-- <footer class="bg-light text-center py-3 mt-4">
        <p class="mb-0">&copy; {{ date('Y') }} Aplicació d'Esdeveniments. Tots els drets reservats.</p>
    </footer> --}}
    <footer class="text-center py-3" style="background-color: #6a0dad; box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);">
    <p class="mb-0 text-white">&copy; {{ date('Y') }} Aplicació d'Esdeveniments. Tots els drets reservats.</p>
    </footer>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>