<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            // en and bn unique if scope_id is same ignore id
            'en'=>[
                'required',
                'string',
                'max:255',
                Rule::unique('categories','en')->where('scope_id','==',scope_id())->ignore($this->id),
            ],
            'bn'=>[
                'required',
                'string',
                'max:255',
                Rule::unique('categories','bn')->where('scope_id','==',scope_id())->ignore($this->id),
            ],
            'amount'=>'nullable|numeric'
            

        ];
    }
}
