@extends('layouts.app')

@section('content')
<h3>Editar Funcionário</h3>

<form method="POST" action="{{ route('employees.update', $employee) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
    </div>

    <div class="mb-3">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $employee->cpf) }}" required>
    </div>

    <div class="mb-3">
        <label>E-mail</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
    </div>

    <div class="mb-3">
        <label>Cargo</label>
        <input type="text" name="cargo" class="form-control" value="{{ old('cargo', $employee->cargo) }}" required>
    </div>

    <div class="mb-3">
        <label>Data de nascimento</label>
        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $employee->birth_date?->format('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label>CEP</label>
        <input id="cep" type="text" name="cep" class="form-control" value="{{ old('cep', $employee->cep) }}" required>
    </div>

    <div class="mb-3">
        <label>Rua</label>
        <input id="street" type="text" name="street" class="form-control" value="{{ old('street', $employee->street) }}">
    </div>

    <div class="mb-3">
        <label>Bairro</label>
        <input id="neighborhood" type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood', $employee->neighborhood) }}">
    </div>

    <div class="mb-3">
        <label>Cidade</label>
        <input id="city" type="text" name="city" class="form-control" value="{{ old('city', $employee->city) }}">
    </div>

    <div class="mb-3">
        <label>Estado</label>
        <input id="state" type="text" name="state" class="form-control" value="{{ old('state', $employee->state) }}">
    </div>

    <div class="mb-3">
        <label>Número</label>
        <input type="text" name="number" class="form-control" value="{{ old('number', $employee->number) }}">
    </div>

    <div class="mb-3">
        <label>Complemento</label>
        <input type="text" name="complement" class="form-control" value="{{ old('complement', $employee->complement) }}">
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g,'');
    if (cep.length === 8) {
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(res => res.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('street').value = data.logradouro || '';
                    document.getElementById('neighborhood').value = data.bairro || '';
                    document.getElementById('city').value = data.localidade || '';
                    document.getElementById('state').value = data.uf || '';
                } else {
                    alert('CEP não encontrado');
                }
            });
    }
});
</script>
@endpush
