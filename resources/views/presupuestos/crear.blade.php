@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear / Editar Presupuesto Semanal</h2>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('presupuestos.store') }}">
        @csrf
        <label for="monto">Monto del presupuesto semanal:</label>
        <input type="number" name="monto" id="monto" step="0.01"
               value="{{ old('monto', $presupuesto->monto ?? '') }}"
               placeholder="Ingresá tu presupuesto semanal">

        <button type="submit">Guardar Presupuesto</button>
    </form>

    <div class="text-center" style="margin-top: 20px;">
        <button onclick="location.href='{{ route('principal') }}'">Volver al Inicio</button>
    </div>
</div>
@endsection
