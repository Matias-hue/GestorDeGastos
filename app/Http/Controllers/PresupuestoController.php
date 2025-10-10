<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;

class PresupuestoController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $semanaActual = now()->weekOfYear;

        $presupuesto = Presupuesto::where('user_id', $user->id)
            ->where('semana', $semanaActual)
            ->first();

        return view('presupuestos.crear', compact('presupuesto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $semanaActual = now()->weekOfYear;

        Presupuesto::updateOrCreate(
            ['user_id' => $user->id, 'semana' => $semanaActual],
            ['monto' => $request->monto]
        );

        return redirect()->route('dashboard')->with('success', 'Presupuesto guardado correctamente.');
    }

    public function destroy($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->delete();

        return redirect()->route('dashboard')->with('success', 'Presupuesto eliminado correctamente.');
    }
}
