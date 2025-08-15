<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Punch;
use Illuminate\Support\Facades\Log;

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
        try {
            Punch::create([
                'user_id' => $request->user()->id
            ]);

            return back()->with('success', 'Ponto registrado em ' . now()->format('d/m/Y H:i:s'));

        } catch (\Exception $e) {
            // Registra o erro para que você possa investigar depois
            Log::error('Erro ao registrar ponto: ' . $e->getMessage(), [
                'user_id' => $request->user()->id
            ]);

            // Retorna um erro amigável ao usuário
            return back()->with('error', 'Não foi possível registrar o ponto. Por favor, tente novamente.');
        }
    }
}
