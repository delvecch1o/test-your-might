<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cnpj;

class RetailerRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
        'name' => 'required|max:191',
        'email' => 'required|email|max:191|unique:retailers,email',
        'cnpj' => ['required', new Cnpj, 'unique:retailers,cnpj'],
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
       return[
        'name.required' => 'O nome é obrigatório',
        'email.unique' => 'O email ja foi cadastrado',
        'cnpj.required' => 'O CNPJ é obrigatório',
        'cnpj.unique' => 'O CNPJ ja foi cadastrado',
        'password.required' => 'A senha é obrigatório',
        'password.confirmed' => 'As senhas não são iguais',
        'password.min' => 'Senha muito curta, mínimo 8 caracteres',
        'password_confirmation.required' => 'Confirmação da senha é obrigatório',
       ] ;
    }
}
