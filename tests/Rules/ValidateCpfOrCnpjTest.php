<?php

namespace Junges\CpfCnpjValidator\Tests\Rules;

use Junges\CpfCnpjValidator\Rules\ValidateCpfOrCnpj;
use Junges\CpfCnpjValidator\Tests\TestCase;

class ValidateCpfOrCnpjTest extends TestCase
{
    public function test_rule()
    {
        $this->assertFalse((new ValidateCpfOrCnpj)->passes('cpf', '0'));
        $this->assertTrue((new ValidateCpfOrCnpj)->passes('cpf', '91.881.588/0001-95'));
        $this->assertTrue((new ValidateCpfOrCnpj)->passes('cpf', '91881588000195'));
        $this->assertTrue((new ValidateCpfOrCnpj)->passes('cpf', '36092896001'));
        $this->assertFalse((new ValidateCpfOrCnpj)->passes('cpf', '11111111111111'));
    }
}