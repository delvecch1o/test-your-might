<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function makeTransaction(User $payer, User $payee, float $amount)
    {
        $payerWallet =  $payer->wallet()->first();
        $payeeWallet = $payee->wallet()->first();
        $payload =[
            'id' => Uuid::uuid4()->toString(),
            'payer_wallet_id' =>  $payerWallet->id,
            'payee_wallet_id' => $payeeWallet->id,
            'amount' => $amount,
        ];

        return DB::transaction(function () use ($payload, $payerWallet, $payeeWallet, $amount){

            $transaction = Transaction::create($payload);
            
            
            if($payerWallet->balance >= $amount){
                
                $payerWallet->balance -= $amount;
                $payerWallet->save();

            } else{
                return 'ERRO';
            }
            

            $payeeWallet->balance += $amount;
            $payeeWallet->save();
            
            return $transaction;
        });
    }
   
}