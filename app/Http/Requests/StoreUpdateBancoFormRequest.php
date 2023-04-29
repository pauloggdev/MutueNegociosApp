<?php

namespace App\Http\Requests;

use App\Rules\Empresa\BancoEmpresaUnique;
use App\Rules\Empresa\EmpresaUnique;
use App\Rules\Empresa\MultEmpresaUnique;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateBancoFormRequest extends FormRequest
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
            'designacao' => ['required','min:3','max:100',new EmpresaUnique('bancos',$this->id)],
            'sigla' => ['required',new EmpresaUnique('bancos',$this->id)],
            'num_conta' => ['required',new BancoEmpresaUnique('coordenadas_bancarias', $this->id)],
            'iban' => ['required',new BancoEmpresaUnique('coordenadas_bancarias',$this->id)]
        ];
    }
}
