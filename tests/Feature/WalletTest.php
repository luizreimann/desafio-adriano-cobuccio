<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_depositar()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/deposit', [
            'amount' => 100.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'balance' => 100.00,
        ]);
    }

    public function test_transferencia_com_saldo_suficiente()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $wallet1 = Wallet::factory()->create(['user_id' => $user1->id, 'balance' => 200]);
        $wallet2 = Wallet::factory()->create(['user_id' => $user2->id, 'balance' => 0]);

        $response = $this->actingAs($user1)->post('/transfer', [
            'to_wallet_id' => $wallet2->id,
            'amount' => 50.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('wallets', ['id' => $wallet1->id, 'balance' => 150.00]);
        $this->assertDatabaseHas('wallets', ['id' => $wallet2->id, 'balance' => 50.00]);
    }

    public function test_transferencia_com_saldo_insuficiente_falha()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $wallet1 = Wallet::factory()->create(['user_id' => $user1->id, 'balance' => 10]);
        $wallet2 = Wallet::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->post('/transfer', [
            'to_wallet_id' => $wallet2->id,
            'amount' => 50.00,
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseHas('wallets', ['id' => $wallet1->id, 'balance' => 10.00]);
        $this->assertDatabaseHas('wallets', ['id' => $wallet2->id, 'balance' => 0.00]);
    }
}