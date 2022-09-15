<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitationRequest extends FormRequest
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
            'specialty_id'    => ['required', 'integer'],
            'professional_id' => ['required', 'integer'],
            'name'            => ['required', 'string'],
            'cpf'             => ['required', 'string'],
            'source_id'       => ['required', 'integer'],
            'birthdate'       => ['required'],
        ];
    }

    public function messages()
{
    return [
        'source_id.required' => 'Por favor, nos diga tambem como nos conheceu',
        'cpf.required'       => 'Digite o seu CPF',
        'name.required'      => 'Digite o seu Nome',
        'birthdate.required' => 'Digite a Data do seu Nascimento',
    ];
}
}
