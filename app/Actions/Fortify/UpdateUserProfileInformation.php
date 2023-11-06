<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Squire\Models\Country;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param array<string, string> $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'country_code' => ['nullable', new In(Country::get('id')->pluck('id')->toArray())],
            'instrument_id' => ['nullable', 'exists:instruments,id'],
            'difficulty_id' => ['nullable', 'exists:gameplay_difficulties,id'],
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
                'country_code' => $input['country_code'],
                'instrument_id' => $input['instrument_id'],
                'difficulty_id' => $input['difficulty_id'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param array<string, string> $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'country_code' => $input['country_code'],
            'instrument_id' => $input['instrument_id'],
            'difficulty_id' => $input['difficulty_id'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
