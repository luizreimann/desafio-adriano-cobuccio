<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WalletDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario 1 com saldo inicial
        $user1 = User::create([
            'name' => 'Alberto Gomes',
            'email' => 'albertogomes@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $wallet1 = Wallet::create([
            'user_id' => $user1->id,
            'balance' => 1000.00,
        ]);

        // Usuario 2 sem saldo inicial
        $user2 = User::create([
            'name' => 'Rubens Nogueira',
            'email' => 'rubensnogueira@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $wallet2 = Wallet::create([
            'user_id' => $user2->id,
            'balance' => 0.00,
        ]);

        // Transação de teste
        Transaction::create([
            'to_wallet_id' => $wallet2->id,
            'from_wallet_id' => $wallet1->id,
            'type' => 'transfer',
            'amount' => 200.00,
            'status' => 'completed',
        ]);

        $wallet1->balance -= 200.00;
        $wallet2->balance += 200.00;

        $wallet1->save();
        $wallet2->save();
    }
}