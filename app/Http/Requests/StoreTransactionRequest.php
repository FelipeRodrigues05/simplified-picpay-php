<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'sender_id' => [
                'numeric',
                'required'
            ],
            'receiver_id' => [
                'numeric',
                'required'
            ],
            'amount' => [
                'numeric',
                'required'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'amount' => 'Amount'
        ];
    }

    public function messages(): array
    {
        return [
            'sender_id' => [
                'numeric' => 'Sender ID must be a number',
                'required' => 'Sender ID is required'
            ],
            'receiver_id' => [
                'numeric' => 'Receiver ID must be a number',
                'required' => 'Receiver ID is required'
            ],
            'amount' => [
                'numeric' => 'Amount must be a number',
                'required' => 'Amount is required'
            ]
        ];
    }
}
