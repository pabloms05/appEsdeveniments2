<nav class="navbar navbar-expand-lg" style="background-color: #6a0dad; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">Esdeveniments</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/esdeveniments') }}">Esdeveniments</a>
                    </li>
                    <li class="nav-item">
                        <form class="d-flex ms-3" method="GET" action="{{ route('esdeveniments.index') }}">
                            <select name="categoria" class="form-select me-2" onchange="this.form.submit()">
                                <option value="">Totes les categories</option>
                                @foreach ($categories as $categoria)
                                    <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('esdeveniments.create') }}">Afegir Esdeveniment</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Tanca sessió</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/') }}">Inicia sessió</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Registra't</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>