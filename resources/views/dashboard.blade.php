<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            <h2 class="h4 fw-bold">Olá, {{ Auth::user()->name }}!</h2>
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Seu Saldo</h5>
                <p class="card-text display-6">R$ {{ number_format(optional(Auth::user()->wallet)->balance ?? 0, 2, ',', '.') }}</p>
                <a href="{{ url('/depositar') }}" class="btn btn-success me-2">Depositar</a>
                <a href="{{ url('/transferir') }}" class="btn btn-primary me-2">Transferir</a>
                <a href="{{ url('/historico') }}" class="btn btn-secondary">Histórico</a>
            </div>
        </div>
    </div>
</x-app-layout>