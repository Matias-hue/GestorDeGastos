@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Historial de Semanas</h2>

    @if($semanas->isEmpty())
        <p>No hay semanas registradas todavía.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Semana</th>
                    <th>Año</th>
                    <th>Presupuesto</th>
                    <th>Gastado</th>
                    <th>Restante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semanas as $semana)
                <tr>
                    <td>{{ $semana->semana }}</td>
                    <td>{{ $semana->anio }}</td>
                    <td>${{ number_format($semana->monto, 2) }}</td>
                    <td>${{ number_format($semana->gastado, 2) }}</td>
                    <td>${{ number_format($semana->restante, 2) }}</td>
                    <td>
                        <a href="{{ route('gastos.verSemana', $semana->id) }}" class="btn btn-primary btn-sm">Ver</a>
                        <form action="{{ route('gastos.eliminarSemana', $semana->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar toda la semana?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-3">
        <a href="{{ route('principal') }}" class="btn btn-secondary">Volver a Inicio</a>
    </div>
</div>
@endsection
