<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = ['balance'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_wallet_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_wallet_id');
    }
}
