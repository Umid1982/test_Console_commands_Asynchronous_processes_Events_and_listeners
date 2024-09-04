<?php

namespace App\Services\Payment;

class StripeProcessor implements PaymentProcessorInterface
{
public function processPayment(float $amount): bool
{
// Логика для обработки платежа через Stripe
return true;
}
}
