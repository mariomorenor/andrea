<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code'=>"required|unique:products,code,$this->code,code",
            'name'=>'required',
            'price'=>'required',
            'promo'=>'required',
            'credit'=>'required',
            'cash'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'code'=>'Código',
            'name'=>'Nombre',
            'price'=>'Precio',
            'promo'=>'Promoción',
            'credit'=>'Crédito',
            'cash'=>'Efectivo',
            'description'=>'Descripción',
        ];
    }
}
