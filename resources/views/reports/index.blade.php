@extends('layouts.app')

@section('content')
<h3>Relatório de Registros de Ponto</h3>

<form method="GET">
    <div class="row g-2 align-items-end mb-3">
        <div class="col-auto">
            <label>De</label>
            <input type="date" name="start" class="form-control" value="{{ $start ?? '' }}">
        </div>
        <div class="col-auto">
            <label>Até</label>
            <input type="date" name="end" class="form-control" value="{{ $end ?? '' }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Registro</th>
            <th>Nome Funcionário</th>
            <th>Cargo</th>
            <th>Idade</th>
            <th>Nome Gestor</th>
            <th>Data e Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $r)
            <tr>
                <td>{{ $r->registro_id }}</td>
                <td>{{ $r->funcionario }}</td>
                <td>{{ $r->cargo }}</td>
                <td>{{ $r->idade }}</td>
                <td>{{ $r->gestor }}</td>
                <td>{{ date("d/m/Y H:i", strtotime($r->data_hora)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
