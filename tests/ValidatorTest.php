<?php

namespace Junges\CpfCnpjValidator\Tests;

use Junges\CpfCnpjValidator\Enums\TaxId;
use Junges\CpfCnpjValidator\Validator;

class ValidatorTest extends TestCase
{
    /** @dataProvider cpf */
    public function test_it_can_validate_a_document_number($number, $expects, $type = null)
    {
        $this->assertEquals($expects, (new Validator)($number, $type));
    }

    public function cpf(): array
    {
        return [
            [
                'number' => "360.928.960-01",
                'expects' => true,
                'type' => null
            ],
            [
                'number' => "360.928.960-01",
                'expects' => false,
                'type' => TaxId::CNPJ
            ],
            [
                'number' => '36092896001',
                'expects' => true,
                'type' => null
            ],
            [
                'number' => '00000000000',
                'expects' => false,
                'type' => null
            ],
            [
                'number' => '91.881.588/0001-95',
                'expects' => true,
                'type' => null
            ],
            [
                'number' => '91.881.588/0001-95',
                'expects' => false,
                'type' => TaxId::CPF
            ],
            [
                'number' => '91881588000195',
                'expects' => true,
                'type' => null
            ],
            [
                'number' => '11111111111111',
                'expects' => false,
                'type' => null
            ],
            [
                'number' => 1,
                'expects' => false,
                'type' => null
            ],
        ];
    }
}