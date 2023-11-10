<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
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
            'institution' => ['required'],
            'title'       => ['required'],
            'level'       => ['required']
        ];
    }

    public function messages() {
        return [
            'institution.required' => 'Debe ingresar la institución donde realizó sus estudios',
            'title.required'       => 'Debe ingresar el título obtenido',
            'level.required'       => 'Debe seleccionar un nivel'
        ];
    }
}
