<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Punch;

class PunchController extends Controller
{
    /**
     * Exibe a tela de marcação de ponto e os últimos registros
     */
    public function index()
    {
        $punches = auth()->user()
            ->punches()
            ->latest()
            ->take(10)
            ->get();

        return view('punches.index', compact('punches'));
    }

    /**
     * Registra um novo ponto para o usuário logado
     */
    public function store(Request $request)
    {
        Punch::create([
            'user_id' => $request->user()->id
        ]);

        return back()->with('success', 'Ponto registrado em ' . now()->format('d/m/Y H:i:s'));
    }
}
