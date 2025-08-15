@extends('layouts.app')

@section('title', 'Marcar Ponto')

@section('content')
    @if(auth()->check() && auth()->user()->role === 'employee')
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h4 class="mb-4">Registro de Ponto</h4>

                        {{-- Mensagens de sucesso/erro --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    <div>{{ $err }}</div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Botão para registrar ponto --}}
                        <form method="POST" action="{{ route('punch.store') }}">
                            @csrf
                            <button type="submit" class="btn btn-lg btn-success px-5 py-3">
                                <i class="bi bi-clock-fill me-2"></i> Marcar Ponto
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Lista dos últimos pontos --}}
                @if($punches->count() > 0)
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <strong>Últimos Registros</strong>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($punches as $punch)
                                <div class="list-group-item">
                                    <strong>#{{ $punch->id }}</strong> —
                                    <span>{{ $punch->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        Nenhum registro de ponto encontrado.
                    </div>
                @endif

            </div>
        </div>
    @endif
@endsection
