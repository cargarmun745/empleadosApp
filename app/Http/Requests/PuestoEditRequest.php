<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PuestoEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function atributes()
    {
        return [
            'nombre'         =>  'nombre del puesto',
            'salarioMaximo'  =>  'salario máximo del puesto',
            'salarioMinimo'  =>  'salario minimo del puesto',
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
        $lte = 'El campo :attribute debe ser menor o igual que :value.';
        $max = 'El campo :attribute no puede tener más de :max caracteres.';
        $min = 'El campo :attribute no puede tener menos de :min caracteres.';
        $required = 'El campo :attribute es obligatorio.';
        $numeric = 'El campo :attribute debe ser numérico.';
        return [
            'nombre.required'          => $required,
            'nombre.min'               => $min,
            'nombre.max'               => $max,
            'salarioMaximo.required'   => $required,
            'salarioMaximo.gte'        => $gte,
            'salarioMaximo.lte'        => $lte,
            'salarioMaximo.numeric'    => $numeric,
            'salarioMinimo.required'   => $required,
            'salarioMinimo.gte'        => $gte,
            'salarioMinimo.lte'        => $lte,
            'salarioMinimo.numeric'    => $numeric,
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
                'salarioMaximo'    =>  'required|gte:0.01|lte:9999999.99|numeric',
                'salarioMinimo'    =>  'required|gte:965|lte:9999999.99|numeric',
            ];
    }
}
