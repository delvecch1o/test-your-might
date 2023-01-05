<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfOrCnpj implements Rule
{
    
    public function passes($attribute, $value)
    {
        $document = preg_replace( '/[^0-9]/is', '', $value);

        if(strlen($document) == 11)  {

            if (preg_match('/(\d)\1{10}/', $document)) {
                return false;
            }
            for ($tamanho = 9; $tamanho < 11; $tamanho++) {
                for ($digito = 0, $contador = 0; $contador < $tamanho; $contador++) {
                    $digito += $document[$contador] * (($tamanho + 1) - $contador);
                }
                $digito = ((10 * $digito) % 11) % 10;
                if ($document[$contador] != $digito) {
                    return false;
                }
            }
    
            return true;

        }elseif(strlen($document) == 14){
            
            if (preg_match('/(\d)\1{13}/', $document)) {
                return false;
            }
            
            for ($t = 12; $t < 14; $t++) {
                for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
                    $d += $document[$i] * $m;
                    $m = ($m == 2 ? 9 : --$m);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($document[$i] != $d) {
                    return false;
                }
            }
            return true;
            
              
        } 
       
    }


    public function message()
    {
        return 'CPF ou CNPJ inválido.';
    }
}
