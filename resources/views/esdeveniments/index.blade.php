@extends('layouts.master')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4 text-white">Esdeveniments Disponibles</h1>
    <div class="row">
        @foreach ($esdeveniments as $esdeveniment)
            @if ($esdeveniment->reserves < $esdeveniment->max_assistents)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" style="background-color: #d8b4f8; border: none;">
                        <div class="card-body">
                            <h5 class="card-title text-black">{{ $esdeveniment->nom }}</h5>
                            <p class="card-text text-black">Categoria: {{ $esdeveniment->categoria->nom }}</p>
                            <p class="card-text text-black">{{ Str::limit($esdeveniment->descripcio, 100) }}</p>
                            <a href="{{ route('esdeveniments.show', $esdeveniment->id) }}" class="btn btn-light">Veure més</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection