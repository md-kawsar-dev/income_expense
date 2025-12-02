<?php

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Models\Category;
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
    //    if($this->route('category')){
    //     return $this->user()->can('update',$this->route('category'));
    //    } else {
    //     return $this->user()->can('create', Category::class);
    //    }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_type' => [
                'required',
                'string',
                'max:255',
                // enum values
                Rule::enum(CategoryEnum::class),
            ],
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')
                    ->where('scope_id', scope_id())
                    ->where('category_type', $this->input('category_type'))
                    ->ignore($this->route('category')),
            ],

            'amount' => 'nullable|numeric'


        ];
    }
    public function messages(): array
    {
        return [
            'category_name.unique' => 'The category name has already been taken for this category type.',
            'category_type.enum' => 'The selected category type is invalid. Allowed types are: ' . implode(', ', CategoryEnum::values()),
        ];
    }
}
