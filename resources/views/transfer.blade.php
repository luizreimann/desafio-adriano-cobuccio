<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold">Transferência</h2>
            <div class="text-muted">
                Seu Saldo: R$ {{ number_format(optional(Auth::user()->wallet)->balance ?? 0, 2, ',', '.') }}
            </div>
        </div>
    </x-slot>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('wallet.transfer') }}">
            @csrf
            <div class="mb-3">
                <label for="to_wallet_id" class="form-label">Destinatário (Wallet ID)</label>
                <input type="number" name="to_wallet_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Transferir</button>
        </form>
    </div>
</x-app-layout>