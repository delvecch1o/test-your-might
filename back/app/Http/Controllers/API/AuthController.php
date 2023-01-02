<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Retailer;
use App\Services\AuthService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RetailerRequest;



class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function User(UserRequest $request)
    {
        $data = $this->authService->createUser(
             ...array_values(
                $request->only([
                    'name',
                    'email',
                    'password',
                    'cpf'
                      
                ])
            )
        );
        return response()->json([
            'status' => 200,
            'username'=> $data['user']->name,
            'token' => $data['token'],
            'message' => 'Usuario cadastrado com Sucesso!'
           
        ]);
    }

    public function Retailer(RetailerRequest $request)
    {
        $data = $this->authService->createRetailer(
             ...array_values(
                $request->only([
                    'name',
                    'email',
                    'password',
                    'cnpj'
                    
                    
                ])
            )
        );
        return response()->json([
            'status' => 200,
            'username'=> $data['retailer']->name,
            'token' => $data['token'],
            'message' => 'Varejista cadastrado com Sucesso!'
           
        ]);
    }

}
