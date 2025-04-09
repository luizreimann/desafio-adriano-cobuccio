<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold">Depósito</h2>
            <div class="text-muted">
                Seu Saldo: R$ {{ number_format(optional(Auth::user()->wallet)->balance ?? 0, 2, ',', '.') }}
            </div>
        </div>
    </x-slot>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('wallet.deposit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Valor do Depósito</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Depositar</button>
        </form>
    </div>
</x-app-layout>