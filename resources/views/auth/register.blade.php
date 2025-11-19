@extends('layouts.master')

@section('content')
<style>
    .recuadre {
        background-color: #d8b4f8; /* Lila clar */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
</style>
<div class="container my-5 d-flex justify-content-center">
    <div class="p-4 recuadre" style="max-width: 400px; width:100%;">
        <h2 class="mb-4 text-center">Registra't</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Correu electrònic</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Data de naixement</label>
                <input type="date" name="birth_date" class="form-control" required value="{{ old('birth_date') }}">
                @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contrasenya</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Repeteix la contrasenya</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrar-se</button>
        </form>
    </div>
</div>
@endsection
