<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold">Histórico de Transações</h2>
            <div class="text-muted">
                Seu Saldo: R$ {{ number_format(optional(Auth::user()->wallet)->balance ?? 0, 2, ',', '.') }}
            </div>
        </div>
    </x-slot>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($transactions->isEmpty())
            <div class="alert alert-info">Nenhuma transação encontrada.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>De</th>
                        <th>Para</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $t)
                        <tr>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($t->type) }}</td>
                            <td>R$ {{ number_format($t->amount, 2, ',', '.') }}</td>
                            <td>{{ $t->from_wallet_id ?? '-' }}</td>
                            <td>{{ $t->to_wallet_id ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $t->status === 'completed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                                @if ($t->type === 'transfer' && $t->status === 'completed')
                                    <form action="{{ route('wallet.revert', $t->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Reverter</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>