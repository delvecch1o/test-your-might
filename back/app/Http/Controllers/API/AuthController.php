<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RetailerRequest;
use App\Http\Requests\LoginRequest;



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

    public function login(LoginRequest $request, $provider)
    {
        $data = $this->authService->login(
            ...[$provider, ...array_values(
                $request->only([
                    'provider',
                    'email',
                    'password'
                ])
            )]
        );
        return response()->json([
            'details' => $data,
            'message' => 'Login Com Sucesso!'
        ]);

    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'status' => 200,
            'message' => 'Usuario saiu com Sucesso'

        ]);
    }

}
