<?php

namespace Junges\CpfCnpjValidator;

use Junges\CpfCnpjValidator\Enums\TaxId;

class Validator
{
    /**
     * Determines whether the given number is a valid CPF or CNPJ.
     *
     * @param  string  $number
     * @param  \Junges\CpfCnpjValidator\Enums\TaxId|null  $type
     * @return bool
     */
    public function __invoke(string $number, TaxId $type = null): bool
    {
        $number = self::removeNonNumericCharacters($number);

        $length = strlen($number);

        if ($length !== 11 && $length !== 14) {
            return false;
        }

        if ($type !== null) {
            return $type === TaxId::CPF
                ? $this->validateCpf($number)
                : $this->validateCnpj($number);
        }

        return $length === 11
            ? $this->validateCpf($number)
            : $this->validateCnpj($number);
    }

    /**
     * Determines whether the given number is a valid CPF.
     *
     * @param  string  $number
     * @return bool
     */
    private function validateCpf(string $number): bool
    {
        $length = strlen($number);

        if ($length !== 11) {
            return false;
        }

        $invalid_values = [
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999',
        ];

        if (in_array($number, $invalid_values)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $number[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($number[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determines whether the given number is a valid CNPJ.
     *
     * @param  string  $number
     * @return bool
     */
    private function validateCnpj(string $number): bool
    {
        $cnpj = str_pad($number, 14, 0, STR_PAD_LEFT);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        $invalid_values = [
            '11111111111111',
            '22222222222222',
            '33333333333333',
            '44444444444444',
            '55555555555555',
            '66666666666666',
            '77777777777777',
            '88888888888888',
            '99999999999999',
        ];

        if (in_array($cnpj, $invalid_values)) {
            return false;
        }

        $j = 5;
        $k = 6;
        $sum_1 = 0;
        $sum_2 = 0;

        for ($i = 0; $i < 13; $i++) {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;

            $sum_2 += ($cnpj[$i] * $k);

            if ($i < 12) {
                $sum_1 += ($cnpj[$i] * $j);
            }

            $k--;
            $j--;
        }

        $first_digit = $sum_1 % 11 < 2 ? 0 : 11 - $sum_1 % 11;
        $second_digit = $sum_2 % 11 < 2 ? 0 : 11 - $sum_2 % 11;

        return (($cnpj[12] == $first_digit) and ($cnpj[13] == $second_digit));
    }

    /**
     * @param  string|null  $string
     * @return string
     */
    private static function removeNonNumericCharacters(?string $string): string
    {
        if ($string === null) {
            return '';
        }

        return preg_replace('(\D)', '', $string);
    }
}