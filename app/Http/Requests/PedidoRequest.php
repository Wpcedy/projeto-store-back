<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'produtos' => 'required|string',
            'status' => 'required|string|min:1|max:1',
            'cliente' => 'required|string',
        ];
    }
}