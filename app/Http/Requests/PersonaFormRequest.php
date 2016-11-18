<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
            'nombre'=>'required|max:100',
            'tipo_documento'=>'max:20',
            'num_documento'=>'max:15',
            'direccion'=>'max:70',
            'telefono'=>'max:15',
            'email'=>'max:50',
            'edad',
            'curp'=>'max:45',
            'fecha_nacimiento',
            'aval'=>'max:100',
            'codigo_empleado'=>'max:45',
            'limite_cuenta'=>'min:0'
        ];
    }
}
