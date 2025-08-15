@extends('layouts.app')

@section('title', 'Trocar Senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="mb-4">Trocar Senha</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf

            <div class="mb-3">
                <label for="current_password" class="form-label">Senha Atual</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirme a Nova Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Alterar Senha</button>
            </div>
        </form>
    </div>
</div>
@endsection
