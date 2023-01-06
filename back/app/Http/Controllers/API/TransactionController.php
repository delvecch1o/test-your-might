<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function postTransaction(TransactionRequest $request)
    {
        $payer = Auth::user();
        $payee = User::findOrFail($request->get('payee_id'));
        $amount = $request->get('amount');
        $transaction = $this->transactionService->makeTransaction(
            $payer, $payee, $amount
        );
        return response()->json([
            'status' => $transaction
        ]);
    }

   
}
