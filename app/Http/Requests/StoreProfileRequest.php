<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'        => ['required'],
            'last_name'         => ['required'],
            'nationality'       => ['required'],
            'type_dni'          => ['required'],
            'dni'               => ['required'],
            'gender'            => ['required'],
            'phone'             => ['required'],
            'country_id'        => ['required'],
            'state_id'          => ['required'],
            'city_id'           => ['required'],
            'postal_code'       => ['required'],
            //'languages'         => ['required'],
            //'area_interest'     => ['required'] 
            'languages'         => ['required',  'regex:/^\[\d+(,\d+)*\]$/'],
            'area_interest'     => ['required',  'regex:/^\[\d+(,\d+)*\]$/']
        ];
    }

    public function messages() {
        return [
            'first_name.required'   => 'Debe completar el primer nombre',
            'last_name.required'    => 'Debe completar el apellido',
            'nationality.required'  => 'Debe indicar la nacionalidad',
            'type_dni.required'     => 'Seleccione tipo de identificación',
            'dni.required'          => 'Coloque su identificación',
            'gender.required'       => 'Seleccione el genero',
            'phone.required'        => 'Indique un número de télefono',
            'country_id.required'   => 'Seleccione pais',
            'state_id.required'     => 'Seleccione estado',
            'city_id.required'      => 'Seleccione una ciudad',
            'postal_code.required'  => 'Indique código postal',
            'languages.regex'           => 'Selecciona al menos un idioma',
            'area_interest.regex'     => 'Seleccione al menos un área de interés.'
        ];
    }
}
