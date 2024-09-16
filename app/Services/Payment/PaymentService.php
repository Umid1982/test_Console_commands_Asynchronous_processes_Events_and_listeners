<?php

namespace App\Services\Payment;

use App\DTOs\PaymentDTO;

class PaymentService
{
    private $processor;

    public function __construct(PaymentProcessorInterface $processor)
    {
        $this->processor = $processor;
    }


    public function process(PaymentDTO $paymentDTO): bool
    {
        return $this->processor->processPayment((float)$paymentDTO);
    }
}
