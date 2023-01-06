<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\MockyService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    private MockyService $mockyService;

    
    public function __construct(TransactionService $transactionService, MockyService $mockyService)
    {
        $this->transactionService = $transactionService;
        $this->mockyService = $mockyService;
    }

    public function postTransaction(TransactionRequest $request)
    {
        $payer = Auth::user();
        $payee = User::findOrFail($request->get('payee_id'));
        $amount = $request->get('amount');
        $status = $this->mockyService->authorizeTransaction();
        $transaction = $this->transactionService->makeTransaction(
            $payer, $payee, $amount
        );
        
        return response()->json([
            'status' => $status,
            'result' => $transaction
        ]);
    }

   
}
