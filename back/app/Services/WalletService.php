<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletService
{
    public function createService($balance)
    {
        $user = Auth::user();
        $balance = $user->wallet()->create([
            'balance' => $balance
        ]);

        return $balance;
    }

    public function showService()
    {
        $user = Auth::user();
        $show = $user->wallet()->get();
        
        return $show;
    }
}

