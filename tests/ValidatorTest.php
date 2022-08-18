<?php

namespace Junges\CpfCnpjValidator\Tests;

use Junges\CpfCnpjValidator\Validator;

class ValidatorTest extends TestCase
{
    /** @dataProvider cpf */
    public function test_it_can_validate_a_cpf_number($number, $expects)
    {
        $this->assertEquals($expects, (new Validator)($number));
    }

    public function cpf(): array
    {
        return [
            [
                'number' => "360.928.960-01",
                'expects' => true
            ],
            [
                'number' => '36092896001',
                'expects' => true,
            ],
            [
                'number' => '00000000000',
                'expects' => false
            ]
        ];
    }
}