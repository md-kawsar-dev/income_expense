<?php

namespace App\Http\Requests;

use App\Enums\ExpenseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expense_type' => [
                'required',
                'string',
                'max:255',
                // enum values
                Rule::enum(ExpenseTypeEnum::class),
            ],
            'expense_item' => [
                'required',
                'string',
                'max:255',
                Rule::unique('expense_items', 'expense_item')
                    ->where(function ($q) {
                        return $q->where('scope_id', scope_id())
                            ->where('expense_type', $this->input('expense_type'))
                            ->where('deleted_at', null);
                    })
                    ->ignore($this->route('expense_items')),
            ],

            'amount' => 'nullable|numeric'


        ];
    }
    public function messages(): array
    {
        return [
            'expense_item.unique' => 'The expense item has already been taken for this expense type.',
            'expense_type.enum' => 'The selected expense type is invalid. Allowed types are: ' . implode(', ', ExpenseTypeEnum::values()),
        ];
    }
}
