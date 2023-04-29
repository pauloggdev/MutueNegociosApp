<?php

namespace App\Http\Requests;

use App\Rules\Empresa\EmpresaUnique;
use App\Rules\Empresa\MultEmpresaUnique;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserFormRequest extends FormRequest
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
            'name' => ['required','min:3','string','max:255'],
            'username' => ['required', 'string'],
            'telefone' => ['required',new EmpresaUnique('users',$this->id)],
            'email' => ['min:3','max:255',new EmpresaUnique('users',$this->id)],
        ];
    }
}
