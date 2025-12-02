<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IncomeByRequest extends FormRequest
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
            'name'=>[
                'required',
                'string',
                'max:255',
                Rule::unique('income_bies','name')
                ->where(function($q){
                    return $q->where('scope_id',scope_id())->where('deleted_at',null);
                })
                ->ignore($this->route('income_by')),
            ]
        ];
    }
}
