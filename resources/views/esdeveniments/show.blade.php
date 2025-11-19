@extends('layouts.master')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Imatge de l'esdeveniment -->
            <img src="{{ asset('images/esdeveniments/' . $esdeveniment->imatge) }}" alt="{{ $esdeveniment->nom }}" class="img-fluid rounded shadow w-100">
        </div>
        <div class="col-md-6">
            <!-- Dades de l'esdeveniment -->
            <h1 class="text-white">{{ $esdeveniment->nom }}</h1>
            <p class="text-light"><strong>Categoria:</strong> {{ $esdeveniment->categoria->nom }}</p>
            <p class="text-light"><strong>Data:</strong> {{ $esdeveniment->data }}</p>
            <p class="text-light"><strong>Hora:</strong> {{ $esdeveniment->hora }}</p>
            <p class="text-light"><strong>Descripció:</strong> {{ $esdeveniment->descripcio }}</p>
            <p class="text-light"><strong>Edat mínima:</strong> {{ $esdeveniment->edat_minima }} anys </p>

            <!-- Entrades disponibles -->
            @php
                $entradesDisponibles = $esdeveniment->max_assistents - $esdeveniment->reserves;
            @endphp
            <p class="text-light"><strong>Entrades disponibles:</strong> {{ $entradesDisponibles > 0 ? $entradesDisponibles : 'No queden entrades disponibles' }}</p>

            <!-- Botó per reservar -->
            @if ($entradesDisponibles > 0)
                <!-- Botó que obre el modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmarReservaModal">
                    Reserva la teva entrada
                </button>
            @else
                <button class="btn btn-secondary" disabled>No queden entrades</button>
            @endif
            @if (Auth::check() && Auth::user()->role === 'admin')
                
                <form action="{{ route('esdeveniments.destroy', $esdeveniment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Segur que vols eliminar aquest esdeveniment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-inline">Eliminar</button>
                </form>
                <a href="{{ route('esdeveniments.edit', $esdeveniment->id) }}" class="btn btn-warning d-inline">Editar</a>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmació de reserva -->
<div class="modal fade" id="confirmarReservaModal" tabindex="-1" aria-labelledby="confirmarReservaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarReservaModalLabel">Confirmar reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tancar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nom:</strong> {{ $esdeveniment->nom }}</p>
        <p><strong>Data:</strong> {{ $esdeveniment->data }}</p>
        <p><strong>Hora:</strong> {{ $esdeveniment->hora }}</p>
        <p>Vols confirmar la teva reserva per aquest esdeveniment?</p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('esdeveniments.reserva', $esdeveniment->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
      </div>
    </div>
  </div>
</div>
@endsection