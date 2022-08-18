<?php

namespace Junges\CpfCnpjValidator\Rules;

use Illuminate\Contracts\Validation\Rule;
use Junges\CpfCnpjValidator\Validator;

class ValidateCpfOrCnpj implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (new Validator)($value);
    }

    public function message(): string
    {
        return __('The :attribute is invalid');
    }
}