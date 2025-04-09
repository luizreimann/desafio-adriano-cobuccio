<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService
{
    public function deposit(User $user, float $amount): Transaction
    {
        return DB::transaction(function () use ($user, $amount) {
            $wallet = $user->wallet;
            $wallet->balance += $amount;
            $wallet->save();

            Log::info('Depósito realizado', [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'new_balance' => $wallet->balance,
            ]);

            return $wallet->receivedTransactions()->create([
                'type' => 'deposit',
                'amount' => $amount,
                'status' => 'completed',
                'to_wallet_id' => $wallet->id,
            ]);
        });
    }

    public function transfer(User $fromUser, User $toUser, float $amount): Transaction
    {
        return DB::transaction(function () use ($fromUser, $toUser, $amount) {
            $fromWallet = $fromUser->wallet;
            $toWallet = $toUser->wallet;

            if ($fromWallet->balance < $amount) {
                throw new \Exception('Saldo insuficiente');
            }

            $fromWallet->balance -= $amount;
            $toWallet->balance += $amount;

            $fromWallet->save();
            $toWallet->save();

            Log::info('Transferência realizada', [
                'from_user_id' => $fromUser->id,
                'to_user_id' => $toUser->id,
                'amount' => $amount,
                'from_new_balance' => $fromWallet->balance,
                'to_new_balance' => $toWallet->balance,
            ]);

            return Transaction::create([
                'type' => 'transfer',
                'amount' => $amount,
                'status' => 'completed',
                'from_wallet_id' => $fromWallet->id,
                'to_wallet_id' => $toWallet->id,
            ]);
        });
    }

    public function revert(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {
            if ($transaction->status === 'reverted') {
                Log::warning('Tentativa de reverter transação já revertida', [
                    'transaction_id' => $transaction->id,
                    'type' => $transaction->type,
                    'status' => $transaction->status,
                ]);
                throw new \Exception('Transação já revertida');
            }

            if ($transaction->type === 'deposit') {
                $wallet = $transaction->toWallet;
                $wallet->balance -= $transaction->amount;
                $wallet->save();

                Log::info('Reversão de depósito realizada', [
                    'wallet_id' => $wallet->id,
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->id,
                ]);
            }

            if ($transaction->type === 'transfer') {
                $fromWallet = $transaction->fromWallet;
                $toWallet = $transaction->toWallet;

                $toWallet->balance -= $transaction->amount;
                $fromWallet->balance += $transaction->amount;

                $fromWallet->save();
                $toWallet->save();

                Log::info('Reversão de transferência realizada', [
                    'from_wallet_id' => $fromWallet->id,
                    'to_wallet_id' => $toWallet->id,
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->id,
                ]);
            }

            $transaction->status = 'reverted';
            $transaction->save();
        });
    }
}