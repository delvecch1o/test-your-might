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

    public function login($provider, $email, $password)
    {
        if($provider == 'user')
        {
            $user = User::where('email', $email)->first();
            if(!$user || !Hash::check($password, $user->password))
            {
                throw new UnauthorizedHttpException('message', 'Credenciais Invalidas');
            } else
            {
                $token = $user->createToken($user->email . '_Token')->plainTextToken;
                return [
                    'user' => $user,
                    'token' => $token
                ];
            }
        }
        elseif($provider == 'retailer')
        {
            $retailer = Retailer::where('email', $email)->first();
            if(!$retailer || !Hash::check($password, $retailer->password))
            {
                throw new UnauthorizedHttpException('message', 'Credenciais Invalidas');
            } else
            {
                $token = $retailer->createToken($retailer->email . '_Token')->plainTextToken;
                return [
                    'retailer' => $retailer,
                    'token' => $token
                ];
            }

        }
        else
        {
            throw new UnauthorizedHttpException('message', 'Erro, não autorizado');
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete(); 
    }
    
}