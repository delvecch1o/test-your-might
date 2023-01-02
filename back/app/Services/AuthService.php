<?php

namespace App\Services;

use App\Models\User;
use App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Exception;

class AuthService
{

    public function createUser($name, $email, $password, $cpf)
    {
    
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'cpf' => $cpf,
           
                    
        ]);

        $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return [
            'user' => $user,
            'token' => $token,
                
            ];
        
        
    }

    public function createRetailer($name, $email, $password, $cnpj)
    {
    
        $retailer = Retailer::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'cnpj' => $cnpj,
                    
        ]);

        $token = $retailer->createToken($retailer->email . '_Token')->plainTextToken;
            return [
            'retailer' => $retailer,
            'token' => $token,
                
        ];
        
        
    }

}