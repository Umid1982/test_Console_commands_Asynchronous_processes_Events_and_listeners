<?php

namespace App\Http\Requests\Payment;

use App\DTOs\PaymentDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProcessPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
        ];
    }

    public function toDTO(): PaymentDTO
    {
        return new PaymentDTO(
            $this->get('amount')
        );
    }
}
