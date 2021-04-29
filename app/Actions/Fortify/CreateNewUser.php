<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use phpDocumentor\Reflection\Types\Nullable;

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
            'birth' => ['nullable','date','after:1930-01-01','before:2008-01-01'],
            'natoa' => ['nullable', 'string', 'max:255'],
            'agree' => ['accepted','boolean'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $role = Role::where('rolename',User::NORMAL)->first();
        $user =  User::create([
            'lastname' => e($input['lastname']),
            'name' => e($input['name']),
            'email' => e($input['email']),
            'cfiscale' => e($input['cfiscale']),
            'password' => Hash::make($input['password']),
            'address' => e($input['address']),
            'cap' => e($input['cap']),
            'city' => e($input['city']),
            'prov' => e($input['prov']),
            'phone' => e($input['phone']),
            'birth' => $input['birth'],
            'natoa' => e($input['natoa']),
            'agree' => $input['agree'],

        ]);
        $user->roles()->attach($role->id);
        return $user;


    }
}
