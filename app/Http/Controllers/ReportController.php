<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Declaração de variáveis
        $start = $request->input('start'); 
        $end = $request->input('end');
        $records = []; 

        try {
            $where = "WHERE u.role = 'employee' ";
            $bindings = [];

            if ($start) {
                $where .= "AND p.created_at >= ? ";
                // Adiciona tempo para pegar todo o dia
                $bindings[] = $start . ' 00:00:00';
            }

            if ($end) {
                $where .= "AND p.created_at <= ? ";
                // Adiciona tempo para pegar todo o dia
                $bindings[] = $end . ' 23:59:59';
            }

            $sql = "
                SELECT
                    p.id AS registro_id,
                    u.name AS funcionario,
                    u.cargo AS cargo,
                    TIMESTAMPDIFF(YEAR, u.birth_date, CURDATE()) AS idade,
                    m.name AS gestor,
                    DATE_FORMAT(p.created_at, '%Y-%m-%d %H:%i:%s') AS data_hora
                FROM punches p
                JOIN users u ON p.user_id = u.id
                LEFT JOIN users m ON u.manager_id = m.id
                {$where}
                ORDER BY p.created_at DESC
            ";

            $records = DB::select($sql, $bindings);

        } catch (Exception $e) {
            // Exemplo: registra o erro no log
            \Log::error('Erro na consulta do relatório: ' . $e->getMessage());

            // Exemplo: retorna uma mensagem de erro para a view
            return view('reports.index', [
                'records' => [],
                'start' => $start,
                'end' => $end,
                'error' => 'Não foi possível carregar o relatório. Tente novamente mais tarde.'
            ]);
        }

        return view('reports.index', compact('records', 'start', 'end'));
    }
}
