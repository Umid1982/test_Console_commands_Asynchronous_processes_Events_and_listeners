<?php

namespace Tests\Feature;

use App\Services\Payment\PaymentService;
use App\Services\Payment\PayPalProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    public function testPaymentProcessingWithPayPal()
    {
        $paymentService = new PaymentService(new PayPalProcessor());
        $this->assertTrue($paymentService->process(100.00));
    }
}
