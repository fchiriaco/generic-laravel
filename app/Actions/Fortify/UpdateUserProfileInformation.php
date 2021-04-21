<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'email:rfc,dns','max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'address' => ['nullable', 'string', 'max:200'],
            'cfiscale' => ['nullable', 'string', 'max:16'],
            'city' => ['nullable', 'string', 'max:200'],
            'prov' => ['nullable', 'string', 'max:4'],
            'cap' => ['nullable', 'max:5'],
            'phone' => ['nullable', 'string', 'max:50'],
            'birth' => ['required','date','after:1930-01-01','before:2007-01-01'],
            'natoa' => ['nullable', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'cfiscale' => $input['cfiscale'],
                'address' => $input['address'],
                'cap' => $input['cap'],
                'city' => $input['city'],
                'prov' => $input['prov'],
                'phone' => $input['phone'],
                'birth' => $input['birth'],
                'natoa' => $input['natoa'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
