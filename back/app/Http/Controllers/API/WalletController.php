<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WalletService;
use App\Http\Requests\WalletRequest;

class WalletController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function create(WalletRequest $request)
    {
        $balance = $this->walletService->createService(
            ...array_values(
                $request->only([
                    'wallet',
                    'balance'
                ])
            )
        );

        return response()->json([
            'Saldo' => $balance,
            'message' => 'Carteira criada com sucesso!'
        ]);
    }

    public function show()
    {
        $show = $this->walletService->showService();
        return response()->json([
            'show' => $show
        ]);
    }
}
