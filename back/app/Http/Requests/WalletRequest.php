<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wallet' => 'required|unique:wallets,wallet',
            'balance' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'wallet.required' => 'A Carteira é obrigatório',
            'wallet.unique' => 'A Carteira ja foi Cadastrada',
            'balance.required' => 'O saldo inicial é obrigatório',
        ];
    }
}
