<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestUser extends FormRequest
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
            'lastname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'email:rfc,dns','max:255', 'unique:users'],
            'password' => ['required','string','min:8','confirmed'],
            'address' => ['nullable', 'string', 'max:200'],
            'cfiscale' => ['nullable', 'string', 'max:16'],
            'city' => ['nullable', 'string', 'max:200'],
            'prov' => ['nullable', 'string', 'max:4'],
            'cap' => ['nullable', 'max:5'],
            'phone' => ['nullable', 'string', 'max:50'],
            'birth' => ['nullable','date','after:1930-01-01','before:2008-01-01'],
            'natoa' => ['nullable', 'string', 'max:255'],
            'role_id' => ['required','numeric'],
        ];
    }
}
