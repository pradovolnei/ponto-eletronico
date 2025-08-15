@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Funcionários</h3>
    <a href="{{ route('employees.create') }}" class="btn btn-primary shadow-sm">+ Novo Funcionário</a>
</div>

@if($employees->count())
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Gestor</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->cpf }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->cargo }}</td>
                        <td>{{ $employee->manager?->name ?? 'N/A' }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Ações do funcionário">
                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-info" title="Ver"><i class="bi bi-eye"></i> Ver</a>
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este funcionário?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i> Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $employees->links() }}
    </div>
@else
    <div class="alert alert-info text-center" role="alert">
        Nenhum funcionário cadastrado.
    </div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush