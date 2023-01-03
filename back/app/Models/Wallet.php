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
        'wallet',
        'balance',
        
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit($value)
    {
        $this->update([
            'balance' => $this->attributes['balance'] + $value
        ]);
    }

    public function withdraw($value)
    {
        $this->update([
            'balance' => $this->attributes['balance'] - $value
        ]);
    }

}
