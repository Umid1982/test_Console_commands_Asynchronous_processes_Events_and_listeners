<?php
namespace App\Services\Payment;

interface PaymentProcessorInterface
{
public function processPayment(float $amount): bool;
}
