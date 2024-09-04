<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected readonly PaymentService $paymentService)
    {
    }

    public function processPayment(Request $request)
    {
        $amount = $request->input('amount');

        if ($this->paymentService->process($amount)) {
            return response()->json(['message' => 'Payment processed successfully']);
        }

        return response()->json(['message' => 'Payment failed'], 500);
    }
}
