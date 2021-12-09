<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function atributes()
    {
        return [
            'nombre'         =>  'nombre del empleado',
            'apellidos'      =>  'apellidos del empleado',
            'email'          =>   'email del empleado',
            'telefono'       =>  'telefono del empleado',
            'fechacontrato'  =>  'fechacontrato del empleado',
            'idpuesto'       =>  'puesto asociado del empleado',
            'iddepartamento' =>  'departamento asociado del empleado',
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
        $unique = 'El campo :attribute debe ser único en la tabla de empleados.';
        $email = 'El campo :attribute no es un email válido.';
        return [
            'nombre.required'           => $required,
            'nombre.min'                => $min,
            'nombre.max'                => $max,
            'apellidos.required'        => $required,
            'apellidos.min'             => $min,
            'apellidos.max'             => $max,
            'email.required'            => $required,
            'email.min'                 => $min,
            'email.max'                 => $max,
            'email.email'               => $email,
            'telefono.required'         => $required,
            'telefono.min'              => $min,
            'telefono.max'              => $max,
            'telefono.unique'           => $unique,
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
                'nombre'            =>  'required|min:2|max:200',
                'apellidos'         =>  'required|min:2|max:200',
                'email'             =>  'required|min:2|max:200|email',
                'telefono'          =>  'required|min:9|max:12|unique:empleado,telefono,' . $this->empleado->id,
                'fechacontrato'     =>  'required|min:2|max:200',
            ];
    }
}
