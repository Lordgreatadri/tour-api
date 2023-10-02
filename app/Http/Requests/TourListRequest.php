<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TourListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priceFrom'=>'numeric',
            'priceTo'  =>'numeric',
            'dateFrom' =>'date',
            'dateTo'   =>'date',
            'sortBy'     => Rule::in('price'),
            'sortOrderBy'=>Rule::in('desc', 'asc'),
        ];
    }


    public function messages(){
        return [
            "sortBy"      => "The sortBy parameter accepts only price",
            "sortOrderBy" => "The sortOrderBy parameter value accepts only desc or asc",
        ];
    }
}
