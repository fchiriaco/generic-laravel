<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'lastname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'email:rfc,dns','max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => ['nullable', 'string', 'max:200'],
            'cfiscale' => ['nullable', 'string', 'max:16'],
            'city' => ['nullable', 'string', 'max:200'],
            'prov' => ['nullable', 'string', 'max:4'],
            'cap' => ['nullable', 'max:5'],
            'phone' => ['nullable', 'string', 'max:50'],
            'birth' => ['required','date','after:1930-01-01','before:2007-01-01'],
            'natoa' => ['nullable', 'string', 'max:255'],
            'agree' => ['accepted','boolean'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $role = Role::where('rolename',User::NORMAL)->first();
        $user =  User::create([
            'lastname' => $input['lastname'],
            'name' => $input['name'],
            'email' => $input['email'],
            'cfiscale' => $input['cfiscale'],
            'password' => Hash::make($input['password']),
            'address' => $input['address'],
            'cap' => $input['cap'],
            'city' => $input['city'],
            'prov' => $input['prov'],
            'phone' => $input['phone'],
            'birth' => $input['birth'],
            'natoa' => $input['natoa'],
            'agree' => $input['agree'],

        ]);
        $user->roles()->attach($role->id);
        return $user;


    }
}
