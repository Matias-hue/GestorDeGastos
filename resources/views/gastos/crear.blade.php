@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Agregar Gasto</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('gastos.store') }}" method="POST" class="form-gasto">
        @csrf

        <label for="descripcion">Descripción</label>
        <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
        @error('descripcion')
            <span class="error">{{ $message }}</span>
        @enderror

        <label for="monto">Monto</label>
        <input type="number" id="monto" name="monto" value="{{ old('monto') }}" step="0.01" required>
        @error('monto')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Agregar Gasto</button>
    </form>

    <div class="volver">
        <button onclick="location.href='{{ route('principal') }}'">Volver a Inicio</button>
    </div>
</div>
@endsection
