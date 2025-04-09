<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WalletController;
use App\Models\Transaction;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::post('/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
    Route::post('/transactions/{transaction}/revert', [WalletController::class, 'revert'])->name('wallet.revert');
});


Route::middleware('auth')->get('/depositar', function () {
    return view('deposit');
});

Route::middleware('auth')->get('/transferir', function () {
    return view('transfer');
});

Route::middleware('auth')->get('/historico', function () {
    $user = Auth::user();

    $transactions = Transaction::where('from_wallet_id', optional($user->wallet)->id)
        ->orWhere('to_wallet_id', optional($user->wallet)->id)
        ->latest()
        ->get();

    return view('history', compact('transactions'));
});