<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemporalVentaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idarticulo'=>'required',
            'codigo'=>'required|max:50',
            'nombre'=>'max:100',
            'stock'=>'required'
        ];
    }
}
