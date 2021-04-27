<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestUser extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'email:rfc,dns','max:255', Rule::unique('users')->ignore($this->user->id, 'id')],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'address' => ['nullable', 'string', 'max:200'],
            'cfiscale' => ['nullable', 'string', 'max:16'],
            'city' => ['nullable', 'string', 'max:200'],
            'prov' => ['nullable', 'string', 'max:4'],
            'cap' => ['nullable', 'max:5'],
            'phone' => ['nullable', 'string', 'max:50'],
            'birth' => ['nullable','date','after:1930-01-01','before:2008-01-01'],
            'natoa' => ['nullable', 'string', 'max:255'],
            'password' => ['present','nullable','string','min:8','confirmed'],
        ];
    }
}
