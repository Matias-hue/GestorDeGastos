@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Historial de Gastos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($gastos->isEmpty())
        <p class="text-center">No hay gastos registrados todavía.</p>
    @else
        <table class="tabla-gastos">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gastos as $gasto)
                <tr>
                    <td>{{ $gasto->fecha->format('d/m/Y') }}</td>
                    <td>{{ $gasto->descripcion }}</td>
                    <td>${{ number_format($gasto->monto, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="volver">
        <button onclick="location.href='{{ route('principal') }}'">Volver a Inicio</button>
    </div>
</div>
@endsection