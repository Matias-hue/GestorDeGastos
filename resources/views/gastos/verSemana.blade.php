@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detalle de la semana {{ $rangoSemana }}</h2>

    <p><strong>Presupuesto:</strong> ${{ number_format($presupuesto->monto, 2) }}</p>
    <p><strong>Gastado:</strong> ${{ number_format($gastos->sum('monto'), 2) }}</p>
    <p><strong>Restante:</strong> ${{ number_format($presupuesto->monto - $gastos->sum('monto'), 2) }}</p>

    <table class="table table-bordered mt-3">
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
                <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                <td>{{ $gasto->descripcion }}</td>
                <td>${{ number_format($gasto->monto, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('gastos.historialSemanas') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
