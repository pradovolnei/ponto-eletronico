@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Relatório de Registros de Ponto</h3>
</div>

<form method="GET" class="mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label for="start_date" class="form-label">De</label>
            <input type="date" id="start_date" name="start" class="form-control" value="{{ $start ?? '' }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Até</label>
            <input type="date" id="end_date" name="end" class="form-control" value="{{ $end ?? '' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary shadow-sm">Filtrar</button>
        </div>
    </div>
</form>

<div class="table-responsive shadow-sm rounded-3">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col">ID Registro</th>
                <th scope="col">Nome Funcionário</th>
                <th scope="col">Cargo</th>
                <th scope="col">Idade</th>
                <th scope="col">Nome Gestor</th>
                <th scope="col">Data e Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
                <tr>
                    <td>{{ $r->registro_id }}</td>
                    <td>{{ $r->funcionario }}</td>
                    <td>{{ $r->cargo }}</td>
                    <td>{{ $r->idade }}</td>
                    <td>{{ $r->gestor }}</td>
                    <td>{{ date("d/m/Y H:i", strtotime($r->data_hora)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum registro encontrado para este período.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection