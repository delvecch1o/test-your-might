<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'amount' => 'required|numeric|gt:0',
            'payee_id' => 'required|string',
        ];
    }

    public function messages()
    {
       return[
        'amount.required' => 'O Valor é obrigatório',
        'amount.numeric' => 'Por favor insira um valor válido',
        'amount.min' => 'O Valor deve ser maior que 0 para a transferencia',
        'payee_id.required' => 'O Beneficiario da transação é obrigatório'
        
       ] ;
    }
}
