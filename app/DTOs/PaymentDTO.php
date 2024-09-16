<?php

namespace App\DTOs;

class PaymentDTO
{
    public function __construct(public float $amount)
    {
    }
}
