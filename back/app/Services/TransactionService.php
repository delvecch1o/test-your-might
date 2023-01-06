<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Services\AuthorizedTransactionService;

class TransactionService
{
    private AuthorizedTransactionService $authorizedTransactionService;
    public function __construct(AuthorizedTransactionService $authorizedTransactionService)
    {
        $this->authorizedTransactionService = $authorizedTransactionService;
    }

    public function makeTransaction(User $payer, User $payee, float $amount)
    {
    $userType = Auth::user()->type_user;
    if($userType === 'retailer')
    {
        throw ValidationException::withMessages(
            ['message' => 
            'Lojista não pode realizar transferência',
            'Type User => ' .$userType
        ]);
    }
    
    $payerWallet =  $payer->wallet()->first();
    if($payerWallet->balance < $amount)
    {
        throw ValidationException::withMessages(
            ['message' => 
            'Você não tem saldo suficiente para fazer esta transação',
            'Saldo => ' .$payerWallet->balance
        ]);
            
    }

    if(!$this->authorizedTransactionService->authorizeTransaction())
    {
        throw ValidationException::withMessages(
            ['message' => 
            'Transação não autorizada'
            
        ]);
    }
        
    $payeeWallet = $payee->wallet()->first();
        $payload =[
            'id' => Uuid::uuid4()->toString(),
            'payer_wallet_id' =>  $payerWallet->id,
            'payee_wallet_id' => $payeeWallet->id,
            'amount' => $amount,
        ];


        $transactionResult = DB::transaction(function () use ($payload, $payerWallet, $payeeWallet, $amount){

            $transaction = Transaction::create($payload);
        
            $payerWallet->balance -= $amount;
            $payerWallet->save();

            $payeeWallet->balance += $amount;
            $payeeWallet->save();

            return $transaction;
        });

        $this->authorizedTransactionService->notifyUser();
        return $transactionResult;
    }
   
}