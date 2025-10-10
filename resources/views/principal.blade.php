@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestor de Gastos - Inicio</h1>

    <p>Bienvenido, {{ Auth::user()->name }}!</p>

    <div class="menu" style="margin-top: 20px;">
        <!-- Botones principales -->
        <button onclick="location.href='{{ route('presupuestos.crear') }}'" style="margin: 5px; padding: 10px 20px;">Crear/Editar Presupuesto</button>
        <button onclick="location.href='{{ route('gastos.crear') }}'" style="margin: 5px; padding: 10px 20px;">Agregar Gasto</button>
        <button onclick="location.href='{{ route('dashboard') }}'" style="margin: 5px; padding: 10px 20px;">Ver Dashboard</button>  
        <button onclick="location.href='{{ route('gastos.historialSemanas') }}'" style="margin: 5px; padding: 10px 20px;">Gastos Semanales</button>
    </div>
</div>
@endsection
