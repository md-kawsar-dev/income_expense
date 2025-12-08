<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'expense_item_id' => 'required|exists:expense_items,id',
        ];
    }
    public function messages()
    {
        return [
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.',
            'date.date' => 'The date is not a valid date.',
            'description.string' => 'The description must be a string.',
            'expense_item_id.required' => 'The expense item field is required.',
            'expense_item_id.exists' => 'The selected expense item is invalid.',
        ];
    }
}
