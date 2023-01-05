<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Wallet extends Model
{
    use UUID;
    use HasFactory, softDeletes;

    protected $fillable = [
        'balance',
        
    ];

    public function transactionsAsPayer()
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id');
    }

    public function transactionsAsPayee()
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
