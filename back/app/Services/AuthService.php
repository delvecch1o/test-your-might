<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Exception;

class AuthService
{

    public function createUser($type_user, $name, $email, $password, $CpfOrCnpj)
    {
        $user = User::create([
            'type_user' => $type_user,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'CpfOrCnpj' => $CpfOrCnpj,
           
                    
        ]);

        $token = $user->createToken($user->email . '_Token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
                
        ];
        
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if(!$user || !Hash::check($password, $user->password))
        {
             throw new UnauthorizedHttpException('message', 'Credenciais Invalidas');
        } 
        else
        {
            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        
    }

    public function logout()
    {
        auth()->user()->tokens()->delete(); 
    }
    
}