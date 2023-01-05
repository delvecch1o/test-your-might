<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    public function makeTransaction(User $payer, User $payee, float $amount)
    {
        $payerWallet = Auth::user()->type_user;
        if($payerWallet == 'retailer')
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Lojista não pode realizar transferência',
                'Type User => ' .$payerWallet
            ]);
        }
        else
        {
            $payerWallet =  $payer->wallet()->first();
            if($payerWallet->balance == 0)
            {
                throw ValidationException::withMessages(
                    ['message' => 
                    'Não foi possivel realizar a transação porque sua carteira esta vazia',
                  'Saldo => '  .$payerWallet->balance
                    ]);
                    
            }
            else
            {
            $payeeWallet = $payee->wallet()->first();
                $payload =[
                    'id' => Uuid::uuid4()->toString(),
                    'payer_wallet_id' =>  $payerWallet->id,
                    'payee_wallet_id' => $payeeWallet->id,
                    'amount' => $amount,
                ];

            }
           

        }
    
        return DB::transaction(function () use ($payload, $payerWallet, $payeeWallet, $amount){

            $transaction = Transaction::create($payload);
            
            if($payerWallet->balance >= $amount){
                $payerWallet->balance -= $amount;
                $payerWallet->save();

            } else{
                throw ValidationException::withMessages(
                    ['message' => 
                    'Você não tem dinhero suficiente para fazer esta transação',
                    'Saldo => ' .$payerWallet->balance
                ]);
            }
            
            $payeeWallet->balance += $amount;
            $payeeWallet->save();
            
            return $transaction;
        });
    }

   
}