@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <h2>Gestor de Gastos Semanal</h2>

    <!-- Mostrar mensajes -->
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- Presupuesto -->
    <section class="presupuesto-section">
        <h3>Presupuesto semanal</h3>
        <form action="{{ route('presupuestos.store') }}" method="POST" class="presupuesto-form">
            @csrf
            <input type="number" name="monto" step="0.01" placeholder="Ingresá tu presupuesto semanal"
                   value="{{ $presupuesto->monto ?? '' }}" required>
            <button type="submit">Guardar</button>
        </form>

        @if($presupuesto)
            <form action="{{ route('presupuestos.destroy', $presupuesto->id) }}" method="POST" onsubmit="return confirm('¿Eliminar presupuesto y todos los gastos de esta semana?')">
                @csrf
                @method('DELETE')
                <button class="btn-eliminar">Eliminar presupuesto</button>
            </form>
        @endif
    </section>

    <!-- Resumen de gastos -->
    @if($presupuesto)
    <section class="resumen-section">
        <h3>Resumen</h3>
        <p>Total gastado: <strong>${{ number_format($totalGastos, 2) }}</strong></p>
        <p>Presupuesto restante: <strong>${{ number_format($restante, 2) }}</strong></p>
    </section>

    <!-- Lista de gastos -->
    <section class="gastos-section">
        <h3>Gastos de la semana</h3>

        <a href="{{ route('gastos.crear') }}" class="btn-crear">+ Agregar gasto</a>

        @if($gastos->isEmpty())
            <p>No hay gastos esta semana.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gastos as $gasto)
                    <tr>
                        <td>{{ $gasto->descripcion }}</td>
                        <td>${{ number_format($gasto->monto, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('gastos.destroy', $gasto->id) }}" method="POST" onsubmit="return confirm('¿Eliminar gasto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-eliminar">🗑</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
    @endif
</div>
@endsection
