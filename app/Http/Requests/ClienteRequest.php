<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nome' => 'required|string|min:3',
            'email' => 'required|string',
            'telefone' => 'required|string|min:10|max:11',
            'cpf' => 'required|string|min:11|max:11',
            'endereco' => 'required|string',
        ];
    }
}
