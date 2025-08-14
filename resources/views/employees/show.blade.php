@extends('layouts.app')

@section('content')
<h3>Detalhes do Funcionário</h3>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Nome:</strong> {{ $employee->name }}</li>
    <li class="list-group-item"><strong>CPF:</strong> {{ $employee->cpf }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $employee->email }}</li>
    <li class="list-group-item"><strong>Cargo:</strong> {{ $employee->cargo }}</li>
    <li class="list-group-item"><strong>Data de Nascimento:</strong> {{ $employee->birth_date?->format('d/m/Y') }}</li>
    <li class="list-group-item"><strong>CEP:</strong> {{ $employee->cep }}</li>
    <li class="list-group-item"><strong>Rua:</strong> {{ $employee->street }}</li>
    <li class="list-group-item"><strong>Número:</strong> {{ $employee->number }}</li>
    <li class="list-group-item"><strong>Complemento:</strong> {{ $employee->complement }}</li>
    <li class="list-group-item"><strong>Bairro:</strong> {{ $employee->neighborhood }}</li>
    <li class="list-group-item"><strong>Cidade:</strong> {{ $employee->city }}</li>
    <li class="list-group-item"><strong>Estado:</strong> {{ $employee->state }}</li>
    <li class="list-group-item"><strong>Gestor:</strong> {{ $employee->manager?->name }}</li>
</ul>

<a href="{{ route('employees.index') }}" class="btn btn-secondary">Voltar</a>
<a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">Editar</a>
@endsection
