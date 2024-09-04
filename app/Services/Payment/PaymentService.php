<?php

namespace App\Services\Payment;

class PaymentService
{
    private $processor;

    public function __construct(PaymentProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    public function process(float $amount): bool
    {
        return $this->processor->processPayment($amount);
    }
}
