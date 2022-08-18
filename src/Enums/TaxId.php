<?php

namespace Junges\CpfCnpjValidator\Enums;

enum TaxId: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';
}