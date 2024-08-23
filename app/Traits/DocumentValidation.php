<?php

namespace App\Traits;

trait DocumentValidation
{
    public function validarCpfOuCnpj($value)
    {
        // Remover qualquer caractere que não seja número
        $value = preg_replace('/\D/', '', $value);

        if (strlen($value) == 11) {
            return $this->validarCpf($value);
        } elseif (strlen($value) == 14) {
            return $this->validarCnpj($value);
        }

        return false;
    }

    public function validarCpf($cpf)
    {
        // Remove caracteres que não são números
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        // Validação do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        // Verifica se os dígitos verificadores estão corretos
        return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
    }


    public function validarCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $peso = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso[$i];
        }

        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        $peso = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso[$i];
        }

        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        return ($cnpj[12] == $digito1 && $cnpj[13] == $digito2);
    }
}
