<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Transaction extends Model
{
    use UUID;
    use HasFactory, softDeletes;
    protected $table = 'wallet_transactions';
    protected $fillable = [
       'id',
       'payer_wallet_id',
       'payee_wallet_id',
       'amount',
        
    ];

    public function walletPayer()
    {
        return $this->belongsTo(Wallet::class , 'payer_wallet_id');
    }

    public function walletPayee()
    {
        return $this->belongsTo(Wallet::class , 'payee_wallet_id');
    }


}
