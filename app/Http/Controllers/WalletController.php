<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $transaction = $this->walletService->deposit(Auth::user(), $request->amount);

        return redirect()
            ->back()
            ->with('success', 'Depósito realizado com sucesso!');
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'to_wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $toWallet = Wallet::findOrFail($request->to_wallet_id);
        $toUser = $toWallet->user;

        try {
            $transaction = $this->walletService->transfer(Auth::user(), $toUser, $request->amount);
        
            return redirect()
                ->back()
                ->with('success', 'Transferência realizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => $e->getMessage()]);
        }

        return redirect()
        ->back()
        ->with('success', 'Transferência realizada com sucesso!');    
    }

    public function revert(Transaction $transaction)
    {
        try {
            $this->walletService->revert($transaction);
            return redirect()->back()->with('success', 'Transação revertida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erro' => $e->getMessage()]);
        }
    }
}