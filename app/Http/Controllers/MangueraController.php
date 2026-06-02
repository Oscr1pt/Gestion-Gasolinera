<?php

namespace App\Http\Controllers;

use App\Models\Manguera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MangueraController extends Controller
{
    public function update(Request $request, Manguera $manguera): RedirectResponse
    {
        $validated = $request->validate([
            'habilitado' => 'required|boolean',
        ]);

        $manguera->update([
            'habilitado' => $validated['habilitado'],
        ]);

        return back()->with('success', 'Manguera actualizada.');
    }
}
