<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletService
{
    public function createService($wallet, $balance)
    {
        $user = Auth::user();
        $balance = $user->wallet()->create([
            'wallet' => $wallet,
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

