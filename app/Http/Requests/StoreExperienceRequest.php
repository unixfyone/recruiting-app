<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'position'     => ['required'],
            'company_name' => ['required'],
            'functions'    => ['required']
        ];
    }

    public function messages() {
        return [
            'position.required'     => 'Debe ingresar el cargo que ocupa(ba) en la empresa',
            'company_name.required' => 'Debe ingresar el nombre de la empresa',
            'functions.required'    => 'Debe describir las funciones que realiza(ba) en la empresa'
        ];
    }
}
