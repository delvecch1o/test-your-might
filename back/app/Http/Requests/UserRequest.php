<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfOrCnpj;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_user' => [ 'required',Rule::in(['user', 'retailer']) ],
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'CpfOrCnpj' => [ 'required',new CpfOrCnpj , 'unique:users,CpfOrCnpj' ],
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
       return[
        'type_user.in' => ' O usuário selecionado é inválido , insira user ou retailer',
        'name.required' => 'O nome é obrigatório',
        'email.unique' => 'O email ja foi cadastrado',
        'CpfOrCnpj.required' => 'O cpf ou cnpj é obrigatório',
        'CpfOrCnpj.unique' => 'O cpf ou cnpj ja foi cadastrado',
        'password.required' => 'A senha é obrigatório',
        'password.confirmed' => 'As senhas não são iguais',
        'password.min' => 'Senha muito curta, mínimo 8 caracteres',
        'password_confirmation.required' => 'Confirmação da senha é obrigatório',
       ] ;
    }
}
