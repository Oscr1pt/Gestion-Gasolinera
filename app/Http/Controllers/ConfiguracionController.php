<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionTurno;
use App\Models\ConfiguracionGeneral;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('configuracion.index');
    }

    public function turnos()
    {
        $turnos = ConfiguracionTurno::all()->keyBy('turno');
        return view('configuracion.turnos', compact('turnos'));
    }

    public function updateTurnos(Request $request)
    {
        $request->validate([
            'turnos.matutino.hora_inicio' => 'required|date_format:H:i',
            'turnos.matutino.hora_fin' => 'required|date_format:H:i',
            'turnos.nocturno.hora_inicio' => 'required|date_format:H:i',
            'turnos.nocturno.hora_fin' => 'required|date_format:H:i',
        ]);

        foreach ($request->turnos as $turno => $data) {
            ConfiguracionTurno::where('turno', $turno)->update([
                'hora_inicio' => $data['hora_inicio'],
                'hora_fin' => $data['hora_fin']
            ]);
        }

        return redirect()->route('configuracion.turnos')->with('success', 'Horarios de turnos actualizados correctamente.');
    }

    public function sistema()
    {
        $generales = ConfiguracionGeneral::all()->keyBy('clave');
        return view('configuracion.sistema', compact('generales'));
    }

    public function updateSistema(Request $request)
    {
        $request->validate([
            'generales.nombre_sistema' => 'required|string|max:255',
            'generales.nombre_empresa' => 'required|string|max:255',
        ]);

        foreach ($request->generales as $clave => $valor) {
            ConfiguracionGeneral::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor]
            );
        }

        return redirect()->route('configuracion.sistema')->with('success', 'Ajustes del sistema actualizados correctamente.');
    }

    public function regional()
    {
        $generales = ConfiguracionGeneral::all()->keyBy('clave');
        return view('configuracion.regional', compact('generales'));
    }

    public function updateRegional(Request $request)
    {
        $request->validate([
            'generales.zona_horaria' => 'required|string|max:255',
            'generales.simbolo_moneda' => 'required|string|max:10',
        ]);

        foreach ($request->generales as $clave => $valor) {
            ConfiguracionGeneral::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor]
            );
        }

        return redirect()->route('configuracion.regional')->with('success', 'Ajustes regionales actualizados correctamente.');
    }
}
