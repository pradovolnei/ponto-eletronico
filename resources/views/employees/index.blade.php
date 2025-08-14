@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Funcionários</h3>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Novo Funcionário</a>
</div>

@if($employees->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>E-mail</th>
                <th>Cargo</th>
                <th>Gestor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->cpf }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->cargo }}</td>
                    <td>{{ $employee->manager?->name }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este funcionário?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $employees->links() }}
@else
    <p>Nenhum funcionário cadastrado.</p>
@endif
@endsection
