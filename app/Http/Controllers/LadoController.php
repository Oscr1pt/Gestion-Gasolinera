<?php

namespace App\Http\Controllers;

use App\Models\Lado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LadoController extends Controller
{
    public function update(Request $request, Lado $lado): RedirectResponse
    {
        $validated = $request->validate([
            'habilitado' => 'required|boolean',
        ]);

        $lado->update([
            'habilitado' => $validated['habilitado'],
        ]);

        return back()->with('success', 'Lado actualizado.');
    }
}
