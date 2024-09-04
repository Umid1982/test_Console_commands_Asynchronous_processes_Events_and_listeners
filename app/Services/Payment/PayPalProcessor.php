<?php
namespace App\Services\Payment;

class PayPalProcessor implements PaymentProcessorInterface
{
public function processPayment(float $amount): bool
{
// Логика для обработки платежа через PayPal
return true;
}
}
