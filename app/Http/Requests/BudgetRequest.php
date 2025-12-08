<?php

namespace App\Http\Requests;

use App\Enums\ExpenseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BudgetRequest extends FormRequest
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
            'year_month' => 'required|date_format:Y-m',
            'expense_item_id'=> [
                'required',
                'exists:expense_items,id',
                Rule::unique('budgets')->where(function ($query) {
                    return $query->where('scope_id', scope_id())
                                 ->where('year', date('Y', strtotime($this->year_month)))
                                 ->where('month', date('m', strtotime($this->year_month)))
                                 ->where('deleted_at', null);
                })->ignore($this->route('budget_plan'))
            ],
            'amount' => 'required|numeric'
        ];
    }
    public function messages(): array
    {
        return [
            'year_month.required' => 'The year and month field is required.',
            'year_month.date_format' => 'The year and month does not match the format Y-m.',
            'expense_item_id.required' => 'The expense item field is required.',
            'expense_item_id.exists' => 'The selected expense item is invalid.',
            'expense_item_id.unique' => 'A budget for this expense item and month already exists.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.'
        ];
    }
}
