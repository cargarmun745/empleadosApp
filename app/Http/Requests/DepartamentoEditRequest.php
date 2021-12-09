<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function atributes()
    {
        return [
            'nombre'         =>  'nombre del departamento',
            'localizacion'  =>  'localización del departamento',
            'idempleadojefe'  =>  'jefe de departamento',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }


    public function messages() {
        $gte = 'El campo :attribute debe ser mayor o igual que :value.';
        $integer = 'El campo :attribute ha de ser un numero entero.';
        $lte = 'El campo :attribute debe ser menor o igual que :value.';
        $max = 'El campo :attribute no puede tener más de :max caracteres.';
        $min = 'El campo :attribute no puede tener menos de :min caracteres.';
        $required = 'El campo :attribute es obligatorio.';
        $numeric = 'El campo :attribute debe ser numérico.';
        return [
            'nombre.required'          => $required,
            'nombre.min'               => $min,
            'nombre.max'               => $max,
            'localizacion.required'    => $required,
            'localizacion.min'         => $min,
            'localizacion.max'         => $max,
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'nombre'           =>  'required|min:2|max:200',
                'localizacion'     =>  'required|min:2|max:200',
            ];
    }
}
