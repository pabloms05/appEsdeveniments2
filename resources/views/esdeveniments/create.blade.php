@extends('layouts.master')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-white">Afegir Esdeveniment</h2>
    <form method="POST" action="{{ route('esdeveniments.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label text-white">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Categoria</label>
            <select name="categoria_id" class="form-select" required>
                @foreach($categories as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Data</label>
            <input type="date" name="data" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Hora</label>
            <input type="time" name="hora" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Descripció</label>
            <textarea name="descripcio" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Edat mínima</label>
            <textarea name="edat_minima" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Imatge</label>
            <input type="file" name="imatge" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Màxim d'assistents</label>
            <input type="number" name="max_assistents" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Afegir</button>
        <a href="{{ route('esdeveniments.index') }}" class="btn btn-secondary">Cancel·lar</a>
    </form>
</div>
@endsection