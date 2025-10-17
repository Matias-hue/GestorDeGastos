<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GastoController extends Controller
{
    /**
     * Dashboard: resumen de la semana actual
     */
    public function dashboard()
    {
        $user = Auth::user();
        $semanaActual = now()->weekOfYear;
        $anioActual = now()->year;

        $presupuesto = Presupuesto::where('user_id', $user->id)
            ->where('semana', $semanaActual)
            ->where('anio', $anioActual)
            ->first();

        $gastos = $presupuesto ? $presupuesto->gastos : collect();
        $totalGastos = $gastos->sum('monto');
        $restante = $presupuesto ? $presupuesto->monto - $totalGastos : 0;

        // Calcular rango de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('d/m/Y');
        $finSemana = Carbon::now()->endOfWeek(Carbon::SUNDAY)->format('d/m/Y');
        $rangoSemana = "Del $inicioSemana al $finSemana";

        return view('dashboard', compact('presupuesto', 'gastos', 'totalGastos', 'restante', 'rangoSemana'));
    }

    /**
     * Crear gasto
     */
    public function create()
    {
        return view('gastos.crear');
    }

    /**
     * Guardar gasto
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $semanaActual = now()->weekOfYear;
        $anioActual = now()->year;

        // Obtener o crear presupuesto semanal
        $presupuesto = Presupuesto::firstOrCreate(
            ['user_id' => $user->id, 'semana' => $semanaActual, 'anio' => $anioActual],
            ['monto' => 0]
        );

        Gasto::create([
            'user_id' => $user->id,
            'presupuesto_id' => $presupuesto->id,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Gasto agregado correctamente.');
    }

    /**
     * Eliminar un gasto individual
     */
    public function destroy($id)
    {
        $gasto = Gasto::findOrFail($id);
        $gasto->delete();

        return redirect()->back()->with('success', 'Gasto eliminado correctamente.');
    }

    /**
     * Historial de semanas (totales por semana)
     */
    public function historialSemanas()
    {
        $user = Auth::user();

        $semanas = Presupuesto::where('user_id', $user->id)
            ->orderByDesc('anio')
            ->orderByDesc('semana')
            ->get()
            ->map(function ($presupuesto) {
                $totalGastos = $presupuesto->gastos->sum('monto');
                $presupuesto->gastado = $totalGastos;
                $presupuesto->restante = $presupuesto->monto - $totalGastos;

                // Calcular inicio y fin de semana
                $inicio = Carbon::now()
                    ->setISODate($presupuesto->anio, $presupuesto->semana)
                    ->startOfWeek(Carbon::MONDAY)
                    ->format('d/m/Y');

                $fin = Carbon::now()
                    ->setISODate($presupuesto->anio, $presupuesto->semana)
                    ->endOfWeek(Carbon::SUNDAY)
                    ->format('d/m/Y');

                $presupuesto->rango = "Del $inicio al $fin";

                return $presupuesto;
            });

        return view('gastos.historialSemanas', compact('semanas'));
    }

    /**
     * Ver una semana específica
     */
    public function verSemana($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $gastos = $presupuesto->gastos;

        // Mostrar rango de fechas de esa semana
        $inicio = Carbon::now()
            ->setISODate($presupuesto->anio, $presupuesto->semana)
            ->startOfWeek(Carbon::MONDAY)
            ->format('d/m/Y');

        $fin = Carbon::now()
            ->setISODate($presupuesto->anio, $presupuesto->semana)
            ->endOfWeek(Carbon::SUNDAY)
            ->format('d/m/Y');

        $rangoSemana = "Del $inicio al $fin";

        return view('gastos.verSemana', compact('presupuesto', 'gastos', 'rangoSemana'));
    }

    /**
     * Eliminar una semana completa
     */
    public function eliminarSemana($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->gastos()->delete();
        $presupuesto->delete();

        return redirect()->route('gastos.historialSemanas')->with('success', 'Semana eliminada correctamente.');
    }
}
