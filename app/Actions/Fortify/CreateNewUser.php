<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
            'alamat' => ['nullable', 'string'],
        ])->validate();

        return User::create([
            'nama_lengkap' => $input['nama_lengkap'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'username' => $input['username'],
            'alamat' => $input['alamat'],
            'level' => 'pengguna',
        ]);
    }
}
